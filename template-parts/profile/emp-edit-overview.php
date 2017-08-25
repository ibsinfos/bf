<?php
	global $user_ID;
	echo '<pre>';
	$user_data = get_userdata($user_ID );
	//var_dump($user_data);

	echo '</pre>';
?>
<div id="profile" class="col-md-12">
	<form id="update_profile" class="row-section">
		<div class="form-group ">
			<h2 class="col-md-12"> <?php _e('Overview','boxtheme');?></h2>
		</div>
	    <div class="form-group ">
	    	<div class="col-md-3 update-avatar">
	    		<?php
	    		$url = get_user_meta($user_ID,'avatar_url', true);

	    		if ( ! empty($url ) ){
	    			echo '<img class="avatar" src=" '.$url.'" />';
	    		}else {
	    			echo get_avatar($user_ID);
	    		}
	    		?>
	    	</div>
	      	<div class="col-md-9 col-sm-12">
	      		<div class="col-sm-12"><span class="btn btn-edit btn-edit-default"> Edit</span></div>
	            <div class="form-group row">
	        	   <h2 class="static visible-default" > <?php echo $user_data->display_name;?></h2>
	        	   <input class=" update hide form-control" type="text" value="<?php echo $user_data->display_name;?>" name="display_name">
	            </div>
	            <div class="form-group row">
	            	<h3 class=" static visible-default no-padding" ><?php echo $user_data->first_name;?></h3>
	            	<input type="text" class="update hide  form-control" value="<?php echo $user_data->first_name;?>" name="first_name">
	            	<input type="hidden" name ="ID" value="<?php echo $profile->ID;?>">
	            </div>
	            <div class="form-group row">
	            	<h3 class=" static visible-default no-padding" ><?php echo $user_data->last_name;?></h3>
	            	<input type="text" class="update hide  form-control" value="<?php echo $user_data->last_name;?>" name="last_name">

	            </div>
	            <div class="form-group row">
	            	<div class=" static visible-default">
	            	Test
	            	</div>
	            	<div>
	            		<textarea class="update hide form-control" name="post_content" cols="50" rows="6">Test</textarea>
	                </div>
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