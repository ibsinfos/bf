<?php
global $post;
$project = BX_Project::get_instance()->convert($post);
//echo '<pre>';var_dump($project);echo '</pre>';
?>
<div class="row project-loop-item">
	<div class="col-md-12">
	<?php echo '<h3 class="project-title"><a href="'.get_permalink().'">'.get_the_title().'</a></h3>';?>
	</div>
	<div class="col-md-12 project-second-line">
		<span class="text-muted display-inline-block m-sm-bottom m-sm-top">
		    <span>Fixed-Price</span>
            <span >
	            <span class="js-budget">- <span>Budget:</span>
	           		<span  data-itemprop="baseSalary"><?php box_price($project->_budget);?> </span>
				</span>
			</span>
			<span class="js-posted"> - <time><?php bx_show_time($post);?></time></span>

		</span>
	</div>
	<div class="col-md-12 project-third-line">
			<?php the_excerpt_max_charlength(get_the_excerpt(), 300); ?>
	</div>
	<div class="col-md-12 employer-info">
		<span class="text-muted display-inline-block m-sm-bottom m-sm-top">
            <strong class="text-muted display-inline-block m-sm-top">Client:</strong>
			<span class="inline">
				<span><?php echo $project->spent_txt;?></span>
			</span>
			<span  class="nowrap">
				<span class="glyphicon glyphicon-md air-icon-location m-0"></span>
			    <span> <span class="glyphicon glyphicon-map-marker"></span> <?php echo $project->country;?></span>
			</span><!---->
        </span>
	</div> <!-- . employer-info !-->
</div>