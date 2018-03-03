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

Startet die PDO Datenbankverbindung
*/

function newPDO() {
	global $CONFIG;
try {
	$PDO = new PDO('mysql:host='.$CONFIG['db']['host'].';dbname='.$CONFIG['db']['name'], $CONFIG['db']['user'], $CONFIG['db']['pass']);
	$PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}

catch(PDOException $e) {
    echo "DB connection failed: " . $e->getMessage();
}
	return $PDO;
}

?>