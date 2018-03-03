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

Hat der aktuelle Nutzer eine bestimmte Rolle?
*/

function isRole($search) {
	global $USER_INFO;
	foreach($USER_INFO['role'] as $role) {
		if($role == $search) {
			return true;
		}
	}
	return false;
}

?>