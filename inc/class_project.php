<?php
if ( ! defined( 'ABSPATH' ) ) exit;
Class BX_Project extends BX_Post{
	static protected $instance;
	function __construct(){
		$this->post_type = PROJECT;
		add_action( 'after_insert_'.$this->post_type, 'do_after_insert');
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
				$args['tax_input'][$tax] = array_map('intval', $args['tax_input'][$tax]); // auto insert tax if admin post project. #111
			}
		}

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
				if( !current_user_can( 'manage_option' ) ){
					$this->update_post_taxonomies($project_id, $args); // #222 - back up for #111 when employer post project.
				}

				$count_posted = (int) get_user_meta( $user_ID,'project_posted', true ) + 1;
				update_user_meta( $user_ID, 'project_posted', $count_posted);
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
		global $currency_sign;
		$spent = (float) get_user_meta( $post->post_author, SPENT, true);

		$result->spent_txt = sprintf( __( 'Spent %s','boxtheme'),box_get_price_format($spent) );
		$result->budget_txt = sprintf( __( 'Budget: %s','boxtheme'), box_get_price_format($result->_budget) );

		$not_set = __('Not set','boxtheme');
		$result->country = $not_set;
		$result->short_des = wp_trim_words( $result->post_content, 62);
		$result->time_txt = bx_show_time($result);

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

		if( $action == 'award' ){ // accept, hire assign task
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
			$bid_price = (float) get_post_meta($bid_id, BID_PRICE, true);
			$credit = BX_Credit::get_instance();
			// perform the action deposite - transfer credit from employer to freelancer account.
			$transfered = $credit->deposit( $employer_id, $bid_price, $project );

			if ( is_wp_error($transfered) ){
				return $transfered;
			}
			$request['ID'] = $project_id;
			$request['post_status'] = AWARDED;
			$request['meta_input'] = array(
				WINNER_ID => $freelancer_id,
				BID_ID_WIN => $bid_id,
			);

			$res = wp_update_post( $request );
			if( $res ){

				// create coversation
				// update bid status to AWARDED
				wp_update_post( array('ID' => $bid_id, 'post_status'=> AWARDED) );


				$order_id = BX_Order::get_instance()->create_deposit_order($bid_price, $project);
				if(!is_wp_error( $order_id ) ){
					update_post_meta( $project->ID,'deposit_order_id', $order_id );
				}
				global $user_ID;
				$fre_hired = (int) get_user_meta($employer_id, 'fre_hired', true) + 1;
				update_user_meta( $employer_id, 'fre_hired',  $fre_hired );

				// send message and email
				$freelancer_id = $request['freelancer_id'];
				$project_id = $request['project_id'];
				Box_ActMail::get_instance()->award_job( $freelancer_id );

				$cvs_content = isset($request['cvs_content'])? $request['cvs_content']: '';
				$cvs_id = is_sent_msg( $project_id, $freelancer_id );

				if( ! $cvs_id ){
					$args  = array(
						'cvs_content' => $cvs_content,
						'project_id' => $project_id,
						'receiver_id' => $freelancer_id
					);
					BX_Conversations::get_instance()->insert($args);
				} else {
					$msg_arg = array(
						'msg_content' 	=> $cvs_content,
						'cvs_id' 		=> $cvs_id,
						'receiver_id'=> $freelancer_id,
						'sender_id' => $user_ID,
						'msg_type' => 'message',
					);

					$msg_id =  BX_Message::get_instance($cvs_id)->insert($msg_arg); // msg_id
				}

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

				$commision_fee = get_commision_fee($bid_price); // web owner will get this amout.

				$emp_pay = $bid_price;
				$amout_fre_receive = $bid_price - $commision_fee;

				$project_worked = (int) get_user_meta($winner_id,PROJECTS_WORKED, true) + 1;
				$earned = (float) get_user_meta( $winner_id,EARNED, true) + $amout_fre_receive;

				update_user_meta($winner_id, PROJECTS_WORKED , $project_worked);
				update_user_meta($winner_id, EARNED , $earned);
				//approve credit
				BX_Credit::get_instance()->release($winner_id, $amout_fre_receive);

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
	function workspace_action($args, $act){
		$project_id = $args['project_id'];
		$project  = get_post($project_id);
		$check = $this->check_workspace_action($project);
		if( !is_wp_error($check ) )
			return $this->$act($args);
		return $check;
	}
	function quit_job($args){
		// undepost
		global $user_ID;

		$project_id = $args['project_id'];
		$project = get_post($project_id);
		$check = $this->check_workspace_action($project);
		if ( is_wp_error( $check ) ){
			return $check;
		}

		if ( $project->post_status != AWARDED ){
			return new WP_Error( 'status_wrong', __('This job is archived','boxtheme') );
		}
		$employer_id = $project->post_author;

		$bid_id = get_post_meta($project_id, BID_ID_WIN, true);
		$bid_price = (float) get_post_meta($bid_id, BID_PRICE, true);

		$credit = BX_Credit::get_instance();
		$transfered = $credit->undeposit( $employer_id, $bid_price, $project_id );

		if ( is_wp_error($transfered) ){
			return $transfered;
		}
		BX_Order::get_instance()->create_undeposit_order($bid_price, $project);

		$request['ID'] = $project_id;
		//$request['post_status'] = ARCHIVED;
		$request['post_status'] = 'publish';
		$request['meta_input'] = array(
			WINNER_ID => 0,
			BID_ID_WIN => 0,
			'fre_markedascomplete'=> '',
		);
		wp_delete_post( $bid_id, true );
		$res = wp_update_post($request);
		if($res){
			wp_update_post( array('ID' => $bid_id, 'post_status'=> 'publish') );
			return $res;
		}

		return true;
	}
	function fre_markascomplete($args){

		global $user_ID;
		$project_id = $args['project_id'];
		$project = get_post($project_id);
		if( $project->post_status == 'awarded' ){
			update_post_meta( $project_id, 'fre_markedascomplete', $args['review_msg'] );
		}
		$respond = array(
			'success' => true,
			'msg' => 'done',
		);
		wp_send_json( $respond);

	}

	/**
	 * admin send a message to employer or freelancer and choose the account winner in dispute case.
	 * This is a cool function
	 * @author danng
	 * @version 1.0
	 * @param   [type] $args [description]
	 * @return  [type]       [description]
	 */
	function frmadminact($args){

		$act = isset($args['act']) ? $args['act'] : 0;
		$emp_id = isset($args['emp_id']) ? $args['emp_id'] : 0;
		$fre_id = isset($args['fre_id']) ? $args['fre_id'] : 0;
		$project_id = isset($args['project_id']) ? $args['project_id'] : 0;

		$response = array('success' => true,'msg' => 'done');

		if( ! current_user_can( 'manage_options' ) ){
			wp_die('Die');
		}
		switch ($act) {
			case 'ask_fre':
				$this->insert_disputing_msg($fre_id, $args);
				break;
			case 'ask_emp':
				$this->insert_disputing_msg($emp_id, $args);
				break;
			case 'choose_fre_win':
				update_post_meta( $project_id,'choose_dispute_winner', $fre_id);
				update_post_meta( $project_id,'choose_dispute_msg', $args['msg_content']);
				wp_update_post( array( 'ID'=> $project_id, 'post_status' => 'resolved') );
				break;

			case 'choose_emp_win':
				update_post_meta($project_id,'choose_dispute_winner', $fre_id);
				update_post_meta($project_id,'choose_dispute_msg', $args['msg_content']);
				wp_update_post( array( 'ID' => $project_id, 'post_status' => 'resolved'));
				break;

			default:
				$response['success'] = false;
				$response['msg'] = __('Please select 1 option.','boxtheme');
				break;
		}


		wp_send_json( $response );
	}
	function insert_disputing_msg($receive_id, $args ){
		$cvs_id = isset($args['cvs_id']) ? $args['cvs_id'] : 0;
		$args = array(
				'msg_content' => $args['msg_content'],
				'msg_link' => get_permalink($project_id),
				'receiver_id' => $receive_id,
				'msg_is_read' => 0,
				'msg_type' => 'disputing',
				);

			$msg_dispute = BX_Message::get_instance($cvs_id)->insert($args);
	}
	function submit_disputing($args){
		global $user_ID;
		$project_id = $args['project_id'];
		$project = get_post($project_id);

		if( $project->post_status == 'awarded' ){

			$winner_id 	= get_post_meta($project->ID, WINNER_ID, true);
			wp_update_post( array('ID' => $project_id,'post_status' => 'disputing') );

			$cvs_id = is_sent_msg($project_id, $winner_id);
			$args = array(
				'sender_id' => 0,
				'msg_content' => $args['msg_content'],
				'msg_link' => get_permalink($project_id),
				'receiver_id' => $project->post_author,
				'msg_is_read' => 0,
				'msg_type' => 'disputing',
				);
			if( $user_ID == $project->post_author){
				$args['receiver_id'] = $winner_id;
			}
			update_post_meta( $project->ID,'user_send_dispute', $user_ID );
			$msg_dispute = BX_Message::get_instance($cvs_id)->insert($args);
		}
		$respond = array(
			'success' => true,
			'msg' => 'done',
		);
		wp_send_json( $respond);
	}
	function check_workspace_action($project){
		global $user_ID;
		$winner_id 	= get_post_meta($project->ID, WINNER_ID, true);
		if( current_user_can( 'manage_options' ) )
			return true;
		if( $project->post_author == $user_ID || ($winner_id && $winner_id == $user_ID) )
			return true;

		return new WP_Error( 'unallow', __( "You are not allowed to perform this action.", "boxtheme" ) );

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