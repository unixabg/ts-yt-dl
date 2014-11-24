<?php
include("./header.php");
require('../../ts-yt-dl-defaults/ts-yt-dl');
$timestamp = $_GET['timestamp'];
$media = addslashes($_GET['media']);
$page = $_GET['page'];
header("Content-type: ".mime_content_type("$data_path/$userid/$page/$timestamp/$media"));
header('Content-Length: ' . filesize("$data_path/$userid/$page/$timestamp/$media"));
header("Content-Disposition: attachment; filename=\"$media\"");
ob_clean();
flush();
readfile("$data_path/$userid/$page/$timestamp/$media");
?>
