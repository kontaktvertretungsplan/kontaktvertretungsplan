<?php
$key = $_POST['key'];
if($key == '') {
	$key = randomToken(32);
}
settingPut('k-v:webhook:timetable', $key);
updateSettingCache();

header("Location: ?p=cron:timetable");
exit();

?>