<?php
Class BX_Order {
	public $mode;
	public $post_type;
	public $post_status;
	public static $instance;
	public $redirect_link;
	public $order_title;
	static function get_instance(){
		if (null === static::$instance) {
        	static::$instance = new static();
    	}
    	return static::$instance;
	}

	function __construct(){
		$this->post_type = ORDER;
		$this->post_status = 'pending';
		$this->mode = 'sandbox';
		$this->order_title = 'Buy credit';

		$this->redirect_link = bx_get_static_link('process-payment');

	}
	function get_redirect_link(){
		return $this->redirect_link;
	}
	function create($args) {
		$args['post_type'] = $this->post_type;
		$args['post_status'] = $this->post_status;
		return wp_insert_post($args);
	}
	function approve($order_id){
		return wp_update_post( array(
			'ID' => $order_id,
			'post_status' =>'publish'
			)
		);
	}
	function meta_fields(){
		return array(
			'amout', // price of this order
			'payer_id', // user id of
			'payer_email',
			'receiver_id', // user id of receiver
			'receiver_email',
			'customer_address',
			'payment_type', // paypal, stripe or cash.
			'order_type', // pay credit, pay post project or pay to bid .
			'order_mode', //sandbox or live
		);
	}

	function get_order($order_id) {
		$post = get_post($order_id);
		$metas = $this->meta_fields();
		foreach ($metas as $meta) {
			$post->$meta = get_post_meta($order_id, $meta, true);
		}
		return (object)$post;
	}
	function get_package($packge_id){
		$post = get_post($packge_id);
		$metas = array('price','sku','type');
		foreach ($metas as $meta) {
			$post->$meta = get_post_meta($packge_id, $meta, true);
		}
		return (object)$post;
	}
	function get_amout($package_id){
       	return (float) get_post_meta($package_id, 'price', true);
    }
    function create_pending_order($package_id){
		$curren_user = wp_get_current_user();
		$args = array(
			'post_title' => $this->order_title,
			'meta_input' => array(
				'amout' => $this->get_amout( $package_id ),
				'payer_id' => $curren_user->ID,
				'payer_email' => $curren_user->user_email ,
				'payment_type' => 'paypal',
				'order_type' 	=>'buy_credit',
				//'receiver_id' => 1,// need to update - default is admin.
				'receiver_email' => '', //$receiver_email,
				'order_mode' => $this->mode,
				)
			);
		return BX_Order::get_instance()->create($args);
	}
}
