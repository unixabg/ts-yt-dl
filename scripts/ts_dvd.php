<?php
session_start();
$userid = $_SESSION['userid'];
$video = scandir("/srv/ts-yt-dl/$userid/videos/");
foreach ($video as $timestamp) {
	if (isset($_POST[$timestamp])) {
		echo $timestamp."<br />";
	}
}
?>
