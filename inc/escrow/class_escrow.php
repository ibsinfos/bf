<?php
Class Box_Escrow{
	function __construct(){

	}
	/**
	 * call this function when employer award job done and paid to system( not release)
	 * for paypal: after pay and the transaction has the "INCOMPLETE" status
	*/

	function perform_after_release(){
		//update bid status;
		//update user meta job_hired, total_spend, rating/review.
	}
	function send_mail_noti_assign( $project, $freelancer_id, $cvs_status = 'publish'){



		Box_ActMail::get_instance()->award_job( $freelancer_id );
		if( is_numeric( $project ) ){
			$project = get_post($project);
		}
		$project_id = $project->ID;

		$request = isset( $_REQUEST['request'] ) ? $_REQUEST['request'] : '';
		$cvs_content  = 'New project is assign for you';
		if( $request){
			$cvs_content = isset( $request['cvs_content'])? $request['cvs_content']: '';
		}
		$cvs_id = is_sent_msg( $project_id, $freelancer_id );
		global $user_ID;
		if ( ! $cvs_id ) {
			$args  = array(
				'project_id' => $project_id,
				'receiver_id' => $freelancer_id,
				'cvs_content' => $cvs_content,
				'cvs_status' => $cvs_status,
			);

			BX_Conversations::get_instance()->insert($args);

		} else {
			$msg_arg = array(
				'msg_content' 	=> $cvs_content,
				'cvs_id' 		=> $cvs_id,
				'receiver_id'=> $freelancer_id,
				'sender_id' => $project->post_author,
				'msg_type' => 'message',
			);

			$msg_id =  BX_Message::get_instance($cvs_id)->insert($msg_arg); // msg_id
		}
	}

}