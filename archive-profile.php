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
					<div class="col-md-12" id = "search_line">
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
						<div class="full" id="count_results">
							<h5> &nbsp;<?php printf( __('%s profile(s) found','boxtheme'), $wp_query->found_posts )?>	</h5>
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
<script type="text/html" id="tmpl-search-record">
	<div class="row archive-profile-item">
	<div class="full">
		<div class="col-md-2 no-padding col-xs-4">
		<a href="{{{data.author_link}}}"></a>		</div>
		<div class="col-md-10 align-left  col-xs-8">
			<h3 class="profile-title no-margin">
				<a href="{{{data.author_link}}}">{{{data.post_title}}}</a>			</h3>
			<h5 class="professional-title">{{{data.professional_title}}}</h5>
			<start class="rating-score clear block core-0 "><span class="glyphicon glyphicon-star"></span><span class="glyphicon glyphicon-star"></span><span class="glyphicon glyphicon-star"></span><span class="glyphicon glyphicon-star"></span><span class="glyphicon glyphicon-star"></span></start>
			<small class="absolute abs-top abs-right hour-rate">{{{data.hour_rate_text}}}</small>
			<small class="clear skills">{{{data.skill_text}}}</small>
		</div>
		<div style="width: 100%; clear: both; display: block;" class="profile-inline">
			<div class="col-md-2">
			</div>
			<div class="col-md-9 col-xs-12 bottom-row">
				<div class="col-md-4 col-xs-4 no-padding-left count-job"> <?php _e('{{{data.projects_worked}}} Job(s)','boxtheme');?> </div>
				<div class="col-md-4  col-xs-4 count-earned">{{{data.earned_txt}}}  </div>
				<div class="col-md-4  col-xs-4 country-profile"><span class="f-right"> <span class="glyphicon glyphicon-map-marker"></span>  {{{data.country}}} </span>
				</div>
			</div>
		</div>
	</div>

</div>
</script>
<?php get_footer();
