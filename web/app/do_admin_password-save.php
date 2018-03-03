<?php

settingPut('password', $_POST['password']);
updateSettingCache();

header("Location: ?p=admin:password");
exit();

?>