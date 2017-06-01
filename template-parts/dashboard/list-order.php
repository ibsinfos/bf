<?php
global $user_ID;
$credit = BX_Credit::get_instance()->get_ballance($user_ID);
?>
  	<ul class="row none-style padding-bottom-20">
  		<li><?php printf(__('Your credit: %s','boxtheme'),$credit->available);?></li>
  		<li><a class="btn btn-radius btn-buy-credit" href="<?php echo home_url('buy-credit');?>"><?php _e('Buy Credit','boxtheme');?> </a></li>
  	</ul>
  	<h5> <?php _e('History of credit','boxtheme');?> </h5>
  	<ul class="none-style row">
  		<li>
  			<div class="col-md-2">Date </div>
  			<div class="col-md-2">Type </div>
  			<div class="col-md-2">Payment </div>
  			<div class="col-md-2">Status </div>
  			<div class="col-md-2">Balance </div>
  			<div class="col-md-2">Actions </div>
  		</li>
  		<?php
  		// query order of this user.
  		$args = array(
  			'post_type' =>'_order',
  			'post_status' => array('pending','publish'),
  			'post_type' =>'_order',
  			'author' => $user_ID,
  			'posts_per_page' => -1,
  		);
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
  				<div class="col-md-2"><?php echo get_the_date();?> </div>
  				<div class="col-md-2"><?php echo $order->order_type;?> </div>
      			<div class="col-md-2"><?php echo $order->payment_type;?> </div>
      			<div class="col-md-2"><?php echo $order->post_status;?> </div>
      			<div class="col-md-2"><?php echo $order->amout . $check;?>  </div>
      			<div class="col-md-2"><button>Arhive</button> </div>
  				<?php
  			}
  		}
  		?>
  	</ul>