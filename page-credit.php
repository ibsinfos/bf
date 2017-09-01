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
		<div  id="content" class="site-content">

			<div class="col-md-12 line-item">
				<div class="form-group"><h3> Your credit info</h3></div>
				<ul class="none-style padding-bottom-20">
			  		<li><?php printf(__('Avaibale: %s','boxtheme'),$credit->available);?></li>
			  		<?php if( $credit->pending > 0 ) { ?>
			  			<li><?php printf(__('Your pending credit: %s','boxtheme'),$credit->pending);?></li>
			  		<?php } ?>
			  		<li><a class="btn btn-radius btn-buy-credit" href="<?php echo home_url('buy-credit');?>"><?php _e('Buy Credit','boxtheme');?> </a></li>
			  	</ul>
			</div>

			<div class="col-md-12 line-item">
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
	}
	.site-content{
		padding-top: 0;
	}
</style>

