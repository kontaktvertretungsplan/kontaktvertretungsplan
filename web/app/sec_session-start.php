<?php

if($_SESSION['session-id'] != '') {
	$session_id = $_SESSION['session-id'];
	$statement = $PDO->prepare("SELECT user, time FROM session WHERE session = ?");
	$statement->execute([$session_id]);
	if($statement->rowCount() == 1) {
		$result = $statement->fetch();
		//print_r($result);
		if($result['time'] > time()-(60*2) && $result['user'] != 0) {
			$_SESSION['user'] = $result['user'];
			header("Location: ?p=main");
			exit();
		}
	}
}

$_SESSION['session-id'] = '';

header("Location: ?sec=login&error=invalid");
exit();