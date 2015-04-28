<?php
App::uses('AppController', 'Controller');
App::uses('AppHelper', 'View/Helper');
App::uses('AppCakeEmail', 'Lib/Network/Email');
class UsersController extends AppController {
	public $components = array('Paginator','Cookie');
	public $paginate = array(
			'limit' => 15,
			'order' => array(
					'username' => 'asc'
			)
	);
	public function beforeFilter() {
		$this->Cookie->httpOnly = true;
		if (!$this->Auth->loggedIn() && $this->Cookie->read('rememberMe')) {
			$cookie = $this->Cookie->read('rememberMe');
			$user = $this->User->find('first', array(
					'conditions' => array(
							'User.username' => $cookie['username'],
							'User.password' => $cookie['password']
					)
			));
			if ($user && !$this->Auth->login($user['User'])) {
				$this->redirect('/users/logout'); // destroy session &   cookie
			} else {
				$this->afterLogin($user);
				$this->redirect($this->Auth->redirectUrl()); // redirect to Auth.redirect if it is set, else to Auth.loginRedirect ('/users/userhome') if it is set, else to /
			}
		}
	}
	public function afterLogin($user){
		$storeIds = array();
		$methodIds = array();
        if(!empty($user['StoreUser'])){
        	foreach ($user['StoreUser'] as $store){
        		$storeIds[$store['store_id']] = (int)$store['level'];
            }
         }
         if(!empty($user['MethodUser'])){
         	foreach ($user['MethodUser'] as $method){
         		$methodIds[$method['method_id']] = (int)$method['level'];
         	}
         }
         if(!$this->Session->check('languages')){
         	$this->loadModel('Language');
         	$languages = $this->Language->getAllRows();
         	foreach ($languages as $key=>$row){
         		$languages[$key] = $row['Language'];
         	}
         	$this->Session->write('Languages', $languages);
         	$this->Session->write( 'Config.language',Configure::read('Config.language') );
         }
         $this->Session->write('User.MethodIds', $methodIds);
         $this->Session->write('User.StoreIds', $storeIds);
	}
	public function login(){
// 		echo AuthComponent::password('fzrj12wh');die;
		if ($this->request->is('post')) {
            if ($this->Auth->login()) {
            	if ($this->request->data['User']['rememberMe'] == 1) {
            		// After what time frame should the cookie expire
            		$cookieTime = "12 months"; // You can do e.g: 1 week, 17 weeks, 14 days
            		// remove "remember me checkbox"
            		unset($this->request->data['User']['rememberMe']);
            		// hash the user's password
            		$this->request->data['User']['password'] = $this->Auth->password($this->request->data['User']['password']);
            		// write the cookie
            		$this->Cookie->write('rememberMe', $this->request->data['User'], true, $cookieTime);
            	}
            	$this->request->data["User"]["id"] = $this->Auth->User('id');
            	//$this->request->data["User"]["last_logged"] = date("Y-m-d H:i:s");
//             	$this->User->save($this->request->data);
            	$user = $this->User->findById($this->Auth->User('id'));
            	$this->afterLogin($user);
                return $this->redirect($this->Auth->redirect());
            }
            $this->setFlash(__('E-mail or password incorrect.'),'error');
        }
        $this->layout = "front";
	}
	public function logout() {
		$this->Cookie->delete('rememberMe');
        return $this->redirect($this->Auth->logout());
    }
	
