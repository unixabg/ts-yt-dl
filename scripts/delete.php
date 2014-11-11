<?php
require_once("./functions.php");
require('../../ts-yt-dl-defaults/ts-yt-dl');
login_check();
// Check if ts_id is set
if (isset($_GET['ts_id'])) {
	$ts_id = addslashes($_GET['ts_id']);
	$media_path = "$data_path/$userid/videos/$ts_id/";
	// Check if video exists
	if (is_dir("$media_path")) {
		// First we have to delete all files in the directory
		$media_dir = scandir("$media_path");
		$media_dir_count = count($media_dir);
		for ($x = 0; $x < $media_dir_count; $x++) {
			if ($media_dir[$x] != "." && $media_dir[$x] != "..") {
				unlink($media_path."/".$media_dir[$x]);
				echo $media_dir[$x];
			}
		}
		rmdir($media_path);
		$date = date("Y-m-d H:i:s");
		file_put_contents($data_path."/".$userid['userid']."/user.log", "[$date]\tDeleted file \"$media_path\".\n", FILE_APPEND);
		header("Location: ./videos.php");
	} else {
		echo "Could not find file on server.";
	}
} else {
	echo "No data was entered.";
}
?>
