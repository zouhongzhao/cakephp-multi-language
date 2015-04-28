<?php
/**
* User Settings  Model class
*/
class UserSetting extends AppModel {
	//public $name = "UserSettings";
	//public $useTable = "user_settings";
// 	public $primaryKey = 'user_id';
	var $validate = array (

	);
	
	public function getUserSettingsValue($uid='',$group='',$name=''){
		if(empty($uid) || empty($group) || empty($name)){
			return false;
		}
		$details = $this->find ( 'first', array (
				"conditions" => array('user_id ' => $uid,'group'=>$group,'name'=>$name),
				"fields" => array (
						"value"
				)
		) );
		return $details;
	}
	
	public function saveAndUpdateSetting($id,$data=array()){
		foreach ($data as $group=>$items){
			foreach ($items as $name=>$value){
				if(is_array($value)){
					$value = serialize($value);
				}
				$setting_details =  $this->getUserSettingsValue($id,$group,$name);
				try {
					if(empty($setting_details)){
						//save
						//echo $id.'||'.$name."||".$value."<br>";
						$this->save(array(
										'user_id' => $id,
										'group' => $group,
										'name' => $name,
										'value'=>$value
						));
						$this->clear();
					}else{
						//update
// 						echo $value.'|'.$group.'|'.$name;die;
						$this->updateAll(
								array( 'value' =>"'".$value."'"),
								array( 'user_id' => $id,'group'=>$group,'name'=>$name));
					}
				} catch (Exception $e) {
// 					echo $e->getMessage();die;
				}

			}
		}
		return true;
	}
	public function setToken($id=null,$name=null,$value=null){
		if(empty($id) || empty($name) || empty($value)){
			return false;
		}
		$group = 'temp';
// 		$name = 'email_change_token';
		$setting_details =  $this->getUserSettingsValue($id,$group,$name);
		
// 		echo $value."<br />";
		try {
			if(empty($setting_details)){
				//save
// 				echo $value."<br />";
				$this->save(array(
								'user_id' => $id,
								'group' => $group,
								'name' => $name,
								'value'=>$value
				));
				$this->clear();
			}else{
				//update
// 				echo $value."<br />";
				$this->updateAll(
						array( 'value' =>"'".$value."'"),
						array( 'user_id' => $id,'group'=>$group,'name'=>$name));
			}
		} catch (Exception $e) {
// 			echo $e->getMessage();die;
		}
		return $value;
	}
	
	public function deleteRow($id=null,$group=null,$name=null){
		if(empty($id) || empty($group) || empty($name)){
			return  false;
		}
		$conditions = array('user_id' => $id,'group'=>$group,'name'=>$name);
		return $this->deleteAll($conditions, false);
	}
}