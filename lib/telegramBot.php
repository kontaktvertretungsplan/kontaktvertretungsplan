<?php
/*
*==============================================================*
* |\      /| | |     /---- |    | | |\   | /----\ |---- |      *
* | \    / | | |     |     |    | | | \  | |      |     |      *
* |  \  /  | | |     |     |----| | |  \ | \----\ |---- |      *
* |   \/   | | |     |     |    | | |   \|      | |     |      *
* |        | | |---- \---- |    | | |    | \----/ |---- |----- *
*==============================================================*
*        Written by Clemens Riese (c)miclhinsel.de 2018        *
*==============================================================*

Kontakt:Vertretungsplan Telegram Bot

Stellt Informationen über den Telegram Bot bereit
*/

function getBotInfo() {
	$cache_path = 'cache';
	$cache_file_name = 'bot.php';
	if(!file_exists($cache_path.'/'.$cache_file_name)) {
		updateBotInfo();
	}
	return require($cache_path.'/'.$cache_file_name);
}

function updateBotInfo() {
	global $SETTINGS;
	$cache_path = 'cache';
	$cache_file_name = 'bot.php';
		
	$json = json_decode(file_get_contents('https://api.telegram.org/bot'.$SETTINGS['telegram:token'].'/getMe'), true);
	if($json['ok']) {
		file_put_contents($cache_path.'/'.$cache_file_name, sprintf('<?php return %s; ?>', var_export($json['result'], true)));
	}
	else {
		file_put_contents($cache_path.'/'.$cache_file_name, sprintf('<?php return %s; ?>', var_export(false, true)));
	}
}