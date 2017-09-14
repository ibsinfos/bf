<?php
/**
 *	Template Name: List conversation
 */
?>
<?php get_header(); ?>
<div class="full-width">
	<div class="container site-container ">
		<div class="site-content" id="content" >
			<div class="col-md-4">
				<?php
				global $user_ID;
	    		$sql = "SELECT *
						FROM  {$wpdb->prefix}box_conversations cv
						INNER JOIN {$wpdb->prefix}box_messages  msg
						ON  cv.ID = msg.cvs_id
						WHERE  ( msg.sender_id = {$user_ID} OR msg.receiver_id = {$user_ID} )
						GROUP BY msg.cvs_id ORDER BY cv.date_modify DESC";


				$conversations = $wpdb->get_results($sql); // list conversations
				if($conversations) {
					echo '<ul class="none-style" id="list_converstaion">';
					echo '<h3>'.__('List Conversation','boxtheme').'</h3>';

					foreach ($conversations as $key=>$cv) {
							$user = array();
						if($cv->sender_id == $user_ID){
							$user = get_userdata($cv->receiver_id);
						} else {
							$user = get_userdata($cv->sender_id);
						}
						$project = get_post($cv->project_id);
						if($user && $project){
							if($key == 0){
								echo '<li class="cv-item acti">';
							} else {
								echo '<li class="cv-item">';
							}
							echo '<div class="cv-left">';
								echo get_avatar($user->ID);
							echo '</div>';
							echo '<div class="cv-right">';
								$date = date_create( $cv->date_modify );
								echo '<small class="mdate">'. date_format($date,"m/d/Y") .'</small>';
								echo '<a href="#" class="render-conv" id="'.$cv->cvs_id.'">'.$user->display_name.'</a> <span>('.$cv->msg_unread.')</span>';
								if( $project )
									echo '<p><small>'.$project->post_title.'</small></p>';

							echo '</div>';
							echo '</li>';

						}
					}
					echo '</ul>';
				} else {
					_e('There is no any conversations yet.','boxtheme');
				}
				?>
			</div>
			<div id="box_chat" class="col-md-8">


				<?php
				if( $conversations ){ ?>
					<h3> <?php _e('Detail of conversation','boxtheme'); ?> </h3> <?php

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
								echo '<div class="msg-record msg-item"><div class="col-md-2">'.$user_label.'</div> <div class="col-md-10">'.$msg->msg_content.'</div></div>';
							}
						}
						?>
					</div>
					<div id="form_reply">
						<?php if($first_cvs){?>
							<form class="frm-send-message" ><textarea name="msg_content" class="full msg_content required" required rows="3" placeholder="Type your message here"></textarea><button type="submit" class="btn btn-send-message align-right f-right">Send</button>
							<input type="reset" name="reset" class="hidden">
							</form>
						<?php } ?>
					</div>
				<?php  } ?>
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
		border:1px solid #f1f1f1;

	}
	.cv-item{
		clear: both;
		display: block;
		width: 100%;
		float: left;
		border-bottom: 1px solid #f1f1f1;
		padding: 10px;
		position: relative;
		border-left:3px solid #fff;
	}
	.cv-item.acti{
		border-left:3px solid #54bf03;
		background-color: #f3f6f8;
	}
	.cv-item:hover{
		background-color: #f3f6f8;
	}
	.cv-item img{
		width: 55px;
		height: 55px;
		border-radius: 50%;
		vertical-align: top;
	}
	.cv-left{
		width: 25%;
		float: left;
	}
	.cv-right{
		width: 75%;
		float: left;
		overflow: hidden;
	}
	.mdate{
		position: absolute; top:10px;
		right: 0px;
	}
	.msg-record{
		width: 100%;
		clear: both;
	}
	.cv-right small{
		display: inline-block;
	    overflow: hidden;
	    text-overflow: ellipsis;
	    white-space: nowrap;
	}
	textarea{
		border-color: #ececec;
	}
	.frm-send-message .btn-send-message{
		background:#ccc;
	}
	.frm-send-message.focus .btn-send-message{
		background: #17a717;
	}
</style>
<?php get_footer();?>

