<?php
include("header.php");
require('../../ts-yt-dl-defaults/ts-yt-dl');
require_once('../../ts-yt-dl-defaults/mysql_security');
require_once("functions.php");
login_check();
session_start();
$userid = $_SESSION['userid'];
$url = $_POST['url'];
$parm = $_POST['parm'];
$thumbnail = exec("youtube-dl --get-thumbnail $url");
if (!empty($url) && filter_var($url, FILTER_VALIDATE_URL)) {
	// write to file
	$ip = $_SERVER['REMOTE_ADDR'];
	$timestamp = date('YmdHis');
	if ( mkdir("$data_path/$userid/downloads/$timestamp", 0755, true) ) {
		$title = exec("youtube-dl --get-title $url");
		//echo "$data_path/$userid/downloads/$timestamp/$title.mp4";
		file_put_contents("$data_path/$userid/downloads/$timestamp/log", "Timestamp = $timestamp\nRemote IP = $ip\nParm = $parm\nVideo URL = $url\n");
		exec("nohup youtube-dl -o \"$data_path/$userid/downloads/$timestamp/$title.mp4\" $parm $url >> \"$data_path/$userid/downloads/$timestamp/log\" &");
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
