<?php
set_time_limit(120);
foreach($_POST as $path){
	$myPath = urldecode(utf8_decode($path));
	if(unlink($myPath)){
		echo "Deleted: " . $myPath . "<br>";
	} else {
		if(unlink($myPath)){

		}
		echo "Failed Deleting: " . $myPath . "<br>";
	}
}
?>
