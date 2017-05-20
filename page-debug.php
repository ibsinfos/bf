<?php
/**
 *Template Name: Debug
 */
?>
<?php get_header(); ?>
<div class="full-width">
	<div class="container site-content-contain">
		<div class="row site-content" id="content" >
			<div class="col-md-8 detail-project text-justify">
				<?php
				$bid_id = 312;
				$bid = get_post($bid_id);
				echo '<pre>';
				var_dump($bid);
				echo '</pre>';
				?>
			</div>
			<div class="col-md-4">
				<?php get_sidebar('single');?>
			</div>
		</div>
	</div>
</div>

<?php get_footer();?>

