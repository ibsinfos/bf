<?php
/**
 *	Template Name: Warning Verify accoun
 */
?>
<?php get_header(); ?>
<div class="full-width">
	<div class="container site-container">
		<div class="row " id="content" >
		<div class="col-md-12  text-justify mt50" style="min-height: 450px; padding-top: 100px;">
			<?php

			$verify_key = isset($_GET['key']) ? wp_unslash($_GET['key']) :'';
			$user_login = isset($_GET['user_login']) ? wp_unslash($_GET['user_login']) :'';
			$user_id 	= 0;
			global $wpdb;

			if( !empty( $verify_key) && !empty( $user_login) ) {

				$user = check_password_reset_key( $verify_key, $user_login );

				if ( ! $user || is_wp_error( $user ) ) {
					if ( $user && $user->get_error_code() === 'expired_key' ){
						_e('Key is expired', 'boxtheme');
					}
				} else {

					$wpdb->update( $wpdb->users, array( 'user_status' => 1 ), array( 'user_login' => $user_login ) );
					$wpdb->update( $wpdb->users, array( 'user_activation_key' => '' ), array( 'user_login' => $user_login ) );

					$redirect_link = '';
					$user_id = $user->ID;
					if( bx_get_user_role($user->ID) == FREELANCER ){

						$redirect_link =  bx_get_static_link('profile');
						// save status 1 as verified of this user.
						$args = array(
							'post_title' 	=> $user->first_name . ' '.$user->last_name ,
							'post_type'  	=> PROFILE,
							'post_author' 	=> $user_id,
							'post_status' 	=> 'publish',
							'meta_input'	=> array(
								HOUR_RATE => 0,
								RATING_SCORE => 0,
								)
						);
						$profile_id = wp_insert_post($args);
						update_user_meta( $user_id, 'profile_id', $profile_id );
					} else {
						$redirect_link = home_url();
					}
					?>
					<form name="redirect">
						<center>
							<?php _e('Your account is verified. You are redirecting to home page.','boxtheme'); ?>
							<form>
							<input type="hidden" size="3" readonly="true" name="redirect2">
						</center>
					</form>
					<script>
						var targetURL= "<?php echo $redirect_link; ?>";
						var countdownfrom=2
						var currentsecond=document.redirect.redirect2.value=countdownfrom+1
						function countredirect(){
							if (currentsecond!=1){
								currentsecond-=1
								document.redirect.redirect2.value=currentsecond
							}else{
								window.location=targetURL
								return
							}
							setTimeout("countredirect()",1000)
						}
						countredirect()
					</script>
					<?php
				}
			} else if( is_user_logged_in() ) {
				$user 	= wp_get_current_user();
			 ?>
			<div id="verify_content">
				<h2 class="primary-font"><?php _e('Verify your email address to access website','boxtheme');?></h2>

				<div class="col-md-12 mt50">
					<?php printf (__('We\'ve just sent an email to your address: <strong>%s</strong><br /> Please check your email and click on the link provided to verify your account.','boxtheme'), $user->user_email) ; ?>
				</div>
			</div>
			<?php } ?>
		</div>
	</div>
</div>
</div>

<?php get_footer();?>

