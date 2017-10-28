<?php
/**
 *Template Name: Buy credit
 */
?>
<?php get_header(); ?>
<div class="full-width">
	<div class="container site-container">
		<div class="site-content" id="content" >
			<div class="col-md-8 col-sm-offset-2">
				<?php the_post(); $packages = array(); ?>
				<h1><?php the_title();?></h1>
				<?php if( is_user_logged_in() ){ ?>
				<form class="frm-buy-credit">
					<div class="step step-1">
						<div class="form-group">
						    <h3  class="col-sm-12 col-form-label"><span class="bg-color">1</span> Select a package</h3>
					    	<?php
					    	 $args = array(
	                            'post_type' => '_package',
	                            'meta_key' => 'type',
	                            'meta_value' => 'buy_credit'
	                        );

	                        $the_query = new WP_Query($args);
	                        $g_id  = isset($_GET['id']) ? $_GET['id'] : '';
	                        // The Loop
	                        $key = 0;
	                        if ( $the_query->have_posts() ) {
	                        	 while ( $the_query->have_posts() ) {
	                                $the_query->the_post();
	                                global $post;


	                                $post->price = get_post_meta(get_the_ID(),'price', true);
	                                $post->sku = get_post_meta(get_the_ID(),'sku', true);

	                               array_push( $packages, $post);
	                                ?>
	                                <div class="col-sm-12  package-plan record-line <?php if( get_the_ID() == $g_id ) echo 'activate';?>">
								    	<div class="col-sm-9">
								    		<div class="col-md-8 no-padding-left"><h2 class="pack-name"><?php the_title();?></h2></div><div class="col-md-4 primary-color"><h4 class="pack-price"> <?php box_price($post->price);?> </h4></div>
								    		<div class="pack-detail col-md-12 no-padding-left"><?php echo get_the_content(); ?></div>

								    	</div>
								    	<div class="col-sm-3 align-right">
									    	<label>
									    		<input type="radio"<?php if( $post->ID == $g_id) echo 'checked'; ?> class="required radio radio-package-item" value="<?php echo get_the_ID();?>"  name="package_id" required >

									    		<span class=" no-radius btn align-right btn-select btn-slect-package" id="<?php echo $key;?>" ><span class="default"><?php _e('Select','boxtheme');?></span><span class="activate"><?php _e('Selected','boxtheme');?></span></span>
									    	</label>
								    	</div>
								    	<div class="full f-left"></div>
								    </div>
	                                <?php $key ++;

	                            }
	                              wp_reset_postdata();
	                        } else {
	                        	echo ' No package';
	                        }

						?>
					    </div>
					</div>
					<div class="step step-2">
						<div class="form-group">
						    <h3  class="col-sm-12 col-form-label"><span class="bg-color">2</span> Select a payment gateway</h3>
						    <?php
						    	global $has_payment;
						    	$has_payment= 0;
							    $option = BX_Option::get_instance();
						        $payment = $option->get_group_option('payment');
						        $paypal = array();

						        $paypal = (object)$payment->paypal;


						        $cash = (object)$payment->cash;

						        if( !empty($paypal) && $paypal->enable ) { 	$has_payment= 1;
							 		?>
								    <div class="col-sm-12  gateway-payment  record-line"">
								    	<div class="col-sm-9">
								    		<img src="<?php echo get_theme_file_uri('img/PayPal.jpg');?>" width="200">
								    		<p>You will checkout via paypal payment </p>

								    	</div>
								    	<div class="col-sm-3 align-right">
								    		<label>
								    		<input type="radio" class="required radio radio-gateway-item"  name="_gateway" required value="paypal">
								    		<span class=" no-radius btn align-right btn-select " ><span class="default">Select</span><span class="activate">Selected</span></span>
								    		</label>
								    	</div>
								    	<div class="full f-left"></div>
								    </div>
							   	<?php } ?>

								<?php if( $cash->enable ){  $has_payment = 1;?>
								    <div class="col-sm-12  gateway-payment record-line">
								    	<div class="col-sm-9">
								    		<img src="<?php echo get_theme_file_uri('img/cash.png');?>" height="69">
								    		<p>You will checkout via cash method </p>
								    	</div>
								    	<div class="col-sm-3 align-right">
									    	<label>
									    		<input type="radio" class="required radio radio-gateway-item" name="_gateway" required value="cash">
									    		<span class=" no-radius btn align-right btn-select " ><span class="default">Select</span><span class="activate">Selected</span></span>
									    	</label>
								    	</div>
								    	<div class="full f-left"></div>
								    </div>
								    <input type="radio" class="required radio radio-gateway-item" name="_gateway" id="free" required value="free">
								<?php } ?>
							<?php if( !$has_payment){ ?>
								<?php _e('The is not any payment gateways','boxtheme');?>
							<?php } ?>
					    </div>
					</div>
					<div class="form-group">
						<button class="btn f-right no-radius btn-submit disable" type="submit"><?php _e('Check Out','boxtheme');?> </button>
					</div>

				</form>
				<?php } else { ?>
				<?php _e('Please login to buy credit','boxtheme');?>
				<?php }?>
				<!-- PAYPAL FORM !-->

			    <?php
               // $paypal_url = "https://www.sandbox.paypal.com/cgi-bin/webscr";
               // $return     = box_get_static_link('process-payment');
                ?>
               <!--  <div class="col-md-4">
                	<h2> Test PayPal</h2>
                    <form class="paypal" action="<?php // echo $paypal_url; ?>" method="GET" id="paypal_form">
                        <input type="hidden" name="cmd" value="_xclick" />
                        <input type="hidden" name="currency_code" value="USD" />
                        <input type="hidden" name="bn" value="PP-BuyNowBF:btn_buynow_LG.gif:NonHostedGuest" />
                        <input type="hidden" name="first_name" value="Customer's First Name"  />
                        <input type="hidden" name="last_name" value="Customer's Last Name"  />
                        <input type="hidden" name="payer_email" value="freelancer@testing.com"  />
                        <input type="hidden" name="business" value="testing@etteam.com">
                        <input type="hidden" name="item_number" id="item_number" value="123" / >
                        <input type="hidden" name="job_id" id="job_id" value="999" / >
                        <input type="hidden" name="item_name" value="Deposite credit" / >
                        <input type="hidden" name="custom" id="custom_field" value="123">
                        <input type="hidden" name="amount" value="1" / >
                        <input type="hidden" name="return" value="<?php //echo $return?>" / >
                        <input type="hidden" name="cancel_return" value="<?php //echo $return;?>" / >
                        <input type="hidden" name="notify_url" value="<?php //echo $return;?>" / >
                        <input type="submit" name="submit" class="btn btn-green" value="Select"/>
                    </form>
                    <form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">

					  <!- Identify your business so that you can collect the payments. -->

					  <!-- <input type="hidden" name="business" value="wpcodev@gmail.com">
					  <input type="hidden" name="cmd" value="_xclick">
					  <input type="hidden" name="item_name" value="Hot Sauce-12oz. Bottle">
					  <input type="hidden" name="amount" value="5.95">
					  <input type="hidden" name="currency_code" value="USD">
					  <input type="hidden" name="return" value="<?php //echo $return?>" / >
					  <!- Display the payment button.

					  <input type="image" name="submit" border="0"
					  src="https://www.paypalobjects.com/webstatic/en_US/i/btn/png/btn_buynow_107x26.png"
					  alt="Buy Now">
					  <img alt="" border="0" width="1" height="1"
					  src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" >

					</form>
                </div> -->
			    <!-- END PAYPAL !-->

			</div>

		</div>
	</div>
