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

Wandelt Stundenplan Arrays in Strings um

*/



function buildTimetable($input) {
	$output = [];
	$out = '';
	foreach($input as $lesson => $classes) {
		foreach($classes as $class => $courses) {
			$output[$class] .= $lesson.'. Stunde'."\n";
			foreach($courses as $course => $info) {
				if($info['status'] == 'canceled') {
					$output[$class] .= '     _'.$info['lesson'].' ('.$course.')_'."\n";
					$output[$class] .= '     '.'_Fällt aus_'."\n";
					if($info['note'] != '') {
						$output[$class] .= '     _('.$info['note'].')_'."\n";
					}
					$output[$class] .= "\n";
				}
				elseif($info['status'] == 'changed') {
					$output[$class] .= '     _'.$info['lesson'].' ('.$course.')_'."\n";
					$output[$class] .= '     _'.$info['teacher'].'_'."\n";
					$output[$class] .= '     _'.$info['room'].'_'."\n";
					if($info['note'] != '') {
						$output[$class] .= '     _('.$info['note'].')_'."\n";
					}
					$output[$class] .= "\n";
				}
				else {
					$output[$class] .= '     '.$info['lesson'].' ('.$course.')'."\n";
					$output[$class] .= '     '.$info['teacher']."\n";
					$output[$class] .= '     '.$info['room']."\n";
					if($info['note'] != '') {
						$output[$class] .= '     ('.$info['note'].')'."\n";
					}
					$output[$class] .= "\n";
				}
			}
		}
	}

	
	foreach($output as $class => $plan) {
		$out .= '*Klasse '.$class.'*'."\n";
		$out .= $plan."\n";
		$out .= "\n";
	}
	return trim($out);
}


?>