<?php
require_once('../../../../php_scripts/mysql_connect.php');
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
		header('Location: ./index.php');
		$_SESSION['username'] = $username;
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
