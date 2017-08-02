<?php
/**
 * @keyword: google.php btn_google_login
 */
	Class Box_Google{
		function __construct(){
			add_action( 'wp_head', array($this, 'enqueue_google_script') );
			///add_action( 'wp_footer', array($this, 'add_fb_script_footer'), 999 );
		}
		function enqueue_google_script(){
			?>
			<script src="https://apis.google.com/js/platform.js" async defer></script>

			<script type="text/javascript">
				function onSignIn(googleUser) {
					var profile = googleUser.getBasicProfile();
					console.log('ID: ' + profile.getId()); // Do not send to your backend! Use an ID token instead.
					console.log('Name: ' + profile.getName());
					console.log('Image URL: ' + profile.getImageUrl());
					console.log('Email: ' + profile.getEmail()); // This is null if the 'email' scope is not present.
					var data = {};
				 	data['action'] 		= 'bx_signup';
				 	data['role'] 		= bx_global.role_default;
				 	data['user_login'] 	=  profile.getName();
				 	data['is_social'] 	= 'google';
				 	data['facebook_id'] = profile.getId();
				 	data['user_email'] = profile.getEmail();
				   	jQuery.ajax({
					        url : bx_global.ajax_url,
					        type 	: 'post',

							data: {
								action: 'bx_signup',
								request: data,
								method: 'insert',
							},
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
						        	alert(res.msg);
						        	//$("#show_warning").html(res.msg);
						        }
					        }
					});
				}

			</script>
			<meta name="google-signin-client_id" content="717490652666-339obadanc1iqdkdf4a9p9o4vr2sojal.apps.googleusercontent.com">
			<?php
		}
		function get_instance(){

		}
	}
	function btn_google_login(){ ?>
		<div class="g-signin2" data-onsuccess="onSignIn"></div>
		<?php
	}
	new Box_Google();
?>