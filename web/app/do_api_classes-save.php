<?php

settingPut('k-v:api:classes', $_POST['url']);
updateSettingCache();

header("Location: ?p=api:classes");
exit();

?>