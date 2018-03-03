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

Plugin Cache aktualisieren
*/

function updatePluginCache() {
	$plugin_path = 'plugins';
	$cache_path = 'cache';
	
	$cache_file_name = 'plugins.php';
	
	$plugin_folders = scandir($plugin_path);
	
	$output = [];
	
	foreach($plugin_folders as $plugin_folder) {
		if($plugin_folder == '.' or $plugin_folder == '..') {
			continue;
		}
		
		if(is_dir($plugin_path.'/'.$plugin_folder)) {
			$plugin_name = $plugin_folder;
			
			if(is_file($plugin_path.'/'.$plugin_folder.'/meta.json')) {
				$output[$plugin_name] = json_decode(file_get_contents($plugin_path.'/'.$plugin_folder.'/meta.json'), true);
			}
		}
	}
	
	file_put_contents($cache_path.'/'.$cache_file_name, sprintf('<?php return %s; ?>', var_export($output, true)));
}
?>