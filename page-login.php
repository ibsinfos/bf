<?php
/**
 *	Template Name: Page Login
 */
?>
<?php get_header(); ?>
<div class="full-width ">
	<div class="container page-nosidebar site-container">
        <div id="loginbox" style="margin-top:15px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
            <div class="panel panel-info" >
                <div style="padding-top:25px" class="panel-body" >
                    <div style="display:none" id="login-alert" class="alert alert-danger col-sm-12"></div>
                	<div class="input-group full center">
                		<img class="avatar" src="<?php echo get_theme_file_uri('img/avatar_login.png');?>" />
                	</div>
                	<?php
                		$warning = array();
                		$email = isset($_GET['email'])? $_GET['email'] : '';
                	?>
                    <div class="row">
						<div class="col-xs-12">
						  	<div class="well">
						      	<form id="loginform" class="loginform"  method="POST" action="/login/" novalidate="novalidate">
						          	<div class="form-group">
						              	<input type="text" class="form-control required" id="login-username" name="user_login" value="<?php echo $email;?>" title="<?php _e('Enter you username','boxtheme');?>" placeholder="<?php _e('Username or Email','boxtheme');?>">
						          	</div>
						          	<div class="form-group">
						              	<input type="password" class="form-control required" id="password" required name="user_password" value=""  title="<?php _e('Enter your password','boxtheme');?>" placeholder="<?php _e('Password','boxtheme');?>">
						          	</div>
						          	<div id="loginErrorMsg" class="alert alert-error alert-warning hide"><?php _e('Wrong username og password','boxtheme');?></div>
						          	<div class="checkbox"><label><input type="checkbox" name="remember" id="remember"><?php _e('Remember login','boxtheme');?>  </label></div>
					           		<?php
				                        if( ! empty( $_GET['redirect'] ) ){
				                            echo '<input type ="hidden" name="redirect_url" value ="'.$_GET['redirect'].'" />';
				                        }
				                        wp_nonce_field( 'bx_login', 'nonce_login_field' );
			                    	?>
						          	<button type="submit" class="btn btn-success btn-block btn-submit"><?php _e('Log In','boxtheme');?></button>
						           	<div class="loginSignUpSeparator"><span class="textInSeparator" aria-label="or ">or </span></div>
						          	<div class="forgotLink"><a href="#" class=""><?php _e('Forgot password?','boxtheme');?></a></div>
						          	<div class="form-group">
						          		<a href="<?php echo box_get_static_link('signup');?>" class="btn btn-success btn-block btn-signup" >
			                                <?php _e('Sign Up','boxtheme');?>
			                            </a>
			                    	</div>
			                    	<div class="no-padding-bottom no-margin-bottom form-group "><div class="center"><?php bx_social_button_signup();?></div></div>
						      	</form>
						  	</div>
						</div>
					</div>
                </div> <!-- panel-body !-->
            </div>
        </div>
	</div>
</div>

<?php get_footer();?>
<script type="text/javascript">
    (function($){

        $("#loginform").submit(function(event){
            event.preventDefault();
            var form    = $(event.currentTarget);


            var send    = {};
            form.find( 'input' ).each( function() {
                var key     = $(this).attr('name');
                send[key]   = $(this).val();
            });

           $.ajax({
                emulateJSON: true,
                url : bx_global.ajax_url,
                data: {
                        action: 'bx_login',
                        request: send,
                },
                beforeSend  : function(event){
                	form.attr('disabled', 'disabled');
                	//$(".btn-submit").
                	form.find(".btn-submit").addClass("loading");
                },
                success : function(res){
                	form.find(".btn-submit").removeClass("loading");
                    if ( res.success ){
                        if( res.redirect_url ){
                            window.location.href = res.redirect_url;
                        } else {
                            window.location.href= bx_global.home_url;
                        }
                    } else {
                    	$("#loginErrorMsg").html(res.msg);
                    	$("#loginErrorMsg").removeClass("hide");
                    }
                }
            });
            return false;
        })
    })(jQuery);

</script>

<style type="text/css">
	#loginErrorMsg{
		padding: 10px 0;
		margin: 0;
		font-size: 12px;
		text-indent: 15px;
	}
	.form-control{
		-webkit-box-shadow: 0;
	    box-shadow: none !important;
	    -webkit-transition:none;
	    height: 39px;
	    border-radius: 3px;
	}
	.form-group:focus{
		box-shadow: none !important;
	}
	img.avatar{
		border: 1px solid #d4d9dc;
		width: 100px;
		margin: 0px 5px 0;
		border-radius: 50%;
	}
	.well{
		background:transparent;
		border: 0;
		box-shadow: none;
		margin-bottom: 0;
		padding-bottom: 0;
	}
	.loginSignUpSeparator {
	    border-top: 1px solid #cbd2d6;
	    position: relative;
	    margin: 25px 0 10px;
	    text-align: center;
	}
	.loginSignUpSeparator .textInSeparator {
	    background-color: #fff;
	    padding: 0 .5em;
	    position: relative;
	    color: #999;
	    top: -.7em;
	}
	.forgotLink {
	    margin: 0px 0 20px;
	    text-align: center;
	    border-bottom: 0;
	}
	.btn-success.btn-signup,
	.btn-success:hover.btn-signup{
		background-color: #ccc;
		border-color: #ccc;
		padding-top: 9px;
	}
	.loginform .btn{
		height: 39px;
		border-radius: 3px;
		font-weight: bold;
	}
</style>