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
	require_once('./mysql_connect.php');
	$scan_users = "SELECT username as total FROM users";
	$result = $db->query($scan_users);
	if ($result->num_rows != 0) {
		header("Location: ./index.php");
		exit();
	}
	session_start();
	if (isset($_SESSION['username']) && !empty($_SESSION['username'])) {
		header("Location: ./home.php");
	}
	echo "<h2 class=\"h2_title\">Set Up TS-YT-DL</h2>";
	?>
	<div class="login_box">
			<form action="./add_user.php" method="POST">
				<input class="login_input" type="text" name="first_name" placeholder="First Name"/>
				<input class="login_input" type="text" name="last_name" placeholder="Last Name"/>
				<input class="login_input" type="text" name="username" placeholder="Administrator Username"/>
				<input class="login_input" type="text" name="email" placeholder="Email"/>
				<input class="login_input" type="password" name="password" placeholder="Password"/>
				<input class="login_input" type="password" name="password_confirm" placeholder="Confirm Password"/>
				<input type="checkbox" name="authorize" value="true">Require User Accounts to be Authorizationed
				<input class="login_submit" type="submit" value="Begin">
			</form>
		</div>
	</div>
</body>
<?php
include("footer.php");
?>
