<?php
/**
 *	Template Name: Dashboard System Of User
 */
?>
<?php get_header(); ?>
<div class="full-width">
	<div class="container site-container">
		<div class="row site-content" id="content" >
			<div id="profile" class="col-md-8"> <!-- start left !-->
				<ul  class="nav nav-pills">
					<li class="active">        	<a  href="#1a" data-toggle="tab">List project</a>			</li>
					<li><a href="#tab_credit" data-toggle="tab">Credit</a>		</li>

				</ul>

				<div class="tab-content clearfix">
					<div class="tab-pane active" id="1a">
			          	<h3> List job </h3>
			          	<?php
			          		global $user_ID;
			          		$args = array(
			          			'post_status' => 'publish',
			          			'post_type' => 'project',
			          			'author'=> $user_ID,
			          		);
			          		$query = new WP_Query($args);

			          		if( $query-> have_posts() ){
			          			echo '<ul>';
			          			while ($query->have_posts()) {
			          				$query->the_post();
			          				echo '<li>';
			          				the_title();
			          				echo '</li>';
			          			}
			          			echo '</ul>';
			          		}
			          	?>
					</div>

			        <div class="tab-pane" id="tab_credit">

			          	<?php
			          	$credit = BX_Credit::get_instance()->get_ballance($current_user->ID);
			          	?>
			          	<ul>
			          		<li><?php printf(__('Your credit available: %s','boxtheme'),$credit->available);?></li>
			          		<li><?php printf(__('Your credit pending: %s','boxtheme'),$credit->pending);?></li>
			          		<li><a href="<?php echo home_url('buy-credit');?>">Buy Credit </a></li>
			          	</ul>
			          	<h5> History </h5>
			          	<ul>
			          		<li> Withdraw 1 </li>
			          		<li> Apr 15/2016 deposit 200 $</li>
			          		<li> Apr 10/2016 withdraw  100 $</li>
			          	</ul>

					</div>

				</div>
			</div> <!-- end left !-->
			<div class="col-md-4">
				<?php get_sidebar('dashboard');?>
			</div>

		</div>
	</div>
</div>
<?php get_footer();?>

