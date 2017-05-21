<?php

if ( ! defined( 'ABSPATH' ) ) exit;

Class BX_Profile extends BX_Post{
	static protected $instance;
	protected $post_type;
	function __construct(){
		$this->post_type = PROFILE;
	}
	static function get_instance(){
		if (null === static::$instance) {
        	static::$instance = new static();
    	}
    	return static::$instance;
	}
	function get_meta_fields(){
		return array('professional_title', 'address', 'hour_rate','phone_number', 'video_url');
	}
	function get_static_meta_fields(){
		return array();
	}
	function check_before_insert($request){
		return true;
	}
	function get_taxonomy_fields(){
		return array('country','skill');
	}
	function sync($args, $method){
		$this->$method($args);
	}

	function insert1($args){
		global $user_ID;
		$args['author'] 		= $user_ID;
		$args['post_status'] 	= 'publish';
		$args['post_type'] 		= $this->post_type;
		$args['meta_input'] 	= array();
		$metas = $this->get_meta_fields();
		foreach ($metas as $key) {
			if ( !empty ( $args[$key] )  ){
				$args['meta_input'][$key] = $args[$key];
			}
		}
		$check = $this->check_before_bid( $args );
		$check = 1;
		if ( ! is_wp_error( $check ) ){
			$id = wp_insert_post($args);
		} else {
			wp_send_json( array('success' => false, 'msg' => $check->get_error_message() ) );
		}

		return $id;
	}
	function convert($post){

		if( is_numeric($post) ){
			$post = get_post($post);
		}

		$metas = $this->get_meta_fields();
		foreach ( $metas as $key ) {
			$post->$key = get_post_meta( $post->ID, $key, true);
		}

		$pcountry = get_the_terms( $post->ID, 'country' );
		$post->country = __('Not set','boxtheme');
		if( !empty($pcountry) ){
			$post->country =  $pcountry[0]->name;
		}

		$post->{EARNED}	= (float)get_user_meta($post->post_author,EARNED, true);
		$post->{EARNED_TXT} = sprintf( __('($)%s earned ','boxtheme'), $post->{EARNED} );
		$post->{RATING_SCORE} 	= (float)get_user_meta($post->post_author,RATING_SCORE, true);
		$post->{PROJECTS_WORKED} = (int) get_user_meta($post->post_author,PROJECTS_WORKED, true);


		return $post;
	}
	function update($args){

		$id = parent::update($args);

		if( !is_wp_error($id)){

			if( isset($args['professional_title']) ){
				update_post_meta( $id, 'professional_title', $args['professional_title'] );
			}
			if( isset($args['post_title']) ){
				global $user_ID;
				// update display name of user
				wp_update_user(array('ID' => $user_ID, 'display_name' => $args['post_title']) );
			}

		}
	}
	function update_one_meta($args){
		$request = $_REQUEST['request'];
		$profile_id = $request['ID'];
		$video_id = $request['video_id'];
		return update_post_meta( $profile_id, 'video_id', $video_id );
	}
	function check_before_update($request){
		$validate = true;
		global $user_ID;
		$profile = get_post($request['ID']);
		if($profile->post_author != $user_ID){
			 return new WP_Error('permission',__('You don\'n have permission to update','boxtheme'));
		}
		return $validate;
	}

	function update_profile_meta($args){
		$args['post_type'] = $this->post_type;
		$args['post_status'] = 'publish';
		$id = $this->update($args);
		if( !is_wp_error($id)){
		$metas = $this->get_meta_fields();
			// foreach ($metas as $key) {
			// 	if ( !empty ( $args[$key] )  ){
			// 		update_post_meta($args['ID'], $key, $args[$key] );
			// 	}
			// }
		}
		return $id;
	}
}