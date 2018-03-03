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

Verwaltet Einstellungen
*/

function settingGet($name) {
	global $PDO;
	
	$statement = $PDO->prepare("SELECT value FROM settings WHERE name = ?");
	$statement->execute([$name]);
	$output = $statement->fetch();
	return $output['value'];
}

function settingPut($name, $value) {
	global $PDO;
	
	$statement = $PDO->prepare("SELECT ID FROM settings WHERE name = ?");
	$statement->execute([$name]);
	if($statement->rowCount() == 0) {
		$statement = $PDO->prepare("INSERT INTO settings (name, value) VALUES (?, ?)");
		$statement->execute([$name, $value]);
	}
	else {
		$statement = $PDO->prepare("UPDATE settings SET value = ? WHERE name = ?");
		$statement->execute([$value, $name]);
	}
}

function settingRemove($name) {
	global $PDO;
	
	$statement = $PDO->prepare("DELETE FROM settings WHERE name = ?");
	$statement->execute([$name]);
}

function settingGetAll() {
	global $PDO;
	
	$out = [];
	
	$statement = $PDO->prepare("SELECT name, value FROM settings");
	$statement->execute();
	
	foreach($statement->fetchAll() as $row) {
		$out[$row['name']] = $row['value'];
	}
	
	return $out;
}

function updateSettingCache() {
	$cache_path = 'cache';
	$cache_file_name = 'settings.php';
	file_put_contents($cache_path.'/'.$cache_file_name, sprintf('<?php return %s; ?>', var_export(settingGetAll(), true)));
}

function getSettingCache() {
	$cache_path = 'cache';
	$cache_file_name = 'settings.php';
	if(!file_exists($cache_path.'/'.$cache_file_name)) {
		updateSettingCache();
	}
	return require($cache_path.'/'.$cache_file_name);
}