<?php
// check if the user is logged in
function login_check() {
	session_start();
	if (isset($_SESSION['username']) || !empty($_SESSION['username'])) {
		global $userid;
		$userid = $_SESSION['userid'];
	} else {
		header("Location: ./index.php?error=nologin");
	}
}
?>
