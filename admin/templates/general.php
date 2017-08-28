<?php
$group_option = "general";
$option = BX_Option::get_instance();
$pending_post = false;
$google_analytic = $coppyright = '';
$general = (object)$option->get_group_option($group_option);

if( isset($general->pending_post) ){
	$pending_post = $general->pending_post;
}
if( isset($general->google_analytic) ){
	$google_analytic = $general->google_analytic;
}
if( isset($general->coppyright) ){
	$coppyright = $general->coppyright;
}


?>
<h2><?php _e('Main options','boxtheme');?></h2>
<div class="sub-section row" id="<?php echo $group_option;?>">
	<div class="full sub-item" id="pending_post" >
		<div class="col-md-3">
		<h3><?php _e('Pending jobs','boxtheme');?></h3>
		</div> <div class="col-md-9"><?php bx_swap_button($group_option,'pending_post', $pending_post, $multipe = false);?>  <br /><span><?php _e('if enable this option, all job only appearances in the site after admin manually approve it.','boxtheme');?></span></div>

	</div>
	<div class="full" id="google_analytic">
		<div class="col-md-3"><h3><?php _e('Google Analytics Script','boxtheme');?></h3></div> <div class="col-md-9"><textarea class="auto-save" multi="0" name="google_analytic"><?php echo $google_analytic;?></textarea></div>
	</div>
	<div class="full">
		<div class="col-md-3"><h3><?php _e('Copy right','boxtheme');?></h3></div> <div class="col-md-9"><input type="text" class="form-control auto-save" multi="0"  name="coppyright" value="<?php echo $coppyright;?>" /></div>
	</div>
	<div class="full">
		<div class="col-md-3"><h3><?php _e('Social Links','boxtheme');?></h3><span><?php _e('List social link in the footer','boxtheme');?></span></div>
		<div class="col-md-9">

			<div class="form-group row">
				<label for="example-text-input" class="col-md-4 col-form-label"><?php _e('Facebook link','boxtheme');?></label>
				<div class="col-md-12"><input class="form-control" type="text" value="http://fb.com/boxthemes/" id="example-text-input"></div>
			</div>

			<div class="form-group row">
				<label for="example-text-input" class="col-md-4 col-form-label"><?php _e('Twitter link','boxtheme');?></label>
				<div class="col-md-12"><input class="form-control" type="text" value="http://tw.com/boxthemes/" id="example-text-input"></div>
			</div>

			<div class="form-group row">
				<label for="example-text-input" class="col-md-4 col-form-label"><?php _e('Google Plus link','boxtheme');?></label>
				<div class="col-md-12"><input class="form-control" type="text" value="http://plus.google.com/boxthemes/" id="example-text-input"></div>
			</div>

		</div>
	</div>
</div>
<?php
$group_option = "social_api";
$option = BX_Option::get_instance();
$social_api = $option->get_group_option($group_option);
$item1  = 'facebook';
$item2  = 'google';
$app_id = $app_secret = '';

$facebook = (object) $social_api[$item1];
$google = (object) $social_api[$item2];
$app_id = isset($facebook->app_id) ? $facebook->app_id : '';

$app_secret = isset($facebook->app_secret) ? $facebook->app_secret : '';
$client_id = isset($google->client_id) ? $google->client_id : '';


?>
<h2>Social Login</h2>
<div class="sub-section" id="<?php echo $group_option;?>">
		<div class="sub-item" id="<?php echo $item1;?>">
	  	<div class="form-group row">
  			<div class="col-md-3"><h3> Facebook Setting </h3></div>
  			<div class="col-md-9 form-group">
		    	<label for="app_id">APP ID</label>
		    	<input type="text" value="<?php echo $app_id;?>" class="form-control auto-save" name="app_id" id="app_id" aria-describedby="app_id" placeholder="Enter APP ID">
		    	<div class="form-group toggle-line">  	<?php bx_swap_button($group_option,$item1, $facebook->enable);?>   </div>
		    </div>
	    </div>

	</div>
	<div class="sub-item" id="google">
	  	<div class="form-group row">
	  		<div class="col-md-3"><h3> Google Setting </h3></div>
	  		<div class="col-md-9 ">
		    	<label for="client_id">Client ID</label>
		    	<input type="text" class="form-control auto-save" value="<?php echo $client_id;?>" name="client_id" id="client_id" aria-describedby="client_id" placeholder="Client ID">
		    	<div class="form-group toggle-line"><?php bx_swap_button($group_option,$item2, $google->enable);?></div>
	    	</div>
	  	</div>
	</div>
</div>
<?php
$group_option = "social_api";
$option = BX_Option::get_instance();
$social_api = $option->get_group_option($group_option);
$item1  = 'facebook';
$item2  = 'google';
$app_id = $app_secret = '';

$facebook = (object) $social_api[$item1];
$google = (object) $social_api[$item2];
$app_id = isset($facebook->app_id) ? $facebook->app_id : '';

$app_secret = isset($facebook->app_secret) ? $facebook->app_secret : '';
$client_id = isset($google->client_id) ? $google->client_id : '';


?>
<h2>Google Captcha</h2>
<div class="sub-section" id="<?php echo $group_option;?>">
		<div class="sub-item" id="<?php echo $item1;?>">
	  	<div class="form-group row">
  			<div class="col-md-3"><h3>Settings</h3></div>
  			<div class="col-md-9 form-group">
		    	<label for="app_id">APP ID</label>
		    	<input type="text" value="<?php echo $app_id;?>" class="form-control auto-save" name="app_id" id="app_id" aria-describedby="app_id" placeholder="Enter APP ID">
		    	<div class="form-group toggle-line">  	<?php bx_swap_button($group_option,$item1, $facebook->enable);?>   </div>
		    	<div class="form-group toggle-line"><span> Enable this to help your website security more and safe. Add captcha code in login form and in register form. </span> </div>

		    </div>
	    </div>

	</div>

</div>