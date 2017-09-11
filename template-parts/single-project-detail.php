<h3> <?php _e('Job details','boxtheme');?> </h3>
<?php the_content(); ?>
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
        $files[] = '<span><span class="glyphicon glyphicon-paperclip primary-color"></span>&nbsp;<a class="text-color " href="'.$feat_image_url.'">'.get_the_title().'</a></span> ';
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
