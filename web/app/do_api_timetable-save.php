<?php

settingPut('k-v:api:timetable', $_POST['url']);
updateSettingCache();

header("Location: ?p=api:timetable");
exit();

?>