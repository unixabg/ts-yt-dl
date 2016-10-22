<?php
include("header.php");
$indicesServer = array('PHP_SELF',
'argv',
'argc',
'GATEWY_INTERFACE',
'SERVER_ADDR',
'SERVER_NAME',
'SERVER_SOFTWARE',
'SERVER_PROTOCOL',
'REQUEST_METHOD',
'REQUEST_TIME',
'REQUEST_TIME_FLOAT',
'QUERY_STRING',
'DOCUMENT_ROOT',
'HTTP_ACCEPT',
'HTTP_ACCEPT_CHARSET',
'HTTP_ACCEPT_ENCODING',
'HTTP_ACCEPT_LANGUAGE',
'HTTP_CONNECTION',
'HTTP_HOST',
'HTTP_REFERER',
'HTTP_USER_AGENT',
'HTTPS',
'REMOTE_ADDR',
'REMOTE_HOST',
'REMOTE_PORT',
'REMOTE_USER',
'REDIRECT_REMOTE_USER',
'SCRIPT_FILENAME',
'SERVER_ADMIN',
'SERVER_PORT',
'SERVER_SIGNATURE',
'PATH_TRANSLATED',
'SCRIPT_NAME',
'REQUEST_URI',
'PHP_AUTH_DIGEST',
'PHP_AUTH_USER',
'PHP_AUTH_PW',
'AUTH_TYPE',
'PATH_INFO',
'ORIG_PATH_INFO') ;

echo "<div id=\"content\">
				<h1 class=\"header\">Support</h1>";
echo '<table cellpadding="10">' ;
$df = disk_total_space('/')/1000000;
$df = number_format($df, 2, '.', ',');
$load = sys_getloadavg();
echo "<tr><td>User Name:</td><td>$name</td></tr>";
echo "<tr><td>User ID:</td><td>$userid</td></tr>";
echo "<tr><td>Available Disk Space:</td><td>$df Megabytes</td></tr>";
echo "<tr><td>System Average Load:</td><td>$load[0], $load[1], $load[2]</td></tr>";
foreach ($indicesServer as $arg) {
	if (isset($_SERVER[$arg])) {
		echo '<tr><td>'.$arg.'</td><td>' . $_SERVER[$arg] . '</td></tr>' ;
	} else {
		echo '<tr><td>'.$arg.'</td><td>-</td></tr>' ;
	}
}
echo '<tr><td>youtube-dl version</td><td>'. exec("youtube-dl --version") .'</td></tr>' ;
echo '</table>
</div>';
include("footer.php");
?>
