<?php
include("header.php");
include("functions.php");
login_check();
?>
<body>
	<div id="content">
	<?php
	$query = "SELECT * ";
	if (isset($_GET['search']) && !empty($_GET['search'])) {
		$search = $_GET['search'];
		echo "Search results for <i>$search</i>";
	}
	?>
