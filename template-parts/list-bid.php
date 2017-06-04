<div class="full list-bid">
	<?php
	global $user_ID, $project;
	$paged = isset($_GET['pid']) ? $_GET['pid'] : 1;
	$args = array(
		'post_type' => BID,
		'post_parent' => $project->ID,
		'paged' => $paged,
	);

	$query = new WP_Query($args);
	//show_conversation($user_ID, $project->ID);
	?>
	<div class="col-md-5 no-padding">
		<h3><?php printf(__('List bid (%s)','boxtheme'), $query->found_posts); ?></h3>
	</div>
	<div class="col-md-5 f-right no-padding">
		<select class="f-right">
			<option>Filter by</option>
			<option>Date</option>
			<option>Price</option>
			<option>Rating</option>
		</select>
	</div>
	<?php
	if( $query->have_posts() ) :
		while( $query->have_posts() ):
			$query->the_post();
			get_template_part( 'template-parts/bid', 'loop' );
		endwhile;

		$projet_link = get_the_permalink($project->ID);
		bx_pagenate($query, array('base'=>$projet_link), 1, 1 );
		wp_reset_query();
	else:
		echo '<div class="col-md-12 no-padding">';
			_e('There is not any bid yet.','boxtheme');
		echo '</div>';
	endif;
	?>
</div>