<?php
/**
 * @key: facebook.php btn_facebook_login
 *
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
class BX_Facebook{
	public $is_active;
	public $app_id;
	static $instance;
	function __construct(){

		$app_api = BX_Option::get_instance()->get_group_option('app_api');
		$facebook = array();
		$facebook = (object) $app_api->facebook;
		$this->is_active = isset($facebook->enable) ? (int) $facebook->enable : 0;

		if( isset($facebook->app_id) )
			$this->app_id = $facebook->app_id;
		add_action( 'wp_head', array($this, 'add_fb_script') );
	}

	public  function add_fb_script(){
		if( $this->is_active) {
			if( is_page_template('page-login.php' ) || is_page_template('page-signup.php' ) ){ ?>
				<div id="fb-root"></div>
				<script>
					window.fbAsyncInit = function() {
						FB.init({
							//appId      : '256824294820471',
							appId      : '<?php echo $this->app_id;?>',
							cookie     : true,
							xfbml      : true,
							version    : 'v2.8'
						});
						//FB.AppEvents.logPageView();
					};
					(function(d, s, id){
					   	var js, fjs = d.getElementsByTagName(s)[0];
					   	if (d.getElementById(id)) {return;}
					   	js = d.createElement(s); js.id = id;
					   	js.src = "//connect.facebook.net/en_US/sdk.js";
					   	fjs.parentNode.insertBefore(js, fjs);
					}(document, 'script', 'facebook-jssdk'));

					function shoModalLogin(){
						FB.login( function(response) {
							if (response.authResponse) {
								FB.api('/me', {fields: 'name, email'}, function (response) {
									var data = {user_login: response.name,type:'facebook', social_id: response.id, user_email: response.email };
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
								}); //end FB.api
							} // end success;
						}, { scope: 'email,public_profile' } );
					}
				</script>
				<?php			}
		}
	}
}

global $fb_activate, $is_social; // init is_social
$fb = new BX_Facebook();
$fb_activate = $fb->is_active;
if($fb_activate){
	$is_social= true;
}
function btn_fb_login(){
	global $fb_activate;

	if( $fb_activate) {	?>
		<li class="fb-item">
			<a href="#" class="btn-facebook" onclick="shoModalLogin()">
				<img class="" src="<?php echo get_theme_file_uri('img/facebook.png');?>" />
			</a>
			<!-- <fb:login-button scope="public_profile,email" class="btn-default1" onlogin="checkLoginState();"></fb:login-button> -->
		</li> <?php
	}
}