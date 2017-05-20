<?php
Class BX_Order {
	public $mode;
	public $post_type;
	public static $instance;
	static function get_instance(){
		if (null === static::$instance) {
        	static::$instance = new static();
    	}
    	return static::$instance;
	}

	function __construct(){
		$this->post_type = ORDER;
		$this->post_status = 'pending';
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
}
