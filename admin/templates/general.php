<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$pending_post = false;
$google_analytic = $coppyright = $tw_link = $fb_link = $gg_link = '' ;
$group_option = "general";
$option = BX_Option::get_instance();
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
if( isset($general->tw_link) ){
	$tw_link = $general->tw_link;
}
if( isset($general->fb_link) ){
	$fb_link = $general->fb_link;
}
if( isset($general->gg_link) ){
	$gg_link = $general->gg_link;
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
		<div class="col-md-3"><h3><?php _e('Google Analytics Script','boxtheme');?></h3></div> <div class="col-md-9"><textarea class="auto-save" multi="0" name="google_analytic"><?php echo stripslashes($google_analytic);?></textarea></div>
	</div>
	<div class="full">
		<div class="col-md-3"><h3><?php _e('Copyright text','boxtheme');?></h3></div> <div class="col-md-9"><textarea class="form-control auto-save" multi="0"  name="coppyright" ><?php echo stripslashes($coppyright);?> </textarea></div>
	</div>
	<div class="full">
		<div class="col-md-3"><h3><?php _e('Social Links','boxtheme');?></h3><span><?php _e('List social link in the footer','boxtheme');?></span></div>
		<div class="col-md-9">

			<div class="form-group row">
				<label for="example-text-input" class="col-md-4 col-form-label"><?php _e('Facebook link','boxtheme');?></label>
				<div class="col-md-12"><input class="form-control auto-save" type="text" value="<?php echo $fb_link;?>"  multi="0" name="fb_link" id="fb_link"></div>
			</div>

			<div class="form-group row">
				<label for="example-text-input" class="col-md-4 col-form-label"><?php _e('Twitter link','boxtheme');?></label>
				<div class="col-md-12"><input class="form-control auto-save" type="text" name="tw_link"  multi="0"  value="<?php echo $tw_link;?>" id="tw_link"></div>
			</div>

			<div class="form-group row">
				<label for="example-text-input" class="col-md-4 col-form-label"><?php _e('Google Plus link','boxtheme');?></label>
				<div class="col-md-12"><input class="form-control auto-save" type="text" name="gg_link" multi="0"  value="<?php echo $gg_link;?>" id="gg_link"></div>
			</div>

		</div>
	</div>
</div>
<?php
$group_option = "app_api";

$item1  = 'facebook';
$item2  = 'google';
$app_id = $app_secret = '';

$app_api = $option->get_group_option($group_option);
echo '<pre>';
var_dump($app_api);
echo '</pre>';

$facebook = (object) $app_api[$item1];
$google = (object) $app_api[$item2];


$app_id = isset($facebook->app_id) ? $facebook->app_id : '';


$app_secret = isset($facebook->app_secret) ? $facebook->app_secret : '';
$client_id = isset($google->client_id) ? $google->client_id : '';


?>
<h2><?php _e('Social Login','boxtheme');?></h2>
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
$item3  = 'gg_captcha';
$group_option = "app_api";
$app_api = $option->get_group_option($group_option);

$secret_key = $site_key  = '';
$enable_catcha = 0;
$gg_captcha = (object) $app_api[$item3];
if( !empty($gg_captcha->site_key) ){
	$site_key = $gg_captcha->site_key;
}
if( !empty($gg_captcha->secret_key) ){
	$secret_key = $gg_captcha->secret_key;
}
if( !empty($gg_captcha->enable) ){
	$enable_catcha = $gg_captcha->enable;
}

?>
<h2><?php _e('Google Captcha','boxtheme');?></h2>
<div class="sub-section" id="<?php echo $group_option;?>">
		<div class="sub-item" id="<?php echo $item3;?>">
	  	<div class="form-group row">
  			<div class="col-md-3"><h3><?php _e('Settings','boxtheme');?></h3></div>
  			<div class="col-md-9 form-group">
  				<div class="form-group">
			    	<label for="app_id"><?php _e('reCaptcha Site Key','boxtheme');?></label>
			    	<input type="text" value="<?php echo $site_key;?>" class="form-control auto-save"  name="site_key" id="site_key" aria-describedby="site_key" placeholder="<?php _e('reCaptcha Site Key','boxtheme');?>">
		    	</div>
		    	<div class="form-group">
		    		<label for="app_id"><?php _e('reCaptcha Secret Key','boxtheme');?></label>
		    		<input type="text" value="<?php echo $secret_key;?>" class="form-control auto-save"  name="secret_key" id="secret_key" aria-describedby="secret_key" placeholder="<?php _e('reCaptcha Secret Key','boxtheme');?>">
		    	</div>
		    	<div class="form-group">
		    		<div class="form-group toggle-line">  	<?php bx_swap_button($group_option, 'enable', $enable_catcha);?>   </div>
		    		<div class="form-group toggle-line"><span><?php _e('Enable this to help your website security more and safe. Add captcha code in login form and in register form - <a href="https://www.google.com/recaptcha/admin#list" target="_blank" rel="nofollow">get key</a>','boxtheme');?> </span> </div>
		    	</div>
		    </div>

	    </div>

	</div>
</div>