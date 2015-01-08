$(document).ready(function() {
	$(".user_edit").click(function() {
		var row = $(this).attr('rowid');
		$(".user_box[rowid='" + row + "']").show();
	});
	$(".cancel").click(function() {
		var row = $(this).attr('rowid');
		$(".user_box[rowid='" + row + "']").hide();
	});
	$(".log_button").click(function() {
		$(".log").show();
	});
	$(".cancel_log").click(function() {
		$(".log").hide();
		$(".user_log").hide();
	});
	$(".user_log_link").click(function() {
		$(".user_log").show();
		var link = $(this).attr("href");
		$(".user_log_content").load(link);
		$(".user_log_content").scrollTop($('.user_log_content')[0].scrollHeight);
		return false;
	});
});
