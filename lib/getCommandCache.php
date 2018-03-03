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

Gibt alle Befehle aus dem Befehls Cache zurück
Falls die Datei fehlt wird sie neu generiert
*/

function getCommandCache() {
	$cache_path = 'cache';
	$cache_file_name = 'commands.php';
	if(!file_exists($cache_path.'/'.$cache_file_name)) {
		updateCommandCache();
	}
	return require($cache_path.'/'.$cache_file_name);
}