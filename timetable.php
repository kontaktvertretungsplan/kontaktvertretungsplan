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

Webhook für einen Cronjob, der den Stundenplan aktualisiert
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


// Konfigurationen, Einstellungen und Datenbank einbinden
$CONFIG = getConfigCache();

$PDO = newPDO();

require('lib/settings.php');
$SETTINGS = getSettingCache();

// FUNKTION: Speichere den neuen Plan in der Datenbank
function update($json, $hash, $date) {
	global $PDO;
	$statement = $PDO->prepare("INSERT INTO timetable (date, hash, plan, time) VALUES (?, ?, ?, ?)");
	$statement->execute([$date['year'].$date['month'].$date['day'], $hash, $json, time()]);
	
	
}



// Ist der KEY gültig?
if($_GET['key'] == $SETTINGS['k-v:webhook:timetable']) {
	
	// Bekomme die aktuelle Zeit
	$current_time = time();
	
	// Bekommen das Datum für eine nächsten möglichen Schultag
	$date = getNextTimetableDate();
	
	// Ersetze die entsprechenden Datumsparameter in der API URL
	$search =  ['%y',          '%m',           '%d'];
	$replace = [$date['year'], $date['month'], $date['day']];
	
	// Lade den Stundenplan und wandle ihn in JSON um
	$json = json_decode(file_get_contents(str_replace($search, $replace, $SETTINGS['k-v:api:timetable'])), true);
	
	// Ist die Rückmeldung Fehlerfrei
	if($json['ok'] == true) {
		
		// Ist der Stundenplan fehlerfrei
		if($json['result']['status'] == 'ok') {
			
			// Bereite Stundenplandaten vor
			// generiere MD5 Hash
			$json_save_dump = json_encode($json['result']);
			$json_save_dump_hash = md5($json_save_dump);
			$plan = $json['result'];
			
			// Lade alle Stundenpläne vom vorher gewählten Tag
			$statement = $PDO->prepare("SELECT ID FROM timetable WHERE date = ?");
			$statement->execute([$date['year'].$date['month'].$date['day']]);
			// Sind keine Pläne vorhanden?
			if($statement->rowCount() == 0) {
				// Speichern
				update($json_save_dump, $json_save_dump_hash, $date);
				
				// Alle Nutzer benachrichtigen
				$statement = $PDO->prepare("SELECT * FROM user WHERE NOT mute LIKE ?");
				$statement->execute(['%"update"%']); // Alle ausnehmen, die die Nachricht stummgeschaltet haben
				$result = $statement->fetchAll();
				foreach($result as $row) {
					
					// Benutzerdaten laden
					$USER_INFO = [
						'id' => $row['ID'],
						'name' => $row['name'],
						'telegram-id' => $row['telegram'],
						'mute' => json_decode($row['mute'], true),
						'role' =>json_decode( $row['role'], true),
					];
					
					// Benachrichtigen
					sendMessage($USER_INFO['telegram-id'], '_[Automatisch]_
*Stundenplan*
Der neue Stundenplan für den '.$date['day'].'.'.$date['month'].'.'.$date['year'].' wurde veröffentlicht!

'. buildTimetable(getPersonalTimetable($plan['plan'], getChoosedClass())).'

'.buildNote($plan['note']),
[[["text" => "Stundenplan", "callback_data" => "/stundenplan"]], [["text" => "Haupmenü", "callback_data" => "/menu"]]]);
				}
			}
			// Falls schon andere Pläne vorhaden sind
			else {
				// Lade die Speicherzeit den neusten Stundenplanes vom gewählten Tag
				$statement = $PDO->prepare("SELECT MAX(time) FROM timetable WHERE date = ?");
				$statement->execute([$date['year'].$date['month'].$date['day']]);
				$result = $statement->fetch();
				
				// Prüfe anhand des Hashes, ob sich Plan geändert hat
				$statement = $PDO->prepare("SELECT hash FROM timetable WHERE date = ? AND time = ?");
				$statement->execute([$date['year'].$date['month'].$date['day'], $result['MAX(time)']]);
				$result2 = $statement->fetch();
				if($result2['hash'] != $json_save_dump_hash) {
					
					// Aktualisiere
					update($json_save_dump, $json_save_dump_hash, $date);
					
					// Benachrichtige
					$statement = $PDO->prepare("SELECT * FROM user WHERE NOT mute LIKE ?");
					$statement->execute(['%"update"%']);
					foreach($statement->fetchAll() as $row) {
				
						$USER_INFO = [
							'id' => $row['ID'],
							'name' => $row['name'],
							'telegram-id' => $row['telegram'],
							'mute' => json_decode($row['mute'], true),
							'role' =>json_decode( $row['role'], true),
						];
					
						sendMessage($USER_INFO['telegram-id'], '_[Automatisch]_
*Stundenplan*
Der Stundenplan für den '.$date['day'].'.'.$date['month'].'.'.$date['year'].' hat sich geändert.
	
'. buildTimetable(getPersonalTimetable($plan['plan'], getChoosedClass())).'

'.buildNote($plan['note']),
[[["text" => "Haupmenü", "callback_data" => "/menu"]]]);
					}
				}
			}
		}
	}
}

?>