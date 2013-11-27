<?php
   
   $filename = $_REQUEST[filename];

   if(!isset($filename))
   {
   	exit('No file');
   }
   
   $pos = strrpos($filename, "/");
   
   if($pos > 0)
   {
   	$foldername = substr($filename, 0, $pos);
   	
   	
   	$upload_path = dirname(dirname(dirname(dirname(__FILE__)))). '/audio/'.$foldername.'/';
   	 
   	if (!file_exists($upload_path)) {
   		mkdir($upload_path, 0777);
   	}

   	$upload_path = dirname(dirname(dirname(dirname(__FILE__)))). '/audio/'.$filename;
   	
   	$fp = fopen($upload_path.".wav", "wb");
   	 
   	fwrite($fp, file_get_contents('php://input'));
   	 
   	fclose($fp);   	
   }
     
   exit('done');
   
?>