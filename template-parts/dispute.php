<div class="col-md-8 wrap-workspace">
	<div class="row">
		<div class="col-md-12">
			<h3>History of Dispute flow </h3>
			<?php
			global $project_id, $winner_id, $cvs_id;
			$feebacks = BX_Message::get_instance($cvs_id)->get_converstaion_custom('disputing');
			foreach ($feebacks as $key => $msg) {
				echo $msg->msg_content;
				# code...
			}
			?>
		</div>
	</div>
</div>