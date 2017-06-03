<?php
if ( ! defined( 'ABSPATH' ) ) exit;
if ( ! function_exists( 'bx_get_user_role') ){
	function bx_get_user_role($user = ''){
		if( empty($user) ){
			global $user_ID;
			if(!$user_ID){
				return 'visitor';
			}
			$user = $user_ID;
		}
		if( is_numeric($user) ) {
			$user = get_userdata($user);
		}
		$user_roles =  $user->roles ;

		$user_role  = reset( $user_roles );
		return $user_role;
	}
}
function get_conversation_id_of_user($freelancer_id, $project_id){
	global $wpdb;
	$convs = $wpdb->get_row(
		$wpdb->prepare( "SELECT * FROM {$wpdb->prefix}conversations
		 	WHERE receiver_id = %d
		 	AND cvs_project_id = %d",
	        $freelancer_id, $project_id
        ) );
	return  $convs;
}
function show_conversation($freelancer_id, $project_id){
	global $wpdb, $user_ID, $convs_id;
	$convs = get_conversation_id_of_user($freelancer_id, $project_id);

	if(null !== $convs){
		$convs_id  = $convs->ID;
		$messages = $wpdb->get_results("
			SELECT *
			FROM {$wpdb->prefix}messages
			WHERE cvs_id = {$convs_id}"
		);

		if ( $messages ){
			echo '<div id="container_msg">';
			foreach ( $messages as $msg ){
				echo '<div class="msg-record msg-item row">';
				echo '<div class="col-md-12">';

				if($msg->msg_author == $user_ID){
					echo '<span class="msg-author f-left col-md-2">You: </span> <span class="msg-content f-left col-md-10">' .$msg->msg_content .'</span>';
				} else {
					echo '<span class="msg-author f-left col-md-2">User: </span> <span class="msg-content f-left col-md-10">' .$msg->msg_content .'</span>';;
				}
				echo '</div>';
				echo '</div>';
			}
			echo '</div>';
		} ?>
		<form class="send-message"  >
			<textarea name="msg_content" class="full" required rows="3" placeholder="Leave your message here"></textarea>
			<br />
			<input type="hidden" name="cvs_id" value="<?php echo $convs_id;?>">
			<button type="submit" class="btn btn-send-message align-right f-right"><?php _e('Send','boxtheme');?></button>
		</form>
		<?php
	}
}
function get_conversation($cvs_id){
	global $wpdb, $user_ID, $convs_id;
	$convs = get_conversation_id_of_user($freelancer_id, $project_id);

	if(null !== $convs){
		$convs_id  = $convs->ID;
		$messages = $wpdb->get_results("
			SELECT *
			FROM {$wpdb->prefix}messages
			WHERE cvs_id = {$convs_id}"
		);

		if ( $messages ){
			$result .= '<div id="container_msg">';
			foreach ( $messages as $msg ){
				$result.= '<div class="msg-record msg-item row">';
				$result.= '<div class="col-md-12">';

				if($msg->msg_author == $user_ID){
					$result.= '<span class="msg-author f-left col-md-2">You: </span> <span class="msg-content f-left col-md-10">' .$msg->msg_content .'</span>';
				} else {
					$result.= '<span class="msg-author f-left col-md-2">User: </span> <span class="msg-content f-left col-md-10">' .$msg->msg_content .'</span>';;
				}
				$result.= '</div>';
				$result.= '</div>';
			}
			$result.= '</div>';
		}
		$result .= '
		<form class="send-message"  >
			<textarea name="msg_content" class="full" required rows="3" placeholder="Leave your message here"></textarea>
			<br />
			<input type="hidden" name="cvs_id" value="<?php echo $convs_id;?>">
			<button type="submit" class="btn btn-send-message align-right f-right">'._e('Send','boxtheme').'</button>
		</form>';
		return $result;

	}
}
/*
* Mofify the column_date function in core WordPress
*/
function bx_show_time( $post ) {
		$t_time = get_the_time( __( 'Y/m/d g:i:s a' ) );
		$m_time = $post->post_date;
		$time = get_post_time( 'G', true, $post );

		$time_diff = time() - $time;

		if ( $time_diff > 0 && $time_diff < MONTH_IN_SECONDS ) {
			$h_time = sprintf( __( '%s ago' ), human_time_diff( $time ) );
		} else {
			$h_time = mysql2date( __( 'Y/m/d' ), $m_time );
			$h_time = date(get_option('date_format'),strtotime($h_time));
		}
		/** This filter is documented in wp-admin/includes/class-wp-posts-list-table.php */
		echo '<abbr title="' . $t_time . '"> Posted ' . $h_time . '</abbr>';
	}
if (  ! function_exists( 'bx_pagenate' )):

		/**
		 * paginaate the listing
		 * @version 1.0
		 * @since   1.0
		 * @author danng
		 * @return  void
		 */
		function bx_pagenate( $jb_query = false, $add_query = array(), $echo = true ,$bid_paging = 0 ){
			global $wp_query;
			if ( $jb_query )
				$wp_query = $jb_query;

	        $big = 999999999; // need an unlikely integer


	        $default = array(
	        	'type' 		=> 'list',
	            'base' 		=> str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
	            'format' 	=> '?paged=%#%',
	            'current' 	=> max( 1, get_query_var('paged') ),
	            'total' 	=> $wp_query->max_num_pages,
	        );

	        if( isset( $add_query['base']) ) {
	        	$default['base'] = $add_query['base'];
	        }
	        if( $bid_paging ){
	        	//$default['base'] = add_query_arg( array('pid'=>get_query_var('paged')), get_the_permalink() );
	        	$default['base'] = add_query_arg( 'pid', '%#%', $add_query['base']);
	        }

	        $paginate = paginate_links( $default);
	        $paginate = str_replace('page-numbers', 'pagination f-right', $paginate);
	        if( !$echo ){
	        	return $paginate;
	        } else {
	        	echo $paginate;
	    	}
		}
	endif;

?>