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

Speichert Konfigurationen im Dateisystem
*/

function saveConfig($config_file, $config_dump) {
	$config_path = 'config';
	
	/*
	$config_content = getConfig($config_file);
	
	function goDeeper($input, $deep) {
		if(is_array($input)) {
			foreach($input as $name => $output) {
				$deep_out = $deep;
				$deep_out[] = $name;
				goDeeper($input, $deep);
			}
		}
		else {
			
		}
	}
	*/
	
	file_put_contents($config_path.'/'.$config_file, sprintf('%s', json_encode($config_dump)));
}

?>