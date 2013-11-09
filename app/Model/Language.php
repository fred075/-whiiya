<?php
// app/Model/User.php
class Language extends AppModel {

	
    var $hasMany = array(
        'Audio1' => array(
            'className' => 'Audio',
            'foreignKey' => 'language_id',
        )
    );
	
}