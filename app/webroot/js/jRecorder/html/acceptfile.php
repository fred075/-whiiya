<?php
   print_r($_GET);
   if(!isset($_REQUEST['filename']))
   {
   	exit('No file');
   }
   
   $filename = $_REQUEST['filename'];
    
   $upload_path = dirname(dirname(dirname(dirname(__FILE__)))). '/audio/bread/';
   
   if (!file_exists($upload_path)) {
   	mkdir($upload_path, 0777);
   }    
   
   $fp = fopen($upload_path.$filename.".wav", "wb");
   
   fwrite($fp, file_get_contents('php://input'));
   
   fclose($fp);
   
   exit('done');
   


?>