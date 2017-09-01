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
		<div  id="content" class="row site-content">

			<div class="col-md-12">
				<ul class="none-style padding-bottom-20">
			  		<li><?php printf(__('Your credit: %s','boxtheme'),$credit->available);?></li>
			  		<?php if($credit->pending > 0){ ?>
			  			<li><?php printf(__('Your pending credit: %s','boxtheme'),$credit->pending);?></li>
			  		<?php } ?>
			  		<li><a class="btn btn-radius btn-buy-credit" href="<?php echo home_url('buy-credit');?>"><?php _e('Buy Credit','boxtheme');?> </a></li>
			  	</ul>
			</div>

			<div class="col-md-12">
				<form>
					<div class="form-group"><h3> Widrawal request </h3></div>
					<div class="form-group">
						<label for="exampleInputEmail1">Email address</label>
						<input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
						<small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
					</div>
					<div class="form-group">
						<label for="exampleInputPassword1">Password</label>
						<input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
					</div>

					<button type="submit" class="btn btn-primary">Submit</button>
				</form>
			</div>

			<div id="profile" class="col-md-12"> <!-- start left !-->
			     <?php get_template_part( 'template-parts/dashboard/list', 'order' ); ?>
			</div> <!-- end left !-->
		</div>

	</div>
</div>
<?php get_footer();?>

