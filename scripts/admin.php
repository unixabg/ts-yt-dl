<?php
include("./header.php");
require('../../ts-yt-dl-defaults/ts-yt-dl');
if ($_SESSION['authorized'] != 10) {
	header('Location: ./home.php');
	exit;
}
require("./mysql_connect.php");
echo "<script src=\"./js/jquery-2.1.1.min.js\"></script>";
echo "<script src=\"./js/admin_page.js\"></script>";
echo "<link rel=\"stylesheet\" href=\"./style/admin.css\">";
$log = file_get_contents($admin_log);
$log = str_replace("\n", "<br />", $log);
echo "<div id=\"content\">
		<button class=\"log_button\">Show log</button>
		<div class=\"log\">
			<h1 class=\"box_header\">Admin Log</h1>
			<h2 class=\"cancel_log\">X</h2>
			<p>
				$log
			</p>
		</div>
		<table id=\"admin_table\">
			<tr>
				<th class=\"small_cell\">User Id</th>
				<th class=\"medium_cell\">Username</th>
				<th class=\"small_cell\">Status</th>
				<th class=\"\">Test</th>
			</tr>";
		$query = "SELECT * FROM users WHERE userid != $userid";
		$result = $db->query($query);
		$num = $result->num_rows;
		for ($x = 0; $x < $num; $x++) {
			$row = $result->fetch_assoc();
			if ($row['authorized'] == 0) {
				$color = "#F4FA58";
			} elseif ($row['authorized'] == 1) {
				$color = "#01DF01";
			} elseif ($row['authorized'] == 5) {
				$color = "#FE2E2E";
			} elseif ($row['authorized'] == 10) {
				$color = "#000000";
			}
			echo "<tr>
							<td class=\"small_cell\">".$row['userid']."</td>
							<td class=\"medium_cell\">".$row['username']."</td>
							<td class=\"small_cell\"><div class=\"status\" style='background:$color;'></div>".$row['authorized']."</td>
							<td class=\"\"><button class=\"user_edit\" rowid=\"$x\">Edit User</button></td>
					</tr>
					<div class=\"user_box\" rowid=\"$x\">
						<h1 class=\"box_header\">Edit User</h1>
						<p class=\"user\">User: ".$row['username']."</p>
						<form action=\"./user_edit.php\" method=\"POST\">
							<input type=\"hidden\" value=\"".$row['userid']."\" name=\"userid\">
							Username:<input type=\"text\" value=\"".$row['username']."\" name=\"username\"\>
							<select name=\"status\" class=\"drop_down\">
								<option value=\"0\">Pending</option>
								<option value=\"1\">Approve</option>
								<option value=\"5\">Lock</option>
								<option value=\"10\">Admin</option>
							</select>
							<input type=\"submit\" name=\"action\" onclick=\"return confirm('Are you sure you want to delete the users and all contents?')\" class=\"delete\" value=\"Delete\"/>
							<input type=\"submit\" name=\"action\" class=\"submit\" value=\"Save Changes\">
						</form>
						<button class=\"cancel\" rowid=\"$x\">Cancel</button>
					</div>";
		}
echo "</table>";
include("footer.php");
?>
