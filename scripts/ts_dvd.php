<?php
session_start();
$userid = $_SESSION['userid'];
require('../../ts-yt-dl-defaults/ts-yt-dl');
$video = scandir("$data_path/$userid/videos/");
foreach ($video as $timestamp) {
	if (isset($_POST[$timestamp])) {
		echo $timestamp."<br />";
	}
}
?>
