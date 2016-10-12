<?php
require_once('./mysql_connect.php');
if (isset($_POST['first_name'], $_POST['last_name'], $_POST['username'], $_POST['email'], $_POST['password'], $_POST['password_confirm']) && $_POST['password'] == $_POST['password_confirm']) {
	if (!empty($_POST['first_name']) && !empty($_POST['last_name']) && !empty($_POST['username']) && !empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['password_confirm'])) {
		$email = mysqli_real_escape_string($db, $_POST['email']);
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			echo "The email entered was not valied. Please try again with another email.";
			echo "<META http-equiv=\"refresh\" content=\"7;URL=./\">";
			exit;
		}
		$first_name = mysqli_real_escape_string($db, $_POST['first_name']);
		$last_name = mysqli_real_escape_string($db, $_POST['last_name']);
		$username = mysqli_real_escape_string($db, $_POST['username']);
		$password = mysqli_real_escape_string($db, md5($_POST['password']));
		if ($authorize != "true") {
			$status = 1;
		} else {
			$status = 0;
		}
		// If this is the first user and setting up the account
		$scan_users = "SELECT username as total FROM users";
		$result = $db->query($scan_users);
		if ($result->num_rows == 0) {
			$status = 10;
		}

		// First check if username exists
		$check = "SELECT * FROM users WHERE username = \"$username\";";
		$check_result = $db->query($check);
		if ($check_result->num_rows >= 1) {
			echo "Username of ".$username." already exists. Please try again with another username.";
			echo "<META http-equiv=\"refresh\" content=\"7;URL=./\">";
			exit;
		}
		// Second only allow one username per email
		$check = "SELECT * FROM users WHERE email = \"$email\";";
		$check_result = $db->query($check);
		if ($check_result->num_rows >= 1) {
			echo "An email of ".$email." already exists in the system for some user account. Please try again with another email.";
			echo "<META http-equiv=\"refresh\" content=\"7;URL=./\">";
			exit;
		}

		// If we get here add the user
		$query = "INSERT INTO users (email, password, firstname, lastname, username, authorized) VALUES (\"$email\", \"$password\", \"$first_name\", \"$last_name\", \"$username\", \"$status\")";
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
				mkdir("$data_path/".$user_id['userid']."/audios/", 0755, true);
				mkdir("$data_path/".$user_id['userid']."/videos/", 0755, true);
			}
			file_put_contents($data_path."/".$user_id['userid']."/user.log", $message);
			// If this is the setup account or authorization is turned off send the user to the home page
			if ($status == 10 || $status == 1) {
				if (isset($_POST['authorize'])) {
					$auth = $_POST['authorize'];
					if ($auth == 'true') {
							// This is where we will be able to disable and enable user authorization  for admin
						}
				}
				$query = "SELECT * FROM users WHERE username = \"$username\"";
				$result = $db->query($query);
				$row = $result->fetch_assoc();
				session_start();
				$_SESSION['username'] = $username;
				$_SESSION['userid'] = $row['userid'];
				$_SESSION['authorized'] = $row['authorized'];
				$date = date("Y-m-d H:i:s");
				file_put_contents("/srv/ts-yt-dl/".$row['userid']."/user.log", "[$date]\tUser logged into account.\n", FILE_APPEND);
				header('Location: ./home.php');
			} else {
				header('Location: ./test.php');
			}
		} else {
			echo "Error adding account information! Please try again.";
			echo "<META http-equiv=\"refresh\" content=\"7;URL=./\">";
		}
	} else {
		echo "All forms were not submited.";
		echo "<META http-equiv=\"refresh\" content=\"7;URL=./\">";
	}
} else {
	echo "All forms were not submited.";
	echo "<META http-equiv=\"refresh\" content=\"7;URL=./\">";
}
?>
