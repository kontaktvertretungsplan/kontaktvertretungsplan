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

PLUGIN
*/

if(isset($command[1])) {
	$statement = $PDO->prepare("SELECT user, time FROM session WHERE session = ?");
	$statement->execute([$command[1]]);
	
	if($statement->rowCount() == 1) {
		$result = $statement->fetch();
		if($result['time'] > time()-(60*2) || $result['user'] == 0) {
			$statement = $PDO->prepare("SELECT ID FROM user WHERE telegram = ?");
			$statement->execute([$message['from']['id']]);
			$result = $statement->fetch();
			
			$statement = $PDO->prepare("UPDATE session SET user = ? WHERE session = (?)");
			$statement->execute([$result['ID'], $command[1]]);
			
			sendMessage($message['from']['id'], '*Webconfig*
Die Session wurde freigeschaltet.',
			[[["text" => "Jetzt Bearbeiten", "url" => $SETTINGS['url'].'?sec=session-start']]]);
		}
		else {
			sendMessage($message['from']['id'], '*Webconfig*
Die Session wurde bereits verwendendet, bitte starte eine neue und versuche es nochmal.',
			[[["text" => "Neue Session", "url" => $SETTINGS['url'].'?sec=login']]]);
		}
	}
	else {
	sendMessage($message['from']['id'], '*Webconfig*
Die Session ID ist ungültig. Probiere es nochmal.',
	[[["text" => "Nochmal Nachschauen", "url" => $SETTINGS['url'].'?sec=login']]]);
	}
}
else {
	sendMessage($message['from']['id'], '*Webconfig*
Es wurde keine Session ID übergeben.'
,
[[["text" => "Neue Session", "url" => $SETTINGS['url'].'?sec=login']]]);
}