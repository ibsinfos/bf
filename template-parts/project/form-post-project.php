<form id="submit_project" class="frm-submit-project">
	<div class="form-group ">
	 	<h1 class="page-title"><?php the_title(); ?></h1>
	</div>
	<div class="form-group">
		<label for="example-text-input" class="col-3  col-form-label"><?php _e('PROJECT NAME:','boxtheme');?></label>
		<input class="form-control required" type="text" required name="post_title"  placeholder="<?php _e('Ex: Build a website','boxtheme');?> " id="example-text-input">
	</div>

	<div class="form-group ">
	 	<label for="example-text-input" class="col-3  col-form-label"><?php _e('What budget do you have in mind?','boxtheme');?></label>
	 	<input class="form-control" type="number" required name="<?php echo BUDGET;?>"   placeholder="<?php _e('Set your budget here','boxtheme');?> " id="example-text-input">

	</div>
	<div class="form-group ">

	 	<label for="example-text-input" class="col-form-label"><?php _e('What type of work do you require?','boxtheme');?></label>
	 	<select class="form-control required chosen-select" multiple name="project_cat" required data-placeholder="<?php _e('Select a category of work (optional)','boxtheme');?> ">
		    <?php
				$pcats = get_terms( array(
					'taxonomy' => 'project_cat',
					'hide_empty' => false,
					)
				);
				if ( ! empty( $pcats ) && ! is_wp_error( $pcats ) ){
					foreach ( $pcats as $cat ) {
				   		echo '<option value="' . $cat->term_id . '">' . $cat->name . '</option>';
					}
 				}
		    ?>
	 	</select>
	</div>

	<div class="form-group ">
	    <label for="example-text-input" class="col-form-label"><?php _e('WHAT SKILLS ARE REQUIRED?','boxtheme');?></label>
	    <select class="form-control required chosen-select" name="skill" required  multiple data-placeholder="<?php _e('What skills are required?','boxtheme');?> ">
	       	<?php
	       	$skills = get_terms(
	       		array(
	           		'taxonomy' => 'skill',
	           		'hide_empty' => false,
	          	)
	       	);
	       if ( ! empty( $skills ) && ! is_wp_error( $skills ) ){
	            foreach ( $skills as $skill ) {
	              echo '<option value="' . $skill->name . '">' . $skill->name . '</option>';
	            }
	        }
	       ?>
	    </select>
	</div>

	<div class="form-group ">
	 	<label for="example-text-input" class="col-3  col-form-label"><?php _e('DESCRIBE YOUR PROJECT','boxtheme');?></label>
	 	<textarea name="post_content" class="form-control required no-radius" required rows="6" cols="43" placeholder="<?php _e('Describe your project here...','boxtheme');?>"></textarea>
	</div>
	<div class="form-group ">
	 	<div id="fileupload-container" class="file-uploader-area">
		    <span class="btn btn-plain btn-file-uploader">
		      	<span class="fl-icon-plus"></span>
		      	<span id="file-upload-button-text">+ <?php _e('Upload Files','boxtheme');?></span>
		      	<input type="file" name="upload[]" id="sp-upload" multiple="" class="fileupload-input">
		      	<input type="hidden" name="fileset" class="upload-fileset">
		  	</span>
	  		<p class="file-upload-text txt-term">Drag &amp; drop any images or documents that might be helpful in explaining your project brief here</p>
	 	</div>

	 	<div id="fileupload-error" class="alert alert-error upload-alert fileupload-error hide">You have uploaded this file before</div>

	 	<table class="file-uploader-table default-table table-alt-row fileupload-item-list" role="presentation">
	     	<tbody class="files"></tbody>
	 	</table>
	</div>
	<div class="form-group row">

	 	<div class="col-md-7">
	    	<span class="txt-term">By clicking 'Post Project Now', you are indicating that you have read and agree to the Terms & Conditions and Privacy Policy</span>
	    </div>
	 	<div class="col-md-5 align-right pull-right">
	    	<button type="submit " class="btn btn-action no-radius"><?php _e('Post Project Now','boxtheme');?></button>
	 	</div>
	</div>
</form>
