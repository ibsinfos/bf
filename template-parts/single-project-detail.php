<?php
	function step_process( $is_workspace ){
		global $project, $access_workspace, $winner_id, $is_dispute;
		$class = $detail_section = $dispute_section = '';
		if( $is_workspace ){
			$class ='current-section';
		} else if( $is_dispute) {
			$dispute_section = 'current-section';
		} else {
			$detail_section = 'current-section';
		}

		if( $access_workspace && in_array( $project->post_status, array('awarded','done','dispute','finish','disputing', 'disputed','archived') ) ) { ?>
	    	<ul class="job-process-heading">
				<li class="<?php echo $detail_section;?>"><a href="<?php echo get_permalink();?>"> <span class="glyphicon glyphicon-list"></span> <?php _e('Job Detail','boxtheme');?></a></li>
				<li class=" text-center <?php echo $class;?>"><a href="?workspace=1"> <span class="glyphicon glyphicon-saved"></span> <?php _e('Workspace','boxtheme');?></a>	</li>
				<li class="text-right <?php echo $dispute_section;?>"><a href="?dispute=1"> <span class="glyphicon glyphicon-saved"></span> <?php _e('Dispute','boxtheme');?></a>	</li>
	    	</ul> <?php
	    }
	}

?>
<div class="full job-content second-font">
<h3> <?php _e('Job details','boxtheme');?> </h3>
<?php
	global $access_workspacem, $is_workspace;

	if( $project->post_status != 'publish' && $access_workspace ) {
		step_process($is_workspace);
	} else {
		box_social_share();
	}
?>

<?php the_content(); ?>
</div>
<?php
global $project;

$args = array(
    'post_status' => 'any',
    'post_type'   => 'attachment',
    'post_parent' => $project->ID,
);
$att_query = new WP_Query( $args );
if( $att_query-> have_posts() ){
    echo '<p>';
    echo '<h3>'.__('Files attach: ','boxtheme').'</h3>';
    $files = array();
    while ( $att_query-> have_posts()  ) {
        global $post;
        $att_query->the_post();
        $feat_image_url = wp_get_attachment_url( $post->ID );
        $files[] = '<span><i class="fa fa-paperclip primary-color" aria-hidden="true"></i>&nbsp;<a class="text-color " href="'.$feat_image_url.'">'.get_the_title().'</a></span> ';
    }
    echo join(",",$files);
    echo '</p>';
}

$terms = get_the_terms( $project, 'skill' );
if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
	echo '<ul class="list-skill">';
	echo '<h3>'.__('Skills Required','boxtheme').'</h3>';
	foreach ( $terms as $term ) {
	  	echo '<li><a href="' . get_term_link($term).'">' . $term->name . '</a></li>';
	}
	echo '</ul>';
}

$cats = get_the_terms( $project, 'project_cat' );
if ( ! empty( $cats ) && ! is_wp_error( $cats ) ){
	echo '<h3 class="sb-heading">'.__('Categories','boxtheme').'</h3>';
	echo '<ul class="list-category none-style inline">';

	foreach ( $cats as $cat ) {
	  echo '<li><a href="' . get_term_link($cat).'">' . $cat->name . '</a></li>';
	}
	echo '</ul>';
}

?>
