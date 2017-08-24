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

