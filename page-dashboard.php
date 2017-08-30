<?php
/**
 *	Template Name: Dashboard System Of User
 */
?>
<?php get_header(); ?>
<div class="full-width">
	<div class="container site-container">
		<div class="row site-content" id="content" >
			<div id="profile" class="col-md-12">
				<ul  class = "nav nav-pills dashboard-tab" id = "heading_dashboard">
					<li class="active" > <a  href="#1a" data-toggle="tab"><?php _e('ACTIVATE','boxtheme');?></a>			</li>
					<li><a href="#tab_working" data-toggle="tab"><?php _e('WORKING','boxtheme');?></a>		</li>
					<li><a href="#tab_done" data-toggle="tab"><?php _e('DONE','boxtheme');?></a></li>
					<li><a href="#tab_archived" data-toggle="tab"><?php _e('ARCHIVED','boxtheme');?></a></li>

				</ul>
				<div class="tab-content clearfix">
					<div class="tab-pane active" id="1a">
						<?php get_template_part( 'template-parts/dashboard/list', 'project-activate' ); ?>
					</div>
			        <div class="tab-pane" id="tab_working">
			       		<?php get_template_part( 'template-parts/dashboard/list', 'project-working' ); ?>
					</div>
					<div class="tab-pane" id="tab_done">
			       		<?php get_template_part( 'template-parts/dashboard/list', 'project-done' ); ?>
					</div>
					<div class="tab-pane" id="tab_archived">
			       		<?php get_template_part( 'template-parts/dashboard/list', 'project-archived' ); ?>
					</div>

				</div>
			</div> <!-- end left !-->

		</div>
	</div>
</div>
<?php get_footer();?>

