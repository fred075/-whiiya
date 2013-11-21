<?php
// app/Model/User.php
class Word extends AppModel {
	
	
	var $hasMany = array(
		'Audio1' => array(
			'className'	=>	'Audio'
			)
		)
	;
    
    
    
}