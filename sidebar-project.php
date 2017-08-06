<?php
global $user_ID, $project, $is_owner, $access_workspace, $is_workspace, $winner_id, $class_bidded, $bidding;
function show_bid_buton($post){
	$back_url = add_query_arg( 'redirect', get_the_permalink($post->ID), bx_get_static_link('login') );
	echo '<a class ="btn btn-login" href ="'.$back_url.'">'.__('Login to bid','boxtheme').'</a>';
}
if ( is_user_logged_in() ) {

	if( current_user_can_bid( $project) && $project->post_author != $user_ID ){ // chec post_status = publish and freelancer role.
		// is freelancer and logged
		$bidding = is_current_user_bidded($project->ID);
		if( ! $bidding){
			get_template_part( 'template-parts/project/bid', 'form' ); //bid_form include bid-form.php file
		} else {
			echo '<div class="full"><button class="btn btn-cancel-bid">'.__('Cancel','boxtheme').' &nbsp;  <span class="glyphicon "></span></button></div>';
			// show button cancel here.
		}

	} else {
		// emp, fre
		$role = bx_get_user_role( $user_ID );
		if ( is_owner_project( $project ) ) {
		}
	}
} else if($project->post_status == 'publish') {
	//is visitor
	show_bid_buton($project);
}

$terms = get_the_terms( $project, 'project_cat' );
if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
	echo '<h3 class="sb-heading">'.__('Categories','boxtheme').'</h3>';
	echo '<ul class="list-category">';

	foreach ( $terms as $term ) {
	  echo '<li><a href="' . get_term_link($term).'">' . $term->name . '</a></li>';
	}
	echo '</ul>';
}

$terms = get_the_terms( $project, 'skill' );
if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
	echo '<ul class="list-skill">';
	echo '<h3>'.__('SKILLS REQUIRED','boxtheme').'</h3>';
	foreach ( $terms as $term ) {
	  	echo '<li><a href="#">' . $term->name . '</a></li>';
	}
	echo '</ul>';
}