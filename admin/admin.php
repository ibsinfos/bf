<?php
if ( ! defined( 'ABSPATH' ) ) exit;
class BX_Admin{
    static $instance;
    static $main_setting_slug = 'box-settings';

    function __construct(){
        add_action( 'admin_menu', array($this,'bx_register_my_custom_menu_page' ));
        add_action( 'admin_enqueue_scripts', array($this, 'bx_custom_wp_admin_style' ) );
        add_action( 'admin_footer', array($this,'box_admin_footer_html') );
    }
    static function get_instance(){
        if (null === static::$instance) {
            static::$instance = new static();
        }
        return static::$instance;
    }
    static function bx_register_my_custom_menu_page() {
        add_menu_page(
            __( 'Theme Options', 'boxtheme' ),
          	'Box settings', // use to check the sub menu
            'manage_options',
            self::$main_setting_slug,
            array('BX_Admin','my_custom_menu_page'),
            plugins_url( 'myplugin/images/icon.png' ),
            6
        );


	}

    static function bx_custom_wp_admin_style($hook) {
        // Load only on ?page=theme-options
    	$credit_page = self::$main_setting_slug.'_page_credit-setting';
        $sub_page = array(self::$main_setting_slug.'_page_credit-setting');
        //var_dump($hook); //box-settings_page_credit-setting
        if( $hook == 'toplevel_page_'.self::$main_setting_slug || in_array($hook, $sub_page ) ) {


	        wp_enqueue_style( 'bootraps', get_theme_file_uri( '/assets/bootstrap/css/bootstrap.min.css' ) );
	        wp_enqueue_style( 'custom_wp_admin_css', get_theme_file_uri('admin/css/style.css') );
	        wp_enqueue_style( 'bootraps-toggle', get_theme_file_uri('admin/css/bootstrap-toggle.min.css') );
	        wp_enqueue_script('toggle-button',get_theme_file_uri('admin/js/bootstrap-toggle.min.js') );
	        wp_enqueue_script('box-js',get_theme_file_uri('admin/js/admin.js') );
	        if($hook == $credit_page){
	        	wp_enqueue_script('credit-js',get_theme_file_uri('admin/js/credit.js') );
	        }
	    }

    }
    function install(){
        echo 'this is install section';
    }
    function general(){
        echo 'this is general section';
    }
    function escrow(){
        echo 'this is general section';
    }
    function payment(){
        $group_option = "payment";
        $option = BX_Option::get_instance();
        $payment = $option->get_group_option($group_option);
        $payment = (object)$payment['paypal'];
        $t = (object) BX_Option::get_instance()->get_option('payment','paypal');


        ?>
        <div class="section" id="<?php echo $group_option;?>">
            <div class="package-plan">

                <div class="row">
                    <div class="col-sm-3">
                    </div>
                    <div class="col-sm-9">
                        <?php
                        $args = array(
                            'post_type' => '_package',
                            'meta_key' => 'type',
                            'meta_value' => 'buy_credit'
                        );
                        $the_query = new WP_Query($args);

                        // The Loop
                        if ( $the_query->have_posts() ) {
                            echo '<div class="">';
                            echo '<h3> List packge plan </h3>';
                            echo '<ul>';
                            while ( $the_query->have_posts() ) {
                                $the_query->the_post();
                                echo '<li class="col-sm-12 block">';
                                echo '<div class="col-sm-11">';
                                $price = get_post_meta(get_the_ID(),'price', true);
                                //echo $price;
                                $sku = get_post_meta(get_the_ID(),'sku', true);
                                echo $sku .' -'. $price .' - '.get_the_content();
                                echo '</div>';
                                echo '<div class="col-sm-1 align-right"><span id="'.get_the_ID().'" class="btn-delete">X</span>';

                                echo '</div>';
                                echo '</li>';

                            }
                            echo '</ul>';
                            echo '</div>';
                            /* Restore original Post Data */
                            wp_reset_postdata();
                        } else {
                            // no posts found
                        }



                        ?>
                        <form class="frm-add-package">
                            <h3> Insert new package </h3>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" required name="sku" placeholder="<?php _e('SKU');?>"><small>SKU</small>
                            </div>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" required name="price" placeholder="<?php _e('Price');?>"  ><small>$</small>
                            </div>
                            <div class="col-sm-12">
                                <p> &nbsp; </p>
                                <input type="text" class="form-control" name="post_content" placeholder="<?php _e('Desction of this package','boxtheme');?>">
                            </div>

                            <div class="col-sm-11">
                            </div>
                            <div class="col-sm-1 align-right">
                            <button class="btn">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="form-group row one-item" id="paypal">
                <label for="inputEmail3" class="col-sm-3 col-form-label">PayPal</label>
                <div class="col-sm-9">
                    <input type="email" class="form-control auto-save" alt="payment" value="<?php echo $payment->email;?>" name="email" placeholder="Email">
                </div>
                <div class="col-sm-9">
                </div>
                <div class="col-sm-3 align-right">
                    <?php bx_buton_option('payment','paypal');?>
                </div>
            </div>

        </div>
        <?php
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
    static function my_custom_menu_page(){ ?>


        <div class="wrap">
            <h1> Theme Options</h1>
            <div class="wrap-conent">
                <div class="heading-tab">
                    <ul>
                        <?php
                        $main_page = admin_url('admin.php?page='.self::$main_setting_slug);
                        $escrow_link = add_query_arg('section','escrow', $main_page);
                        $general_link = add_query_arg('section','general', $main_page);
                        $install_link = add_query_arg('section','install', $main_page);
                        $payment_link = add_query_arg('section','payment', $main_page);

                        ?>
                        <li><a href="<?php echo $general_link;?>">General</a></li>
                        <li><a href="<?php echo $install_link;?>">Install</a></li>
                        <li><a href="<?php echo $payment_link;?>">Payment</a></li>
                        <li><a href="<?php echo $escrow_link;?>">Escrow</a></li>

                    </ul>
                    <div class="tab-content clear">
                        <?php
                            $section = isset($_GET['section']) ? $_GET['section'] : 'install';
                            $admin = BX_Admin::get_instance();
                            $admin->$section();
                        ?>
                    </div>
                </div>
            </div>
        </div>
    <?php
    }
}
$admin = new BX_Admin();
function bx_buton_option($group, $name, $checked = 'checked'){
    echo '<input type="checkbox" class="auto-save" name="enable" value="1" '.$checked.' data-toggle="toggle">';

}