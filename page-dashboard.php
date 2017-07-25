<?php
/**
 *	Template Name: Dashboard System Of User
 */
?>
<?php get_header(); ?>
<div class="full-width">
	<div class="container site-container">
		<div class="row site-content" id="content" >
			<div id="profile" class="col-md-12"> <!-- start left !-->
				<ul  class="nav nav-pills" id ="heading_dashboard">
					<li class="active"><a  href="#1a" data-toggle="tab">ACTIVATE</a>			</li>
					<li><a href="#tab_working" data-toggle="tab">WORKING</a>		</li>
					<li><a href="#tab_done" data-toggle="tab">DONE</a></li>

				</ul>
				<div class="tab-content clearfix">
					<div class="tab-pane active" id="1a">
						<?php get_template_part( 'template-parts/dashboard/list', 'project' ); ?>
					</div>
			        <div class="tab-pane" id="tab_working">
			       		<?php get_template_part( 'template-parts/dashboard/list', 'order' ); ?>
					</div>
					<div class="tab-pane" id="tab_done">
			       		<?php get_template_part( 'template-parts/dashboard/list', 'order' ); ?>
					</div>

				</div>
			</div> <!-- end left !-->

		</div>
	</div>
</div>
<?php get_footer();?>

