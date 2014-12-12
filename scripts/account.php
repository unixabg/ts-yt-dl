<?php
include("./header.php");
require('../../ts-yt-dl-defaults/ts-yt-dl');
require_once("./mysql_connect.php");
echo "<script src=\"./js/jquery-2.1.1.min.js\"></script>";
echo "<script src=\"./js/account.js\"></script>";
echo "<script src=\"./js/status_box.js\"></script>";
$user_info = "SELECT * FROM users WHERE userid = $userid";
$result = $db->query($user_info);
$info = $result->fetch_assoc();
if (isset($_GET['status']) && !empty($_GET['status'])) {
	$status = addslashes($_GET['status']);
	echo "<div class=\"status_box\">
			$status
			</div>";
}
echo "<div id=\"content\">
				<form action=\"./account_edit.php\" method=\"POST\">
				<div class=\"user_info\">
					<h2 class=\"user_header\">User Information</h1>
					<h4 id=\"name\" class=\"user_h4\" >Name: <div class=\"first_name\">".$info['firstname']." </div><div class=\"last_name\">".$info['lastname']."</div></h4>
					<h4 class=\"user_h4\"id=\"email\">Email: <div class=\"email\">".$info['email']."</div></h4>
					<h5 class=\"user_h5\" id=\"edit\"><a class=\"account_edit\" href=\"./account_edit.php\">Edit Information</a></h5>
					<h5 class=\"user_h5\"><a href=\"./password_edit.php\">Change Password</a></h5>
				</div>
			</form>
		</div>
	</div>";
include("footer.php");
?>
