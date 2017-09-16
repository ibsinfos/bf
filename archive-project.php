<?php
/**
 * @key:archive-project.php
 */
get_header(); ?>
<div class="full-width main-archive">
	<div class="container site-container">
		<div  id="content" >
			<div class="set-bg full">
				<div class="col-md-3 sidebar sidebar-search set-bg box-shadown" id="sidebar">
					<?php get_template_part( 'sidebar/archive', 'projects' ); ?>
				</div>
				<div class="col-md-9 no-padding-right" id="right_column">
					<div class="full set-bg box-shadown">
						<div class="col-md-12" id = "search_line">
							<form action="" class="full frm-search">
								<div class="input-group full">
							       <input type="text" name="s" id="keyword" required  placeholder="Search..." value="<?php echo get_search_query();?>" class="form-control required" />
							       <div class="input-group-btn">  <button class="btn btn-info primary-bg"><i class="fa fa-search" aria-hidden="true"></i></button> </div>
							   </div>
							</form>
							<div class="full hide" id="count_results">
								<h5> &nbsp;<?php printf( __('%s job(s) found','boxtheme'), $wp_query->found_posts )?>	</h5>
							</div>
						</div>

						<div class="list-project" id="ajax_result">
							<?php
								if( have_posts() ):
									while( have_posts() ): the_post();
										get_template_part( 'template-parts/project/project', 'loop' );
									endwhile;
									bx_pagenate();
								endif;
								wp_reset_query();
							?>
						</div>
					</div> <!-- set bg !-->
				</div><!-- end .col-md-9 !-->
			</div> <!-- set-bg !-->
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
<script type="text/html" id="tmpl-search-record">
	<div class="project-loop-item">
		<div class="col-md-12"><h3 class="project-title "><a class="primary-color second-font" href="{{{data.guid}}}">{{{data.post_title}}}</a></div>
		<div class="col-md-12">
			<span class="text-muted display-inline-block m-sm-bottom m-sm-top">
			   	<span class="js-type">Fixed-Price</span>
		        <span class="js-budget">-<span  data-itemprop="baseSalary">{{{data.budget_txt}}} </span></span>
			</span>
			<span class="js-posted"> - <time>{{{data.post_date_text}}}</time></span>
		</div>
		<div class="col-md-12">{{{data.short_des}}}</div>
		<div class="col-md-12 employer-info">
			<span>
	            <span class="text-muted display-inline-block m-sm-top">Client:</span>
				<span class="inline"><span class="client-spendings display-inline-block">{{{data.spent_txt}}}</span></span>
				<span  class="nowrap">
					<span class="glyphicon glyphicon-md air-icon-location m-0"></span>
				    <span class="text-muted client-location"><i class="fa fa-map-marker" aria-hidden="true"></i> {{{data.country}}}</span>
				</span><!---->
	        </span>
		</div> <!-- . employer-info !-->
	</div>
</script>
<script type="text/javascript">
	(function($){
		var h_right = $("#right_column").css('height'),
			h_left = $("#sidebar").css('height');
			$(".list-project").css('min-height',h_left);
		if( parseInt(h_left) > parseInt(h_right) ){
			$(".list-project").css('height',h_left);
		}
	})(jQuery);
</script>
<?php  get_footer();