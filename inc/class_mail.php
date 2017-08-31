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
		$img = '';
		$email_heading = 'BOXTHEMES';
		if ( get_option( 'box_email_header_image' ) != '' ) {
			$img =  '<p style="margin-top:0;"><img src="' . esc_url( $img ) . '" alt="' . get_bloginfo( 'name', 'display' ) . '" /></p>';
		}
		$header = '<!DOCTYPE html>
<html dir="'.$rlt.'">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset='.bloginfo( 'charset' ).'" />
		<title>'.get_bloginfo( 'name', 'display' ).'</title>
	</head>
	<body '.$rightmargin.'="0" marginwidth="0" topmargin="0" marginheight="0" offset="0">
		<div id="wrapper" dir="'.$rlt.'">
			<table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%">
				<tr>
					<td align="center" valign="top">
						<div id="template_header_image"> '.$img.'</div>
						<table border="0" cellpadding="0" cellspacing="0" width="600" id="template_container">
							<tr>
								<td align="center" valign="top">
									<!-- Header -->
									<table border="0" cellpadding="0" cellspacing="0" width="600" id="template_header">
										<tr>
											<td id="header_wrapper">
												<h1>'.$email_heading.'</h1>
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
												$footer = 	'</div>
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
								<td align="center" valign="top">
									<!-- Footer -->
									<table border="0" cellpadding="10" cellspacing="0" width="600" id="template_footer">
										<tr>
											<td valign="top">
												<table border="0" cellpadding="10" cellspacing="0" width="100%">
													<tr>
														<td colspan="2" valign="middle" id="credit">'.$foo_txt.'</td>
													</tr>
												</table>
											</td>
										</tr>
									</table>
									<!-- End Footer -->
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</div>
	</body>
</html>';
		return $footer;
	}
	function send($to, $subject, $message){
		$header = $this->get_header();
		$footer = $this->get_footer();
		$html = $header.$message.$footer;
		return wp_mail($to, $subject, $html);
	}
}
$to = 'danng@youngworld.vn';
$subject = 'Test from localhost';
$message = 'Hi Dan, This is my email';

//$mail = Box_Email::get_instance()->send($to, $subject, $message);