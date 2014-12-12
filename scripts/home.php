<?php
include("header.php");
require('../../ts-yt-dl-defaults/ts-yt-dl');
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
				&nbsp;&nbsp;Audio only: <input type=\"radio\" name=\"dtype\" value=\"audio\">
			</p>
		</form>
	</div>";
include("footer.php");
?>
