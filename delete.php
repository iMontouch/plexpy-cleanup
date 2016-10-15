<?php
foreach($_POST as $path){
	echo "Deleted: " . $path;
	unlink($path);
}
?>
