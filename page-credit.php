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
					<div class="form-group"><h3> Setup your bank account </h3></div>
					<div class="form-group">
						<label for="exampleInputEmail1">Name on account</label>
						<input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
						<small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
					</div>
					<div class="form-group">
						<label for="exampleInputEmail1">Account number or IBAN</label>
						<input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
						<small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
					</div>

					<div class="form-group">
						<label for="exampleInputPassword1">Bank name</label>
						<input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
					</div>
					<div class="form-group">
						<label for="exampleInputPassword1">Note</label>
						<textarea  class="form-control" name="note" placeholder="Add your note"></textarea>
						<small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
					</div>

					<button type="submit" class="btn btn-primary">Submit</button>
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
</style>

