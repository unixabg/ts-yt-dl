<?php
include("./header.php");
require('../../ts-yt-dl-defaults/ts-yt-dl');
echo "<link rel=\"stylesheet\" href=\"./style/content_list.css\">";
$userid = $_SESSION['userid'];
// Scan the user's video folder for timestamp directories
$timestamp= scandir("$data_path/$userid/videos/");
$timestamp_count = count($timestamp);
echo "<body>
	<div id=\"content\">
		<h1 class=\"header\">Videos</h1>
		<form action=\"./ts_dvd.php\" method=\"POST\">
			<table id=\"media_table\">
				<tr>
					<th></th>
					<th class=\"medium_cell\"><h4>TS Ref. Number</h4></th>
					<th class=\"large_cell\"><h4>Title</h4></th>
					<th class=\"medium_cell\"><h4>File Size</h4></th>
					<th class=\"small_th\"></th>
				</tr>";
	for ($t = 0; $t < $timestamp_count; $t++) {
		// Skip over the "." and ".." files
		if ($timestamp[$t] != "." && $timestamp[$t] != "..") {
			// Scan each timestamp folder for the video
			$video = scandir("$data_path/$userid/videos/".$timestamp[$t]);
			$video_count = count($video);
			for ($v = 0; $v < $video_count; $v++) {
				// Skip over the "." and ".." files
				if ($video[$v] != "." && $video[$v] != "..") {
					$ext = pathinfo($video[$v], PATHINFO_EXTENSION);
					// Exclude the image and log file
					if ($ext != 'jpg' && $video[$v] != 'log') {
						echo "<tr>";
							echo "<td><input type=\"checkbox\" name=\"".$timestamp[$t]."\" value=\".".$timestamp[$t]."\"></td>";
							echo "<td class=\"medium_cell\">".$timestamp[$t]."</td>";
							echo "<td class=\"large_cell\"><a href=\"./play_media.php?timestamp=".$timestamp[$t]."&media=".$video[$v]."&page=videos\"><h4 class=\"media_title\">&#9658 ".$video[$v]."</h4></a></td>";
							echo "<td class=\"medium_cell\">". number_format(filesize("$data_path/$userid/videos/".$timestamp[$t]."/".$video[$v]) / 1024, 2) ." KB</td>";
							echo "<td class=\"small_cell\"><a onclick=\"return confirm('Are you sure you to delete this?')\" href=\"./delete.php?ts_id=".$timestamp[$t]."&media_type=videos\" class=\"saltire\" > Delete</a></td>";
						echo "</tr>";
					}
				}
			}
		}
	}
echo "</table>";
echo "		<input class=\"download_submit\" type=\"submit\" value=\"Time Shift to DVD (FIXME)\">
	</form>";
?>
