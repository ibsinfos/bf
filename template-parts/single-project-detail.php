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
?>