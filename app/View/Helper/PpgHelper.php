<?php  
App::uses('Helper', 'View');
/**
 * Application helper
 *
 * Add your application-wide methods in the class below, your helpers
 * will inherit them.
 *
 * @package       app.View.Helper
 */
class PpgHelper extends AppHelper 
{ 
	var $helpers = array ('Html', 'Form', 'Session'); 
	public function checkUserRight(){
		$type = $this->Session->read('Auth.User.type');
		if($type == 'payment_admin'){
			if($methodUsers = $this->Session->read('User.MethodIds')){
				foreach ((array)$methodUsers as $level){
					if($level > 3){
						return true;
					}
				}
			}
		}elseif($type == 'store_admin'){
			if($storeUsers = $this->Session->read('User.StoreIds')){
				foreach ((array)$storeUsers as $level){
					if($level > 3){
						return true;
					}
				}
			}
		}else{
			return true;
		}
		return false;
	}
	
	public static function getOrderMethodStatus($key=null)
	{
		$options = Configure::read('order_method_status');
		// 		var_dump($options);
		// 		var_dump($options[0]);
		if(!is_null($key)){
			return $options[$key];
		}
		return $options;
	}
	public static function getOrderStatus($key=null)
	{
		$options = Configure::read('order_status');
		// 		var_dump($options);
		// 		var_dump($options[0]);
		if(!is_null($key)){
			return $options[$key];
		}
		return $options;
	}
	
	public function getLevels($key=null)
	{
		$options = Configure::read('levels');
		if(!is_null($key)){
			return $options[$key];
		}
		$user = $this->Session->read("Auth.User");
		if($user['type'] == 'store_admin'){
			return array(1=>$options[1]);
		}elseif ($user['type'] == 'payment_admin'){
			return array(1=>$options[1]);
// 			return array_splice($options, $user['level'],count($options));
		}
		return $options;
	}
	public static function getStoreMethodTypes($key=null)
	{
		$options = Configure::read('store_method_types');
		// 		var_dump($options);
		// 		var_dump($options[0]);
		if(!is_null($key)){
			return $options[$key];
		}
		return $options;
	}
	public static function getMethodTypes($key=null)
	{
		$options = Configure::read('method_types');
		// 		var_dump($options);
		// 		var_dump($options[0]);
		if(!is_null($key)){
			return $options[$key];
		}
		return $options;
	}
	public static function getStoreStatus($key=null)
	{
		$options = Configure::read('store_status');
// 		var_dump($options);
// 		var_dump($options[0]);
		if(!is_null($key)){
			return $options[$key];
		}
		return $options;
	}
	
	public static function getNormalStatus($key=null)
	{
		$options = Configure::read('normal_status');
		// 		var_dump($options);
		// 		var_dump($options[0]);
		if(!is_null($key)){
			return $options[$key];
		}
		return $options;
	}
	
	public static function getPaymentStatus($key=null)
	{
		$options = Configure::read('payment_status');
		// 		var_dump($options);
		// 		var_dump($options[0]);
		if(!is_null($key)){
			return $options[$key];
		}
		return $options;
	}
	
	public static function getMethodStatus($key=null)
	{
		$options = Configure::read('method_status');
		// 		var_dump($options);
		// 		var_dump($options[0]);
		if(!is_null($key)){
			return $options[$key];
		}
		return $options;
	}
	
	
	public static function getStatus($key=null)
	{
		$options = Configure::read('status');
		if(!is_null($key)){
			return $options[$key];
		}
		return $options;
	}
	public static function getStoreUserLevels($key=null)
	{
		$options = Configure::read('store_user_levels');
		if(!is_null($key)){
			return $options[$key];
		}
		return $options;
	}
	public static function getMethodUserLevels($key=null)
	{
		$options = Configure::read('method_user_levels');
		if(!is_null($key)){
			return $options[$key];
		}
		return $options;
	}
// 	public static function getStoreUserMaxLevels($maxLevel=null)
// 	{
// 		$options = Configure::read('store_user_levels');
// 		if(!is_null($maxLevel)){
// 			return array_slice($options,0,$maxLevel,true);
// 		}
// 		return $options;
// 	}
	public static function getStoreApiLevels($key=null)
	{
		$options = Configure::read('store_api_levels');
		if(!is_null($key)){
			return $options[$key];
		}
		return $options;
	}
	public function getUserTypes($key=null)
	{
		$options = Configure::read('user_types');
		if(!is_null($key)){
			return $options[$key];
		}
		$user = $this->Session->read("Auth.User");
		if($user['type'] != 'super_admin'){
			return array($user['type']=>$options[$user['type']]);
		}
		return $options;
	}
	function showLevel($maxLevel){
		$result = $this->getLevels();
		return array_slice($result,0,$maxLevel,true);
	}
	
