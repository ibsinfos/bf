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
		return (object)$current[$name];
	}
	function get_group_option($group){
		return get_option($group);
	}
	function set_option($group,$section,$name,$new_value){
		// payment, paypal,'emai', 'danhoat@gmail.com'
		// $group = array(
		// 	$section =>  array(
		// 		$name => $new_value
		// 		'enable' => 1,
		// 	)
		// );

		$current = get_option($group);
		$current[$section][$name] = $new_value;

		return update_option($group, $current);
	}

}
?>