<?php
	get_header();

	global $post, $project, $user_ID, $is_owner, $winner_id, $access_workspace, $is_workspace, $role, $cvs_id, $list_bid, $bidding, $is_logged , $current_user_can_bid;

	$cvs_id = $is_owner = $access_workspace = 0;
	$role = bx_get_user_role();

	$project = BX_Project::get_instance()->convert($post);
	$winner_id = $project->{WINNER_ID};
	$is_workspace = isset($_GET['workspace']) ? (int) $_GET['workspace'] : 0;

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

	function step_process(){
		global $project, $access_workspace, $winner_id;
		if( $access_workspace && $winner_id && in_array( $project->post_status, array('awarded','done','dispute','finish','disputing', 'disputed') ) ) { ?>
	    	<ul class="job-process-heading">
				<li><a href="<?php echo get_permalink();?>"> <span class="glyphicon glyphicon-list"></span> <?php _e('Job Detail','boxtheme');?></a></li>
				<li><a href="?workspace=1"> <span class="glyphicon glyphicon-saved"></span> <?php _e('Workspace','boxtheme');?></a>	</li>
	    	</ul> <?php
	    }
	}
	the_post();
?>

<div <?php post_class('container single-project site-container');?>>
	<div id="content" class="site-content">

        <div class="col-md-12">	<h1 class="project-title"><?php the_title();?></h1>  </div>

        <div class="detail-project">
            <div class="wrap-content">
       			<div class="full heading">
       				<div class ="col-md-2 no-padding-right"><?php printf(__('Status: %s','boxtheme'),$project->post_status); ?></div>
                  	<div class="col-md-3"><?php printf(__('Post date: %s','boxtheme'),get_the_date() );?></div>
                  	<div class="col-md-3"><?php printf(__("Fixed price: %s",'boxtheme'),get_box_price($project->_budget,true) ); ?> </div>
                  	<div class="col-md-4">
                  		<ul class="social-shares">
                  			<li class="share-item fb-share">
	                  		<div class="fb-share-button" data-href="<?php the_permalink();?>" data-size="small" data-mobile-iframe="true"><a class="fb-xfbml-parse-ignore" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?php get_permalink();?>&amp;src=sdkpreparse">Share</a> </div>
	                  		</li>
                  		<li class="share-item gplus-share"><g:plusone align="right"></g:plusone></li>
						<li class="share-item  tw-share"><a class="twitter popup" href="http://twitter.com/share">Tweet</a></li>
						</ul>

                  	</div>
       			</div> <!-- full !-->

       			<?php

       			if ( ! $is_workspace ) { ?>
       				<div class="col-md-8">
       					<?php 	get_template_part('template-parts/single','project-detail' ); ?>

			       	</div> <!-- .col-md-8  Job details !-->
				    <div class="col-md-4 sidebar" id="single_sidebar">
				    	<?php 	step_process();?>
	          			<?php  	get_sidebar('project');?>
      				</div>
      				<div class="col-md-12">
      				<?php get_template_part( 'template-parts/list', 'bid' ); ?>
      				</div><?php
      			} else {
			       		get_template_part( 'template-parts/workspace' );
			    } ?>
            </div> <!-- .wrap-content !-->
        </div> <!-- .detail-project !-->

	</div>
</div>

<?php get_template_part( 'template-parts/single','template-js' ); ?>

<?php get_footer();?>