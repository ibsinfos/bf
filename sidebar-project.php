<?php
global $user_ID, $project, $is_owner, $access_workspace, $is_workspace, $winner_id, $class_bidded, $bidding, $is_logged, $current_user_can_bid;
$user = get_userdata($project->post_author );

$country_id  = get_user_meta( $project->post_author, 'location', true );
$txt_country = 'Unset';
$ucountry = get_term( $country_id, 'country' );

if( !is_wp_error($ucountry ) ){
	$txt_country = $ucountry->name;
}
$project_posted = (int) get_user_meta( $project->post_author, 'project_posted', true);
$fre_hired = (int) get_user_meta( $project->post_author, 'fre_hired', true);
$total_spent =  get_user_meta( $project->post_author, 'total_spent', true);
$score = get_user_meta($project->post_author,RATING_SCORE, true);
if(empty($score) || !$score){
	$score = 0;
}
?>
<div class="block-employer-info">
<h3> <?php _e('Employer Information','boxtheme');?></h3>
	<ul class="list-employer-info">
		<li><span class="emp-name"><?php echo $user->display_name ;?></span></li>
		<li><i class="fa fa-map-marker bcon" aria-hidden="true"></i><?php echo $txt_country;?></li>
		<li><i class="fa fa-flag bcon" aria-hidden="true"></i><?php printf(__("Project posted: %d",'boxtheme'), $project_posted);?></li>
		<li><i class="fa fa-address-book-o bcon" aria-hidden="true"></i><?php printf(__("Freelancers Hired: %d",'boxtheme'), $fre_hired);?></li>
		<li><i class="fa fa-money bcon" aria-hidden="true"></i><?php printf(__("Total Spent: %s",'boxtheme'), box_get_price_format($total_spent) );?></li>

		<li class="rating rating-score core-<?php echo $score;?>"><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i></li>
	</ul>
</div>
<?php
function show_bid_buton($post){
	$back_url = add_query_arg( 'redirect', get_the_permalink($post->ID), box_get_static_link('login') );
	echo '<a class ="btn btn-login" href ="'.$back_url.'">'.__('Login to bid','boxtheme').'</a>';
}
if ( $is_logged ) {

	if ( $current_user_can_bid  ) { // chec post_status = publish and freelancer role.
		// is freelancer and logged
		if ( ! $bidding){
			get_template_part( 'template-parts/project/bid', 'form' ); //bid_form include bid-form.php file
		}

	} else {
		// emp, fre
		$role = bx_get_user_role( $user_ID );
		if ( is_owner_project( $project ) ) {
		}
	}
} else if ( $project->post_status == 'publish' ) {
	//is visitor
	show_bid_buton($project);
}
?>