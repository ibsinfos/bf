<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
function setup_enroviment() {

	BX_User::add_role();
	global $box_general, $box_currency, $app_api, $checkout_mode, $escrow;
	$box_general = BX_Option::get_instance()->get_general_option(); // return not an object - arrray.
	$box_currency = (OBJECT) BX_Option::get_instance()->get_currency_option($box_general);
	$app_api = (OBJECT) BX_Option::get_instance()->get_app_api_option($box_general);
	$checkout_mode = (int) $box_general->checkout_mode; // 0 - sandbox. 1- real

	$escrow = (object) BX_Option::get_instance()->get_escrow_setting();

}
add_action( 'after_setup_theme','setup_enroviment');
function bx_pre_get_filter( $query ) {

    if ( is_post_type_archive( PROJECT ) && !is_admin() ) {
        // Display 50 posts for a custom post type called 'movie'
        $query->set( 'post_status', 'publish' );
        return $query;
    }
    return $query;
}
add_action( 'pre_get_posts', 'bx_pre_get_filter', 1 );


add_action( 'init', 'bx_theme_init' , 9);

/**
 * Register a Project post type.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_post_type
 */
function bx_theme_init() {

	$labels = array(
		'name'               => _x( 'Projects', 'post type general name', 'your-plugin-boxtheme' ),
		'singular_name'      => _x( 'Project', 'post type singular name', 'your-plugin-boxtheme' ),
		'menu_name'          => _x( 'Projects', 'admin menu', 'your-plugin-boxtheme' ),
		'name_admin_bar'     => _x( 'Project', 'add new on admin bar', 'your-plugin-boxtheme' ),
		'add_new'            => _x( 'Add New', 'Project', 'your-plugin-boxtheme' ),
		'add_new_item'       => __( 'Add New Project', 'your-plugin-boxtheme' ),
		'new_item'           => __( 'New Project', 'your-plugin-boxtheme' ),
		'edit_item'          => __( 'Edit Project', 'your-plugin-boxtheme' ),
		'view_item'          => __( 'View Project', 'your-plugin-boxtheme' ),
		'all_items'          => __( 'All Projects', 'your-plugin-boxtheme' ),
		'search_items'       => __( 'Search Projects', 'your-plugin-boxtheme' ),
		'parent_item_colon'  => __( 'Parent Projects:', 'your-plugin-boxtheme' ),
		'not_found'          => __( 'No Projects found.', 'your-plugin-boxtheme' ),
		'not_found_in_trash' => __( 'No Projects found in Trash.', 'your-plugin-boxtheme' )
	);

	$args = array(
		'labels'             => $labels,
         'description'        => __( 'Description.', 'boxthemes' ),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'project' ),
		'capability_type'    => 'post',
		'has_archive'        => 'projects',
		'hierarchical'       => false,
		'menu_position'      => null,
		'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' )
	);

	register_post_type( 'project', $args );

	$labels = array(
		'name'                       => _x( 'Categories', 'taxonomy general name', 'boxtheme' ),
		'singular_name'              => _x( 'Category', 'taxonomy singular name', 'boxtheme' ),
		'search_items'               => __( 'Search Categories', 'boxtheme' ),
		'popular_items'              => __( 'Popular Categories', 'boxtheme' ),
		'all_items'                  => __( 'All Categories', 'boxtheme' ),
		'parent_item'                => null,
		'parent_item_colon'          => null,
		'edit_item'                  => __( 'Edit Category', 'boxtheme' ),
		'update_item'                => __( 'Update Category', 'boxtheme' ),
		'add_new_item'               => __( 'Add New Category', 'boxtheme' ),
		'new_item_name'              => __( 'New Category Name', 'boxtheme' ),
		'separate_items_with_commas' => __( 'Separate Categories with commas', 'boxtheme' ),
		'add_or_remove_items'        => __( 'Add or remove Categories', 'boxtheme' ),
		'choose_from_most_used'      => __( 'Choose from the most used Categories', 'boxtheme' ),
		'not_found'                  => __( 'No Categories found.', 'boxtheme' ),
		'menu_name'                  => __( 'Categories', 'boxtheme' ),
	);

	$args = array(
		'hierarchical'          => true,
		'labels'                => $labels,
		'show_ui'               => true,
		'show_admin_column'     => true,
		'update_count_callback' => '_update_post_term_count',
		'query_var'             => true,
		'rewrite'               => array( 'slug' => 'cat' ),
	);
	register_taxonomy( 'project_cat', 'project', $args );

	$labels = array(
		'name'               => _x( 'Profiles', 'post type general name', 'your-plugin-boxtheme' ),
		'singular_name'      => _x( 'Profile', 'post type singular name', 'your-plugin-boxtheme' ),
		'menu_name'          => _x( 'Profiles', 'admin menu', 'your-plugin-boxtheme' ),
		'name_admin_bar'     => _x( 'Profile', 'add new on admin bar', 'your-plugin-boxtheme' ),
		'add_new'            => _x( 'Add New', 'Profile', 'your-plugin-boxtheme' ),
		'add_new_item'       => __( 'Add New Profile', 'your-plugin-boxtheme' ),
		'new_item'           => __( 'New Profile', 'your-plugin-boxtheme' ),
		'edit_item'          => __( 'Edit Profile', 'your-plugin-boxtheme' ),
		'view_item'          => __( 'View Profile', 'your-plugin-boxtheme' ),
		'all_items'          => __( 'All Profiles', 'your-plugin-boxtheme' ),
		'search_items'       => __( 'Search Profiles', 'your-plugin-boxtheme' ),
		'parent_item_colon'  => __( 'Parent Profiles:', 'your-plugin-boxtheme' ),
		'not_found'          => __( 'No Profiles found.', 'your-plugin-boxtheme' ),
		'not_found_in_trash' => __( 'No Profiles found in Trash.', 'your-plugin-boxtheme' )
	);

	$args = array(
		'labels'             => $labels,
                'description'        => __( 'Description.', 'boxthemes' ),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'profile' ),
		'capability_type'    => 'post',
		'has_archive'        => 'profiles',
		'hierarchical'       => false,
		'menu_position'      => null,
		'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' )
	);

	register_post_type( 'profile', $args );


	$labels = array(
		'name'                       => _x( 'Skills', 'taxonomy general name', 'boxtheme' ),
		'singular_name'              => _x( 'Category', 'taxonomy singular name', 'boxtheme' ),
		'search_items'               => __( 'Search Skills', 'boxtheme' ),
		'popular_items'              => __( 'Popular Skills', 'boxtheme' ),
		'all_items'                  => __( 'All Skills', 'boxtheme' ),
		'parent_item'                => null,
		'parent_item_colon'          => null,
		'edit_item'                  => __( 'Edit Category', 'boxtheme' ),
		'update_item'                => __( 'Update Category', 'boxtheme' ),
		'add_new_item'               => __( 'Add New Category', 'boxtheme' ),
		'new_item_name'              => __( 'New Category Name', 'boxtheme' ),
		'separate_items_with_commas' => __( 'Separate Skills with commas', 'boxtheme' ),
		'add_or_remove_items'        => __( 'Add or remove Skills', 'boxtheme' ),
		'choose_from_most_used'      => __( 'Choose from the most used Skills', 'boxtheme' ),
		'not_found'                  => __( 'No Skills found.', 'boxtheme' ),
		'menu_name'                  => __( 'Skills', 'boxtheme' ),
	);
	$args = array(
		'hierarchical'          => false,
		'labels'                => $labels,
		'show_ui'               => true,
		'show_admin_column'     => true,
		'update_count_callback' => '_update_post_term_count',
		'query_var'             => true,
		'rewrite'               => array( 'slug' => 'skill' ),
	);

    register_taxonomy( 'skill', array(PROJECT,PROFILE), $args );

    $labels = array(
		'name'                       => _x( 'Countries', 'taxonomy general name', 'boxtheme' ),
		'singular_name'              => _x( 'Country', 'taxonomy singular name', 'boxtheme' ),
		'search_items'               => __( 'Search Countries', 'boxtheme' ),
		'popular_items'              => __( 'Popular Countries', 'boxtheme' ),
		'all_items'                  => __( 'All Countries', 'boxtheme' ),
		'parent_item'                => null,
		'parent_item_colon'          => null,
		'edit_item'                  => __( 'Edit Category', 'boxtheme' ),
		'update_item'                => __( 'Update Category', 'boxtheme' ),
		'add_new_item'               => __( 'Add New Category', 'boxtheme' ),
		'new_item_name'              => __( 'New Category Name', 'boxtheme' ),
		'separate_items_with_commas' => __( 'Separate Countries with commas', 'boxtheme' ),
		'add_or_remove_items'        => __( 'Add or remove Countries', 'boxtheme' ),
		'choose_from_most_used'      => __( 'Choose from the most used Countries', 'boxtheme' ),
		'not_found'                  => __( 'No Countries found.', 'boxtheme' ),
		'menu_name'                  => __( 'Countries', 'boxtheme' ),
	);
    $args = array(
		'hierarchical'          => false,
		'labels'                => $labels,
		'show_ui'               => true,
		'show_admin_column'     => true,
		'update_count_callback' => '_update_post_term_count',
		'query_var'             => true,
		'rewrite'               => array( 'slug' => 'country' ),
	);
	register_taxonomy( 'country', 'profile', $args );

	$labels = array(
		'name'               => _x( 'Bids', 'post type general name', 'your-plugin-boxtheme' ),
		'singular_name'      => _x( 'Bid', 'post type singular name', 'your-plugin-boxtheme' ),
		'menu_name'          => _x( 'Bids', 'admin menu', 'your-plugin-boxtheme' ),
		'name_admin_bar'     => _x( 'Bid', 'add new on admin bar', 'your-plugin-boxtheme' ),
		'add_new'            => _x( 'Add New', 'Bid', 'your-plugin-boxtheme' ),
		'add_new_item'       => __( 'Add New Bid', 'your-plugin-boxtheme' ),
		'new_item'           => __( 'New Bid', 'your-plugin-boxtheme' ),
		'edit_item'          => __( 'Edit Bid', 'your-plugin-boxtheme' ),
		'view_item'          => __( 'View Bid', 'your-plugin-boxtheme' ),
		'all_items'          => __( 'All Bids', 'your-plugin-boxtheme' ),
		'search_items'       => __( 'Search Bids', 'your-plugin-boxtheme' ),
		'parent_item_colon'  => __( 'Parent Bids:', 'your-plugin-boxtheme' ),
		'not_found'          => __( 'No Bids found.', 'your-plugin-boxtheme' ),
		'not_found_in_trash' => __( 'No Bids found in Trash.', 'your-plugin-boxtheme' )
	);

	$args = array(
		'labels'             => $labels,
        'description'        => __( 'Description.', 'boxthemes' ),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'bid' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => true,
		'menu_position'      => null,
		'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' )
	);

	register_post_type( 'bid', $args );
	register_post_status( AWARDED, array(
		'label'                     => _x( 'Awarded', 'post' ),
		'public'                    => true,
		'exclude_from_search'       => true,
		'show_in_admin_all_list'    => true,
		'show_in_admin_status_list' => true,
		'label_count'               => _n_noop( 'Awarded <span class="count">(%s)</span>', 'Awarded <span class="count">(%s)</span>' ),
		)
	);
	register_post_status( ARCHIVED, array(
		'label'                     => _x( 'Archived', 'post' ),
		'public'                    => true,
		'exclude_from_search'       => true,
		'show_in_admin_all_list'    => true,
		'show_in_admin_status_list' => true,
		'label_count'               => _n_noop( 'Archived <span class="count">(%s)</span>', 'Archived <span class="count">(%s)</span>' ),
		)
	);
	register_post_status( 'done', array(
		'label'                     => _x( 'Done', 'post' ),
		'public'                    => true,
		'exclude_from_search'       => true,
		'show_in_admin_all_list'    => true,
		'show_in_admin_status_list' => true,
		'label_count'               => _n_noop( 'Done <span class="count">(%s)</span>', 'Done <span class="count">(%s)</span>' ),
		)
	);
	register_post_status( 'disputing', array(
		'label'                     => _x( 'Disputing', 'post' ),
		'public'                    => true,
		'exclude_from_search'       => true,
		'show_in_admin_all_list'    => true,
		'show_in_admin_status_list' => true,
		'label_count'               => _n_noop( 'Disputing <span class="count">(%s)</span>', 'Done <span class="count">(%s)</span>' ),
		)
	);
	register_post_status( 'resolved', array(
		'label'                     => _x( 'Resolved', 'post' ),
		'public'                    => true,
		'exclude_from_search'       => true,
		'show_in_admin_all_list'    => true,
		'show_in_admin_status_list' => true,
		'label_count'               => _n_noop( 'Resolved <span class="count">(%s)</span>', 'Done <span class="count">(%s)</span>' ),
		)
	);

	$port_label = array(
		'name'               => _x( 'Portfolio', 'post type general name', 'your-plugin-boxtheme' ),
		'singular_name'      => _x( 'Portfolio', 'post type singular name', 'your-plugin-boxtheme' ),
		'menu_name'          => _x( 'Portfolios', 'admin menu', 'your-plugin-boxtheme' ),
		'name_admin_bar'     => _x( 'Portfolio', 'add new on admin bar', 'your-plugin-boxtheme' ),
		'add_new'            => _x( 'Add New', 'Portfolio', 'your-plugin-boxtheme' ),
		'add_new_item'       => __( 'Add New Portfolio', 'your-plugin-boxtheme' ),
		'new_item'           => __( 'New Profile', 'your-plugin-boxtheme' ),
		'edit_item'          => __( 'Edit Portfolio', 'your-plugin-boxtheme' ),
		'view_item'          => __( 'View Portfolio', 'your-plugin-boxtheme' ),
		'all_items'          => __( 'All Portfolios', 'your-plugin-boxtheme' ),
		'search_items'       => __( 'Search Portfolios', 'your-plugin-boxtheme' ),
		'parent_item_colon'  => __( 'Parent Portfolios:', 'your-plugin-boxtheme' ),
		'not_found'          => __( 'No Portfolios found.', 'your-plugin-boxtheme' ),
		'not_found_in_trash' => __( 'No Portfolios found in Trash.', 'your-plugin-boxtheme' )
	);

	$args = array(
		'labels'             => $port_label,
                'description'        => __( 'Description.', 'boxthemes' ),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'portfolio' ),
		'capability_type'    => 'post',
		'has_archive'        => false,
		'hierarchical'       => false,
		'menu_position'      => null,
		'supports'           => array( 'title', 'author', 'thumbnail', )
	);

	register_post_type( 'portfolio', $args );


	//global $escrow;
	//$active = isset($escrow->active) ? $escrow->active : 'credit';

	//if( $active == 'credit'){
	$args = array(
      	'public' => false,
      	'label'  => 'Transactions',
      	'show_ui' => true,
      	'menu_position' => 25,
      	'supports'           => array( 'title' ),
    );
	register_post_type( 'transaction', $args );
    //}
	$labels = array(
		'name'               => _x( 'Orders', 'post type general name', 'boxtheme' ),
		'singular_name'      => _x( 'Order', 'post type singular name', 'boxtheme' ),
		'menu_name'          => _x( 'Orders', 'admin menu', 'boxtheme' ),
		'name_admin_bar'     => _x( 'Order', 'add new on admin bar', 'boxtheme' ),
		'add_new'            => _x( 'Add New', 'order', 'boxtheme' ),
		'add_new_item'       => __( 'Add New Order', 'boxtheme' ),
		'new_item'           => __( 'New Order', 'boxtheme' ),
		'edit_item'          => __( 'Edit Order', 'boxtheme' ),
		'view_item'          => __( 'View Order', 'boxtheme' ),
		'all_items'          => __( 'All Orders', 'boxtheme' ),
		'search_items'       => __( 'Search Orders', 'boxtheme' ),
		'parent_item_colon'  => __( 'Parent Orders:', 'boxtheme' ),
		'not_found'          => __( 'No orders found.', 'boxtheme' ),
		'not_found_in_trash' => __( 'No orders found in Trash.', 'boxtheme' )
	);

	$args = array(
		'labels'             => $labels,
        'description'        => __( 'Description.', 'boxtheme' ),
		'public'             => false,
		'publicly_queryable' => false,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => '_order' ),
		'capability_type'    => 'post',
		'has_archive'        => false,
		'hierarchical'       => false,
		'menu_position'      => null,
		'supports'           => array( 'title', 'excerpt','editor' )
	);

	register_post_type( ORDER, $args );

	register_post_status( 'sandbox', array(
		'label'                     => _x( 'Sandbox', 'post' ),
		'public'                    => false,
		'exclude_from_search'       => true,
		'show_in_admin_all_list'    => true,
		'show_in_admin_status_list' => true,
		'label_count'               => _n_noop( 'Sanbox <span class="count">(%s)</span>', 'Sanbox <span class="count">(%s)</span>' ),
		)
	);


}
//add_filter( 'author_rewrite_rules', 'wpse17106_author_rewrite_rules' );
function wpse17106_author_rewrite_rules( $author_rewrite_rules )
{
    foreach ( $author_rewrite_rules as $pattern => $substitution ) {
        if ( FALSE === strpos( $substitution, 'author_name' ) ) {
            unset( $author_rewrite_rules[$pattern] );
        }
    }
    return $author_rewrite_rules;
}
//add_filter( 'author_link', 'wpse17106_author_link', 10, 2 );
function wpse17106_author_link( $link, $author_id )
{

    $author_level = 'freelancer';

    $author_level = 'employer';

    $link = str_replace( '%author_level%', $author_level, $link );
    return $link;
}
function codex_Package_init() {
	$labels = array(
		'name'               => _x( 'Packages Plan', 'post type general name', 'boxtheme' ),
		'singular_name'      => _x( 'Package', 'post type singular name', 'boxtheme' ),
		'menu_name'          => _x( 'Packages', 'admin menu', 'boxtheme' ),
		'name_admin_bar'     => _x( 'Package', 'add new on admin bar', 'boxtheme' ),
		'add_new'            => _x( 'Add New', 'Package', 'boxtheme' ),
		'add_new_item'       => __( 'Add New Package', 'boxtheme' ),
		'new_item'           => __( 'New Package', 'boxtheme' ),
		'edit_item'          => __( 'Edit Package', 'boxtheme' ),
		'view_item'          => __( 'View Package', 'boxtheme' ),
		'all_items'          => __( 'All Packages', 'boxtheme' ),
		'search_items'       => __( 'Search Packages', 'boxtheme' ),
		'parent_item_colon'  => __( 'Parent Packages:', 'boxtheme' ),
		'not_found'          => __( 'No Packages found.', 'boxtheme' ),
		'not_found_in_trash' => __( 'No Packages found in Trash.', 'boxtheme' )
	);

	$args = array(
		'labels'             => $labels,
        'description'        => __( 'Description.', 'boxtheme' ),
		'public'             => false,
		'publicly_queryable' => false,
		'show_ui'            => true,
		'show_in_menu'       => false,
		'query_var'          => false,
		'rewrite'            => array( 'slug' => 'package' ),
		'capability_type'    => 'post',
		'has_archive'        => false,
		'hierarchical'       => false,
		'menu_position'      => null,
		'supports'           => array( 'title', 'editor', 'excerpt' )
	);

	//register_post_type( '_package', $args );
}

