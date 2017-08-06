<?php
/**
 * @keyword: google.php btn_google_login
 */
Class Box_Google{
	static $instance;
	public $is_active;
	public $client_id;
	function __construct(){

		$social_api = BX_Option::get_instance()->get_group_option('social_api');
		$google = (object) $social_api['google'];
		$this->is_active = isset($google->enable) ? (int) $google->enable : 0;
		$this->client_id = $google->client_id;

		add_action( 'wp_head', array($this, 'enqueue_google_script') );
	}

	function enqueue_google_script(){
		if( is_page_template('page-login.php' ) || is_page_template('page-signup.php' ) ){
			if( $this->$is_active) { ?>
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
global $gg_activate;
$gg = new Box_Google();
$gg_activate = $gg->is_active;

function btn_google_login(){
	global $gg_activate;
	if( $gg_activate ) { ?>
		<li class="gg-item">
			<a href="btn-google" href="#">
				<img class="" src="<?php echo get_theme_file_uri('img/gplus.png');?>" />
				<div class="g-signin2" data-onsuccess="onSignIn"></div>
			</a>
		</li><?php
	}
}
