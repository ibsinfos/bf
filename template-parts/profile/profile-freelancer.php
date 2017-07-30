<?php
	$profile_id 	= get_user_meta($user_ID,'profile_id', true);
	$profile 		= BX_Profile::get_instance()->convert($profile_id);

   	$txt_country = $slug = $skill_val = $country_select = $phone_number = $address ='';
   	$pcountry = get_the_terms( $profile_id, 'country' );
   	if( !empty($pcountry) ){
    	$txt_country =  $pcountry[0]->name;
      	$slug = $pcountry[0]->slug;
   	}

   	$countries = get_terms( 'country', array(
    	'hide_empty' => false)
   	);

   if ( ! empty( $countries ) && ! is_wp_error( $countries ) ){
      	$country_select.= '<select name="country" id="country" class="chosen-select form-control" >';
      	$country_select .= '<option value=""> Select your country </option>';
      	foreach ( $countries as $country ) {
        	$country_select .= '<option value="'.$country->slug.'" '. selected($country->slug, $slug, false) .' >' . $country->name . '</option>';
      	}
      	$country_select.= '</select>';
   }


   	$list_ids = array();
   	$skills = get_the_terms( $profile_id, 'skill' );

   	if ( $skills && ! is_wp_error( $skills ) ){

      	$draught_links = array();

      	foreach ( $skills as $term ) {
        	$draught_links[] = '<a href="'.get_term_link($term).'">'.$term->name.'</a>';
         	$list_ids[] = $term->term_id;
      	}
      	$skill_val = join( ", ", $draught_links );
   	}

   	$skills = get_terms( 'skill', array(
    	'hide_empty' => false));
   	$skill_list = '';

   	if ( ! empty( $skills ) && ! is_wp_error( $skills ) ){

    	$skill_list .=  '<select name="skill" multiple  id="skill" class="chosen-select form-control" >';
      	$skill_list .= '<option> Select skill</option>';

      	foreach ( $skills as $skill ) {
        	$selected = "";
         	if( in_array($skill->term_id, $list_ids) ){
            	$selected = ' selected ';
         	}
        	$skill_list .= '<option '.$selected.' value="'.$skill->slug.'" >' . $skill->name . '</option>';
      	}
      $skill_list.='</select>';
   }

   ?>
   <div class="full clear">
      <div class="video block">

         <span href="#" class="btn btn-edit btn-edit-video">Edit</span>
         <h3> Video </h3>
         <?php
         $video_id = get_post_meta($profile_id, 'video_id', true);

         if( !empty($video_id) ){ ?>
            <div class="video-container">
            <iframe width="635" height="315" src="https://www.youtube-nocookie.com/embed/<?php echo $video_id;?>?rel=0&amp;controls=0&amp;showinfo=0" frameborder="0" allowfullscreen></iframe>
            </div>

         <?php } ?>
         <form class="update-one-meta">
            <!-- <img src="<?php echo get_stylesheet_directory_uri().'/img/youtube.png';?>" /> -->
            <div class="form-group row">
               <label class="col-sm-3 col-form-label">Set youtube video ID</label>
               <div class="col-sm-9">
                  <input type="text" class="update form-control" name="video_id" value="<?php echo $video_id;?>" placeholder="<?php _e('Set your youtube video ID here','boxtheme');?>">
               </div>
            </div>
            <input type="hidden" name="ID" value="<?php echo $profile_id;?>" >

            <div class="form-group row">
                  <label class="col-sm-3 col-form-label">&nbsp;</label>
                  <div class="col-sm-9 align-right">
                     <button type="submit" class="btn btn-primary"> Save</button>
                  </div>
            </div>
         </form>
      </div>
   </div>
   <form id="update_profile_meta" class="update-profile row-section">
      <span class="btn btn-edit btn-edit-second"> Edit</span>
      <div class="form-group row">
      	<div class="col-sm-10">
      	<h3> <?php _e('Profile info','boxtheme');?></h3>
      	</div>
      </div>
      <div class="form-group row">
         <label for="country" class="col-sm-2 col-form-label"><?php _e('Hour rate','boxtheme');?></label>
         <div class="col-sm-10">
            <span class="visible-default"><?php echo  $profile->hour_rate ;?></span>
            <div class="invisible-default">
               <input type="text" class="update form-control " value="<?php echo $profile->hour_rate;?>" name="hour_rate">
            </div>
         </div>
         <input type="hidden" name="ID" value="<?php echo $profile_id;?>" >
      </div>
      <div class="form-group row">
         <label for="country" class="col-sm-2 col-form-label"><?php _e('Phone','boxtheme');?></label>
         <div class="col-sm-10">
            <span class="visible-default"><?php echo  $profile->phone_number ;?></span>
            <div class="invisible-default">
               <input type="text" class="update form-control " value="<?php echo $profile->phone_number;?>" name="phone_number">
            </div>
         </div>
         <input type="hidden" name="ID" value="<?php echo $profile_id;?>" >
      </div>
       <div class="form-group row">
         <label for="country" class="col-sm-2 col-form-label"><?php _e('Address','boxtheme');?></label>
         <div class="col-sm-10">
            <span class="visible-default"><?php echo $profile->address ;?></span>
            <div class="invisible-default">
                <input type="text" class="update form-control" value="<?php echo $profile->address;?>" name="address">
            </div>
         </div>
         <input type="hidden" name="ID" value="<?php echo $profile_id;?>" >
      </div>


      <div class="form-group row">
         <label for="country" class="col-sm-2 col-form-label"><?php _e('Country','boxtheme');?></label>
         <div class="col-sm-10">
            <span class="visible-default"><?php echo $txt_country;?></span>
            <div class="invisible-default">
               <?php echo $country_select;?>
            </div>
         </div>
      </div>
      <div class="form-group row">
         <label for="country" class="col-sm-2 col-form-label"><?php _e('Skill','boxtheme');?></label>
         <div class="col-sm-10">
            <span class="visible-default"><?php echo  $skill_val ;?></span>
            <div class="invisible-default">
               <?php
               echo $skill_list;
               ?>
            </div>
         </div>
         <input type="hidden" name="ID" value="<?php echo $profile_id;?>" >
      </div>

      <div class="form-group row invisible-default">
         <div class="offset-sm-10 col-sm-12 align-right">
           <button type="submit" class="btn btn-primary"> &nbsp; <?php _e('Save','boxtheme');?> &nbsp;</button>
         </div>
      </div>

   </form>
<div class="row">
	<div class="col-md-12 center frame-add-port">
		<button class="btn btn-show-portfolio-modal"><?php _e('+ Add portfolio','boxtheme');?></button>
	</div>
</div>
<div class="row-section" id="list_portfolio">
	<!-- portfolio !-->

	<?php
	global $user_ID, $list_portfolio;
	$args = array(
		'post_type' 	=> 'portfolio',
		'author' 		=> $user_ID,
	);
	$result =  new WP_Query($args);
	$list_portfolio = array();
	if( $result->have_posts() ){
		while ($result->have_posts()) {

			$result->the_post();
			$post->feature_image = get_the_post_thumbnail_url($post->ID, 'full');
			$post->thumbnail_id = get_post_thumbnail_id($post->ID);
			$list_portfolio[$post->ID] = $post;
			echo '<div class="col-md-6 port-item" id="'.$post->ID.'">';
				the_post_thumbnail('full' );
				echo '<div class="btns-act"><span class="btn-edit-port" class="'.$post->ID.'"> Edit</span>';
				echo '<span class="btn-del-port" class="'.$post->ID.'"> X</span></div>';
			echo '</div>';
		}
		wp_reset_query();
	}
	?>

</div>
<!-- end portfolio !-->