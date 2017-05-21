<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
class BX_Message{
	static protected $instance;
	function  __construct(){

	}
	static function get_instance(){
		if (null === static::$instance) {
        	static::$instance = new static();
    	}
    	return static::$instance;
	}
	function sync($args, $method){
		return $this->$method($args);
	}

	function insert( array $args ) {
		global $wpdb;
		global $user_ID;
		$cvs_id = isset($args['cvs_id']) ? $args['cvs_id'] : 0;
		$msg_sender_id = $args['msg_sender_id'];
		$msg_link = isset($args['msg_link']) ? $args['msg_link']: '';
		$msg_type = isset($args['msg_type']) ? $args['msg_type']: '';

		if( empty($args['cvs_id']) ){
			$msg_sender_id = 0;
		}

		$t = $wpdb->insert(
			$wpdb->prefix . 'box_messages', array(
				'msg_sender_id'  	=> $msg_sender_id,
				'msg_content' 	=> $args['msg_content'],
				'cvs_id' 		=> $cvs_id,
				'msg_date' 		=> current_time('mysql'),
				'msg_unread' => 1,
				'msg_status' => 'new',
				'msg_link' => $msg_link,
				'msg_type' => $msg_type,
				'msg_receiver_id' => $args['msg_receiver_id']
			)
		);
		//var_dump($wpdb->last_query);
		return $wpdb->insert_id;
	}

	function get_converstaion($args){
		$group = $args['group'];

		$gr = explode(",",$group);
		$sender_id = $gr[0];
		$receiver_id = $gr[1];
		global $wpdb;

		$sql = "SELECT *
				FROM {$wpdb->prefix}box_messages msg
				WHERE msg_sender_id = {$sender_id}
					AND msg_receiver_id = {$receiver_id}
					AND msg_type = 'message'
				ORDER BY id DESC";

		$msg =  $wpdb->get_results($sql);
		return $msg;


	}
}
class BX_Conversations{
	static protected $instance;
	function  __construct(){

	}
	static function get_instance(){
		if (null === static::$instance) {
        	static::$instance = new static();
    	}
    	return static::$instance;
	}
	function sync($args, $method){
		return $this->$method($args);
	}

	function insert($args){
		global $wpdb;
		global $user_ID;

		$wpdb->insert( $wpdb->prefix . 'conversations', array(
			'cvs_author' => $user_ID,
			'cvs_content' => $args['cvs_content'],
			'cvs_project_id' => $args['cvs_project_id'],
			'cvs_freelancer_id' => $args['cvs_freelancer_id'],
			'cvs_status' => 1,
			'cvs_date' => current_time('mysql'),
			)
		);
		// triiger insert first message.
		$msg_arg = array(
			'msg_content' 	=> $args['cvs_content'],
			'cvs_id' 		=> $wpdb->insert_id,
		);
		BX_Message::get_instance()->insert($msg_arg);
		return $wpdb->insert_id;
	}
}
?>