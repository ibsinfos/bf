<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
class BX_Option {

	static $instance;
	static function get_instance(){
		if(null === static::$instance){
			static::$instance = new static();
		}
		return static::$instance;
	}
	function get_option($group, $name){
		$current = get_option($group);
		return $current[$name];
	}
	function get_group_option($group){
		$group_args = array(
			'general'=> array(
				'pending_post' => false,
				'google_analytic' => '',
				'copyright' => '',
				'social_links' => array(
					'fb_link' => 'https://fb.com/boxthemes/',
					'gg_link' => 'https://https://plus.google.com/boxthemes/',
					'tw_link' => 'https://https://twitter.com/boxthemes/',
					'le_link.' => 'https://linkedin.com.com/boxthemes/',
				),

			),
			'payment' => array(
				'mode' => 0,
				'paypal' => array(
					'email' => '',
					'enable' => false,
				),
				'cash' => array(
					'description' => '',
					'enable' => false,
				),
			),
			'social_api' => array(
				'facebook' => array(
					'app_id' => '',
					'enable' => 0,

				),
				'google' => array(
					'client_id' => '',
					'enable' => 0,
				),
			),
			'escrow' => array(
				'commision' => array(
					'number' => '10',
					'type'   => 'fit',
					'user_pay' => 'freelancer'
				),
			),
			'gg_captcha' => array(
				'site_key' => '',
				'secret_key' => '',
				'enable' => 0,
			)

		);
		return get_option($group, $group_args[$group]);
	}
	function set_option($group, $section, $name, $new_value, $multi = true){

		$current = get_option($group);

		if( $multi ){
			$current[$section][$name] = $new_value;
		} else {
			$current[$name] = $new_value;
		}
		return update_option($group, $current);
	}
	function set_logo(){

	}
	function get_logo(){

	}

}
function get_sandbox_mode(){
	$payment = (object) BX_Option::get_instance()->get_group_option($group_option);

	$sanbox_mode = 1;// sandbox = 0

	if( isset( $payment->mode ) ){
		$sanbox_mode = $payment->mode;
	}
	return $sanbox_mode;
}
function get_commision_fee( $total ){

	$escrow = BX_Option::get_instance()->get_group_option('escrow');
	$commision = (object)$escrow['commision'];

	$number = 10;
	$type = 'fix';
	$user_pay = 'fre';
	if( isset( $commision->number ) ){
		$number = (int) $commision->number;
	}
	if( isset( $commision->type ) ){
		$type = $commision->type;
	}
	if( isset( $commision->user_pay ) ){
		$user_pay = $commision->user_pay;
	}

	if($type == 'percent'){
		return ($number/100) * $total;
	}

	return $number;

}

?>