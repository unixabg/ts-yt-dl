<?php
if (isset($_POST['username'], $_POST['password'])) {
	if (!empty($_POST['username']) && !empty($_POST['password'])) {
		require_once("./mysql_connect.php");
		$username = $_POST['username'];
		$password = md5($_POST['password']);
		$query = "SELECT * FROM users WHERE username = \"". $username . "\" AND password = \"". $password. "\"";
		$result = $db->query($query);
		if ($result->num_rows) {
			$row = $result->fetch_assoc();
			session_start();
			$_SESSION['username'] = $username;
			$_SESSION['userid'] = $row['userid'];;
			header('Location: ./home.php');
		} else {
			header('Location: ./index.php?error=invalid_user');
		}
	}
}
?>
