<div class="col-md-8">
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
</div>

<div class="col-md-8 list-bid">
	<h3><?php printf(__('List bid (%s)','boxtheme'), $query->found_posts); ?></h3>
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
		_e('There is not any bid yet.','boxtheme');
	endif;
	?>
</div>