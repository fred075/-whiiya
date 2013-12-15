<?php
include_once '../webroot/functions.php';
// app/Controller/UsersController.php
class WordsController extends AppController {

	var $components = array('Auth');
	var $uses = array('Word','Language','User','Audio', 'Rating', 'Credit');

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
			$user['Credit']['amount'] = $user['Credit']['amount']-1;
			if($user['Credit']['amount']<=20) {
				$this->set('error','1');
			}
			$credit = $this->Credit->findByUserId($this->Session->read('Auth.User.id'));
			$credit['Credit']['amount'] = $user['Credit']['amount'];
			$this->Credit->save($credit);
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
	    		
	    	//check if an audio file with the same user language already exists
	    	$tmp = $this->Audio->find('first', array('conditions'=> array('word_id'=>$word['Word']['id'], 'Audio.language_id'=>$user['User']['language_id'])));
	    	
	    	if(empty($word_with_user_accent)) $this->set('audio_to_add',true);
	    	//if an audio file alreay exists, the use's not allowed to rec
	    	if(!empty($tmp)) {$this->set('audio_to_add',false);}
    	
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
	    	
	    	$this->cleanBadAudio($rating['Rating']['audio_id']);
	    	
	    }
	}
	
	
	public function cleanBadAudio($audio_id){ //deletes bad rated audio files
		$rating = $this->Rating->find('all', array('conditions' => array('audio_id' =>$audio_id)));
		$sum = 0;
		if(count($rating) >= 2){ //to change into 5
			foreach ($rating as $r){
				$sum += $r['Rating']['rating'];
			}
			$mean = $sum / count($rating);
			if($mean <= 2.5){ //change to less
				$audio = $this->Audio->findById($rating[0]['Rating']['audio_id']);//get word name
				$word = $this->Word->findById($audio['Audio']['word_id']);
				$word_name = $word['Word']['word'];
				$language = $audio['Language']['code'];
				
				$pathToDelete = $word_name . '/' . $language . '.wav';
				deleteFile($pathToDelete);
				
				$this->Rating->deleteAll(array('Rating.audio_id' => $rating[0]['Rating']['audio_id']));
				$this->Audio->delete($audio_id);
			}
		}
	}

	
	public function findWordsWithNoAudioByUser(){
		
		do {
	       //find an random audio file from another user than the logged in one
	       $audio = $this->Audio->find('first', array('conditions' => array('user_id NOT' => $this->Session->read('Auth.User.id')), 'order' => 'RAND()'));
	       //check if the user also recorded this word
	       $userAlsoRecorded = $this->Audio->find('first', array('conditions' => array('word_id'=>$audio['Audio']['word_id'], 'user_id' => $this->Session->read('Auth.User.id'))));
	       if($audio['Audio']['language_id'] == $this->Session->read('Auth.User.language_id')) {
	       	$userAlsoRecorded = "placeholder"; //just to stay in the loop
	       }
		} while (!empty($userAlsoRecorded));
		return $audio;
	}
    
    
    
    
}