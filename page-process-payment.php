<?php
/**
 *Template Name: Process payment
 */

$verified = BX_Paypal::get_instance()->verifyIPN();

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

