<?php
/*
/ MYSQL CONNECTION
*/
require_once("../../mysql_security.php");

// CHECK CONNECTION
if (mysqli_connect_errno()) {
	echo "Error could not connect to databas. Please try again later.";
	exit;
}

?>
