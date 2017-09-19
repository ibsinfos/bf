<?php
	global $user_ID;

	$user_data = get_userdata($user_ID );

	$country_id  = get_user_meta( $user_ID, 'location', true );
	$txt_country = 'Unset';
	$ucountry = get_term( $country_id, 'country' );

	if( !is_wp_error($ucountry ) ){
		$txt_country = $ucountry->name;
	}
	$country_select = '';
	$countries = get_terms( 'country', array(
    	'hide_empty' => false)
   	);

   if ( ! empty( $countries ) || ! is_wp_error( $countries ) ){
      	$country_select.= '<select name="country" id="country" class="chosen-select form-control" data-placeholder="Choose a country" >';
      	$country_select.= '<option value="">Select your country</option>';
      	foreach ( $countries as $country ) {
        	$country_select .= '<option value="'.$country->term_id .'" '. selected($country->term_id , $country_id, false) .' >' . $country->name . '</option>';
      	}
      	$country_select.= '</select>';
   } else {
   	$country_select == __('List country is empty','boxtheme');
   }
?>
<div id="profile" class="col-md-12 edit-profile-section edit-em-profile">
	<form id="update_profile" class="">
		<div class="form-group "><div class="col-md-3 text-center"> <h2><?php _e('Your Profile','boxtheme');?></h2></div></div>
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
	      		<div class="col-sm-12"><span class="btn btn-edit btn-edit-default btn-emp-edit"> Edit</span></div>
	      		<div class="full is-view">
		      		<div class="form-group ">
		      			<label>First name</label>: <span><?php echo $user_data->first_name;?></span>
		      		</div>
		      		<div class="form-group ">
		      			<label>Last name</label>: <span><?php echo $user_data->last_name;?></span>
		      		</div>
		      		<div class="form-group ">
		      			<label>Display name</label>: <span><?php echo $user_data->display_name ;?></span>
		      		</div>
		      		<div class="form-group ">
		      			<label>Username</label>: <span><?php echo $user_data->user_login;?></span>
		      		</div>
		      		<div class="form-group ">
		      			<label>Email</label>: <span><?php echo $user_data->user_email;?></span>
		      		</div>
		      		<div class="form-group ">
		      			<label>Country</label>: <span><?php echo $txt_country;?></span>
		      		</div>
		      	</div>
		      	<div class="is-edit full">
		      		<div class="form-group">
						<label for="example-text-input" class="col-3  col-form-label"><?php _e('First name','boxtheme');?></label>
						<input class="form-control" type="text" required name="first_name" value="<?php  echo $user_data->first_name;?>"  placeholder="<?php _e('First Name','boxtheme');?> " id="first-text-input">
					</div>
					<div class="form-group">
						<label for="example-text-input" class="col-3  col-form-label"><?php _e('Last name','boxtheme');?></label>
						<input class="form-control" type="text" required name="last_name" value="<?php  echo $user_data->last_name;?>"  placeholder="<?php _e('Last Name','boxtheme');?> " id="last-text-input">
					</div>
					<div class="form-group">
						<label for="example-text-input" class="col-3  col-form-label"><?php _e('Display name','boxtheme');?></label>
						<input class="form-control" type="text" required name="display_name" value="<?php  echo $user_data->display_name;?>"  placeholder="<?php _e('Display Name','boxtheme');?> " id="display-text-input">
					</div>

					<div class="form-group">
						<label for="example-text-input" class="col-3  col-form-label"><?php _e('Username','boxtheme');?></label>
						<input class="form-control" type="text" required name="user_login" value="<?php  echo $user_data->user_login;?>"  placeholder="<?php _e('Username','boxtheme');?> " id="userlogin-text-input">
					</div>
					<div class="form-group">
						<label for="example-text-input" class="col-3  col-form-label"><?php _e('Email','boxtheme');?></label>
						<input class="form-control" type="email" required name="user_email" value="<?php  echo $user_data->user_email;?>"  placeholder="<?php _e('Email','boxtheme');?> " id="email-text-input">
						<input type="hidden" name="is_emp" value="1">
					</div>
					<div class="form-group">
						<label for="example-text-input" class="col-3  col-form-label"><?php _e('Country:','boxtheme');?></label>
						<?php echo $country_select;?>
					</div>
					<div class="form-group">
				      	<div class="offset-sm-10 col-sm-12 pull-right align-right no-padding-right">
				        	<button type="submit" class="btn btn-primary update hide "> &nbsp; <?php _e('Save','boxtheme');?> &nbsp;</button>
				      	</div>
				    </div>
		      	</div>
	      	</div>

	    </div>
	</form>
</div> <!-- end left !-->