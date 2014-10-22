<?php
require_once('./mysql_connect.php');
if (isset($_POST['first_name'], $_POST['last_name'], $_POST['username'], $_POST['email'], $_POST['password'], $_POST['password_confirm']) && $_POST['password'] == $_POST['password_confirm']) {
	if (!empty($_POST['first_name']) && !empty($_POST['last_name']) && !empty($_POST['username']) && !empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['password_confirm'])) {
		$email = $_POST['email'];
		$first_name = $_POST['first_name'];
		$last_name = $_POST['last_name'];
		$username = $_POST['username'];
		$password = md5($_POST['password']);

		$query = "INSERT INTO users (email, password, firstname, lastname, username) VALUES (\"$email\", \"$password\", \"$first_name\", \"$last_name\", \"$username\")";
		$result = $db->query($query);
		if ($result) {
			session_start();
			$get_id = "SELECT userid FROM users WHERE username = \"$username\"";
			$id_result = $db->query($get_id);
			$user_id = $id_result->fetch_assoc();
			$_SESSION['username'] = $username;
			$_SESSION['userid'] = $user_id['userid'];
			header('Location: ./home.php');
		}else {
			echo "Error adding user.";
		}
	} else {
		echo "All forms were not submited.";
	}
} else {
	echo "All forms were not submited.";
}
?>
