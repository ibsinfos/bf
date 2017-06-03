<?php
global $wp_query;
?>
<?php get_header(); ?>
<?php
	global $post, $project, $user_ID, $is_owner, $winner_id, $access_workspace, $is_workspace, $role;
	the_post();
	$role = bx_get_user_role();
	$project = BX_Project::get_instance()->convert($post);
	$is_workspace = isset($_GET['workspace']) ? (int) $_GET['workspace'] : 0;
	$winner_id = $project->{WINNER_ID};
	if( is_owner_project( $project ) ){
		$is_owner = $project->post_author;
	}
	if( can_access_workspace($project) ){
		$access_workspace = 1;
	}
?>

<div <?php post_class('container single-project site-container');?>>
	<div id="content" class="row">
		<?php if( $is_workspace && $access_workspace ){
			get_template_part( 'template-parts/workspace' );
		} else { ?>

         <div class="col-md-12">
			    <h1 class="project-title"><?php the_title();?></h1>
         </div>

        <div class="detail-project">
            <div class="wrap-content">
       			<div class="full heading">
       				<div class ="col-md-2 no-padding-right"><?php printf(__('Status: %s','boxtheme'),$project->post_status); ?></div>
                  	<div class="col-md-3"><?php printf(__('Post date: %s','boxtheme'),get_the_date() );?></div>
                  	<div class="col-md-3"><?php printf(__("Fixed price: %s",'boxtheme'),get_box_price($project->_budget,true) ); ?> </div>
                  	<div class="col-md-3"><?php _e('Need urgent finish','boxtheme');?> </div>

       			</div> <!-- full !-->

               	<div class="col-md-8">
               		<h3> <?php _e('Job details','boxtheme');?> </h3>
          			<?php the_content(); ?>
                    <?php
	                    $args = array(
	                        'post_status' => 'any',
	                        'post_type'   => 'attachment',
	                        'post_parent' => $project->ID,
	                    );
	                    $att_query = new WP_Query( $args );
	                    if( $att_query-> have_posts() ){
	                        echo '<p>';
	                        echo '<h3>'.__('Files attach: ','boxtheme').'</h3>';
	                        $files = array();
	                        while ( $att_query-> have_posts()  ) {
	                            global $post;
	                            $att_query->the_post();
	                            $feat_image_url = wp_get_attachment_url( $post->ID );
	                            $files[] = '<span> <a class="text-color" href="'.$feat_image_url.'">'.get_the_title().'</a></span> ';
	                        }
	                        echo join(",",$files);
	                        echo '</p>';
	                    }
                    ?>
                    <?php  if( !$is_workspace){ get_template_part( 'template-parts/list', 'bid' ); } ?>

          		</div> <!-- .col-md-8  Job details !-->
          		<div class="col-md-4 sidebar" id="single_sidebar">
          		<?php  get_sidebar('project');?>
          		</div>


            </div> <!-- .wrap-content !-->
        </div> <!-- .detail-project !-->
		<?php } ?>
	</div>

</div>
<div id="frame_chat">test
</div>
<script type="text/template" id="">

</script>
<script type="text/html" id="tmpl-bid_form">
	<form class="frm-conversation  send-message" >
			<textarea name="cvs_content" class="full cvs_content" rows="6" placeholder="<?php _e('Type your message here','boxtheme');?>"></textarea>
			<!-- <input type="hidden" name="cvs_freelancer_id" value="{{{data.freelancer_id}}}">
			<input type="hidden" name="cvs_project_id" value="{{{data.project_id}}}"> -->
			<br />
			<button type="submit" class="btn btn-send-message align-right f-right"><?php _e('Send','boxtheme');?></button>
	</form>

</script>
<script type="text/template" id="json_project"><?php global $convs_id; $project->convs_id = $convs_id; echo json_encode($project); ?></script>
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="exampleModalLabel">
			<?php if($role == FREELANCER) {?>
			  	Review employer of this project
			<?php } else { ?>
					Mark as finish and review project
			<?php }?>
			</h4>
		</div>
      	<div class="modal-body">
      		<?php if($role == FREELANCER){ ?>
      	 	<form id="frm_fre_review">
	          	<div class="form-group">
	            	<label for="message-text" class="control-label">Review </label>
	            	<textarea class="form-control no-radius" rows="6" id="message-text" name="<?php echo REVIEW_MSG;?>"></textarea>
	            	Rating:
	            	<start class="rating-score clear block" title="1">
		            	<span class="glyphicon glyphicon-star" title="1"></span>
		            	<span class="glyphicon glyphicon-star" title="2"></span>
		            	<span class="glyphicon glyphicon-star" title="3"></span>
		            	<span class="glyphicon glyphicon-star" title="4"></span>
		            	<span class="glyphicon glyphicon-star" title="5"></span>
	            	</start>
	            	<input type="hidden" name="<?php echo RATING_SCORE;?>" id="rating_scrore" value="">
	            	<input type="hidden" name="project_id" value="<?php echo $project->ID;?>" value="">
	          	</div>
	          	<div class="form-group align-right">
	        		<button type="submit" class="btn btn-primary">Send</button>
	          	</div>
        	</form>
      	<?php } else { ?>
        <form id="frm_emp_review">
          	<div class="form-group">
            	<label for="message-text" class="control-label">Review </label>
            	<textarea class="form-control no-radius" rows="6" id="message-text" name="<?php echo REVIEW_MSG;?>"></textarea>
            	Rating:
            	<start class="rating-score clear block" title="1">
	            	<span class="glyphicon glyphicon-star" title="1"></span>
	            	<span class="glyphicon glyphicon-star" title="2"></span>
	            	<span class="glyphicon glyphicon-star" title="3"></span>
	            	<span class="glyphicon glyphicon-star" title="4"></span>
	            	<span class="glyphicon glyphicon-star" title="5"></span>
            	</start>
            	<input type="hidden" name="<?php echo RATING_SCORE;?>" id="rating_scrore" value="">
            	<input type="hidden" name="project_id" value="<?php echo $project->ID;?>" value="">
          	</div>
          	<div class="form-group align-right">
        	<button type="submit" class="btn btn-primary">Mark as finish</button>
          </div>
        </form>
        <?php }   ?>
        <button type="button" class="btn btn-default btn-close-modal" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>

<?php get_footer();?>
