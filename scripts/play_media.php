<?php
include("./header.php");
$timestamp = $_GET['timestamp'];
$media = addslashes($_GET['media']);
$page = $_GET['page'];
$public = $_GET['public'];
echo "<div id=\"content\">";
if ($_GET['page'] == "videos") {
	echo "<div class=\"video_player\">
					<h1 class=\"header\">$media</h1>
					<video width=\"520\" height=\"340\" controls>
						<source src=\"./local_download.php?timestamp=$timestamp&media=$media&page=$page&public=$public\" type=\"video/mp4\"/>
					</video>
					<a class=\"download_link\" href=\"./local_download.php?timestamp=$timestamp&media=$media&page=$page&public=$public\">Download</a>";
} else {
	echo "<div class=\"video_player\">
					<h1 class=\"header\">$media</h1>
					<audio class=\"audio_player\" controls>
						<source src=\"./local_download.php?timestamp=$timestamp&media=$media&page=$page&public=$public\" type=\"audio/mpeg\"/>
					Your browser does not support the audio element.
					</audio>
	<a class=\"download_link\" href=\"./local_download.php?timestamp=$timestamp&media=$media&page=$page&public=$public\">Download</a>";
}
echo "</div>
</div>";
include("footer.php");
?>
