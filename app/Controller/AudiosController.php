<?php
// app/Controller/UsersController.php
class AudiosController extends AppController {

	var $components = array('Auth');
	var $uses = array('Audio','User', 'Word');

    public function beforeFilter() {
        parent::beforeFilter();
        
        $this->Auth->allow('add');
    }


    public function add() {
    	$word = $_GET['word'];
    	
        if (isset($_GET['uid'])) {
        	  error_log(serialize($word), 0);
    	$user = $this->User->findById($_GET['uid']);
    	$word = $this->Word->findByWord($_GET['word']);
    	
        	$audio['Audio']['language_id'] = $user['User']['language_id'];
        	$audio['Audio']['user_id'] = $_GET['uid'];
        	$audio['Audio']['word_id'] = $word['Word']['id'];
        	  error_log(serialize($audio), 0);
            if ($this->Audio->save($audio)) {
				$user = $this->User->findById($user['User']['id']);
				$credit = $this->Credit->findByUserId($this->Session->read('Auth.User.id'));
				$credit['Credit']['amount'] = $user['Credit']['amount']+5;
				$this->Credit->save($credit);
        	  error_log(serialize($user_new), 0);
            }
        }
    }

    public function edit($id = null) {
        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->User->save($this->request->data)) {
                $this->Session->setFlash(__('The user has been saved'));
                return $this->redirect(array('action' => 'index'));
            }
            $this->Session->setFlash(__('The user could not be saved. Please, try again.'));
        } else {
            $this->request->data = $this->User->read(null, $id);
            unset($this->request->data['User']['password']);
        }
    }

    public function delete($id = null) {
        $this->request->onlyAllow('post');

        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }
        if ($this->User->delete()) {
            $this->Session->setFlash(__('User deleted'));
            return $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('User was not deleted'));
        return $this->redirect(array('action' => 'index'));
    }
    
	
	public function login() {
		
	    if ($this->request->is('post')) {
	        if ($this->Auth->login()) {
	        	//loading the credit into a session variable (to be able to access to it in the header label)
	        	 $credit = $this->User->findById($this->Session->read('Auth.User.id'),array('fields'=>'Credit.amount'));
	        	 $this->Session->write('Auth.User.credit', $credit['Credit']['amount']);
	            return $this->redirect($this->Auth->redirect());
	        } else {
	        $this->Session->setFlash(__('Invalid username or password, try again'), 'default', array('class' => 'message warning'));
	        }
	    }
	}
	
	

	
	public function logout() {
	    return $this->redirect($this->Auth->logout());
	}
    
	
	public function profil(){
		//debug($this->Auth);
		$this->User->contain('Language','Credit');
		$user = $this->User->findById($this->Session->read('Auth.User.id'));
		$this->set('user', $user);
	}
	
	public function hasVotedForAudio($audio_id, $user_id=null){
		if($user_id == null) $user_id = $this->Session->read('Auth.User.id');
		$this->Rating->findByUserId($user_id);
	}
	
	
	
}