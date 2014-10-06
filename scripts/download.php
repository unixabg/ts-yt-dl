<?php
include("header.php");
require('../../ts-yt-dl-defaults/ts-yt-dl');
require_once('../../ts-yt-dl-defaults/mysql_security');
require_once("functions.php");
login_check();
session_start();
$userid = $_SESSION['userid'];
$url = $_POST['url'];
$dtype = $_POST['dtype'];
if (!empty($url) && filter_var($url, FILTER_VALIDATE_URL)) {
	// write to file
	$ip = $_SERVER['REMOTE_ADDR'];
	$timestamp = date('YmdHis');
	if ($dtype == "video") {
		if ( mkdir("$data_path/$userid/videos/$timestamp", 0755, true) ) {
			$title = exec("youtube-dl --get-title $url");
			$thumbnail = exec("youtube-dl --get-thumbnail $url");
			//echo "$data_path/$userid/videos/$timestamp/$title.mp4";
			file_put_contents("$data_path/$userid/videos/$timestamp/log", "Timestamp = $timestamp\nRemote IP = $ip\nDownload Type = $dtype\nVideo URL = $url\n");
			exec("nohup youtube-dl --write-thumbnail -o \"$data_path/$userid/videos/$timestamp/$title.mp4\" $dtype $url >> \"$data_path/$userid/videos/$timestamp/log\" &");
		} else {
			echo "Failed to create directory!";
		}
	} elseif ($dtype == "audio"){
		//download audio only
	} else {
		echo "Invalid dtype variable passed!";
	}
	//FIXME - set thumbnail to an error image.
	echo "<body>
	<div id=\"content\">
	<img class=\"thumbnail\" src=\"$thumbnail\">
	</div>";
} else {
	header("Location: ./index.php?error=no_url");
}
include('footer.php');
?>
