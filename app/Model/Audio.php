<?php
class Audio extends AppModel {
	
	var $name = 'Audio';
	var $actsAs = array('Containable');
	var $useTable = 'audios';
	

    public $belongsTo = array(
        'Language' => array(
            'className' => 'Language',
            'foreignKey' => 'language_id'
        ),
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id'
        )
    );
    
    public $hasMany = "Rating";
    
}