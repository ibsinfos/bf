<?php
Class Box_Email{
	static $_instance;
	function __construct(){

	}
	static function get_instance(){
		if ( ! isset(self::$instance) ){
			 self::$_instance = new self();
		}
		return self::$_instance;
	}
	function get_header(){
		$rlt =  is_rtl() ? "rtl" : "ltr";
		$rightmargin = is_rtl() ? 'rightmargin' : 'leftmargin';
		$url_img = '';
		$email_heading = 'Register successful';
		if ( get_option( 'box_email_header_image' ) == '' ) {
			$url_img =  get_template_directory_uri().'/img/header-email.png';
		}
		$header = '<!DOCTYPE html>
		<html dir="'.$rlt.'">
			<head>
				<meta http-equiv="Content-Type" content="text/html; charset='.get_bloginfo( 'charset' ).'" />
				<title>'.get_bloginfo( 'name', 'display' ).'</title>
				<style type="text/css">
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
													<td style="border-bottom:solid 1px #ececec;" id="image_wrapper"><img width="75%" style="display:block;margin:0 auto; padding:15px 0;"   alt="' . get_bloginfo( 'name', 'display' ) . '" src="'.$url_img.'"></td>
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
	function get_footer(){
		$foo_txt = wpautop( wp_kses_post( wptexturize( apply_filters( 'box_email_footer_text', get_option( 'box_email_footer_text' ) ) ) ) );
		$option = BX_Option::get_instance();
		$box_mail = (object)$option->get_mailing_setting();
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
										<td align="center" valign="top" bgcolor="'.$box_mail->main_bg.'">
											<!-- Footer -->
											<table border="0" cellpadding="15" cellspacing="0" width="600" id="template_footer">
												<tr>
													<td valign="top">
														<table border="0" cellpadding="0" cellspacing="0" width="100%">
															<tr>
																<td colspan="2" valign="middle" id="credit">'.$box_mail->footer_text.'</td>
															</tr>
														</table>
													</td>
												</tr>

											</table>
											<!-- End Footer -->
										</td>
									</tr>

									<tr>
										<td valign="top" bgcolor="'.$box_mail->main_bg.'">
											<table border="0" cellpadding="15" cellspacing="0" width="228px" align="left">
												<tr>
													<td colspan="2" valign="middle" id="credit"><h3 style="padding:0; margin:0;"> Connect Us</h3></td>
												</tr>
											</table>
											<table border="0" class="connect-us" cellpadding="15" cellspacing="0" width="150" align="right">
												<tr>
													<td colspan="2" valign="middle" id="credit">';
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
		$header = $this->get_header();
		$footer = $this->get_footer();
		$msg = $header.$message.$footer;

		add_filter( 'wp_mail_from', array( $this, 'get_from_address' ) );
		add_filter( 'wp_mail_from_name', array( $this, 'get_from_name' ) );
		add_filter( 'wp_mail_content_type', array( $this, 'get_content_type' ) );
		return  wp_mail( $to, $subject, $msg );
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
		$from_name = 'From BoxThemes';
		return wp_specialchars_decode( esc_html( $from_name ), ENT_QUOTES );
	}
	public function get_from_address() {
		$from_address = 'admin@lab.boxthemes.net';
		return sanitize_email( $from_address );
	}

}
function box_mail( $to, $subject, $message ) {
	return Box_Email::get_instance()->send_mail( $to, $subject, $message );
}