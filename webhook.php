<?php
/*
*==============================================================*
* |\      /| | |     /---- |    | | |\   | /----\ |---- |      *
* | \    / | | |     |     |    | | | \  | |      |     |      *
* |  \  /  | | |     |     |----| | |  \ | \----\ |---- |      *
* |   \/   | | |     |     |    | | |   \|      | |     |      *
* |        | | |---- \---- |    | | |    | \----/ |---- |----- *
*==============================================================*
*        Written by Clemens Riese (c)milchinsel.de 2018        *
*==============================================================*

Kontakt:Vertretungsplan Telegram Bot

Webhook für Telegram
Hier werden alle Nachrichten entgegen genommen und verarbeitet
*/

// Schauen, ob die Verbindung verschlüsselt ist
require('lib/isHttps.php');
if(!isHttps()) {
	die("Only HTTPS connections are allowed");
}

// Funktionen laden
require('lib/updateConfigCache.php');
	require('lib/getConfig.php');
	require('lib/saveConfig.php');
	require('lib/exportConfig.php');
require('lib/updatePluginCache.php');
require('lib/updateCommandCache.php');

require('lib/getConfigCache.php');
require('lib/getPluginCache.php');
require('lib/getCommandCache.php');

require('lib/newPDO.php');

require('lib/telegramSend.php');
require('lib/getPersonalTimetable.php');
require('lib/getChoosedClass.php');
require('lib/timetablesAreDifferent.php');
require('lib/buildTimetable.php');
require('lib/buildNote.php');
require('lib/getNextTimetableDate.php');

require('lib/logIt.php');


// Konfigurationen, Einstellungen und Datenbank einbinden
$CONFIG = getConfigCache();
$PLUGINS = getPluginCache();
$COMMANDS = getCommandCache();

$PDO = newPDO();

require('lib/settings.php');
$SETTINGS = getSettingCache();


