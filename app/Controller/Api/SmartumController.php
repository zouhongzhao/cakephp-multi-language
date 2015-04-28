<?php
App::import('Controller', 'Api');
// App::uses('ApiController','AppController', 'Controller');
// App::uses('AppHelper', 'View/Helper');
// App::uses('AppCakeEmail', 'Lib/Network/Email');
class SmartumController extends ApiController {
	public $_cookie_file = null;
// 	public $_debug_cookie_file = null;
	public $_user_agent = null;
	public $_curl = null;
	public $_headers = array(
											'Content-Type: application/x-www-form-urlencoded',
											'Accept: application/json'
										);
	public $_headers2 = array(
			'Content-Type: application/json',
			'Accept: application/json'
	);
	public function beforeFilter() {
		if(is_null($this->_cookie_file)){
			if(!is_dir(TMP."cookie")){
				mkdir(TMP."cookie",0777);
			}
			$this->_cookie_file = TMP. "cookie/cookie_" . md5 ( basename ( __FILE__ ) ) . ".txt";
			file_put_contents($this->_cookie_file, '');
		}
// 		if(is_null($this->_debug_cookie_file)){
// 			if(!is_dir(TMP."cookie")){
// 				mkdir(TMP."cookie",0777);
// 			}
// 			$this->_debug_cookie_file = TMP. "cookie/debug_cookie_" . md5 ( basename ( __FILE__ ) ) . ".txt";
// 			file_put_contents($this->_debug_cookie_file, '');
// 		}
		if(is_null($this->_user_agent)){
			$this->_user_agent = "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.89 Safari/537.36";
		}
		$this->Auth->allow();

	}
	
    //api
    public function apiLogin(){
    		if(is_null($this->_curl)){
    			session_start();
				$data = isset($this->request->data)?$this->request->data:array();
				if(isset($data['username']) && isset($data['password'])){
// 					$this->Session->write('Api.api',$data['api']);
// 					$this->Session->write('Api.username',$data['username']);
// 					$this->Session->write('Api.password',$data['password']);
						$_SESSION['Api.api']=$data['api'];
						$_SESSION['Api.username']=$data['username'];
						$_SESSION['Api.password']=$data['password'];
				}
				$fields = array(
						'username'=>$_SESSION['Api.username'],
						'password'=>$_SESSION['Api.password']
				);
// 				 print_r($fields2);die;
				$result = array();
				$result['status'] = false;
				$apiInfo = $this->vlogin($_SESSION['Api.api'], $fields);
				$apiInfo =  json_decode($apiInfo);
				if(isset($apiInfo->data)){
					$apiInfo = $apiInfo->data;
					if(isset($apiInfo->success) && $apiInfo->success){
						return;
					}
				}
				$result['data'] = $apiInfo;
				echo json_encode($result);
				exit();
			}
    }
    
    public function ajaxCheckLogin(){
    	if ($this->request->is('ajax')) {
    		$this->autoRender = false;
    		$data = $this->request->data;
//     		$fields = array(
//     				'username'=>$data['username'] ,
//     				'password'=>$data['password'] ,
//     		);
			$result = array();
			$result['status'] = false;
			$this->apiLogin();
    		$resultInfo = $this->vget($data['url']);
    		$resultInfo =  json_decode($resultInfo);
    		$resultInfo = $this->objectToArray($resultInfo->data);
    		$result['data'] = $resultInfo;
			if($resultInfo){
				$apiBuyerName = $resultInfo['firstName'] .' '. $resultInfo['lastName'];
// 				if($data['buyerName'] != $apiBuyerName){
// 					$result['data'] = __('The buyer name is not the same!');
// 					echo json_encode($result);
// 					exit();
// 				}
				$result['status'] = true;
			}
			echo json_encode($result);
    		exit(); 
    	}
    }
    
    public function ajaxChangeRole(){
    	if ($this->request->is('ajax')) {
    		$this->autoRender = false;
    		$data = $this->request->data;
    		$fields = array(
    				'customerId'=>$data['customerId'] ,
    				'role'=>$data['role'] ,
    		);
    		$result = array();
    		$result['status'] = false;
    		$this->apiLogin();
//     		if(is_null($this->_curl)){
//     			$apiInfo = $this->vlogin($data['api'], $fields);
    			 
//     			$apiInfo =  json_decode($apiInfo);
//     			$apiInfo = $apiInfo->data;
//     			if(isset($apiInfo->status) && $apiInfo->status == 'error'){
//     				$result['data'] = $apiInfo->message;
//     				echo json_encode($result);
//     				exit();
//     			}
//     		}
    
    		$resultInfo = $this->vpost($data['url'],$fields);
   			
    		$resultInfo =  json_decode($resultInfo);
    		$resultInfo = $this->objectToArray($resultInfo->data);
    		$result['data'] = $resultInfo;
    		if($resultInfo){
    			$result['status'] = true;
    		}
    		echo json_encode($result);
    		exit();
    	}
    }
    
