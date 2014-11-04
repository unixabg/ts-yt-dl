<?php
session_start();
if ($_SESSION['authorized'] != 10) {
	header('Location: ./home.php');
	exit;
}
require("./functions.php");
login_check();
require("./mysql_connect.php");
require('../../ts-yt-dl-defaults/ts-yt-dl');
if (isset($_GET['action']) && isset($_POST['userid'])) {
	$action =  $_GET['action'];
	$cust_id = $_POST['userid'];
	$status = $_POST['status'];
	if ($action == "approve") {
		$query = "UPDATE users SET authorized = $status WHERE userid = $cust_id";
		$result = $db->query($query);
		if ($result) {
			header("Location: ./admin.php");
		}
	} elseif ($action == "delete") {
		//if ($userid == $cust_id) {
		//	echo "You cannot delete your own account.";
			//exit;
		//}
		$query = "DELETE FROM users WHERE userid = $cust_id";
		//$delete = $db->query($query);
		if ($rmdir) {
				echo "User was deleted.";
		}
			/*$userdir = scandir("$data_path/$cust_id/");
			$dir_count = count($userdir);
			for ($u = 0; $u < $dir_count; $u++) {
				if ($userdir[$u] != "." && $userdir[$u] != "..") {
					if (is_dir("$data_path/$cust_id/".$userdir[$u])) {
						$media_dir = scandir("$data_path/$cust_id/".$userdir[$u]);
						echo "$data_path/$cust_id/".$userdir[$u];
						$media_count = count($media_dir);
						echo $media_count;
						for ($m = 0; $m < $media_count; $m++) {
						}
					} elseif (is_file("$data_path/$cust_id/".$userid[$u])) {
							//unlink("$data_path/$cust_id/".$userid[$u]);
					}
				}
			}
			//echo "User was deleted.";
		//}*/
	} else {
		echo "Action not reconized.";
	}
}
?>
