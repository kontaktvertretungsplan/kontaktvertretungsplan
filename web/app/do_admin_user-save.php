<?php

$role = $_POST['role'];
if(count($role) == 0) {
	$role = '';
}
else {
	$role = json_encode($role);
}

$mute = $_POST['mute'];
if(count($mute) == 0) {
	$mute = '';
}
else {
	$mute = json_encode($mute);
}

$statement = $PDO->prepare("UPDATE user SET name = ?, role = ?, mute = ? WHERE ID = ?");
$statement->execute([$_POST['name'], $role, $mute, $_GET['id']]);

header("Location: ?p=admin:user");
exit();

?>