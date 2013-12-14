<?php
// app/Controller/UsersController.php
class WordsController extends AppController {

	var $components = array('Auth');
	var $uses = array('Word','Language','User','Audio', 'Rating');

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('add');
    }
    

    public function index() {
    	$this->Word->contain(
    			array('Audio1' => 'User')
    	);
    	$words = $this->Word->find('all');
    	
    	$audio_empty = $this->findWordsWithNoAudioByUser();

    	$this->set('words',$words);
    	$this->set('audio_empty',$audio_empty);
    }

    
    public function details($word){
    	
    	$this->Word->contain(array('Audio1'=>array('Language','Rating')));
    	$word = $this->Word->findByWord($word);
    	$user = $this->User->findById($this->Session->read('Auth.User.id'));
    	if(!empty($word['Audio1'])){ //if there are some audio files, we substract one credit
	    	//updating the credits (-1)
			$user_new = $user;
			$user_new['Credit']['amount'] = $user['Credit']['amount']-1;
			if($user['Credit']['amount']<=20) {
				$this->set('error','1');
			}
			$this->User->saveAll($user_new);
			//loading the credit into a session variable (to be able to access to it in the header label)
	       	$this->Session->write('Auth.User.credit', $user['Credit']['amount']);
    	} 
    	
	    	//search for the accent of the user for this word
	    	$word_with_user_accent = $this->Audio->find('first',
	    		array(
	    			'conditions'=> array( 'AND' =>	
	    				array('word_id'=>$word['Word']['id']),
	    				array('Audio.language_id'=>$user['User']['language_id']),
	    				array('Audio.user_id'=>$user['User']['id'])
	    		))
	    		);
	    	if(empty($word_with_user_accent)) $this->set('audio_to_add',true);
    	
    	$this->set('word',$word);
    }
    
    
	public function rating(){
	    if ($this->request->is('post') && $this->Session->read('Auth.User.id')) {
	    	$rating['Rating']['rating'] = $this->request->data['rating'];
	    	$rating['Rating']['user_id'] = $this->Session->read('Auth.User.id');
	    	$rating['Rating']['audio_id'] = $this->request->data['audio_id'];
	    	if($this->Rating->save($rating)){
	    		echo "1";
	    	} else {
	    		echo "0";
	    	}
	    }
	}
	
	public function findWordsWithNoAudioByUser(){
		
		do {
	       //find an random audio file from another user than the logged in one
	       $audio = $this->Audio->find('first', array('conditions' => array('user_id NOT' => $this->Session->read('Auth.User.id')), 'order' => 'RAND()'));
	       //check if the user also recorded this word
	       $userAlsoRecorded = $this->Audio->find('first', array('conditions' => array('word_id'=>$audio['Audio']['word_id'], 'user_id' => $this->Session->read('Auth.User.id'))));
		} while (!empty($userAlsoRecorded));
		return $audio;
	}
    
    
    
    
}