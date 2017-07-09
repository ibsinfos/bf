<?php
/**
 *Template Name: Buy credit
 */
?>
<?php get_header(); ?>
<div class="full-width">
	<div class="container site-container">
		<div class="row site-content" id="content" >
			<div class="col-md-8 col-sm-offset-2">
				<?php the_post(); ?>
				<h1><?php the_title();?></h1>
				<?php if( is_user_logged_in() ){ ?>
				<form class="frm-buy-credit">
					<div class="step step-1">
						<div class="form-group">
						    <h3  class="col-sm-12 col-form-label"><span class="bg-color">1</span> Select your package</h3>
					    	<?php
					    	 $args = array(
	                            'post_type' => '_package',
	                            'meta_key' => 'type',
	                            'meta_value' => 'buy_credit'
	                        );
	                        $the_query = new WP_Query($args);

	                        // The Loop
	                        if ( $the_query->have_posts() ) {
	                        	 while ( $the_query->have_posts() ) {
	                                $the_query->the_post();
	                                $price = get_post_meta(get_the_ID(),'price', true);			                                //echo $price;
	                                $sku = get_post_meta(get_the_ID(),'sku', true);
	                                ?>
	                                <div class="col-sm-12  package-plan record-line">
								    	<div class="col-sm-9">
								    		<h4> <?php echo $price;?>$ </h4>

								    		<p><?php echo get_the_content(); ?></p>
								    	</div>
								    	<div class="col-sm-3 align-right">
									    	<label>
									    		<input type="radio" class="required radio" value="<?php echo get_the_ID();?>"  name="package_id" required >
									    		<span class=" no-radius btn align-right btn-select " ><?php _e('Select','boxtheme');?></span>
									    	</label>
								    	</div>
								    	<div class="full f-left"></div>
								    </div>
	                                <?php

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
						    <h3  class="col-sm-12 col-form-label"><span class="bg-color">2</span> Select your payment gateway</h3>
						    <?php
						    	global $has_payment;
						    	$has_payment= 0;
							    $option = BX_Option::get_instance();
						        $payment = $option->get_group_option('payment');
						        $paypal = array();
						        $cash =  array();

						        if(isset($payment['paypal']))
						        	$paypal = (object)$payment['paypal'];

						        if( isset($payment['cash']) )
						        	$cash = (object)$payment['cash'];

						        if( !empty($paypal) && $paypal->enable ) { 	$has_payment= 1;
							 		?>
								    <div class="col-sm-12  gateway-payment  record-line"">
								    	<div class="col-sm-9">
								    		<img src="<?php echo get_theme_file_uri('img/PayPal.jpg');?>" width="200">
								    		<p>You will pay via paypal payment </p>

								    	</div>
								    	<div class="col-sm-3 align-right">
								    		<label>
								    		<input type="radio" class="required radio"  name="_gateway" required value="paypal">
								    		<span class=" no-radius btn align-right btn-select " >Select</span>
								    		</label>
								    	</div>
								    	<div class="full f-left"></div>
								    </div>
							   	<?php } ?>

								<?php if( !empty($cash) &&  $cash->enable ){  $has_payment = 1;?>
								    <div class="col-sm-12  gateway-payment record-line">
								    	<div class="col-sm-9">
								    		<img src="<?php echo get_theme_file_uri('img/cash.png');?>" height="69">
								    		<p>You will pay via cash method </p>
								    	</div>
								    	<div class="col-sm-3 align-right">
									    	<label>
									    		<input type="radio" class="required radio" name="_gateway" required value="cash">
									    		<span class=" no-radius btn align-right btn-select " >Select</span>
									    	</label>
								    	</div>
								    	<div class="full f-left"></div>
								    </div>
								<?php } ?>
							<?php if( !$has_payment){ ?>
								<?php _e('The is not any payment gateways','boxtheme');?>
							<?php } ?>
					    </div>
					</div>
					<div class="form-group">
						<button class="btn f-right no-radius btn-submit" type="submit"><?php _e('Buy Credit','boxtheme');?> </button>
					</div>

				</form>
				<?php } else { ?>
				<?php _e('Please login to buy credit','boxtheme');?>
				<?php }?>
				<!-- PAYPAL FORM !-->
				<!--
			    <?php
                $paypal_url = "https://www.sandbox.paypal.com/cgi-bin/webscr";
                $return     = bx_get_static_link('process-payment');
                ?>
                <div class="col-md-4">
                    <form class="paypal" action="<?php echo $paypal_url; ?>" method="GET" id="paypal_form">
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
                        <input type="hidden" name="return" value="<?php echo $return?>" / >
                        <input type="hidden" name="cancel_return" value="<?php echo $return;?>" / >
                        <input type="hidden" name="notify_url" value="<?php echo $return;?>" / >
                        <input type="submit" name="submit" class="btn btn-green" value="Select"/>
                    </form>
			    <!-- END PAYPAL !-->

			</div>

		</div>
	</div>
</div>
<style type="text/css">

	.frm-buy-credit{

	}
	.frm-buy-credit h3{
		font-size: 21px;
		background: #eaeaea;
		margin-top: 0;
		line-height: 29px;
		margin-bottom: 20px;
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
	}
	input[type=radio]{
		z-index: -1;
	}
	input[type=radio]:checked:after{
		z-index: 1000;
		z-index: 10;
	}
	.frm-buy-credit .record-line.activate .btn-select{
		background: #00a200;
		color: #fff;
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
	}
	.frm-buy-credit .record-line{
		padding-bottom: 10px;
	}
	.frm-buy-credit .record-line .col-sm-3 label{
		sfloat: right;
	}
	.frm-buy-credit .record-line:first-child{

	}
	.frm-buy-credit .record-line:nth-child(2) .full {
    	border-bottom: 1px solid #ddd;
	}
	.frm-buy-credit .btn-submit{
		margin-top: 25px;
		margin-right: 29px;
		color: #fff;
		text-transform: uppercase;
	}
</style>
<script type="text/javascript">
	(function($){
		$(document).ready(function(){
			$(".btn-select").click(function(event){
				var _this = $(event.currentTarget);

				_this.closest('.step').find('.record-line').removeClass('activate');
				_this.closest('.record-line').addClass('activate');


				// $(".btn-select").removeClass('activate');
				// _this.addClass('activate');
			});
		});
	})( jQuery, window.ajaxSend );

</script>

<?php get_footer();?>