/// START
// Ist der Webhook Schlüssel OK
if($_GET['key'] == $SETTINGS['webhook']) {
	// Laden die Nachricht
	$update = file_get_contents('php://input');
	$update = json_decode($update, true);
	
	// Kommt die Nachricht von einem Inline Button?
	// Diese werden umgewandelt, dass sie zukünftig wie normale Nachrichten behandelt werden
	if(isset($update['callback_query'])) {
		$update = $update['callback_query'];
		$update['message']['text'] = $update['data'];
		answerCallbackQuery($update['id']);
	}
	
	// Ist diese Nachricht eine Textnachricht?
	// Bilder etc. werden ignoriert und per Fehlermeldung quitiert
	if(isset($update['message']['text'])) {
		
		// Lade alle wichtigen Informationen in ein neues Array
		$message = [
			'text' => $update['message']['text'],
			'command' => explode(' ', strtolower(trim($update['message']['text']))),
			'from' => [
				'id' => $update['message']['chat']['id'],
				'name' => $update['message']['chat']['first_name'].' '.$update['message']['chat']['last_name'],
			],
		];
		
		// Befehlen werden gesondert behandelt
		$command = $message['command'];
		
		
		
		// Ist der Benutzer registriert?
		// Ist wichtig für die Zustellung von Inhalten
		$statement = $PDO->prepare("SELECT * FROM user WHERE telegram = ?");
		$statement->execute([$message['from']['id']]);
		$detected_users = $statement->rowCount();
		if($detected_users == 1) {
			
			// Lade die Benutzerdaten
			$result = $statement->fetch();
			$USER_INFO = [
				'id' => $result['ID'],
				'name' => $result['name'],
				'telegram-id' => $result['telegram'],
				'mute' => $result['mute'],
				'role' => json_decode($result['role'], true),
			];
			
			
			// Ist die eingegangene Nachricht ein Befehl?
			// Befehle beginnen mit '/'
			if($command[0][0] == '/') {
				
				// Top Level Commands sind alle Zeichenketten vom '/' bis zum ersten Leerzeichen
				$tl_command = substr($command[0],1);
				
				// Start Parameter sind mittels Leerzeichen angehängt an den '/start' Befehl und können der Telegram Bot URL beigefügt werden 
				$start_command = explode('-', $command[1]);
				
				// Ist der Befehl '/start' und enthält Parameter
				if($tl_command == 'start' && isset($COMMANDS['start'][$start_command[0]])) {
					$command[1] = $start_command[1];
					// Passendes Modul laden
					require('plugins/'.$COMMANDS['start'][$start_command[0]].'/index.php');
				}
				// Andere Befehle
				elseif(isset($COMMANDS['command'][$tl_command])) {
					// Passendes Modul laden
					require('plugins/'.$COMMANDS['command'][$tl_command].'/index.php');
				}
				// Ungültige Befehle
				else {
					// ERROR
					sendMessage($message['from']['id'], '*ERROR*
Dieser Befehl ist unbekannt.',
[[["text" => "Haupmenü", "callback_data" => "/menu"]]]);
				}
			}
			
			// Shortcuts beginnen mit '[' gefolgt von eine beliebigen Zeichenkette und enden mit ']'
			// Mit diesen kann man Befehle abkürzen
			// Ursprünglich genutzt von Custom Keyborads
			// In Kontakt:Vertretungsplan aktuell nichtmehr verwendet 
			elseif($command[0][0] == '[') {
				if($command[0][strlen($command[0])-1] == ']') {
					$shortcut = substr($command[0],1,strlen($command[0])-2);
					// Is command available?
					if(isset($COMMANDS['shortcut'][$shortcut])) {
						// Load command Plugin
						require('plugins/'.$COMMANDS['command'][$COMMANDS['shortcut'][$shortcut]].'/index.php');
					}
					else {
						// ERROR
						sendMessage($message['from']['id'], '*ERROR*
Dieser Shortcut ist unbekannt.',
[[["text" => "Haupmenü", "callback_data" => "/menu"]]]);
					}
				}
				else {
					// ERROR
					sendMessage($message['from']['id'], '*ERROR*
Dieser Shortcut ist fehlerhaft.',
[[["text" => "Haupmenü", "callback_data" => "/menu"]]]);
				}
			}
			
			
			// Aliase sind normale Wörter
			// Mit diesen kann man Befehle abkürzen
			// Ursprünglich genutzt von Custom Keyborads
			// In Kontakt:Vertretungsplan aktuell nicht mehr aktiv verwendet
			// Sind teilweise noch von nutzen bei manueller Texteingabe
			elseif(isset($COMMANDS['alias'][strtolower($command[0])])) {
				// Load command Plugin
				require('plugins/'.$COMMANDS['alias'][strtolower($command[0])].'/index.php');
			}
			// Alles andere
			else {
				// ERROR
				sendMessage($message['from']['id'], '*ERROR*
Keine Antwort auf deine Nachricht möglich.',
[[["text" => "Haupmenü", "callback_data" => "/menu"]]]);
			}
			
			// Aktualisiere den Namen des Nutzers in der Datenbank
			// Für Administration hilfreicht
			// Kann auskommentiert werden
			$statement = $PDO->prepare("UPDATE user SET name = ? WHERE ID = ?");
			$statement->execute([$update['message']['chat']['first_name'].' '.$update['message']['chat']['last_name'], $USER_INFO['id']]);
		}
		
		// Falls der Nutzer nicht registriert ist
		else {
			// Durch einen möglichen Datenbankfehler sind mehrere Nutzer registriert?
			if($detected_users > 1) {
				// Alle Optionen Löschen --> Abmelden
				$statement = $PDO->prepare("DELETE FROM user WHERE telegram = ?");
				$statement->execute();
				
				// Benutzer benachrichtigen
				sendMessage($message['from']['id'], '*ERROR*
Bei deinem Benutzerprofil trat ein fehler auf. Deine Daten wurde zurückgesetzt.
Bitte melde dich neu an.',
[[["text" => "Neu anmelden", "callback_data" => "/start"]]]);
			}
			
			// Beim ersten Neustart des Bots Willkommensnachricht senden
			if($command[0] == '/start') {
				// Welcome message
				sendMessage($message['from']['id'], '*Kontakt:Vertretungsplan*
Hallo '.$message['from']['name'].',
Willkommen bei Kontakt:Vertretungsplan! Deinen Vertretungsplan kannst du ab sofort jeden Tag automatisch per PUSH-Benachrichtigung auf deinem Gerät empfangen.

https://kontakt-vertretungsplan.de Clemens Riese');
			}
			
			// Falls ein Passwort gesetzt ist
			if($SETTINGS['password'] != "") {
				
				// Ist die Nachricht das Passwort? ODER Wenn Startbefehl und korrekter Passkey, der nicht leer ist
				// Der Passkey dient dazu einen automatischen Login per z.B. QR-Code zu ermöglichen, dieser wird einfach als Startparameter an die Bot URL angehängt 
				if($message['text'] == $SETTINGS['password'] || ($command[0].' '.$command[1] == '/start '.$SETTINGS['passkey'] && $SETTINGS['passkey'] != '')) {
					$statement = $PDO->prepare("INSERT INTO user (telegram) VALUES (?)");
					$statement->execute([$message['from']['id']]);
					sendMessage($message['from']['id'], '*Angemeldet*
Du bist nun angemeldet.
Vergiss nicht in den Einstellungen deine Klasse auszuwählen.',
[[["text" => "Stundenplan", "callback_data" => "/stundenplan"]], [["text" => "Einstellungen", "callback_data" => "/settings"]], [["text" => "Haupmenü", "callback_data" => "/menu"]]]);
					
					// Benachrichtige alle Administratoren über neue Nachrichten
					$statement = $PDO->prepare("SELECT telegram FROM user WHERE role LIKE ?");
					$statement->execute(['%"admin"%']);
					foreach($statement->fetchAll() as $row) {
						sendMessage($row['telegram'], '_[Automatisch]_
*Angemeldet*
Neuer Benutzer: '.$message['from']['name'].'',
[[["text" => "Haupmenü", "callback_data" => "/menu"]]]);
					}
				}
				
				// Wenn das Passwort falsch ist, Benachrichtigen
				else {
					sendMessage($message['from']['id'], '*Passwort nötig*
Um Kontakt:Vertretungsplan nutzen zu können, wird ein Passwort benötigt.
Bitte sende das Passwort als einfache Nachricht.');
				}
			}
			// Automatische Registrierung, wenn kein Passwort gesetzt
			else {
				$statement = $PDO->prepare("INSERT INTO user (telegram) VALUES (?)");
				$statement->execute([$message['from']['id']]);
				sendMessage($message['from']['id'], '*Angemeldet*
Du bist nun angemeldet.
Vergiss nicht in den Einstellungen deine Klasse auszuwählen.',
[[["text" => "Stundenplan", "callback_data" => "/stundenplan"]], [["text" => "Einstellungen", "callback_data" => "/settings"]], [["text" => "Haupmenü", "callback_data" => "/menu"]]]);
				
				$statement = $PDO->prepare("SELECT telegram FROM user WHERE role LIKE ?");
				$statement->execute(['%"admin"%']);
				foreach($statement->fetchAll() as $row) {
					sendMessage($row['telegram'], '_[Automatisch]_
*Angemeldet*
Neuer Benutzer: '.$message['from']['name'].'',
[[["text" => "Haupmenü", "callback_data" => "/menu"]]]);
				}
			}
		}
	}
	// Bei nichtunterstützten Nachrichtentypen
	else {
		// ERROR
		sendMessage($message['from']['id'], '*ERROR*
Dieser Nachrichtentyp wird nicht unterstützt.');
	}
}
?>