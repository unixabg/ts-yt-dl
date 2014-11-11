<?php
require_once('./mysql_connect.php');
require('../../ts-yt-dl-defaults/ts-yt-dl');
if (isset($_POST['first_name'], $_POST['last_name'], $_POST['username'], $_POST['email'], $_POST['password'], $_POST['password_confirm']) && $_POST['password'] == $_POST['password_confirm']) {
	if (!empty($_POST['first_name']) && !empty($_POST['last_name']) && !empty($_POST['username']) && !empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['password_confirm'])) {
		$email = mysqli_real_escape_string($db, $_POST['email']);
		$first_name = mysqli_real_escape_string($db, $_POST['first_name']);
		$last_name = mysqli_real_escape_string($db, $_POST['last_name']);
		$username = mysqli_real_escape_string($db, $_POST['username']);
		$password = mysqli_real_escape_string($db, md5($_POST['password']));

		$query = "INSERT INTO users (email, password, firstname, lastname, username, authorized) VALUES (\"$email\", \"$password\", \"$first_name\", \"$last_name\", \"$username\", \"0\")";
		$result = $db->query($query);
		if ($result) {
			$get_id = "SELECT userid FROM users WHERE username = \"$username\"";
			$id_result = $db->query($get_id);
			$user_id = $id_result->fetch_assoc();
			// Make a folder for the user
			$date = date("Y-m-d H:i:s");
			$message = "[$date]\tUser requested authorization for account.\n";
			if ( !is_dir("$data_path/".$user_id['userid']) ) {
				mkdir("$data_path/".$user_id['userid']."/", 0755, true);
			}
			file_put_contents($data_path."/".$user_id['userid']."/user.log", $message);
			header('Location: ./test.php');
		} else {
			echo "Error adding user.";
		}
	} else {
		echo "All forms were not submited.";
	}
} else {
	echo "All forms were not submited.";
}
?>
