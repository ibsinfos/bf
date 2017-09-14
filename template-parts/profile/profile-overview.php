<?php
	global $user_ID, $current_user, $profile;
	$professional_title = $profile->professional_title;
	$url = get_user_meta($user_ID,'avatar_url', true);
?>
<div id="profile" class="col-md-12 edit-profile-section overview-section">
	<form id="update_profile" class="row-section">
		<div class="form-group ">
			<h2 class="col-md-12"> <?php _e('Overview','boxtheme');?></h2>
		</div>
	    <div class="form-group ">
	    	<div class="col-md-3 update-avatar">
	    		<?php
	    		if ( ! empty($url ) ){ echo '<img class="avatar" src=" '.$url.'" />'; } else {
	    			echo get_avatar($user_ID);
	    		}
	    		?>
	    	</div>
	      	<div class="col-md-9 col-sm-12">
	      		<div class="col-sm-12"><span class="btn btn-edit btn-edit-default"> <i class="fa fa-pencil-square-o" aria-hidden="true"></i>Edit</span></div>
	            <div class="form-group row">
	        	   <h2 class="static visible-default" > <?php echo $current_user->display_name;?></h2>
	        	   <input class=" update hide form-control" type="text" value="<?php echo $current_user->display_name;?>" name="post_title">
	            </div>
	            <div class="form-group row">
	            	<h3 class=" static visible-default no-padding primary-color" ><?php echo !empty ($professional_title) ? $professional_title : __('Empty professinal title','boxtheme');?></h3>
	            	<input type="text" class="update hide  form-control" value="<?php echo $professional_title;?>" name="professional_title">
	            	<input type="hidden" name ="ID" value="<?php echo $profile->ID;?>">
	            </div>
	            <div class="form-group row">
	            	<div class=" static visible-default">  <?php echo $profile->post_content;?>         	</div>
	            	<div><textarea class="update hide form-control" name="post_content" cols="50" rows="6"><?php echo $profile->post_content;?></textarea></div>
	            </div>
	      	</div>
	      	<div class="form-group row">
		      	<div class="offset-sm-10 col-sm-12 align-right">
		        	<button type="submit" class="btn btn-primary update hide"> &nbsp; <?php _e('Save','boxtheme');?> &nbsp;</button>
		      	</div>
		    </div>
	    </div>
	</form>
</div> <!-- end left !-->