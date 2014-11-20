<?php
include("./header.php");
require('../../ts-yt-dl-defaults/ts-yt-dl');
$timestamp = $_GET['timestamp'];
$video = addslashes($_GET['video']);
echo "<body>
		<div id=\"content\">
			<div class=\"video_player\">
				<h1 class=\"header\">$video</h1>
				<video width=\"520\" height=\"340\" controls>
					<source src=\"./local_download.php?timestamp=$timestamp&video=$video\"/>
				</video>
				<a class=\"download_link\" href=\"./local_download.php?timestamp=$timestamp&video=$video\">Download</a>
			</div>";
?>
