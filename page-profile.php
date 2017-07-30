<?php
/**
 *	Template Name: Profile user
 */
?>
<?php get_header(); ?>
<div class="full-width">
	<div class="container site-container">
		<div class="row site-content" id="content" >

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

			</div>
		</div>
	</div>
</div>
<div class="modal fade" tabindex="-1" role="dialog" id="modal_avatar">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
    	<form class="frm-avatar">
	      	<div class="modal-body">
	      		<div class="demo-wrap upload-demo"  id="full_avatar">
	      			<div align="center  upload-msg">
	      				<?php
	      				global $user_ID;
	      				$full_avatar_id = get_user_meta( $user_ID, 'full_avatar', true );
	      				?>
	      				<div class="img-container">
	              			<img src="<?php echo wp_get_attachment_url($full_avatar_id);?>" alt="Picture" id="thumbnail">
	              		</div>

					<br style="clear:both;">
						<input type="hidden" name="x1" value="" id="x1">
						<input type="hidden" name="y1" value="" id="y1">
						<input type="hidden" name="x2" value="" id="x2">
						<input type="hidden" name="y2" value="" id="y2">
						<input type="hidden" name="w" value="" id="w">
						<input type="hidden" name="h" value="" id="h">
					<button id="btn-upload-avatar">Upload file</button>
					</div>

	      		<!-- end test !-->
	      		</div>
	      		<div class="modal-footer">
		        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		        <button type="submit" class="btn btn-primary upload-result">Save changes</button>
		    	</div>
		    </div>
		</form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<div class="modal fade modal-portfolio" tabindex="-1" role="dialog" id="modal_add_portfolio">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
    	<form class="add-portfolio" id="modal_add_port">
	      	<div class="modal-body ">
	      		<div class="form-group">
			      	<center><h2> Add portfolio</h2></center>
			   	</div>
	      		<div class="form-group">
			      	<input type="text" class="form-control required" required  name="post_title" id="post_title" value="" placeholder="<?php _e("Set title",'boxtheme');?>" />
			      	<input type="hidden" class="form-control required"  name="post_content" value="" placeholder="<?php _e("Post content ",'boxtheme');?>" />
			      	<input type="hidden" class="form-control"  name="ID" id="port_id" value="" />

			   	</div>

			   	<div class="form-group">
			      	<div id="container_file">
					   	<div class="wrap-port-img" id="pickfiles"><i class="fa fa-upload" aria-hidden="true">Select an image</i></div>
					</div>
					<input type="text" class="form-control "   name="thumbnail_id" id="thumbnail_id" value="" />
			   	</div>

	      	</div>
	      	<div class="modal-footer">
		        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		        <button type="submit" class="btn btn-primary"><?php _e('Save','button');?></button>
		    </div>
	    </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script type="text/template" id="json_list_portfolio"><?php global $list_portfolio;   echo json_encode($list_portfolio); ?></script>
<script type="text/html" id="tmpl-add_portfolio">
	<div class="modal-body ">
  		<div class="form-group">
	      	<center><h2><?php _e('Add portfolio','boxtheme');?></h2></center>
	   	</div>
  		<div class="form-group">
	      	<input type="text" class="form-control "  name="post_title" value="{{{data.post_title}}}" placeholder="<?php _e("Set title",'boxtheme');?>" />
	      	<input type="hidden" class="form-control "  name="ID" value="{{{data.ID}}}" />
	      	<input type="hidden" class="form-control "  name="thumbnail_id" value="{{{data.thumbnail_id}}}" />

	      	<input type="hidden" class="form-control "  name="post_content" value="" placeholder="<?php _e("Set title",'boxtheme');?>" />
	   	</div>

	   	<div class="form-group">
	      	<div id="container_file1">
	      		<div class="wrap-port-img" id="pickfiles12"><img src="{{{data.feature_image}}}" /></div>
			</div>
	   	</div>

  	</div>
  	<div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary"><?php _e('Save','button');?></button>
    </div>
</script>
<script type="text/javascript">
(function($){


	$(document).ready(function () {
		$('#save_thumb').click(function() {
			var x1 = $('#x1').val();
			var y1 = $('#y1').val();
			var x2 = $('#x2').val();
			var y2 = $('#y2').val();
			var w = $('#w').val();
			var h = $('#h').val();
			if(x1=="" || y1=="" || x2=="" || y2=="" || w=="" || h==""){
				alert("You must make a selection first");
				return false;
			}else{
				return true;
			}
		});
	});

	$(window).load(function () {

	});
})(jQuery);
</script>

<?php get_footer();?>