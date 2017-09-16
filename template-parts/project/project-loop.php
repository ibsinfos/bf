<?php
global $post;
$project = BX_Project::get_instance()->convert($post);
//echo '<pre>';var_dump($project);echo '</pre>';
?>
<div class="project-loop-item">
	<div class="col-md-12">
	<?php echo '<h3 class="project-title"><a class="primary-color second-font" href="'.get_permalink().'">'.get_the_title().'</a></h3>';?>
	</div>
	<div class="col-md-12 project-second-line">
		<span class="text-muted display-inline-block m-sm-bottom m-sm-top">
		    <span>Fixed-Price</span>
            <span >
	            <span class="js-budget">-<span  data-itemprop="baseSalary"><?php echo $project->budget_txt; ?> </span></span>
			</span>
			<span class="js-posted"> - <time><?php bx_show_time($post);?></time></span>

		</span>
	</div>
	<div class="col-md-12 project-third-line">
			<?php echo wp_trim_words( get_the_content(), 62); ?>
	</div>
	<div class="col-md-12 employer-info">
		<span class="text-muted display-inline-block m-sm-bottom m-sm-top">
            <strong class="text-muted display-inline-block m-sm-top">Client:</strong>
			<span class="inline">
				<span><?php echo $project->spent_txt;?></span>
			</span>
			<span  class="nowrap">
			    <span> <i class="fa fa-map-marker" aria-hidden="true"></i> <?php echo $project->country;?></span>
			</span><!---->
        </span>
	</div> <!-- . employer-info !-->
</div>