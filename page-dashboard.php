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
<style type="text/css">
	.dashboard-filter{
		width: 100%;
		margin-bottom: 20px;
	}
	.dashboard-filter select{
		border-radius: 5px;

	}
</style>
<script type="text/javascript">
	(function($){
		$(document).ready(function(){
			$( ".dashboard-filter select" ).change(function(ev) {
			  	console.log(ev);
			  	var url = $(this).find(":checked").val();
			  	window.location.href = url;
			});
		})
	})(jQuery);
</script>
<?php get_footer();?>

