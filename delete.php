<?php
foreach($_POST as $path){
	echo "Deleted: " . urldecode($path) . "<br>";
	unlink(urldecode($path));
}
?>
