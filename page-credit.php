<?php
/**
 *	Template Name: Credit system
 */
?>
<?php get_header(); ?>
<?php
global $user_ID;
$credit = BX_Credit::get_instance()->get_ballance($user_ID);
?>
<div class="full-width">
	<div class="container site-container">
		<div  id="content" class="site-content page-credit">

			<div class="col-md-12 line-item">
				<div class="form-group"><h3> Your credit info</h3></div>
			  		<div class="col-md-6"><?php printf(__('Avaibale: %s','boxtheme'),$credit->available);?></div>
			  		<div class="col-md-6">
			  			<div class="col-md-12"> <a class="btn btn-radius btn-buy-credit" href="<?php echo home_url('buy-credit');?>"><?php _e('Buy Credit','boxtheme');?> </a></div>
			  		</div>
			</div>

			<div class="col-md-12 line-item">
				<ul class="nav nav-tabs">
				  <li class="active"><a href="#withdraw">Widthdraw</a></li>
				  <li><a href="#paypal" href="#">PayPal</a></li>
				  <li><a href="#bank_info"> Bank account</a></li>
				</ul>
				<div class="tab-content">
					<div id="withdraw" class="tab-content-item">
						<form id="frm_withdraw">
							<div class="form-group">
								<label for="withdraw_amout"><?php _e('Amout','boxtheme');?></label>
								<input type="number" class="form-control required" required id="withdraw_amout" name="withdraw_amout" aria-describedby="withdraw_amout" placeholder="<?php _e('How much you want to withdraw?','boxtheme');?>">
								<small id="withdraw_amout" class="form-text text-muted"><?php _e('Your bank account name','boxtheme');?></small>
							</div>
							<div class="form-group">
								<label for="withdraw_type"><?php _e('Select type','boxtheme');?></label>
								<select class="form-control" name="withdraw_type">
									<option value="paypal"> PayPal</option>
									<option value="banking"> Bank Account</option>
								</select>
							</div>
							<button type="submit" class="btn btn-primary"><?php _e('Send request','boxtheme');?></button>
						</form>
					</div>
					<div id="paypal" class="tab-content-item hidding">
						<form>

							<div class="form-group">
								<label for="account_name"><?php _e('PayPal Email','boxtheme');?></label>
								<input type="text" class="form-control" id="account_name" name="account_name" aria-describedby="account_name" placeholder="<?php _e('Name on account','boxtheme');?>">
								<small id="emailHelp" class="form-text text-muted"><?php _e('Your bank account name','boxtheme');?></small>
							</div>
							<button type="submit" class="btn btn-primary"><?php _e('Send request','boxtheme');?></button>
						</form>
					</div>

					<div id="bank_info" class=" tab-content-item hidding">
						<form>
							<div class="form-group"><h3><?php _e('Setup your bank account','boxtheme');?> </h3></div>
							<div class="form-group">
								<label for="account_name"><?php _e('Name on account','boxtheme');?></label>
								<input type="text" class="form-control" id="account_name" name="account_name" aria-describedby="account_name" placeholder="<?php _e('Name on account','boxtheme');?>">
								<small id="emailHelp" class="form-text text-muted"><?php _e('Your bank account name','boxtheme');?></small>
							</div>
							<div class="form-group">
								<label for="account_number"><?php _e('Account number or IBAN','boxtheme');?></label>
								<input type="text" class="form-control" id="account_number" aria-describedby="" placeholder="<?php _e('Account number or IBAN','boxtheme');?>">
							</div>

							<div class="form-group">
								<label for="exampleInputPassword1"><?php _e('Bank name','boxtheme');?></label>
								<input type="text" class="form-control" id="bank_name" name="bank_name" placeholder="Bank name">
							</div>
							<div class="form-group">
								<label for="note"><?php _e('Note','boxtheme');?></label>
								<textarea  class="form-control" name="note" placeholder="Add your note"></textarea>
								<small id="noteHelp" class="form-text text-muted">Add your phone or note some tips to help admin easy to transfer money to your bank account.</small>
							</div>

							<button type="submit" class="btn btn-primary"><?php _e('Save','boxtheme');?></button>
						</form>
					</div>
				</div>


			</div>

			<div id="profile" class="col-md-12 line-item"> <!-- start left !-->
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
