<?php
include "header.php";
?>
<body>
	<div id="conholder">
		<div id="maincon">
			<h1 class="texth1">TimeShifter-YouTube-DownLoader</h1>
			<h4 class="texth4">
			<ul>

<?php
// core scripts
$files = scandir( "./scripts/" );
foreach( $files as $file ){
	if ($file != '.' && $file != '..' ) {
		echo "<li> <a href=\"./scripts/" . $file . "\">" . $file . "</a></li>";
	}
}

// examples
$files = scandir( "./examples/" );
foreach( $files as $file ){
	if ($file != '.' && $file != '..' ) {
		echo "<li> <a href=\"./examples/" . $file . "\">" . $file . "</a></li>";
	}
}
?>

			</ul>
			</h4>
		</div>
	</div>
<?php
include "footer.php";
?>
