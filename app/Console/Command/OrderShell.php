<?php
App::import('Shell','Cron');
/* App::uses('Controller', 'Controller');
App::uses('AppController', 'Controller'); */

class OrderShell extends CronShell {
	public $uses = array('Order','Method','OrderMethod');
	function resendNotification(){
		echo "START====================================>\nResend Notification ... \r\n";
		$orders = $this->Order->find('all', array(
				'conditions' => array('Order.notification_sent' => 0),
				'recursive' => -1
		));
		$total = count($orders);
		$num = 0;
		if(!empty($orders)){
			foreach ($orders as $order){
				$params = unserialize($order['Order']['params']);
				$orderId = $order['Order']['id'];
				$num ++;
				echo "order id:{$orderId}. ... ({$num}/$total) ... ";
				if(empty($params)){
					echo "\r\npost data is empty.. ignore\r\n";
					continue;
				}
				$params = $this->array_splice_assoc($params, 'TOTAL_AMOUNT', 0, array('TOTAL_PAID' => $order['Order']['total_paid']));
				$URL= $order['Order']['success_address'];
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL,$URL);
				curl_setopt($ch, CURLOPT_TIMEOUT, 30); //timeout after 30 seconds
				curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
				curl_setopt($ch, CURLOPT_POST, 1);
				curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
				$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);   //get status code
				$result=curl_exec ($ch);
				curl_close ($ch);
				print_r($status_code);
				print_r($result);
				$this->Order->id = $orderId;
				if($this->Order->saveField('notification_sent',1)){
					echo "ok\r\n";
				}else{
					echo "fail\r\n";
				}
				$this->Order->clear();
			}
		}else{
			echo "has no order!\r\n";
		}
		echo "DONE!\n";
	}
	
	public function orderTimeoutCheck(){
		echo "START====================================>\nTimeout Check ... \r\n";
		$orders = $this->Order->find('all', array(
				'conditions' => array('Order.status' => 1),
// 				'recursive' => -1
		));
		$total = count($orders);
		$num = 0;
		if(!empty($orders)){
			foreach ($orders as $order){
				$params = unserialize($order['Order']['params']);
				$orderId = $order['Order']['id'];
				$num ++;
				echo "order id:{$orderId}. ... ({$num}/$total) ... ";
				if(empty($params)){
						echo "\r\npost data is empty.. ignore\r\n";
						continue;
				}
				$timeLimitation = $params['TIME_LIMITATION'];
				$startTime = strtotime($order['Order']['created_at']);
				$difference =  $timeLimitation - (time() - $startTime);
				if($difference > 0){
					echo "\r\ntime normal .. ignore\r\n"; 
					continue;
				}
				$this->orderRefund($order);
				$params = $this->array_splice_assoc($params, 'TOTAL_AMOUNT', 0, array('TOTAL_PAID' => $order['Order']['total_paid']));
				$URL= $order['Order']['cancel_address'];
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL,$URL);
				curl_setopt($ch, CURLOPT_TIMEOUT, 30); //timeout after 30 seconds
				curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
				curl_setopt($ch, CURLOPT_POST, 1);
				curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
				$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);   //get status code
				$result=curl_exec ($ch);
				curl_close ($ch);
				echo "ok\r\n";
				//print_r($status_code);
				//print_r($result);
			}
			}else{
			echo "has no order!\r\n";
		}
		echo "DONE!\n";
	}

	function orderRefund($order){
		if(!isset($order['OrderMethod']) || empty($order['OrderMethod'])){
			return false;
		}
		$refundArray = array();
		$methodsArray = array();
		$filters = array();
		$orderId = $order['Order']['id'];
		if($order['Order']['methods'] != 'ALL'){
			$filters['Method.code'] = explode(',', $order['Order']['methods']);
		}
		$methods = $this->Method->getMethodsByStore($order['Order']['store_id'],$filters);
		foreach ( ( array ) $methods as $key=>$method ) {
			$methods[$key]['StoreMethod'] = $method['StoreMethod'][0];
			if(isset($method['StoreMethodCurrencie'][0])){
				$methods[$key]['StoreMethodCurrencie'] = $method['StoreMethodCurrencie'][0];
			}
			if(empty($method['StoreMethod'][0]['title'])){
				$method['StoreMethod'][0]['title'] = $method['Method']['name'];
			}
			$methodsArray[$method['Method']['id']] = $method['StoreMethod'][0];
		}
		foreach((array)$order['OrderMethod'] as $method){
			if($method['status'] == 1){
				$refundDay = $methodsArray[$method['method_id']]['refund_days'];
				if(!isset($refundArray[$refundDay][$method['method_id']])){
					$refundArray[$refundDay][$method['method_id']] = array('id'=>$method['method_id'],'total'=>0,'points'=>0);
				}
				$refundArray[$refundDay][$method['method_id']]['total'] +=  $method['total'];
				$refundArray[$refundDay][$method['method_id']]['points'] +=  $method['exchange_rate'] != '0' && $method['exchange_rate'] != '1'?$method['total'] / $method['exchange_rate']:$method['total'];
			}
		}
		$params = unserialize($order['Order']['params']);
		$orderMethods = $order['OrderMethod'];
		//     		$totalPaid = $order['Order']['total_paid'];
		$refundMethods = array();
		if(!empty($refundArray)){
			foreach ($refundArray as $day=>$methods){
				foreach ($methods as $id=>$method){
					$this->Method->id = $id;
					$code=$this->Method->field('code');
					$this->Method->clear();
					$func = 'refund';
					foreach ($orderMethods as $_orderMethod){
						if($_orderMethod['method_id'] == $id && $_orderMethod['status'] == 1){
							$response = unserialize($_orderMethod['response']);
							$status = 4;
							$this->OrderMethod->id = $_orderMethod['id'];
							$this->OrderMethod->saveField('status',$status);
							$error=$this->OrderMethod->field('error');
							$this->OrderMethod->saveField('error',$error."\r\n".serialize($response));
							$this->OrderMethod->clear();
						}
					}
				}
				//     			$totalPaid -= $row['total'];
			}
		}
		
		//change order status
		$this->Order->id = $orderId;
		$this->Order->saveField('status',3);
		$this->Order->saveField('total_paid',0);
		$this->Order->clear();
		return true;
	}
}