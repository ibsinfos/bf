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
	<div class="container site-content-contain">
		<div class="row">
			<div class="col-md-8">
			<?php
				if(have_posts()):
					while(have_posts()):
						the_post();
						get_template_part( 'template-parts/project/project', 'loop' );
					endwhile;

				endif;		?>
			</div>
			<div class="col-md-4">
				<h2> Sidebar</h2>
			</div>
		</div> <!-- .row !-->

	</div>
</div>

<?php get_footer();
