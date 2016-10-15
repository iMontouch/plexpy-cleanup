<?php
foreach($_POST as $path){
	echo "Deleted: " . $path . "<br>";
	unlink($path);
}
?>
