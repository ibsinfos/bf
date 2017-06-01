<?php
if ( ! defined( 'ABSPATH' ) ) exit;
Class BX_Project extends BX_Post{
	static protected $instance;
	function __construct(){
		$this->post_type = PROJECT;
	}
	static function get_instance(){
		if (null === static::$instance) {
        	static::$instance = new static();
    	}
    	return static::$instance;
	}
	function get_meta_fields(){
		return array( BUDGET,WINNER_ID);
	}
	function get_taxonomy_fields(){
		return array('project_cat', 'skill');
	}

	function get_hierarchica_taxonomy(){
		return array('project_cat');
	}
	function get_nonhierarchica_taxonomy(){
		return array('skill');
	}

	function insert($args){
		global $user_ID;
		$args['author'] 		= $user_ID;
		$args['post_status'] 	= 'publish';
		$args['post_type'] 		= $this->post_type;
		$args['meta_input'] 	= array();
		$metas 			= $this->get_meta_fields();
		$taxonomies 	= $this->get_taxonomy_fields();

		foreach ($metas as $key) {
			if ( !empty ( $args[$key] )  ){
				$args['meta_input'][$key] = $args[$key];
			}
		}
		$nonhierarchica = $this->get_nonhierarchica_taxonomy();
		$hierachice 	= $this->get_hierarchica_taxonomy();
		foreach ($taxonomies as $tax) {
			if ( !empty ( $args[$tax] )  ){
				$args['tax_input'][$tax] = $args[$tax];
			}
		}
		foreach ( $hierachice as $tax ) {
			if ( !empty ( $args['tax_input'][$tax] )  ){
				$args['tax_input'][$tax] = array_map('intval', $args['tax_input'][$tax]);
			}
		}
		//var_dump($args);
		//https://developer.wordpress.org/reference/functions/wp_insert_post/
		$check = $this->check_before_insert( $args );
		if ( ! is_wp_error( $check ) ){
			$project_id = wp_insert_post($args);
			if ( !is_wp_error( $project_id ) ){
				if( isset($args['attach_ids']) ){
					foreach ($args['attach_ids'] as $attach_id) {
						wp_update_post( array(
							'ID' => $attach_id,
							'post_parent' => $project_id
							)
						);
					}
				}
				return $project_id;

			}
			return new WP_Error( 'insert_fail',  $project_id->get_error_message() );

		} else {

			return new WP_Error( 'insert_fail',$check->get_error_message()  );
		}

		return $id;
	}

	/**
	 * [convert description]
	 * This is a cool function
	 * @author danng
	 * @version 1.0
	 * @return  [type] [description]
	 */
	function convert($post){

		$result = parent::convert($post);
		$profile_id =get_user_meta($post->post_author,'profile_id', true);

		$spent = get_user_meta( $post->post_author, SPENT, true);
		if( ! $spent ){
			$spent = 0;
		}

		$result->spent = sprintf( __( '%s <span>spent</span>','boxtheme'), $spent );
		$not_set = __('Not set','boxtheme');
		$result->country = $not_set;

		if( $profile_id ){

			$pcountry = get_the_terms( $profile_id, 'country' );

			if( !empty( $pcountry ) ){
				$result->country =  $pcountry[0]->name;
			}

		}
		return $result;
	}

	function check_before_post($args){

		if( !is_user_logged_in() ){
			return new WP_Error( 'not_logged', __( "Please log in your account again.", "boxtheme" ) );
		}
		return true;
	}
	function call_action($request, $action){

		if( $action == 'award' ){
			$bid_id = $request['bid_id'];
			$project_id = $request['project_id'];
			$freelancer_id = $request['freelancer_id'];


			$project = get_post($project_id);

			$check = $this->check_before_award($project, $freelancer_id);
			if( is_wp_error( $check ) ){
				return $check;
			}
			// check balance and deducts.

			$employer_id = $project->post_author;


			$credit = BX_Credit::get_instance();
			// perform the action deposite - transfer credit from employer to freelancer account.
			$transfered = $credit->deposit( $employer_id, $bid_id, $project_id );

			if ( is_wp_error($transfered) ){
				return $transfered;
			}
			$request['ID'] = $project_id;
			$request['post_status'] = AWARDED;
			$request['meta_input'] = array(
				WINNER_ID => $freelancer_id,
				BID_ID_WIN => $bid_id,
			);

			$res = wp_update_post($request);
			if($res){

				// create coversation
				// update bid status to AWARDED
				wp_update_post( array('ID' => $bid_id, 'post_status'=> AWARDED) );
				$args  = array(
					'cvs_content' => $request['cvs_content'],
					'cvs_project_id' => $request['project_id'],
					'cvs_freelancer_id' => $request['freelancer_id']
				);
				BX_Conversations::get_instance()->insert($args);

				return $res;
			}
			return new WP_Error( 'award_fail', __( "You don't permission to perform this action", "boxtheme" ) );
			//wp_update
			// update post status and  freelancer of this project
		} else if($action == 'review_fre'){
			// action of employer
			// mark as close project
			$request['ID'] = $request['project_id'];
			$request['post_status'] = DONE;
			$check = $this->check_before_emp_review($request);
			if ( is_wp_error($check) ){
				return $check;
			}


			$project_id = wp_update_post($request);

			if( !is_wp_error($project_id) ){
				global $current_user;
				$bid_win_id = get_post_meta($project_id, BID_ID_WIN, true);
				$review_msg = $request[REVIEW_MSG];
				$rating_score = (int) $request[RATING_SCORE];
				if($rating_score > 5){
					$rating_score = 5;
				}
				if( $rating_score < 1 ) {
					$rating_score = 1;
				}

				$winner_id 	= get_post_meta($project_id, WINNER_ID, true);

				$bid_price 	= (float) get_post_meta($bid_win_id, BID_PRICE, true);
				// var_dump($bid_win_id);
				// var_dump($budget);
				// var_dump($winner_id);
				$commision_fee = get_commision_fee($bid_price); // web owner will get this amout.

				$emp_pay = $bid_price;
				$amout_fre_receive = $bid_price - $commision_fee;

				$project_worked = (int) get_user_meta($winner_id,PROJECTS_WORKED, true) + 1;
				$earned = (float) get_user_meta( $winner_id,EARNED, true) + $amout_fre_receive;

				update_user_meta($winner_id, PROJECTS_WORKED , $project_worked);
				update_user_meta($winner_id, EARNED , $earned);
				//approve credit
				BX_Credit::get_instance()->approve_credit_pending($winner_id, $amout_fre_receive);

				$bid_args = array(
					'ID' 	=> $bid_win_id,
					'post_status' => DONE,

				);
				$bid = wp_update_post( $bid_args);





				$current_user = wp_get_current_user();
				$time = current_time('mysql');
				$data = array(
				    'comment_post_ID' => $bid_win_id,
				    'comment_author' => $current_user->user_login,
				    'comment_author_email' => $current_user->user_email,
				    'comment_content' => $review_msg,
				    'comment_type' => 'emp_review',
				    'comment_approved' => 1,
				    'user_id' => $winner_id,
				    'comment_date' => $time,
				);

				$cmn_id = wp_insert_comment($data);
				if( !is_wp_error($cmn_id)){
					add_comment_meta($cmn_id, RATING_SCORE, $rating_score);
					$rating_score = count_rating($winner_id);
					update_user_meta($winner_id,RATING_SCORE,$rating_score);
				}
			}
			// update project status
			// update bid status
		} else if($action == 'review_emp'){
			// action of freelancer.
			global $current_user;
			$project_id = $request['project_id'];
			$review_msg = $request[REVIEW_MSG];
			$rating_score = (int) $request[RATING_SCORE];
			$check = $this->check_before_fre_review($request);
			if($rating_score > 5){
				$rating_score = 5;
			}
			if($rating_score < 1){
				$rating_score = 1;
			}

			if ( is_wp_error($check) ){
				return $check;
			}


			$time = current_time('mysql');
			$project = get_post($project_id);
			$current_user = wp_get_current_user();

			$data = array(
				'comment_author' => $current_user->user_login,
				'comment_author_email' => $current_user->user_email,
			    'comment_post_ID' => $project_id,
			    'comment_content' => $review_msg,
			    'comment_type' => 'fre_review',
			    'user_id' => $project->post_author,
			    'comment_date' => $time,
			    'comment_approved' => 1,
			);

			$cmn_id = wp_insert_comment($data);
			if( !is_wp_error( $cmn_id ) ){
				add_comment_meta( $cmn_id, RATING_SCORE, $rating_score);
				update_post_meta( $project_id, 'is_fre_review', 1);
				$rating_score = count_rating( $project->post_author );
				update_user_meta( $project->post_author,RATING_SCORE,$rating_score );

			}

		}
	}
	/**
	 * check the condition and make sure it fit with the flow of system.
	 * This is a cool function
	 * @author danng
	 * @version 1.0
	 * @param   object $project
	 * @param   int $freelancer_id
	 * @return  bool  true or false
	 */
	function check_before_award( $project, $freelancer_id ){


		global $user_ID;

		if( (int)$project->post_author !== $user_ID ){
			return new WP_Error( 'empty', __( "You are not author of this project.", "boxtheme" ) );
		}
		if( $project->post_status != 'publish'){
			return new WP_Error( 'empty', __( "This project was awrded.", "boxtheme" ) );
		}
		if( empty($freelancer_id) ){
			return new WP_Error( 'empty', __( "Please choose a winner.", "boxtheme" ) );
		}

		return true;
	}
	function check_before_emp_review($request){
		$rating_score = $request[RATING_SCORE];
		if( empty($rating_score) ){
			return new WP_Error( 'empty', __( "You have to set score", "boxtheme" ) );
		}
		$project_id = $request['project_id'];
		$project = get_post($project_id);

		if($project->post_status != AWARDED){
			return new WP_Error( 'empty', __( "This project is not available", "boxtheme" ) );
		}
		global $user_ID;

		if( (int) $project->post_author != $user_ID){
			return new WP_Error( 'empty', __( "You are not author of this project.", "boxtheme" ) );
		}
		return true;
	}
	function check_before_fre_review($request){
		$rating_score = $request[RATING_SCORE];
		if( empty($rating_score) ){
			return new WP_Error( 'empty', __( "You have to set score", "boxtheme" ) );
		}
		$project_id = $request['project_id'];
		$is_fre_review = get_post_meta($project_id, 'is_fre_review', true);

		if( $is_fre_review ){
			return new WP_Error( 'empty', __( "You revieded this project.", "boxtheme" ) );
		}
		$winner_id  = get_post_meta($project_id,WINNER_ID, true);
		global $user_ID;

		if( (int) $winner_id != $user_ID){
			return new WP_Error( 'empty', __( "You are not winner.", "boxtheme" ) );
		}
		return true;
	}

}