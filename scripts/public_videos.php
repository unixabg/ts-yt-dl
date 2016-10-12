<?php
include("./header.php");
echo "<link rel=\"stylesheet\" href=\"./style/content_list.css\">";
$userid = $_SESSION['userid'];
// Scan the user's video folder for timestamp directories
$timestamp= scandir("$public_path/videos/");
$timestamp_count = count($timestamp);
echo "<body>
	<div id=\"content\">
		<h1 class=\"header\">Public Videos</h1>
			<table id=\"media_table\">
				<tr>
					<th class=\"medium_cell\"><h4>TS Ref. Number</h4></th>
					<th class=\"large_cell\"><h4>Title</h4></th>
					<th class=\"medium_cell\"><h4>File Size</h4></th>
					<th class=\"small_th\"></th>
				</tr>";
	for ($t = 0; $t < $timestamp_count; $t++) {
		// Skip over the "." and ".." files
		if ($timestamp[$t] != "." && $timestamp[$t] != "..") {
			// Scan each timestamp folder for the video
			$video = scandir("$public_path/videos/".$timestamp[$t]);
			$video_count = count($video);
			for ($v = 0; $v < $video_count; $v++) {
				// Skip over the "." and ".." files
				if ($video[$v] != "." && $video[$v] != "..") {
					$ext = pathinfo($video[$v], PATHINFO_EXTENSION);
					// Exclude the image and log file
					if ($ext != 'jpg' && $video[$v] != 'log') {
						echo "<tr>";
							echo "<td class=\"medium_cell\">".$timestamp[$t]."</td>";
							if ($ext == 'part') {
								echo "<td class=\"large_cell\"><h4 class=\"media_title\">Processing</h4></td>";
							} else {
								echo "<td class=\"large_cell\"><a href=\"./play_media.php?timestamp=".$timestamp[$t]."&media=".$video[$v]."&page=videos&public=true\"><h4 class=\"media_title\">&#9658 ".$video[$v]."</h4></a></td>";
							}
							echo "<td class=\"medium_cell\">". number_format(filesize("$public_path/videos/".$timestamp[$t]."/".$video[$v]) / 1024, 2) ." KB</td>";
						echo "</tr>";
					}
				}
			}
		}
	}
echo "</table>
	</div>";
include("footer.php");
?>