    public function ajaxGetScoreInfo(){
    	if ($this->request->is('ajax')) {
    		$this->autoRender = false;
    		$data = $this->request->data;
    		//     		$fields = array(
    		//     				'username'=>$data['username'] ,
    		//     				'password'=>$data['password'] ,
    		//     		);	EXERCISE_AND_CULTURE_EMONEY
    		$allowItemMethods = $this->objectToArray(json_decode($data['allowItemMethods']));
    		$extraInfo = $this->objectToArray(json_decode($data['extraInfo']));
    		$method = $data['method'];
    		$result = array();
    		$result['status'] = false;
    		$this->apiLogin();
    		$resultInfo = $this->vget($data['url']);
    		$resultInfo =  json_decode($resultInfo);
    		$resultInfo = $this->objectToArray($resultInfo->data);
//     		print_r($resultInfo);die;
    		$result['data']['accounts'] = array();
    		$result['data']['origin'] = array();
//     		$result['data'] = $resultInfo;
    		if($resultInfo){
    			$result['status'] = true;
    			if($method == 'smartum'){
    				if(isset($allowItemMethods['smartum'])){
    					$result['data']['accounts']['exercise'] = array(
    																									'code' => 'exercise',
    																									'label' => 'EXERCISE_EMONEY',
    																									'type'=>'EXERCISE_EMONEY',
    																									'value' => empty($allowItemMethods['smartum']['exercise'])?0:array_sum($allowItemMethods['smartum']['exercise'])
    																								);
//     					if(!empty($allowItemMethods['smartum']['culture'])){
    						$result['data']['accounts']['culture'] = array(
						    																										'code' => 'culture',//exercise_and_culture
						    																										'label' => 'CULTURE_EMONEY',//EXERCISE_AND_CULTURE_EMONEY
    																																'type'=>'CULTURE_EMONEY',
						    																										'value' =>empty($allowItemMethods['smartum']['culture'])?0:array_sum($allowItemMethods['smartum']['culture'])
    																														);
    						//$result['data']['accounts']['exercise_and_culture']['value'] += $result['data']['accounts']['exercise']['value'];
//     					}
    				}
//     				print_r($result['data']['accounts']);
    				if(isset($extraInfo['smartum'])){
    					//     						print_r($extraInfo['smartum']);
    					foreach ($extraInfo['smartum'] as $key=>$value){
    						foreach ($result['data']['accounts'] as $type=>$row){
    							if($key == $row['label']){
    								$result['data']['accounts'][$type]['value'] -= $value/100;
    							}
    						}
    					}
    				}
//     				print_r($result['data']['accounts']);
    				if($resultInfo['accounts']){
    					if(count($resultInfo['accounts']) > 1){
    						$tmpBalance = array();
    						foreach ($resultInfo['accounts'] as $account){
    							$balance = $account['balance']/100;
    							if($account['itemName'] == 'EXERCISE_AND_CULTURE_EMONEY'){
    								$tmpBalance['CULTURE_EMONEY'] = $balance;
    							}
    							if(!isset($tmpBalance['EXERCISE_EMONEY'])){
    								$tmpBalance['EXERCISE_EMONEY'] =  $balance;
    							}else{
    								$tmpBalance['EXERCISE_EMONEY'] +=  $balance;
    							}
    							
    							$result['data']['origin'][$account['itemName']] =  $balance;
    						}
//     						print_r($tmpBalance);
//     						print_r($result['data']['accounts']);
							if($tmpBalance['EXERCISE_EMONEY'] < $result['data']['accounts']['exercise']['value']){
								$result['data']['accounts']['exercise']['value'] = $tmpBalance['EXERCISE_EMONEY'];
							}
							if($tmpBalance['CULTURE_EMONEY'] < $result['data']['accounts']['culture']['value']){
								$result['data']['accounts']['culture']['value'] = $tmpBalance['CULTURE_EMONEY'];
							}
    						$result['data']['type'] = 2;
    					}else{
    						$account = reset($resultInfo['accounts']);
    						$balance = $account['balance']/100;
    						$result['data']['origin'][$account['itemName']] = $balance;
    						if($account['itemName'] == 'EXERCISE_EMONEY'){
    							if($balance < $result['data']['accounts']['exercise']['value']){
    								$result['data']['accounts']['exercise']['value'] = $balance;
    							}
    							unset($result['data']['accounts']['culture']);
    						}elseif($account['itemName'] == 'EXERCISE_AND_CULTURE_EMONEY'){
    							if($balance < $result['data']['accounts']['exercise']['value']){
    								$result['data']['accounts']['exercise']['value'] = $balance;
    							}
    							if($balance < $result['data']['accounts']['culture']['value']){
    								$result['data']['accounts']['culture']['value'] = $balance;
    							}
//     							unset($result['data']['accounts']['exercise']);
    						}
    						$result['data']['type'] = 1;
    					}

    				}
    			}
    		}
//     		print_r($result['data']);die;
    		echo json_encode($result);
    		exit();
    	}
    }
    public function ajaxSetVenuesMoney(){
        if ($this->request->is('ajax')) {
    		$this->autoRender = false;
    		$data = $this->request->data;
    		$fields = array(
    				'amount'=> (int)$data['amount'],
    				'type'=>trim($data['type']),
    				'message'=>$data['message']
    		);
    		$result = array();
    		$result['status'] = false;
    		$this->apiLogin();
    		//change role
    		$roleFields = array(
    				'customerId'=>$data['role_id'],
    				'role'=>'ROLE_COMPANY_BENEFICIARY' ,
    		);
    		$resultInfo = $this->vpost('http://core.dev.smartum.fi/api/change_role',$roleFields);
    		$status_code = curl_getinfo($this->_curl, CURLINFO_HTTP_CODE);
    		$result['data'] = $status_code;
    		if($status_code){
    			$resultInfo = $this->vpost($data['url'],$fields);
    			$status_code = curl_getinfo($this->_curl, CURLINFO_HTTP_CODE);
    			$this->loadModel('OrderMethod');
    			$this->OrderMethod->id = $data["order_methods_id"];
    			$this->OrderMethod->saveField('response',serialize($resultInfo));
    			if($status_code == 201){
    				$result['status'] = true;
    				$result['data'] = $status_code;
    				$extra_info = serialize($this->objectToArray(json_decode($data['extra_info'])));
    				$this->OrderMethod->saveField('extra_info',$extra_info);
    			}else{
    				$resultInfo =  json_decode($resultInfo);
//     				print_r(curl_getinfo($this->_curl));
//     				$resultInfo = $this->objectToArray($resultInfo->data);
    				$result['data'] = $resultInfo;
    			}
    		}
    		echo json_encode($result);
    		exit();
    	}
    }
    
