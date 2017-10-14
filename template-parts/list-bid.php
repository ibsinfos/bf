<div class="full list-bid">
	<?php
	global $user_ID, $project, $list_bid, $bid_query;
	?>
	<div class="list-bid-heading">
		<div class="col-md-5 no-padding">
			<h3><?php printf(__('Total Bid(s): %s','boxtheme'), $bid_query->found_posts); ?></h3>
		</div>
		<div class="col-bid_query-6 f-right no-padding hide">
			<?php if( $bid_query->found_posts > 1) { ?>
			<div class="dropdown f-right sort-bids">
				<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown"><?php _e('Order by','boxtheme');?>
				<span class="caret"></span></button>
				<ul class="dropdown-menu">
					<li><a href="#"><?php _e('Filter by','boxtheme');?></a></li>
					<li><a href="#"><?php _e('Date','boxtheme');?></a></li>
					<li><a href="#"><?php _e('Price','boxtheme');?></a></li>
					<li><a href="#"><?php _e('Rating','boxtheme');?></a></li>
				</ul>
			</div>
			<?php } ?>
		</div>
	</div>
	<?php
	global $cms_setting;
	$cms_setting = get_commision_setting();

	if( $bid_query->have_posts() ) :
		while( $bid_query->have_posts() ):
			$bid_query->the_post();
			get_template_part( 'template-parts/bid', 'loop' );
			//$list_bid[] = $post;
		endwhile;

		$projet_link = get_the_permalink($project->ID);
		//bx_pagenate( $bid_query, array('base'=>$projet_link), 1, 1 );
		wp_reset_query();
	else:
		echo '<div class="col-md-12 no-padding">';
			_e('There is no any bid yet.','boxtheme');
		echo '</div>';
	endif;
	?>
</div>