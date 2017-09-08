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
		$group_args =$this->get_default();
		return (object)wp_parse_args(get_option($group), $group_args[$group]);
	}
	function get_default_option($group, $section, $key){
			$default = $this->get_default();
			return $default[$group][$section][$key];
	}

	function get_default(){
		return array(
			'general'=> array(
				'pending_post' => false,
				'google_analytic' => '',
				'copyright' => '2017 © Boxthemes. All rights reserved. <a href="https://boxthemes.net/terms-and-conditions/" target="_blank">Term of Use</a> and <a href="https://boxthemes.net/terms-and-condition/" target="_blank">Privacy Policy</a>',
				'fb_link' => 'https://fb.com/boxthemes/',
				'gg_link' => 'https://https://plus.google.com/boxthemes/',
				'tw_link' => 'https://twitter.com/',
				'le_link.' => 'https://linkedin.com.com/boxthemes/',
				'currency' => array(
					'code' => 'USD',
					'position' => 'left',
					'price_thousand_sep' => ',',
					'price_decimal_sep' => '.',
				),
				'static_link' => array (
					'login' => array( 'id' => 0, 'link' =>'' ),
					'signup' => array( 'id' => 0, 'link' =>'' ),
					'signup-employer' => array( 'id' => 0, 'link' =>'' ),
					'signup-jobseeker' => array( 'id' => 0, 'link' =>'' ),
					'verify' => array( 'id' => 0, 'link' =>'' ),
					'profile' => array( 'id' => 0, 'link' =>'' ),
					'messages' => array( 'id' => 0, 'link' =>'' ),
					'my-credit' => array( 'id' => 0, 'link' =>'' ),
					'buy-credit' => array( 'id' => 0, 'link' =>'' ),
					'dashboard' => array( 'id' => 0, 'link' =>'' ),
					'post-project' => array( 'id' => 0, 'link' =>'' ),
					'process-payment' => array( 'id' => 0, 'link' =>'' ),
				),

			),
			'payment' => array(
				'mode' => 0,
				'paypal' => array(
					'email' => '',
					'enable' => 0,
				),
				'stripe' => array(
					'email' => '',
					'enable' => 0,
				),
				'cash' => array(
					'description' => __("<p>https:// %s to this bank account:</p><p>Number: XXXXXXXXXX.</p><p>Bank: ANZ Bank. Account name: Johnny Cook.</p><p>After get your fund, we will approve your order and you can access your balance.</p",'boxtheme'),
					'enable' => 1,
				),
			),
			'app_api' => array(
				'facebook' => array(
					'app_id' => '',
					'enable' => 0,

				),
				'google' => array(
					'client_id' => '',
					'enable' => 0,
				),
				'gg_captcha' => array(
					'site_key' => '',
					'secret_key' => '',
					'enable' => 0,
				),
			),
			'escrow' => array(

				'activate' => 'credit',
				'commision' => array(
					'number' => '10',
					'type'   => 'fit',
					'user_pay' => 'fre',
					'system' => 'credit',
				),

			),
			'opt_credit'=>array(
				'number_credit_default' => 10,
			),

		);
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
	function get_opt_credit_default(){
		$default =$this->get_default_option('opt_credit');
		$setting =  get_option('opt_credit');
		$result = wp_parse_args( $setting, $default );
		return (object)$result;
	}
	function get_general_option(){
		$default = array(
				'pending_post' => false,
				'google_analytic' => '',
				'copyright' => '2017 © Boxthemes. All rights reserved. <a href="https://boxthemes.net/terms-and-conditions/" target="_blank">Term of Use</a> and <a href="https://boxthemes.net/terms-and-condition/" target="_blank">Privacy Policy</a>',
				'fb_link' => 'https://fb.com/boxthemes/',
				'gg_link' => 'https://https://plus.google.com/boxthemes/',
				'tw_link' => 'https://twitter.com/',
				'le_link.' => 'https://linkedin.com.com/boxthemes/',
				'currency' => array(
					'code' => 'USD',
					'position' => 'left',
					'price_thousand_sep' => ',',
					'price_decimal_sep' => '.',
				),
		);
		$general = get_option('general', false);
		return (object) wp_parse_args($general, $default);
	}
	function get_currency_code(){
		$default = array(
			'code' => 'USD',
			'position' => 'left',
			'price_thousand_sep' => ',',
			'price_decimal_sep' => '.',
		);
		$general = (object) $this->get_group_option('general');
		return (object) wp_parse_args($general->currency, $default);
	}
	function set_logo(){

	}
	function get_logo(){

	}

	/**
	 * mailing setting in dashboar and be used in mail content.
	 * This is a cool function
	 * @author danng
	 * @version 1.0
	 * @return  [type] [description]
	 */
	function get_mailing_setting(){

		$default = array(
			'main_bg' => '#33cc66',
			'from_name' => 'BoxThemes Inc',
			'footer_text' => '© 2009-2017. BoxThemes, Inc. USA. All Rights Reserved.',
			'header_image' => get_template_directory_uri().'/img/header-email.png',
			'from_address' => 'admin@boxthemes',
		);
		$setting =  get_option('box_mail');
		$result = wp_parse_args( $setting, $default );
		return (object)$result;
	}

}
function box_get_currency(){
	return BX_Option::get_instance()->get_currency_code();
}
function get_sandbox_mode(){
	$payment = (object) BX_Option::get_instance()->get_group_option('payment');

	$sanbox_mode = 1;// sandbox = 0

	if( isset( $payment->mode ) ){
		$sanbox_mode = $payment->mode;
	}
	return $sanbox_mode;
}
function get_commision_fee( $total, $commision ){
	$number = $commision->number; // fix price
	if( $commision->type == 'percent' ) {
		return ( $number/100 ) * (float) $total;
	}

	return $number;
}
function get_commision_setting(){
	$option = BX_Option::get_instance();
	$escrow = $option->get_group_option('escrow');
	$commision = (object)$escrow['commision'];

	$result = array('number' => 10, 'type' => 'fix', 'user_pay' => 'fre');

	if( isset( $commision->number ) ){
		$result['number'] = (int) $commision->number;
	}
	if( isset( $commision->type ) ){
		$result['type'] = $commision->type;
	}
	if( isset( $commision->user_pay ) ){
		$result['user_pay']= $commision->user_pay;
	}
	return (object)$result;
}
function box_get_pay_info($bid_price){
	$setting = get_commision_setting();
	$cms_fee = get_commision_fee($bid_price, $setting);

	$emp_pay = $bid_price;
	$fre_receive = $bid_price - $cms_fee;

	$result = array( 'emp_pay' => $emp_pay, 'fre_receive' => $fre_receive, 'cms_fee' => $cms_fee );

	if($setting->user_pay == 'emp'){

		$result['emp_pay'] = $bid_price + $cms_fee;
		$result['fre_receive'] = $bid_price;

	}
	return (object)$result;
}

?>