<?php
	if ( ! defined( 'ABSPATH' ) ) {
		exit; // Exit if accessed directly.
	}
	require_once( get_parent_theme_file_path().'/inc/social/facebook.php');
	require_once( get_parent_theme_file_path().'/inc/social/google.php');
	Class Box_Social{
		static $instance;
		function construct(){

		}
		static function get_instance(){
			if (null === static::$instance) {
        		static::$instance = new static();
	    	}
	    	return static::$instance;

		}
		function check_exist( $email ){
			if( email_exists($email) ){
				return true;
			}
			return false;
		}
		function auto_login($userdata){

			$user_id = $this->social_id_exists($userdata['social_id']); // get user id of this social id

			if( !$user_id){
				if( email_exists($userdata['user_email'] ) ){
					return  new WP_Error( 'exists_email', __( "Sorry, that email address is already used!", "boxtheme" ) );
				}
				$userdata['user_pass'] = FREELANCER;
				$userdata['user_pass'] = wp_generate_password(12);
				$user_id = wp_insert_user($userdata);
				update_user_meta( $user_id, 'social_id', $userdata['social_id'] );
				global $wpdb;
				$wpdb->update( $wpdb->users, array( 'user_status' => 1 ), array( 'user_login' => $userdata['user_login'] ) );
				$wpdb->update( $wpdb->users, array( 'user_activation_key' => '' ), array( 'user_login' => $userdata['user_login'] ) );

			}

			// set the auth cookie to current user id
			wp_set_auth_cookie($user_id, true);
			// log the user in
			wp_set_current_user($user_id);
			// do redirect  here
			return $user_id;
		}

		function social_id_exists($social_id){
			global $wpdb;
			$sql =  $wpdb->prepare(
				"
					SELECT user_id
					FROM $wpdb->usermeta
					WHERE meta_key = %s AND meta_value = %s
				", 'social_id', $social_id
			);

			$record = $wpdb->get_row($sql );

			return ($record) ? $record->user_id : 0;
		}
	}

function bx_social_button_signup(){ ?>
    <p class="hidden-xs text-center ng-scope" >
        <label> You can also login with</label>
            <?php btn_fb_login() ;?>
            <?php btn_google_login();?>
    </p>
<?php } ?>