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

Webhook für einen Cronjob, der die Klassenliste aktualisiert
*/

require('lib/isHttps.php');

if(!isHttps()) {
	die("Only HTTPS connections are allowed");
}

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

$CONFIG = getConfigCache();

$PDO = newPDO();

require('lib/settings.php');
$SETTINGS = getSettingCache();



if($_GET['key'] == $SETTINGS['k-v:webhook:class']) {
	
	$json = json_decode(file_get_contents($SETTINGS['k-v:api:classes']), true);
	
	if($json['ok'] == true) {
		if($json['result']['status'] == 'ok') {
			
			$changed_something = false;
			
			foreach($json['result']['classes'] as $class) {
				
				$statement = $PDO->prepare("SELECT ID FROM class WHERE name = ?");
				$statement->execute([$class['name']]);
				if($statement->rowCount() != 1) {
					// Delete all classes with the current name for the case there are doubles
					$statement = $PDO->prepare("DELETE FROM class WHERE name = ?");
					$statement->execute([$class['name']]);
					
					// Insert new
					$statement = $PDO->prepare("INSERT INTO class (name) VALUE (?)");
					$statement->execute([$class['name']]);
					
					$changed_something = true;
				}
				
				if($class['courses'] != []) {
				
					// Get ID of the current class item					
					$statement = $PDO->prepare("SELECT ID FROM class WHERE name = ?");
					$statement->execute([$class['name']]);
					$result = $statement->fetch();
					
					foreach($class['courses'] as $course) {
						$statement = $PDO->prepare("SELECT ID FROM course WHERE class = ? AND name = ?");
						$statement->execute([$result['ID'], $course]);
						if($statement->rowCount() != 1) {
							// Delete all courses with the current name for the case there are doubles
							$statement = $PDO->prepare("DELETE FROM course WHERE class = ? AND name = ?");
							$statement->execute([$result['ID'], $course]);
							
							// Insert new
							$statement = $PDO->prepare("INSERT INTO course (class, name) VALUE (?, ?)");
							$statement->execute([$result['ID'], $course]);
							
							$changed_something = true;
						}
					}
				}
			}
			
			if($change_something) {
				// Delete all classes, witch are not available anymore
				$class_list = [];
				$mqsyl_command = "DELETE FROM class WHERE NOT name = ?";
				foreach($json['result']['classes'] as $id => $class) {
					$class_list[] = $class['name'];
					if($id != 0) {
						$mqsyl_command .= " AND NOT name = ?";
					}
				}
				
				$statement = $PDO->prepare($mysql_command);
				$statement->execute($class_list);
				
				
				$statement = $PDO->prepare("SELECT ID FROM class");
				$statement->execute();
				// Delete all classes, witch are not available anymore
				$class_list = [];
				$mqsyl_command = "DELETE FROM course WHERE NOT class = ?";
				foreach($statement->fetchAll() as $id => $class) {
					$class_list[] = $class['ID'];
					if($id != 0) {
						$mqsyl_command .= " AND NOT class = ?";
					}
				}
				
				$statement = $PDO->prepare($mysql_command);
				$statement->execute($class_list);
				
				
				// Clean up subscription database
				$statement = $PDO->prepare("SELECT ID FROM class");
				$statement->execute();
				// Delete all classes, witch are not available anymore
				$class_list = [];
				$course_list = [];
				$mqsyl_command_class = "NOT value = ?";
				$mqsyl_command_course = "NOT value = ?";
				foreach($statement->fetchAll() as $id => $class) {
					$class_list[] = $class['ID'];
					if($id != 0) {
						$mqsyl_command_class .= " AND NOT value = ?";
					}
					
					$statement2 = $PDO->prepare("SELECT ID FROM course");
					$statement2->execute();				
					foreach($statement->fetchAll() as $course) {
						$course_list[] = $class['ID'];
						if($id != 0) {
							$mqsyl_command_course .= " AND NOT value = ?";
						}
					}
				}
				
				$statement = $PDO->prepare("DELETE FROM subscription WHERE (".$mysql_command_class.") OR (".$mysql_command_course.")");
				$statement->execute($list);
			}
		}
	}
}

?>