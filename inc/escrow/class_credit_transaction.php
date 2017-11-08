<?php
class Box_Transaction{
	public $id;
	public $project_id;
	public $payer_id; // payer for this transaction.
	public $receiver_id; // receiver for this transaction.
	public $emp_pay;
	public $fre_receive;
	public $status;
	static $instance;
	function __construct ($trans_id){

		$this->id = $trans_id;
		if( $this->id ) {
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
	}
	static function get_instance( $trans_id = 0){

		if( self::$instance == null){
			self::$instance =  new static($trans_id);
		}
		return self::$instance;
	}
	function create($args){
		$default = array(
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
				),
		);

		$id = wp_insert_post( $default );

		if( ! is_wp_error( $id ) )
			$this->id = $id;
		return $this;
	}
	function update_status($trans_id, $status ){
		return wp_update_post(
			array(
				'ID' => $trans_id,
				'post_status' => $status,
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
		return $this;
	}

}
Class Box_Transaction_Backen {
	protected $trans;
	function __construct(){
		$this->trans = 0;
		add_action('edit_form_after_editor', array($this,'show_detail_transaction') );
		add_action('save_post', array( $this, 'disable_publish_in_admin'), 10 ,2  );
	}
	function disable_publish_in_admin($trans_id, $post){
		// echo '<pre>';
		// var_dump($post);
		// var_dump($_REQUEST);
		// echo '</pre>';
		wp_die();
	}
	function show_detail_transaction($post){
		if($post->post_type == 'transaction' ){
			$this->trans = Box_Transaction::get_instance( $post->ID );
			echo '<div class="trans-detail">';
			?>
			<h1> Detail of transaction </h1>
			<div class="row">Transaction ID :<?php the_ID();?></div>
			<?php

			echo '<div class="row"> Payer ID(Employer ID):'.$this->trans->payer_id .'</div>';
			echo '<div class="row"> Freelancer ID:'.$this->trans->receiver_id.'</div>';
			echo '<div class="row"> Employer pay:'.$this->trans->emp_pay.'</div>';
			echo '<div class="row"> Freelancer receive :'.$this->trans->fre_receive.'</div>';
			echo '</div>';
			?>
			<style type="text/css">
				.trans-detail{
					background-color: #fff;
					padding: 30px;
				}
				.trans-detail .row{
					display: block;
					padding-bottom: 15px;
				}
				#side-sortables { display: none; }
			</style>
			<?php
		}
	}
}
if( is_admin() && ! wp_doing_ajax() ) {
	new Box_Transaction_Backen();
}
?>