<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */
get_header(); ?>
<div class="full-width">
	<div class="container site-container">
		<div class="row 1row-margin">
			<?php
			//$args = array('post_type' => 'project');
			//$query = new WP_Query($args);

			if(have_posts()):
				while(have_posts()):
					the_post();
					get_template_part( 'template-parts/profile/profile', 'loop' );
				endwhile;
				bx_pagenate();
			endif;
			?>


		</div> <!-- .row !-->

	</div>
</div>

<?php get_footer();
