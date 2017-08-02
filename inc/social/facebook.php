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
	public static function add_fb_script(){
		?>
		<div id="fb-root"></div>
		<script>(function(d, s, id) {
			var js, fjs = d.getElementsByTagName(s)[0];
			if (d.getElementById(id)) return;
			js = d.createElement(s); js.id = id;
			js.src = "//connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v2.7&appId=366422403527661";
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

		// window.fbAsyncInit = function() {
		// FB.init({
		//   appId      : '366422403527661',
		//   cookie     : true,  // enable cookies to allow the server to access
		//                       // the session
		//   xfbml      : true,  // parse social plugins on this page
		//   version    : 'v2.5' // use graph api version 2.5
		// });

		// // Now that we've initialized the JavaScript SDK, we call
		// // FB.getLoginStatus().  This function gets the state of the
		// // person visiting this page and can return one of three states to
		// // the callback you provide.  They can be:
		// //
		// // 1. Logged into your app ('connected')
		// // 2. Logged into Facebook, but not your app ('not_authorized')
		// // 3. Not logged into Facebook and can't tell if they are logged into
		// //    your app or not.
		// //
		// // These three cases are handled in the callback function.

		// FB.getLoginStatus(function(response) {
		//   statusChangeCallback(response);
		// });

		// };


		// Here we run a very simple test of the Graph API after login is
		// successful.  See statusChangeCallback() for when this call is made.
		function testAPI() {
			console.log('Welcome!  Fetching your information 888.... ');
			FB.api('/me', function(response) {
				console.log(response);
				var data = {};
			 	data['action'] 		= 'bx_signup';
			 	data['role'] 		= bx_global.role_default;
			 	data['user_login'] 	= response.name + Math.random();
			 	data['is_social'] 	= 'facebook';
			 	data['facebook_id'] = response.id;
			   	jQuery.ajax({
				        url : bx_global.ajax_url,
				        type 	: 'post',
						data: data,
						beforeSend  : function(event){
				        	console.log('bat dau');
				        },
				        success : function(res){
				        	console.log(res);
				        	if ( res.success){
					        	console.log(' thanh cong');
					        	window.location.href = res.redirect_url;
					        } else {
					        	console.log('fail');
					        	//$("#show_warning").html(res.msg);
					        }
				        }
				});
					return false;
			 	console.log('Successful login for: ' + response.name);
			  	document.getElementById('status').innerHTML =
			    'Thanks for logging in, ' + response.name + '!';
			});
		}

		function customLogin(){
			FB.login(function(response) {
				console.log(response);
				if (response.authResponse) {
					console.log('Welcome!  Fetching your information 999.... ');
					console.log(response);
					FB.api('/me', function(response) {
						console.log(response);
					});
				} else {
				 	console.log('User cancelled login or did not fully authorize.');
				}
			});
		}
	</script>
	<?php
	}

}
	function btn_fb_login(){ ?>
		<div id="status"></div>
		<a  data-max-rows="1" onClick="customLogin();" data-size="medium" data-show-faces="false" data-auto-logout-link="false"></a>
		<fb:login-button scope="public_profile,email" onlogin="checkLoginState();"></fb:login-button>
		<?php
	}
new BX_Facebook();