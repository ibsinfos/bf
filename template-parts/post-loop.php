<div class="full">
	<h3><a href="<?php the_permalink();?>"><?php the_title(); ?></a> </h3>
	<small><?php the_date(); ?></small>
	<div class="post-excerpt">
		<?php
			if( has_post_thumbnail() ){
				the_post_thumbnail('full');
			}
		?>
		<?php the_excerpt(); ?>
	</div>
</div>