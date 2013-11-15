<?php
// app/Model/User.php
class User extends AppModel {
	
	var $hasOne = array('Credit');
	var $belongsTo ='Language';
	/*
	var $hasAndBelongsToMany = array(
		'Audio1' => array(
			//'joinTable'             => 'languages_users',
			'joinTable'             => 'audios',
			'foreignKey'            => 'user_id',
			'associationForeignKey' => 'language_id'
		)
	);
	*/
    public $validate = array(
        'username' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'A username is required'
            )
        ),
        'password' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'A password is required'
            )
        ),
    );
    
    
	public function beforeSave($options = array()) {
	    if (isset($this->data[$this->alias]['password'])) {
	        $this->data[$this->alias]['password'] = AuthComponent::password($this->data[$this->alias]['password']);
	    }
	    return true;
	}
    
}