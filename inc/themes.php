<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * Enqueue scripts and styles.
 */
function box_log($input, $file_store = ''){
	$file_store =LOG_FILE;
	//WP_CONTENT_DIR.'/ipn.log');
	if( is_array($input) ){
		error_log( print_r($input, TRUE), 3, $file_store );
	}else {
		error_log($input . "\n" , 3, $file_store);
	}
}


function bx_signon($info){
	$creds 		= array();
	if(isset($info['user_pass']))
		$info['user_password'] = $info['user_pass'];

	$creds['user_login'] 	= $info['user_login'];
	$creds['user_password'] = $info['user_password'];

	$creds['remember'] 		= true;

	$response 	= array( 'success' => false, 'msg' => __('Login fail','boxtheme') );

	$user = wp_signon( $creds, false );

	if ( ! is_wp_error( $user ) ){
		$response 	= array( 'success' => true, 'msg' => __('You have logged succesful','boxtheme') );
	} else  {
		$type_error = $user->get_error_codes()[0];
		//invalid_username,empty_username,empty_password,incorrect_password
		if ( in_array($type_error, array('empty_username') ) ){
			$msg = __('The username field is empty', 'boxtheme');
		} else	if ( in_array($type_error, array('empty_password') ) ){
			$msg = __('The password field is empty', 'boxtheme');
		} else if ( in_array( $type_error, array('invalid_username') ) ){
			$msg = __('Invalid username', 'boxtheme');
		}else if ( in_array($type_error, array('incorrect_password') ) ){
			$msg = sprintf(__('The password you entered for the username %s is incorrect', 'boxtheme'), $info['user_login']);
		} else {
			$msg = strip_tags($user->get_error_message());
		}
		$response['msg'] 			= $msg;

		$response['success'] 		= false;
    }
    if( !empty( $info['redirect_url'] ) )
    	$response['redirect_url'] 	= $info['redirect_url'];
	return $response;
}
if( ! function_exists('bx_get_verify_key')):
	/**
	 * clone of the method get_password_reset_key
	 * check update then the get_password_reset_key update.
	*/
	function bx_get_verify_key( $username ) {
		global $wpdb, $wp_hasher;

		// Generate something random for a password reset key.
		$key = wp_generate_password( 20, false );

		// Now insert the key, hashed, into the DB.
		if ( empty( $wp_hasher ) ) {
			require_once( ABSPATH . WPINC . '/class-phpass.php');
			$wp_hasher = new PasswordHash( 8, true );
		}
		$hashed = time() . ':' . $wp_hasher->HashPassword( $key );
		$key_saved = $wpdb->update( $wpdb->users, array( 'user_activation_key' => $hashed ), array( 'user_login' => $username ) );
		if ( false === $key_saved ) {
			return new WP_Error( 'no_password_key_update', __( 'Could not save password reset key to database.','boxtheme' ) );
		}

		return $key;
	}
endif;
add_action('wp_mail_failed','show_mail_fail');
function show_mail_fail($wp_error){
	//var_dump($wp_error);
}
if( !function_exists('list_dealine') ) :
	function list_dealine(){
		$list = array(
		 	__('Less than 1 week','boxtheme'),
		 	__('Less than 1 month','boxtheme'),
		 	__('1 to 3 months','boxtheme'),
		 	__('3 to 6 months','boxtheme'),
		 	__('More than 6 months','boxtheme'),
		);
		return $list;
	}
endif;
function is_account_verified($user_ID){ //is_verified
	return BX_User::get_instance()->is_verified($user_ID);
}


function is_owner_project( $project ) {
	global $user_ID;
	if( ! $user_ID )
		return false;
	if( $project->post_author == $user_ID ){
		return true;
	}
	return false;
}
function can_access_workspace($project){
	global $user_ID;

	if( is_owner_project($project) ){
		return true;
	}
	$winner_id = $project->{WINNER_ID};
	if( in_array( $user_ID, array($winner_id, $project->post_author) )) {
		return true;
	}
	if( current_user_can('manage_options') ){
		return true;
	}
	return false;
}

function current_user_can_bid($project){
	return BX_Bid::get_instance()->is_can_bid($project);
}
function is_current_user_bidded($project_id){
	$project_id = (int)$project_id;
	return BX_bid::get_instance()->has_bid_on_project($project_id);
}
function countr_of_user($profile){
}

/**
 *
 * This is a cool function
 * @author danng
 * @version 1.0
 * @param   int $user_id who will receive this rating.
 * @param   string $type    emp_review ==> author of this review is employer.
 * @return  [type]          [description]
 */
