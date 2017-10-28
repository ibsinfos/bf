<?php
function box_bid_buton($post){
					//add_query_arg( 'key', 'value', 'http://example.com' );
	$apply_link = 	add_query_arg( 'apply','1' ,  get_the_permalink($post->ID) );

	$back_url = add_query_arg(  'redirect', $apply_link , box_get_static_link('login') );
	if( is_user_logged_in() ){
		echo '<a href="?apply=1" class ="btn-bid-now text-right pull-right" > &nbsp; ' . __('Bid Now','boxtheme') . ' &nbsp; &nbsp;  <i class="fa fa-angle-right" aria-hidden="true"></i> </a>';
	} else {
		echo '<a class ="btn-login text-right pull-right" href ="'.esc_url($back_url).'"> &nbsp; '.__('Bid Now','boxtheme') . ' &nbsp; &nbsp;  <i class="fa fa-angle-right" aria-hidden="true"></i> </a>';
	}
}


global $user_ID, $project, $is_owner, $can_access_workspace, $is_workspace, $winner_id, $class_bidded, $bidding, $is_logged, $current_user_can_bid;
$user = get_userdata($project->post_author );

$country_id  = get_user_meta( $project->post_author, 'location', true );
$txt_country = 'Unset';
$ucountry = get_term( $country_id, 'country' );

if( !is_wp_error($ucountry ) ){
	$txt_country = $ucountry->name;
}
$project_posted = (int) get_user_meta( $project->post_author, 'project_posted', true);
$fre_hired = (int) get_user_meta( $project->post_author, 'fre_hired', true);
$total_spent = floatval( get_user_meta( $project->post_author, 'total_spent', true) );
$score = (int) get_user_meta($project->post_author,RATING_SCORE, true);
if(empty($score) || !$score){
	$score = 0;
}

?>
	<div class="main-btn-react  hide">
		<button class="contact-me primary-bg"> WorkSpace</button><button class="contact-me primary-bg">Dispute</button>
	</div>

<div class="block-employer-info">
	<h3> <?php _e('Employer Information','boxtheme');?></h3>
	<ul class="list-employer-info">
		<li class="item-avatar">
			<div class="left-emp-avatar">
				<?php echo get_avatar( $user->ID, 39);?> &nbsp;
			</div>
			<div class="right-emp-avatar">
				<label class="emp-name"><a class="author-url" href="<?php echo esc_url(get_author_posts_url( $project->post_author )); ?>"><?php echo $user->display_name ;?>  </a> </label>
				<span class="member-since"> Member Since May 16, 2017</span>
			</div>
		</li>
		<li><i class="fa fa-map-marker bcon" aria-hidden="true"></i>From <span class="pull-right"><?php echo $txt_country;?></span></li>
		<li><i class="fa fa-flag bcon" aria-hidden="true"></i><?php printf(__("Project posted <span class='text-right pull-right'>%d</span>",'boxtheme'), $project_posted);?></li>
		<li><i class="fa fa-address-book-o bcon" aria-hidden="true"></i><?php printf(__("Freelancers hired <span class='text-right pull-right'>%d</span>",'boxtheme'), $fre_hired);?></li>
		<li><i class="fa fa-money bcon" aria-hidden="true"></i><?php printf(__("Total spent ($) <span class='text-right pull-right'>%f</span>",'boxtheme'), $total_spent );?></li>
		<li class="rating rating-score score-<?php echo $score;?>"><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i></li>
		<?php if ( $current_user_can_bid && ! $bidding ) { ?>
			<li><?php box_bid_buton($project);?></li>
		<?php }?>
	</ul>
</div>

<div class="company-pictures">
		<img src="<?php echo  get_template_directory_uri().'/img/ads.png';?>" />
</div>