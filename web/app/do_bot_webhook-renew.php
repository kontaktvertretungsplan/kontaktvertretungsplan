<?php
settingPut('webhook', randomToken(32));
updateSettingCache();
$url = 'https://api.telegram.org/bot'.$SETTINGS['telegram:token'].'/setWebhook?url='.urlencode($SETTINGS['url'].'webhook.php?key='.settingGet('webhook'));

$json= json_decode(file_get_contents($url), true);

if($json['ok'] && $json['result']) {
	header("Location: ?p=bot:info&notice=ok");
	exit();
}
else {
	header("Location: ?p=bot:info&notice=error");
	exit();
}
?>