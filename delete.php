<?php
set_time_limit(120);
foreach($_POST as $path){
	if(unlink(urldecode($path))){
		echo "Deleted: " . urldecode($path) . "<br>";
	} else {
		echo "Failed Deleting: " . urldecode($path) . "<br>";
	}
}
?>
