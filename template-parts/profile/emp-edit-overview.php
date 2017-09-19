<?php
	global $user_ID;

	$user_data = get_userdata($user_ID );
	echo '<pre>';
	var_dump($user_data->user_login);
	echo '</pre>';
	$country_id  = get_user_meta( $user_ID, 'location', true );
	var_dump($country_id);
	$country = get_term( $country_id, 'country' );

	$country_select = '';
	$countries = get_terms( 'country', array(
    	'hide_empty' => false)
   	);

   if ( ! empty( $countries ) || ! is_wp_error( $countries ) ){
      	$country_select.= '<select name="country" id="country" class="chosen-select form-control" data-placeholder="Choose a country" >';
      	foreach ( $countries as $country ) {
        	$country_select .= '<option value="'.$country->term_id .'" '. selected($country->term_id , $country_id, false) .' >' . $country->name . '</option>';
      	}
      	$country_select.= '</select>';
   } else {
   	$country_select == __('List country is empty','boxtheme');
   }
?>
<div id="profile" class="col-md-12 edit-profile-section edit-em-profile">
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
	      			<label>First name</label>: <span><?php echo $user_data->first_name;?></span>
	      		</div>
	      		<div class="form-group row">
	      			<label>Last name</label>: <span><?php echo $user_data->last_name;?></span>
	      		</div>
	      		<div class="form-group row">
	      			<label>Username</label>: <span><?php echo $user_data->user_login;?></span>
	      		</div>
	      		<div class="form-group row">
	      			<label>Email</label>: <span><?php echo $user_data->user_email;?></span>
	      		</div>
	      		<div class="form-group row">
	      			<label>Country</label>: <span><?php echo $country->name;?></span>
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