	public function index(){
			$this->checkUserRight();
// 		if ($this->Auth->User('level') >= USER_MANAGER_LEVEL) {
			$this->Paginator->settings = $this->paginate;
			$conditions = array('User.id !=' =>$this->Auth->User('id'));
			$this->loadModel('Store');
			$this->loadModel('StoreUser');
			$this->loadModel('Method');
			$this->loadModel('MethodUser');
			if ($this->Auth->User('type') == 'store_admin') {
				$storeLevels = $this->Session->read('User.StoreIds');
				$filters = array(
											'store_id'=>array_keys($storeLevels),
											'user_id !='=> $this->Auth->User('id')
								);
				$otherUsers = $this->StoreUser->getCustomData($filters);
				$otherUserIds = array();
				if(!empty($otherUsers)){
					foreach ($otherUsers as $user){
						if(empty($user) || empty($user['StoreUser']) || $user['StoreUser']['level'] > $storeLevels[$user['StoreUser']['store_id']]){
							continue;
						}
						array_push($otherUserIds, $user['StoreUser']['user_id']);
					}
				}
// 				$conditions['User.level <='] = $this->Auth->User('level');
				$conditions['User.id'] = $otherUserIds;
				$conditions['User.type'] = 'store_admin';
			}elseif ($this->Auth->User('type') == 'payment_admin'){
				$methodLevels = $this->Session->read('User.MethodIds');
				$filters = array(
						'method_id'=>array_keys($methodLevels),
						'user_id !='=> $this->Auth->User('id')
				);
				$otherUsers = $this->MethodUser->getCustomData($filters);
				
				$otherUserIds = array();
				if(!empty($otherUsers)){
					foreach ($otherUsers as $user){
						if(empty($user) || empty($user['MethodUser']) || $user['MethodUser']['level'] > $methodLevels[$user['MethodUser']['method_id']]){
							continue;
						}
						array_push($otherUserIds, $user['MethodUser']['user_id']);
					}
				}
				// 				$conditions['User.level <='] = $this->Auth->User('level');
				$conditions['User.id'] = $otherUserIds;
				$conditions['User.type'] = 'payment_admin';
			}
	    	$data = $this->Paginator->paginate('User',$conditions);
	    	$this->set('store_ids', $this->Store->getAllList());
	    	$this->set('method_ids', $this->Method->getAllList());
	    	$this->set('data', $data);
// 		}else{
// 			return $this->redirect(array('controller' => 'dashboard', 'action' => 'home'));
// 		}
	}
	public function delete($id = null){
		$this->checkUserRight();
		if ($this->Auth->User('level') < USER_NORMAL_LEVEL) {
			$this->setFlash(__('You are not allowed to do this.'),'error');
			return $this->redirect(array('action' => 'index'));
		}
		$this->User->id = $id;
		if (!$this->User->exists()) {
			$this->setFlash(__('User does not exist.'),'error');
			return $this->redirect(array('action' => 'index'));
		}
		if ($this->User->deleteAll(array('User.id' => $id))) {
			$this->setFlash(__('The admin user has been deleted.'));
		} else {
			$this->setFlash(__('The admin user could not be deleted. Please, try again.'),'error');
		}
		return $this->redirect(array('action' => 'index'));
	}
	
	public function add(){
			$this->checkUserRight();
// 		if ($this->Auth->User('level') >= 5) {
			$storeLevels = $this->Session->read('User.StoreIds');
			$methodLevels = $this->Session->read('User.MethodIds');
			if ($this->request->is('post')) {
				$this->User->create();
				$data = $this->request->data;
				if ($this->User->save($data['User'])) {
					//store user
					if(isset($data['StoreUser']) && !empty($data['StoreUser']['store'])){
						$storeRows = array();
						$userId = $this->User->id;
						foreach ($data['StoreUser']['store'] as $store=>$level){
							if($level > $storeLevels[$store]){
								$level = $storeLevels[$store];
							}
							$storeRows[$store] = array(
																'user_id'=>$userId,
																'store_id'=>$store,
																'level'=>$level,
															);
						}
// 						var_dump($storeRows);die;
						$this->loadModel('StoreUser');
						$this->StoreUser->saveAndUpdateRow($storeRows);
					}
					//method user
					if(isset($data['MethodUser']) && !empty($data['MethodUser']['method'])){
						$storeRows = array();
						$userId = $this->User->id;
						foreach ($data['MethodUser']['method'] as $store=>$level){
							$storeRows[$store] = array(
									'user_id'=>$userId,
									'method_id'=>$store,
									'level'=>$level,
							);
						}
						$this->loadModel('MethodUser');
						$this->MethodUser->saveAndUpdateRow($storeRows);
					}
					$this->setFlash(__('New admin user has been saved.'));
		            return $this->redirect(array('action' => 'index'));
		        }
			}
			$this->loadModel('Store');
			$this->loadModel('Method');
			$this->set('storeList', $this->Store->getAllList());
			$this->set('storeLevels', $storeLevels);
			$this->set('methodList', $this->Method->getAllList());
			$this->set('methodLevels', $methodLevels);
// 			if($this->Auth->User('type') != 'super_admin'){
// 				$this->set('store_users',  $this->Session->read('User.StoreIds'));
// 			}
//         }else{
//         	return $this->redirect(array('controller' => 'dashboard', 'action' => 'index'));
//         }
	}
	
