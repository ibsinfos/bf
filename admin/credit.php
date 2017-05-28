<?php
class BX_Credit_Setting{
	function __construct(){
		add_action('admin_menu', array($this,'wpdocs_register_my_custom_submenu_page') );
	}

	static function wpdocs_register_my_custom_submenu_page() {
	    add_submenu_page(
	        BX_Admin::$main_setting_slug,
	        'Credit order',
	        'Credit order',
	        'manage_options',
	        'credit-setting',
	        array($this,'wpdocs_my_custom_submenu_page_callback') );
	}
	static function wpdocs_my_custom_submenu_page_callback(){

		$args = array(
			'post_type' => '_order',
			'posts_per_page' => 35,

		);
		$query = new WP_query($args);
		if( $query->have_posts() ){
			echo '<h3>List credit pending</h3>';
			echo '<ul class="box-table">';
			echo '<li class="row li-heading">';
			echo '<div class="col-md-3">Buyer</div>';
			echo '<div class="col-md-2">Type</div>';

			echo '<div class="col-md-2">';
			echo "Price";
			echo '</div>';

			echo '<div class="col-md-2">Date</div>';
			echo '<div class="col-md-1">';
			echo "Status";
			echo '</div>';
			echo '<div class="col-md-2">Action</div>';
			echo '</li>';
			$bx_order = BX_Order::get_instance();
			while ($query->have_posts()) {
				global $post;
				$query->the_post();
				$order = $bx_order->get_order($post);

				echo '<li class="row">';
					echo '<div class="col-md-3">'.get_the_author();
					echo '</div>';
					echo '<div class="col-md-2">';
					echo $order->payment_type;
					echo '</div>';

					echo '<div class="col-md-2">';
					echo $order->amout;
					echo '</div>';
					echo '<div class="col-md-2">';
					echo get_the_date();
					echo '</div>';
					echo '<div class="col-md-1">';
					echo $order->post_status;
					echo '</div>';

					echo '<div class="col-md-2">';
					if( $order->post_status != 'publish' )
						echo '<button class="btn-approve" id="'.get_the_ID().'">Approve</button>';
					echo '</div>';
				echo '</li>';
			}
			echo '</ul>';
		}
	}


}
new BX_Credit_Setting();