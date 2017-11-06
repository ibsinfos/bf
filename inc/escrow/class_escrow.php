<?php
Class Box_Escrow{
	function __construct(){

	}
	/**
	 * call this function when employer award job done and paid to system( not release)
	 * for paypal: after pay and the transaction has the "INCOMPLETE" status
	*/
	function perform_after_deposit($bid_id, $freelancer_id,  $project){
		//update bid status
		//update user meta
		if( is_numeric($project) ){
			$project = get_post($project);
		}
		$project_id = $project->ID;
		$request['ID'] = $project_id;
		$request['post_status'] = AWARDED;
		$request['meta_input'] = array(
			WINNER_ID => $freelancer_id,
			BID_ID_WIN => $bid_id,
		);

		$res = wp_update_post( $request );
		if( $res ){

			global $user_ID;
			// create coversation
			// update bid status to AWARDED
			wp_update_post( array( 'ID' => $bid_id, 'post_status'=> AWARDED) );


			$fre_hired = (int) get_user_meta( $employer_id, 'fre_hired', true) + 1;
			update_user_meta( $employer_id, 'fre_hired',  $fre_hired );

			// send message and email
			$freelancer_id = $request['freelancer_id'];
			$project_id = $request['project_id'];

			Box_ActMail::get_instance()->award_job( $freelancer_id );


			$cvs_id = is_sent_msg( $project_id, $freelancer_id );
			$cvs_content = isset($request['cvs_content'])? $request['cvs_content']: '';

			if ( ! $cvs_id ) {
				$args  = array(
					'project_id' => $project_id,
					'receiver_id' => $freelancer_id,
					'cvs_content' => $cvs_content,
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
	}
	function perform_after_release(){
		//update bid status;
		//update user meta job_hired, total_spend, rating/review.
	}
}