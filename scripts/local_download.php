<?php
include("./header.php");
$timestamp = $_GET['timestamp'];
$media = addslashes($_GET['media']);
$page = $_GET['page'];
$public = $_GET['public'];

# Test to see if media request is a public media request and send header info.
if ($public) {
	header("Content-type: ".mime_content_type("$public_path/$page/$timestamp/$media"));
	header('Content-Length: ' . filesize("$public_path/$page/$timestamp/$media"));
	header("Content-Disposition: attachment; filename=\"$media\"");
} else {
	header("Content-type: ".mime_content_type("$data_path/$userid/$page/$timestamp/$media"));
	header('Content-Length: ' . filesize("$data_path/$userid/$page/$timestamp/$media"));
	header("Content-Disposition: attachment; filename=\"$media\"");
}
ob_clean();
flush();

# Test to see if media request is a public media request and send file.
if ($public) {
	readfile("$public_path/$page/$timestamp/$media");
} else {
	readfile("$data_path/$userid/$page/$timestamp/$media");
}
?>
