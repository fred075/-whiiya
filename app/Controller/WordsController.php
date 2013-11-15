<?php
// app/Controller/UsersController.php
class WordsController extends AppController {

	var $components = array('Auth');
	var $uses = array('Word','Language','User','Audio');

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('add');
    }
    

    public function index() {
    	$this->Word->Audio->contain(
    		array(
    			'User'
    		)
    	);
    	$words = $this->Word->find('all');
    	$this->set('words',$words);
    }

    
    public function details($word){
    	
    	//updating the credits (-1)
		$user = $this->User->findById($this->Session->read('Auth.User.id'));
		$user_new = $user;
		$user_new['Credit']['amount'] = $user['Credit']['amount']-1;
		if($user['Credit']['amount']<=20) {
			$this->set('error','1');
		}
		
		$this->User->save($user_new['Credit']['amount']);
		
		//loading the credit into a session variable (to be able to access to it in the header label)
       	$this->Session->write('Auth.User.credit', $user['Credit']['amount']);
    	
    	$this->Word->contain(array('Audio1'=>'Language'));
    	$word = $this->Word->findByWord($word);
    	//search for the accent of the user for this word
    	$word_with_user_accent = $this->Audio->find('first',
    		array(
    			'conditions'=> array( 'AND' =>	
    				array('word_id'=>$word['Word']['id']),
    				array('language_id'=>$user['User']['language_id'])
    		))
    		);
    	
    	if(empty($word_with_user_accent)) $this->set('audio_to_add',true);
    	$this->set('word',$word);
    }
    
    
    
    
    
}