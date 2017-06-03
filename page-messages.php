<?php
/**
 *	Template Name: List conversation
 */
?>
<?php get_header(); ?>
<div class="full-width">
	<div class="container site-container">
		<div class="row site-content" id="content" >
			<div id="profile" class="col-md-8"> <!-- start left !-->
				<div class="col-md-4">
					<?php

					$args = array(
						'group' => "1,3",

					);

					// $result = BX_Message::get_instance()->get_converstaion($args);
					// foreach ($result as $key => $msg) {
					// 	var_dump($msg->);
					// }
					global $user_ID, $wpdb;

					// $sql1 = "SELECT *, SUM(msg.msg_unread) as count_unread
					// 		FROM  {$wpdb->prefix}box_messages msg
					// 		WHERE ( sender_id = {$user_ID} OR receiver_id = {$user_ID} )
					// 			AND msg_type = 'message'
		   //  				 	GROUP BY msg.receiver_id, msg.sender_id";

		    		$sql = "SELECT *
							FROM  {$wpdb->prefix}box_messages msg
							WHERE ( sender_id = {$user_ID} OR receiver_id = {$user_ID} )
								AND msg_type = 'message' GROUP BY cvs_id ";
					//echo $sql;
		    		//echo $sql;
					$conversations = $wpdb->get_results($sql); // list conversations

					if($conversations) {
						echo '<ul class="none-style" id="list_converstaion">';
						echo '<h2>'.__('List Conversation','boxtheme').'</h2>';
						foreach ($conversations as $conv) {
							echo '<li><a href="#" class="render-conv" id="'.$conv->cvs_id.'">'.$conv->msg_content.'</a> <span>('.$conv->msg_unread.')</span></li>';
						}
						echo '</ul>';
					} else {
						_e('There is not any message','boxtheme');
					}
					?>
				</div>
				<div id="box_chat" class="col-md-8"></div>
			</div> <!-- end left !-->
			<div class="col-md-4">
				<?php //get_sidebar('dashboard');?>
			</div>

		</div>
	</div>
</div>
<script type="text/html" id="tmpl-msg_record">
	<div class="row">{{{username_sender}}}: {{{msg_content}}} {{{msg_date}}}</div>

</script>
<?php get_footer();?>

