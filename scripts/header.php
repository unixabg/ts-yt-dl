<!DOCTYPE html>
<html>
<head>
	<title>TimeShifter-YouTube-DownLoader</title>
	<link rel="stylesheet" type="text/css" href="./style/main.css">
</head>
<div id="banner">
	<h1>TS-YT-DL</h1>
</div>
	<?php
	session_start();
	if (isset($_SESSION['username'])) {
		echo "<nav>
				<ul>
					<li><a href=\"\">Home</a></li>
					<li><a href=\"\">Videos</a></li>
					<li><a href=\"\">My Account</a></li>
					<li><a href=\"\">Link</a></li>
				</ul>
			</nav>";
	echo "<a href=\"./logout.php\">Logout</a>";
	}
	?>
