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
		<?php
		require_once("./functions.php");
		require('../../ts-yt-dl-defaults/ts-yt-dl');
		require("./mysql_connect.php");
		if (isset($_POST['email']) && !empty($_POST['email'])) {
			$email = $_POST['email'];
			if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
				$check_email = "SELECT * FROM users WHERE email = \"$email\"";
				$email_rs = $db->query($check_email);
				$user_info = $email_rs->fetch_assoc();
				if ($user_info >= 1) {
					$salt = $user_info['password'];
					// We use a combination of the current password and userid to send a key to thier email
					$encypt = md5("$salt".$user_info['userid']);
					$link = "<a href=\"http://$_SERVER[HTTP_HOST]/password_recover.php?encypt=$encypt\">Reset Password</a>";
					$email = $user_info['email'];
					$subject = "Forgot Password";
					$headers = "From: $from \r\n";
					$headers .= "MIME-Version: 1.0\r\n";
					$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
					$body = "Hello ".$user_info['firstname']." ".$user_info['lastname']."<br /> Your account requested a password reset here is the link to reset it:<br /> $link";
					mail($email, $subject, $body, $headers);
					echo "<center>A link for reseting your password was sent to your email.</center>";
					// Use for debuggin
					//echo $link;
				} else {
					echo "Acount with email \"$email\" was not found. You can sign up here: <a href=\"./sign_up.php\">Sign up</a>";
				}
			} else {
				echo "The email entered was not valied.<a href=\"./index.php\">TS-YT-DL</a>";
			}
		} elseif (isset($_GET['encypt']) && !empty($_GET['encypt'])) {
			echo "<div class=\"login_box\">
				<form action=\"./password_reset.php\" method=\"POST\">
					<input class=\"login_input\" type=\"password\" name=\"password\" placeholder=\"New Password\"/>
					<input class=\"login_input\" type=\"password\" name=\"confirm_password\" placeholder=\"Confirm Password\"/>
					<input type=\"hidden\" name=\"hash\" value=\"".$_GET['encypt']."\"/>
					<input class=\"login_submit\" type=\"submit\" value=\"Reset\">
				</form>
			</div>";
		}
		echo "</div>";
		include("footer.php");
		?>
