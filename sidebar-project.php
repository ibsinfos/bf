<?php
global $user_ID, $project, $is_owner, $access_workspace, $is_workspace, $winner_id, $class_bidded, $bidding, $is_logged, $current_user_can_bid;
function show_bid_buton($post){
	$back_url = add_query_arg( 'redirect', get_the_permalink($post->ID), box_get_static_link('login') );
	echo '<a class ="btn btn-login" href ="'.$back_url.'">'.__('Login to bid','boxtheme').'</a>';
}
if ( $is_logged ) {

	if( $current_user_can_bid  ){ // chec post_status = publish and freelancer role.
		// is freelancer and logged
		if( ! $bidding){
			get_template_part( 'template-parts/project/bid', 'form' ); //bid_form include bid-form.php file
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
?>
<div class="block-employer-info">
<?php
$user = get_userdata($project->post_author );

?>
	<h3> Employer Information</h3>
	<ul class="list-employer-info">
		<li><?php echo $user->display_name;?></li>
		<li><i class="fa fa-map-marker bcon" aria-hidden="true"></i>France</li>
		<li><i class="fa fa-flag bcon" aria-hidden="true"></i>Project posted: 120.</li>
		<li><i class="fa fa-address-book-o bcon" aria-hidden="true"></i>Freelancers Hired: 120.</li>
		<li><i class="fa fa-money bcon" aria-hidden="true"></i>Total Spent 120.000</li>
		<li class="rating"><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i></li>
	</ul>
</div>