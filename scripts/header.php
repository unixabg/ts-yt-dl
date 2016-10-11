<!DOCTYPE html>
<html>
<head>
	<title>TimeShifter-YouTube-DownLoader</title>
	<link rel="stylesheet" type="text/css" href="./style/main.css">
</head>
<body>
<div id="banner">
	<h1 class="logo"><a href="./home.php">TS-YT-DL</a></h1>
	<?php
	require_once("./functions.php");
	require("./mysql_connect.php");
	login_check();
	if (isset($userid)) {
		$query_username = "SELECT firstname, lastname FROM users WHERE userid = $userid";
		$result = $db->query($query_username);
		$user = $result->fetch_assoc();
		$name = $user['firstname']." ".$user['lastname'];
		echo "<form class=\"search\" action=\"search.php\" method=\"GET\">
				<input class=\"search_input\" type=\"text\" name=\"search\" placeholder=\"Search\">
				<input class=\"search_submit\" type=\"submit\" value=\"Search\">
				</form>
				<p class=\"full_name\">Hello, $name</p>
				<a class=\"logout\" href=\"./logout.php\">Logout</a>
			</div>
			<nav>
					<ul>
						<li><a href=\"./home.php\">Home</a></li>
						<li><a href=\"./audios.php\">Audios</a></li>
						<li><a href=\"./videos.php\">Videos</a></li>";
						if ( is_dir($public_path) ) {
							echo "<li><a href=\"./public_audios.php\">Public Audios</a></li>
							<li><a href=\"./public_videos.php\">Public Videos</a></li>";
						}
						echo "<li><a href=\"./account.php\">My Account</a></li>";
						if ($_SESSION['authorized'] == 10) {
							echo "<li><a href=\"./admin.php\">Admin</a></li>";
						}
						echo "<li><a href=\"./support.php\">Support</a></li>
					</ul>
				</nav>";
	} else {
		echo "</div>";
	}
	?>
