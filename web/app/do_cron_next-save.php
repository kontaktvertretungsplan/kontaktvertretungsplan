<?php
$key = $_POST['key'];
if($key == '') {
	$key = randomToken(32);
}
settingPut('k-v:webhook:next', $key);
updateSettingCache();

header("Location: ?p=cron:next");
exit();

?>