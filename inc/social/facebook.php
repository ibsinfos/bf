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
		///add_action( 'wp_footer', array($this, 'add_fb_script_footer'), 999 );
	}
	public static function add_fb_script(){ ?>
		<div id="fb-root"></div>
		<script>
			window.fbAsyncInit = function() {
				FB.init({
					appId      : '256824294820471',
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
			      testAPI();
			    } else if (response.status === 'not_authorized') {
			      // The person is logged into Facebook, but not your app.
			      document.getElementById('status').innerHTML = 'Please log ' +
			        'into this app.';
			    } else {
			      // The person is not logged into Facebook, so we're not sure if
			      // they are logged into this app or not.
			      document.getElementById('status').innerHTML = 'Please log ' +
			        'into Facebook.';
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
			function testAPI() {
				FB.api('/me?fields=email,name', function(response) { // et email here
					console.log(response);
					var data = {};
				 	data['action'] 		= 'social_signup';
				 	data['role'] 		= bx_global.role_default;
				 	data['user_login'] 	= response.name;
				 	data['type'] 	= 'facebook';
				 	data['social_id'] = response.id;
				 	data['user_email'] = response.email;
				   	jQuery.ajax({
					        url : bx_global.ajax_url,
					        type 	: 'post',

							data: {
								action: 'social_signup',
								request: data,
							},
							beforeSend  : function(event){
					        	console.log('bat dau');
					        },
					        success : function(res){
					        	console.log(res);
					        	if ( res.success){

						        	if(res.redirect_url){
						        		window.location.href = res.redirect_url;
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

				  	document.getElementById('status').innerHTML =
				    'Thanks for logging in, ' + response.name + '!';
				});
			}

		</script>
	<?php
	}

}
	function btn_fb_login(){ ?>
		<div id="status"></div>
		<!-- <a  data-max-rows="1" onClick="checkLoginState();" data-size="medium" data-show-faces="false" data-auto-logout-link="false"> FB </a> -->
		<fb:login-button scope="public_profile,email" onlogin="checkLoginState();"></fb:login-button>

		<?php
	}
new BX_Facebook();