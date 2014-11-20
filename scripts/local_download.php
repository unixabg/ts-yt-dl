<?php
include("./header.php");
require('../../ts-yt-dl-defaults/ts-yt-dl');
$timestamp = $_GET['timestamp'];
$video = addslashes($_GET['video']);
header("Content-type: ".mime_content_type("$data_path/$userid/videos/$timestamp/$video"));
header("Content-Disposition: attachment; filename=\"$video\"");
ob_clean();
flush();
readfile("$data_path/$userid/videos/$timestamp/$video");
?>
