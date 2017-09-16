<?php
$p_id = isset($_GET['p_id']) ? $_GET['p_id'] : 0;
$project = array();
$lbl_btn = __('Post Project Now','boxtheme');
$skills = $cat_ids =$skill_ids = array();

?>
<form id="submit_project" class="frm-submit-project">

	<?php
	$id_field =  '<input type="hidden" value="0" name="ID" />'; // check insert or renew
	if($p_id){
		global $user_ID;
		$project = get_post($p_id);

		if( $project && $user_ID == $project->post_author ){ // only author can renew or view detail of this project

			$project = BX_Project::get_instance()->convert($project);
			$lbl_btn = __('Renew Your Project','boxtheme');


			$skills = get_the_terms( $project, 'skill' );

			if ( ! empty( $skills ) && ! is_wp_error( $skills ) ){
				foreach ( $skills as $skill ) {
				  	$skill_ids[] = $skill->term_id;
				}
			}

			$cats = get_the_terms( $project, 'project_cat' );

			if ( ! empty( $cats ) && ! is_wp_error( $cats ) ){
				foreach ( $cats as $cat ) {
				  	$cat_ids[] = $cat->term_id;
				}

			}
			$id_field = '<input type="hidden" value="'.$p_id.'" name="ID" />';
		}
	}
	echo $id_field;


	$symbol = box_get_currency_symbol( );
	?>
	<div class="form-group ">
	 	<h1 class="page-title"><?php if( ! $p_id){ the_title();} else { _e('Renew project','boxtheme'); } ?></h1>
	</div>
	<div class="form-group">
		<label for="example-text-input" class="col-3  col-form-label"><?php _e('PROJECT NAME:','boxtheme');?></label>
		<input class="form-control required" type="text" required name="post_title" value="<?php echo !empty($project) ? $project->post_title:'';?>"  placeholder="<?php _e('Ex: Build a website','boxtheme');?> " id="example-text-input">
	</div>

	<div class="form-group ">
	 	<label for="example-text-input" class="col-3  col-form-label"><?php printf(__('What budget do you have in mind(%s)?','boxtheme'), '<small>'.$symbol.'</small>');?></label>
	 	<input class="form-control" type="number" step="any" value="<?php echo !empty($project) ? $project->{BUDGET}:'';?>" required name="<?php echo BUDGET;?>"   placeholder="<?php printf(__('Set your budget here(%s)','boxtheme'), $symbol);?> " id="example-text-input">

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
						$selected = '';
						if( in_array($cat->term_id, $cat_ids) ){
							$selected = 'selected';
						}
				   		echo '<option '.$selected.' value="' . $cat->term_id . '">' . $cat->name . '</option>';
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
	       if ( ! empty( $skills ) && ! is_wp_error( $skills ) ) {
	            foreach ( $skills as $skill ) {
	            	$selected = '';
						if( in_array($skill->term_id, $skill_ids) ){
							$selected = 'selected';
						}
	              	echo '<option '.$selected.' value="' . $skill->name . '">' . $skill->name . '</option>';
	            }
	        }
	       ?>
	    </select>
	</div>

	<div class="form-group ">
	 	<label for="example-text-input" class="col-3  col-form-label"><?php _e('DESCRIBE YOUR PROJECT','boxtheme');?></label>
	 	<textarea name="post_content" class="form-control required no-radius" required rows="6" cols="43" placeholder="<?php _e('Describe your project here...','boxtheme');?>"><?php echo !empty($project) ? $project->post_content :'';?></textarea>
	</div>
	<div class="form-group ">
	 	<div id="fileupload-container" class="file-uploader-area">
		    <span class="btn btn-plain btn-file-uploader border-color">
		      	<span class="fl-icon-plus"></span>
		      	<input type="hidden" class="nonce_upload_field" name="nonce_upload_field" value="<?php echo wp_create_nonce( 'box_upload_file' ); ?>" />
		      	<span id="file-upload-button-text " class="text-color"><i class="fa fa-plus text-color" aria-hidden="true"></i> <?php _e('Upload Files','boxtheme');?></span>
		      	<input type="file" name="upload[]" id="sp-upload" multiple="" class="fileupload-input">
		      	<input type="hidden" name="fileset" class="upload-fileset">
		  	</span>
	  		<p class="file-upload-text txt-term"><?php _e('Drag drop any images or documents that might be helpful in explaining your project brief here','boxtheme');?></p>

	 	</div>
	 	<ul class="list-attach"></ul>
	 	<div id="fileupload-error" class="alert alert-error upload-alert fileupload-error hide"><?php _e('You have uploaded this file before','boxtheme');?></div>

	</div>
	<?php wp_nonce_field( 'sync_project', 'nonce_insert_project' ); ?>
	<div class="form-group row">

	 	<div class="col-md-7">
	    	<span class="txt-term"><?php _e("By clicking 'Post Project Now', you are indicating that you have read and agree to the Terms & Conditions and Privacy Policy","boxtheme");?></span>
	    </div>
	 	<div class="col-md-5 align-right pull-right">
	    	<button type="submit " class="btn btn-action no-radius"><?php echo $lbl_btn;?></button>
	 	</div>
	</div>
</form>