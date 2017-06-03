<?php
/**
 *	Template Name: List conversation
 */
?>
<?php get_header(); ?>
<div class="full-width">
	<div class="container site-container">
		<div class="row site-content" id="content" >
			<div class="col-md-3">
				<?php
	    		$sql = "SELECT *
						FROM  {$wpdb->prefix}box_messages msg
						WHERE ( sender_id = {$user_ID} OR receiver_id = {$user_ID} )
							AND msg_type = 'message' GROUP BY cvs_id ORDER BY msg.msg_date DESC";

				$conversations = $wpdb->get_results($sql); // list conversations
				if($conversations) {
					echo '<ul class="none-style" id="list_converstaion">';
					echo '<h2>'.__('List Conversation','boxtheme').'</h2>';
					foreach ($conversations as $conv) {

						echo '<li><a href="#" class="render-conv" id="'.$conv->cvs_id.'">'.$conv->msg_content.'</a> <span>('.$conv->msg_unread.')</span></li>';
					}
					echo '</ul>';
				} else {
					_e('There is not any conversations yet.','boxtheme');
				}
				?>
			</div>
			<div id="box_chat" class="col-md-8">

				<h2> Details </h2>
				<?php
				$first_cvs = 0;

				if( isset($conversations[0]) )
					$first_cvs = $conversations[0]->cvs_id;
				echo '<input type="hidden" value="'.$first_cvs.'" id="first_cvs" />';
				?>
				<div id="container_msg">
					<?php
					if($first_cvs){
						$msgs = BX_Message::get_instance()->get_converstaion(array('id' => $first_cvs));
						foreach ($msgs as $key => $msg) {
							$user_label = 'You:';
							$user_label = ($user_ID == $msg->sender_id) ? 'You: ':'Partner: ';

							echo '<div class="msg-record msg-item row">'.$user_label.$msg->msg_content.'</div>';
						}

					}
					?>
				</div>
				<div id="form_reply">
					<?php if($first_cvs){?>
						<form class="frm-send-message" ><textarea name="msg_content" class="full msg_content" rows="3" placeholder="Type your message here"></textarea><button type="submit" class="btn btn-send-message align-right f-right">Send</button></form>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/html" id="tmpl-msg_record">
	<div class="row">{{{username_sender}}}: {{{msg_content}}} {{{msg_date}}}</div>
</script>
<style type="text/css">
	#list_msg{
		height: 200px;
		padding-left: 15px;
		padding-left: 15px;
		overflow-x: hidden;
		overflow-y: scroll;
		border:1px solid #ccc;
	}

</style>
<?php get_footer();?>

