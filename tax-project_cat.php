<?php
/**
 *	@keyword: tax-project_cat.php
 */

global $wp_query, $ae_post_factory, $post, $user_ID;
$query_args = array(
	'post_type'   => PROJECT,
	'post_status' => 'publish'
);
$loop       = new WP_Query( $query_args );
get_header();
?>
<?php get_header(); ?>
<div class="full-width">
	<div class="container site-container">
		<div class="row site-content" id="content" >
			<div class="col-md-12">
				<?php
				global $wp_query;

				if( have_posts() ):

					while( have_posts() ):
						the_post();
						get_template_part( 'template-parts/project/project', 'loop' );
					endwhile;
					bx_pagenate();
				endif;
			?>
			</div>
		</div>
	</div>
</div>
	<style type="text/css">
		li.cat-label label{
			border-bottom: 2px solid #39c515;
			color: #39c515;
		}
	</style>
<?php
get_footer();