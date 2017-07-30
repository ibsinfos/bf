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
					<?php get_template_part( 'sidebar/archive', 'projects' ); ?>
				</div>

				<div class="col-md-9 " >
					<div class="row">
						<form action="" class="navbar-form full frm-search">
							<div class="input-group full">
						       <input type="text" name="s" placeholder="Search..." value="<?php echo get_search_query();?>" class="form-control" />
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
						global $wp_query;
						//var_dump('<pre>');
						//var_dump($wp_query->found_posts);
						//echo '</pre>';
						wp_reset_query();
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

			</div> <!-- .row !-->


	</div>
</div>
<script type="text/template" data-template="project_template">
    <a href="${url}" class="list-group-item">
        <table>
            <tr>
                <td><img src="${img}"></td>
                <td><p class="list-group-item-text">${title}</p></td>
            </tr>
        </table>
    </a>
</script>
<script type="text/html" id="tmpl-project-record">
	<div class="row project-loop-item">
		<div class="col-md-12">
		<?php echo '<h3 class="project-title"><a href="{{{data.guid}}}">{{{data.post_title}}}</a></h3>';?>
		</div>
		<div class="col-md-12">
			<span class="text-muted display-inline-block m-sm-bottom m-sm-top">
			   	<span class="js-type">Fixed-Price</span>
		            <span class="js-budget">- <span> Budget:</span>
		           	 <span  data-itemprop="baseSalary">{{{data._budget}}} </span>
					</span>
				</span>
				<span class="js-posted"> - <time>{{{data.post_date_text}}}</time></span>

			</span>
		</div>
		<div class="col-md-12">
		{{{data.post_excerpt}}}
		</div>
		<div class="col-md-12 employer-info">
			<span>
	            <span class="text-muted display-inline-block m-sm-top">Client:</span>
				<span class="inline">
					<span class="client-spendings display-inline-block">
				    {{{data.spent}}}
					</span>
				</span>
				<span  class="nowrap">
					<span class="glyphicon glyphicon-md air-icon-location m-0"></span>
				    <span class="text-muted client-location"><span class="glyphicon glyphicon-map-marker"></span> {{{data.country}}}</span>
				</span><!---->
	        </span>
		</div> <!-- . employer-info !-->
	</div>
</script>
<?php  get_footer();
