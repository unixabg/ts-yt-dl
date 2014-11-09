<?php
session_start();
$userid = $_SESSION['userid'];
require('../../ts-yt-dl-defaults/ts-yt-dl');
$video = scandir("$data_path/$userid/videos/");

// FIXME - Test to only run one build at a time.

if ( !file_exists("$data_path/$userid/iso") ) {
	mkdir("$data_path/$userid/iso", 0755, true);
	file_put_contents("$data_path/$userid/iso/log", date('YmdHis')." TS to dvd requested.\nCreated iso folder!\n");
} else {
	file_put_contents("$data_path/$userid/iso/log", date('YmdHis')." TS to dvd requested.\nFolder iso already exists!\n");
}

// Delete previous ts_dvd.list request.
if ( file_exists("$data_path/$userid/iso/ts_dvd.list") ) {
	unlink("$data_path/$userid/iso/ts_dvd.list");
}

// Populate the list to Time Shift.
foreach ($video as $timestamp) {
	if (isset($_POST[$timestamp])) {
		file_put_contents("$data_path/$userid/iso/log", "TS Ref. of $timestamp to dvd!\n", FILE_APPEND | LOCK_EX);
		file_put_contents("$data_path/$userid/iso/ts_dvd.list", "$timestamp\n", FILE_APPEND | LOCK_EX);
		echo $timestamp."<br />";
	}
}

// FIXME - Trigger background Time Shift to iso file.

?>
