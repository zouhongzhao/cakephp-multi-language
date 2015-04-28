<?php
App::uses('AppController', 'Controller');
class DashboardController extends AppController {
    public function home(){

    }
    
	public function changeLanguage($lang){
//         $lang = strtolower($lang);
        if(!empty($lang)){
 			$this->Session->write('Config.language', $lang);
 			Configure::write('Config.language',$lang);
        }
        $this->redirect($this->referer());
    }
}