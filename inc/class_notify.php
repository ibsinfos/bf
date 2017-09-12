<?php
class Box_Notify extends Box_Custom_Type{
	public $author_id;
	public $receiver_id;
	public $content;
	public $type;
	static protected $instance;
	function  __construct(){
		$this->type = 'notify';
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
		$receiver_id = isset($args['receiver_id'])? $args['receiver_id']: 0;
		$msg_link = isset($args['msg_link']) ? $args['msg_link']: '';
		$wpdb->insert( $wpdb->prefix . 'box_messages', array(
				'msg_content' => $args['msg_content'],
				'msg_date'	=> current_time('mysql'),
				'msg_unread' => 1,
				'msg_status' => 'new',
				'msg_link' => $msg_link,
				'msg_type' => $this->type,
				'receiver_id' => $receiver_id
			)
		);

		return $wpdb->insert_id;
	}
	function get_message($msg_id){
		global $wpdb;
		$sql = " SELECT * FROM " . $wpdb->prefix . "box_messages WHERE ID = '$msg_id'";
		return $wpdb->get_row($sql);

	}

	function get_converstaion1($args){
		$group = $args['group'];

		$gr = explode(",",$group);
		$sender_id = $gr[0];
		$receiver_id = $gr[1];
		global $wpdb;
		return 1;
		$sql = "SELECT *
				FROM {$wpdb->prefix}box_messages msg
				WHERE sender_id = {$sender_id}
					AND receiver_id = {$receiver_id}
					AND msg_type = 'message'
				ORDER BY id ASC";

		$msg =  $wpdb->get_results($sql);
		return $msg;
	}
	function get_converstaion($args){
		$id = $args['id'];
		global $wpdb;
		$sql = "SELECT *
				FROM {$wpdb->prefix}box_messages msg
				WHERE cvs_id = {$id}
					AND msg_type = 'message'
				ORDER BY id ASC";

		$msg =  $wpdb->get_results($sql);
		return $msg;
	}
}