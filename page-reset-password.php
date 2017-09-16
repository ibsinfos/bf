<?php
/**
 *Template Name: Default template
 */
?>
<?php get_header(); ?>
<div class="full-width">
	<div class="container site-container">
		<div class="site-content" id="content" >
			<div class="col-md-12 ">
				 <h1 class="margin-b20 margin-t30 span7">Choose your new password</h1>

			    <div id="error-text" class="alert alert-error span7" style="display: none"></div>
			    <form class="well span7" id="reset_password_form" method="POST">

			        <input type="hidden" id="token" name="token" value="13475da03bff16a06c78bc3bfa9005354fbde2b329eb6cb38a229db79c74adee">
			        <input type="hidden" id="userid" name="userid" value="2500645">
			        <input type="hidden" id="username" name="username" value="danhoat">

			        <div class="control-group">
			            <label for="new_password">New Password:</label>
			            <div>
			                <input type="password" name="new_password" id="new_password">
			                <i class="icon-16-green-tick" style="display:none"></i>
			                <span class="help-inline small" style="display:block"></span>
			                <span id="passwd_hint_id" class="hint" style="display:block"></span>
			            </div>
			        </div>

			        <div class="control-group">
			            <label for="confirm_password">Confirm Password:</label>
			            <div>
			                <input type="password" name="confirm_password" id="confirm_password">
			                <i class="icon-16-green-tick" style="display:none"></i>
			                <span class="help-inline small" style="display:block"></span>

			            </div>
			        </div>
			        <div class="control-group ">
			            <div id="submit-controls">
			                <input type="submit" id="submit-btn" class="btn btn-large btn-info" value="Submit">
			                <img id="ajax-loader" alt="Freelancer Loading..." src="https://cdn3.f-cdn.com/img/ajax-loader.gif?v=62d3d0c60d4c33ef23dcefb9bc63e3a2&amp;m=6" style="display: none;">
			            </div>
			        </div>
			    </form>
			</div>

		</div>
	</div>
</div>
<?php get_footer();?>