function boxtheme_scripts() {
	// Add custom fonts, used in the main stylesheet.
	wp_enqueue_style( 'boxtheme-fonts', boxtheme_fonts_url(), array(), null );

	// Theme stylesheet.
	wp_enqueue_style( 'boxtheme-style', get_stylesheet_uri() );

	wp_enqueue_style( 'main-css', get_theme_file_uri( '/assets/css/main.css' ), array( 'boxtheme-style' ), rand() );

	wp_enqueue_style( 'bootraps', get_theme_file_uri( '/library/bootstrap/css/bootstrap.css' ), array( 'boxtheme-style' ), '1.0' );
	wp_enqueue_style( 'box-responsive', get_theme_file_uri( '/assets/css/responsive.css' ), array( 'main-css' ), rand() );



	// Load the Internet Explorer 9 specific stylesheet, to fix display issues in the Customizer.
	if ( is_customize_preview() ) {
		wp_enqueue_style( 'boxtheme-ie9', get_theme_file_uri( '/assets/css/ie9.css' ), array( 'boxtheme-style' ), '1.0' );
		wp_style_add_data( 'boxtheme-ie9', 'conditional', 'IE 9' );
	}

	// Load the Internet Explorer 8 specific stylesheet.
	wp_enqueue_style( 'boxtheme-ie8', get_theme_file_uri( '/assets/css/ie8.css' ), array( 'boxtheme-style' ), '1.0' );
	wp_style_add_data( 'boxtheme-ie8', 'conditional', 'lt IE 9' );

	// Load the html5 shiv.
	wp_enqueue_script( 'html5', get_theme_file_uri( '/assets/js/html5.js' ), array(), '3.7.3' );
	wp_register_script( 'bootstrap-js', get_theme_file_uri( '/library/bootstrap/js/bootstrap.min.js' ), array('jquery'), BX_VERSION );

	wp_script_add_data( 'html5', 'conditional', 'lt IE 9' );

	// load front.js file
	//wp_enqueue_script( 'wp-util' );
	wp_register_script( 'define', get_theme_file_uri( '/assets/js/define.js' ), array( 'jquery','wp-util' ), BX_VERSION, true );
	wp_enqueue_script( 'front', get_theme_file_uri( '/assets/js/front.js' ), array( 'jquery','underscore','define','plupload','bootstrap-js' ),  rand(), true );

	if ( is_singular() ) {

		if( comments_open() && get_option( 'thread_comments' ) ){
			wp_enqueue_script( 'comment-reply' );
		}
		if( is_singular( PROJECT ) ) {

			wp_enqueue_style( 'single-project', get_theme_file_uri( '/assets/css/single-project.css' ), array( 'boxtheme-style' ), BX_VERSION );
			wp_enqueue_script( 'single-project-js', get_theme_file_uri( '/assets/js/single-project.js' ), array( 'front' ), BX_VERSION, true );

			wp_localize_script( 'single-project-js', 'escrow', get_commision_setting(false) );
		}

		if ( is_page_template('page-login.php') ) {
			wp_enqueue_script('jquery');
		}
	}

	if( is_page_template( 'page-post-project.php') ){

		wp_enqueue_style( 'post-project', get_theme_file_uri( '/assets/css/post-project.css' ), array( 'boxtheme-style' ), rand() );
		wp_enqueue_script( 'chosen-js', get_theme_file_uri( '/library/chosen/chosen.jquery.min.js' ), array( 'jquery' ), BX_VERSION, true );
		wp_enqueue_script( 'post-project1', get_theme_file_uri( '/assets/js/post-project.js' ), array( 'jquery','chosen-js','plupload', 'define' ), BX_VERSION, true );

		wp_enqueue_style( 'chosen-css', get_theme_file_uri( '/library/chosen/chosen.min.css' ), array( 'boxtheme-style' ), BX_VERSION );
	}

	if ( is_page_template( 'page-my-profile.php') ){
		wp_enqueue_style( 'profile-css', get_theme_file_uri( '/assets/css/profile.css' ), array( 'boxtheme-style' ), BX_VERSION );
		if ( is_user_logged_in() ){
			wp_enqueue_script( 'chosen-js', get_theme_file_uri( '/library/chosen/chosen.jquery.min.js' ), array( 'jquery' ), BX_VERSION, true );
			wp_enqueue_style( 'chosen-css', get_theme_file_uri( '/library/chosen/chosen.min.css' ), array( 'boxtheme-style' ), BX_VERSION );
			wp_enqueue_script( 'profile', get_theme_file_uri( '/assets/js/profile.js' ), array( 'jquery','chosen-js', 'front' ), BX_VERSION, true );

		}
	}
	if( is_page_template('page-buy-credit.php' ) ){
		wp_enqueue_script( 'buy-credit', get_theme_file_uri( '/assets/js/buy_credit.js' ), array( 'front' ), BX_VERSION, true );
	}

	if( is_page_template('page-dashboard.php' ) ){
		wp_enqueue_script( 'dashboard-js', get_theme_file_uri( '/assets/js/dashboard.js' ), array( 'front' ), BX_VERSION, true );
		wp_enqueue_style( 'dashboard-css', get_theme_file_uri( '/assets/css/dashboard.css' ), array( 'boxtheme-style' ), BX_VERSION );
	}
	if( is_page_template('page-my-credit.php' ) ){
		wp_enqueue_script( 'credit-js', get_theme_file_uri( '/assets/js/credit.js' ), array( 'front' ), BX_VERSION, true );

	}

	if( is_post_type_archive( PROJECT ) ){
		wp_enqueue_script( 'ion.rangeSlider', get_theme_file_uri( '/assets/js/ion.rangeSlider.js' ), array('jquery','front'), BX_VERSION, true );
		wp_enqueue_style( 'ion.rangeSlider', get_theme_file_uri( '/assets/css/ion.rangeSlider.css' ), array(), BX_VERSION );
		wp_enqueue_style( 'ion.rangeSlider.Flat', get_theme_file_uri( '/assets/css/ion.rangeSlider.skinFlat.css' ), array( ), BX_VERSION );
	}
	if( is_page_template( 'page-messages.php' ) ){
		wp_enqueue_script( 'box-msg', get_theme_file_uri( '/assets/js/messages.js' ), array( 'front' ), BX_VERSION, true );
	}

}
add_action( 'wp_enqueue_scripts', 'boxtheme_scripts' );
function bx_excerpt_more( $more ) {
    return '';
}

