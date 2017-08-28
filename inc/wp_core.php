<?php
add_filter( 'get_site_icon_url', 'box_set_favicon', 10 ,3 );
function box_set_favicon( $url, $size, $blog_id ) {
	if( empty($url) )
		$url = get_stylesheet_directory_uri().'/ico.png';
	return $url;
}
add_action( 'wp_head', 'box_add_meta_head', 11 );
function box_add_meta_head(){
	global $general;
	$group_option = "general";
	$option = BX_Option::get_instance();
	$general = (object)$option->get_group_option($group_option);

	if( isset($general->google_analytic) ){
		echo $general->google_analytic;
	}
}