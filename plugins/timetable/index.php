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

PLUGIN
*/

if(isset($command[1])) {
	$statement = $PDO->prepare("SELECT ID FROM class WHERE name = ?");
	$statement->execute([$command[1]]);
	if($statement->rowCount() != 0) {
		$choosed_class = [$command[1] => true];
	}
	else {
		sendMessage($message['from']['id'], '*Stundenplan*
Diese Klasse konnte nicht gefunden werden.', [[["text" => "Stundenplan", "callback_data" => "/stundenplan"]], [["text" => "Haupmenü", "callback_data" => "/menu"]]]);
		exit();
	}
}
else {
	$choosed_class = getChoosedClass();
}

$guessed_date = getNextTimetableDate();
$wanted_date = $guessed_date['year'].$guessed_date['month'].$guessed_date['day'];

$statement = $PDO->prepare("SELECT ID FROM timetable WHERE date = ?");
$statement->execute([$wanted_date]);
if($statement->rowCount() != 0) {

	$statement = $PDO->prepare("SELECT MAX(time) FROM timetable WHERE date = ?");
	$statement->execute([$wanted_date]);
	$result = $statement->fetch();
	
	$statement = $PDO->prepare("SELECT plan FROM timetable WHERE date = ? AND time = ?");
	$statement->execute([$wanted_date, $result['MAX(time)']]);
	$result2 = $statement->fetch();
	$plan = json_decode($result2['plan'], true);
	
	if(count($choosed_class) != 0) {
		$personal_plan = getPersonalTimetable($plan['plan'], $choosed_class);
		if(count($personal_plan) != 0) {
			sendMessage($message['from']['id'], '*Stundenplan*
vom '.$plan['date']['day'].'.'.$plan['date']['month'].'.'.$plan['date']['year'].'

'.buildTimetable($personal_plan).'

'.buildNote($plan['note']), [[["text" => "Stundenplan", "callback_data" => "/stundenplan"]], [["text" => "Haupmenü", "callback_data" => "/menu"]]]);
		}
		else {
			sendMessage($message['from']['id'], '*Stundenplan*
vom '.$plan['date']['day'].'.'.$plan['date']['month'].'.'.$plan['date']['year'].'

Du hast heute keinen Unterricht.

'.buildNote($plan['note']), [[["text" => "Stundenplan", "callback_data" => "/stundenplan"]], [["text" => "Haupmenü", "callback_data" => "/menu"]]]);
		}
	}
	else {
		sendMessage($message['from']['id'], '*Stundenplan*
vom '.$plan['date']['day'].'.'.$plan['date']['month'].'.'.$plan['date']['year'].'

Du hast keine Klasse ausgewählt. Bitte wähle erst eine.

'.buildNote($plan['note']),
[[["text" => "Einstellungen", "callback_data" => "/settings"]], [["text" => "Haupmenü", "callback_data" => "/menu"]]]);
	}
}
else {
	sendMessage($message['from']['id'], '*Stundenplan*
Kein Stundenplan verfügbar.', [[["text" => "Stundenplan", "callback_data" => "/stundenplan"]], [["text" => "Haupmenü", "callback_data" => "/menu"]]]);
}

?>