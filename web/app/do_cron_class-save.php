<?php
$key = $_POST['key'];
if($key == '') {
	$key = randomToken(32);
}
settingPut('k-v:webhook:class', $key);
updateSettingCache();

header("Location: ?p=cron:class");
exit();

?>