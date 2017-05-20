<?php
global $profile, $employer_type;
$profile_id = $profile->ID;
?>
<form id="update_profile_meta">
  	<div class="form-group row">
  		<div class="col-sm-10">
  		<h3> <?php _e('About your company','boxtheme');?></h3>
  		</div>
  	</div>

    <div class="form-group row">
      	<label for="inputexperiences"  class="col-sm-2 col-form-label"><?php _e('Website','boxtheme');?></label>
      	<div class="col-sm-10">
        	<input name="experiences" value="<?php echo $profile->experiences;?>" type="text" class="form-control" id="inputexperiences" placeholder="<?php _e('Your experiences','boxtheme'); ?>">
        	<input type="hidden" name ="ID" value="<?php echo $profile_id;?>">
      	</div>
    </div>
    <div class="form-group row">
      	<label for="hourrate"  class="col-sm-2 col-form-label"><?php _e('Size','boxtheme');?></label>
      	<div class="col-sm-10">
        	<input name="hour_rate" value="<?php echo $profile->hour_rate;?>" type="text" class="form-control" id="hour_rate" placeholder="<?php _e('Your hour rate','boxtheme'); ?>">
      	</div>
    </div>
    <div class="form-group row">
      <label for="country" class="col-sm-2 col-form-label"><?php _e('Headquarters','boxtheme');?></label>
      <div class="col-sm-10">
         <input name="hour_rate" value="<?php echo $profile->hour_rate;?>" type="text" class="form-control" id="hour_rate" placeholder="<?php _e('Your hour rate','boxtheme'); ?>">
      </div>
    </div>
     <div class="form-group row">
      <label for="country" class="col-sm-2 col-form-label"><?php _e('Industry','boxtheme');?></label>
      <div class="col-sm-10">
         <input name="hour_rate" value="<?php echo $profile->hour_rate;?>" type="text" class="form-control" id="hour_rate" placeholder="<?php _e('Your hour rate','boxtheme'); ?>">
      </div>
    </div>

    <div class="form-group row">
      <label for="country" class="col-sm-2 col-form-label"><?php _e('Type','boxtheme');?></label>
      <div class="col-sm-10">
          <select name="country" id="country" class="chosen-select form-control" >
            <option value="vi"> Việt Nam</option>
            <option value="arg"> Argentina</option>
            <option value="Germany"> Germany</option>
          </select>
      </div>
    </div>
    <div class="form-group row">
      <label for="country" class="col-sm-2 col-form-label"><?php _e('Country','boxtheme');?></label>
      <div class="col-sm-10">
        	<select name="country" id="country" class="chosen-select form-control" >
        		<option value="vi"> Việt Nam</option>
        		<option value="arg"> Argentina</option>
        		<option value="Germany"> Germany</option>
        	</select>
      </div>
    </div>

    <div class="form-group row">
      <div class="offset-sm-10 col-sm-12 align-right">
        <button type="submit" class="btn btn-primary"> &nbsp; <?php _e('Save','boxtheme');?> &nbsp;</button>
      </div>
    </div>
</form>
Hình ảnh upload ở đây