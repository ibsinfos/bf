<div class="col-md-8 wrap-workspace">
		<div class="col-md-12">
			<h3>History of Dispute flow </h3>
			<?php
			global $project, $winner_id, $cvs_id;
			$feebacks = BX_Message::get_instance($cvs_id)->get_converstaion_custom('disputing');
			foreach ($feebacks as $key => $msg) {
				echo '<p>'.$msg->msg_content .'</p>' ;
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