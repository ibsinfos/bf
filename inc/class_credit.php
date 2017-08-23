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
	function deposit($employer_id, $bid_id, $project_id = 0) {

		$ballance = $this->get_ballance($employer_id);
		$bid_price = (float) get_post_meta($bid_id, BID_PRICE, true);
		$commision_fee = get_commision_fee($bid_price); // web owner will get this amout.


		$emp_pay = $commision_fee + $bid_price;
		$new_available = $ballance->available - $emp_pay;

		if( $ballance->available < $emp_pay ){
			return new WP_Error( 'not_enough', __( "Your credit are not enough to perform this transasction", "boxtheme" ) );
		}
		global $wpdb;
		$wpdb->query( $wpdb->prepare(			"
				UPDATE $wpdb->usermeta
				SET  meta_value = %f
				WHERE user_id = %d AND meta_key ='%s' ",
			    $new_available, $employer_id, $this->meta_available
			)
		);
		return true;
		return new WP_Error( 'award_fail', __( "fail 123", "boxtheme" ) );

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

		if( $new_available >= 0)
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
	function approve($order_id){
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
			var_dump($code);
			if($code == 101){
				// update order to pending
			}
			if($code == 100){

			}
			return false;
		}
		return true;
	}
}