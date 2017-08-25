<?php
add_filter( 'get_site_icon_url', 'box_set_favicon', 10 ,3 );
function box_set_favicon( $url, $size, $blog_id ) {
	if( empty($url) )
		$url = get_stylesheet_directory_uri().'/ico.png';
	return $url;
}
