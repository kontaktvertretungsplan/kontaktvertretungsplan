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

Speichert die angegebenen Werte in der Datenbank für die Statistik
*/

function logIt($user, $module, $part, $status, $notice) {
	global $PDO;
	$statement = $PDO->prepare("INSERT INTO log (user, module, part, status, notice, time) VALUES (?, ?, ?, ?, ?, ?)");
	$statement->execute([$user, $module, $part, $status, $notice, time()]);
}

?>