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

Funktion, die den nächsten Tag ermittelt an dem ein Stundenplan bereitgestellt werden kann

Morgens für den aktuellen Tag
Nachmittags für den nächsten Tag (kann durch $not_next_day=true verhindert werden)
Am Wochenende für den nächsten Montag
*/

function getNextTimetableDate($not_next_day = false) {
	$current_time = time();
	$time = $current_time;
	
	// Is after 11:00?
	if(date('G', $time) > 11 && !$not_next_day) {
		$time = $time + (60*60*24);
	}
	
	// Is Saturday?
	if(date('w', $time) == 6) {
		$time = $time + (60*60*24);
	}
	
	// Is Sunday?
	if(date('w', $time) == 0) {
		$time = $time + (60*60*24);
	}
	
	return ['year' => date('Y', $time), 'month' => date('m', $time), 'day' => date('d', $time)];

}