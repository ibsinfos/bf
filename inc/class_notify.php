<?php
class Box_Notify extends Box_Custom_Type{
	public $author_id;
	public $receiver_id;
	public $content;
	public $type;
	static protected $instance;
	function  __construct(){

		parent::__construct();
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

		global $wpdb, $user_ID;

		$receiver_id = isset($args['receiver_id'])? $args['receiver_id']: 0;
		$msg_link = isset( $args['msg_link'] ) ? $args['msg_link']: '';
		$sender_id = isset($args['sender_id']) ? $args['sender_id']: $user_ID;

		$wpdb->insert( $wpdb->prefix . 'box_messages', array(
				'msg_content' => $args['msg_content'],
				'msg_date'	=> current_time('mysql'),
				'msg_unread' => 1,
				'sender_id' => $sender_id,
				'msg_status' => 'new',
				'msg_link' => $msg_link,
				'msg_type' => $this->type,
				'receiver_id' => $receiver_id
			)
		);
		update_user_meta($receiver_id,'has_new_notify', 1);

		return $wpdb->insert_id;
	}
	function get_message($msg_id){
		global $wpdb;
		$sql = " SELECT * FROM " . $wpdb->prefix . "box_messages WHERE ID = '$msg_id'";
		return $wpdb->get_row($sql);

	}
	function seen_all(){
		global $wpdb, $user_ID;
		update_user_meta($user_ID, 'has_new_notify',0);
		var_dump($this->table);
		return $wpdb->query( $wpdb->prepare(
			"
			UPDATE $this->table
			SET msg_unread = %d
			WHERE receiver_id = %d and msg_type = %s
			",0 , $user_ID, 'notify')
		);
	}

	function delete($id){
		global $wpdb, $user_ID;
		return $wpdb->query(
			$wpdb->prepare( "
		        DELETE FROM {$wpdb->prefix}box_messages
				WHERE ID = %d
				AND receiver_id = %d
				", $id, $user_ID
		    )
		);

	}
}