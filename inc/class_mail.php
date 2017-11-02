<?php
Class Box_Email{
	static $_instance;
	public $option;
	function __construct(){
		$this->option = BX_Option::get_instance()->get_mailing_setting();
	}
	static function get_instance(){
		if ( ! isset(self::$instance) ){
			 self::$_instance = new self();
		}
		return self::$_instance;
	}
	function get_header($option){
		//font-family: 'Roboto Condensed', sans-serif;
		//font-family: 'Roboto', sans-serif;
		//font-family: 'Raleway', sans-serif;
		//font-family: 'Open Sans', sans-serif;
		$rlt =  is_rtl() ? "rtl" : "ltr";
		$rightmargin = is_rtl() ? 'rightmargin' : 'leftmargin';
		$header = '<!DOCTYPE html>
		<html dir="'.$rlt.'">
			<head>
				<meta http-equiv="Content-Type" content="text/html; charset='.get_bloginfo( 'charset' ).'" />
				<title>'.get_bloginfo( 'name', 'display' ).'</title>
				<link href="https://fonts.googleapis.com/css?family=Raleway|Roboto|Roboto+Condensed|Open+Sans" rel="stylesheet">

				<svg style="position: absolute; width: 0; height: 0; overflow: hidden;" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
					<defs>
					<symbol id="icon-facebook" viewBox="0 0 32 32">
					<title>facebook</title>
					<path d="M19 6h5v-6h-5c-3.86 0-7 3.14-7 7v3h-4v6h4v16h6v-16h5l1-6h-6v-3c0-0.542 0.458-1 1-1z"></path>
					</symbol>
					</defs>
				</svg>

				<style type="text/css">
					body{
						word-break: break-word;
					    color: #666;
					    font-family: Helvetica;
					    font-size: 14px;
					    line-height: 160%;
					    text-align: left;
					}
					#credit{
						font-family: "Raleway", sans-serif;
					}
					#template_header_image img{max-width: 100%; width: 350px; text-align: left; padding:15px 0;}
					img{max-width:100%;}
					#template_header_image{
						text-align: left;
						border-bottom: 1px solid #ccc;
						padding: 0 15px;
					}
					#header_wrapper{
						padding: 0 15px;
					}
					body{
						width: 100%;
						background: #ececec;
					}
					.main-body{
						width: 450px;
						margin:0 auto;
						background: #fff;

					}

					#body_content{
						padding-bottom: 35px;
					}
					h3{ margin:0; padding:0;}
					.connect-us a{ padding:0 5px;}
				</style>
			</head>




			<body '.$rightmargin.'="0" marginwidth="0" topmargin="0" marginheight="0" offset="0" bgcolor="#ececec">
				<div id="wrapper" dir="'.$rlt.'">
					<table border="0" cellpadding="0" class="main-body" cellspacing="0" height="100%" width="100%" bgcolor="#ececec">

						<tr>
							<td align="center" valign="top" cellpadding="0" cellspacing="0" >
								<table border="0" cellpadding="0" cellspacing="0" width="600" id="template_container" bgcolor="#fff">
									<tr>
										<td align="left" valign="top">
											<!-- Header -->
											<table border="0" cellpadding="0" cellspacing="0" width="600" id="image_header">
												<tr>
													<td style="border-bottom:solid 1px #ececec;" id="image_wrapper"><img width="75%" style="display:block;margin:0 auto; padding:15px 0;"   alt="' . get_bloginfo( 'name', 'display' ) . '" src="'.$option->header_image.'"></td>
												</tr>
											</table>
											<!-- End IMG Header -->
										</td>
									</tr>

									<tr>
										<td align="left" valign="top">
											<!-- Header -->
											<table border="0" cellpadding="15" cellspacing="0" width="600" id="template_header" >
												<tr>
													<td id="header_wrapper">

													</td>
												</tr>
											</table>
											<!-- End Header -->
										</td>
									</tr>
									<tr>
										<td align="center" valign="top">
											<!-- Body -->
											<table border="0" cellpadding="0" cellspacing="0" width="600" id="template_body">
												<tr>
													<td valign="top" id="body_content">
														<!-- Content -->
														<table border="0" cellpadding="20" cellspacing="0" width="100%">
															<tr>
																<td valign="top">
																	<div id="body_content_inner">';
		return $header;
	}
	function get_footer( $option ){
		$foo_txt = wpautop( wp_kses_post( wptexturize( apply_filters( 'box_email_footer_text', get_option( 'box_email_footer_text' ) ) ) ) );

														$foo_txt = 	'</div>
																</td>
															</tr>
														</table>
														<!-- End Content -->
													</td>
												</tr>
											</table>
											<!-- End Body -->
										</td>
									</tr>
									<tr>
										<td align="center" valign="top" bgcolor="'.$option->main_bg.'">
											<!-- Footer -->
											<table border="0" cellpadding="15" cellspacing="0" width="600" id="template_footer">
												<tr>
													<td valign="top">
														<table border="0" cellpadding="0" cellspacing="0" width="100%">
															<tr>
																<td colspan="2" valign="middle" id="credit"><font color="#FFFFFF">'.$option->footer_text.'</font></td>
															</tr>
														</table>
													</td>
												</tr>

											</table>
											<!-- End Footer -->
										</td>
									</tr>

									<tr>
										<td valign="top" bgcolor="'.$option->main_bg.'">
											<table border="0" cellpadding="15" cellspacing="0" width="228px" align="left">
												<tr>
													<td colspan="2" valign="middle" id="credit"><h3 style="padding:0; margin:0;"> <font color="#FFFFFF">Connect Us</font></h3></td>
												</tr>
											</table>
											<table border="0" class="connect-us" cellpadding="15" cellspacing="0" width="150" align="right">
												<tr>
													<td colspan="2" valign="middle" id="credit" color="#FFFFFF">';
													global $general;
													if( !isset($general) )
														$general = (object) BX_Option::get_instance()->get_group_option('general');

													$social_link = '';

													if ( !empty( $general->fb_link ) )
										    			$social_link .='<a class="gg-link"  target="_blank" href="'.esc_url($general->fb_link).'"><img src="'.get_template_directory_uri().'/img/email-fb.png" /></a></li>';

										    		if ( !empty( $general->tw_link ) )
										    			$social_link .='<a class="gg-link"  target="_blank" href="'.esc_url($general->tw_link).'"><img src="'.get_template_directory_uri().'/img/email-tw.png" /></a></li>';

										    		if ( !empty( $general->gg_link ) )
										    			$social_link .='<a class="gg-link"  target="_blank" href="'.esc_url($general->gg_link).'"><img src="'.get_template_directory_uri().'/img/email-gg.png" /></a></li>';

										    		$foo_txt.=$social_link;
										    		$foo_txt.='

													</td>
												</tr>
											</table>
										</td>
									</tr>

								</table>
							</td>
						</tr>
					</table>
				</div>
			</body>
		</html>';
		return $foo_txt;
	}
	function send_mail( $to, $subject, $message ){

		$header = $this->get_header($this->option);
		$footer = $this->get_footer($this->option);
		$msg = $header.$message.$footer;


		//add_filter( 'wp_mail_from', array( $this, 'get_from_address' ) );
		add_filter( 'wp_mail_from_name', array( $this, 'get_from_name' ) );
		add_filter( 'wp_mail_content_type', array( $this, 'get_content_type' ) );
		return wp_mail( $to, $subject, $msg );

		remove_filter( 'wp_mail_from', array( $this, 'get_from_address' ) );
		remove_filter( 'wp_mail_from_name', array( $this, 'get_from_name' ) );
		remove_filter( 'wp_mail_content_type', array( $this, 'get_content_type' ) );
	}
	public function get_content_type() {
		return 'text/html';
		// switch ( $this->get_email_type() ) {
		// 	case 'html' :
		// 		return 'text/html';
		// 	case 'multipart' :
		// 		return 'multipart/alternative';
		// 	default :
		// 		return 'text/plain';
		// }
	}
	function get_from_name(){

		return wp_specialchars_decode( esc_html( $this->option->from_name ), ENT_QUOTES );
	}
	public function get_from_address() {

		return sanitize_email( $this->option->from_address );
	}

}
function box_mail( $to, $subject, $message ) {
	return Box_Email::get_instance()->send_mail( $to, $subject, $message );
}
class Box_ActMail{
	static $_instance;
	public static function get_instance(){
		if ( ! isset(self::$instance) ){
			 self::$_instance = new self();
		}
		return self::$_instance;
	}
	function mail_to_register( $user ){


		$activation_key =  get_password_reset_key( $user);
		$link = box_get_static_link('verify');
		$link = add_query_arg( array('user_login' => $user->user_login,  'key' => $activation_key) , $link );


		$mail = BX_Option::get_instance()->get_mail_settings('new_account');

		$subject = $mail->subject;
		$content = $mail->content;

		$subject = str_replace('#blog_name', get_bloginfo('name'), stripslashes ( $subject ) );
		$content = str_replace('#user_login', $user->user_login, $mail->content);
		$content = str_replace('#link', esc_url($link), $content);


		box_mail( $request['user_email'], $subject, stripslashes($content) );
	}
	function mail_reset_password( $userdata){
		//$mail = BX_Option::get_instance()->get_mail_settings('new_account');
		$activation_key =  get_password_reset_key( $user);
		$link = box_get_static_link('reset-password');
		$link = add_query_arg( array('user_login' => $user->user_login,  'key' => $activation_key) , $link );


		$mail_content = '<p>Hi #user_login,</p><p><a href="#blog_link">#blog_name</a> has received a request to reset the password for your account. If you did not request to reset your password, please ignore this email.</p>
				<p>Click <a href="#reset_link"> here </a> to reset your password now</p>';
		$subject = 'Reset your #blog_name password';
		$subject = str_replace('#blog_name', get_bloginfo('name'), stripslashes ($subject) );

		$content = str_replace('#user_login', $userdata->user_login, $mail_content);
		$content = str_replace('#blog_name', get_bloginfo('name'), $content);
		$content = str_replace('#blog_link', home_url(), $content);
		$content = str_replace('#reset_link', esc_url($link), $content);


		box_mail( $email, $subject, stripslashes($content) );
	}
	/**
	 * Send an email to owner project let he know has new bidding in his project.
	 **/
	function has_new_bid($project){


		$mail = BX_Option::get_instance()->get_mail_settings('new_bidding');

		$content = str_replace("#project_link", get_permalink( $project->ID), $content);
		$content = str_replace("#project_name", $project->post_title, $content);

		$author = get_userdata($project->post_author);

		box_mail( $author->user_email, $subject, $content );

	}

	/**
	 * send an email to freelancer when employer create a conversion with this freelancer
	**/
	function has_new_conversation($freelancer_id){

		$subject = __("Employer just send to you a message",'boxtheme');
		$content = 'Employer just send to you a message';
		$author = get_userdata($freelancer_id);

		box_mail( $author->user_email, $subject, $content );

	}
	function award_job( $freelancer_id ){

		$subject = __("You has been assigned for a job",'boxtheme');
		$content = 'You has been assigned for a job';
		$author = get_userdata( $freelancer_id );

		box_mail( $author->user_email, $subject, $content );

	}

}