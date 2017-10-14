<?php


	get_header();

	global $post, $project, $user_ID, $is_owner, $winner_id, $access_workspace, $is_workspace,$is_dispute, $role, $cvs_id, $list_bid, $bidding, $is_logged , $current_user_can_bid, $bid_query;

	$cvs_id = $is_owner = $access_workspace =  0;

	$role = bx_get_user_role();

	$project = BX_Project::get_instance()->convert($post);
	$current_user_can_bid  = current_user_can_bid( $project);

	$winner_id = $project->{WINNER_ID};
	$is_workspace = isset($_GET['workspace']) ? (int) $_GET['workspace'] : 0;
	$is_dispute = isset($_GET['dispute']) ? (int) $_GET['dispute'] : 0;

	if( is_owner_project( $project ) )
		$is_owner = $project->post_author;

	if( can_access_workspace($project) )
		$access_workspace = 1;

	if( $current_user_can_bid ){
		$bidding = is_current_user_bidded($project->ID);
	}


	the_post();

	$args = array(
		'post_type' => BID,
		'post_parent' => $project->ID,
		'posts_per_page' => -1,
	);

	$bid_query = new WP_Query($args);
	wp_reset_query();

?>

<div <?php post_class('container single-project site-container');?>>
	<div id="content" class="site-content">

        <div class="col-md-12">
        	<h1 class="project-title"><?php the_title();?></h1></div>
        	<div class="full heading">
        		<div class="full value-line">
        			<div class="col-md-5 col-xs-12 right-top-heading">

				      	<div class="col-md-4 col-xs-4"><span class="heading-label">Budget($) </span><span class="primary-color large-label"> <?php echo $project->_budget; ?> </span></div>
				      	<div class="col-md-4 col-xs-4"> <span class="heading-label">Bids </span> <span class="primary-color large-label"><?php echo $bid_query->found_posts;?></span></div>
				      	<div class="col-md-4 col-xs-4"> <span class="heading-label">Views  </span><span class="primary-color large-label"> 3 </span></div>
			      	</div>
			      	<?php
	      			if( $access_workspace ){
	      				if( in_array( $project->post_status, array('awarded','done','dispute','finish','disputing', 'disputed','archived') ) ){?>
	      					<div class="col-md-2 pull-right no-padding-left col-xs-6">
			      				<ul class="job-process-heading">

	      						<?php if( ! $is_workspace  ) { ?>
			      					<li class=" text-center <?php echo $class;?>"><a href="?workspace=1" class="primary-color"><i class="fa fa-clipboard" aria-hidden="true"></i> <?php _e('Go to Workspace','boxtheme');?></a>	</li>
			      				<?php } else {?>
			      					<li class="<?php echo $detail_section;?>"><a href="<?php echo get_permalink();?>" class="primary-color"><i class="fa fa-file-text-o" aria-hidden="true"></i></span> <?php _e('Back to Detail','boxtheme');?></a></li>
			      				<?php } ?>
			      				</ul>
			      			</div> <?php
			      		}
			      	}
			      	$_expired_date = get_post_meta($project->ID,'_expired_date', true);
			      	?>

			      	<div class="col-md-3 pull-right left-top-heading col-xs-12">
				      		<div class="job-status">
				      				<span class="time-job-left">
					      				<?php if( !empty( $_expired_date)){?>
					      					 <?php printf(__('%s left',ET_DOMAIN), human_time_diff( time(), strtotime($_expired_date)) ); ?>
					      				<?php } else {
					      					printf(__('Posted %s ago','boxtheme'), human_time_diff( get_the_time('U'), time() ) );
					      				} ?>
				      				</span>
				      				<span class="label-status primary-color"><?php echo box_project_status($project->post_status);?></span>
				      		</div>


			      	</div>
			    </div>

			</div> <!-- full !-->
        <div class="detail-project second-font">
            <div class="wrap-content"> <?php

       			if ( $access_workspace &&  $is_workspace ) {
       				get_template_part( 'template-parts/workspace');
      			} else if( $access_workspace && $is_dispute ){
      				get_template_part( 'template-parts/dispute' );
			    } else {
			    	$apply  = isset($_GET['apply']) ? $_GET['apply'] : '';

			    ?>
			    	<div class="full row-detail-section ">
				    	<div class="col-md-8 column-left-detail">
		   					<?php 	get_template_part('template-parts/single','project-detail' ); ?>
		   					<?php if( $apply == 1){?>
		   						<?php 	get_template_part('template-parts/single','project-detail-bid-form' ); ?>
		   					<?php } ?>
				       	</div> <!-- .col-md-8  Job details !-->
					    <div class="col-md-4 sidebar column-right-detail" id="single_sidebar"> <?php  	get_sidebar('project');?></div>
					</div>
					<div class="full row-detail-section">
		  				<?php get_template_part( 'template-parts/list', 'bid' ); ?>
	  				</div>
			    <?php } ?>
            </div> <!-- .wrap-content !-->
        </div> <!-- .detail-project !-->

	</div>
</div>

<?php get_template_part( 'template-parts/single','template-js' ); ?>

<?php get_footer();?>