function count_rating($user_id,$type ='emp_review'){
	global $wpdb;


	return $wpdb->get_var(
				$wpdb->prepare(
					"
					SELECT ROUND(ROUND( AVG(mt.meta_value) * 2 ) / 2,1)
					FROM $wpdb->comments cm
						INNER JOIN $wpdb->commentmeta mt
							ON cm.comment_ID = mt.comment_id
								AND cm.user_id = %s
								AND cm.comment_type = '%s'
								AND mt.meta_key = '%s'
								AND mt.meta_value > 0
					",
					$user_id, $type, RATING_SCORE
				)
	);
}
/**
 * [get_conversation_id_of_user count number message unread of a usder

 * @author danng
 * @version 1.0
 * @param   integer $user_ID ID of user ID
 * @return  integer number message unread
 */

function count_bids($project_id){
	global $wpdb;
	return $wpdb->get_var( " SELECT COUNT(*) FROM $wpdb->posts WHERE post_type = 'bid' AND post_parent= {$project_id}" );
}

function box_account_dropdow_menu(){ global $role; global $user_ID; $current_user = wp_get_current_user();

	global $user_ID, $wpdb;

	$messages = $notifies = array();

	$has_new_noti = (int) get_user_meta($user_ID,'has_new_notify', true);

	if(  $has_new_noti ){

		$list_unread  = $wpdb->get_results( $wpdb->prepare(
			"SELECT msg.ID, msg.msg_unread, msg.sender_id, msg.msg_date , msg.msg_content, msg.msg_type, msg.msg_link
			FROM {$wpdb->prefix}box_messages msg
			WHERE msg_unread = 1 AND receiver_id = %d ", $user_ID)
		);

		if( $list_unread){

			foreach ($list_unread as $custom) {

				if( $custom->msg_type == 'message' )
					$messages[] = $custom;

				if( $custom->msg_type  == 'notify' )
					$notifies[] = $custom;
			}
		}
	}

	$number_new_msg = count($messages);
	$msg_class= 'empty-msg';
	if( $number_new_msg > 0 )
		$msg_class = "has-msg-unread"

?>
	<ul class="account-dropdown">
		<li class="profile-account dropdown ">

			<a rel="nofollow" class="dropdown-toggle account-name" data-toggle="dropdown" href="#"><div class="head-avatar"><?php echo get_avatar($user_ID);?></div><span class="username"><?php echo $current_user->display_name;?></span> <span class="caret"></span>
			<span class="<?php echo $msg_class;?>"><?php echo $number_new_msg;?></span>
			</a>
			<ul class="dropdown-menu account-link" >
				<?php if($role == FREELANCER){ ?>
					<li> <i class="fa fa-th-list" aria-hidden="true"></i> <a href="<?php echo box_get_static_link('dashboard');?>"><?php _e('My Job','boxtheme');?></a></li>
				<?php } else { ?>
					<li> <i class="fa fa-th-list" aria-hidden="true"></i> <a href="<?php echo box_get_static_link('dashboard');?>"><?php _e('My Project','boxtheme');?></a></li>
				<?php }  ?>
				<li><i class="fa fa-credit-card" aria-hidden="true"></i> <a href="<?php echo box_get_static_link('my-credit');?>"><?php _e('My Credit','boxtheme');?></a></li>
				<li> <i class="fa fa-user-circle-o" aria-hidden="true"></i> <a href="<?php echo box_get_static_link('my-profile');?>"><?php _e('My Profile','boxtheme');?></a></li>

				<li> <i class="fa fa-envelope" aria-hidden="true"></i> <a href="<?php echo box_get_static_link('messages');?>"><?php _e('Message','boxtheme');?></a> <span class="<?php echo $msg_class;?>"><?php echo $number_new_msg ?></span></li>

				<li> <i class="fa fa-sign-out" aria-hidden="true"></i>  <a href="<?php echo wp_logout_url( home_url() ); ?>"><?php _e('Logout','boxtheme');?></a></li>
			</ul>
		</li>
		<li class="icon-bell first-sub no-padding-left pull-left"">
			<div class="dropdown">
			  	<span class="dropdown-toggle <?php if ( $has_new_noti)  echo 'toggle-msg';?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-bell  " aria-hidden="true"></i></span> <?php
			  	echo '<ul class=" dropdown-menu ul-notification">';
			  	$unread = 0;
				if( !empty ( $notifies) ) {

					foreach ($notifies as $noti) {
						$class ="noti-read";
						if( $noti->msg_unread == 1) { $unread ++; $class="noti-unread"; }
						$date = date_create( $noti->msg_date );
						$date = date_format($date,"m/d/Y");	?>

						<li class="dropdown-item <?php echo $class;?>">
							<div class="left-noti"><a href="#"><?php echo get_avatar( $noti->sender_id ); ?></a></div>
							<div class='right-noti'>
								<a href="<?php echo esc_url($noti->msg_link);?>"><?php echo stripslashes($noti->msg_content);?></a>
								<?php echo '<small class="mdate">'.$date.'</small>'; ?>
							</div>
							<span class="btn-del-noti" title="<?php _e('Remove','boxtheme');?>" rel="<?php echo $noti->ID;?>" href="#"><i class="fa fa-times primary-color" aria-hidden="true"></i></span>
						</li> <?php
					}

				} else { ?>
					<p class="empty-noty"><?php _e('There is no new notification','boxtheme');?></p>
				<?php }
				echo '</ul>';
				if( $unread )
					echo '<span class="notify-acti">'.$unread.'</span>'; ?>
			</div>
		</li>
	</ul>
<?php }

if( ! function_exists( 'box_social_link' ) ){
	function box_social_link( $general ){ ?>
		<ul class="social-link">
    		<?php
    		if ( !empty( $general->gg_link ) )
    			echo '<li><a class="gg-link"  target="_blank" href="'.esc_url($general->gg_link).'"><span></span></a></li>';
    		if ( !empty( $general->tw_link ) )
    			echo '<li><a class="tw-link" target="_blank"  href="'.esc_url($general->tw_link).'"><span></span></a></li>';
    		if ( !empty( $general->fb_link ) )
    			echo '<li><a class="fb-link"  target="_blank" href="'.esc_url($general->fb_link).'"><span></span></a></li>'; ?>
    	</ul> <?php
	}
}
function heading_project_info($project, $is_workspace){ ?>
	<div class="full heading">
		<div class ="col-md-2 no-padding-right"><?php printf(__('Status: %s','boxtheme'),$project->post_status); ?></div>
      	<div class="col-md-3"><?php printf(__('Post date: %s','boxtheme'),get_the_date() );?></div>
      	<div class="col-md-3"><?php printf(__("Fixed price: %s",'boxtheme'),box_get_price_format($project->_budget) ); ?> </div>
      	<div class="col-md-4"> 	<?php
      	global $can_access_workspace;

      	if( $project->post_status != 'publish' && $can_access_workspace ) {
      		step_process($is_workspace);
      	} else {
      		box_social_share();
      	} ?>
      	</div>

	</div> <!-- full !-->
	<?php
}
function step_process( $is_workspace ){
		global $project, $can_access_workspace, $winner_id, $is_dispute;
		$class = $detail_section = $dispute_section = '';
		if( $is_workspace ){
			$class ='current-section';
		} else if( $is_dispute) {
			$dispute_section = 'current-section';
		} else {
			$detail_section = 'current-section';
		}

		if( $can_access_workspace && in_array( $project->post_status, array('awarded','done','dispute','finish','disputing', 'disputed','archived') ) ) { ?>
	    	<ul class="job-process-heading">
	    		<?php if( $is_workspace){ ?>
					<li class="<?php echo $detail_section;?>"><a href="<?php echo get_permalink();?>"> <span class="glyphicon glyphicon-list"></span> <?php _e('Job Detail','boxtheme');?></a></li>
				<?php } ?>
				<li class=" text-center <?php echo $class;?>"><a href="?workspace=1"> <span class="glyphicon glyphicon-saved"></span> <?php _e('Workspace','boxtheme');?></a>	</li>
				<li class="text-right <?php echo $dispute_section;?>"><a href="?dispute=1"> <span class="glyphicon glyphicon-saved"></span> <?php _e('Dispute','boxtheme');?></a>	</li>
	    	</ul> <?php
	    }
	}
	function box_project_status($status){
		$args = array(
			'publish' => __('Open','boxtheme'),
			'pending' => __('Pending','boxtheme'),
			'draft' => __('Draft','boxtheme'),
			'awarded' => __('Working','boxtheme'),
			'done' => __('Done','boxtheme'),
			'archived' => __('Archived','boxtheme'),
			'disputing' => __('Disputing','boxtheme'),
			'resolved' => __('Resolved','boxtheme'),
			'inherit' => '',

		);
		if( isset($args[$status]) )
			return $args[$status];
		return '';
	}