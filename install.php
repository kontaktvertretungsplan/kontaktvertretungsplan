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

Installationsassistent für Kontakt:Vertretungsplan
*/

require('lib/isHttps.php');

if(!isHttps()) {
	die("Only HTTPS connections are allowed");
}

require('lib/updateConfigCache.php');
	require('lib/getConfig.php');
	require('lib/saveConfig.php');
	require('lib/exportConfig.php');
require('lib/getConfigCache.php');
require('lib/newPDO.php');
require('lib/settings.php');
require('lib/telegramBot.php');

$CONFIG = getConfigCache();
$PDO = newPDO();

function generateRandomString($length) {
    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
}

$statement = $PDO->prepare("CREATE TABLE IF NOT EXISTS `class` (
  `ID` int(8) NOT NULL AUTO_INCREMENT,
  `name` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `ID` (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=0 ;");
$statement->execute();

$statement = $PDO->prepare("CREATE TABLE IF NOT EXISTS `course` (
  `ID` int(8) NOT NULL AUTO_INCREMENT,
  `class` int(8) NOT NULL,
  `name` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `ID` (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=0 ;");
$statement->execute();

$statement = $PDO->prepare("CREATE TABLE IF NOT EXISTS `log` (
  `ID` int(8) NOT NULL AUTO_INCREMENT,
  `user` int(8) NOT NULL,
  `module` text COLLATE utf8_unicode_ci NOT NULL,
  `part` text COLLATE utf8_unicode_ci NOT NULL,
  `status` text COLLATE utf8_unicode_ci NOT NULL,
  `notice` text COLLATE utf8_unicode_ci NOT NULL,
  `time` int(10) NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `ID` (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=0 ;");
$statement->execute();

$statement = $PDO->prepare("CREATE TABLE IF NOT EXISTS `session` (
  `ID` int(8) NOT NULL AUTO_INCREMENT,
  `session` text COLLATE utf8_unicode_ci NOT NULL,
  `user` int(8) NOT NULL,
  `time` int(10) NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `ID` (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=0 ;");
$statement->execute();

$statement = $PDO->prepare("CREATE TABLE IF NOT EXISTS `settings` (
  `ID` int(8) NOT NULL AUTO_INCREMENT,
  `name` text COLLATE utf8_unicode_ci NOT NULL,
  `value` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `ID` (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=0 ;");
$statement->execute();

$statement = $PDO->prepare("CREATE TABLE IF NOT EXISTS `subscription` (
  `ID` int(8) NOT NULL AUTO_INCREMENT,
  `user` int(8) NOT NULL,
  `typ` text COLLATE utf8_unicode_ci NOT NULL,
  `value` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `ID` (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=0 ;");
$statement->execute();

$statement = $PDO->prepare("CREATE TABLE IF NOT EXISTS `timetable` (
  `ID` int(8) NOT NULL AUTO_INCREMENT,
  `date` text COLLATE utf8_unicode_ci NOT NULL,
  `hash` text COLLATE utf8_unicode_ci NOT NULL,
  `plan` text COLLATE utf8_unicode_ci NOT NULL,
  `time` int(10) NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `ID` (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=0 ;");
$statement->execute();

$statement = $PDO->prepare("CREATE TABLE IF NOT EXISTS `user` (
  `ID` int(8) NOT NULL AUTO_INCREMENT,
  `telegram` text COLLATE utf8_unicode_ci NOT NULL,
  `mute` text COLLATE utf8_unicode_ci NOT NULL,
  `role` text COLLATE utf8_unicode_ci NOT NULL,
  `name` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `ID` (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=0 ;");
$statement->execute();

$url = explode("?", "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
$url = str_replace('install.php', '', $url[0]);

settingPut('url', $url);

//==========================================================================

if($_GET['install'] == 'main') {
	if($_POST['school-name'] != '') {
		settingPut('school:name', $_POST['school-name']);
	}
	else {
		$info_out['school-name'] = 'empty';
	}

	if($_POST['school-address'] != '') {
		settingPut('school:address', $_POST['school-address']);
	}
	else {
		$info_out['school-address'] = 'empty';
	}

	if($_POST['school-url'] != '') {
		settingPut('school:url', $_POST['school-url']);
	}
	else {
		$info_out['school-url'] = 'empty';
	}



	if($_POST['provider-name'] != '') {
		settingPut('provider:name', $_POST['provider-name']);
	}
	else {
		$info_out['provider-name'] = 'empty';
	}
	if($_POST['provider-address'] != '') {
		settingPut('provider:address', $_POST['provider-address']);
	}
	else {
		$info_out['provider-address'] = 'empty';
	}
	if($_POST['provider-url'] != '') {
		settingPut('provider:url', $_POST['provider-url']);
	}
	else {
		$info_out['provider-url'] = 'empty';
	}
	if($_POST['provider-mail'] != '') {
		settingPut('provider:mail', $_POST['provider-mail']);
	}
	else {
		$info_out['provider-mail'] = 'empty';
	}


	if($_POST['api-classes'] != '') {
		$json = json_decode(file_get_contents($_POST['api-classes']), true);
		if($json['ok']) {
			settingPut('k-v:api:classes', $_POST['api-classes']);
		}
		else {
			$info_out['api-classes'] = 'not-valid';
		}
	}
	else {
		$info_out['api-classes'] = 'empty';
	}
	if($_POST['api-plan'] != '') {
		$json = json_decode(file_get_contents($_POST['api-plan']), true);
		if($json['ok']) {
			settingPut('k-v:api:timetable', $_POST['api-plan']);
		}
		else {
			$info_out['api-plan'] = 'not-valid';
		}
	}
	else {
		$info_out['api-plan'] = 'empty';
	}


	if($_POST['bot-token'] != '') {
		$json = json_decode(file_get_contents('https://api.telegram.org/bot'.$_POST['bot-token'].'/getMe'), true);
		if($json['ok']) {
			$me = $json['result'];
			$webhook = generateRandomString(32);
			$json = json_decode(file_get_contents('https://api.telegram.org/bot'.$_POST['bot-token'].'/setWebhook?url='.urlencode(settingGet('url').'webhook.php?key='.$webhook)), true);

			if($json['ok'] && $json['result']) {
				settingPut('webhook', $webhook);
				settingPut('telegram:token', $_POST['bot-token']);
				$SETTINGS['telegram:token'] = $_POST['bot-token'];
				updateBotInfo();
			}
			else {
				$info_out['bot-token'] = 'webhook-fail';
			}
		}
		else {
			$info_out['bot-token'] = 'not-valid';
		}

	}
	else {
		$info_out['bot-token'] = 'empty';
	}

	updateSettingCache();

	$info_url = '';
	foreach($info_out as $input => $error) {
		$info_url .= '&info['.$input.']='.$error;
	}

	header('Location: ?step=1'.$info_url);
}
elseif($_GET['install'] == 'user') {
	$statement = $PDO->prepare("SELECT ID, name FROM user WHERE role LIKE ?");
	$statement->execute(['%"admin"%']);
	if($statement->rowCount() == 0) {
		if(isset($_GET['id'])) {
			$statement = $PDO->prepare("UPDATE user SET role = ? WHERE ID = ?");
			$statement->execute(['["admin"]', $_GET['id']]);
		}
	}
	header('Location: ?step=2');
}

//==========================================================================

if(settingGet('school:name') == '') {
	$install['school']['name'] = true;
}
if(settingGet('school:address') == '') {
	$install['school']['address'] = true;
}
if(settingGet('school:url') == '') {
	$install['school']['url'] = true;
}

if(settingGet('provider:name') == '') {
	$install['provider']['name'] = true;
}
if(settingGet('provider:address') == '') {
	$install['provider']['address'] = true;
}
if(settingGet('provider:url') == '') {
	$install['provider']['url'] = true;
}
if(settingGet('provider:mail') == '') {
	$install['provider']['mail'] = true;
}

if(settingGet('k-v:api:classes') == '') {
	$install['api']['classes'] = true;
}
if(settingGet('k-v:api:timetable') == '') {
	$install['api']['plan'] = true;
}

if(settingGet('telegram:token') == '') {
	$install['bot']['token'] = true;
}

//==========================================================================

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Kontakt:Vertretungsplan</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="web/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="web/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="web/bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="web/dist/css/AdminLTE.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition login-page">
	<div class="login-box">
	  <div class="login-logo">
	    <a href="?">Kontakt:Vertretungsplan</a>
	  </div>
	  <div class="login-subtitle">
	    <p>Installieren</p>
	  </div>
	  <!-- /.login-logo -->
		<div class="login-box-body">
<?php
if($_GET['step'] == 1) {
	if(count($install) == 0) {
		echo '<p class="login-box-msg">Alle wichtigen Konfigurationen sind gespeichert.</p>';
		echo '<p>Starte nun den Bot in deinem Telegram Account.</p>';

		echo '<ul>';
		$BOT = getBotInfo();
		echo '<li>Benutzername: '.$BOT['username'].'</li>';
		echo '</ul>';

		echo '<p>Fertig?</p>';
		echo '<a href="?step=2" class="btn btn-success btn-block btn-flat btn-lg">weiter</a>';
	}
	else {
		echo '<form method="POST" action="?install=main">';
		if(count($install['school']) != 0) {
			echo '<p class="login-box-msg">Schulinformationen</p>';
			if($install['school']['name']) {
				echo '<input type="text" name="school-name" placeholder="Schulname" required class="form-control"><br>';
			}
			if($install['school']['address']) {
				echo '<input type="text" name="school-address" placeholder="Schul Adresse" required class="form-control"><br>';
			}
			if($install['school']['url']) {
				echo '<input type="url" name="school-url" placeholder="Schul Website" required class="form-control"><br>';
			}
			echo '<br>';
		}

		if(count($install['provider']) != 0) {
			echo '<p class="login-box-msg">Anbieterinformationen</p>';
			if($install['provider']['name']) {
				echo '<input type="text" name="provider-name" placeholder="Anbieter Name" required class="form-control"><br>';
			}
			if($install['provider']['address']) {
				echo '<input type="text" name="provider-address" placeholder="Anbieter Adresse" required class="form-control"><br>';
			}
			if($install['provider']['url']) {
				echo '<input type="url" name="provider-url" placeholder="Anbieter Website" required class="form-control"><br>';
			}
			if($install['provider']['mail']) {
				echo '<input type="email" name="provider-mail" placeholder="Anbieter E-Mail Adresse" required class="form-control"><br>';
			}
			echo '<br>';
		}

		if(count($install['api']) != 0) {
			echo '<p  class="login-box-msg">API Urls</p>';
			if($install['api']['classes']) {
				echo '<input type="url" name="api-classes" placeholder="API Klassen" required class="form-control"><br>';
			}
			if($install['api']['plan']) {
				echo '<input type="url" name="api-plan" placeholder="API Stundenplan" required class="form-control"><br>';
			}
			echo '<br>';
		}

		if(count($install['bot']) != 0) {
			echo '<p class="login-box-msg">Telegram Bot API</p>';
			if($install['bot']['token']) {
				echo '<input type="text" name="bot-token" placeholder="Bot Token" required class="form-control"><br>';
			}
			echo '<br>';
		}
		echo '<button class="btn btn-success btn-block btn-flat btn-lg">Speichern</button>';
		echo '</form>';
	}
}
elseif($_GET['step'] == 2) {
	$statement = $PDO->prepare("SELECT ID, name FROM user WHERE role LIKE ?");
	$statement->execute(['%"admin"%']);
	if($statement->rowCount() == 0) {
		echo '<p>Dein Name sollte nun in der Liste unten auftauchen.</p>';
		echo '<p>Nicht der Fall?</p>';
		echo '<a href="?step=2" class="btn btn-success btn-block btn-flat btn-lg">neu laden</a>';
		echo '<p class="login-box-msg">Angemeldete Benutzer</p>';

		echo '<ul>';
		$statement = $PDO->prepare("SELECT ID, name FROM user");
		$statement->execute();
		foreach($statement->fetchAll() as $row) {
			echo '<li>'.$row['name'].' <a href="?install=user&id='.$row['ID'].'" class="btn btn-success btn-block btn-flat btn-lg">Zum Admin machen</a></li>';
		}
		echo '</ul>';
	}
	else {
		echo '<p>Mindestens eine Person ist nun Administrator.</p>';
		echo '<p>Die Installation ist nun funktionsfähig und abgeschlossen.</p>';
		echo '<p>Bedenke aber, dass für den Studenplan noch folgende Aufgaben zu erledigen sind:</p>';
		echo '<ul>';
		echo '<li>Klassenliste einlesen</li>';
		echo '<li>Cronjob für Klassenliste anlegen</li>';
		echo '<li>Cronjob für Stundenplan anlegen</li>';
		echo '<li>Cronjob für "Du hast gleich" anlegen</li>';
		echo '</ul>';

		echo '<a href="./" class="btn btn-success btn-block btn-flat btn-lg">Zur Webconfig</a>';
	}
}
else {
	echo '<a href="?step=1" class="btn btn-success btn-block btn-flat btn-lg">Installation starten</a>';
}
?>
		</div>
		<!-- /.login-box-body -->
	</div>
	<!-- /.login-box -->

	<!-- jQuery 3 -->
	<script src="web/bower_components/jquery/dist/jquery.min.js"></script>
	<!-- Bootstrap 3.3.7 -->
	<script src="web/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
	</body>
</html>
