<?php
/**
 *Template Name: Process payment
 */

$type  = isset($_GET['type']) ? $_GET['type'] : '';
$order_id = isset($_GET['order_id']) ? $_GET['order_id'] : 0;

$verified = BX_Paypal::get_instance()->verifyIPN();
if($type == 'paypal'){
	if ($verified) {
		// appove order_status and add amout of this order to ballance of payer.
		bx_error_log('Verified successful');
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
			<div class="col-md-8 detail-project text-justify">
				<?php the_post(); ?>
				<h1><?php the_title();?></h1>
				<?php the_date();?>
				<?php the_content(); ?>
			</div>
			<div class="col-md-4">
				<?php get_sidebar('single');?>
			</div>
		</div>
	</div>
</div>

<?php get_footer();?>

