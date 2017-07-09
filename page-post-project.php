<?php
/**
 *Template Name: Post project
 */
?>
<?php get_header(); ?>
<div class="full-width">
	<div class="container site-container">
		<div class="row site-content" id="content" >
			<div class="col-md-8 col-md-offset-2 text-justify">
				<?php the_post(); ?>
				<?php
					if( is_user_logged_in() ){
						get_template_part( 'template-parts/project/form-post', 'project' );
					} else {
						_e('Please login to post project','boxtheme');
					}
				?>
			</div>

		</div>
	</div>
</div>

<?php get_footer();?>

