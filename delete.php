<?php
set_time_limit(120);
foreach($_POST as $path){
	if(unlink(utf8_decode($path))){
		echo "Deleted: " . utf8_decode($path) . "<br>";
	} else {
		if(unlink(utf8_decode($path))){

		}
		echo "Failed Deleting: " . utf8_decode($path) . "<br>";
	}
}
?>
