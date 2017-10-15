<div class="col-md-8 wrap-workspace dispute-section">
		<div class="col-md-12">
			<h3>History of Dispute flow </h3>
			<?php
			global $project, $winner_id, $cvs_id, $user_ID;
			$feebacks = BX_Message::get_instance($cvs_id)->get_converstaion_custom('disputing');
			$bid_author = get_userdata($winner_id);
			$employer = get_userdata($project->post_author);

			$display_name = array(
				$winner_id => $bid_author->display_name,
				$project->post_author => $employer->display_name,
			);
			foreach ($feebacks as $key => $msg) {
				//echo '<div class="col-avatar">'.get_avatar( $msg->sender_id, 39).'<div>';

				if( (int) $msg->receiver_id == 0 ){ // employer or freelancer send.
					echo '<strong>'.$display_name[$msg->sender_id].'</strong>';
				} else {
					echo '<strong>Administrator </strong>';
				}
				echo ' feedback in <small>'.$msg->msg_date.'</small> : <br />';
				echo $msg->msg_content .'<br />' ;

				# code...
			}
			$place_holder = __('Freelancer send feedback to admin here','boxtheme');
			if ( $user_ID != $winner_id){
				$place_holder = __('Employer send feedback to admin here','boxtheme');
			}
			?>
			<form class="swp-send-message"  >
				<textarea name="msg_content" class="full msg_content" required rows="3" placeholder="<?php echo $place_holder;?>"></textarea>
				<input type="hidden" name="cvs_id" value="<?php echo $cvs_id;?>">
				<input type="hidden" name="receiver_id" value="0">

				<input type="hidden" name="msg_type" value="disputing">
				<input type="hidden" name="method" value="insert">
				<br />
				<button type="submit" class="btn btn-send-message align-right f-right"><?php _e('Send','boxtheme');?></button>
			</form>
			<?php if( current_user_can( 'manage_options' ) ){ ?>
				<label> For admin</label>
				<form id="frmAdminAct" class="frm-admin-act form-inline"  >

					<input type="hidden" name="cvs_id" value="<?php echo $cvs_id;?>">
					<input type="hidden" name="fre_id" value="<?php echo $winner_id;?>">
					<input type="hidden" name="emp_id" value="<?php echo $project->post_author;?>">
					<input type="hidden" name="project_id" value="<?php echo $project->ID;?>">

					<input type="hidden" name="msg_type" value="disputing">
					<input type="hidden" name="method" value="insert">
					<div class="form-row align-items-center">
						<div class="col-auto">
					      	<div class="input-group col-md-12">
					        	<div class="input-group-addon" style="width: 165px;">
					        	<select name="act" class="custom-select required" style="background: #eeeeee; border:0;" required>
					        		<option>Select option</option>
									<option value="ask_fre">Send a messsage to Freelancer</option>
									<option value="ask_emp">Send a message to Employer</option>
									<option value="fre_win">Choose employer winner</option>
									<option value="emp_win">Choose freelancer winner</option>
								</select>
								</div>
					        <textarea type="text" class="form-control required" name="msg_content" id="msg_content" required placeholder="Admin add feedback here" style="height: 39px; width: 100%;"></textarea>

					      </div>
					    </div>
					</div>
					 <button type="submit" class="btn btn-send-message align-right f-right"><?php _e('Send','boxtheme');?></button>
				</form>
			<?php } ?>
		</div>
</div>
<style type="text/css">
	.frm-admin-act{
		position: relative;
	}
	.frm-admin-act .btn-send-message {
	    z-index: 100;
	    height: 25px;
	    padding: 2px 9px;
	}
	.sl-ask{
		position: 1absolute;
	}
</style>