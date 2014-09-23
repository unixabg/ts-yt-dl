<?php
session_start();
include("header.php");
echo "<link rel=\"stylesheet\" href=\"./style/login.css\">";
?>
<body>
	<div id="content">
	<?php
	if (!isset($_SESSION['username'])) {
		echo "<h2 class=\"h2_title\">Sign in</h2>";
		if ($_GET['error'] == "invalid_user") {
			echo "<p class=\"error\">Invalid username and/or password.</p>";
		} elseif ($_GET['error'] == "nologin") {
			echo "<p class=\"error\">You are not logged in.</p>";
		}
		echo "<div class=\"login_box\">
				<form action=\"login.php\" method=\"POST\">
					<input class=\"login_input\" type=\"text\" name=\"username\" placeholder=\"Username\"/>
					<input class=\"login_input\" type=\"password\" name=\"password\" placeholder=\"Password\"/>
					<input class=\"login_submit\" type=\"submit\" value=\"Sign In\">
				</form>
			</div>";
			echo "<h3 class=\"h3_title\"><a href=\"sign_up.php\">Sign up</a></h3>";
			exit;
		}
		if ($_GET['error'] == "no_url") {
			echo "<p class=\"error\">Invalid URL</p>";
		}
			echo "<div class=\"url_box\">
			<form action=\"download.php\" method=\"POST\">
				<input class=\"url_input\" type=\"text\" name=\"url\" placeholder=\"url\"/>
				<input class=\"url_submit\" type=\"submit\" value=\"Download\">
			</div>
			<p class=\"radio_input\">
				Video: <input lable=\"High\" type=\"radio\" name=\"parm\" value=\" \" checked>
				&nbsp;&nbsp;Audio only: <input type=\"radio\" name=\"parm\" value=\"--extract-audio --audio-format mp3\">
			</p>
		</form>";
	?>
	</div>
</body>
<?php
include("footer.php");
?>
