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
		<div class="row">
				<div class="col-md-3 sidebar sidebar-search" id="sidebar">
					<?php get_template_part( 'sidebar/archive', 'profiles' ); ?>
				</div>
				<div class="col-md-9 " >
					<div class="row">
						<form action="" class="navbar-form full frm-search">
							<div class="input-group full">
						       <input type="text" name="s" id="keyword"  placeholder="Search..." value="<?php echo get_search_query();?>" class="form-control" />
						       <div class="input-group-btn">
						           <button class="btn btn-info">
						           <span class="glyphicon glyphicon-search"></span>
						           </button>
						       </div>
						   </div>
						</form>
						<div class="col-md-12">
							<?php echo sprintf( '<h5>'._n( '%s job found', '%s jobs found', $wp_query->found_posts, 'boxtheme' ).'</h5>', $wp_query->found_posts); ?>
						</div>

					</div>

					<div class="list-project" id="ajax_result">
					<?php

					if(have_posts()):
						while(have_posts()):
							the_post();
							get_template_part( 'template-parts/profile/profile', 'loop' );
						endwhile;
						bx_pagenate();
					endif;
					?>
					</div>
				</div>


		</div> <!-- .row !-->

	</div>
</div>

<?php get_footer();
