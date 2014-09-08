<?php
include("header.php");
require_once("functions.php");
login_check();
session_start();
$userid = $_SESSION['userid'];
// beginning of test
$url = $_POST['url'];
$thumbnail = exec("youtube-dl --get-thumbnail $url");
$title = exec("youtube-dl --get-title $url"); 
//exec("youtube-dl -o \"./videos/$userid/$title.mp4\" $url");
// write to file
$timestamp = date('Ymdis');
file_put_contents("/srv/ts-yt-dl/tmp/$timestamp.ts", "$userid|$url");
echo "$timestamp $userid $url";
echo "<body>
	<div id=\"content\">
		<img class=\"thumbnail\" src=\"$thumbnail\">
	</div>";

include('footer.php');
?>
