<?php
foreach($_POST as $path){
	if(unlink(urldecode($path))){
		echo "Deleted: " . urldecode($path) . "<br>";
	} else {
		echo "Failed Deleting: " . urldecode($path) . "<br>";
	}
}
?>
