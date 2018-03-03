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

Gibt alle Befehle aus dem Konfigurations Cache zurück
Falls die Datei fehlt wird sie neu generiert
*/
function getConfigCache() {
	$cache_path = 'cache';
	$cache_file_name = 'config.php';
	if(!file_exists($cache_path.'/'.$cache_file_name)) {
		updateConfigCache();
	}
	return require($cache_path.'/'.$cache_file_name);
}