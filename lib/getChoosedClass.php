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

Gibt die gewählten Klassen und Kurse des aktuellen Benutzers zurück
*/

function getChoosedClass() {
	global $PDO, $USER_INFO;
	$statement = $PDO->prepare("SELECT value FROM subscription WHERE user = ? AND typ = ?");
	$statement->execute([$USER_INFO['id'], "class"]);
	foreach($statement->fetchAll() as $subscription_class) {
		$statement = $PDO->prepare("SELECT name FROM class WHERE ID = ?");
		$statement->execute([$subscription_class['value']]);
		$class_name = $statement->fetch();
		$class_name = $class_name['name'];
		
		
		$statement = $PDO->prepare("SELECT ID, name FROM course WHERE class = ?");
		$statement->execute([$subscription_class['value']]);
		foreach($statement->fetchAll() as $course) {
			$statement = $PDO->prepare("SELECT ID FROM subscription WHERE user = ? AND typ = ? AND value = ?");
			$statement->execute([$USER_INFO['id'], "course", $course['ID']]);
			if($statement->rowCount() == 1) {
				$choosed_class[$class_name][$course['name']] = 'yes';
			}
			else {
				$choosed_class[$class_name][$course['name']] = 'no';
			}
		}
		
		if(!isset($choosed_class[$class_name])) {
			$choosed_class[$class_name] = true;
		}
	}
	
	return $choosed_class;
}