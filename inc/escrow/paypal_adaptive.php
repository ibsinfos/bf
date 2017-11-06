<?php
/**
 * document: https://developer.paypal.com/docs/classic/adaptive-payments/ht_ap-delayedChainedPayment-curl-etc/

accepted
Sounds like you just have the amounts wrong. When working with chained payments the primary receiver amount should be the total amount of all payments. Then the secondary amounts would just be what they are supposed to get.

For example, say $100 was getting split between 3 people. You might set that up like this...

Primary Receiver Amount = $100.00
Secondary Receiver Amount = $50.00
Secondary Receiver Amount = $30.00
*/
class PP_Adaptive{
	static $return_url;
	static $paypal_adaptive;
	static $instance;

	function __construct(){
		self::$return_url = add_query_arg( 'type','pp_adaptive',box_get_static_link('process-payment') );
		self::$paypal_adaptive = (OBJECT) BX_Option::get_instance()->get_group_option('paypal_adaptive');
	}
	static function get_instance(){
		if (null === static::$instance) {
        	static::$instance = new static();
    	}
    	return static::$instance;
	}
	function return_url(){

	}
	function get_headers(){

		$headers = array(
	    	'X-PAYPAL-SECURITY-USERID' => self::$paypal_adaptive->api_userid,
	    	'X-PAYPAL-SECURITY-PASSWORD' => self::$paypal_adaptive->api_userpassword,
	    	'X-PAYPAL-SECURITY-SIGNATURE' => self::$paypal_adaptive->app_signarute,
            'X-PAYPAL-REQUEST-DATA-FORMAT' => 'NV',
            'X-PAYPAL-RESPONSE-DATA-FORMAT' => 'JSON',
			'X-PAYPAL-APPLICATION-ID' => self::$paypal_adaptive->api_appid,
		);
		return $headers;
	}
	function get_body( $fre_receive_email, $emp_pay, $fre_receive  ){
		return array(
			'actionType'=>'PAY_PRIMARY',
			'clientDetails.applicationId'=>'APP-80W284485P519543T',
			'clientDetails.ipAddress='=>'127.0.0.1',
			'currencyCode'=>'USD',
			'feesPayer'=>'EACHRECEIVER',
			'receiverList.receiver(0).amount'=> $emp_pay,
			'receiverList.receiver(0).email'=> 'employer@etteam.com',
			'receiverList.receiver(0).primary'=> true,
			'receiverList.receiver(1).amount'=> $fre_receive,
			'receiverList.receiver(1).email'=> $fre_receive_email,
			'receiverList.receiver(1).primary'=> false,
			'requestEnvelope.errorLanguage'=>'US',
			'returnUrl'=>self::$return_url,
			'cancelUrl'=>self::$return_url,
		);

	}
	function get_body_default(){ // 100% run ok
		return array(
			'actionType'=>'PAY_PRIMARY',
			'clientDetails.applicationId'=>'APP-80W284485P519543T',
			'clientDetails.ipAddress='=>'127.0.0.1',
			'currencyCode'=>'USD',
			'feesPayer'=>'EACHRECEIVER',
			'receiverList.receiver(0).amount'=> '10',
			'receiverList.receiver(0).email'=> 'employer@etteam.com',
			'receiverList.receiver(0).primary'=> true,
			'receiverList.receiver(1).amount'=> 5,
			'receiverList.receiver(1).email'=> 'freelancer@etteam.com',
			'receiverList.receiver(1).primary'=> false,
			'requestEnvelope.errorLanguage'=>'US',
			'returnUrl'=>'http://localhost/et/fb/',
			'cancelUrl'=>'http://localhost/et/fb/',
		);

	}

	/**
	 * Release payment after projest is done
	*/
	function excutePayment(){
		$release_endpoint = 'https://svcs.sandbox.paypal.com/AdaptivePayments/ExecutePayment';

		$release = wp_remote_post(
			$release_endpoint,
			array(
				'headers' => $headers,
				'body' => array(
					'payKey' => $payKey,
					'requestEnvelope.errorLanguage'=>'en_US',
				)
			)
		);
		$body = $release['body'];
		return json_decode($body);
	}
	function act_award($frelancer_id, $bid_price, $project ){

		$freelancer = get_userdata($frelancer_id);

		$pay_info = box_get_pay_info( $bid_price );
      	$emp_pay = $pay_info->emp_pay;
      	$fre_receive = $pay_info->fre_receive;
      	$cms_fee = $pay_info->cms_fee;

      	$respond = array('success' => false, 'msg' =>'Failse');
      	try{
      		$withdraw_info = BX_Credit::get_instance()->get_withdraw_info($frelancer_id);
      		$fre_receive_email = trim($withdraw_info->paypal_email);

      		$respond  = $this->pay( $fre_receive_email, $emp_pay, $fre_receive);
      	} catch (Exception $e) {
      		$respond['msg'] = $e->getMessage();
      	}

      	//var_dump($respond);
      	if( ! is_wp_error( $respond ) ){

	      	$res = json_decode($respond['body']);

			if( !empty( $res->payKey ) ){
				//https://www.sandbox.paypal.com/cgi-bin/webscr?cmd=_ap-payment&paykey=InsertPayKeyHere
				//wp_redirect('https://www.sandbox.paypal.com/cgi-bin/webscr?cmd=_ap-payment&paykey='.$respond->payKey);
				$response = array(
					'success' => true,
					'payKey' => $res->payKey,
					'url_redirect' =>"https://www.sandbox.paypal.com/cgi-bin/webscr?cmd=_ap-payment&paykey=".$res->payKey,
				);

				update_post_meta( $project->ID, 'payKey', $res->payKey );
				return  $response;
			}
		}
		return $respond;
	}
	function pay( $fre_receive_email, $emp_pay, $fre_receive ){

		$return_url =  add_query_arg( 'type','pp_adaptive',box_get_static_link('process-payment') );
		$body = $this->get_body( $fre_receive_email, $emp_pay, $fre_receive  );
		//$body = $this->get_body_default( );


		try{
			$respond = wp_remote_post(
				'https://svcs.sandbox.paypal.com/AdaptivePayments/Pay',
					array(
						//'timeout' => 45,
					    'headers' => $this->get_headers(),
						'body' => $body,
				    )
			);

		} catch(Exception $e) {
			$respond = array(
				'success' => false,
				'msg' => $e->getMessage(),
			);
		}

		return $respond;

	}
}
// freelancer@etteam.com
// employer@etteam.com
// danhoat-buyer@gmail.com
?>