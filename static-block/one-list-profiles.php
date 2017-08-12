<div class="full-width top-profile">
	<div class=" container site-container">
		<div class="row">
			<div class="col-md-12">
				<h2> Looking for Professional Freelancers?</h2>
			</div>
			<?php
			$profile_query = new WP_Query( array (
				'post_type' => PROFILE,
				'post_status' => 'publish',
				'orderby'   => 'meta_value_num',
				'meta_key'  => RATING_SCORE,
				'order'     => 'DESC',
				'orderby'    => 'meta_value_num',
				'order'      => 'DESC',

				'showposts' => 6
				)
			);
			if( $profile_query->have_posts() ){
				while( $profile_query->have_posts() ){
					global $post;
					$profile_query->the_post();
					$profile 	= BX_Profile::get_instance()->convert($post);
					$profile_id = get_user_meta($post->post_author,'profile_id', true);
					$rating = get_post_meta($post->ID,RATING_SCORE, true);
					$start_class = 'core-'.$profile->{RATING_SCORE};
					if ((int) $profile->{RATING_SCORE} != $profile->{RATING_SCORE}){
						$start_class = 'score-'.(int)$profile->{RATING_SCORE}.'-half';
					}

					$skills = get_the_terms( $profile_id, 'skill' );
					$skill_html = '';

					if ( $skills && ! is_wp_error( $skills ) ){
					  	$draught_links = array();
					  	foreach ( $skills as $term ) {
					     	$draught_links[] = '<a href="'.get_term_link($term).'">'.$term->name.'</a>';
					     	$list_ids[] = $term->term_id;
					  	}
					  	$skill_html = join( ", ", $draught_links );
					}?>

					<div class="col-md-4 profile-item" >
						<div class="left avatar col-md-4 no-padding">
							<?php echo '<a href = "'.get_author_posts_url($profile->post_author).'">'.get_avatar($profile->post_author).'</a>';
							$userdata = get_userdata($post->post_author); ?>
						</div>
						<div class="right col-md-8 no-padding-right">
							<h3 class="profile-title no-margin">
								<?php echo '<a href = " '.get_author_posts_url($profile->post_author).'">'.$profile->post_title.'</a>';?>
							</h3>
							<h5 class="professional-title">
								<?php if( !empty($profile->professional_title) ){ ?>
									<?php echo $profile->professional_title;?>
								<?php } ?>
							</h5>
							<span class="padding-top-15"><small>Join since June, 2017 </small></span>
							<span class="full"><small>
								<start class="rating-score <?php echo $start_class;?> "><span class="glyphicon glyphicon-star"></span><span class="glyphicon glyphicon-star"></span><span class="glyphicon glyphicon-star"></span><span class="glyphicon glyphicon-star"></span><span class="glyphicon glyphicon-star"></span></start><span>(10)</span>
								</small>

							</span>
						</div>
						<div class="right col-md-12 list-skill padding-top-10 no-padding-left">
							<label>Skills:</label> <?php echo $skill_html;?>
						</div>
					</div> <?php

				}
			}?>

		</div>
	</div> <!-- .row !-->
</div>