<?php
$config = array (
  	'levels' =>array(
				'1'=> __('Normal User',true),
				'2'=> __('Manager',true),
				'3'=> __('Admin',true),
				'4'=>__('Owner',true),
				'5'=>__('Super Admin',true)
		),
	'status'=>array(
				'1'=> __('Active',true),
				'2'=> __('Inactive',true),
				'3'=> __('Disabled',true)
		),
	'store_user_levels'=>array(
				'0'=>0,
				'1'=> 1,
				'2'=> 2,
				'3'=> 3,
				'4'=> 4,
				'5'=> 5,
		),
	'store_api_levels'=>array(
				'0'=>0,
				'1'=> 1,
				'2'=> 2,
				'3'=> 3,
				'4'=> 4,
				'5'=> 5,
		),
	'store_status'=>array(
				'1'=> __('Active',true),
				'0'=> __('Inactive',true),
		),
	'user_types'=>array(
			'super_admin'=> __('Super Admin',true),
			'payment_admin'=> __('Payment Admin',true),
			'store_admin'=> __('Store Admin',true),
	),
	'method_status'=>array(
				'1'=> __('Active',true),
				'0'=> __('Inactive',true),
		),
	'method_user_levels'=>array(
				'0'=>0,
				'1'=> 1,
				'2'=> 2,
				'3'=> 3,
				'4'=> 4,
				'5'=> 5,
		),
	'normal_status'=>array(
				'1'=> __('Yes',true),
				'0'=> __('No',true),
	),
	'payment_status'=>array(
				'0'=> __('Waiting',true),
				'1'=> __('Complete',true),
				'2'=> __('Failed',true),
	),
	'store_method_types'=>array(
				'free'=> __('free',true),
				'payall'=> __('payall',true)
		),
	'method_types'=>array(
				'2'=> __('Cash',true),
				'1'=> __('Point',true)
	),
	'order_status'=>array(
				'1'=> __('Waiting',true),
				'2'=> __('Complete',true),
				'3'=> __('Cancel',true)
	),
	'order_method_status'=>array(
				'0'=> __('Waiting',true),
				'1'=> __('Complete',true),
				'2'=> __('Failed',true),
				'3'=> __('Refund Done',true),
				'4'=> __('Refund Unfinished',true)
	),
);

define("USER_ADMIN_LEVEL", 5);
define("USER_MANAGER_LEVEL", 3);
define("USER_NORMAL_LEVEL", 1);

define("ITEM_DEFAULT_TITLE", "Cakephp #");
define("TITLE", "Cakephp");
App::build(array('Controller' => array(ROOT.DS.'app/Controller/Api/')));
Configure::write('Config.language', 'en_US');
// Configure::write('Routing.prefixes', array('api'));
?>