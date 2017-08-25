 <?php
/**
 * Template Name: Page Jobseeker Signup
*/
?>
<?php get_header(); ?>

    <div class="container">
        <div class="row m-lg-top m-xlg-bottom">
            <div class="col-md-12 m-lg-bottom page-auth pb50">
            	<?php if( ! is_user_logged_in() ) { ?>
	               	<form id="signup" class="frm-signup">
						<div class="row" id="heading_signup">
						    <div class="col-md-12 align-center">
						        <h1>SIGN UP</h1>
						    <h3><?php _e('Create a freelancer account in seconds and bid a job right now','boxtheme');?></h3>
						    </div>
						</div>
						<div class="row">
						    <div class="form-group col-md-6">
						        <input class="form-control" type="text" name="first_name"  placeholder="<?php _e('First name','boxtheme');?> " id="example-text-input">
						    </div>
						    <div class="col-md-6 form-group">
						        <input class="form-control" type="text" name="last_name"   placeholder="<?php _e('Last name','boxtheme');?> " id="example-text-input">
						    </div>
						</div>

						<div class="row">
						    <div class="form-group col-md-12">
						        <input class="form-control"  name="user_login" required   placeholder="<?php _e('User name','boxtheme');?> " type="text"  >
						    </div>
						</div>
						<div class="row">
						    <div class="form-group col-md-12">
						        <input class="form-control"  name="user_email" required  type="email" placeholder="<?php _e('Your email','boxtheme');?> " >
						    </div>
						</div>
						<div class="row">
						    <div class="form-group col-md-12">
						        <input class="form-control"  name="user_pass" required  type="password" placeholder="<?php _e('Password','boxtheme');?> ">
						    </div>
						</div>
						<div id="loginErrorMsg" class="alert alert-error alert-warning hide"></div>
						<?php signup_nonce_fields(); ?>
						<input type="hidden" name="role" value="<?php echo FREELANCER;?>">

						<div class="form-group row">
						<div class="col-md-12">
						    <button class="btn btn-xlarge btn-action" type="submit">SIGN UP</button>
						</div>

						</div>
					</form>
				<?php } else { ?>
					<?php _e(' This page only available for visitor','boxtheme');?>
				<?php } ?>
            </div>
        </div>
    </div>
<?php get_footer(); ?>