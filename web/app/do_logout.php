<?php

session_destroy();

header("Location: ?info=main&notice=logout");
exit();