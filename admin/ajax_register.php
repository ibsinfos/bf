<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

function check_permission(){
	if( ! current_user_can( 'manage_options' ) )
		return new WP_Error( 'insert_fail',  $project_id->get_error_message() );
	return true;
}
class BX_ajax_backend{
	static $instance;
	static function get_instance(){
		  if (null === static::$instance) {
            static::$instance = new static();
        }
        return static::$instance;
	}
	function init(){
		add_action( 'wp_ajax_save-option', array( __CLASS__, 'save_option' ) );
		add_action( 'wp_ajax_create-packge',array( __CLASS__, 'create_package' ) );
		add_action( 'wp_ajax_del-post',array( __CLASS__, 'del_post' ) );
		add_action( 'wp_ajax_admin_approve', array( __CLASS__, 'admin_approve' ) );

	}

	static function save_option(){

		if( ! self::check_permission() ){
			wp_send_json( array('success' => false, 'msg' => 'Security declince') );
			die();
		}

		$request= $_REQUEST['request'];
		$name = $request['name'];
		$group = $request['group'];
		$value = $request['value'];
		$section = $request['section'];
		$multi = isset($request['multi']) ? $request['multi']: 1;

		$option = BX_Option::get_instance();

		$option->set_option( $group, $section, $name, $value, $multi);
		wp_send_json(array('success' => true, 'msg' => 'save done'));
	}
	function create_package() {
		if( ! self::check_permission() ){
			wp_send_json( array('success' => false, 'msg' => 'Security declince') );
			die();
		}
		$request = $_REQUEST['request'];
		$id = isset($request['ID']) ? $request['ID'] : 0;
		$post_title = isset($request['post_title']) ? $request['post_title'] : 'Package name';

		$args = array(
			'post_title' => $post_title,
			'post_content' => $request['post_content'],
			'post_type' => '_package',
			'post_status' =>'publish',
			'meta_input' => array(
				'sku' => $request['sku'],
				'price' => $request['price'],
				'type' => 'buy_credit',
				),
		);

		if( $id ){
			$args['ID'] = $id;
			wp_update_post($args );
		} else {
			wp_insert_post($args);
		}
		wp_send_json( array(
			'success' => true,
			'msg' => 'DONE'
			)
		);
	}
	function del_post(){
		if( ! self::check_permission() ){
			wp_send_json( array('success' => false, 'msg' => 'Security declince') );
			die();
		}

		$request= $_REQUEST['request'];
		$id = $request['id'];
		wp_delete_post($id,true);
		wp_send_json( array(
			'success' => true,
			'msg' => 'DONE'
			)
		);
	}
	static function check_permission(){
		if( current_user_can('manage_options' ) ){
			return true;
		}
		return false;
	}
	static function admin_approve(){
		if( ! self::check_permission() ){
			wp_send_json( array('success' => false, 'msg' => 'Security declince') );
			die();
		}

		$request= $_REQUEST['request'];
		$order_id = $request['order_id'];
		$type = $_REQUEST['type'];

		$credit = BX_Credit::get_instance()->$type($order_id);
		if( is_wp_error( $credit ) ){
			wp_send_json(array('success'=> false,'msg' => $credit->get_error_message() ) );
		}
		wp_send_json(array('success'=> tre,'msg' => 'Update OK') );
	}

}
BX_ajax_backend::get_instance()->init();
?>