<?php

$mute = $_POST['mute'];
if(count($mute) == 0) {
	$mute = '';
}
else {
	$mute = json_encode($mute);
}

$statement = $PDO->prepare("UPDATE user SET mute = ? WHERE ID = ?");
$statement->execute([$mute, $USER_INFO['id']]);

header("Location: ?p=notification&notice=saved");
exit();