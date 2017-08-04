<?php
	if ( ! defined( 'ABSPATH' ) ) {
		exit; // Exit if accessed directly.
	}
	require_once( get_parent_theme_file_path().'/inc/social/facebook.php');
	require_once( get_parent_theme_file_path().'/inc/social/google.php');


function bx_social_button_signup(){ ?>
    <p class="hidden-xs text-center ng-scope" >
        <label> You can also login with</label>
            <?php btn_fb_login() ;?>
            <?php btn_google_login();?>
    </p>
<?php } ?>