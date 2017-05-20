<?php
/**
 *Template Name: Post project
 */
?>
<?php get_header(); ?>
<div class="full-width">
	<div class="container site-container">
		<div class="row site-content" id="content" >
			<div class="col-md-8 detail-project text-justify">
				<?php the_post(); ?>
				<?php get_template_part( 'template-parts/project/form-post', 'project' );?>
			</div>
			<div class="col-md-4">
				<?php get_sidebar('single');?>
			</div>
		</div>
	</div>
</div>

<?php get_footer();?>

