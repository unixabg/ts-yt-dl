<!DOCTYPE html>
<html>
<head>
	<title>TimeShifter-YouTube-DownLoader</title>
	<link rel="stylesheet" type="text/css" href="./style/main.css">
</head>
<div id="banner">
	<h1 class="logo"><a href="./home.php">TS-YT-DL</a></h1>
	<?php
	require_once("./functions.php");
	login_check();
	if (isset($userid)) {
	echo "<form class=\"search\" action=\"search.php\" method=\"GET\">
			<input class=\"search_input\" type=\"text\" name=\"search\" placeholder=\"Search\">
			<input class=\"search_submit\" type=\"submit\" value=\"Search\">
			</form>
		<a class=\"logout\" href=\"./logout.php\">Logout</a>
		</div>
		<nav>
				<ul>
					<li><a href=\"./home.php\">Home</a></li>
					<li><a href=\"./audios.php\">Audios</a></li>
					<li><a href=\"./videos.php\">Videos</a></li>
					<li><a href=\"\">My Account</a></li>";
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
