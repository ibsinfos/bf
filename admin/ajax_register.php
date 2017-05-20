<?php
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

	}

	static function save_option(){

		$request= $_REQUEST['request'];

		$name = $request['name'];
		$group = $request['group'];
		$value = $request['value'];
		$section = $request['section'];


		$option = BX_Option::get_instance();
		$result = get_option('payment');
		$option->set_option( $group, $section,$name, $value);
		wp_send_json(array('success' => true, 'msg' => 'save done'));
	}
	function create_package() {
		$request = $_REQUEST['request'];
		$args = array(
			'post_title' => 'Buy credit package',
			'post_content' => $request['post_content'],
			'post_type' => '_package',
			'post_status' =>'publish',
			'meta_input' => array(
				'sku' => $request['sku'],
				'price' => $request['price'],
				//'number_post' => $request['number_posts'],
				'type' => 'buy_credit',
				),

		);
		$t = wp_insert_post($args);
		wp_send_json( array(
			'success' => true,
			'msg' => 'DONE'
			)
		);
	}
	function del_post(){
		$request= $_REQUEST['request'];
		$id = $request['id'];
		wp_delete_post($id,true);
		wp_send_json( array(
			'success' => true,
			'msg' => 'DONE'
			)
		);
	}
}
BX_ajax_backend::get_instance()->init();
?>