<?php
include("header.php");
echo "<div id=\"content\">";
		if (isset($_GET['error'])) {
			if ($_GET['error'] == "no_url") {
				echo "<p class=\"error\">Invalid URL</p>";
			}
		}
			echo "<div class=\"url_box\">
			<form action=\"download.php\" method=\"POST\">
				<input class=\"url_input\" type=\"text\" name=\"url\" placeholder=\"url\"/>
				<input class=\"url_submit\" type=\"submit\" value=\"Download\">
			</div>
			<p class=\"radio_input\">
				Video: <input lable=\"High\" type=\"radio\" name=\"dtype\" value=\"video\" checked>
				&nbsp;&nbsp;Audio only: <input type=\"radio\" name=\"dtype\" value=\"audio\"><br>";
				if ($_SESSION['authorized'] == 3 || $_SESSION['authorized'] == 10) {
					echo "&nbsp;&nbsp; Public Video: <input type=\"radio\" name=\"dtype\" value=\"public_video\">
					&nbsp;&nbsp; Public Audio: <input type=\"radio\" name=\"dtype\" value=\"public_audio\">";
				}
			echo "</p>
		</form>
	</div>";
include("footer.php");
?>
