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
	<?php
	require('../../ts-yt-dl-defaults/ts-yt-dl');
	echo "<h2 class=\"h2_title\">Sign Up</h2>";
	echo "<div class=\"login_box\">
			<form action=\"add_user.php\" method=\"POST\">
				<input class=\"login_input\" type=\"text\" name=\"first_name\" placeholder=\"First Name\"/>
				<input class=\"login_input\" type=\"text\" name=\"last_name\" placeholder=\"Last Name\"/>
				<input class=\"login_input\" type=\"text\" name=\"username\" placeholder=\"Username\"/>
				<input class=\"login_input\" type=\"text\" name=\"email\" placeholder=\"Email Address\"/>
				<input class=\"login_input\" type=\"password\" name=\"password\" placeholder=\"Password\"/>
				<input class=\"login_input\" type=\"password\" name=\"password_confirm\" placeholder=\"Password Confirm\"/>
				<input class=\"login_submit\" type=\"submit\" value=\"Sign Up\">
			</form>
		</div>
	</div>";
	echo "<h3 class=\"h3_title\"><a href=\"sign_up.php\">Sign up</a></h3>";
	include("footer.php");
	?>
