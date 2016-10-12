<?php
include("header.php");
require_once("./mysql_connect.php");
if (isset($_POST['first_name']) && isset($_POST['last_name']) && isset($_POST['email'])) {
	if (strtolower($_SESSION['username']) != 'demo') {
		$email = addslashes($_POST['email']);
		$check_email = "SELECT email FROM users WHERE email = \"$email\" AND userid != $userid";
		$check_result = $db->query($check_email);
		$check = $check_result->num_rows;
		if ($check != 0) {
			echo "Email is already in use.";
			exit;
		}
		$first_name = addslashes($_POST['first_name']);
		$last_name = addslashes($_POST['last_name']);
		$edit_info = "UPDATE users SET firstname = \"$first_name\", lastname = \"$last_name\", email = \"$email\" WHERE userid = $userid";
		$run_edit = $db->query($edit_info);
		if ($run_edit) {
			header("Location: ./account.php?status=Account information updated");
		} else {
			echo "Error occured connecting to database";
		}
	} else {
		echo "This account can not be altered.";
	}
} else {
	$get_info = "SELECT * FROM users WHERE userid = $userid";
	$info_result = $db->query($get_info);
	$info = $info_result->fetch_assoc();
	if (strtolower($info['username']) != "demo") {
		echo "
					<div id=\"content\">
						<form action=\"".$_SERVER['PHP_SELF']."\" method=\"POST\">
							<input type=\"text\" name=\"first_name\" placeholder\"First Name\" value=\"".$info['firstname']."\"/>
							<input type=\"text\" name=\"last_name\" placeholder\"Last Name\" value=\"".$info['lastname']."\"/>
							<input type=\"submit\" value=\"Save Changes\"/>
						</form>
					</div>";
	} else {
		echo "This account can not be altered.";
	}
}
?>
