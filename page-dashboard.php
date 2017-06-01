<?php
/**
 *	Template Name: Dashboard System Of User
 */
?>
<?php get_header(); ?>
<div class="full-width">
	<div class="container site-container">
		<div class="row site-content" id="content" >
			<div id="profile" class="col-md-12"> <!-- start left !-->
				<ul  class="nav nav-pills" id ="heading_dashboard">
					<li class="active"><a  href="#1a" data-toggle="tab">List project</a>			</li>
					<li><a href="#tab_credit" data-toggle="tab">Credit</a>		</li>

				</ul>

				<div class="tab-content clearfix">
					<div class="tab-pane active" id="1a">
			          	<?php
			          		global $user_ID;
			          		$args = array(
			          			'post_status' => 'publish',
			          			'post_type' => 'project',
			          			'author'=> $user_ID,
			          		);
			          		$query = new WP_Query($args);
			          		$loadmore = false;
			          		if( $query-> have_posts() ){
			          			$loadmore = true;
			          			echo '<ul class="db-list-project">';
			          			echo '<li class="heading row list-style-none padding-bottom-10">';
				          				echo '<div class ="col-md-7">';
				          				_e('Project Title','boxtheme');
				          				echo '</div>';
				          				echo '<div class ="col-md-3">';
				          				_e('Price','boxtheme');
				          				echo '</div>';
				          				echo '<div class ="col-md-2">';
				          				_e('Posted date','boxtheme');
				          				echo '</div>';
			          				echo '</li>';

			          			while ($query->have_posts()) {
			          				global $post;
			          				$query->the_post();
			          				$project = BX_Project::get_instance()->convert($post);
			          				echo '<li class="row list-style-none padding-bottom-10">';
				          				echo '<div class ="col-md-7">';
				          				echo '<a href="'.get_permalink().'">'. get_the_title().'</a>';
				          				echo '</div>';
				          				echo '<div class ="col-md-3">';
				          				box_price($project->_budget);
				          				echo '</div>';
				          				echo '<div class ="col-md-2">';	echo get_the_date();	echo '</div>';
			          				echo '</li>';
			          			}
			          			if($loadmore){
			          				echo '<li class="row list-style-none padding-bottom-10"><center> <button class="load-more" page ="1">Load more</button> </center></li>';
			          			}
			          			echo '</ul>';
			          		}
			          	?>
					</div>

			        <div class="tab-pane" id="tab_credit">

			          	<?php
			          	$credit = BX_Credit::get_instance()->get_ballance($current_user->ID);
			          	?>
			          	<ul class="row none-style padding-bottom-20">
			          		<li><?php printf(__('Your credit available: %s','boxtheme'),$credit->available);?></li>
			          		<li class="hide"><?php printf(__('Your credit pending: %s','boxtheme'),$credit->pending);?></li>
			          		<li><a class="btn btn-buy-credit" href="<?php echo home_url('buy-credit');?>">Buy Credit </a></li>
			          	</ul>
			          	<h5> History </h5>
			          	<ul class="none-style row">
			          		<li>
			          			<div class="col-md-2">Date </div>
			          			<div class="col-md-2">Type </div>
			          			<div class="col-md-2">Payment </div>
			          			<div class="col-md-2">Status </div>
			          			<div class="col-md-2">Balance </div>
			          			<div class="col-md-2">Actions </div>
			          		</li>
			          		<?php
			          		// query order of this user.
			          		$args = array(
			          			'post_type' =>'_order',
			          			'post_status' => array('pending','publish'),
			          			'post_type' =>'_order',
			          			'author' => $user_ID,
			          			'posts_per_page' => -1,
			          		);
			          		$query = new WP_Query($args);
			          		if( $query->have_posts() ){
			          			while ( $query->have_posts() ) {
			          				$check = '(+)';

			          				global $post;
			          				$query->the_post();
			          				$order = BX_Order::get_instance()->get_order($post);
			          				if($order->order_type == 'withdraw')
			          					$check = '(-)';
			          				?>
			          				<div class="col-md-2"><?php echo get_the_date();?> </div>
			          				<div class="col-md-2"><?php echo $order->order_type;?> </div>
				          			<div class="col-md-2"><?php echo $order->payment_type;?> </div>
				          			<div class="col-md-2"><?php echo $order->post_status;?> </div>
				          			<div class="col-md-2"><?php echo $order->amout . $check;?>  </div>
				          			<div class="col-md-2"><button>Arhive</button> </div>
			          				<?php
			          			}
			          		}
			          		?>
			          	</ul>

					</div>

				</div>
			</div> <!-- end left !-->

		</div>
	</div>
</div>
<?php get_footer();?>

