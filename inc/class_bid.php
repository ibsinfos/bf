<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
class BX_Bid extends BX_Post{
	static private $instance;
	protected $post_type;
	protected $post_title;
	protected $budget;
	function __construct(){
		$this->post_type = BID;
	}
	static function get_instance(){
		if (null === static::$instance) {
        	static::$instance = new static();
    	}
    	return static::$instance;
	}

	function get_meta_fields(){
		return array('_bid_price', '_dealine');
	}

	function convert($bid){

		$result 			= parent::convert($bid);
		$profile_id 		= get_user_meta( $bid->post_author, 'profile_id', true );
		$project_id 		= $bid->post_parent;
		$project 			= get_post($project_id);
		$result->project_title = $project->post_title;
		$result->professional_title = get_post_meta( $profile_id, 'professional_title' , true );
		$result->project_link = get_permalink($project_id);
		// $user = get_userdata($bid->post_author);
		// if($user){
		// 	$result->display_name = $user->display_name;
		// }

		return $result;
	}
	function has_bid_on_project( $project_id ){
		global $wpdb, $user_ID;
		$type = BID;
		$sql  = " SELECT * FROM $wpdb->posts p
			WHERE p.post_type = '{$type}'
				AND p.post_parent = {$project_id}
				AND p.post_author = {$user_ID}
		";
		$row = $wpdb->get_row($sql);
		return $row;

	}
	function check_before_update($args){
		$project_id 	= $args['post_parent'];
		$bid_content 	= $args['post_content'];
		$bid_id 		= $args['ID'];

		$bid = get_post( $bid_id );
		if ( $bid->post_author !== $user_ID && $bid->post_parent != $project_id ){
			return new WP_Error('You don\'t permission to update this bid','boxtheme');
		}
		return true;
	}
	function check_before_insert($args, $user_id = 0){

		if( bx_get_user_role() != FREELANCER ){
			return new WP_Error( 'empty', __( "Only freelancer can bid.", "boxtheme" ) );
		}

		$project_id 	= $args['post_parent'];
		$bid_content 	= $args['post_content'];

		if( empty( $project_id ) ){
			return new WP_Error( 'empty', __( "Project is empty.", "boxtheme" ) );
		}
		if( empty( $bid_content ) ){
			return new WP_Error( 'empty', __( "Cover letter is empty.", "boxtheme" ) );
		}
		if ( !$user_id ) {
			global $user_ID;
			$user_id = $user_ID;
		}
		if( $this->has_bid_on_project($project_id) && empty($args['update']) ){
			return new WP_Error( 'exists', __( "You've bid on this project", "boxtheme" ) );
		}
		$project = get_post( $project_id );
		if( $project->post_status == 'publish' && $project->post_author != $user_id ) {
			// project is publish.
			// current user not owner of project
			return true;
		}

		if ( $project->post_author == $user_id ) {
			return new WP_Error( 'is_owner', __( "You can not bid on your own project.", "boxtheme" ) );
		}
		return true;
	}
	/**
	 * add a bidding into the project
	 * @author danng
	 * @version 1.0
	 * @return  [type] [description]
	 */
	function insert($args){
		if( !empty( $args['ID'] ) ){
			return $this->update($args );
		}
		$check = $this->check_before_insert($args);
		if( is_wp_error($check) ){
			return $check;
		}
		$args['post_type'] 		= $this->post_type;
		$args['post_status']	= 'publish';
		if ( is_wp_error( $check ) ){
			return $check;
		}

		$metas 		= $this->get_meta_fields();
		foreach ($metas as $key) {
			if ( !empty ( $args[$key] )  ){
				$args['meta_input'][$key] = $args[$key];
			}
		}
		$args 		= apply_filters( 'args_pre_insert_'.$this->post_type, $args );
		$bid_id 	= wp_insert_post( $args );

		if( ! is_wp_error( $bid_id) ){

			$current_user = wp_get_current_user();
			$project_id = $args['post_parent'];
			$project = get_post($project_id);

			$args = array(
				'msg_sender_id' => 0,
				'msg_content' => sprintf(__('%s just bid on project: %d','boxtheme'),$current_user->display_name, $project->post_title),
				'msg_link' => get_permalink($project_id),
				'msg_receiver_id' => $project->post_author,
				'msg_is_read' => 0,
				'msg_type' => 'notify',
				);

			$notify 	= BX_Message::get_instance()->insert($args);
		}
		return $bid_id;

	}
	function update( $args){
		global $user_ID;
		$bid_id = $args['ID'];
		$bid = get_post($bid_id);
		if( $bid->post_author != $user_ID){
			return new WP_Error('permission',__('You can not update this bid','boxtheme') );
		}

		$metas 		= $this->get_meta_fields();
		foreach ($metas as $key) {
			if ( !empty ( $args[$key] )  ){
				$args['meta_input'][$key] = $args[$key];
			}
		}
		$args 		= apply_filters( 'args_pre_update_'.$this->post_type, $args );

		$post_id 	= wp_update_post( $args );

		if( !is_wp_error($post_id) ){
			// test insert notification here.
			$current_user = wp_get_current_user();
			$project_id = $args['post_parent'];
			$project = get_post($project_id);

			$args = array(
				'msg_sender_id' => 0,
				'msg_content' => sprintf(__('%s just updated bid','boxtheme'), $current_user->display_name ),
				'msg_link' => get_permalink($project_id),
				'msg_receiver_id' => $project->post_author,
				'msg_is_read' => 0,
				'msg_type' => 'notify',
				);

			$notify 	= BX_Message::get_instance()->insert($args);

		}
		return $post_id;
	}
	function is_can_bid( $project ) {

		if (  $project->post_status == 'publish' && bx_get_user_role() == FREELANCER ) {
			return true;
		}
		return false;

	}


}
new BX_Bid();
?>
