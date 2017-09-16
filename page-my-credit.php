<?php
/**
 *	Template Name: Credit system
 */
?>
<?php get_header(); ?>

<div class="full-width">

	<div class="container site-container">
<?php

global $user_ID;
$bank_account = (OBJECT) array('account_name' => '', 'account_number' => '', 'bank_name'=>'' );

$ins_credit = BX_Credit::get_instance();
$credit = $ins_credit->get_ballance($user_ID);
$withdraw_info = $ins_credit->get_withdraw_info($user_ID);
$paypal_email= $account_number = '';

if( ! empty ($withdraw_info->paypal_email) )
	$paypal_email = $withdraw_info->paypal_email;
if( ! empty ($withdraw_info->bank_account) ){
	$bank_account = (object) $withdraw_info->bank_account;
	if( ! empty( $bank_account->account_number ) )
		$account_number = $bank_account->account_number;
}
// echo '<pre>';
// var_dump($withdraw_info);
// echo phpversion();
// echo '</pre>';
?>

		<div  id="content" class="site-content page-credit">

			<div class="col-md-12 line-item">
				<div class="form-group"><h3><?php _e('Your credit info','boxtheme');?></h3></div>
			  		<div class="col-md-6"><?php printf(__('Avaibale: %s','boxtheme'), box_get_price($credit->available) );?></div>
			  		<div class="col-md-6">
			  			<div class="col-md-12"> <a class="btn btn-radius btn-buy-credit" href="<?php echo home_url('buy-credit');?>"><?php _e('Buy Credit','boxtheme');?> </a></div>
			  		</div>
			</div>

			<div class="col-md-12 line-item">
				<ul class="nav nav-tabs">
				  <li class="active"><a href="#withdraw"><?php _e('Widthdraw','boxtheme');?></a></li>
				  <li><a href="#paypal" href="#"><?php _e('PayPal','boxtheme');?></a></li>
				  <li><a href="#bank_info"><?php _e('Bank account','boxtheme');?></a></li>
				</ul>
				<div class="tab-content">
					<div id="withdraw" class="tab-content-item">
						<?php

						if( $credit->available > 30  ){
							if(  empty( $paypal_email ) && empty($account_number)  ){
								echo '<p>&nbsp;</p>';
								_e(' Please setup paypal email or bank account to widthdraw','boxtheme');
							} else {?>
								<form id="frm_withdraw" class="">
									<div class="form-group">
										<label for="withdraw_amout"><?php _e('Amout','boxtheme');?></label>
										<input type="number" class="form-control required" required id="withdraw_amout" name="withdraw_amout" aria-describedby="withdraw_amout" placeholder="<?php _e('How much you want to withdraw?','boxtheme');?>">
									</div>
									<div class="form-group">
										<label for="withdraw_type"><?php _e('Select Method','boxtheme');?></label>
										<select class="form-control required" required name="withdraw_method">
											<?php if( !empty( $paypal_email ) ) { ?>
												<option value="paypal_email"> PayPal</option>
											<?php } ?>
											<?php if( !empty( $account_number ) ) { ?>
												<option value="bank_account"> Bank Account</option>
											<?php } ?>

										</select>
									</div>
									<div class="form-group">
										<label for="withdraw_type"><?php _e('Note','boxtheme');?></label>
										<textarea class="form-control" name="withdraw_note" required></textarea>
										<small>Add your phone or note some tips to help admin easy to transfer money to you.</small>
									</div>
									<button type="submit" class="btn btn-primary"><?php _e('Send request','boxtheme');?></button>
								</form>
							<?php } ?>
						<?php } else {?>
							<p></p>
							<?php _e('Your ballance is not enough to withdraw','boxtheme');?>
						<?php } ?>
					</div>
					<div id="paypal" class="tab-content-item hidding">
						<form id="frm_paypal" class="withdraw-info">
							<div class="form-group">
								<label for="paypal_email"><?php _e('PayPal Email','boxtheme');?></label>
								<input type="text" class="form-control required" id="paypal_email" name="paypal_email" required aria-describedby="paypal_email" value="<?php echo $paypal_email;?>" placeholder="<?php _e('Your PayPal Email','boxtheme');?>">
							</div>
							<button type="submit" class="btn btn-primary"><?php _e('Save','boxtheme');?></button>
						</form>
					</div>

					<div id="bank_info" class=" tab-content-item hidding">
						<form id="frm_bank_info" class="withdraw-info">
							<div class="form-group"><h3><?php _e('Setup your bank account','boxtheme');?> </h3></div>
							<div class="form-group">
								<label for="account_name"><?php _e('Name on account','boxtheme');?></label>
								<input type="text" class="form-control required" id="account_name" required name="account_name" aria-describedby="account_name" value="<?php echo $bank_account->account_name;?>" placeholder="<?php _e('Name on account','boxtheme');?>">
								<small id="emailHelp" class="form-text text-muted"><?php _e('Your bank account name','boxtheme');?></small>
							</div>
							<div class="form-group">
								<label for="account_number"><?php _e('Account number or IBAN','boxtheme');?></label>
								<input type="text" class="form-control required" required id="account_number" name="account_number" value="<?php echo $bank_account->account_number;?>" aria-describedby="" placeholder="<?php _e('Account number or IBAN','boxtheme');?>">
							</div>

							<div class="form-group">
								<label for="exampleInputPassword1"><?php _e('Bank name','boxtheme');?></label>
								<input type="text" class="form-control required" id="bank_name" name="bank_name" value="<?php echo $bank_account->bank_name;?>" placeholder="Bank name">
							</div>
							<button type="submit" class="btn btn-primary"><?php _e('Save','boxtheme');?></button>
						</form>
					</div>
				</div>


			</div>

			<div id="profile" class="col-md-12 line-item history-order-section"> <!-- start left !-->

			     <?php get_template_part( 'template-parts/dashboard/list', 'order' ); ?>
			</div> <!-- end left !-->
		</div>

	</div>
