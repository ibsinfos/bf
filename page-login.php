<?php
/**
 *	Template Name: Page Login
 */
?>
<?php get_header(); ?>
<div class="row full-width">
	<div class="container page-nosidebar">
        <div id="loginbox" style="margin-top:50px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
            <div class="panel panel-info" >
                <div style="padding-top:30px" class="panel-body" >
                	<label class="full"><center>LOGIN</center></label>
                    <div style="display:none" id="login-alert" class="alert alert-danger col-sm-12"></div>


                	<div class="input-group full center">
                		<img class="avatar" src="<?php echo get_theme_file_uri('img/avatar_login.png');?>" />
                	</div>


                    <div class="row">
						<div class="col-xs-12">
						  	<div class="well">
						      	<form id="loginform" class="loginform"  method="POST" action="/login/" novalidate="novalidate">
						          	<div class="form-group">
						              	<input type="text" class="form-control" id="login-username" name="user_login" value="" required="" title="Please enter you username" placeholder="Username or Email">
						              	<span class="help-block"></span>
						          	</div>
						          	<div class="form-group">
						              	<input type="password" class="form-control" id="password" name="user_password" value="" required="" title="Please enter your password" placeholder="Your password">
						              	<span class="help-block"></span>
						          	</div>
						          	<div id="loginErrorMsg" class="alert alert-error hide">Wrong username og password</div>
						          	<div class="checkbox">
						              <label>
						                  <input type="checkbox" name="remember" id="remember"> Remember login
						              </label>
						              <p class="help-block"></p>
						          	</div>
						           <?php
				                        if( ! empty( $_GET['redirect'] ) ){
				                            echo '<input type ="hidden" name="redirect_url" value ="'.$_GET['redirect'].'" />';
				                        }
				                        wp_nonce_field( 'bx_login', 'nonce_login_field' );
				                    ?>

						          <button type="submit" class="btn btn-success btn-block">Login</button>
						           		<div class="loginSignUpSeparator"><span class="textInSeparator" aria-label="or ">or </span></div>
						          <div class="forgotLink"><a href="/authflow/password-recovery/?country.x=AU&amp;locale.x=en_AU" target="_blank" class="scTrack:unifiedlogin-click-forgot-password">Having trouble logging in?</a></div>
						          	<div class="form-group">
						          		<a href="#" class="btn btn-success btn-block btn-signup" onClick="jQuery('#loginbox').hide(); jQuery('#signupbox').show()">
			                                Sign Up
			                            	</a>
			                    	</div>
						      </form>

						  </div>

						</div>
					</div>

                </div> <!-- panel-body !-->
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
                    console.log('bat dau');
                },
                success : function(res){
                    if ( res.success ){
                        if( res.redirect_url ){
                            window.location.href = res.redirect_url;
                        } else {
                            window.location.href= bx_global.home_url;
                            //window.location.reload(true);
                        }
                    } else {
                        console.log('Can not logout');
                    }
                }
            });
            return false;
        })
    })(jQuery);

</script>

<style type="text/css">
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
		margin: 13px 5px 0;
	}
	.well{
		background:transparent;
		border: 0;
		box-shadow: none;
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
	}
	.loginform .btn{
		height: 39px;
		border-radius: 3px;
	}
</style>