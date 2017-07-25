<?php
/**
 *	Template Name: Credit system
 */
?>
<?php get_header(); ?>
<div class="full-width">
	<div class="container site-container">
		<div class="row site-content" id="content" >
			<div id="profile" class="col-md-12"> <!-- start left !-->
			     <?php get_template_part( 'template-parts/dashboard/list', 'order' ); ?>
			</div> <!-- end left !-->
		</div>
	</div>
</div>
<?php get_footer();?>