	public function edit($id = null){
		$this->checkUserRight();
		if (!$id) {
	        $this->setFlash(__('You are not allowed to edit this user.'),'error');
			return $this->redirect(array('action' => 'index'));
	    }
	    $user = $this->User->findById($id);
	    if (!$user) {
	        $this->setFlash(__('User does not exist.'),'error');
			return $this->redirect(array('action' => 'index'));
	    }
	    
		if ($this->request->is(array('post', 'put'))) {
			$this->User->id = $id;
			if(isset($this->request->data["User"]["reset_password"]) && $this->request->data["User"]["reset_password"] == 1){
				$firstName = '';
				$lastName = '';
				if(!empty($user['Profile'])){
					foreach ($user['Profile'] as $item){
						if($item['name'] == 'firstname' && $item['group'] == 'basic'){
							$firstName = $item['value'];
						}
						if($item['name'] == 'lastname' && $item['group'] == 'basic'){
							$lastName = $item['value'];
						}
					}
				}
// 				$user['User']['username'] = 'zouhongzhao@126.com';
				$this->loadModel('UserSetting');
				$value = sha1(time());
				$token = $this->UserSetting->setToken($id,'reset_password_token',$value);
// 				echo $token;
				$link = Router::url('/', true) . "active/change_password/{$id}/".$token;
				$Email = new AppCakeEmail();
				$Email->template('reset_password')
				->emailFormat('html')
				->viewVars(array('firstname' => $firstName,'lastname'=>$lastName,'url'=>$link))
				->to($user['User']['username'])
				->subject(__(' Password reset confirmation.'))
				->send();
				$this->setFlash(__('An email with new password information has been sent to the user.'),'notice');
			}else{
				$this->User->validator()->remove('username');
				if ($this->User->save($this->request->data)) {
					// 				$log = $this->User->getDataSource()->getLog(false, false); debug($log);die;
					$this->setFlash(__('The user has been saved.'));
					return $this->redirect(array('action' => 'edit', $this->User->id));
				} else {
					$this->setFlash(__('The user could not be saved. Please, try again.'),'error');
				}
			}
		}
		$this->loadModel('Store');
		$this->loadModel('Method');
		$this->set('method_ids', $this->Method->getAllList());
		$this->set('method_users', $user['MethodUser']);
		$this->set('store_ids', $this->Store->getAllList());
		$this->set('store_users', $user['StoreUser']);
		if (!$this->request->data) {
	        $this->request->data = $user;
	    }
	} 
	
