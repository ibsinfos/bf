<?php get_header(); ?>
<div class="row full-width">
	<div class="container site-content-contain">
		<div id="content" class="site-content">
			<div class="col-md-9">
			<?php the_post(); ?>
			<?php the_content(); ?>
			</div>
			<div class="col-md-3">
				<button> Bid</button>
			</div>
		</div>
	</div>
</div>

<?php get_footer();?>
