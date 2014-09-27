<?php
include("header.php");
require_once('../../ts-yt-dl-defaults/mysql_security.php');
require_once("functions.php");
login_check();
session_start();
$userid = $_SESSION['userid'];
$url = $_POST['url'];
$parm = $_POST['parm'];
$thumbnail = exec("youtube-dl --get-thumbnail $url");
if (!empty($url) && filter_var($url, FILTER_VALIDATE_URL)) {
	// write to file
	//$ip = $_SERVER['REMOTE_ADDR'];
	$timestamp = date('YmdHis');
	if ( mkdir("/srv/ts-yt-dl/$userid/$timestamp", 0755, true) ) {
		$title = exec("youtube-dl --get-title $url");
		exec("youtube-dl -o \"/srv/ts-yt-dl/$userid/$timestamp/$title.mp4\" $parm $url &");
	} else {
		echo "Failed to create directory!";
	}
	echo "<body>
	<div id=\"content\">
	<img class=\"thumbnail\" src=\"$thumbnail\">
	</div>";
} else {
	header("Location: ./index.php?error=no_url");
}
include('footer.php');
?>