/**
 * Replaces "[...]" (appended to automatically generated excerpts) with ... and
 * a 'Continue reading' link.
 *
 * @since Twenty Seventeen 1.0
 *
 * @return string 'Continue reading' link prepended with an ellipsis.
 */
function boxtheme_excerpt_more( $link ) {
	if ( is_admin() ) {
		return $link;
	}

	$link = sprintf( '<p class="link-more"><a href="%1$s" class="more-link" >%2$s</a></p>',
		esc_url( get_permalink( get_the_ID() ) ),
		/* translators: %s: Name of current post */
		sprintf( __( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'boxtheme' ), get_the_title( get_the_ID() ) )
	);
	return ' &hellip; ' . $link;
}
add_filter( 'excerpt_more', 'bx_excerpt_more' );
add_filter( 'excerpt_more', 'boxtheme_excerpt_more' );


function the_excerpt_max_charlength( $excerpt, $charlength, $echo = true) {
	$excerpt = strip_tags($excerpt);
	$charlength++;

	if ( mb_strlen( $excerpt ) > $charlength ) {
		$subex = mb_substr( $excerpt, 0, $charlength - 5 );
		$exwords = explode( ' ', $subex );
		$excut = - ( mb_strlen( $exwords[ count( $exwords ) - 1 ] ) );
		if ( $excut < 0 ) {
			echo mb_substr( $subex, 0, $excut );
		} else {
			echo $subex;
		}
		echo '...';
	} else {
		echo strip_tags($excerpt);
	}
}
function bx_page_template_redirect(){
	global $user_ID;


	if( ! is_user_logged_in() ){

		if( is_page_template( 'page-post-project.php' )  ){
			$login_page = add_query_arg( array('redirect'=>box_get_static_link( 'post-project' ) ),box_get_static_link( 'login' ) );
			wp_redirect( $login_page);
			exit();
		}
		if(  is_page_template( 'page-buy-credit.php' ) ){
			$id = isset($_GET['id']) ? $_GET['id'] : '';
			$buy_credit = add_query_arg( 'id',$id, box_get_static_link('buy-credit' ) );
			$login_page = add_query_arg( array('redirect'=>$buy_credit ),box_get_static_link( 'login' ) );
			wp_redirect( $login_page);
			exit();
		}
		if( is_page_template( 'page-my-profile.php' ) ){
			wp_redirect( home_url() );
			exit();
		}

	}

	if( is_user_logged_in() ) {

		if( is_page_template( 'page-login.php' ) || is_page_template( 'page-signup.php' ) || is_page_template( 'page-signup-employer.php' ) || is_page_template( 'page-signup-jobseeker.php' ) ){
			wp_redirect( home_url() );
			exit();
		}

		if ( current_user_can('manage_options') ){
			return ;
		}
		if(  is_page_template( 'page-verify.php' ) ){
			if( is_account_verified( $user_ID) )  {
				wp_redirect( home_url() );
			}
			return;
		}
		if( ! is_account_verified( $user_ID) )  {
	        wp_redirect( box_get_static_link( 'verify' ) );
	        exit();
	    }
	}

}
add_action( 'template_redirect', 'bx_page_template_redirect', 15 );



function bx_custom_avatar_url( $url, $id_or_email) {
    $user = false;
    if ( is_numeric( $id_or_email ) ) {

        $id = (int) $id_or_email;
        $user = get_user_by( 'id' , $id );

    } elseif ( is_object( $id_or_email ) ) {

        if ( ! empty( $id_or_email->user_id ) ) {
            $id = (int) $id_or_email->user_id;
            $user = get_user_by( 'id' , $id );
        }

    } else {
        $user = get_user_by( 'email', $id_or_email );
    }
    if( $user && is_object($user) ){
	    $user_id = $user->data->ID;

		$avatar_url = get_user_meta($user_id, 'avatar_url', true);
		if( !empty( $avatar_url) ){
			$url = $avatar_url;
		}
	}

    return $url;
}
add_filter( 'get_avatar_url' , 'bx_custom_avatar_url' , 99999 , 2 );

