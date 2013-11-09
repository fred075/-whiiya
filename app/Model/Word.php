<?php
// app/Model/User.php
class Word extends AppModel {
	
	
	var $hasAndBelongsToMany = array(
		'Audio1' => array(
			//'joinTable'             => 'languages_users',
			'className' => 'Audio',
			'joinTable'             => 'audios',
			'foreignKey'            => 'word_id',
			'associationForeignKey' => 'language_id'
		)
	);
	
    
    
    
}