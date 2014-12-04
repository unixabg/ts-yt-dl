$(document).ready(function() {
	$(".account_edit").click(function() {
		var first_name = $(".first_name").text();
		var last_name = $(".last_name").text();
		var username = $(".username").text();
		var email = $(".email").text();
		$(".first_name").hide();
		$(".last_name").hide();
		$(".email").hide();
		$("#name").append("<input class=\"input\" type=\"text\" name=\"first_name\" value=\""+first_name+"\"/><input class=\"input\" type=\"text\" name=\"last_name\" value=\""+last_name+"\"/>");
		$("#email").append("<input class=\"input\" type=\"text\" name=\"email\" value=\""+email+"\"/>");
		$(".account_edit").hide();
		$("#edit").append("<input type=\"submit\" value=\"Save\"/> <a href=\"./account.php\">Cancel</a>");
		$(".user_h5").css("top", "0px");
		return false;
	});
});
