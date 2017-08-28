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
<div class="full-width main-banner">
	<div class="container">
		<div class="heading-aligner">
	        <h1>#JOIN PUERTO RICO FREELANCE COMMUNITY</h1>
	        <p>We know it's hard to find a online expert when you need one,
	            which is why we've set on a mission to bring them all to one place.
	        </p>
	        <!-- CREATE PRODILE BUTTON -->
	        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
	            <a href="<?php echo et_get_page_link('signup-jobseeker');?>" class="btn review-btn">Create a Profile</a>
	        </div>
	        <!-- POST A PROJECT BUTTON -->
	        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
	            <a href="<?php echo et_get_page_link('post-project');?>" class="btn   review-btn find-btn">Post a Project</a>
	        </div>
	    </div>



	</div>
</div>
<div class="full-width">
	<div class=" container site-container">
		<div id="content" class="site-content">


		</div>
	</div>
</div>

<?php get_footer();
