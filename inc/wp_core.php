<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
add_filter( 'get_site_icon_url', 'box_set_favicon', 10 ,3 );
function box_set_favicon( $url, $size, $blog_id ) {
	if( empty($url) )
		$url = get_stylesheet_directory_uri().'/ico.png';
	return $url;
}
add_action( 'wp_head', 'box_add_meta_head', 11 );
function box_add_meta_head(){

	global $general;
	$general = (object) BX_Option::get_instance()->get_group_option('general');

	if( !empty( $general->google_analytic ) ){
		echo stripslashes($general->google_analytic);
	}
}