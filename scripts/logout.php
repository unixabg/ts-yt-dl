<?php
session_start();
session_destroy();
$date = date("Y-m-d H:i:s");
file_put_contents("/srv/ts-yt-dl/".$_SESSION['userid']."/user.log", "[$date]\tUser logged out of account.\n", FILE_APPEND);
header('Location: ./index.php');
?>
