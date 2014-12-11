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
		<h2 class="h2_title">Password Recovery</h2>
<?php
if (isset($_POST['password']) && isset($_POST['confirm_password']) && !empty($_POST['password']) && !empty($_POST['confirm_password'])) {
	require_once("./functions.php");
	require("./mysql_connect.php");
	require('../../ts-yt-dl-defaults/ts-yt-dl');
	$encypt = addslashes($_POST['hash']);
	$password = md5($_POST['password']);
	$pass_confirm = md5($_POST['password']);
	if ($password == $pass_confirm) {
		// Match md5(password+id) and $encypt to get the userid for the user trying to reset their password
		$get_user = "SELECT * FROM users WHERE md5(CONCAT(password,userid)) = \"$encypt\"";
		$email_rs = $db->query($get_user);
		$info = $email_rs->fetch_assoc();
		if (count($info) >= 1) {
			$password = "UPDATE users SET password = \"$password\" WHERE userid = ".$info['userid'];
			$password_reset = $db->query($password);
			if ($password_reset) {
				echo "Your password was reset. You can go <a href=\"./index.php\">here</a> to login.";
			} else {
				echo "Could not reset password at this time. Please try again.<a href=\"./index.php\">Home</a>";
			}
		} else {
			$status = "The key provided was not valid. Please try again later. <a href=\"./index.php\">TS-YT-DL</a>";
			echo $status;
		}
	} else {
		$status = "Passwords did not match.";
			echo $status;
	}
} else {
	echo "Not all data was entered";
}
?>
