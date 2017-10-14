<?php
	global $user_ID;
	$args = array(
		'post_status' => 'publish',
		'post_type' => 'project',
		'author'=> $user_ID,
		'posts_per_page' => -1,
	);
	$query = new WP_Query($args);
	$loadmore = false;
	if( $query-> have_posts() ){
		$loadmore = true;
		echo '<ul class="db-list-project">';
		echo '<li class="heading list-style-none padding-bottom-10">';
				echo '<div class ="col-md-4">';				_e('Project Title','boxtheme');				echo '</div>';
				echo '<div class ="col-md-2">';				_e('Bid(s)','boxtheme');				echo '</div>';
				echo '<div class ="col-md-2">';				_e('Price','boxtheme');				echo '</div>';
				echo '<div class ="col-md-2">'; _e('Posted date','boxtheme');echo '</div>';
				echo '<div class ="col-md-1 text-center pull-right">'; _e('Action','boxtheme');echo '</div>';
			echo '</li>';

		while ($query->have_posts()) {
			global $post;
			$query->the_post();
			$project = BX_Project::get_instance()->convert($post);
			echo '<li class="list-style-none padding-bottom-10">';
				echo '<div class ="col-md-4">';	echo '<a href="'.get_permalink().'">'. get_the_title().'</a>';	echo '</div>';
				echo '<div class ="col-md-2">';				echo count_bids($post->ID);	echo '</div>';
				echo '<div class ="col-md-2">';				box_price($project->_budget);echo '</div>';
				echo '<div class ="col-md-2">';	echo get_the_date();	echo '</div>';
				?>
				<div class ="col-md-1 pull-right text-center"><a href="#" class="btn-board btn-archived-job" id="<?php echo $project->ID;?>"  data-toggle="tooltip" title="<?php printf(__('Archived %s','boxtheme'), $project->post_titile);?>"><i class="fa fa-trash-o" aria-hidden="true"></i></a> <?php
			echo '</li>';
		}
		// if($loadmore){
		// 	echo '<li class="row list-style-none padding-bottom-10"><center> <button class="load-more" page ="1">Load more</button> </center></li>';
		// }
		echo '</ul>';
	}
?>