</div>
<style type="text/css">

	.frm-buy-credit{

	}
	.pack-name{
		text-transform: uppercase;
		font-size: 17px;
	}
	.frm-buy-credit h3{
		font-size: 19px;
		background: #eaeaea;
		margin-top: 0;
		line-height: 29px;
		margin-bottom: 0px;
		padding: 6px 10px ;
		text-transform: uppercase;
	}
	.frm-buy-credit h3 span {
    border-radius: 50%;
	    /* width: 20px; */
	    /* height: 20px; */
	    float: left;
	    text-align: center;
	    font-size: 14px;
	    color: #fff;
	    font-weight: bold;
	    line-height: 15px;
	    margin-top: 4px;
	    margin-right: 10px;
	    padding: 2px 6px;
	}
	.frm-buy-credit img{
		background: #fff;
		margin-bottom: 10px;
	}
	input[type=radio]{
		z-index: -1;
	}
	input[type=radio]:checked:after{
		z-index: 1000;
		z-index: 10;
	}
	.pack-detail{
		font-size: 13px;
		font-style: italic;
		padding-bottom: 15px;
	}
	.pack-price{
		font-size: 19px;
	}
	.frm-buy-credit .record-line span.activate{
		display: none;
	}
	.frm-buy-credit .record-line.activate span.activate{
		display: block;
	}
	.frm-buy-credit .record-line.activate span.default{
		display: none;
	}

	.frm-buy-credit .step{
		border: 1px solid #eee;
		overflow: hidden;
		margin-bottom: 15px;
	}
	.frm-buy-credit .step .form-group.row1{
		border: 1px solid #eee;
	}
	.frm-buy-credit .radio{
		position: relative;
		right: -10px;
		top:30px;
		z-index: -1;
		opacity: 1;
	}
	.frm-buy-credit .btn-select{
		background: #ccc;
		padding: 6px 20px;
    	font-style: initial;
    	text-transform: uppercase;
    	min-width: 110px;
	}
	.frm-buy-credit .record-line{
		padding: 15px 0;
	}
	.frm-buy-credit .record-line:first-child{

	}
	.frm-buy-credit .record-line:nth-child(2) .full {
    	border-bottom: 1px solid #ddd;
	}

	.frm-buy-credit .btn-submit {
	    margin-top: 25px;
	    margin-right: 16px;
	    color: #fff;
	    text-transform: uppercase;
	    min-width: 110px;
	}
	.frm-buy-credit .btn-submit.disable{
		background-color: #ccc;
	}
	.selected .record-line{
		display: none;
	}
	.selected .record-line.activate{
		display: block;
	}
</style>
<script type="text/javascript">
	(function($){
		$(document).ready(function(){

		});
	})( jQuery, window.ajaxSend );

</script>
<script type="text/template" id="json_packages"><?php   echo json_encode($packages); ?></script>
<?php get_footer();?>

