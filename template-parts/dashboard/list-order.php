
<div class="col-md-12">

  	<h5> <?php _e('History of credit','boxtheme');?> </h5>
  	<div class="none-style row history-order">
  		<div class="full line-heading">
  			<div class="col-md-4">Date </div>
  			<div class="col-md-2">Type </div>
  			<div class="col-md-2">Payment </div>
  			<div class="col-md-2">Status </div>
  			<div class="col-md-2 align-center">Balance </div>
  			<!-- <div class="col-md-2"> </div> -->
  		</div>
  		<?php
  		// query order of this user.
  		$args = array(
  			'post_type' =>'_order',
  			'post_status' => array('pending','publish'),
  			'post_type' =>'_order',
  			'author' => $user_ID,
  			'posts_per_page' => -1,
  		);
  		$status = array('pending' => __('Pending','boxtheme'),'publish' => __('Approved','boxtheme') );
		$types = array('buy_credit' => __('Buy credit','boxtheme'),'withdraw' => __('Withdraw','boxtheme') ,'none' =>'None');
  		$query = new WP_Query($args);
  		if( $query->have_posts() ){
  			while ( $query->have_posts() ) {
  				$check = '(+)';

  				global $post;
  				$query->the_post();
  				$order = BX_Order::get_instance()->get_order($post);
  				if( in_array($order->order_type, array('withdraw','pay_service') ) )
  					$check = '(-)';
  				?>
  				<div class="line full">
	  				<div class="col-md-4"><?php echo get_the_date();?> </div>
	  				<div class="col-md-2"><?php echo $types[$order->order_type];?> </div>
	      			<div class="col-md-2"><?php echo $order->payment_type;?> </div>
	      			<div class="col-md-2"><?php echo $status[$order->post_status];?> </div>
	      			<div class="col-md-2 align-center"><?php echo $order->amout . $check;?>  </div>
      			</div>
      			<!-- <div class="col-md-2"><button>Arhive</button> </div> -->
  				<?php
  			}
  		}
  		?>
  	</div>
</div>
<style type="text/css">
	.history-order{
		border:1px solid #e6e6e6;
	}
	.history-order .line.full{
		padding: 8px 0;
		border-bottom: 1px solid #e6e6e6;
		overflow: hidden;
	}
	div.full.line-heading{
		border-bottom: 1px solid #e6e6e6;
		overflow: hidden;
		padding: 10px 0;
		font-weight: bold;
	}
</style>