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

Wandelt Stundenplan Notiz Arrays in Strings um

Funktionen:
buildNote(input)
	input = [['note1'], ['note2']];
	
	Gibt String zurück

*/



function buildNote($input) {
	$out = '';
	
	if(count($input) > 0) {
		foreach($input as $note) {
			$out .= $note[0].'
	';
		}
		
		$out = substr($out, 0, -1);
		$out = '*Anmerkung*
'.$out;
		return trim($out);
	}
	else {
		return '';
	}
}


?>