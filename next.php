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

Webhook für einen Cronjob
Benachrichtigt bei aufrufen alle Benutzer, welches Fach sie gleich haben
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
require('lib/getNextTimetableDate.php');

// Konfigurationen, Einstellungen und Datenbank einbinden
$CONFIG = getConfigCache();

$PDO = newPDO();

require('lib/settings.php');
$SETTINGS = getSettingCache();

// Laden des GET Parameters für die zu sendende Stunde
// Prüfen, ob eine Zahl
$lesson_ok = true;
foreach(explode(',', $_GET['lesson']) as $l) {
	$l += 0;
	if(is_int($l)) {
		$lesson[] = $l;
	}
	else {
		$lesson_ok = false;
	}
}

// Ist der KEY korrekt und Stunde korrekt
if($_GET['key'] == $SETTINGS['k-v:webhook:next'] && $lesson_ok) {
	
	// Laden des Datums des aktuellen Tages
	$guessed_date = getNextTimetableDate(true);
	$wanted_date = $guessed_date['year'].$guessed_date['month'].$guessed_date['day'];
	
	// Sind Stundenpläne für den gewählten Tag vorhanden?
	$statement = $PDO->prepare("SELECT ID FROM timetable WHERE date = ?");
	$statement->execute([$wanted_date]);
	// ja
	if($statement->rowCount() != 0) {
	
		// Lade den neuestehn Stundenplan
		$statement = $PDO->prepare("SELECT MAX(time) FROM timetable WHERE date = ?");
		$statement->execute([$wanted_date]);
		$result = $statement->fetch();
		
		$statement = $PDO->prepare("SELECT plan FROM timetable WHERE date = ? AND time = ?");
		$statement->execute([$wanted_date, $result['MAX(time)']]);
		$result2 = $statement->fetch();
		$plan = json_decode($result2['plan'], true);
		
		// Bereite den zu sendenden Stundenplan vor
		
		// Lade die gewählten Stunden
		foreach($lesson as $l) {
			$plan_lesson[$l] = $plan['plan'][$l];
		}
		
		// Sende allen Nutzern ihren Plan
		$statement = $PDO->prepare("SELECT * FROM user WHERE NOT mute LIKE ?");
		$statement->execute(['%"next"%']);
		foreach($statement->fetchAll() as $user) {
			
			$USER_INFO = [
				'id' => $user['ID'],
				'name' => $user['name'],
				'telegram-id' => $user['telegram'],
				'mute' => json_decode($user['mute'], true),
				'role' =>json_decode( $user['role'], true),
			];
			
			$choosed_class = getChoosedClass();
			
			$personal_timetable = getPersonalTimetable($plan_lesson, $choosed_class);
			
			if($personal_timetable != []) {
				sendMessage($user['telegram'], '*Nächste Stunde*
Du hast gleich:

'. buildTimetable($personal_timetable),
[[["text" => "Stundenplan", "callback_data" => "/stundenplan"]], [["text" => "Haupmenü", "callback_data" => "/menu"]]]);
			}
		}
	}
}

?>