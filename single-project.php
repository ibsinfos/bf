<?php
	global $post;
	$cviews = (int) get_post_meta( $post->ID, BOX_VIEWS, true );

	if ( $post->post_status == 'publish' ) {
		$cookie = 'cookie_' . $post->ID . '_visited';
		if ( ! isset( $_COOKIE[$cookie] ) ) {
			update_post_meta( $post->ID, BOX_VIEWS , $cviews + 1 );
			setcookie( $cookie, 'is_visited', time() + 3*3600 );
		}
	}
	global $post, $project, $user_ID, $is_owner, $winner_id, $can_access_workspace, $is_workspace,$is_dispute, $role, $cvs_id, $list_bid, $bidding, $is_logged , $current_user_can_bid, $bid_query;

	get_header();

	$cvs_id = $is_owner = $can_access_workspace =  $bidding = 0;

	$role = bx_get_user_role();

	$project = BX_Project::get_instance()->convert($post);
	$current_user_can_bid  = current_user_can_bid( $project);

	$winner_id = $project->{WINNER_ID};
	$is_workspace = isset($_GET['workspace']) ? (int) $_GET['workspace'] : 0;
	$is_dispute = isset($_GET['dispute']) ? (int) $_GET['dispute'] : 0;

	if( is_owner_project( $project ) )
		$is_owner = $project->post_author;

	if( can_access_workspace($project) )
		$can_access_workspace = 1;

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

				      	<div class="col-md-3 col-xs-4"><span class="heading-label">Budget($) </span><span class="primary-color large-label"> <?php echo $project->_budget; ?> </span></div>
				      	<div class="col-md-2 col-xs-4"> <span class="heading-label">Bids </span> <span class="primary-color large-label"><?php echo $bid_query->found_posts;?></span></div>
				      	<div class="col-md-3 col-xs-4"> <span class="heading-label">Views  </span><span class="primary-color large-label"> <?php echo $cviews;?> </span></div>
			      	</div>
			      	<?php

	      			if( $can_access_workspace ){
	      				if( in_array( $project->post_status, array('awarded','done','dispute','finish','disputing', 'disputed','archived') ) ){?>
	      					<div class="col-md-2 pull-right no-padding-left col-xs-6">
			      				<ul class="job-process-heading">

	      						<?php

	      						if( ! $is_workspace ||  $project->post_status == 'resolved'   ) { ?>
			      					<li class=" text-center "><a href="?workspace=1" class="primary-color"><i class="fa fa-clipboard" aria-hidden="true"></i> <?php _e('Go to Workspace','boxtheme');?></a>	</li>
			      				<?php } else { ?>
			      					<li class=""><a href="<?php echo get_permalink();?>" class="primary-color"><i class="fa fa-file-text-o" aria-hidden="true"></i></span> <?php _e('Back to Detail','boxtheme');?></a></li>
			      					<?php if( $project->post_status == 'disputing' ){ ?>
			      						<li class=""><a href="?dispute=1" class="primary-color"><i class="fa fa-file-text-o" aria-hidden="true"></i></span> <?php _e('Disputing section','boxtheme');?></a></li>
			      					<?php } ?>
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

       			if ( $can_access_workspace && ( $is_workspace || $is_dispute ) ){

       				$cvs_id = is_sent_msg($project->ID, $winner_id);
       				if( $is_workspace ) {
       					get_template_part( 'template-parts/workspace');
      				} else if( $is_dispute ){
      					get_template_part( 'template-parts/dispute' );
			   		}
			   	} else {

			    	$apply  = isset($_GET['apply']) ? $_GET['apply'] : '';   ?>

			    	<div class="full row-detail-section ">
				    	<div class="col-md-8 column-left-detail">
		   					<?php 	get_template_part('template-parts/single','project-detail' ); ?>
		   					<?php if ( $apply == 1 ){?>
		   						<?php 	get_template_part('template-parts/single','project-detail-bid-form' ); ?>
		   					<?php } ?>
				       	</div> <!-- .col-md-8  Job details !-->
					    <div class="col-md-4 sidebar column-right-detail" id="single_sidebar"> <?php  	get_sidebar('project');?></div>
					</div>
					<div class="full row-detail-section row-list-bid">
		  				<?php get_template_part( 'template-parts/list', 'bid' ); ?>
	  				</div>
			    <?php } ?>
            </div> <!-- .wrap-content !-->
        </div> <!-- .detail-project !-->

	</div>
</div>

<?php get_template_part( 'template-parts/single','template-js' ); ?>

<?php get_footer();?>