<?php

settingPut($_POST['name'], $_POST['value']);
updateSettingCache();

header("Location: ?p=admin:settings");
exit();

?>