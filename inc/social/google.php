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
			<?php
			global $box_option;
			$social_api = $box_option->get_group_option('social_api');
			$google = (object) $social_api['google'];
			//717490652666-339obadanc1iqdkdf4a9p9o4vr2sojal
			?>
			<meta name="google-signin-client_id" content="<?php echo $google->client_id;?>">
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