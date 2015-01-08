<?php
$userid = $_GET['userid'];
$log = file_get_contents("/srv/ts-yt-dl/$userid/user.log");
$log = str_replace("\n", "<br />", $log);
echo $log;
?>
