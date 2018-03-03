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

Konfigiratinos Cache aktualisieren
*/

function updateConfigCache() {
	$config_path = 'config';
	$cache_path = 'cache';
	
	$cache_file_name = 'config.php';
	
	$config_files = scandir($config_path);
	
	$output = [];
	
	foreach($config_files as $config_file) {
		if($config_file == '.' or $config_file == '..') {
			continue;
		}
		
		if(is_file($config_path.'/'.$config_file)) {	
			$config_file_name = explode('.', $config_file);
			if($config_file_name[count($config_file_name)-1] == 'json') {
				$config_file_namepart = '';
				foreach($config_file_name as $id => $namepart) {
					if($id != count($config_file_name)-1) {
						if($config_file_namepart != '') {
							$config_file_namepart .= '.'.$namepart;
						}
						else {
							$config_file_namepart = $namepart;
						}
					}
				}
				$config_file_name = $config_file_namepart;
				
				$output[$config_file_name] = getConfig($config_file);
			}
		}
	}
	
	file_put_contents($cache_path.'/'.$cache_file_name, sprintf('<?php return %s; ?>', var_export($output, true)));
}
?>