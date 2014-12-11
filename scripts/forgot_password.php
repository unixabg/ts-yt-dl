<!DOCTYPE html>
<html>
<head>
	<title>TimeShifter-YouTube-DownLoader</title>
	<link rel="stylesheet" type="text/css" href="./style/main.css">
	<link rel="stylesheet" href="./style/login.css">
</head>
<div id="banner">
	<h1>TS-YT-DL</h1>
</div>
<body>
	<div id="content">
		<h2 class="h2_title">Recover Password</h2>
		<div class="login_box">
			<form action="./password_recover.php" method="POST">
				<input class="login_input" type="text" name="email" placeholder="Email"/>
				<input class="login_submit" type="submit" value="Send">
			</form>
		</div>
<?php
require('../../ts-yt-dl-defaults/ts-yt-dl');
include("footer.php");
?>
