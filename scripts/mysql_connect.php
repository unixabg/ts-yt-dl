<?php
/*
/ MYSQL CONNECTION
*/
require_once("../../ts-yt-dl-defaults/mysql_security");

// CHECK CONNECTION
if (mysqli_connect_errno()) {
	echo "Error could not connect to databas. Please try again later.";
	exit;
}

?>