	function showStatus(){
		return $this->getStatus();
	}
	function showStoreUserLevel($maxLevel){
		$result = $this->getStoreUserLevels();
		return array_slice($result,0,$maxLevel+1,true);
	}
	function showMethodUserLevel($maxLevel){
		$result = $this->getMethodUserLevels();
		return array_slice($result,0,$maxLevel+1,true);
	}
	function showStoreApiLevel($maxLevel){
		$result = $this->getStoreApiLevels();
		return array_slice($result,0,$maxLevel+1,true);
	}
    function getList() 
    { 
    	return array(
    		'' => __('Please select a country', true),
    		'AF' =>    __('Afganistan', true), 
            'AL' =>    __('Albania', true), 
            'DZ' =>    __('Algeria', true), 
            'AS' => __('American Samoa', true), 
            'AD' => __('Andorra', true),  
            'AO' => __('Angola', true), 
            'AI' => __('Anguilla', true), 
            'AQ' => __('Antarctica', true), 
            'AG' => __('Antigua and Barbuda', true),  
            'AR' => __('Argentina', true),  
            'AM' => __('Armenia', true),  
            'AW' => __('Aruba', true),  
            'AU' => __('Australia', true),  
            'AT' => __('Austria', true),  
            'AZ' => __('Azerbaijan', true), 
            'BS' => __('Bahamas', true),  
            'BH' => __('Bahrain', true),  
            'BD' => __('Bangladesh', true), 
            'BB' => __('Barbados', true), 
            'BY' => __('Belarus', true),  
            'BE' => __('Belgium', true),  
            'BZ' => __('Belize', true), 
            'BJ' => __('Benin', true),  
            'BM' => __('Bermuda', true),  
            'BT' => __('Bhutan', true), 
            'BO' => __('Bolivia', true),  
            'BA' => __('Bosnia and Herzegowina', true), 
            'BW' => __('Botswana', true), 
            'BV' => __('Bouvet Island', true),  
            'BR' => __('Brazil', true), 
            'IO' => __('British Indian Ocean Territory', true), 
            'BN' => __('Brunei Darussalam', true),  
            'BG' => __('Bulgaria', true), 
            'BF' => __('Burkina Faso', true), 
            'BI' => __('Burundi', true),  
            'KH' => __('Cambodia', true), 
            'CM' => __('Cameroon', true), 
            'CA' => __('Canada', true), 
            'CV' => __('Cape Verde', true), 
            'KY' => __('Cayman Islands', true), 
            'CF' => __('Central African Republic', true), 
            'TD' => __('Chad', true), 
            'CL' => __('Chile', true),  
            'CN' => __('China', true), 
            'CX' => __('Christmas Island', true),     
            'CC' => __('Cocos (Keeling) Islands', true),  
            'CO' => __('Colombia', true), 
            'KM' => __('Comoros', true),  
            'CG' => __('Congo', true),  
            'CD' => __('Congo, the Democratic Republic of the', true),  
            'CK' => __('Cook Islands', true), 
            'CR' => __('Costa Rica', true), 
            'CI' => __('Cote d\'Ivoire', true),  
            'HR' => __('Croatia (Hrvatska)', true), 
            'CU' => __('Cuba', true), 
            'CY' => __('Cyprus', true), 
            'CZ' => __('Czech Republic', true), 
            'DK' => __('Denmark', true),  
            'DJ' => __('Djibouti', true), 
            'DM' => __('Dominica', true), 
            'DO' => __('Dominican Republic', true), 
            'TP' => __('East Timor', true), 
            'EC' => __('Ecuador', true),  
            'EG' => __('Egypt', true),  
            'SV' => __('El Salvador', true),  
            'GQ' => __('Equatorial Guinea', true),  
            'ER' => __('Eritrea', true),  
            'EE' => __('Estonia', true),  
            'ET' => __('Ethiopia', true), 
            'FK' => __('Falkland Islands (Malvinas)', true),  
            'FO' => __('Faroe Islands', true),  
            'FJ' => __('Fiji', true), 
            'FI' => __('Finland', true), 
            'FR' => __('France', true), 
            'FX' => __('France, Metropolitan', true), 
            'GF' => __('French Guiana', true),  
            'PF' => __('French Polynesia', true), 
            'TF' => __('French Southern Territories', true),  
            'GA' => __('Gabon', true),  
            'GM' => __('Gambia', true), 
            'GE' => __('Georgia', true),  
            'DE' => __('Germany', true),  
            'GH' => __('Ghana', true),  
            'GI' => __('Gibraltar', true),  
            'GR' => __('Greece', true), 
            'GL' => __('Greenland', true),  
            'GD' => __('Grenada', true),  
            'GP' => __('Guadeloupe', true), 
            'GU' => __('Guam', true), 
            'GT' => __('Guatemala', true),  
            'GN' => __('Guinea', true), 
            'GW' => __('Guinea-Bissau', true),  
            'GY' => __('Guyana', true), 
            'HT' => __('Haiti', true),  
            'HM' => __('Heard and Mc Donald Islands', true),  
            'VA' => __('Holy See (Vatican City State)', true),  
            'HN' => __('Honduras', true), 
            'HK' => __('Hong Kong', true),  
            'HU' => __('Hungary', true),  
            'IS' => __('Iceland', true),  
            'IN' => __('India', true),  
            'ID' => __('Indonesia', true),  
            'IR' => __('Iran (Islamic Republic of)', true), 
            'IQ' => __('Iraq', true), 
            'IE' => __('Ireland', true),  
            'IL' => __('Israel', true), 
            'IT' => __('Italy', true),  
            'JM' => __('Jamaica', true),  
            'JP' => __('Japan', true), 
            'JO' => __('Jordan', true), 
            'KZ' => __('Kazakhstan', true), 
            'KE' => __('Kenya', true),  
            'KI' => __('Kiribati', true), 
            'KP' => __('Korea, Democratic People\'s Republic of', true), 
            'KR' => __('Korea, Republic of', true), 
            'KW' => __('Kuwait', true), 
            'KG' => __('Kyrgyzstan', true), 
            'LA' => __('Lao People\'s Democratic Republic', true), 
            'LV' => __('Latvia', true), 
            'LB' => __('Lebanon', true), 
            'LS' => __('Lesotho', true),  
            'LR' => __('Liberia', true),  
            'LY' => __('Libyan Arab Jamahiriya', true), 
            'LI' => __('Liechtenstein', true),  
            'LT' => __('Lithuania', true), 
            'LU' => __('Luxembourg', true), 
            'MO' => __('Macau', true),  
            'MK' => __('Macedonia, The Former Yugoslav Republic of', true), 
            'MG' => __('Madagascar', true), 
            'MW' => __('Malawi', true), 
            'MY' => __('Malaysia', true), 
            'MV' => __('Maldives', true), 
            'ML' => __('Mali', true), 
            'MT' => __('Malta', true), 
            'MH' => __('Marshall Islands', true), 
            'MQ' => __('Martinique', true), 
            'MR' => __('Mauritania', true), 
            'MU' => __('Mauritius', true), 
            'YT' => __('Mayotte', true),  
            'MX' => __('Mexico', true), 
            'FM' => __('Micronesia, Federated States of', true), 
            'MD' => __('Moldova, Republic of', true), 
            'MC' => __('Monaco', true), 
            'MN' => __('Mongolia', true), 
            'MS' => __('Montserrat', true), 
            'MA' => __('Morocco', true), 
            'MZ' => __('Mozambique', true), 
            'MM' => __('Myanmar', true), 
            'NA' => __('Namibia', true), 
            'NR' => __('Nauru', true),  
            'NP' => __('Nepal', true),  
            'NL' => __('Netherlands', true), 
            'AN' => __('Netherlands Antilles', true), 
            'NC' => __('New Caledonia', true), 
            'NZ' => __('New Zealand', true),  
            'NI' => __('Nicaragua', true),  
            'NE' => __('Niger', true),  
            'NG' => __('Nigeria', true),  
            'NU' => __('Niue', true), 
            'NF' => __('Norfolk Island', true), 
            'MP' => __('Northern Mariana Islands', true), 
            'NO' => __('Norway', true), 
            'OM' => __('Oman', true), 
            'PK' => __('Pakistan', true), 
            'PW' => __('Palau', true), 
            'PA' => __('Panama', true), 
            'PG' => __('Papua New Guinea', true), 
            'PY' => __('Paraguay', true), 
            'PE' => __('Peru', true), 
            'PH' => __('Philippines', true), 
            'PN' => __('Pitcairn', true), 
            'PL' => __('Poland', true), 
            'PT' => __('Portugal', true), 
            'PR' => __('Puerto Rico', true), 
            'QA' => __('Qatar', true), 
            'RE' => __('Reunion', true), 
            'RO' => __('Romania', true), 
            'RU' => __('Russian Federation', true), 
            'RW' => __('Rwanda', true), 
            'KN' => __('Saint Kitts and Nevis', true),  
            'LC' => __('Saint LUCIA', true),  
            'VC' => __('Saint Vincent and the Grenadines', true), 
            'WS' => __('Samoa', true),  
            'SM' => __('San Marino', true), 
            'ST' => __('Sao Tome and Principe', true), 
            'SA' => __('Saudi Arabia', true), 
            'SN' => __('Senegal', true), 
            'SC' => __('Seychelles', true), 
            'SL' => __('Sierra Leone', true), 
            'SG' => __('Singapore', true),  
            'SK' => __('Slovakia (Slovak Republic)', true), 
            'SI' => __('Slovenia', true), 
            'SB' => __('Solomon Islands', true), 
            'SO' => __('Somalia', true),  
            'ZA' => __('South Africa', true), 
            'GS' => __('South Georgia and the South Sandwich Islands', true), 
            'ES' => __('Spain', true), 
            'LK' => __('Sri Lanka', true), 
            'SH' => __('St. Helena', true), 
            'PM' => __('St. Pierre and Miquelon', true),  
            'SD' => __('Sudan', true),  
            'SR' => __('Suriname', true), 
            'SJ' => __('Svalbard and Jan Mayen Islands', true), 
            'SZ' => __('Swaziland', true),  
            'SE' => __('Sweden', true), 
            'CH' => __('Switzerland', true),  
            'SY' => __('Syrian Arab Republic', true), 
            'TW' => __('Taiwan, Province of China', true), 
            'TJ' => __('Tajikistan', true), 
            'TZ' => __('Tanzania, United Republic of', true), 
            'TH' => __('Thailand', true), 
            'TG' => __('Togo', true), 
            'TK' => __('Tokelau', true), 
            'TO' => __('Tonga', true),  
            'TT' => __('Trinidad and Tobago', true),  
            'TN' => __('Tunisia', true),  
            'TR' => __('Turkey', true), 
            'TM' => __('Turkmenistan', true), 
            'TC' => __('Turks and Caicos Islands', true), 
            'TV' => __('Tuvalu', true), 
            'UG' => __('Uganda', true), 
            'UA' => __('Ukraine', true), 
            'AE' => __('United Arab Emirates', true), 
            'GB' => __('United Kingdom', true), 
            'US' => __('United States', true), 
            'UM' => __('United States Minor Outlying Islands', true), 
            'UY' => __('Uruguay', true),  
            'UZ' => __('Uzbekistan', true), 
            'VU' => __('Vanuatu', true),  
            'VE' => __('Venezuela', true), 
            'VN' => __('Viet Nam', true), 
            'VG' => __('Virgin Islands (British)', true), 
            'VI' => __('Virgin Islands (U.S.)', true),  
            'WF' => __('Wallis and Futuna Islands', true),  
            'EH' => __('Western Sahara', true), 
            'YE' => __('Yemen', true),  
            'YU' => __('Yugoslavia', true), 
            'ZM' => __('Zambia', true), 
            'ZW' => __('Zimbabwe', true)            
    	);
    } 

} 
?> 