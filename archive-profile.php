<?php
/**
 * @key:archive-profile.php
 */
get_header(); ?>
<div class="full-width">
	<div class="container site-container">
		<div class="row " id="content" >
			<div class="set-bg full">
				<div class="col-md-3 sidebar sidebar-search set-bg box-shadown" id="sidebar">
					<?php get_template_part( 'sidebar/archive', 'profiles' ); ?>
				</div>
				<div class="col-md-9 " id="right_column">
					<div class="full set-bg box-shadown">
						<div class="col-md-12" id = "search_line">
							<form action="" class="full frm-search">
								<div class="input-group full">
							       <input type="text" name="s" id="keyword" placeholder="Search..." value="<?php echo get_search_query();?>" class="form-control" />
							       <div class="input-group-btn">
							           <button class="btn btn-info primary-bg">
							           <span class="glyphicon glyphicon-search"></span>
							           </button>
							       </div>
							   </div>
							</form>
							<div class="full hide" id="count_results">
								<h5> &nbsp;<?php printf( __('%s profile(s) found','boxtheme'), $wp_query->found_posts )?>	</h5>
							</div>
						</div>

						<div class="list-project" id="ajax_result">
							<?php
								if( have_posts() ):
									while( have_posts() ):
										the_post();
										get_template_part( 'template-parts/profile/profile', 'loop' );
									endwhile;
									bx_pagenate();
								endif;
							?>
						</div>
					</div>
				</div>
			</div><!-- .set bg !-->
		</div> <!-- .row !-->

	</div>
</div>
<script type="text/html" id="tmpl-search-record">
	<div class="row archive-profile-item">
		<div class="full">
			<div class="col-md-2 no-padding col-xs-4">
			<a class="avatar" href="{{{data.author_link}}}">{{{data.avatar}}}</a></div>
			<div class="col-md-10 align-left  col-xs-8">
				<h3 class="profile-title no-margin">
					<a href="{{{data.author_link}}}">{{{data.post_title}}}</a>
				</h3>
				<span class="inline second-line">
					<span class="item professional-title primary-color">{{{data.professional_title}}}</span>
				</span>
				<span class="inline list-info">
					<span class="item hour-rate"><span class="glyphicon glyphicon-time"></span> {{{data.hour_rate_text}}}</span>
					<span class=" item eared-txt"> Earned: {{{data.earned}}}</span>
					<span class=" item country-profile"> <span class="glyphicon glyphicon-map-marker"></span>{{{data.country}}}</span>
					<span class="item profile-rating"> <start class="rating-score clear block core-{{{data.rating_scrore}}} "><span class="glyphicon glyphicon-star"></span><span class="glyphicon glyphicon-star"></span><span class="glyphicon glyphicon-star"></span><span class="glyphicon glyphicon-star"></span><span class="glyphicon glyphicon-star"></span></start></span>
				</span>
				<span class="overview-profile clear">{{{data.post_content}}}</span>
				<small class="clear skills">{{{data.skill_text}}}</small>
			</div>
		</div>
	</div>


</div>
</script>
<script type="text/javascript">
	(function($){
		var h_right = $("#right_column").css('height'),
			h_left = $("#sidebar").css('height');

		if( parseInt(h_left) > parseInt(h_right) ){

			$(".list-project").css('height',h_left);
		}
	})(jQuery);
</script>
<?php get_footer();
