<?php

// group = escrow
$group = "payment";
$option = BX_Option::get_instance();
$payment = $option->get_group_option($group);

$paypal = (object) $payment->paypal;
$cash = (object) $payment->cash;
$mode = $payment->mode;
// // echo '<pre>';
// // var_dump($cash);
// echo '</pre>';

$cash_enable = $cash->enable;
$pp_enable = 0;

if(isset($paypal->enable) )
    $pp_enable = $paypal->enable;
?>
<div id="<?php echo $group;?>" class="main-group">

   		<h2 class="section-title"><?php _e('Payment gateways','boxtheme');?></h2>

     	<div class="sub-wrap col-sm-12">
     		<div class="full">
    			<div class="col-md-3">
    			<h3>Sandbox mode</h3>
    			</div> <div class="col-md-9"><?php  bx_swap_button($group,'mode', $mode, 1);?>  <br /><span>if enable this option, all job only appearances in the site after admin manually approve it.</span></div>

    		</div>

     		<div class="sub-section" id="paypal">
                <label for="inputEmail3" class="col-sm-3 col-form-label">PayPal</label>
                <div class="col-sm-9">
                    <input type="email" class="form-control auto-save" alt="paypal" value="<?php if(! empty($paypal->email) ) echo $paypal->email;?>" level="1" name="email" placeholder="Email">
                     <span class="f-right"><?php _e('Set PayPal email','boxtheme');?></span>
                </div>
                <div class="col-sm-9">
                </div>
                <div class="col-sm-3 align-right">
                    <?php bx_swap_button('payment','enable', $pp_enable, 0);?>
                </div>
            </div>

            <div class="sub-section" id="cash">
            	 <div class="sub-item" id="cash">
	            	<label for="inputEmail3" class="col-sm-3 col-form-label">Cash</label>
	            	<?php

	                $cash_des = $option->get_default_option($group,'cash','description',1);
	                if( isset($cash->description) )
	                    $cash_des = $cash->description;
	            	?>
	                <div class="col-sm-9 wrap-auto-save">
	                	 <textarea name="description" id="description" class="auto-save simple" level="1"> <?php echo esc_html($cash_des);?></textarea>
	                	<div class="hide">
	                	<?php wp_editor($cash->description,'call');?>

	                	</div>
	                </div>

	                <div class="col-sm-9">           </div>
	                <div class="col-sm-3 align-right">
	                    <?php bx_swap_button('payment','enable', $cash_enable, 1);?>
	                </div>
	            </div>
	       	</div>
        </div><!-- .end sub-wrap !-->
</div>