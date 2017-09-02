<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

Class BX_Credit {

	static private $instance;
	public $meta_available;
	public $meta_pending;
	private $mode;
	function __construct(){
		$this->mode = 'sandbox';
		$this->meta_total = '_credit_total';
		$this->meta_pending = '_credit_pending';
		$this->meta_available = '_credit_available';
		if( $this->mode == 'sandbox' ){
			$this->meta_total = '_sandbox_credit_total';
			$this->meta_pending = '_sandbox_credit_pending';
			$this->meta_available = '_sandbox_credit_available';
		}
	}
	static function get_instance(){
		if (null === static::$instance) {
        	static::$instance = new static();
    	}
    	return static::$instance;
	}

	/**
	 * Tranfer credit in employer account to freelancer account with status pending.
	 * @param int $employer_id
	 * @param int $bidding  bidding id
	*/
	function deposit($employer_id, $bid_id, $project = 0) {

		$ballance = $this->get_ballance($employer_id);

		$bid_price = (float) get_post_meta($bid_id, BID_PRICE, true);

		$pay_ifo = box_get_pay_info($bid_price);

      	$emp_pay = $pay_ifo->emp_pay;

		if( $ballance->available < $emp_pay ){
			return new WP_Error( 'not_enough', __( "Your credit are not enough to perform this transasction", "boxtheme" ) );
		}
		$new_available = $ballance->available - $emp_pay;
		global $wpdb;
		$wpdb->query( $wpdb->prepare(			"
				UPDATE $wpdb->usermeta
				SET  meta_value = %f
				WHERE user_id = %d AND meta_key ='%s' ",
			    $new_available, $employer_id, $this->meta_available
			)
		);
		return true;

	}
	function undeposit($employer_id, $bid_id, $project_id = 0) {

		$ballance = $this->get_ballance($employer_id);
		$bid_price = (float) get_post_meta($bid_id, BID_PRICE, true);
		$commision_fee = get_commision_fee($bid_price); // web owner will get this amout.


		$emp_pay = $commision_fee + $bid_price;
		$new_available = $ballance->available + $emp_pay;

		global $wpdb;
		$wpdb->query( $wpdb->prepare(			"
				UPDATE $wpdb->usermeta
				SET  meta_value = %f
				WHERE user_id = %d AND meta_key ='%s' ",
			    $new_available, $employer_id, $this->meta_available
			)
		);
		return true;

	}

	// call this action when employer mark as finish a project.
	function release($freelancer_id, $amout){
		return $this->increase_credit_available($freelancer_id, $amout);
	}

	function undeposit_bk($employer_id, $bid_id, $project_id = 0) {
		$bidding = get_post($bid_id);
		$freelaner_id = $bidding->post_author;

		$ballance = $this->get_ballance($employer_id);
		$bid_price = (float) get_post_meta($bidding->ID, BID_PRICE, true);

		$commision_fee = get_commision_fee($bid_price); // web owner will get this amout.

		$emp_pay = $bid_price;
		$amout_fre_receive = $bid_price - $commision_fee;

		$pay_ok =  $this->subtract_credit_available( $employer_id, $emp_pay );// subtract credit in employer account.



		//$result =  $this->increase_credit_pending( $freelaner_id, $amout_fre_receive );// change to available
		$result =  $this->remove_credit_pending( $freelaner_id, $amout_fre_receive );// change to available
		if( ! $result ) {
			$this->increase_credit_available( $employer_id, $emp_pay);
			return new WP_Error( 'increase_pending_1', __( "Can not increase the credit of freelancer", "boxtheme" ) );
			die();
		}
		if( $result ){
			// create order here
			$order_args = array(
				'order_type' => 'pay_service',
				'project_id' => $project_id,
				'payment_type'=>'credit',
				'amout' => $emp_pay,
			);

			$order  = BX_Order::get_instance()->create_order($order_args);
		}
		// update the number spent of this employer
		$spent = (float) get_user_meta($employer_id, SPENT, true) + $emp_pay ;
		update_user_meta( $employer_id, SPENT, $spent );
		return true;
	}

	/**
	 * add more available credit to the account.
	 * @author danng
	 * @version 1.0
	 * @param  int  $user_receiver_id int
	 * @param   float $amout
	 * @return  void
	 */
	function process_verified_order( $user_receice_id, $amout ){
		$return =  $this->increase_credit_available($user_receice_id, $amout);
		bx_error_log('User Receiver ID Input:'.$user_receice_id);
		bx_error_log('Amout order:'.$amout);
		if($return){
			bx_error_log('Process verified order : OK');
		} else {
			bx_error_log('Process verified order : Fail');
		}
	}
	function get_ballance($user_id) {
		return (object) array(
			'pending' => $this->get_credit_pending($user_id),
			'available' => $this->get_credit_available($user_id)
		);
	}
	function get_credit_available($user_id){
		return (float) get_user_meta($user_id, $this->meta_available, true) ;
	}
	function increase_credit_available($user_id, $available){

		$current_available = $this->get_credit_available($user_id);
		$new_available = $current_available + (float) $available;
		return update_user_meta($user_id, $this->meta_available, $new_available);
	}
	function increase_credit_pending( $user_id, $available ){
		$new_pending = $this->get_credit_pending($user_id) + (float)$available;
		return update_user_meta($user_id, $this->meta_pending, $new_pending);
	}
	function approve_credit_pending($user_id, $value){
		$this->subtract_credit_pending($user_id,$value);
		$this->increase_credit_available($user_id, $value);
	}
	//deduct
	function subtract_credit_available($user_id, $value){
		$current = $this->get_credit_available($user_id);
		$new_available = $this->get_credit_available($user_id) - (float)$value;

		if( $new_available >= 0 )
			return update_user_meta($user_id, $this->meta_available, $new_available);

		return false;
	}

	function get_credit_pending($user_id){
		return (float) get_user_meta($user_id, $this->meta_pending, true);
	}

	/**
	 * [subtract_credit_pending description]
	 * This is a cool function
	 * @author danng
	 * @version 1.0
	 * @param   [type] $user_id   [description]
	 * @param   [type] $available [description]
	 * @return  [type]            [description]
	 */
	function subtract_credit_pending($user_id, $available){

		$new_available = $this->get_credit_pending($user_id) - (float)$available;
		if( $new_available >= 0){
			return update_user_meta( $user_id, $this->meta_pending, $new_available);
		}
		return 0;
	}

	/**
	 * admin approve 1 buy_credit order
	 * This is a cool function
	 * @author danng
	 * @version 1.0
	 * @param   [type] $order_id [description]
	 * @return  [type]           [description]
	 */
	function request_withdraw( $request){ //widthraw_request

		global $user_ID;
		$amout = (float) $request['withdraw_amout'];
		$method =  $request['withdraw_method'];
		$note =  $request['withdraw_note'];
		$payment_method = $this->get_withdraw_info();

		$ballance = $this->get_ballance($user_ID);

		$method_detail = array('paypay' => '', 'bank_account' => array( 'account_name' => '', 'bank_name' => '', 'account_number' => '' ) );

		if( empty( $payment_method->$method ) ){
			return new WP_Error( 'unset_method', __( "Please set your payment method to withdraw", "boxtheme" ) );
		}



		if( $amout < 10 )
			return new WP_Error( 'inlimitted', __( "Your amout must bigger than 15$", "boxtheme" ) );

		if( $ballance->available < $amout ){
			return new WP_Error( 'not_enough', __( "Your ballance does not enough to perform this withdraw.", "boxtheme" ) );
		}
		$this->subtract_credit_available($user_ID, $amout); //deducte in available credit of this user.
		//create order
		$curren_user = wp_get_current_user();

		$method_text = '';
		if( $method == 'paypal_email'){
			$method_text = '<p> &nbsp; &nbsp; PayPal email: '.$payment_method->paypal_email.'</p>';
		} else {
			// array('account_name' => 'empty', 'account_number' => '', 'bank_name'=>'' );
			$method_detail = (object)$payment_method->$method;
			$method_text = '<p> &nbsp; &nbsp; Bank name: '.$method_detail->bank_name.'</p>';
			$method_text .= '<p> &nbsp; &nbsp; Account name: '.$method_detail->account_name.'</p>';
			$method_text .= '<p> &nbsp; &nbsp; Account number: '.$method_detail->account_number.'</p>';
		}
		$content =  sprintf( __('<p><h1>Detail of withdraw</h1></p><p><label> Amout:</label> %f</p><p><label>Method:</label> %s </p> <p> <label> Notes:</label> %s </p><p> Detail of method: %s','boxtheme'), $amout,$method, $note, $method_text) ;

		$args_wdt = array(
			'post_title' => sprintf( __('%s request widdraw %f ','boxthemee'), $curren_user->user_login, $amout ),
			'amout' => $amout,
			'order_type' => 'withdraw' ,
			'payment_type' => 'none' ,
			'post_content' => $content,
		);

		BX_Order::get_instance()->create_custom_pending_order( $args_wdt );

		$to = get_option('admin_email', true);
		$subject = 'Has a withdraw request';
		box_mail( $to, $subject, $content ); // mail to admin.

		$subject = __( 'You have just requested a withdrawal.','boxtheme' );
		box_mail( $curren_user->user_email, $subject, $content ); // mail to freelancer.


		return true;
	}

	function approve_buy_credit($order_id){
		try{
			$order = BX_Order::get_instance()->get_order($order_id);
			$order_access = BX_Order::get_instance()->approve($order_id);

			if( !$order_access ){
				throw new Exception("Some error message", 101);
			}

			$this->subtract_credit_pending($order->post_author, $order->amout);
			$this->increase_credit_available($order->post_author, $order->amout);

		} catch(Exception  $e){
			$code = $e->getCode();

			if($code == 101){
				// update order to pending
			}
			if($code == 100){

			}
			return false;
		}
		return true;
	}
	/**
	 * admin approve 1 widthraw
	 * This is a cool function
	 * @author danng
	 * @version 1.0
	 * @return  [type] [description]
	 */
	function approve_withdraw($order_id){

		try{

			$order_access = BX_Order::get_instance()->approve($order_id);

			if( !$order_access ){
				throw new Exception("Some error message", 101);
			}
			$order = BX_Order::get_instance()->get_order($order_id);

			$this->increase_credit_available($order->post_author, $order->amout);

		} catch(Exception  $e){

			$code = $e->getCode();

			if($code == 101){
				// update order to pending
			}
			if($code == 100){

			}
			return false;
		}
		return true;
	}
	/**
	 *
	 * This is a cool function
	 * @author danng
	 * @version 1.0
	 * @param   [type] $args [description]
	 * @return  [type]       [description]
	 */
	function update_withdraw_info( $args ){

		global $user_ID;
		$withdraw_info = get_user_meta( $user_ID, 'withdraw_info', true );

		if( !is_array($withdraw_info) )
			$withdraw_info = array();

		if( isset($args['paypal_email']) ){
			$withdraw_info['paypal_email'] = $args['paypal_email'];
		} else {
			// update bank infor
			$withdraw_info['bank_account'] = array(
				'account_name' => $args['account_name'],
				'account_number' => $args['account_number'],
				'bank_name' => $args['bank_name'],
				'account_name' => $args['account_name'],
			);
		}
		return update_user_meta( $user_ID, 'withdraw_info', $withdraw_info );

	}
	function get_withdraw_info($user_id = 0){
		if( empty( $user_id )){
			global $user_ID;
			$user_id = $user_ID;
		}
		return (object) get_user_meta( $user_id, 'withdraw_info', true );
	}

}