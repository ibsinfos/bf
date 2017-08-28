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
			'payment' => array(
				'paypal' => array(
					'email' => '',
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
			'main_options' => array(
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
	function set_option($group,$section,$name,$new_value){

		$current = get_option($group);
		$current[$section][$name] = $new_value;

		return update_option($group, $current);
	}
	function set_logo(){

	}
	function get_logo(){

	}

}
?>