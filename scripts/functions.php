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
// Recursively delete directories

function delete_file($target) {
	if ( is_dir($target) ) {
		$files = glob($target. '*', GLOB_MARK);
		echo $taget;
		foreach ( $files as $file ) {
			delete_file($file);
		}
		echo "deleted target";
		rmdir ($target);
	} elseif ( is_file($target) ) {
		echo "deleted file";
		unlink($target);
	}
}
?>
