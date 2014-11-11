<?php
require("./functions.php");
login_check();
if ($_SESSION['authorized'] != 10) {
	header('Location: ./home.php');
	exit;
}
require("./mysql_connect.php");
require('../../ts-yt-dl-defaults/ts-yt-dl');
if (isset($_POST['action']) && isset($_POST['userid'])) {
	$date = date("Y-m-d H:i:s");
	$action =  $_POST['action'];
	$cust_id = $_POST['userid'];
	$status = $_POST['status'];
	$username = $_POST['username'];
	if ($action == "Save Changes") {
		$query = "UPDATE users SET authorized = $status, username = \"$username\" WHERE userid = $cust_id";
		$update_user = $db->query($query);
		if ($update_user) {
			file_put_contents("$data_path/$cust_id/user.log","[$date]\tUser status changed to \"$status\".\n", FILE_APPEND);
			file_put_contents("$admin_log", "[$date] Admin $userid: Changed user \"$cust_id\" status to \"$status\".\n", FILE_APPEND);
			header("Location: ./admin.php");
		}
	} elseif ($action == "Delete") {
		if ($userid == $cust_id) {
			echo "You cannot delete your own account.";
			exit;
		}
		$userdir = "$data_path/$cust_id/";
		delete_file( $userdir );
		$query = "DELETE FROM users WHERE userid = $cust_id";
		$delete = $db->query($query);
		if ($delete) {
			file_put_contents("$admin_log", "[$date] Admin $userid: Deleted user \"$cust_id\".\n", FILE_APPEND);
			header("Location: ./admin.php");
		}
	} else {
		echo "Action not reconized.";
	}
} else {
	echo "Error";
}
?>
