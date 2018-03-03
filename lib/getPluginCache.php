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

Gibt alle Befehle aus dem Plugin Cache zurück
Falls die Datei fehlt wird sie neu generiert
*/
function getPluginCache() {
	$cache_path = 'cache';
	$cache_file_name = 'plugins.php';
	if(!file_exists($cache_path.'/'.$cache_file_name)) {
		updatePluginCache();
	}
	return require($cache_path.'/'.$cache_file_name);
}