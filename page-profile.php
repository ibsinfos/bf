<?php
/**
 *	Template Name: Profile user
 */
?>
<?php get_header(); ?>
<div class="full-width">
	<div class="container site-container">
		<div class="row site-content" id="content" >
			<div id="profile" class="col-md-8">
				<?php
					global $current_user, $profile, $profile_id, $user_ID, $current_user;
					$role = bx_get_user_role();
					$profile_id = get_user_meta($user_ID,'profile_id', true);
					$current_user = wp_get_current_user();
					if( $profile_id ){

						$profile = BX_Profile::get_instance()->convert($profile_id);
						if( $role == FREELANCER ){
							get_template_part( 'template-parts/profile/profile', 'overview' );
							get_template_part( 'template-parts/profile/profile', 'freelancer' );
						} else {
							// global $employer_type;
							// $employer_type = get_user_meta($user_ID,EMPLOYER_TYPE, true);
							// get_template_part( 'template-parts/profile/profile', 'employer' );
						}
					}

				?>
			</div> <!-- end left !-->
			<div class="col-md-4">
				<?php get_sidebar('single');?>
				<?php get_sidebar('history');?>
			</div>

			</div>
		</div>
	</div>
</div>
<div class="modal fade" tabindex="-1" role="dialog" id="modal_avatar">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      	<div class="modal-body">
      		<div class="demo-wrap upload-demo">

                <div class="upload-msg">
                    Upload a file to start cropping
                </div>
                <div class="upload-demo-wrap">
                    <div id="upload-demo" class="croppie-container">    </div>
       			</div>
       			<a class="btn file-btn">
                    <span>Upload</span>
                    <input type="file" id="upload" value="Choose a file" accept="image/*">
                </a>
      		</div>
      	</div>
      	<div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	        <button type="button" class="btn btn-primary upload-result">Save changes</button>
	     </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<div class="modal fade" tabindex="-1" role="dialog" id="modal_add_portfolio">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      	<div class="modal-body">
      		<form>
	      		<div class="form-group">

			      	<input class="col-md-12"  type="text" class="form-control input-price"  name="post_content" value="" placeholder="<?php _e("Set title",'boxtheme');?>" />
			   	</div>

			   	<div class="form-group">
			      	<div class="col-md-12" id="container_file">
					   	<button class="btn " id="pickfiles"><i class="fa fa-upload" aria-hidden="true"></i> + Add A picture </button>
					</div>
			   	</div>





	      	</form>
      	</div>
      	<div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	        <button type="button" class="btn btn-primary upload-result">Save changes</button>
	     </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<?php get_footer();?>

