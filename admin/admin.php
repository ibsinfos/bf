<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class BX_Admin{
    static $instance;
    static $main_setting_slug = 'box-settings';

    function __construct(){
        add_action( 'admin_menu', array($this,'bx_register_my_custom_menu_page' ), 9);
       	add_action( 'admin_enqueue_scripts', array($this, 'box_enqueue_scripts' ) );
        add_action( 'admin_footer', array($this,'box_admin_footer_html'), 9 );
    }
    static function get_instance(){
        if (null === static::$instance) {
            static::$instance = new static();
        }
        return static::$instance;
    }
    public function bx_register_my_custom_menu_page() {
        add_menu_page(__( 'Theme Options', 'boxtheme' ),'Box settings','manage_options', self::$main_setting_slug, array('BX_Admin','box_custom_menu_page'),'url_img.png',6);
	}

    public function box_enqueue_scripts($hook) {
        // Load only on ?page=theme-options
    	$credit_page = 'box-settings_page_credit-setting';
        $sub_page = array('box-settings_page_credit-setting');
        //var_dump($hook); //box-settings_page_credit-setting
        if( $hook == 'toplevel_page_'.self::$main_setting_slug || in_array($hook, $sub_page ) ) {

	        wp_enqueue_style( 'bootraps', get_theme_file_uri( '/library/bootstrap/css/bootstrap.min.css' ) );
	        wp_enqueue_style( 'box_wp_admin_css', get_theme_file_uri('admin/css/box_style.css') );
	        wp_enqueue_style( 'bootraps-toggle', get_theme_file_uri('admin/css/bootstrap-toggle.min.css') );
	        wp_enqueue_script('toggle-button',get_theme_file_uri('admin/js/bootstrap-toggle.min.js') );
	        wp_enqueue_script( 'box-js', get_theme_file_uri('admin/js/admin.js'), array('jquery','wp-util') );
	        if($hook == $credit_page){
	        	wp_enqueue_script('credit-js',get_theme_file_uri('admin/js/credit.js') );
	        }
	    }

    }
    function install(){
        echo 'This function is updating';
    }
    function general(){
    	get_template_part( 'admin/templates/general');    }

    function escrow(){
    	get_template_part( 'admin/templates/escrow');

    }
    function payment(){
    	get_template_part( 'admin/templates/payment');
    }
    function payment_gateway(){
    	get_template_part( 'admin/templates/payment_gateway');
    }
    static function box_admin_footer_html(){
    	$page = isset($_GET['page']) ? $_GET['page'] : '';
    	if( in_array($page, array('credit-setting','box-settings')) ) {	?>
	    	<script type="text/javascript">
	            var bx_global = {
	                'home_url' : '<?php echo home_url() ?>',
	                'admin_url': '<?php echo admin_url() ?>',
	                'ajax_url' : '<?php echo admin_url().'admin-ajax.php'; ?>',
	                'selected_local' : '',
	                'is_free_submit_job' : true,

	            }
	        </script>
    	<?php }
    }
    function email(){
    	global $main_page;
    	$main_page 		= admin_url('admin.php?page='.self::$main_setting_slug);
    	get_template_part( 'admin/templates/email');
	}
    static function box_custom_menu_page(){
    	$section = isset($_GET['section']) ? $_GET['section'] : 'general';
        $admin = BX_Admin::get_instance();
        $methods = array('escrow','install','payment','payment_gateway','email');
        ?>
        <div class="wrap">
            <h1><?php _e('Theme Options','boxtheme');?></h1>
            <div class="wrap-conent">
            	<div class="heading-tab">
                    <ul>
                        <?php
                        $main_page 		= admin_url('admin.php?page='.self::$main_setting_slug);
                        $escrow_link 	= add_query_arg('section','escrow', $main_page);
                        $general_link 	= add_query_arg('section','general', $main_page);
                        $install_link 	= add_query_arg('section','install', $main_page);
                        $email_link 	= add_query_arg('section','email', $main_page);
                        $payment_link 	= add_query_arg('section','payment', $main_page);
                        $gateway_link 	= add_query_arg('section','payment_gateway', $main_page);

                        ?>
                        <li><a href="<?php echo $general_link;?>">General</a></li>
                        <li><a href="<?php echo $payment_link;?>">Currency and Package</a></li>
                        <li><a href="<?php echo $gateway_link;?>">Payment Gateway</a></li>
                        <li><a href="<?php echo $escrow_link;?>">Config Credit</a></li>
                        <li><a href="<?php echo $email_link;?>">Email</a></li>
                        <li><a href="<?php echo $install_link;?>">Install</a></li>
                    </ul>
                </div>
                <div class="tab-content clear">
                	<div id="main_content" class="wrap ">
                		<div id="general">
                        <?php
                            if( in_array($section, $methods) ){
                            	$admin->$section();
                            } else {
                            	$admin->general();
                            }
                        ?>
                        </div>
                    </div>
                </div>
            </div>
        </div> <?php
    }
}

?>