	public function profile(){
		$id = $this->Auth->User('id');
		$user = $this->User->findById($id);
		if (!$user) {
			$this->setFlash(__('User does not exist.'),'error');
			return $this->redirect(array('action' => 'index'));
		}
		if ($this->request->is(array('post', 'put'))) {
			$this->User->id = $id;
			$this->loadModel('UserSetting');
			//save basic or contact
			if(isset($this->request->data["Profile"])){
				$profileData = $this->request->data["Profile"];
				if($this->UserSetting->saveAndUpdateSetting($id,$profileData)){
					if(isset($profileData['basic'])){
						$this->setFlash(__('Basic information saved successfully.'));
					}elseif (isset($profileData['contact'])){
						$this->setFlash(__('Contact information saved successfully.'));
					}
					return $this->redirect(array('action' => 'profile'));
				}else {
					$this->setFlash(__('The information could not be saved. Please, try again.'),'error');
				}
			}
			//change email
			if(isset($this->request->data["User"]["username"])){
				$newEmail = $this->request->data["User"]["username"];
				$this->User->set($this->request->data);
				if ($this->User->validates()) {
					$firstName = '';
					$lastName = '';
					if(!empty($user['Profile'])){
						foreach ($user['Profile'] as $item){
							if($item['name'] == 'firstname' && $item['group'] == 'basic'){
								$firstName = $item['value'];
							}
							if($item['name'] == 'lastname' && $item['group'] == 'basic'){
								$lastName = $item['value'];
							}
						}
					}
					$value = sha1(time());
					$token = $this->UserSetting->setToken($id,'email_change_token',$value);
						
					$this->UserSetting->setToken($id,'email',$newEmail);
					// 				echo $token;
					$link = Router::url('/', true) . "active/change_email/{$id}/".$token;
					$Email = new AppCakeEmail();
					$Email->template('login_emai_change_confirm')
					->emailFormat('html')
					->viewVars(array('firstname' => $firstName,'lastname'=>$lastName,'url'=>$link))
					->to($newEmail)
					->subject(__(' Login E-mail change confirmation'))
					->send();
					$this->setFlash(__('You need to check the confirmation email sent to your new email address.'),'notice');
				} else {
					
				}
			}
			//change password
			if(isset($this->request->data["User"]["new_password"])){
				$this->User->set($this->request->data);
				$this->User->validator()->remove('username');
				$new_password = trim($this->request->data['User']['new_password']);
				$this->User->set(array(
						'password' => $new_password
				));
				if($this->User->save()){
					$this->setFlash(__('Password changed successfully.'));
					return $this->redirect(array('action' => 'profile'));
				}else{
					$this->setFlash(__('The password could not be saved. Please, try again.'),'error');
				}
			}
		}
	
		if (!$this->request->data) {
			$this->request->data = $user;
		}
		$this->set('settings', $user['Profile']);
	}
	
	
	//store user
	public function add_store($userId=null){
		$this->User->id = $userId;
		if (!$this->User->exists()) {
			$this->setFlash(__('User does not exist.'),'error');
			return $this->redirect(array('action' => 'index'));
		}
	
		if ($this->request->is(array('post', 'put'))) {
			$data = $this->request->data['StoreUser'];
			$data['user_id'] = $userId;
			$this->loadModel('StoreUser');
			if ($this->StoreUser->saveAndUpdateRow($data)) {
				$this->setFlash(__('The store user has been saved.'));
				 return $this->redirect(array('action' => 'edit', $userId));
			} else {
				$this->setFlash(__('The store user could not be saved. Please, try again.'),'error');
			}
		}
		$this->loadModel('Store');
		$storeList = $this->Store->getAllList();
		$storeList = $this->getLicensedStores($storeList);
		$this->set('store_list', $storeList);
	}
	public function delete_store($storeId=null,$userId = null){
		if(!$storeId || !$userId){
			$this->setFlash(__('You are not allowed to do this.'),'error');
			return $this->redirect($this->referer());
		}
		$this->loadModel('Store');
		$this->Store->id = $storeId;
		if (!$this->Store->exists()) {
			$this->setFlash(__('Store does not exist.'),'error');
			return $this->redirect($this->referer());
		}
		$this->checkUserStore($storeId);
		$this->loadModel('StoreUser');
		if ($this->StoreUser->deleteAll( array( "StoreUser.store_id " => $storeId,	"StoreUser.user_id " => $userId ),false)) {
			$this->setFlash(__('The store user has been deleted.'));
		} else {
			$this->setFlash(__('The store user could not be deleted. Please, try again.'),'error');
		}
		// 		return $this->redirect(array('controller' => 'stores','action' => 'edit', $storeId));
		return $this->redirect($this->referer());
	}
	public function edit_store($storeId=null,$userId=null){
		if(!$storeId){
			$this->setFlash(__('You are not allowed to do this.'),'error');
			return $this->redirect(array('controller' => 'dashboard', 'action' => 'home'));
		}
		$this->checkUserStore($storeId);
		$this->loadModel('StoreUser');
		if ($this->request->is(array('post', 'put'))) {
			$data = $this->request->data['StoreUser'];
			$data['store_id'] = $storeId;
			if ($this->StoreUser->saveAndUpdateRow($data)) {
				$this->setFlash(__('The store user has been saved.'));
				return $this->redirect(array('controller' => 'stores','action' => 'edit', $storeId));
			} else {
				$this->setFlash(__('The store user could not be saved. Please, try again.'),'error');
			}
		}
		if($storeId){
			$this->loadModel('Store');
			$store = $this->Store->findById($storeId);
			if (!$store) {
				$this->setFlash(__('Store does not exist.'),'error');
				return $this->redirect(array('action' => 'index'));
			}
		}
		
		if($userId){
			$params = array('conditions' => array('StoreUser.store_id' =>$storeId,'StoreUser.user_id'=>$userId));
			$storeUser = $this->StoreUser->find('first', $params);
			$this->request->data = $storeUser;
			$this->set('store_user', $storeUser);
		}else{
			$existUser = $this->StoreUser->getStoreExistUser($storeId);
			$this->set('existUser', $existUser);
		}
		$existUser = $this->StoreUser->getStoreExistUser($storeId);
		$this->set('existUser', $existUser);
		$currentUserLevel = $this->currentUserStoreLevel($storeId);
		if($currentUserLevel != false){
			$this->set('currentUserLevel', $currentUserLevel);
		}
		$this->set('user_list', $this->User->getAllList());
	}
	//store user end
	
	
	//method user
	public function add_method($userId=null){
		$this->User->id = $userId;
		if (!$this->User->exists()) {
			$this->setFlash(__('User does not exist.'),'error');
			return $this->redirect(array('action' => 'index'));
		}
		if ($this->request->is(array('post', 'put'))) {
			$data = $this->request->data['MethodUser'];
			$data['user_id'] = $userId;
			$this->loadModel('MethodUser');
			if ($this->MethodUser->saveAndUpdateRow($data)) {
				$this->setFlash(__('The method user has been saved.'));
				return $this->redirect(array('action' => 'edit', $userId));
			} else {
				$this->setFlash(__('The method user could not be saved. Please, try again.'),'error');
			}
		}
		$this->loadModel('Method');
		$methodList = $this->Method->getAllList();
		$methodList = $this->getLicensedMethods($methodList);
		$this->set('method_list', $methodList);
	}
	public function delete_method($methodId=null,$userId = null){
		if(!$methodId || !$userId){
			$this->setFlash(__('You are not allowed to do this.'),'error');
			return $this->redirect(array('action' => 'edit', $userId));
		}
		$this->checkUserMethod($methodId);
		$this->loadModel('Method');
		$this->Method->id = $methodId;
		if (!$this->Method->exists()) {
			$this->setFlash(__('Method does not exist.'),'error');
			return $this->redirect(array('action' => 'edit', $userId));
		}
		$this->loadModel('MethodUser');
		if ($this->MethodUser->deleteAll( array( "MethodUser.method_id" => $methodId,	"MethodUser.user_id" => $userId ),false)) {
			$this->setFlash(__('The method user has been deleted.'));
		} else {
			$this->setFlash(__('The method user could not be deleted. Please, try again.'),'error');
		}
		// 		return $this->redirect(array('controller' => 'stores','action' => 'edit', $storeId));
		return $this->redirect(array('action' => 'edit', $userId));
	}
	public function edit_method($methodId=null,$userId=null){
		if(!$methodId){
			$this->setFlash(__('You are not allowed to do this.'),'error');
			return $this->redirect(array('controller' => 'dashboard', 'action' => 'home'));
		}
		$this->checkUserMethod($methodId);
		$this->loadModel('MethodUser');
		if ($this->request->is(array('post', 'put'))) {
			$data = $this->request->data['MethodUser'];
			$data['method_id'] = $methodId;
			if ($this->MethodUser->saveAndUpdateRow($data)) {
				$this->setFlash(__('The method user has been saved.'));
				return $this->redirect(array('action' => 'edit', $userId));
			} else {
				$this->setFlash(__('The method user could not be saved. Please, try again.'),'error');
			}
		}
		if($methodId){
			$this->loadModel('Method');
			$store = $this->Method->findById($methodId);
			if (!$store) {
				$this->setFlash(__('Method does not exist.'),'error');
				return $this->redirect(array('action' => 'index'));
			}
		}
	
		if($userId){
			$params = array('conditions' => array('MethodUser.method_id' =>$methodId,'MethodUser.user_id'=>$userId));
			$methodUser = $this->MethodUser->find('first', $params);
			$this->request->data = $methodUser;
			$this->set('method_user', $methodUser);
		}else{
			$existUser = $this->MethodUser->getStoreExistUser($methodId);
			$this->set('existUser', $existUser);
		}
		$existUser = $this->MethodUser->getStoreExistUser($methodId);
		$this->set('existUser', $existUser);
		$currentUserLevel = $this->currentUserStoreLevel($methodId);
		if($currentUserLevel != false){
			$this->set('currentUserLevel', $currentUserLevel);
		}
		$this->set('user_list', $this->User->getAllList());
	}
	//store user end
}