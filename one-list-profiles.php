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
				$rating = get_post_meta($post->ID,RATING_SCORE, true);
				get_template_part( 'template-parts/profile/profile', 'loop' );
			}
		}
		?>

	</div>
	</div> <!-- .row !-->
</div>