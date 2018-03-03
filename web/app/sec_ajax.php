<?php

function generateRandomString($length) {
    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
}

function generateNewSessionID() {
	global $PDO;
	
	$count = 1;
	
	while($count > 0) {
		$newID = generateRandomString(10);
		
		$statement = $PDO->prepare("SELECT ID FROM session WHERE session = ?");
		$statement->execute([$newID]);
		$count = $statement->rowCount();
	}
	
	return $newID;
}



if(empty($_SESSION['session-id'])) {
	$session_id = generateNewSessionID();
	
	$statement = $PDO->prepare("INSERT INTO session (session, time) VALUES (?, ?)");
	$statement->execute([$session_id, time()]);
}
else {
	$session_id = $_SESSION['session-id'];
}

$_SESSION['session-id'] = $session_id;

$statement = $PDO->prepare("SELECT user, time FROM session WHERE session = ?");
$statement->execute([$session_id]);
if($statement->rowCount() == 1) {
	$result = $statement->fetch();
	//print_r($result);
	if($result['time'] > time()-(60*2)) {
		$valid = true;
	}
	else {
		$valid = false;
		$_SESSION['session-id'] = '';
	}
	
	if($result['user'] != 0) {
		$ready = true;
	}
	else {
		$ready = false;
	}
}
else {
	$valid = false;
	$ready = false;
	$_SESSION['session-id'] = '';
}



$output = [
	'session-id' => $session_id,
	'valid' => $valid,
	'ready' => $ready,
];

echo json_encode($output);

//print_r($_SESSION['session-id']);