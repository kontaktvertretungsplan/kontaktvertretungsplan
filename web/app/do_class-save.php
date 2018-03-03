<?php

$statement = $PDO->prepare("SELECT ID FROM class");
$statement->execute();
foreach($statement->fetchAll() as $class) {
	$statement = $PDO->prepare("SELECT ID FROM subscription WHERE user = ? AND typ = 'class' AND value = ?");
	$statement->execute([$USER_INFO['id'], $class['ID']]);
	if($statement->rowCount() == 1) {
		if($_POST['class'][$class['ID']] != 'yes') {
			$statement = $PDO->prepare("DELETE FROM subscription WHERE user = ? AND typ = 'class' AND value = ?");
			$statement->execute([$USER_INFO['id'], $class['ID']]);
		}
	}
	else {
		if($_POST['class'][$class['ID']] == 'yes') {
			$statement = $PDO->prepare("INSERT INTO subscription (user, typ, value) VALUES (?, 'class', ?)");
			$statement->execute([$USER_INFO['id'], $class['ID']]);
		}
	}
	
	if($_POST['course'][$class['ID']] != []) {
		$statement = $PDO->prepare("SELECT ID FROM course WHERE class = ?");
		$statement->execute([$class['ID']]);
		foreach($statement->fetchAll() as $course) {
			$statement = $PDO->prepare("SELECT ID FROM subscription WHERE user = ? AND typ = 'course' AND value = ?");
			$statement->execute([$USER_INFO['id'], $course['ID']]);
			if($statement->rowCount() == 1) {
				if($_POST['course'][$class['ID']][$course['ID']] != 'yes') {
					$statement = $PDO->prepare("DELETE FROM subscription WHERE user = ? AND typ = 'course' AND value = ?");
					$statement->execute([$USER_INFO['id'], $course['ID']]);
				}
			}
			else {
				if($_POST['course'][$class['ID']][$course['ID']] == 'yes') {
					$statement = $PDO->prepare("INSERT INTO subscription (user, typ, value) VALUES (?, 'course', ?)");
					$statement->execute([$USER_INFO['id'], $course['ID']]);
				}
			}
		}
	}
}

header("Location: ?p=class&notice=saved");