    public function refund($data=array()){
    	$result = array();
    	$result['status'] = false;
    	$this->apiLogin();
    	$resultInfo = $this->vpatch($data['url']);
    	$status_code = curl_getinfo($this->_curl, CURLINFO_HTTP_CODE);
    	if($status_code == 204){
    		$result['status'] = true;
    	}else{
    		$result['data'] = json_decode($resultInfo);
    	}
    	return $result;
    }
    //debug
    public function debug($step=1){
    	$this->debugLogin();
    	switch ($step) {
    		case 1:
    			//users/current
    			$url = 'http://core.dev.smartum.fi/api/users/current';
    			$resultInfo = $this->vget($url);
    			$resultInfo =  json_decode($resultInfo);
    		break;
    		case 2:
    			//change_role
    			$url = 'http://core.dev.smartum.fi/api/change_role';
    			$fields = array(
    					'customerId'=>1 ,
    					'role'=>'ROLE_COMPANY_BENEFICIARY'
    			);
    			$resultInfo = $this->vpost($url,$fields);
    		break;
    		case 3:
    			//score
    			$url = 'http://core.dev.smartum.fi/api/companies/1/users/4/accounts/company_beneficiary';
    			$resultInfo = $this->vget($url);
    			$resultInfo =  json_decode($resultInfo);
    		break;
    		case 4:
    			//checkout
    			$url = 'http://core.dev.smartum.fi/api/venues/6/emoney';
    			$fields = array(
    					'amount'=>1000,
    					'type'=>'CULTURE_EMONEY',
    					'message'=>'Iggo Test'
    			);
    			$resultInfo = $this->vpost($url,$fields);
    					;
    		break;
    		default:
    			;
    		break;
    	}
        echo "<pre>";
    	print_r($resultInfo);die;
    }
    public function debugLogin(){
    	if(is_null($this->_curl)){
    		$api = 'http://core.dev.smartum.fi/api/login';
    		$fields = array(
    				'username'=>'company-1-company-beneficiary@mailinator.com',
    				'password'=>'sagapo'
    		);
    		$apiInfo = $this->vlogin($api, $fields);
    		$apiInfo =  json_decode($apiInfo);
    		$apiInfo = $apiInfo->data;
    		if(isset($apiInfo->status) && $apiInfo->status == 'error'){
    			echo "login fail!";
    			exit();
    		}
    	}
    }
}
?>
