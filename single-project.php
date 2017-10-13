<?php
	get_header();

	global $post, $project, $user_ID, $is_owner, $winner_id, $access_workspace, $is_workspace,$is_dispute, $role, $cvs_id, $list_bid, $bidding, $is_logged , $current_user_can_bid;

	$cvs_id = $is_owner = $access_workspace = 0;
	$role = bx_get_user_role();

	$project = BX_Project::get_instance()->convert($post);
	$winner_id = $project->{WINNER_ID};
	$is_workspace = isset($_GET['workspace']) ? (int) $_GET['workspace'] : 0;
	$is_dispute = isset($_GET['dispute']) ? (int) $_GET['dispute'] : 0;

	if( is_owner_project( $project ) )
		$is_owner = $project->post_author;

	if( can_access_workspace($project) )
		$access_workspace = 1;

	if ( is_user_logged_in() ) {
		$is_logged = 1;
		if( current_user_can_bid( $project) && $project->post_author != $user_ID ){ // chec post_status = publish and freelancer role.
			// is freelancer and logged
			$current_user_can_bid = 1;
			$bidding = is_current_user_bidded($project->ID);
		}
	}

	function step_process( $is_workspace ){
		global $project, $access_workspace, $winner_id, $is_dispute;
		$class = $detail_section = $dispute_section = '';
		if( $is_workspace ){
			$class ='current-section';
		} else if( $is_dispute) {
			$dispute_section = 'current-section';
		} else {
			$detail_section = 'current-section';
		}

		if( $access_workspace && in_array( $project->post_status, array('awarded','done','dispute','finish','disputing', 'disputed','archived') ) ) { ?>
	    	<ul class="job-process-heading">
				<li class="<?php echo $detail_section;?>"><a href="<?php echo get_permalink();?>"> <span class="glyphicon glyphicon-list"></span> <?php _e('Job Detail','boxtheme');?></a></li>
				<li class=" text-center <?php echo $class;?>"><a href="?workspace=1"> <span class="glyphicon glyphicon-saved"></span> <?php _e('Workspace','boxtheme');?></a>	</li>
				<li class="text-right <?php echo $dispute_section;?>"><a href="?dispute=1"> <span class="glyphicon glyphicon-saved"></span> <?php _e('Dispute','boxtheme');?></a>	</li>
	    	</ul> <?php
	    }
	}
	the_post();
?>

<div <?php post_class('container single-project site-container');?>>
	<div id="content" class="site-content">

        <div class="col-md-12">
        	<h1 class="project-title"><?php the_title();?></h1></div>
        	<div class="full heading">
        		<div class="full">
        			<div class ="col-md-2 no-padding-right"><?php _e('Status','boxtheme');?></div>
			      	<div class="col-md-3">Post date</div>
			      	<div class="col-md-3">Budget</div>
			      	<div class="col-md-4">
			      	</div>
        		</div>
        		<div class="full">
					<div class ="col-md-2 no-padding-right"> <?php echo $project->post_status; ?></div>
			      	<div class="col-md-3"><?php echo get_the_date();?></div>
			      	<div class="col-md-3"><?php echo box_get_price_format($project->_budget); ?> </div>
			      	<div class="col-md-4"> 	<?php
			      	global $access_workspace;

			      	if( $project->post_status != 'publish' && $access_workspace ) {
			      		step_process($is_workspace);
			      	} else {
			      		box_social_share();
			      	} ?>
			      	</div>
			    </div>

			</div> <!-- full !-->
        <div class="detail-project">
            <div class="wrap-content"> <?php

       			if ( $access_workspace &&  $is_workspace ) {
       				get_template_part( 'template-parts/workspace');
      			} else if( $access_workspace && $is_dispute ){
      				get_template_part( 'template-parts/dispute' );
			    } else { ?>
			    	<div class="full row-detail-section">
				    	<div class="col-md-8 left-project-column">
		   					<?php 	get_template_part('template-parts/single','project-detail' ); ?>

				       	</div> <!-- .col-md-8  Job details !-->
					    <div class="col-md-4 sidebar right-project-column" id="single_sidebar"> <?php  	get_sidebar('project');?></div>
					</div>
					<div class="full row-detail-section">
		  				<div class="col-md-12">	<?php get_template_part( 'template-parts/list', 'bid' ); ?>				</div>
	  				</div>
			    <?php } ?>
            </div> <!-- .wrap-content !-->
        </div> <!-- .detail-project !-->

	</div>
</div>

<?php get_template_part( 'template-parts/single','template-js' ); ?>

<?php get_footer();?>