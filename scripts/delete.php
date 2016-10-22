<?php
require('../../ts-yt-dl-defaults/ts-yt-dl');
require_once("./functions.php");
login_check();
// Check if ts_id is set
if (isset($_GET['ts_id'])) {
	$ts_id = addslashes($_GET['ts_id']);
	$media_type = addslashes($_GET['media_type']);
	if ($_GET['public']) {
		// Only admin users can delete public media
		if ($_SESSION['authorized'] == 10) {
			$media_path = "$public_path/$media_type/$ts_id/";
		} else {
			echo "Only administrators may delete public media.";
			exit;
		}
	} else {
		// Normal media delete request
		$media_path = "$data_path/$userid/$media_type/$ts_id/";
	}
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
		if ($_GET['public']) {
			file_put_contents($public_path."/user.log", "[$date]\tUserID $userid - Deleted file \"$media_path\".\n", FILE_APPEND);
			header("Location: ./public_$media_type.php");
		} else {
			file_put_contents($data_path."/".$userid['userid']."/user.log", "[$date]\tDeleted file \"$media_path\".\n", FILE_APPEND);
			header("Location: ./$media_type.php");
		}
	} else {
		echo "Could not find file on server.";
	}
} else {
	echo "No data was entered.";
}
?>
