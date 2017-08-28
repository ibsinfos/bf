<?php
$group_option = "payment";
$option = BX_Option::get_instance();
$payment = $option->get_group_option($group_option);
$paypal = (object)$payment['paypal'];

$mode = 0;// sandbox = 0

if( isset($payment['mode'] ) ){
	$mode = $payment['mode'];
}

?>
<div class="section box-section" id="<?php echo $group_option;?>">

   	<div class="sub-section " id="payment">
   		<h2 class="section-title"><?php _e('Payment gateways','boxtheme');?></h2>

     	<div class="sub-wrap col-sm-12">
     		<div class="full">
    			<div class="col-md-3">
    			<h3>Sandbox mode</h3>
    			</div> <div class="col-md-9"><?php  bx_swap_button($group_option,'mode', $mode, $multipe = false);?>  <br /><span>if enable this option, all job only appearances in the site after admin manually approve it.</span></div>

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
                	 <textarea name="description" id="description" class="auto-save"> <?php echo stripslashes($cash->description);?></textarea>
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