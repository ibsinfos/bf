<?php
function self_customizer_section($wp_customize) {
    $wp_customize->add_section( 'section_name' , array(
        'title'       => __( 'Home page', 'my_theme' ),
        'description' => 'Select banner image',
    ));

    /* LOGO */
    $wp_customize->add_setting( 'main_img', array(
        'default' => get_template_directory_uri().'/img/banner.jpg'
    ));

    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'main_img', array(
        'label'    => __( 'Main banner', 'my_theme' ),
        'section'  => 'section_name',
        'settings' => 'main_img',
    )));


}

add_action('customize_register', 'self_customizer_section');

add_action('customize_register', 'box_customizer_footer');
function box_customizer_footer($wp_customize){
	$wp_customize->add_section( 'footer_setup', array(
			'title' => __( 'Footer setup' ),
			'priority' => 120,
			'description' => __( 'Setup for the footer section.' ),
			//'active_callback' => 'box_get_menu',
		) );



	$menus = wp_get_nav_menus();
	$result = array();
	if( !is_wp_error($menus ) && !empty($menus) ){
		foreach ($menus as $key => $menu) {

			$result[$menu->slug] = $menu->name;
		}
	}


	$wp_customize->add_setting( 'footer_menu[first_title]', array(
			'type'       => 'option',
			'capability' => 'manage_options',
		) );
	$wp_customize->add_control( 'footer_menu[first_title]', array(
		'label' => __( 'Set title Menu 1' ),
		'section' => 'footer_setup',
		'type' => 'textarea',
		'allow_addition' => true,
	) );

	$wp_customize->add_setting( 'footer_menu[first]', array(
			'type'       => 'option',
			'capability' => 'manage_options',
		) );
	$wp_customize->add_control( 'footer_menu[first]', array(
		'label' => __( 'Set Footer Menu 1' ),
		'section' => 'footer_setup',
		'type' => 'select',
		'choices'     => $result,
		'allow_addition' => true,
	) );

	$wp_customize->add_setting( 'footer_menu[second_title]', array(
			'type'       => 'option',
			'capability' => 'manage_options',
		) );
	$wp_customize->add_control( 'footer_menu[second_title]', array(
		'label' => __( 'Set title Menu 2' ),
		'section' => 'footer_setup',
		'type' => 'textarea',
		'allow_addition' => true,
	) );

	$wp_customize->add_setting( 'footer_menu[second]', array(
			'type'       => 'option',
			'capability' => 'manage_options',
		) );
	$wp_customize->add_control( 'footer_menu[second]', array(
		'label' => __( 'Set Footer Menu 2' ),
		'section' => 'footer_setup',
		'type' => 'select',
		'choices'     => $result,
		'allow_addition' => true,
	) );
	$wp_customize->add_setting( 'footer_menu[third_title]', array(
			'type'       => 'option',
			'capability' => 'manage_options',
		) );
	$wp_customize->add_control( 'footer_menu[third_title]', array(
		'label' => __( 'Set title Menu 3' ),
		'section' => 'footer_setup',
		'type' => 'textarea',
		'allow_addition' => true,
	) );

	$wp_customize->add_setting( 'footer_menu[third]', array(
			'type'       => 'option',
			'capability' => 'manage_options',
		) );
	$wp_customize->add_control( 'footer_menu[third]', array(
		'label' => __( 'Set Footer Menu 3' ),
		'section' => 'footer_setup',
		'type' => 'select',
		'choices'     => $result,
		'allow_addition' => true,
	) );


}
function box_get_menu(){

	//return  $result;
}
$t = box_get_menu();
