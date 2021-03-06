<?php
// app/Controller/UsersController.php
class UsersController extends AppController {

	var $components = array('Auth');
	var $uses = array('User','Language', 'Rating', 'Audio');

    public function beforeFilter() {
        parent::beforeFilter();
        
        $this->Auth->allow('add');
    }

    public function index() {
        $this->User->recursive = 0;
        $this->set('users', $this->paginate());
    }

    public function view($id = null) {
        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }
        $this->set('user', $this->User->read(null, $id));
    }

    public function add() {
    	$languages = $this->Language->find('all');
        if ($this->request->is('post')) {
        	$user = $this->request->data;
        	$user['Credit']['amount'] = 30; //initial credit
            $this->User->create();
            if ($this->User->saveAll($user)) {
                $this->Session->setFlash(__('The user has been saved'));
                return $this->redirect(array('action' => 'index'));
            }
            $this->Session->setFlash(__('The user could not be saved. Please, try again.'), 'default', array('class' => 'message success'));
        }
        //pr($languages);exit;
        $this->set('languages',$languages);
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
		
		$audios = $this->Audio->find('all', array('conditions'=>array('user_id'=>$this->Session->read('Auth.User.id'))));
		$usersAudioFiles = array();
		foreach ($audios as $a){ //load stats
			$rating = $this->Rating->findAllByAudioId($a['Audio']['id']);
			if(!empty($rating)){
				$sum = 0;
				foreach ($rating as $r){
					$sum += $r['Rating']['rating'];
				}
				$usersAudioFiles[$a['Word']['word']] = $sum / count($rating);
			}
			$this->set('usersAudioFiles', $usersAudioFiles);
		}
		$this->set('nbOfEntriesForUser', count($audios));
	}
	
	public function hasVotedForAudio($audio_id, $user_id=null){
		if($user_id == null) $user_id = $this->Session->read('Auth.User.id');
		$this->Rating->findByUserId($user_id);
	}
}