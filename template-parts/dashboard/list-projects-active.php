<?php
/**
 * be included in page-dashboard and list all bidded of current Employer
 * Only available for Employer or Admin account.
**/

	global $user_ID;

	//$status = isset( $_GET['status'] ) ? $_GET['status'] : 'any';
	$status = isset( $_GET['status'] ) ? $_GET['status'] : array('publish','pending','disputing','resolved','done','awarded');
	$loadmore = false;
	$link =  box_get_static_link('dashboard');
	$check = $status;
	if( is_array($status) )
		$check = 'any';

	?>

<ul class="db-list-project ul-list-project" id="ul-active">
	<?php
		$args = array(
		'post_type' => 'project',
		'author'=> $user_ID,
		'posts_per_page' => -1,
		'post_status' => 'publish',
	);
	$query = new WP_Query($args);
	?>
	<li class="heading heading-table list-style-none padding-bottom-10">
		<div class ="col-md-5"> <?php _e('JOB TITLE','boxtheme'); ?></div>
		<div class ="col-md-2"><?php _e('PROPOSALS','boxtheme'); ?></div>
		<div class ="col-md-3"><?php _e('DATE POSTED','boxtheme'); ?></div>
		<div class ="col-md-2 text-center pull-right"></div>
	</li>
	<?php
	if( $query-> have_posts() ){
		while ($query->have_posts()) {
			$link  = get_the_permalink( );
			$ws_link = add_query_arg( 'workspace',1,$link );
			global $post;
			$query->the_post();
			$project = BX_Project::get_instance()->convert($post);
			echo '<li class="list-style-none padding-bottom-10">';
				echo '<div class ="col-md-5">';	echo '<a class="primary-color" href="'.get_permalink().'">'. get_the_title().'</a>';	echo '</div>';
				echo '<div class ="col-md-2">';echo count_bids($post->ID);	echo '</div>';
				echo '<div class ="col-md-3">';	echo get_the_date();	echo '</div>';	?>
				<div class ="col-md-2 pull-right text-center">
					<a href="<?php echo $ws_link;?>" class="btn">Details</a>
				</div>

			</li><?php		}
	} else { ?>
		<li class="col-md-12" style="padding-top: 20px; list-style:none">
			<?php _e('This query is empty','boxtheme'); ?>
		</li> <?php
	}
	wp_reset_query(); ?>
</ul>