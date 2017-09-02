<?php
Class BX_Order {
	public $use_sandbox;
	public $post_type;
	public $post_status;
	public static $instance;
	public $redirect_link;
	public $order_title;
	public $payment_type;
	public $receiver_email;
	public $mode;
	static function get_instance(){
		if (null === static::$instance) {
        	static::$instance = new static();
    	}
    	return static::$instance;
	}

	function __construct(){
		$this->post_type = ORDER;
		$this->use_sandbox = get_sandbox_mode();
		$this->receiver_email = '';

		$this->redirect_link = bx_get_static_link('process-payment');

	}
	function get_redirect_link(){
		return $this->redirect_link;
	}
	function create($args) {
		$args['post_type'] = $this->post_type;
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
			'payment_type', //  cash, paypal or stripe ...
		);
	}

	function get_order($post) {

		if(is_numeric($post)){
			$post = get_post($post);
		}
		$metas = $this->meta_fields();
		foreach ($metas as $meta) {
			$post->$meta = get_post_meta($post->ID, $meta, true);
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
			'post_title' => $curren_user->user_email . ' buy credit  via '.$this->payment_type . '(' .$this->get_amout( $package_id ) .')',
			'post_status' => 'pending',
			'author' => $curren_user->ID,
			'meta_input' => array(
				'amout' => $this->get_amout( $package_id ),
				'payer_id' => $curren_user->ID,
				'payer_email' => $curren_user->user_email ,
				'order_type' 	=>'buy_credit',
				'payment_type' 	=>$this->payment_type,
				//'receiver_id' => 1,// need to update - default is admin.
				'receiver_email' => $this->receiver_email,
				'order_mode' => $this->mode,
			)
		);
		return $this->create($args);
	}
	function create_custom_pending_order($args){

		$curren_user = wp_get_current_user();
		$args = array(
			'post_title' => $args['post_title'],
			'post_status' => 'pending',
			'post_content' => $args['post_content'],
			'author' => $curren_user->ID,
			'meta_input' => array(
				'amout' => $args['amout'],
				'payer_id' => $curren_user->ID,
				'payer_email' => $curren_user->user_email ,
				'order_type' 	=>$args['order_type'], // buy credit, withdraw
				'payment_type' 	=>$args['payment_type'],
				//'receiver_id' => 1,// need to update - default is admin.
				'receiver_email' => $this->receiver_email,
				'order_mode' => $this->use_sandbox,
			)
		);
		return $this->create($args);
	}
	function create_order( $args ){
		$curren_user = wp_get_current_user();
		$args_order = array(
			'post_type' => $this->post_type,
			'post_title' =>'Pay service',
			'post_status' => 'publish',
			'author' => $curren_user->ID,
			'meta_input' => array(
				'amout' => $args['amout'],
				'project_id' => $args['project_id'],
				'order_type' => $args['order_type'],
				'order_mode' => $this->use_sandbox,
				'payment_type' => $args['payment_type'],
				//'payer_id' => $curren_user->ID,
				//'payer_email' => $curren_user->user_email ,

				//'receiver_email' => $this->receiver_email,
			)
		);
		return wp_insert_post($args_order);
	}
	/**
	 * create orders
	 * This is a cool function
	 * @author danng
	 * @version 1.0
	 * @param   [type] $package_id [description]
	 * @return  [type]             [description]
	 */
	function create_draft_order( $package_id ){
		$curren_user = wp_get_current_user();
		$args = array(
			'post_title' => $curren_user->user_email . ' buy credit  via '.$this->payment_type . '(' .$this->get_amout( $package_id ) .')',
			'post_status' => 'draft',
			'author' => $curren_user->ID,
			'meta_input' => array(
				'amout' => $this->get_amout( $package_id ),
				'payer_id' => $curren_user->ID,
				'payer_email' => $curren_user->user_email ,
				'order_type' 	=>'buy_credit',
				'payment_type' 	=>$this->payment_type,
				//'receiver_id' => 1,// need to update - default is admin.
				'receiver_email' => $this->receiver_email,
				'order_mode' => $this->mode,
				)
			);
		return $this->create($args);
	}

}
