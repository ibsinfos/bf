<?php
/**
 * @key: facebook.php btn_facebook_login
 *
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
class BX_Facebook{
	function __construct(){
		add_action( 'wp_head', array($this, 'add_fb_script') );
	}
	public static function add_fb_script(){
		global $box_option;
		$social_api = $box_option->get_group_option('social_api');
		$facebook = (object) $social_api['facebook'];
	?>
		<div id="fb-root"></div>
		<script>
			window.fbAsyncInit = function() {
				FB.init({
					//appId      : '256824294820471',
					appId      : '<?php echo $facebook->app_id;?>',
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

			function statusChangeCallback(response) {
			    // The response object is returned with a status field that lets the
			    // app know the current login status of the person.
			    // Full docs on the response object can be found in the documentation
			    // for FB.getLoginStatus().
			    if (response.status === 'connected') {
			    	console.log(response);
			      	// Logged into your app and Facebook.
			      	sendRequest();
			    } else{
			    	shoModalLogin();
			    }
			}

			// This function is called when someone finishes with the Login
			// Button.  See the onlogin handler attached to it in the sample
			// code below.
			function checkLoginState() {
				console.log('response  login');
				FB.getLoginStatus(function(response) {
				  statusChangeCallback(response);
				});
			}

			// Here we run a very simple test of the Graph API after login is
			// successful.  See statusChangeCallback() for when this call is made.
			function sendRequest() {
				FB.api('/me?fields=email,name', function(response) { // et email here
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
					return false;
				});
			}


			function shoModalLogin(){
				FB.login(function(response) {
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

				}, {scope: 'public_profile,email,name'});
			}
		</script>
	<?php
	}

}
	function btn_fb_login(){ ?>
		<!-- <a  data-max-rows="1" onClick="checkLoginState();" data-size="medium" data-show-faces="false" data-auto-logout-link="false"> FB </a> -->
		<li class="fb-item">
			<a href="#" class="btn-facebook" onclick="checkLoginState()">
				<img class="" src="<?php echo get_theme_file_uri('img/facebook.png');?>" />
				<!-- <fb:login-button scope="public_profile,email" class="btn-default" onlogin="checkLoginState();"></fb:login-button> -->
			</a>
		</li>

		<?php
	}
new BX_Facebook();