<?php
	global $user_ID, $project, $winner_id, $is_owner, $convs_id, $role;
	$is_fre_review = get_post_meta( $project->ID,'is_fre_review', true );
	$bid_id_win = get_post_meta($project->ID, BID_ID_WIN, true);

	$_bid_price = get_post_meta($bid_id_win, BID_PRICE, true);

?>
<div class="col-md-8 wrap-workspace">
	<div class="row">
		<div class="col-md-7"><h3> <?php _e('Workspace place','boxtheme');?> </h3> </div>
		<div class="col-md-5">
			<div class="full align-right f-right ws-btn-action"> <?php

				if( $project->post_status =='awarded' ){

					if( $user_ID == $project->post_author ){ // employer  ?>

						<button type="button" class="btn btn-quit" data-toggle="modal" data-target="#quytModal" data-whatever="@mdo"><?php _e('Quit','boxtheme');?></button>
						<button type="button " class="btn btn-finish" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo">Mark as Finish</button>
						<?php }

				} else if( $user_ID == $winner_id && !$is_fre_review) { // freelancer ?>

						<button type="button " class="btn btn-finish" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo">Mark as Complete</button>
						<button type="button" class="btn btn-quit" data-toggle="modal" data-target="#quytModal" data-whatever="@mdo"><?php_e('Quit','boxtheme');?></button> <?php

				} else if( $project->post_status == 'done' && $user_ID == $winner_id && !$is_fre_review) { ?>
						<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo"><?php _e('Review','boxtheme');?></button> <?php

				} ?>

			</div>
		</div>
	</div><?php

	_e('Excerpt:','boxtheme'); ?>

	<div class="ws-project-des" ><?php the_excerpt_max_charlength(get_the_content($project->ID), 300); ?></div> 	<?php

	if($project->post_status == DONE){
		echo '<div class="full review-section">'; ?>

			<h3 class="no-margin"><?php _e('Review section','boxtheme');?></h3>	<?php

			// show rating here.
			$bid_id = get_post_meta($project->ID,BID_ID_WIN, true);
			$args = array(
				'post_id' => $bid_id,
				'type' => 'emp_review',
				'number' => 1,
			);
			$emp_comment = get_comments($args);

			if( !empty( $emp_comment ) ){
				echo '<div class="full rating-line">';
				if(  ( $role == FREELANCER && $is_fre_review ) || $role != FREELANCER ) {
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
				_e('Employer did not left a review','boxtheme');
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
	} ?>

	<h3> <?php _e('Chat coversation','boxtheme');?></h3>
	<?php	$cvs_id = is_sent_msg($project->ID, $winner_id);	?>
<?php show_conversation($winner_id, $project->ID, $cvs_id); ?>

<?php  echo '<input type="hidden" id="cvs_id" value="'.$cvs_id.'" />';		?>
</div> <!-- wrap-workspace !-->

<div class="col-md-4">
	<?php step_process();?>

	<div class="full">
		<h3>Process info:</h3>
		<ul class="none-style">
			<?php
			$status = array('awarded' => 'Working',
				'done' 		=> 'Done',
				'disputing' => 'Disputing',
				'disputed' 	=> 'Disputed',
			);
			?>
			<li> Award date: March 20, 2017</li>
			<li> Status: <?php echo $status[$project->post_status];?></li>
			<li> Bid price: <?php echo get_box_price($_bid_price) ?></li>
			<?php if($project->post_status == 'done'){?>
				<li>Finish: March 20, 2017</li>
			<?php } ?>
		</ul>
		<?php if( !$is_fre_review  ){?>
			<div id="container_file" class="clear block">
			    <button class="btn f-right btn-add-file" id="pickfiles"><i class="fa fa-upload" aria-hidden="true"></i> + Add File </button>
			</div>
		<?php } ?>
		<div id="filelist" class="full">
			<!-- // nho check case post_parent when set featured 1 image -->
			<?php
			$args = array(
			   'post_type' => 'attachment',
			   'numberposts' => -1,
			   'post_status' => null,
			   'post_parent' => $post->ID
			  );

			$attachments = get_posts( $args );
			echo '<ul class="list-attach clear block none-style">';
		    if ( $attachments ) {
		        foreach ( $attachments as $attachment ) {
		           echo '<li class="inline f-left">';
		           //the_attachment_link( $attachment->ID, true );
		           echo $attachment->post_title;
		           echo '<span id="'.$attachment->ID.'" class="btn-del-attachment">(x)</span> </li>';
		        }
		    }
		    echo '</ul>'; ?>
		</div>
	</div>
</div>
