<?php

function deleteFile($filename){

	$path = "../webroot/audio/". $filename;
	
	if(file_exists($path)) {
		unlink($path);	
	}

}
?>