<?php
	global $user_ID, $project, $winner_id, $is_owner, $cvs_id, $role;
	$is_fre_review = get_post_meta( $project->ID,'is_fre_review', true );
	$bid_id_win = get_post_meta($project->ID, BID_ID_WIN, true);

	$_bid_price = get_post_meta($bid_id_win, BID_PRICE, true);


?>
<div class="full row-detail-section">
	<div class="col-md-8 wrap-workspace  column-left-detail">
		<div class="full align-right f-right ws-btn-action"> <?php
			if( $project->post_status =='awarded'  ){
				$fre_markedascomplete = get_post_meta( $project->ID, 'fre_markedascomplete', true);
				if( $user_ID == $project->post_author ){ // employer  ?>
					<button type="button" class="btn btn-quit" data-toggle="modal" data-target="#disputeModal" data-whatever="@mdo"><?php _e('Dispute','boxtheme');?></button>
					<button type="button " class="btn btn-finish" data-toggle="modal" data-target="#reviewModal" data-whatever="@mdo"><?php _e('Mark as Finish','box_theme');?></button>
				<?php } else if( $user_ID == $winner_id  ){
					if( empty($fre_markedascomplete)){ ?>
						<button type="button" class="btn btn-quit" data-toggle="modal" data-target="#quytModal" data-whatever="@mdo"><?php _e('Quit Job','boxtheme');?></button>
					<?php  }?>

					<?php if ( empty( $fre_markedascomplete ) ) { ?>
						<button type="button " class="btn btn-finish" data-toggle="modal" data-target="#freMarkAsComplete" data-whatever="@mdo"><?php _e('Mark as Complete','boxtheme');?></button>
					<?php } else {?>
						<button type="button" class="btn btn-quit" data-toggle="modal" data-target="#disputeModal" data-whatever="@mdo"><?php _e('Dispute','boxtheme');?></button>
					<?php } ?>

				<?php }

			} else if( $project->post_status == 'done' && $user_ID == $winner_id && !$is_fre_review ) { ?>
					<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#reviewModal" data-whatever="@mdo"><?php _e('Review','boxtheme');?></button> <?php

			} ?>

		</div>
		<?php

		if($project->post_status == DONE) {
			echo '<div class="full review-section">'; ?>

				<?php
				echo '<p>'; _e('Job is done.','boxtheme'); echo '</p>';

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
	<div class="fb-history full col-md-12">
		<h3 class="default-label">History feedback </h3>
		<?php
		if( !empty($fre_markedascomplete) ){
			echo 'Freelancer marked as complete in 10/2017';
		}
		if($project->post_status == 'disputing' ){
			$user_send_id = get_post_meta($project->ID, 'user_send_dispute', true);
			$disputor = get_userdata( $user_send_id );
			printf( __('%s sent a dispute request to system. This job is disputing and wait admin review. Go to <a href="?dispute=1"> dispute section </a> to see the processing. In the whole process the disputing case. Chat will be disabled.','boxtheme'), $disputor->display_name );
		}
		?>
	</div>

	<?php

		show_conversation($winner_id, $project, $cvs_id);

	?>

	<?php  echo '<input type="hidden" id="cvs_id" value="'.$cvs_id.'" />';		?>
	</div> <!-- wrap-workspace !-->

	<div class="col-md-4  column-right-detail">
		<div class="full">
			<?php if( ! $is_fre_review  ){?>
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

				$fre_acc = get_userdata($winner_id);
				$emp_acc = get_userdata($project->post_author);

				$attachments = get_posts( $args );
				$display = array(
					$project->post_author => $emp_acc->display_name,
					$winner_id =>$fre_acc->display_name,
				);
				echo '<ul class="list-attach clear block none-style">';
			    if ( $attachments ) {
			        foreach ( $attachments as $attachment ) {
			           echo '<li class="full f-left">';
			           echo '<label class="full">'.$display[$attachment->post_author] .'</label>';
			           echo $attachment->post_title;
			           echo '<span id="'.$attachment->ID.'" class="btn-del-attachment">(x)</span> </li>';

			        }
			    }
			    echo '</ul>'; ?>
			</div>
		</div>
	</div>
</div>
