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

			$current_user = $this->social_id_exists($userdata['social_id']); // get user id of this social id

			if( !$current_user){
				if( email_exists($userdata['user_email'] )){
					return  new WP_Error( 'exists_email', __( "Sorry, that email address is already used!", "boxtheme" ) );
					wp_die('123');
				}
				$userdata['user_pass'] = wp_generate_password();
				$current_user = wp_insert_user($userdata);
			}
			update_user_meta( $current_user, 'social_id', $current_user );
			// set the auth cookie to current user id
			wp_set_auth_cookie($current_user, true);
			// log the user in
			wp_set_current_user($current_user);
			// do redirect  here
			wp_safe_redirect(get_permalink(). '#response');
			return $current_user;
		}

		function social_id_exists($social_id){
			global $wpdb;
			$current_user = $wpdb->get_var( $wpdb->prepare(
				"
					SELECT meta_key
					FROM $wpdb->usermeta
					WHERE meta_key = %s
				",
				$social_id
			) );
			return $current_user;
		}
	}

function bx_social_button_signup(){ ?>
    <p class="hidden-xs text-center ng-scope" >
        <label> You can also login with</label>
            <?php btn_fb_login() ;?>
            <?php btn_google_login();?>
    </p>
<?php } ?>