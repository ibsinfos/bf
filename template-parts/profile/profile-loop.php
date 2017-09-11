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
    	//$draught_links[] = '<a href="'.get_term_link($term).'">'.$term->name.'</a>';
    	$draught_links[] = '<span >'.$term->name.'</span>';
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
		<div class="col-md-2 no-padding col-xs-3 col-avatar">
		<?php echo '<a class="avatar" href = "'.get_author_posts_url($profile->post_author).'">'.get_avatar($profile->post_author, 150).'</a>';
		$userdata = get_userdata($post->post_author); ?>
		</div>
		<div class="col-md-10 align-left  col-xs-9 res-content res-second-line">

			<h3 class="profile-title no-margin col-xs-12">
				<?php echo '<a class="" href = " '.get_author_posts_url($profile->post_author).'">'.$profile->post_title.'</a>';?>
			</h3>
			<span class="inline second-line col-md-12 col-xs-12">
				<span class="item professional-title primary-color">
					<?php if( !empty($profile->professional_title) ){?>
						<?php echo $profile->professional_title;?>
					<?php } else { echo '&nbsp;'; } ?>
				</span>
			</span>

			<span class="inline list-info ">
				<span class=" item hour-rate "> <span class="glyphicon glyphicon-time"> </span><span class="txt-rate"><?php echo $profile->{HOUR_RATE_TEXT};?> </span></span>
				<span class=" item eared-txt  col-xs-6"><?php printf(__('Earned: %s','boxtheme'),$profile->{EARNED} ) ;?> </span>
				<span class=" item country-profile col-xs-6 pull-right text-right"> <span class="glyphicon glyphicon-map-marker"></span>  <?php echo $profile->country;?> </span>
				<span class="item profile-rating col-xs-12"> <start class="rating-score clear block <?php echo $start_class;?> "><span class="glyphicon glyphicon-star"></span><span class="glyphicon glyphicon-star"></span><span class="glyphicon glyphicon-star"></span><span class="glyphicon glyphicon-star"></span><span class="glyphicon glyphicon-star"></span></start></span>
			</span>
		</div>
		<div class="col-md-10 align-left  col-xs-12 res-content">
			<span class="overview-profile clear col-xs-12">
			<?php
			$str = str_replace( array("\n", "\r"), '', get_the_content() );
			the_excerpt_max_charlength($str, 170);
			?>

			</span>
			<small class="clear skills"><?php echo $skill_val;?></small>
		</div>


	</div>
</div>