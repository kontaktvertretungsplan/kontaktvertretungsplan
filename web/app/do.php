<?php
	$do = explode(':', $ACTION_DO);
	if(count($do) == 2) {
		if(isRole($do[0])) {
			include("web/app/do_".validPath($do[0])."_".validPath($do[1]).".php");
		}
		else {
			header("Location: ?p=main");
			exit();
		}
	}
	else {
		include("web/app/do_".validPath($do[0]).".php");
	}
?>