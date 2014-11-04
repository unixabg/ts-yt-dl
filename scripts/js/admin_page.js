$(document).ready(function() {
	$(".user_edit").click(function() {
		var row = $(this).attr('rowid');
		$(".user_box[rowid='" + row + "']").show();
	});
	$(".cancel").click(function() {
		var row = $(this).attr('rowid');
		$(".user_box[rowid='" + row + "']").hide();
	});
});
