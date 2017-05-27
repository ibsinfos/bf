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
                <div class="panel-heading">
                    <div class="panel-title">Sign In</div>
                    <div style="float:right; font-size: 80%; position: relative; top:-10px"><a href="#">Forgot password?</a></div>
                </div>
                <div style="padding-top:30px" class="panel-body" >

                    <div style="display:none" id="login-alert" class="alert alert-danger col-sm-12"></div>

                    <form id="loginform" class="form-horizontal" role="form">

                        <div style="margin-bottom: 25px" class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                            <input id="login-username" type="text" class="form-control" name="user_login" value="" placeholder="username or email">
                        </div>
                        <div style="margin-bottom: 25px" class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                            <input id="login-password" type="password" class="form-control" name="user_password" placeholder="Password">
                        </div>
                        <div class="input-group">
                            <div class="checkbox">
                                <label><input id="login-remember" type="checkbox" name="remember" value="1"> Remember me </label>
                          </div>
                        </div>
                        <?php
	                        if( ! empty( $_GET['redirect'] ) ){
	                            echo '<input type ="hidden" name="redirect_url" value ="'.$_GET['redirect'].'" />';
	                        }

	                        wp_nonce_field( 'bx_login_action', 'nonce_login_field' );
	                    ?>
                        <div style="margin-top:10px" class="form-group">
                            <!-- Button -->
                            <div class="col-sm-12 controls">
                                <button type = "submit" id="btn-login" href="#" class="btn btn-success">Login  </button>
                                <a id="btn-fblogin" href="#" class="btn btn-primary">Login with Facebook</a>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12 control">
                                <div style="border-top: 1px solid#888; padding-top:15px; font-size:85%" >
                                    Don't have an account!
                                <a href="#" onClick="jQuery('#loginbox').hide(); jQuery('#signupbox').show()">
                                    Sign Up Here
                                </a>
                                </div>
                            </div>
                        </div>
                    </form>
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
                        action: 'bx_signin',
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