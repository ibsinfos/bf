<?php

global $cvs_id, $project, $list_bid, $role;
$project->cvs_id = $cvs_id;
$list_bid
?>
<div id="frame_chat">
	<button class="btn btn-close"> x </button>
	<div class="frm_content">
	</div>

	<div class="reply_input">
	</div>
	<div class="right-scroll" style="padding: 30px;">
	</div>
</div>
<script type="text/html" id="tmpl-send_message">
	<form class="emp-send-message" >
		<textarea name="cvs_content" class="full msg_content" rows="3" placeholder="<?php _e('Type your message here','boxtheme');?>"></textarea>
		<br />
		<button type="submit" class="btn btn-send-message f-right"><?php _e('Send','boxtheme');?></button>
	</form>
</script>

<script type="text/html" id="tmpl-msg_record_wsp">
	<div class="msg-record msg-item full">
			<div class="msg-record msg-item">
				<div class="col-md-1 no-padding-right col-chat-avatar">{{{data.avatar}}}</div>
				<div class="col-md-9 no-padding-right col-msg-content">
					<span class="wrap-text "><span class="triangle-border left">{{{data.msg_content}}}</span></span>
				</div>
				<div class="col-md-2 col-msg-time"><span class="msg-mdate">{{{data.msg_date}}}</span></div>
			</div>
	</div>
</script>


<script type="text/html" id="tmpl-full_info">
	<div class="full-info">
		<div class="row">
			<div class="col-md-12">
				<center>{{{data.avatar}}}</center>
				<center><h2 class="profile-title no-margin">{{{data.display_name}}}</h2></center>
				<center><h4 class="professional-title no-margin">{{{data.professional_title}}}</h4></center>
			</div>
			<div class="col-md-12">
				{{{data.skill_text}}}
			</div>
			<div class="col-md-12">
				<h3>Overviews:</h3>
				{{{data.post_content}}}
			</div>

			<# _.each( data.feedbacks, function( feeback ) { #>
				<div class="col-md-12">
					<div class="col-md-9 no-padding">{{{feeback.project_link}}}</div>
					<div class="col-md-3 no-padding">
					<start class="rating-score clear block core-{{{feeback.rating}}}">
						<i class="fa fa-star" aria-hidden="true"></i>
						<i class="fa fa-star" aria-hidden="true"></i>
						<i class="fa fa-star" aria-hidden="true"></i>
						<i class="fa fa-star" aria-hidden="true"></i>
						<i class="fa fa-star" aria-hidden="true"></i>

					</start>
					</div>
					<div class="review"><i>{{{feeback.comment_content}}}</i></div>
				</div>
			<#  }) #>
		</div>
	</div>
</script>

<script type="text/html" id="tmpl-award_form">
	<!-- Award form !-->
	<form id="frm_award" class="frm-award"  method="post">
		<div class="row">
			<div class="col-md-12">
				<h2> <?php _e('Assign task','boxtheme');?> </h2>
			</div>
		</div>
		<div class="row">
		    <div class="form-group col-md-12">
		        <label> <?php _e('Freelancer: {{{data.fre_displayname}}}','boxtheme');?> </label>
		    </div>
		</div>
		<div class="row">
		    <div class="form-group col-md-12">
		        <label> <?php _e('You will deposit: {{{data.emp_pay}}}','boxtheme');?> </label>
		    </div>
		</div>
		<div class="row">
		    <div class="form-group col-md-12">
		        <label> <?php _e('Fee service: {{{data.commission_fee}}}','boxtheme');?> </label>
		    </div>
		</div>

		<div class="row">
		    <div class="form-group col-md-12">
		        <label> <?php _e('Freelancer will be received:<a href="#" data-toggle="tooltip" title="Some tooltip text!">?</a> {{{data.fre_receive}}}','boxtheme');?></label>
		    </div>
		</div>
		<div class="row">
		    <div class="form-group col-md-12">
		        <textarea  class="form-control" name="award_msg" placeholder="<?php _e('Your message','boxtheme');?>" ></textarea>
		        <input type="hidden" name="bid_id" value="{{{data.ID}}}">
		        <input type="hidden" name="freelancer_id" value="{{{data.post_author}}}">
		        <input type="hidden" name="project_id" value="<?php echo $project->ID;?>" value="">

		    </div>
		</div>
		<div class="form-group row">
		<div class="col-md-12">
		    <button class="btn btn-xlarge btn-action f-right" type="submit" ><?php _e('Assign task','boxtheme');?></button>
		</div>

		</div>
	</form>
	<!-- Award form !-->
</script>
<script type="text/template" id="json_project"><?php  echo json_encode($project); ?></script>
<script type="text/template" id="json_list_bid"><?php   echo json_encode($list_bid); ?></script>
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
		            	<i class="fa fa-star" aria-hidden="true"></i>
		            	<i class="fa fa-star" aria-hidden="true"></i>
		            	<i class="fa fa-star" aria-hidden="true"></i>
		            	<i class="fa fa-star" aria-hidden="true"></i>
		            	<i class="fa fa-star" aria-hidden="true"></i>
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
	            	<i class="fa fa-star" aria-hidden="true"></i>
	            	<i class="fa fa-star" aria-hidden="true"></i>
	            	<i class="fa fa-star" aria-hidden="true"></i>
	            	<i class="fa fa-star" aria-hidden="true"></i>
	            	<i class="fa fa-star" aria-hidden="true"></i>
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
<!-- ENd modal mark ad finish !-->

<div class="modal fade" id="quytModal" tabindex="-1" role="dialog" aria-labelledby="quytModal">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<?php
					$lb_reason = __('Let employer your reason','boxtheme');
					$lb_title = __('Cancel and quyt this job');

					if($role == EMPLOYER) {
						$lb_reason = __('Let freelancer your reason','boxtheme');
						$lb_title = __('Cancel and quyt this job');
					}
				?>
				<h4 class="modal-title" id="quytModal"> <?php echo $lb_title;?></h4>
			</div>
		  	<div class="modal-body">
		  		<form id="frm_quit_job">
		          	<div class="form-group">
		            	<label for="message-text" class="control-label"><?php echo $lb_reason;?></label>
		            	<textarea class="form-control no-radius" rows="6" id="message-text" name="<?php echo REVIEW_MSG;?>"></textarea>
		            	<input type="hidden" name="project_id" value="<?php echo $project->ID;?>">
		            </div>
		            <div class="form-group"><button type="submit" class="btn btn-primary">Confirm and Submit</button> </div>
		        </form>
		  	</div>
		</div>
	</div>
</div>