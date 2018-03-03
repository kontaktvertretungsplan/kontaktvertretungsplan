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

Einstiegsseite für die WebConfig
*/

require('lib/isHttps.php');

if(!isHttps()) {
	die("Only HTTPS connections are allowed");
}
require('lib/randomToken.php');
require('lib/updateConfigCache.php');
	require('lib/getConfig.php');
	require('lib/saveConfig.php');
	require('lib/exportConfig.php');
require('lib/updatePluginCache.php');
require('lib/updateCommandCache.php');

require('lib/getConfigCache.php');
require('lib/getPluginCache.php');
require('lib/getCommandCache.php');

require('lib/newPDO.php');

require('lib/telegramSend.php');
//require('lib/getPersonalTimetable.php');
//require('lib/timetablesAreDifferent.php');

require('lib/isRole.php');
require('lib/validPath.php');
require('lib/logIt.php');

$CONFIG = getConfigCache();
$PLUGINS = getPluginCache();
$COMMANDS = getCommandCache();

$PDO = newPDO();

require('lib/settings.php');
$SETTINGS = getSettingCache();

require('lib/telegramBot.php');
$BOT = getBotInfo();

session_start();

$USER = $_SESSION['user'];
//$USER = NULL;

$ACTION_PAGE = $_GET['p'];
$ACTION_DO = $_GET['do'];
$ACTION_SEC = $_GET['sec'];

logIt(0, 'webconfig', 'site-request', 'ok', "page: ".$ACTION_PAGE."\ndo: ".$ACTION_DO."\nsec:".$ACTION_SEC);

if(!empty($USER)) {
	$statement = $PDO->prepare("SELECT * FROM user WHERE ID = ?");
	$statement->execute([$USER]);
	$result = $statement->fetch();
	
	$USER_INFO = [
		'id' => $USER,
		'name' => $result['name'],
		'telegram-id' => $result['telegram'],
		'mute' => $result['mute'],
		'role' => json_decode($result['role'], true),
	];
	
	if($USER_INFO['name'] == '') {
		$USER_INFO['name'] = 'user:'.$USER_INFO['id'];
	}
	
	if(!empty($ACTION_PAGE)) {
		include("web/app/page.php");
	}
	elseif(!empty($ACTION_DO)) {
		include("web/app/do.php");
	}
	else {
		header("Location: ?p=main");
		exit();
	}
}
else {
	if(!empty($ACTION_SEC)) {
		include("web/app/sec.php");
	}
	else {
		header("Location: ?sec=login");
		exit();
	}
}

/*
include('web/app/page.php');
*/