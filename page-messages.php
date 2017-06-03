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
					global $user_ID, $wpdb;

					$sql = "SELECT *, SUM(msg.msg_unread) as count_unread
							FROM  {$wpdb->prefix}box_messages msg
							WHERE ( msg_sender_id = {$user_ID} OR msg_receiver_id = {$user_ID} )
								AND msg_type = 'message'
		    				 GROUP BY msg.msg_receiver_id, msg.msg_sender_id";
		    		//echo $sql;
					$conversations = $wpdb->get_results($sql); // list conversations

					if($conversations) {
						echo '<ul class="none-style" id="list_converstaion">';
						echo '<h2>'.__('List Conversation','boxtheme').'</h2>';
						foreach ($conversations as $conv) {
							echo '<li><a href="#" class="render-conv" id="'.$conv->msg_sender_id.','.$conv->msg_receiver_id.'">'.$conv->msg_content.'</a><span>'.$conv->count_unread.'</span></li>';
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
<?php get_footer();?>

