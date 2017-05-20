<?php
global $user_ID, $project, $winner_id, $is_owner, $convs_id, $role;
?>
<div class="col-md-8">
<?php echo '<h3> Workspace of project '.$project->post_title.'</h3>'; ?>
<?php _e('Description:','boxtheme'); ?>
<div class="ws-project-des">
<?php the_excerpt_max_charlength(get_the_content($project->ID), 300); ?>
</div>
<p class="align-right"><a target="_blank" href="<?php echo get_permalink($project->ID);?>"> <?php _e('Project detail','boxtheme');?> </a> </p>
<?php
$is_fre_review = get_post_meta($project->ID,'is_fre_review', true);
if($project->post_status == DONE){
	echo '<div class="full review-section">';
	?>
		<h3 class="no-margin"> Review section</h3>
		<?php

		// show rating here.
		$bid_id = get_post_meta($project->ID,BID_ID_WIN, true);

			$args = array(
				'post_id' => $bid_id,
				'type' => 'emp_review',
				'number' => 1,
			);
		$emp_comment = get_comments($args);
		if( !empty( $emp_comment )){
			echo '<div class="full rating-line">';
			if( ($role == FREELANCER && $is_fre_review) || $role != FREELANCER) {
				echo '<label>'.__('Employer review:','boxtheme').'</label>';
					$rating_score = get_comment_meta( $emp_comment[0]->comment_ID, RATING_SCORE, true );
					bx_list_start($rating_score);
					echo '<i>'.$emp_comment[0]->comment_content.'</i>';
			} else if( !$is_fre_review){
				//freelancer still not review employer yet.
				_e('Employer reviewed and mark as close this project. <br />You have to  review the project to see employer\'s review.','boxtheme');
			}
			echo '</div>';
		} else{
			_e('Employer did not left a review');
		}

		$args = array(
			'post_id' => $project->ID,
			'type' => 'fre_review',
			'number' => 1,
		);
		$fre_comment = get_comments($args);
		if( ! empty( $fre_comment) ) {
			echo '<div class="full rating-line">';
			echo '<label>'.__('Freelancer review:','boxtheme').'</label>';

				$rating_score = get_comment_meta( $fre_comment[0]->comment_ID, RATING_SCORE, true );
				bx_list_start($rating_score);
				echo '<i>'.$fre_comment[0]->comment_content.'</i>';

			echo '</div>';
		}

	echo '</div>';
}
?>
<?php echo '<h3>'.__('Chat coversation','boxtheme').'</h3>'; ?>
<?php show_conversation($winner_id, $project->ID); ?>
</div>
<div class="col-md-4">
	<div class="full align-right">

		<?php if($project->post_status =='awarded' && $user_ID == $project->post_author ){ ?>
				<button class="btn   align-right "> &nbsp; <?php _e('Quit','boxtheme');?> &nbsp; </button>
		<button type="button" class="btn  align-right" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo">Mark as finish</button>
		 &nbsp; &nbsp; &nbsp;  &nbsp;
		<?php } else if($project->post_status == 'done' && $role == FREELANCER && !$is_fre_review) { ?>
			<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo">Review employer</button>
		<?php } ?>
	</div>
	<div class="full">
		<h3>Project:</h3>
		<ul>
			<?php
			$status = array('awarded' => 'Working',
				'done' 		=> 'Done',
				'disputing' => 'Disputing',
				'disputed' 	=> 'Disputed',
			);
			?>
			<li> Award date: March 20, 2017</li>
			<li> Dealine: March 20, 2017</li>
			<li> Status: <?php echo $status[$project->post_status];?></li>
			<?php if($project->post_status == 'done'){?>
				<li>Finish: March 20, 2017</li>
			<?php } ?>
		</ul>
		<?php if($is_owner){ ?>
			<h3>Freelancer:</h3>
			<ul>
				<li> Hour rate: 30$</li>
				<li> Score: 5*</li>
				<li> Country: US</li>
			</ul>

		<?php } else { ?>
		<h3>Employer:</h3>
		<ul>
			<li> David Kent</li>
			<li> Project posted: 300</li>
			<li> Scrore: 5*</li>
			<li> Country: US</li>
		</ul>
		<?php } ?>
		Milestones:
		<ul>
			<li> Milestone 1</li>
			<li> Milestone 2</li>
			<li> Milestone 3</li>
		</ul>
		<?php if( !$is_fre_review  ){?>
			<div id="container_file" class="clear block">
			    <button class="btn f-right" id="pickfiles"><i class="fa fa-upload" aria-hidden="true"></i> + Add File </button>
			</div>
		<?php } ?>
		<div id="filelist" class="full row">
			<!-- // nho check case post_parent when set featured 1 image -->
			<?php
			$args = array(
			   'post_type' => 'attachment',
			   'numberposts' => -1,
			   'post_status' => null,
			   'post_parent' => $post->ID
			  );

			$attachments = get_posts( $args );
			echo '<ul class="list-attach clear block">';
		    if ( $attachments ) {
		        foreach ( $attachments as $attachment ) {
		           echo '<li class="inline f-left">';
		           //the_attachment_link( $attachment->ID, true );
		           echo $attachment->post_title;
		           echo '<span id="'.$attachment->ID.'" class="btn-del-attachment">(x)</span> </li>';
		        }
		    }
		    echo '</ul>';

			?>
		</div>

	</div>
</div>
