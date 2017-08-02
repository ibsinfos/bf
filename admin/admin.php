<?php

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


	        wp_enqueue_style( 'bootraps', get_theme_file_uri( '/assets/bootstrap/css/bootstrap.min.css' ) );
	        wp_enqueue_style( 'box_wp_admin_css', get_theme_file_uri('admin/css/box_style.css') );
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
    function general(){ ?>
    	<div class="col-md-3">
    		<ul class="block">
    			<li>Home page</li>
    			<li>Social Login </li>
    			<li>Google Captcha</li>
    		</ul>

    	</div>
    	<div class="col-md-9">
    	this is right
    	</div>
    	<?php
    }
    function escrow(){
        echo 'this is escrow section ';
    }
    function payment(){
        $group_option = "payment";
        $option = BX_Option::get_instance();
        $payment = $option->get_group_option($group_option);
        $paypal = (object)$payment['paypal'];

        $t = (object) BX_Option::get_instance()->get_option('payment','paypal');


        ?>
        <div class="section box-section" id="<?php echo $group_option;?>">

            <div class="sub-section " id="package_plan">
            	<h2 class="section-title">List Package plan</h2>
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
                        <div class="col-sm-12">
                        	<h3 class="form-heading"><?php _e('Insert new package','boxtheme');?> </h3>
                        </div>
                        <div class="col-sm-6 one-line">
                            <input type="text" class="form-control" required name="sku" placeholder="<?php _e('SKU');?>"><small>SKU</small>
                        </div>
                        <div class="col-sm-6 one-line">
                            <input type="text" class="form-control" required name="price" placeholder="<?php _e('Price');?>"  ><small>$</small>
                        </div>
                        <div class="col-sm-12 one-line">
                        	<textarea id="post_content" name="post_content" class=""> <?php _e('Description of new package','boxtheme');?></textarea>
                        </div>

                        <div class="col-sm-10 one-line">
                        </div>
                        <div class="col-sm-2 align-right one-line">
                        	<button class="btn">Save</button>
                        </div>
                    </form>

            </div>


           <div class="sub-section " id="payment">
	         	<h2 class="section-title"><?php _e('Payment gateways','boxtheme');?></h2>
             	<div class="sub-wrap col-sm-12">
             		<div class="sub-item" id="paypal">
		                <label for="inputEmail3" class="col-sm-3 col-form-label">PayPal</label>
		                <div class="col-sm-9">
		                    <input type="email" class="form-control auto-save" alt="paypal" value="<?php if(! empty($paypal->email) ) echo $paypal->email;?>" name="email" placeholder="Email">
		                     <span class="f-right"><?php _e('Set PayPal email','boxtheme');?></span>
		                </div>
		                <div class="col-sm-9">
		                </div>
		                <div class="col-sm-3 align-right">
		                	<?php
		                	$check = 'checked';
		                	if( (int) $paypal->enable != 1){
		                		$check = '';
		                	}
		                	?>
		                    <?php bx_swap_button('payment','paypal', $check);?>
		                </div>
		            </div>

		            <div class="sub-item" id="stripe">
		            	<?php
		            	$stripe = (object) array(
		            		'api_key' => 'LDFJ',
		            		'api_code' => 'LDFJ',
		            		'enable' => 0
		            	);
		            	if( !empty($payment['stripe']) ){
		            		$stripe = (object) $payment['stripe'];
		            	}

		            	?>
		                <label for="inputEmail3" class="col-sm-3 col-form-label">Stripe</label>
		                <div class="col-sm-9">
		                    <input type="email" class="form-control auto-save" value="<?php  if(! empty($stripe->api_key) )  echo $stripe->api_key;?>" name="api_key" placeholder="API Key">
		                    <span class="f-right"> Set Sitrpe API key here </span>
		                </div>
		                <label for="inputEmail3" class="col-sm-3 col-form-label">&nbsp;</label>
		                <div class="col-sm-9" >
		                    <input type="email" class="form-control auto-save" value="<?php if(! empty($stripe->api_code) ) echo $stripe->api_code;?>" name="api_code" placeholder="API Code">
		                    <span class="f-right"> Set Sitrpe API code here </span>
		                </div>
		                <div class="col-sm-9">
		                </div>
		                <div class="col-sm-3 align-right">
		                	<?php
		                	$check = 'checked';
		                	if( (int) $stripe->enable != 1){
		                		$check = '';
		                	}
		                	?>
		                    <?php bx_swap_button('payment','stripe', $check);?>
		                </div>
		            </div>

	                <div class="sub-item" id="cash">
	                	<label for="inputEmail3" class="col-sm-3 col-form-label">Cash</label>
		            	<?php
		            	$cash = (object) array('description' => 'Cash payment',
		            		'enable' => 0);
		            	if( !empty($payment['cash']) ){
		            		$cash = (object) $payment['cash'];
		            	}
		            	if( empty($cash->description) ){
		            		$cash->description = __("Please deposit to this account:\nNumber: XXXXXXXXXX.\nBank: ANZ Bank.\nAccount name: Johnny Cook.\nAfter get your fund, we will approve your order and you can access your balance.",'boxtheme');
		            	}
		            	?>
		                <div class="col-sm-9 wrap-auto-save">
		                	 <textarea name="description" id="description" class="auto-save"> <?php echo $cash->description;?></textarea>
		                	<div class="hide">
		                	<?php wp_editor($cash->description,'call');?>
		                	</div>
		                </div>

		                <div class="col-sm-9">
		                </div>
		                <div class="col-sm-3 align-right">
		                	<?php
		                	$check = 'checked';
		                	if( (int) $cash->enable != 1) $check = '';               	?>
		                    <?php bx_swap_button('payment','cash', $check);?>
		                </div>
	           		</div>
	            </div><!-- .end sub-wrap !-->
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
    static function box_custom_menu_page(){ ?>


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
                        <li><a href="<?php echo $payment_link;?>">Config Payment</a></li>
                        <li><a href="<?php echo $escrow_link;?>">Config Credit</a></li>

                    </ul>
                    <div class="tab-content clear">
                        <?php
                            $section = isset($_GET['section']) ? $_GET['section'] : 'general';
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


function bx_swap_button($group, $name, $checked){
	// $value = 0;
	// if($checked == 'checked')
	// 	$value = 1;
 //    echo '<input type="checkbox" class="auto-save" name="enable" value="'.$value.'" '.$checked.' data-toggle="toggle">';

}
?>