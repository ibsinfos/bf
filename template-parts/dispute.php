<div class="col-md-8 wrap-workspace dispute-section">
		<div class="col-md-12">
			<h3>History of Dispute flow </h3>
			<?php
			global $project, $winner_id, $cvs_id;
			$feebacks = BX_Message::get_instance($cvs_id)->get_converstaion_custom('disputing');
			$bid_author = get_userdata($winner_id);
			$employer = get_userdata($project->post_author);

			$display_name = array(
				$winner_id => $bid_author->display_name,
				$project->post_author => $employer->display_name,
			);
			foreach ($feebacks as $key => $msg) {
				//echo '<div class="col-avatar">'.get_avatar( $msg->sender_id, 39).'<div>';

				echo '<p>'.$display_name[$msg->sender_id].' feedback in <small>'.$msg->msg_date.'</small> : </p>';
				echo $msg->msg_content .'<br />' ;

				# code...
			}
			?>
			<form class="swp-send-message"  >
				<textarea name="msg_content" class="full msg_content" required rows="3" placeholder="<?php _e('Leave your feedback here','boxtheme');?>"></textarea>
				<input type="hidden" name="cvs_id" value="<?php echo $cvs_id;?>">
				<input type="hidden" name="receiver_id" value="<?php echo $winner_id;?>">
				<input type="hidden" name="project_id" value="<?php echo $project_id;?>">
				<input type="hidden" name="msg_type" value="disputing">

				<input type="hidden" name="method" value="insert">
				<br />
				<button type="submit" class="btn btn-send-message align-right f-right"><?php _e('Send','boxtheme');?></button>
			</form>
		</div>
</div>