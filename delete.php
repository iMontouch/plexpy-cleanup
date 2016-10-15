<?php
foreach($_POST as $path){
	unlink($path);
}
?>
