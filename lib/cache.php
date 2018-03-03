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

Läd, speichert und stell Cache Dateien zur Verfügung
*/

function getConfig($config_file) {
	$config_path = 'config';
	return json_decode(file_get_contents($config_path.'/'.$config_file), true);
}

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

function exportConfig($config_input) {
	
	foreach($config_input as $name => $config_dump) {
		saveConfig($name.'.json', $config_dump);
	}

}

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

function getConfigCache() {
	$cache_path = 'cache';
	$cache_file_name = 'config.php';
	if(!file_exists($cache_path.'/'.$cache_file_name)) {
		updateConfigCache();
	}
	return require($cache_path.'/'.$cache_file_name);
}

function updateTextCache() {
	global $CONFIG;
	
	$text_path = 'recources/text';
	$cache_path = 'cache';
	
	$cache_file_name = 'text.php';
	
	$text_file = /*$CONFIG['brand']['language'].*/'de-de.json';
	
	$output = [];
	
	if(is_file($text_path.'/'.$text_file)) {	
		$output = json_decode(file_get_contents($text_path.'/'.$text_file), true);
	}
	
	file_put_contents($cache_path.'/'.$cache_file_name, sprintf('<?php return %s; ?>', var_export($output, true)));
}

function getTextCache() {
	$cache_path = 'cache';
	$cache_file_name = 'text.php';
	if(!file_exists($cache_path.'/'.$cache_file_name)) {
		updateTextCache();
	}
	return require($cache_path.'/'.$cache_file_name);
}

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

function getPluginCache() {
	$cache_path = 'cache';
	$cache_file_name = 'plugins.php';
	if(!file_exists($cache_path.'/'.$cache_file_name)) {
		updatePluginCache();
	}
	return require($cache_path.'/'.$cache_file_name);
}

function updateCommandCache() {
	$cache_path = 'cache';
	
	$cache_file_name = 'commands.php';
	
	$plugin_meta = require('cache/plugins.php');
	
	$command_significance = [];
	
	foreach($plugin_meta as $id => $plugin) {
		foreach($plugin['integration']['commands'] as $command) {
			$command_significance[$command['significance']][] = array_merge(['plugin' => $id], $command);
		}
	}
	
	$commands = [];
	$shortcuts = [];
	$aliases = [];
	
	foreach($command_significance as $significance) {
		foreach($significance as $command) {
			if($command['command'] != '') {
				$commands[$command['command']] = $command['plugin'];
				if($command['shortcut'] != '') {
					$shortcuts[$command['shortcut']] = $command['plugin'];
				}
				if($command['alias'] != '') {
					$aliases[$command['alias']] = $command['plugin'];
				}
			}
		}
	}
	
	
	$start_significance = [];
	
	foreach($plugin_meta as $id => $plugin) {
		$start_significance[$command['significance']][] = array_merge(['plugin' => $id], $plugin['integration']['start']);
	}
	
	$start = [];
	
	foreach($start_significance as $significance) {
		foreach($significance as $command) {
			if($command['name'] != '') {
				$start[$command['name']] = $command['plugin'];
			}
		}
	}
	
	
	$output = ['command' => $commands, 'shortcut' => $shortcuts, 'alias' => $aliases, 'start' => $start];
	
	
	
	
	
	file_put_contents($cache_path.'/'.$cache_file_name, sprintf('<?php return %s; ?>', var_export($output, true)));
}

function getCommandCache() {
	$cache_path = 'cache';
	$cache_file_name = 'commands.php';
	if(!file_exists($cache_path.'/'.$cache_file_name)) {
		updateCommandCache();
	}
	return require($cache_path.'/'.$cache_file_name);
}