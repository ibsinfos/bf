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
class PP_Adaptive extends Box_Escrow{
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
	function get_body( $fre_receive_email, $emp_pay, $fre_receive ,$project_id ){
		$process_payment = box_get_static_link('process-payment');

		$return_url =  add_query_arg( array(
			'type' =>'pp_adaptive',
			'project_id' =>$project_id
		), esc_url( $process_payment) );

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
			'returnUrl'=>$return_url,
			'cancelUrl'=>$return_url,
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

	function pay( $fre_receive_email, $emp_pay, $fre_receive, $project_id){


		$body = $this->get_body( $fre_receive_email, $emp_pay, $fre_receive, $project_id  );
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

	function act_award($bid_id, $frelancer_id, $project ){

		$freelancer = get_userdata($frelancer_id);
		$bid_price = (float) get_post_meta($bid_id, BID_PRICE, true);


		$pay_info = box_get_pay_info( $bid_price );
      	$emp_pay = $pay_info->emp_pay;
      	$fre_receive = $pay_info->fre_receive;
      	$cms_fee = $pay_info->cms_fee;

      	$respond = array('success' => false, 'msg' =>'Failse');
      	try{
      		$withdraw_info = BX_Credit::get_instance()->get_withdraw_info($frelancer_id);
      		$fre_receive_email = trim($withdraw_info->paypal_email);

      		$respond  = $this->pay( $fre_receive_email, $emp_pay, $fre_receive, $project->ID);
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
				box_log('save pp_key:'.$res->payKey . " Project ID: ".$project->ID);
				update_post_meta( $project->ID, 'pp_paykey', $res->payKey );

				return  $response;
			}
		}
		return $respond;
	}

	function get_trans_status_via_paykey( $paykey ){
		 $check_endpoint = 'https://svcs.sandbox.paypal.com/AdaptivePayments/PaymentDetails';

		$detail = wp_remote_post(
			$check_endpoint,
			array(
				'headers' => $this->get_headers(),
				'body' => array(
					'payKey' => $paykey,
					'requestEnvelope.errorLanguage'=>'en_US',
				)
			)
		);
		if( ! is_wp_error( $detail ) ){
			$detail =  json_decode($detail['body']);
			return $detail->status; //COMPLETED CREATED, INCOMPLETE
		}
		return $detail;
	}
	function award_complete($project_id ){
		box_log("Project ID: ".$project_id);
		$paykey = get_post_meta( $project_id, 'pp_paykey', true);
		box_log("pp_paykey in db: ".$paykey);
		if( $paykey ){
			$trans_status = $this->get_trans_status_via_paykey($paykey);
			box_log($trans_status);
			if( !is_wp_error( $trans_status ) ){
				if( $trans_status == 'INCOMPLETE ' ){
					//'Fund is paid but receiver not receive';
					$this->perform_after_deposit($bid_id, $project_id);
				} else{
					var_dump($trans_status);
				}
			}
			var_dump($trans_status);
		}
	}
	function release($project_id){
		$paykey = get_post_meta( $project_id, 'pp_paykey', true);
		$this->excutePayment($paykey);
		$this->perform_after_release();
	}
	function perform_after_deposit($bid_id, $project_id){

		global $user_ID;
		$project = get_post($project_id);
		if( $project ){

			$employer_id = $project->post_author;

			$bid_price = (float) get_post_meta($bid_id, BID_PRICE, true);

			$pay_info = box_get_pay_info( $bid_price );
	      	$emp_pay = $pay_info->emp_pay;



			$total_spent = (float) get_user_meta($employer_id, 'total_spent', true) + $emp_pay;
			update_user_meta( $employer_id, 'total_spent', $total_spent );

			$fre_hired = (int) get_user_meta( $employer_id, 'fre_hired', true) + 1;
			update_user_meta( $employer_id, 'fre_hired',  $fre_hired );

			$bid = get_post($bid_id);
			$request['post_status'] = AWARDED;
			$request['meta_input'] = array(
				WINNER_ID => $bid->post_author,
				BID_ID_WIN => $bid_id,
			);
			$res = wp_update_post( $request );
			$freelancer_id = $bid->post_author;

			$this->send_mail_noti_award( $project_id, $freelancer_id );
		}

	}

}
// freelancer@etteam.com
// employer@etteam.com
// danhoat-buyer@gmail.com
?>