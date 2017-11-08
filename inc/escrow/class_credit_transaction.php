<?php
class BOX_Transaction{
	protected $id:
	protected $project_id;
	protected $payer_id; // payer for this transaction.
	protected $receiver_id; // receiver for this transaction.
	protected $emp_pay;
	protected $fre_receive;
	protected $status;
	static $instance;
	function __contruct($trans_id){
		$this->id = $trans_id;
		$trans = get_post($trans_id);

		$this->status = $trans->post_status;
		$this->status = $trans->post_status;
		$this->total = get_post_meta($trans_id, 'total', true);
		$this->payer_id = get_post_meta($trans_id, 'payer_id', true);
		$this->receiver_id = get_post_meta($trans_id, 'receiver_id', true);
		$this->emp_pay = get_post_meta($trans_id, 'emp_pay', true);
		$this->fre_receive = get_post_meta($trans_id, 'fre_receive', true);
		$this->commision_fee = get_post_meta($trans_id, 'commision_fee', true);
	}
	static function get_instance(){
		if( self::$instance == null){
			self::$instance = new static;
		}
		return self::$instance;
	}
	function create($args){

		$id = wp_inset_post(
			array(
				'post_title' => 'Transaction of project ',
				'post_type' => 'transaction',
				'post_status' => 'pending',
				'meta_input' =>
					array(
						'total' => $args['total'],
						'emp_pay' => $args['emp_pay'],
						'payer_id' => $args['payer_id'],
						'receiver_id' => $args['receiver_id'],
						'fre_receive' => $args['fre_receive'],
						'commision_fee' => $args['commision_fee'],
						'user_pay' => $args['user_pay'], // fre - emp or 50/50
					)
			)
		);
		$this->id = $id;
		return $id;
	}
	function update_status($id, $){
		$id = wp_update_post(
			array(
				'ID' => '',
			)
		);
	}
	function delete(){
		wp_delete_post( $this->id, true);
	}
	function release($id){
		$this->update_status('publish');
		// update total_spent, erned here.
	}
	function deposit(){
		// 1: create 1 transaction with status pending.
		//  	1.2) tru tien từ payer.
		//done.
	}
	function refund($trans_id){
		$this->update_status('');
	}
	function get_transaction($trans_id){
		return $this;
	}
}
?>