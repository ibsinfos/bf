<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
class BX_Conversations{
	static protected $instance;
	private $table;
	function  __construct(){
		$this->table = 'box_conversations';
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

		$wpdb->insert( $wpdb->prefix . 'box_conversations', array(
				'cvs_author' => $user_ID,
				'project_id' => $args['project_id'],
				'receiver_id' =>  $args['receiver_id'],
				'cvs_content'	=> $args['cvs_content'],
				'cvs_status' => 1,
				'msg_unread' => 'new',
				'cvs_date' => current_time('mysql'),
			)
		);
		$msg_arg = array(
			'msg_content' 	=> $args['cvs_content'],
			'cvs_id' 		=> $wpdb->insert_id,
			'receiver_id'=> $args['receiver_id'],
			'sender_id' => $user_ID,
			'msg_type' => 'message',
		);
		return BX_Message::get_instance()->insert($msg_arg);

	}
	function is_sent_msg($project_id, $receiver_id){
		global $wpdb;
		return $wpdb->get_var( "SELECT ID FROM $wpdb->prefix{$this->table} WHERE project_id = {$project_id} AND receiver_id = {$receiver_id} " );
	}
}


class BX_Message{
	public $author_id;
	public $receiver_id;
	public $content;
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
		$sender_id = isset($args['sender_id'])? $args['sender_id']:0;
		$receiver_id = isset($args['receiver_id'])? $args['receiver_id']:0;
		$msg_link = isset($args['msg_link']) ? $args['msg_link']: '';
		$msg_type = isset($args['msg_type']) ? $args['msg_type']: 'message';

		$cvs_project_id = isset($args['cvs_project_id']) ? $args['cvs_project_id'] : 0;

		$cvs_id = isset($args['cvs_id']) ? $args['cvs_id'] : 0;



		if( empty($args['sender_id']) ){
			$sender_id = 0;
		}
		if( empty($sender_id) )
			$sender_id = $user_ID;


		$wpdb->insert( $wpdb->prefix . 'box_messages', array(
				'sender_id' => $sender_id,
				'msg_content' => $args['msg_content'],
				'cvs_id' => $cvs_id,
				'msg_date'	=> current_time('mysql'),
				'msg_unread' => 1,
				'msg_status' => 'new',
				'msg_link' => $msg_link,
				'msg_type' => $msg_type,
				'receiver_id' => $receiver_id
			)
		);

		return $wpdb->insert_id;
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

function is_sent_msg($project_id, $receiver_id){
	return BX_Conversations::get_instance()->is_sent_msg($project_id, $receiver_id);
}
?>