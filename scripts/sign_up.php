<?php
include("header.php");
echo "<link rel=\"stylesheet\" href=\"./style/login.css\">";
?>
<body>
	<div id="content">
	<?php
	echo "<h2 class=\"h2_title\">Sign Up</h2>";
	echo "<div class=\"login_box\">
		<form action=\"add_user.php\" method=\"POST\">
			<input class=\"login_input\" type=\"text\" name=\"first_name\" placeholder=\"First Name\"/>
			<input class=\"login_input\" type=\"text\" name=\"last_name\" placeholder=\"Last Name\"/>
			<input class=\"login_input\" type=\"text\" name=\"username\" placeholder=\"Username\"/>
			<input class=\"login_input\" type=\"text\" name=\"email\" placeholder=\"Email Address\"/>
			<input class=\"login_input\" type=\"password\" name=\"password\" placeholder=\"Password\"/>
			<input class=\"login_input\" type=\"password\" name=\"password_confirm\" placeholder=\"Password Confirm\"/>
			<input class=\"login_submit\" type=\"submit\" value=\"Sign Up\">
		</form>
	</div>";
	echo "<h3 class=\"h3_title\"><a href=\"sign_up.php\">Sign up</a></h3>";
	?>
	</div>
</body>
