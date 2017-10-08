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
		global $wpdb, $user_ID;
		$t = $wpdb->insert( $wpdb->prefix . 'box_conversations', array(
				'cvs_author' => $user_ID,
				'project_id' => $args['project_id'],
				'receiver_id' =>  $args['receiver_id'],
				'cvs_content'	=> $args['cvs_content'],

				'cvs_status' => 1,
				'msg_unread' => 0,
				'date_created' => current_time('mysql'),
				'date_modify' => current_time('mysql'),
			)
		);
		$cvs_id = $wpdb->insert_id;  // cvs_id just inserted
		$msg_arg = array(
			'msg_content' 	=> $args['cvs_content'],
			'cvs_id' 		=> $cvs_id,
			'receiver_id'=> $args['receiver_id'],
			'sender_id' => $user_ID,
			'msg_type' => 'message',
		);

		$msg_id =  BX_Message::get_instance($cvs_id)->insert($msg_arg); // msg_id
		return BX_Message::get_instance()->get_message($msg_id);
	}

	function create_conversation( $args ){
		global $wpdb, $user_ID;

		$wpdb->insert( $wpdb->prefix . 'box_conversations', array(
				'cvs_author' => $user_ID,
				'project_id' => $args['project_id'],
				'receiver_id' =>  $args['receiver_id'],
				'cvs_content'	=> $args['cvs_content'],
				'cvs_status' => 1,
				'msg_unread' => 'new',
				'date_created' => current_time('mysql'),
				'date_modify' => current_time('mysql'),
			)
		);
		return $wpdb->insert_id;
	}
	function get_conversation($id){
		global $wpdb;
		return  $wpdb->get_row( "SELECT * FROM  $wpdb->prefix{$this->table}  WHERE ID = ".$id );
	}

	function is_sent_msg( $project_id, $receiver_id ) {
		global $wpdb;
		return $wpdb->get_var( "SELECT ID FROM $wpdb->prefix{$this->table} WHERE project_id = {$project_id} AND receiver_id = {$receiver_id} " );
	}
}


class BX_Message{
	public $author_id;
	public $receiver_id;
	public $content;
	static protected $instance;
	function  __construct( $cvs_id = 0){

		if( $cvs_id ){
			global $user_ID;
			$cvs = BX_Conversations::get_instance()->get_conversation($cvs_id);
			if( $user_ID == $cvs->cvs_author ){
				$this->receiver_id = $cvs->receiver_id;
			} else {
					$this->receiver_id = $cvs->cvs_author;
			}
			$this->cvs_id = $cvs_id;
		}
		$this->msg_type = 'message';
	}
	static function get_instance($cvs_id = 0){
		if (null === static::$instance) {
        	static::$instance = new static($cvs_id);
    	}
    	return static::$instance;
	}
	function sync($args, $method){
		return $this->$method($args);
	}

	function insert( array $args ) {

		global $wpdb, $user_ID;

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
				'msg_type' => $this->msg_type,
				'receiver_id' => $this->receiver_id,
			)
		);
		// update modify time of this conversiaion.
		$sql = "UPDATE {$wpdb->prefix}box_conversations SET `date_modify` = '".current_time('mysql')."'  WHERE  `ID` = {$cvs_id} ";
		$wpdb->query( $sql );

		return $wpdb->insert_id;
	}
	function get_message($msg_id){
		global $wpdb;
		$sql = " SELECT * FROM " . $wpdb->prefix . "box_messages WHERE ID = '$msg_id'";
		return $wpdb->get_row($sql);

	}

	function get_converstaion($args){
		$id = $args['id'];
		global $wpdb;
		$sql = "SELECT *
				FROM {$wpdb->prefix}box_messages msg
				WHERE cvs_id = {$id}
					AND msg_type = 'message'
				ORDER BY id ASC";

		$msgs =  $wpdb->get_results($sql);
		$results = array();
		foreach ($msgs as $key => $msg) {
			$date = date_create( $msg->msg_date );
			$msg->msg_date = date_format($date,"m/d/Y");
			$results[] = $msg;
		}
		return $results;
	}
}

function is_sent_msg($project_id, $receiver_id){
	return BX_Conversations::get_instance()->is_sent_msg($project_id, $receiver_id);
}
function box_get_message($msg_id){
	return BX_Message::get_instance()->get_message($msg_id);
}
?>