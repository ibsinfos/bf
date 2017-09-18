<?php
/**
 *Template Name: Process payment
 */

$type  = isset($_GET['type']) ? $_GET['type'] : '';
$order = array();
$order_id = isset($_GET['order_id']) ? $_GET['order_id'] : 0;

// box_log('page-process-payment.php');
// box_log($_POST);

if($type == 'paypal'){
	$verified = BX_Paypal::get_instance()->verifyIPN();
	if ($verified) {

		// appove order_status and add amout of this order to ballance of payer.
		//box_log('Verified successful');
		bx_process_payment($_POST);
	    /*
	     * Process IPN
	     * A list of variables is available here:
	     * https://developer.paypal.com/webapps/developer/docs/classic/ipn/integration-guide/IPNandPDTVariables/
	     */
	}
	// Reply with an empty 200 response to indicate to paypal the IPN was received correctly.
	//header("HTTP/1.1 200 OK");
} else if($type == 'cash'){
	global $user_ID;

	$order = BX_Order::get_instance()->get_order($order_id);

	$is_access = get_post_meta($order->ID,'is_access', true);

	if( $user_ID == $order->post_author && !$is_access ){
		$credit = BX_Credit::get_instance();
		$credit->increase_credit_pending($order->post_author, $order->amout);
		update_post_meta($order->ID,'is_access', 1);
	}
}
?>
<?php get_header(); ?>
<div class="full-width">
	<div class="container site-content-contain">
		<div class="row site-content" id="content" >
			<div class="col-md-12 detail-project text-justify" style="min-height: 500px; padding-top: 100px; padding-bottom: 250px;">
				<div class="msg" style="width: 500px; margin: 0 auto; text-align: left;">
					<?php
					//echo '<pre>';
					//var_dump($order);
					//echo '</pre>';

						if( !empty( $order ) ){

							_e('Thank you for your purching. You have buy credit successful','boxtheme'); ?>
							<h3><?php _e('Detail:','boxtheme'); ?></h3>
							<p><label>Price:</label><?php echo $order->amout;?></p>
							<?php if( $type == 'cash'){
								if( $order->post_status == 'publish') {
									 _e('Your order is approved ','boxtheme');
								 } else { ?>

									<?php
										$option = BX_Option::get_instance();
        								$payment = $option->get_group_option('payment');
	        							$cash = (object) $payment->cash;
		            					if( ! empty( $cash->description) ){
		            						echo $cash->description;
		            					}
					 			}
					 		}
					 	} ?>

				</div>
			</div>

		</div>
	</div>
</div>

<?php get_footer();?>
