<?php
session_start();
if ($_SESSION['authorized'] != 10) {
	header('Location: ./home.php');
	exit;
}
include("./header.php");
require("./mysql_connect.php");
echo "<script src=\"./js/jquery-2.1.1.min.js\"></script>";
echo "<script src=\"./js/admin_page.js\"></script>";
echo "<link rel=\"stylesheet\" href=\"./style/admin.css\">";
echo "<body>
	<div id=\"content\">
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
						User: ".$row['userid']."
						<form action=\"./user_edit.php?action=approve\" method=\"POST\">
							<input type=\"hidden\" value=\"".$row['userid']."\" name=\"userid\">
							<select name=\"status\">
								<option value=\"0\">Pending</option>
								<option value=\"1\">Approve</option>
								<option value=\"5\">Lock</option>
								<option value=\"10\">Admin</option>
							</select>
							<input type=\"submit\" class=\"submit\" value=\"Save Changes\">
						</form>
						<button class=\"cancel\" rowid=\"$x\">Cancel</button>
					</div>";
		}
echo "</table>";

