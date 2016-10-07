<?php
foreach($_GET as $path){
	unlink($path);
}
?>