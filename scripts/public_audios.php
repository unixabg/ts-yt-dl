<?php
include("./header.php");
echo "<link rel=\"stylesheet\" href=\"./style/content_list.css\">";
$userid = $_SESSION['userid'];
// Scan the user's audio folder for timestamp directories
$timestamp= scandir("$public_path/audios/");
$timestamp_count = count($timestamp);
echo "<div id=\"content\">
		<h1 class=\"header\">Public Audios</h1>
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
			// Scan each timestamp folder for the audio
			$audio = scandir("$public_path/audios/".$timestamp[$t]);
			$audio_count = count($audio);
			for ($a = 0; $a < $audio_count; $a++) {
				// Skip over the "." and ".." files
				if ($audio[$a] != "." && $audio[$a] != "..") {
					$ext = pathinfo($audio[$a], PATHINFO_EXTENSION);
					// Exclude the image and log file
					if ($ext != 'jpg' && $audio[$a] != 'log') {
						echo "<tr>";
							echo "<td class=\"medium_cell\">".$timestamp[$t]."</td>";
							if ($ext == 'part') {
								echo "<td class=\"large_cell\"><h4 class=\"media_title\">Processing</h4></td>";
							} else {
								echo "<td class=\"large_cell\"><a href=\"./play_media.php?timestamp=".$timestamp[$t]."&media=".$audio[$a]."&page=audios\"><h4 class=\"media_title\">&#9658 ".$audio[$a]."</h4></a></td>";
							}
							echo "<td class=\"medium_cell\">". number_format(filesize("$public_path/audios/".$timestamp[$t]."/".$audio[$a]) / 1024, 2) ." KB</td>";
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
