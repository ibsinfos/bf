<?php
require get_parent_theme_file_path( '/inc/define.php' );
require get_parent_theme_file_path( '/inc/class-bx-install.php' );
require get_parent_theme_file_path( '/inc/plugable.php' );
require get_parent_theme_file_path( '/inc/themes.php' );
require get_parent_theme_file_path( '/inc/init_hook.php' );
require get_parent_theme_file_path( '/inc/class_option.php' );

require get_parent_theme_file_path( '/inc/class_user.php' );
require get_parent_theme_file_path( '/inc/class_post.php' );

require get_parent_theme_file_path( '/inc/payment/requires.php' );
require get_parent_theme_file_path( '/inc/class_credit.php' );

require get_parent_theme_file_path( '/inc/class_message.php' );
require get_parent_theme_file_path( '/inc/class_project.php' );
require get_parent_theme_file_path( '/inc/class_profile.php' );


require get_parent_theme_file_path( '/inc/class_bid.php' );
require get_parent_theme_file_path( '/inc/class-wp-ajax.php' );

/**
 * Implement the Custom Header feature.
 */
//require get_parent_theme_file_path( '/inc/custom-header.php' );

/**
 * Custom template tags for this theme.
 */
//require get_parent_theme_file_path( '/inc/template-tags.php' );

/**
 * Additional features to allow styling of the templates.
 */
//require get_parent_theme_file_path( '/inc/template-functions.php' );

/**
 * Customizer additions.
 */
///require get_parent_theme_file_path( '/inc/customizer.php' );

add_filter('getimagesize_mimes_to_exts','bx_allow_upload_extend');
function bx_allow_upload_extend($args){

	$add = array('doc|docx' => 'application/msword' ,
		'pdf' 			=> 'application/pdf',
		'zip' 			=> 'multipart/x-zip',
		'mp3|m4a|m4b'  => 'audio/mpeg',
		'wav'          => 'audio/wav',
		'wma'          => 'audio/x-ms-wma',
		'wmv'          => 'video/x-ms-wmv',
		'wmx'          => 'video/x-ms-wmx',
		'wm'           => 'video/x-ms-wm',
		'avi'          => 'video/avi',
		'divx'         => 'video/divx',
		'flv'          => 'video/x-flv',
		'mov|qt'       => 'video/quicktime',
		'mpeg|mpg|mpe' => 'video/mpeg',
		'mp4|m4v'      => 'video/mp4'
		);
	return array_merge($args, $add);
}