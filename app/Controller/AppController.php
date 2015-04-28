<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
App::uses ( 'Controller', 'Controller' );

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
	public $components = array (
			'Session',
			'Cookie',
			'Auth' => array (
					'loginRedirect' => array (
							'controller' => 'dashboard',
							'action' => 'home',
							'index' 
					),
					'logoutRedirect' => array (
							'controller' => 'dashboard',
							'action' => 'home',
							'index' 
					),
					'authorize' => array (
							'Controller' 
					),
					'authenticate' => array(
							'Form' => array(
									'userModel' => 'User',
									'fields' => array(
											'username' => 'username',
											'password'=>'password'
									),
									'scope' => array (
											'status' => 1
									)
							)
					)
			) 
	);
	function beforeFilter() {
		if (is_null ( $this->Auth->user () )) {
			$this->Auth->allow ( 'change_password', 'change_email' );
		}
	}
	
	// override redirect
	public function redirect($url, $status = NULL, $exit = true) {
		if (! isset ( $url ['language'] ) && $this->Session->check ( 'Config.language' )) {
			$url ['language'] = $this->Session->read ( 'Config.language' );
		}
		parent::redirect ( $url, $status, $exit );
	}
	
	public function isAuthorized($user) {
		// Admin can access every action (override this with extra rules in controllers)
		if (isset ( $user ['level'] ) && ($user ['level'] >= USER_NORMAL_LEVEL)) {
			return true;
		}
		
		// Default deny
		return false;
	}
	public function setFlash($message, $type = 'success') {
		switch ($type) {
			case 'success' :
				$class = 'alert-success';
				break;
			case 'notice' :
				$class = 'alert-info';
				break;
			case 'error' :
				$class = 'alert-danger';
				break;
			default :
				$class = 'alert-success';
				;
				break;
		}
		$this->Session->setFlash ( $message, 'alert-box', array (
				'class' => $class 
		) );
	}
	public function currentUserStoreLevel($storeId=null){
		$currentUserLevel = 0;
		if(is_null($storeId)){
			return $currentUserLevel;
		}
		if($this->Auth->User('type') == 'store_admin'){
			$storeUsers = $this->Session->read('User.StoreIds');
			if(isset($storeUsers)){
				return $storeUsers[$storeId];
			}
			return $currentUserLevel;
		}else{
			return false;
		}
	}
	public function currentUserMethodLevel($methodId=null){
		$currentUserLevel = 0;
		if(is_null($methodId)){
			return $currentUserLevel;
		}
		if($this->Auth->User('type') == 'payment_admin'){
			$methodUsers = $this->Session->read('User.MethodIds');
			if(isset($methodUsers)){
				return $methodUsers[$methodId];
			}
			return $currentUserLevel;
		}else{
			return false;
		}
	}
	public function sortByFiled($a, $b) {
		if (strlen($a) == strlen($b)) {
			return 0;
		} else {
			return (strlen($a) > strlen($b)) ? 1 : -1;
		}
	}
	 public function objectToArray($d) {
		  if (is_object($d)) {
		   // Gets the properties of the given object
		   // with get_object_vars function
		   $d = get_object_vars($d); 
		  }
		
		  if (is_array($d)) {
		   /*
		   * Return array converted to object
		   * Using __FUNCTION__ (Magic constant)
		   * for recursive call
		   */
		  return array_map(array($this, 'objectToArray'), $d);
		  }
		  else {
		   // Return array
		   return $d;
		  }
	 }
	 
	 public function array_splice_assoc(&$input, $offset, $length = 0, $replacement = array()) {
	 	$replacement = (array) $replacement;
        $key_indices = array_flip(array_keys($input));
        if (isset($input[$offset]) && is_string($offset)) {
                $offset = $key_indices[$offset] + 1;
        }
        if (isset($input[$length]) && is_string($length)) {
                $length = $key_indices[$length] - $offset;
        }
        $input = array_slice($input, 0, $offset, TRUE)
                + $replacement
                + array_slice($input, $offset + $length, NULL, TRUE);
        return $input;
	 }
	 
	 public function checkUserStore($storeId){
	 	 if($this->Auth->User('type') == 'store_admin'){
	 	 	if($storeUsers = $this->Session->read('User.StoreIds')){
	 	 		$storeIds = array_keys($storeUsers);
	 	 	}
	 	 	if(!in_array($storeId, $storeIds)){
	 	 		$this->setFlash(__('You are not allowed to edit this store.'),'error');
	 	 		return $this->redirect(array('controller' => 'dashboard', 'action' => 'home'));
	 	 	}
	 	 }
	 }
	 public function checkUserMethod($methodId){
	 	if($this->Auth->User('type') == 'payment_admin'){
	 		if($methodUsers = $this->Session->read('User.MethodIds')){
	 			$methodIds = array_keys($methodUsers);
	 		}
	 		if(!in_array($methodId, $methodIds)){
	 			$this->setFlash(__('You are not allowed to edit this method.'),'error');
	 			return $this->redirect(array('controller' => 'dashboard', 'action' => 'home'));
	 		}
	 	}
	 }
	 public function checkUserRight(){
	 	if ($this->Auth->loggedIn()){
	 			if($this->Auth->User('type') == 'store_admin'){
	 				if($storeUsers = $this->Session->read('User.StoreIds')){
	 					foreach ((array)$storeUsers as $level){
	 						if($level > 3){
	 							return true;
	 						}
	 					}
	 				}
	 				$this->setFlash(__('You are not allowed to edit this store.'),'error');
	 			}elseif ($this->Auth->User('type') == 'payment_admin'){
	 				if($methodUsers = $this->Session->read('User.MethodIds')){
	 					foreach ((array)$methodUsers as $level){
	 						if($level > 3){
	 							return true;
	 						}
	 					}
	 				}
	 				$this->setFlash(__('You are not allowed to edit this method.'),'error');
	 			}else{
	 				return true;
	 			}
	 			
	 			return $this->redirect(array('controller' => 'dashboard', 'action' => 'home'));
	 	}
	 }
	 
	 public function getLicensedStores($storeList){
	 	if($this->Auth->User('type') != 'store_admin'){
	 		return $storeList;
	 	}
	 	$storeIds = array_keys($this->Session->read('User.StoreIds'));
	 	foreach ($storeList as $key=>$value){
	 		if(!in_array($key, $storeIds)){
	 			unset($storeList[$key]);
	 		}
	 	}
		return $storeList;
	 }
	 public function getLicensedMethods($methodList){
	 	if($this->Auth->User('type') != 'payment_admin'){
	 		return $methodList;
	 	}
	 	$methodIds = array_keys($this->Session->read('User.MethodIds'));
	 	foreach ($methodList as $key=>$value){
	 		if(!in_array($key, $methodIds)){
	 			unset($methodList[$key]);
	 		}
	 	}
	 	return $methodList;
	 }
	 
	 public function getCurrentLangId(){
	 	$languages = $this->Session->read('Languages');
	 	$langId = 1;
	 	$locale =$this->Session->read ( 'Config.language' );
// 	 	echo $locale;
	 	foreach ($languages as $id=>$lang){
	 		if($lang['code_locale'] == $locale){
	 			$langId = $lang['id'];
	 			break;
	 		}
	 	}
	 	return $langId;
	 }
// 	 public function getLicensedUsersByStore($storeId){
// 	 	$userList = $this->User->getCustomList(array('status'=>1,'type'=>'store_admin'));
	 	
// 	 }
}
