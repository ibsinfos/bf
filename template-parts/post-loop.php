<div class="full post-item">
	<h3 class="h3"><a class="ptitle primary-font" href="<?php the_permalink();?>"><?php the_title(); ?></a> </h3>
	<?php
	if(get_the_tag_list()) {
		echo '<div class="full ptag"> <span class="tag-label">'.__('Tags:','boxtheme').'</span>';
    	echo get_the_tag_list(' <ul class="none-style inline"><li>','</li><li>','</li></ul>');
    	echo '</div>';
	}
	?>
	<div class="full pdate"><?php _e('Posted: ','boxtheme'); the_date(); ?></div>
	<div class="pexcerpt">
		<?php
			if( has_post_thumbnail() ){
				the_post_thumbnail( 'full' );
			}
		?>
		<?php the_excerpt(); ?>
	</div>
</div>