</div>
<?php get_footer();?>
<style type="text/css">
	.site-content{
		background-color: transparent;
	}
	.line-item{
		background: #fff;
		border:3px solid #e6e6e6;
		margin-bottom: 25px;
		padding-top:30px;
		padding-bottom: 30px;
		padding-left: 30px;
		padding-right: 30px;
	}
	.site-content{
		padding-top: 0;
	}
	.tab-content-item{
		min-height: 299px;
	}
	.tab-content-item form{
		padding: 25px 15px;
		border:1px solid #ddd;
		border-top: 0;
	}
	.tab-withdraw{}
	.tab-content .hidding{
		visibility: hidden;
		display: none;
	}
	.page-credit .nav-tabs>li>a{
		border-radius: 0;
	}
	@media only screen and (max-width: 768px) {
		.line-item{
			padding-left: 10px;
			padding-right: 10px;
			border: 0;
			border-bottom: 1px solid #ccc;
			padding-top: 0;
		}
		.page-credit .nav-tabs > li > a{
			padding-left: 10px;
			padding-right: 10px;
		}
		.history-order{
			border: 0;
		}

		.history-order .line-heading .col-xs-5,
		.history-order .row-order-item .col-xs-5{
			padding-left: 0;
			padding-right: 0;
		}
		.tab-content-item{
			min-height: 0;
		}
		.tab-content-item form{
			border: 0;
			padding-left: 0;
			padding-right: 0;
		}
		.custom-res h5{
			margin-left: -15px;
		    font-weight: normal;
		    font-size: 16px;

		}
	}
</style>
<script type="text/javascript">
	(function($){
		$(document).ready(function(){
			console.log('123');
			$(".nav-tabs a").click(function(event){
				$(".nav-tabs li").removeClass('active');
				var _this = $(event.currentTarget);
				_this.closest("li").addClass('active');
				var section = _this.attr('href');
				$(".tab-content-item").addClass('hidding');
				$(section).removeClass('hidding');
				return false;4
			});

		})

	})(jQuery);
</script>
