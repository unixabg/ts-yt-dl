<?php
// check if user is logged
function login_check() {
	if (!isset($_SESSION['username']) && empty($_SESSION['username'])) {
		header("Location: index.php?error=nologin");
		exit;
	}
}
?>
