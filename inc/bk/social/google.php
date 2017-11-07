<?php
/**
 * @keyword: google.php btn_google_login
 */
Class Box_Google{
	static $instance;
	public $is_active;
	public $client_id;
	function __construct(){
		global $app_api;
		$google =  (object) $app_api->google;
		$this->is_active = isset($google->enable) ? (int) $google->enable : 0;
		if( isset($this->client_id) )
			$this->client_id = $google->client_id;
		if( empty( $this->client_id ) )
			$this->is_active = 0;


		add_action( 'wp_head', array($this, 'enqueue_google_script') );
	}

	function enqueue_google_script(){
		if( is_page_template('page-login.php' ) || is_page_template('page-signup.php' ) ){
			if( $this->is_active) { ?>
				<script src="https://apis.google.com/js/platform.js" async defer></script>
				<script type="text/javascript">
					function onSignIn(googleUser) {
						var profile = googleUser.getBasicProfile();
					 	var data = {user_login: profile.getName(),type:'google', social_id: profile.getId(), user_email: profile.getEmail() };
					   	jQuery.ajax({
					        url : bx_global.ajax_url,
					        emulateJSON: true,
		   					method :'post',

							data: {
								action: 'social_signup',
								request: data,
							},
							beforeSend  : function(event){
								console.log(data);
					        	console.log('bat dau line 87');
					        },
					        success : function(res){
					        	console.log(res);
					        	if ( res.success){
						        	if(res.redirect_url){
						        		window.location.href = res.redirect_url;
						        	} else {
						        		window.location.href = bx_global.home_url;
						        	}
						        } else {
						        	if(res.redirect_url){
						        		window.location.href = res.redirect_url;
						        	} else {
						        		alert(res.msg);
						        	}
						        }
					        }
						});
					   return false;
					}
				</script>
				<meta name="google-signin-client_id" content="<?php echo $this->client_id;?>"> <?php
			}
		}
	}
}


function btn_google_login(){
	global $gg_activate, $social_log;
	if( $gg_activate ) {
		$social_log = true;
		?>
		<li class="gg-item">
			<a href="btn-google" href="#">
				<img class="" src="<?php echo get_theme_file_uri('img/gplus.png');?>" />
				<div class="g-signin2" data-onsuccess="onSignIn"></div>
			</a>
		</li><?php
	}
}
