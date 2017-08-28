<?php
	global $user_ID;
	$args = array(
		'post_status' => 'archived',
		'post_type' => 'project',
		'author'=> $user_ID,
		'posts_per_page' => -1,
	);
	$query = new WP_Query($args);
	$loadmore = false;
	$submit_url = bx_get_static_link("post-project");
	if( $query-> have_posts() ){
		$loadmore = true;
		echo '<ul class="db-list-project">';
		echo '<li class="heading row list-style-none padding-bottom-10">';
				echo '<div class ="col-md-4">';				_e('Project Title','boxtheme');				echo '</div>';
				echo '<div class ="col-md-2">';				_e('Bid(s)','boxtheme');				echo '</div>';
				echo '<div class ="col-md-2">';				_e('Price','boxtheme');				echo '</div>';
				echo '<div class ="col-md-2">'; _e('Posted date','boxtheme');echo '</div>';
				echo '<div class ="col-md-2">'; _e('Action','boxtheme');echo '</div>';
			echo '</li>';

		while ($query->have_posts()) {
			global $post;
			$query->the_post();
			$project = BX_Project::get_instance()->convert($post);
			$new_url = add_query_arg( array('p_id'=>$post->ID), $submit_url ) ;
			echo '<li class="row list-style-none padding-bottom-10">';
				echo '<div class ="col-md-4">';				echo '<a href="'.get_permalink().'">'. get_the_title().'</a>';				echo '</div>';
				echo '<div class ="col-md-2">';				echo count_bids($post->ID);				echo '</div>';
				echo '<div class ="col-md-2">';				box_price($project->_budget);				echo '</div>';
				echo '<div class ="col-md-2">';	echo get_the_date();	echo '</div>';
				?><div class ="col-md-2"><a href="#" class="btn-delete-job"   data-toggle="tooltip"  title="<?php _e('Delete this job','boxtheme');?>" id ="<?php echo $project->ID;?>"><span class="glyphicon glyphicon-remove"></span></a> <a  data-toggle="tooltip" title= "Renew this job" href="<?php echo $new_url;?>"><span class="glyphicon glyphicon-refresh"></span></a> </div> <?php
			echo '</li>';
		}
		// if($loadmore){
		// 	echo '<li class="row list-style-none padding-bottom-10"><center> <button class="load-more" page ="1">Load more</button> </center></li>';
		// }
		echo '</ul>';
	}
?>