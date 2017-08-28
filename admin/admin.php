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

	        wp_enqueue_style( 'bootraps', get_theme_file_uri( '/library/bootstrap/css/bootstrap.min.css' ) );
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
        echo 'This function is updating';
    }
    function general(){ ?>

    	<?php $this->main_access();?>
		<?php $this->social_login();?>
		<?php $this->google_captcha();?>


		<?php
    }
    function main_access(){
    	$group_option = "main_options";
        $option = BX_Option::get_instance();
        $social_api = $option->get_group_option($group_option);

    	?>
    	<h2>Main options</h2>
    	<div class="sub-section row" id="<?php echo $group_option;?>">
    		<div class="full">
    			<div class="col-md-3">
    			<h3> Pending jobs</h3>
    			</div> <div class="col-md-9"><?php bx_swap_button($group_option,'auto_approve', 1);?>  <br /><span>if enable this option, all job only appearances in the site after admin manually approve it.</span></div>

    		</div>
    		<div class="full">
    			<div class="col-md-3"><h3>Google Analytics Script</h3></div> <div class="col-md-9"><textarea name="google_ans"></textarea></div>
    		</div>
    		<div class="full">
    			<div class="col-md-3"><h3>Social Links</h3><span> List social link in the footer</span></div>
    			<div class="col-md-9">
    				<div class="form-group row">
						<label for="example-text-input" class="col-md-4 col-form-label"><?php _e('Facebook link','boxtheme');?></label>
						<div class="col-md-12">
						<input class="form-control" type="text" value="http://fb.com/boxthemes/" id="example-text-input">
						</div>
					</div>
					<div class="form-group row">
						<label for="example-text-input" class="col-md-4 col-form-label"><?php _e('Twitter link','boxtheme');?></label>
						<div class="col-md-12">
						<input class="form-control" type="text" value="http://tw.com/boxthemes/" id="example-text-input">
						</div>
					</div>

					<div class="form-group row">
						<label for="example-text-input" class="col-md-4 col-form-label"><?php _e('Google Plus link','boxtheme');?></label>
						<div class="col-md-12">
						<input class="form-control" type="text" value="http://plus.google.com/boxthemes/" id="example-text-input">
						</div>
					</div>

    			</div>
    		</div>


    	</div> <?php
    }
    function social_login(){
    	$group_option = "social_api";
        $option = BX_Option::get_instance();
        $social_api = $option->get_group_option($group_option);
        $item1  = 'facebook';
        $item2  = 'google';
        $app_id = $app_secret = '';

        $facebook = (object) $social_api[$item1];
        $google = (object) $social_api[$item2];
        $app_id = isset($facebook->app_id) ? $facebook->app_id : '';

        $app_secret = isset($facebook->app_secret) ? $facebook->app_secret : '';
        $client_id = isset($google->client_id) ? $google->client_id : '';


    	?>
    	<h2>Social Login</h2>
    	<div class="sub-section" id="<?php echo $group_option;?>">
   			<div class="sub-item" id="<?php echo $item1;?>">
			  	<div class="form-group row">
		  			<div class="col-md-3"><h3> Facebook Setting </h3></div>
		  			<div class="col-md-9 form-group">
				    	<label for="app_id">APP ID</label>
				    	<input type="text" value="<?php echo $app_id;?>" class="form-control auto-save" name="app_id" id="app_id" aria-describedby="app_id" placeholder="Enter APP ID">
				    	<div class="form-group toggle-line">  	<?php bx_swap_button($group_option,$item1, $facebook->enable);?>   </div>
				    </div>
			    </div>

			</div>
			<div class="sub-item" id="google">
			  	<div class="form-group row">
			  		<div class="col-md-3"><h3> Google Setting </h3></div>
			  		<div class="col-md-9 ">
				    	<label for="client_id">Client ID</label>
				    	<input type="text" class="form-control auto-save" value="<?php echo $client_id;?>" name="client_id" id="client_id" aria-describedby="client_id" placeholder="Client ID">
				    	<div class="form-group toggle-line"><?php bx_swap_button($group_option,$item2, $google->enable);?></div>
			    	</div>
			  	</div>
			</div>
		</div>
    	<?php
    }
    function google_captcha(){
    	$group_option = "social_api";
        $option = BX_Option::get_instance();
        $social_api = $option->get_group_option($group_option);
        $item1  = 'facebook';
        $item2  = 'google';
        $app_id = $app_secret = '';

        $facebook = (object) $social_api[$item1];
        $google = (object) $social_api[$item2];
        $app_id = isset($facebook->app_id) ? $facebook->app_id : '';

        $app_secret = isset($facebook->app_secret) ? $facebook->app_secret : '';
        $client_id = isset($google->client_id) ? $google->client_id : '';


    	?>
    	<h2>Google Captcha</h2>
    	<div class="sub-section" id="<?php echo $group_option;?>">
   			<div class="sub-item" id="<?php echo $item1;?>">
			  	<div class="form-group row">
		  			<div class="col-md-3"><h3>Settings</h3></div>
		  			<div class="col-md-9 form-group">
				    	<label for="app_id">APP ID</label>
				    	<input type="text" value="<?php echo $app_id;?>" class="form-control auto-save" name="app_id" id="app_id" aria-describedby="app_id" placeholder="Enter APP ID">
				    	<div class="form-group toggle-line">  	<?php bx_swap_button($group_option,$item1, $facebook->enable);?>   </div>
				    	<div class="form-group toggle-line"><span> Enable this to help your website more security and safe. Add captcha code in login form and in register form. </span> </div>

				    </div>
			    </div>

			</div>

		</div>
    	<?php
    }
    function escrow(){ ?>
    	<h2> <?php _e('Config Escrow system','boxtheme');?> </h2> <br />

    	<form style="max-width: 600px;">
			<div class="form-group row">
				<label for="example-text-input" class="col-md-4 col-form-label"><?php _e('Commistion','boxtheme');?></label>
				<div class="col-md-8">
				<input class="form-control" type="text" value="10" id="example-text-input">
				</div>
			</div>
			<div class="form-group row">
				<label for="example-text-input" class="col-md-4 col-form-label"><?php _e('Commistion type','boxtheme');?></label>
				<div class="col-md-8">
					<select class="form-control" id="exampleSelect2">
						<option value="emp"><?php _e('Fix number','boxtheme');?></option>
						<option value="fre"><?php _e('Percent','boxtheme');?></option>
					</select>
				</div>
			</div>
			<div class="form-group row">
				<label for="example-text-input" class="col-md-4 col-form-label"><?php _e('Who is pay commision','boxtheme');?></label>
				<div class="col-md-8">
					<select class="form-control" id="exampleSelect2">
						<option value="emp">Employer</option>
						<option value="fre">Freelancer</option>
						<option value="share">50/50</option>

					</select>
				</div>
			</div>
			<!-- <div class="form-group row">
				<div class="col-md-12 align-right">
					<button type="submit" class="btn btn-submit"> Save</button>
				</div>
			</div> -->

		</form>
    	<?php

    }
    function payment(){
        $group_option = "payment";
        $option = BX_Option::get_instance();
        $payment = $option->get_group_option($group_option);
        $paypal = (object)$payment['paypal'];

        $t = (object) BX_Option::get_instance()->get_option('payment','paypal');


        ?>
        <div class="section box-section" id="<?php echo $group_option;?>">
        	<h2 class="section-title">Currency Options </h2>
        	<div class="form-group row">
        		<div class="col-md-3"> <span>Select currency</span> 		</div>
        		<div class="col-md-9">
		        	<select name="woocommerce_currency" id="woocommerce_currency" style="min-width: 350px;" class="wc-enhanced-select enhanced" tabindex="-1" title="Currency">
		        	<?php
		        	$list = list_currency();
		        	foreach ($list as $cur => $value) {
		        		echo "<option value='".$cur."'>".$value."</option>";
		        	}
		        	?>
					</select>
				</div>
			</div>

        	<div class="form-group row">
        		<div class="col-md-3">     		<span>Currency Position</span>       		</div>
        		<div class="col-md-9">
        			<select name="woocommerce_currency_pos" id="woocommerce_currency_pos" style="min-width: 350px; " class="wc-enhanced-select enhanced" tabindex="-1" title="Currency Position">
						<option value="left" selected="selected">Left ($99.99)</option>
						<option value="right">Right (99.99$)</option>
						<option value="left_space">Left with space ($ 99.99)</option>
						<option value="right_space">Right with space (99.99 $)</option>
					</select>
        		</div>
        	</div>
        	<div class="form-group row">
        		<div class="col-md-3">     		<span>Thousand Separator</span>       		</div>
        		<div class="col-md-9"> <input name="woocommerce_price_thousand_sep" id="woocommerce_price_thousand_sep" type="text" style="width:50px;" value="," class="" placeholder="" />   </div>
        	</div>
        	<div class="form-group row">
        		<div class="col-md-3">     		<span>Decimal Separator</span>       		</div>
        		<div class="col-md-9"><input name="woocommerce_price_decimal_sep" id="woocommerce_price_decimal_sep" type="text" style="width:50px;" value="." class="" placeholder="">       		</div>
        	</div>

       </div>

        <div class="section box-section" id="<?php echo $group_option;?>">
        	<h2 class="section-title">Package plan</h2>
            <div class="sub-section " id="package_plan">
            	<div class="col-md-3">
            	<h3> List package plan </h3>
            	</div>
            	<div class="col-md-9">
                <?php
                    $args = array(
                        'post_type' => '_package',
                        'meta_key' => 'type',
                        'meta_value' => 'buy_credit'
                    );
                    $the_query = new WP_Query($args);

                    // The Loop
                    if ( $the_query->have_posts() ) {
                        echo '<table class="widefat" id="list_package">';
                        $i = 1; ?>
	                    <thead>
		  					<tr>
								<th class="page-name"><?php _e( 'STT', 'boxtheme' ); ?></th>
		  						<th class="page-name"><?php _e( 'SKU', 'boxtheme' ); ?></th>
		  						<th class="page-name"><?php _e( 'Detail', 'boxtheme' ); ?></th>
		  						<th class="page-name">&nbsp;</th>
		  					</tr>
	   					</thead> <?php
                        while ( $the_query->have_posts() ) {
                            $the_query->the_post();
                            $price = get_post_meta(get_the_ID(),'price', true);
                            //echo $price;
                            $sku = get_post_meta(get_the_ID(),'sku', true);

                            echo '<tr class="block">';
                            echo '<td class="col-md-1">'.$i.'</td>';
                            echo '<td class="col-md-1">'.$sku.'</td>';
                            echo '<td class="col-md-8">';
                            echo get_the_content();
                            echo '</td>';
                            echo '<td class="col-sm-1 align-center">
                            	<span class="swap-btn-act" id="'.get_the_ID().'"><span attr="'.get_the_ID().'" class="btn-act btn-delete 	glyphicon glyphicon-trash"></span> &nbsp; <span  class=" btn-act	glyphicon glyphicon-edit"></span></span>';

                            echo '</td>';
                            echo '</tr>';
                            $i ++;
                        }
                        echo '</table>';

                        /* Restore original Post Data */
                        wp_reset_postdata();
                    } else {
                    	echo '<div class="form-group">';
                        _e('List package plan is empty','boxtheme');
                        echo '</div>';
                    }
                    ?>
                    </div>
                    <div class="col-md-3"><h3 class="form-heading"><?php _e('Insert new package','boxtheme');?> </h3>
                    </div>
                    <div class="col-md-9">
	                    <form class="frm-add-package row">

	                      	<div class="full">
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
		                        	<button class="btn">Create</button>
		                        </div>
		                   	</div>
	                    </form>
                   </div>
            </div>
        </div>
        <?php
    }
    function payment_gateway(){
    	 $group_option = "payment";
        $option = BX_Option::get_instance();
        $payment = $option->get_group_option($group_option);
        $paypal = (object)$payment['paypal'];

        $t = (object) BX_Option::get_instance()->get_option('payment','paypal');


        ?>
        <div class="section box-section" id="<?php echo $group_option;?>">

           	<div class="sub-section " id="payment">
           		<h2 class="section-title"><?php _e('Payment gateways','boxtheme');?></h2>

             	<div class="sub-wrap col-sm-12">
             		<div class="full">
		    			<div class="col-md-3">
		    			<h3>Sandbox mode</h3>
		    			</div> <div class="col-md-9"><?php bx_swap_button($group_option,'auto_approve', 1);?>  <br /><span>if enable this option, all job only appearances in the site after admin manually approve it.</span></div>

		    		</div>

             		<div class="sub-item" id="paypal">
		                <label for="inputEmail3" class="col-sm-3 col-form-label">PayPal</label>
		                <div class="col-sm-9">
		                    <input type="email" class="form-control auto-save" alt="paypal" value="<?php if(! empty($paypal->email) ) echo $paypal->email;?>" name="email" placeholder="Email">
		                     <span class="f-right"><?php _e('Set PayPal email','boxtheme');?></span>
		                </div>
		                <div class="col-sm-9">
		                </div>
		                <div class="col-sm-3 align-right">
		                    <?php bx_swap_button('payment','paypal', $paypal->enable);?>
		                </div>
		            </div>

		            <div class="sub-item hide" id="stripe">
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
		                    <?php bx_swap_button('payment','stripe', $stripe->enable);?>
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
		                    <?php bx_swap_button('payment','cash', $cash->enable);?>
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
                    <div class="tab-content clear row">
                    	<div id="main_content" class="wrap ">
                    		<div id="general">
		                        <?php
		                            $section = isset($_GET['section']) ? $_GET['section'] : 'general';
		                            $admin = BX_Admin::get_instance();
		                            $methods = array('escrow','install','payment','payment_gateway','email');
		                            if( in_array($section, $methods) ){
		                            	$admin->$section();
		                            }else {
		                            	$admin->general();
		                            }

		                        ?>
	                        </div>
                        </div>
                    </div>

            </div>
        </div>
    <?php
    }
    function email(){
    	$main_page 		= admin_url('admin.php?page='.self::$main_setting_slug);
	    $email_link 	= add_query_arg('section','email', $main_page);

    	$group_option ="email";
    	$list = (object) list_email();
    	$label = array(
    		'new_register' =>'New account register',
    		'new_job' => 'New project',
    		'new_bidding' => 'New bidding',
    		'assign_job' => 'Assign job',
    		'new_message' => "New Message",
    	);
    	?>
     	<div class="section box-section" id="<?php echo $group_option;?>">

           	<div class="sub-section " id="payment">
	           	<h2>Email Notifications </h2>
	           	<p> Email notifications sent from job board are listed below. Click on an email to configure it.</p>
	           	<table class="widefat">
	           		<thead>
	  					<tr>
							<th class="page-name"><?php _e( 'Name', 'boxtheme' ); ?></th>
	  						<th class="page-name"><?php _e( 'Subject', 'boxtheme' ); ?></th>
	  						<th class="page-name"><?php _e( 'Receiver', 'boxtheme' ); ?></th>
	  						<th class="page-name">&nbsp;</th>
	  					</tr>
   					</thead>

	           		<?php

	           		foreach ($list as $key=> $email) {
	           			$mail = (object)$email;
	           			$edit_link = add_query_arg('name',$key, $email_link);
	           			echo '<tr><td>'.$label[$key].'<td>'.$mail->subject.'</td><td>'.$mail->receiver.'</td><td><a href="'.$edit_link.'"><span class="glyphicon glyphicon-cog"></span></a></td></tr>';
	           		}
	           		?>
	           	</table>
           	</div>
        </div>
    	<?php
    }
}


function bx_swap_button($group, $name, $is_active){
	$checked = '';
	if( $is_active  ) $checked = 'checked';
	echo '<input type="checkbox" class="auto-save" name="enable" value="'.$is_active.'" '.$checked.' data-toggle="toggle">';

}
?>