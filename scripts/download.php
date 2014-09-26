<?php
include("header.php");
require_once('./mysql_connect.php');
require_once("functions.php");
login_check();
session_start();
$userid = $_SESSION['userid'];
$url = $_POST['url'];
$parm = $_POST['parm'];
$thumbnail = exec("youtube-dl --get-thumbnail $url");
if (!empty($url) && filter_var($url, FILTER_VALIDATE_URL)) {
	// write to file
	$query = "INSERT INTO videos (userid, url) VALUES ($userid, \"$url\")";
	$result = $db->query($query);
	$ip = $_SERVER['REMOTE_ADDR'];
	if (!$result) {
		echo "Database error. Please try agian.";
	}
	$timestamp = date('YmdHis');
	if (!mkdir("$ts-yt-dl_data_path/$userid/$timestamp", 0755, true)) {
	    die('Failed to create folders...');
	}
	//file_put_contents("/srv/ts-yt-dl/tmp/$timestamp.ts", "_USERID=\"$userid\"\n_TSCALL=\"$parm $url\"\n_REMOTEADDR=\"$ip\"");
	exec("youtube-dl -o $ts-yt-dl_data_path/$userid/$timestamp $parm $url");
	echo "<body>
	<div id=\"content\">
	<img class=\"thumbnail\" src=\"$thumbnail\">
	</div>";
} else {
	header("Location: ./index.php?error=no_url");
}
include('footer.php');
?>
