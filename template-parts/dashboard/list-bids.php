<?php
/**
 * be included in page-dashboard and list all bidded of current freelancer
 * Only available for freelancer account.
**/

	global $user_ID;

	$status = isset( $_GET['status'] ) ? $_GET['status'] : 'any';
	$loadmore = false;
	$link =  box_get_static_link('dashboard');  ?>

	<ul class="db-list-project">
		<li class="heading list-style-none full">
			<form class="pull-right full dashboard-filter">
				<div class="col-md-2 pull-right">
					<select class="form-control">
						<option <?php selected( $status, 'any' ); ?>  value="<?php echo $link;?>"> <?php _e('All Status','boxtheme');?></option>
						<option <?php selected( $status, 'publish' ); ?> value="<?php echo add_query_arg('status','publish', $link);?>"> Publish</option>
						<option <?php selected( $status, 'pending' ); ?>  value="<?php echo add_query_arg('status','pending', $link);?>"> Pending</option>
						<option <?php selected( $status, 'awarded' ); ?>  value="<?php echo add_query_arg('status','awarded', $link);?>"> Working</option>
						<option <?php selected( $status, 'done' ); ?>  value="<?php echo add_query_arg('status','done', $link);?>"> Done</option>
						<option <?php selected( $status, 'disputing' ); ?>  value="<?php echo add_query_arg('status','disputing', $link);?>"> Disputing/Resolved</option>
						<option <?php selected( $status, 'archived' ); ?>  value="<?php echo add_query_arg('status','archived', $link);?>"> Archived</option>
					</select>
				</div>

			</form>
		</li>
		<?php
			$args = array(
			'post_type' => 'bid',
			'author'=> $user_ID,
			'posts_per_page' => -1,
		);
		if( $status == 'disputing' )
			$status = array('disputing','resolved');

		$args['post_status'] = $status;
		$query = new WP_Query($args);

		echo '<li class="heading list-style-none padding-bottom-10">';
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
				$bid = BX_Bid::get_instance()->convert($post);
				$project = get_post($bid->post_parent);


				echo '<li class="list-style-none padding-bottom-10">';
					echo '<div class ="col-md-4">';	echo '<a href="'.get_permalink($project->ID).'">'. $project->post_title.'</a>';	echo '</div>';
					echo '<div class ="col-md-2">';				echo count_bids($post->ID);	echo '</div>';
					echo '<div class ="col-md-1">';				box_price($bid->{BID_PRICE}); echo '</div>';
					echo '<div class ="col-md-2">';	echo get_the_date();	echo '</div>';
					?>
					<div class ="col-md-2 text-center">
						<?php echo $bid->post_status;?>
					</div>
					<div class ="col-md-1 pull-right text-center">
						<a href="#" class="btn-board btn-archived-job" id="<?php echo $bid->ID;?>"  data-toggle="tooltip" title="<?php printf(__('Archived %s','boxtheme'), $bid->post_titile);?>">
							<i class="fa fa-trash-o" aria-hidden="true"></i>
						</a> <?php
				echo '</li>';
			}
		} else {
			echo '<li class="col-md-12" style="padding:15px 20px;">';
			_e('This query is empty','boxtheme');
			echo '</li>';
		}

		echo '</ul>';

?>