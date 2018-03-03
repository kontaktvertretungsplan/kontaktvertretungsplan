<?php

if($_POST['message'] != '' && $_POST['classes'] != []) {
	$user = [];
	
	foreach($_POST['classes'] as $class) {
		$statement = $PDO->prepare("SELECT user FROM subscription WHERE typ = ? AND value = ?");
		$statement->execute(['class', $class]);
		
		foreach($statement->fetchAll() as $row) {
			$merge = true;
			foreach($user as $u) {
				if($u == $row['user']) {
					$merge = false;
				}
			}
			
			if($merge) {
				$user[] = $row['user'];
			}
		}
	}
	
	$class_text = '';
	
	foreach($_POST['classes'] as $class) {
		$statement = $PDO->prepare("SELECT name FROM class WHERE ID = ?");
		$statement->execute([$class]);
		$result = $statement->fetch();
		
		$class_text .= $result['name'].', ';
	}
	
	$class_text = substr($class_text, 0, -2);
	
	foreach($user as $u) {
		$statement = $PDO->prepare("SELECT telegram FROM user WHERE ID = ?");
		$statement->execute([$u]);
		$result = $statement->fetch();
		
		sendMessage($result['telegram'], '*Nachricht*
von '.$USER_INFO['name'].' an '.$class_text.'

'.$_POST['message'], [[["text" => "Haupmenü", "callback_data" => "/menu"]]]);
	}
}

header("Location: ?p=mod:broadcast");
exit();
?>