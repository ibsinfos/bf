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

		);
		return get_option($group, $group_args[$group]);
	}
	function set_option($group,$section,$name,$new_value, $multi = true){

		$current = get_option($group);

		if( $multi ){
			$current[$section][$name] = $new_value;
		} else {
			$current[$name] = $new_value;
			var_dump($current[$name]);
		}


		return update_option($group, $current);
	}
	function set_logo(){

	}
	function get_logo(){

	}

}
?>