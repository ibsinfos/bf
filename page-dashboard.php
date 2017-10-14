<?php
/**
 *	Template Name: Dashboard System Of User
 */
?>
<?php get_header(); ?>
<div class="full-width">
	<div class="container site-container">
		<div class="site-content" id="content" >
			<div id="profile" class="col-md-12">
				<div class="tab-content clearfix">
					<?php get_template_part( 'template-parts/dashboard/my', 'projects' ); ?>
				</div>
			</div> <!-- end left !-->

		</div>
	</div>
</div>
<?php get_footer();?>

