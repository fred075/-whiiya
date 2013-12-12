<?php
$fullPath = $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
$string = $fullPath;
$string = explode('/', $string);
array_pop($string);
array_pop($string);
array_pop($string);
array_pop($string);
array_pop($string);
array_pop($string);

$string = implode('/', $string);

$filename = $_REQUEST['filename'];
$filename_tmp = explode("/", $filename);
$filename = $filename_tmp[0] . '/' . $filename_tmp[1]; 
$word = explode("/", $filename);



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

   	file_get_contents("http://" . $string . "/audios/add?word=" . $word[0] . '&uid=' . $filename_tmp[2] ); //insert into DB
   	echo "http://" . $string . "/audios/add?word=" . $word[0] . '&uid=' . $filename_tmp[2];
   	
   }
     
   exit('done');
   
?>