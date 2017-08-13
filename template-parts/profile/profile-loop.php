<?php
global $post;
global $user_ID;
$profile 	= BX_Profile::get_instance()->convert($post);
$profile_id = get_user_meta($post->post_author,'profile_id', true);
$skills = get_the_terms( $profile_id, 'skill' );
$skill_val = '';
if ( $skills && ! is_wp_error( $skills ) ){

  $draught_links = array();

  foreach ( $skills as $term ) {
     $draught_links[] = '<a href="'.get_term_link($term).'">'.$term->name.'</a>';
     $list_ids[] = $term->term_id;
  }
  $skill_val = join( " ", $draught_links );
}
$start_class = 'core-'.$profile->{RATING_SCORE};
if ((int) $profile->{RATING_SCORE} != $profile->{RATING_SCORE}){
	$start_class = 'score-'.(int)$profile->{RATING_SCORE}.'-half';
}
?>
<div class="row archive-profile-item">
	<div class="full">
		<div class="col-md-2 no-padding col-xs-4">
		<?php echo '<a href = "'.get_author_posts_url($profile->post_author).'">'.get_avatar($profile->post_author).'</a>';
		$userdata = get_userdata($post->post_author); ?>
		</div>
		<div class="col-md-10 align-left  col-xs-8">
			<h3 class="profile-title no-margin">
				<?php echo '<a class="" href = " '.get_author_posts_url($profile->post_author).'">'.$profile->post_title.'</a>';?>
			</h3>
			<h5 class="professional-title primary-color">
				<?php if( !empty($profile->professional_title) ){?>
					<?php echo $profile->professional_title;?>
				<?php } else { echo '&nbsp;'; } ?>
			</h5>
			<start class="rating-score clear block <?php echo $start_class;?> "><span class="glyphicon glyphicon-star"></span><span class="glyphicon glyphicon-star"></span><span class="glyphicon glyphicon-star"></span><span class="glyphicon glyphicon-star"></span><span class="glyphicon glyphicon-star"></span></start>

			<span class="hour-rate"> <span class="glyphicon glyphicon-time"></span> $<?php echo $profile->hour_rate;?>/hr </span>
			<span class="eared-txt"><?php echo $profile->{EARNED_TXT};?> </span>
			<span class="country-profile"> <span class="glyphicon glyphicon-map-marker"></span>  <?php echo $profile->country;?> </span>

			<span class="overview-profile"><?php the_content();?></span>
			<small class="clear skills"><?php echo $skill_val;?></small>
		</div>

	</div>
</div>