<?php
require("header.php");
require('../../ts-yt-dl-defaults/ts-yt-dl');
require_once('../../ts-yt-dl-defaults/mysql_security');
$userid = $_SESSION['userid'];
$url = addslashes($_POST['url']);
$dtype = addslashes($_POST['dtype']);
$status = "Attempting a time shift for ";
if (!empty($url) && filter_var($url, FILTER_VALIDATE_URL)) {
	// write to file
	$ip = $_SERVER['REMOTE_ADDR'];
	$timestamp = date('YmdHis');
	$date = date("Y-m-d H:i:s");
	if ($dtype == "video") {
		//download video
		if ( mkdir("$data_path/$userid/videos/$timestamp", 0755, true) ) {
			$title = exec("youtube-dl --get-title $url");
			$title = preg_replace("/[^a-zA-Z0-9:#!,. ]+/", "", $title);
			// echo "$title";
			if(strlen(trim($title)) > 0){
				// $title has at least one non-space character
				// then start the download process.
				$thumbnail = exec("youtube-dl --get-thumbnail $url");
				//echo "$data_path/$userid/videos/$timestamp/$title.mp4";
				file_put_contents("$data_path/$userid/videos/$timestamp/log", "Timestamp = $timestamp\nRemote IP = $ip\nDownload Type = $dtype\nVideo URL = $url\n");
				exec("nohup youtube-dl --write-thumbnail -o \"$data_path/$userid/videos/$timestamp/$title.mp4\" $url >> \"$data_path/$userid/videos/$timestamp/log\" &");
				$status = $status."\"".$title.".mp4\"";
				file_put_contents("$data_path/$userid/user.log", "[$date]\tDownloaded video \"$url\".\n", FILE_APPEND);
			} else {
				// No info in $title.
				file_put_contents("$data_path/$userid/videos/$timestamp/log", "Timestamp = $timestamp\nRemote IP = $ip\nDownload Type = $dtype\nVideo URL = $url\nError -- No title downloaded!!\n");
				$status = "Error -- No title downloaded!!";
				$thumbnail = './error.png';
				file_put_contents("$data_path/$userid/user.log", "[$date]\tFailed downloading video for \"$url\".\n", FILE_APPEND);
			}
		} else {
			$status = "Failed to create directory for video!";
			$thumbnail = './error.png';
		}
	} elseif ($dtype == "audio"){
		//download audio only
		if ( mkdir("$data_path/$userid/audios/$timestamp", 0755, true) ) {
			$title = exec("youtube-dl --get-title $url");
			$title = preg_replace("/[^a-zA-Z0-9:#!,. ]+/", "", $title);
			if(strlen(trim($title)) > 0){
				// $title has at least one non-space character
				// then start the download process.
				$thumbnail = exec("youtube-dl --get-thumbnail $url");
				file_put_contents("$data_path/$userid/audios/$timestamp/log", "Timestamp = $timestamp\nRemote IP = $ip\nDownload Type = $dtype\nVideo URL = $url\n");
				exec("nohup youtube-dl --extract-audio --audio-format mp3 --write-thumbnail -o \"$data_path/$userid/audios/$timestamp/$title.mp4\" $url >> \"$data_path/$userid/audios/$timestamp/log\" &");
				$status = $status."\"".$title.".mp3\"";
				file_put_contents("$data_path/$userid/user.log", "[$date]\tDownloaded audio \"$url\".\n", FILE_APPEND);
			} else {
				// No info in $title.
				file_put_contents("$data_path/$userid/audios/$timestamp/log", "Timestamp = $timestamp\nRemote IP = $ip\nDownload Type = $dtype\nVideo URL = $url\nError -- No title downloaded!!\n");
				$status = "Error -- No title downloaded!!";
				$thumbnail = './error.png';
			}
		} else {
			$status = "Failed to create directory for audio!";
			$thumbnail = './error.png';
			file_put_contents("$data_path/$userid/user.log", "[$date]\tFailed downloading audio for \"$title\".\n", FILE_APPEND);
		}
	} else {
		$status = "Error -- Invalid dtype variable passed!";
		$thumbnail = './error.png';
	}
	echo "<div id=\"content\">
	<img class=\"thumbnail\" src=\"$thumbnail\">
	<h4>$status</h4>
	</div>";
} else {
	header("Location: ./index.php?error=no_url");
}
include('footer.php');
?>
