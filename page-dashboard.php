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
					<li class="active"><a  href="#1a" data-toggle="tab">List project</a>			</li>
					<li><a href="#tab_credit" data-toggle="tab">Credit</a>		</li>

				</ul>

				<div class="tab-content clearfix">
					<div class="tab-pane active" id="1a">
			          	<?php
			          		global $user_ID;
			          		$args = array(
			          			'post_status' => 'publish',
			          			'post_type' => 'project',
			          			'author'=> $user_ID,
			          		);
			          		$query = new WP_Query($args);
			          		$loadmore = false;
			          		if( $query-> have_posts() ){
			          			$loadmore = true;
			          			echo '<ul class="db-list-project">';
			          			echo '<li class="heading row list-style-none padding-bottom-10">';
				          				echo '<div class ="col-md-7">';
				          				_e('Project Title','boxtheme');
				          				echo '</div>';
				          				echo '<div class ="col-md-3">';
				          				_e('Price','boxtheme');
				          				echo '</div>';
				          				echo '<div class ="col-md-2">';
				          				_e('Posted date','boxtheme');
				          				echo '</div>';
			          				echo '</li>';

			          			while ($query->have_posts()) {
			          				global $post;
			          				$query->the_post();
			          				$project = BX_Project::get_instance()->convert($post);
			          				echo '<li class="row list-style-none padding-bottom-10">';
				          				echo '<div class ="col-md-7">';
				          				echo '<a href="'.get_permalink().'">'. get_the_title().'</a>';
				          				echo '</div>';
				          				echo '<div class ="col-md-3">';
				          				box_price($project->_budget);
				          				echo '</div>';
				          				echo '<div class ="col-md-2">';	echo get_the_date();	echo '</div>';
			          				echo '</li>';
			          			}
			          			if($loadmore){
			          				echo '<li class="row list-style-none padding-bottom-10"><center> <button class="load-more" page ="1">Load more</button> </center></li>';
			          			}
			          			echo '</ul>';
			          		}
			          	?>
					</div>

			        <div class="tab-pane" id="tab_credit">
			        	<?php get_template_part( 'template-parts/dashboard/list', 'order' ); ?>
					</div>

				</div>
			</div> <!-- end left !-->

		</div>
	</div>
</div>
<?php get_footer();?>

