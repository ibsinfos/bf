<?php
/**
 * be included in page-dashboard and list all bidded of current Employer
 * Only available for Employer or Admin account.
**/

	global $user_ID;

	//$status = isset( $_GET['status'] ) ? $_GET['status'] : 'any';
	$status = isset( $_GET['status'] ) ? $_GET['status'] : array('publish','pending','disputing','resolved','done','awarded');
	$loadmore = false;
	$link =  box_get_static_link('dashboard');
	$check = $status;
	if( is_array($status) )
		$check = 'any';

	?>

	<ul class="db-list-project">
		<li class="heading list-style-none full">
			<div class="col-md-8 pull-left">
				<?php _e('Your projects','boxtheme');?>
			</div>
			<div class="col-md-4 pull-right">
				<form class="pull-right full dashboard-filter">
					<select class="form-control">
						<option <?php selected( $check, 'any' ); ?>  value="<?php echo $link;?>"> <?php _e('All Status','boxtheme');?></option>
						<option <?php selected( $check, 'publish' ); ?> value="<?php echo add_query_arg('status','publish', $link);?>"> Publish</option>
						<option <?php selected( $check, 'pending' ); ?>  value="<?php echo add_query_arg('status','pending', $link);?>"> Pending</option>
						<option <?php selected( $check, 'awarded' ); ?>  value="<?php echo add_query_arg('status','awarded', $link);?>"> Working</option>
						<option <?php selected( $check, 'done' ); ?>  value="<?php echo add_query_arg('status','done', $link);?>"> Done</option>
						<option <?php selected( $check, 'disputing' ); ?>  value="<?php echo add_query_arg('status','disputing', $link);?>"> Disputing/Resolved</option>
						<option <?php selected( $check, 'archived' ); ?>  value="<?php echo add_query_arg('status','archived', $link);?>"> Archived</option>
					</select>
				</form>
			</div>
		</li>
		<?php
			$args = array(
			'post_type' => 'project',
			'author'=> $user_ID,
			'posts_per_page' => -1,
		);
		if( $status == 'disputing' )
			$status = array('disputing','resolved');

		$args['post_status'] = $status;
		$query = new WP_Query($args);

		echo '<li class="heading heading-table list-style-none padding-bottom-10">';
				echo '<div class ="col-md-4">';				_e('Project Title','boxtheme');				echo '</div>';
				echo '<div class ="col-md-2">';				_e('Bid(s)','boxtheme');				echo '</div>';
				echo '<div class ="col-md-1">';				_e('Price','boxtheme');				echo '</div>';
				echo '<div class ="col-md-2">'; _e('Posted date','boxtheme');echo '</div>'; ?>
				<div class ="col-md-2 text-center">Status</div><?php
				echo '<div class ="col-md-1 text-center pull-right">'; _e('Action','boxtheme');echo '</div>';
			echo '</li>';
		if( $query-> have_posts() ){
			while ($query->have_posts()) {
				global $post;
				$query->the_post();
				$project = BX_Project::get_instance()->convert($post);
				echo '<li class="list-style-none padding-bottom-10">';
					echo '<div class ="col-md-4">';	echo '<a href="'.get_permalink().'">'. get_the_title().'</a>';	echo '</div>';
					echo '<div class ="col-md-2">';				echo count_bids($post->ID);	echo '</div>';
					echo '<div class ="col-md-1">';				box_price($project->_budget);echo '</div>';
					echo '<div class ="col-md-2">';	echo get_the_date();	echo '</div>';
					?>
					<div class ="col-md-2 text-center">
						<?php echo $project->post_status;?>
					</div>
					<div class ="col-md-1 pull-right text-center">
						<a href="#" class="btn-board btn-archived-job" id="<?php echo $project->ID;?>"  data-toggle="tooltip" title="<?php printf(__('Archived %s','boxtheme'), $project->post_titile);?>">
							<i class="fa fa-trash-o" aria-hidden="true"></i>
						</a> <?php
				echo '</li>';
			}
		} else {
			echo '<li class="col-md-12" style="padding-top: 20px; list-style:none">';
			_e('This query is empty','boxtheme');
			echo '</li>';
		}

		echo '</ul>';

?>