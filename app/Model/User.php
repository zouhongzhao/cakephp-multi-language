<?php
App::uses('SimplePasswordHasher', 'Controller/Component/Auth');
App::uses('CakeSession', 'Model/Datasource');
class User extends AppModel{
	public $hasMany = array(
			'Profile' => array(
					'className' => 'UserSetting',
					'foreignKey' => 'user_id',
// 					'associatedKey'   => 'user_id',
// 					'dependent' => true,
					'exclusive'=>true
			),
			'StoreUser' => array(
					'className' => 'StoreUser',
					'foreignKey' => 'user_id',
// 					'associatedKey'   => 'user_id',
					// 					'dependent' => true,
					'exclusive'=>true
			),
			'MethodUser' => array(
					'className' => 'MethodUser',
					'foreignKey' => 'user_id',
					// 					'associatedKey'   => 'user_id',
					// 					'dependent' => true,
					'exclusive'=>true
			)
	);
	public $validate = array(
        'username' => array(
            'email' => array(
                'rule'     => 'email',
                'required' => true,
                'message'  => 'Username must be an email address'
            ),
            'isUnique' => array(
                'rule'    => 'checkUniqueUser',
               'message' => 'User with this username already exists'
            )
        ),
        'password' => array(
        	'confirmCheck' => array( 
		        'rule' => array('confirmCheck', 'password_confirm'), 
		        'message' => 'Please re-enter your password twice so that the values match',
		        'on' => 'create'
			)
        ),
		'old_password' => array(
					'ruleName' => array(
							'rule' => 'notEmpty',
							'message' => "Enter old password.",
							'last' => true
					),
					'ruleName2' => array(
							'rule' => array('isOldPasswordExists'),
							'message' => "Old password incorrect."
					)
						
			),
			'new_password' => array (
					'ruleName' => array (
							'rule' => 'notEmpty',
							'message' => "Enter confirm password."
					),
					'ruleName2' => array (
							'rule' => array (
									'matchOldPasswords',
									'old_password'
							),
							'message' => "New password cannot be same as old password."
					)
			),
			'new_password_confirm' => array (
					'ruleName' => array (
							'rule' => 'notEmpty',
							'message' => "Enter confirm password."
					),
					'ruleName2' => array (
							'rule' => array (
									'matchPasswords',
									'new_password'
							),
							'message' => "Password and confirm password not matching."
					)
			),
    );
	function checkUniqueUser() {
		$conditions = array(
				"User.username" => $this->data['User']['username']
		);
		if (isset($this->id)) {
			$conditions["User.id <>"] = $this->id;
		}
		return (0 === $this->find('count', array('conditions' => $conditions)));
// 		return ($this->find('count', array('conditions' => array('User.username' => $this->data['User']['username']))) == 0);
	}
	function matchOldPasswords($field = array(), $compare_field = null) {
		foreach ( $field as $key => $value ) {
			$v1 = trim ( $value );
			$v2 = trim ( $this->data [$this->name] [$compare_field] );
			if ($v1 != "" && $v2 != "" && $v1 == $v2) {
				return false;
			}
			return true;
		}
	}
	function isOldPasswordExists($field = array()) {
		$uid = CakeSession::read("Auth.User.id");
		foreach ( $field as $key => $value ) {
			$v1 = AuthComponent::password(trim($value));
			$result = $this->find ( 'first', array (
					'conditions' => array (
							'id' => $uid,
							'password' => $v1
					),
					'fields' => array (
							'id'
					)
			) );
			if (! is_array ( $result ) || empty($result)) {
				return false;
			}
			return true;
		}
	}
	function matchPasswords($field = array(), $compare_field = null) {
		foreach ( $field as $key => $value ) {
			$v1 = trim ( $value );
			$v2 = trim ( $this->data [$this->name] [$compare_field] );
			if ($v1 != "" && $v2 != "" && $v1 != $v2) {
				return false;
			}
				
			return true;
		}
	}
	function confirmCheck($field=array(), $compare_field=null){
		foreach( $field as $key => $value ){ 
            $v1 = $value; 
            $v2 = $this->data[$this->name][ $compare_field ];                  
            if($v1 !== $v2) { 
                return FALSE; 
            } else { 
                continue; 
            } 
        } 
        return TRUE; 
	}
	
	public function beforeSave($options = array()) {
		if (!empty($this->data[$this->alias]['password'])) {
            $passwordHasher = new SimplePasswordHasher();
            $this->data[$this->alias]['password'] = $passwordHasher->hash($this->data[$this->alias]['password']);
        }
		
        return true;
    }
    
    public function getAllList(){
    	return $this->find('list', array(
		        'fields' => array( 'username'),
		        'conditions' => array('status' => '1'),
		    	'order' => 'username ASC',
		        'recursive' => 0
		    ));
    }
    
    public function getCustomList($filters=array()){
    	return $this->find('list', array(
    			'fields' => array( 'username'),
    			'conditions' => $filters,
    			'order' => 'username ASC',
    			'recursive' => 0
    	));
    }
}
?>