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

Befehls Cache aktualisieren
*/

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
?>