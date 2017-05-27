<?php
class BX_Credit_Setting{
	function __construct(){
		add_action('admin_menu', array($this,'wpdocs_register_my_custom_submenu_page') );
	}

	static function wpdocs_register_my_custom_submenu_page() {
	    add_submenu_page(
	        BX_Admin::BOX_MAIN_SETTING,
	        'Credit',
	        'Credit settings',
	        'manage_options',
	        'credit-setting',
	        array($this,'wpdocs_my_custom_submenu_page_callback') );
	}
	static function wpdocs_my_custom_submenu_page_callback(){
		$args = array(
			'post_type' => '_order',
			'post_status' => 'pending'
		);
		$query = new WP_query($args);
		if( $query->have_posts() ){
			echo '<h3>List credit pending</h3>';
			echo '<ul>';
			echo '<li>';
			echo '<div class="col-md-3">Buyer</div>';
			echo '<div class="col-md-3">Type</div>';
			echo '<div class="col-md-3">Date</div>';
			echo '<div class="col-md-3">Action</div>';
			echo '</li>';
			while ($query->have_posts()) {
				$query->the_post();
				echo '<li class="row">';
				echo '<div class="col-md-3">Buyer';
				the_author();
				echo '</div>';
				echo '<div class="col-md-3">';
				the_title();
				echo '</div>';
				echo '<div class="col-md-3">';
				echo get_the_date();
				echo '</div>';
				echo '<div class="col-md-3">Approve</div>';
				echo '</li>';
			}
			echo '</ul>';
		}
	}

}
new BX_Credit_Setting();