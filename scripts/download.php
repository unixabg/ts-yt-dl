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
		//download video
		if ( mkdir("$data_path/$userid/videos/$timestamp", 0755, true) ) {
			$title = exec("youtube-dl --get-title $url");
			if(strlen(trim($title)) > 0){
				// $title has at least one non-space character
				// then start the download process.
				$thumbnail = exec("youtube-dl --get-thumbnail $url");
				//echo "$data_path/$userid/videos/$timestamp/$title.mp4";
				file_put_contents("$data_path/$userid/videos/$timestamp/log", "Timestamp = $timestamp\nRemote IP = $ip\nDownload Type = $dtype\nVideo URL = $url\n");
				exec("nohup youtube-dl --write-thumbnail -o \"$data_path/$userid/videos/$timestamp/$title.mp4\" $url >> \"$data_path/$userid/videos/$timestamp/log\" &");
			} else {
				// No info in $title.
				file_put_contents("$data_path/$userid/videos/$timestamp/log", "Timestamp = $timestamp\nRemote IP = $ip\nDownload Type = $dtype\nVideo URL = $url\nError -- No title downloaded!!\n");
				$thumbnail = './error.png';
			}
		} else {
			echo "Failed to create directory for video!";
			$thumbnail = './error.png';
		}
	} elseif ($dtype == "audio"){
		//download audio only
		if ( mkdir("$data_path/$userid/audios/$timestamp", 0755, true) ) {
			$title = exec("youtube-dl --get-title $url");
			if(strlen(trim($title)) > 0){
				// $title has at least one non-space character
				// then start the download process.
				$thumbnail = exec("youtube-dl --get-thumbnail $url");
				file_put_contents("$data_path/$userid/audios/$timestamp/log", "Timestamp = $timestamp\nRemote IP = $ip\nDownload Type = $dtype\nVideo URL = $url\n");
				exec("nohup youtube-dl --extract-audio --audio-format mp3 --write-thumbnail -o \"$data_path/$userid/audios/$timestamp/$title.mp4\" $url >> \"$data_path/$userid/audios/$timestamp/log\" &");
			} else {
				// No info in $title.
				file_put_contents("$data_path/$userid/audios/$timestamp/log", "Timestamp = $timestamp\nRemote IP = $ip\nDownload Type = $dtype\nVideo URL = $url\nError -- No title downloaded!!\n");
				$thumbnail = './error.png';
			}
		} else {
			echo "Failed to create directory for audio!";
			$thumbnail = './error.png';
		}
	} else {
		echo "Invalid dtype variable passed!";
		$thumbnail = './error.png';
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
