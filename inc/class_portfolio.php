<?php
Class Box_Portfolio extends BX_Post {
	static protected $instance;
	function __construct(){
		$this->post_type = 'portfolio';
		add_action('after_insert_portfolio', array($this,'update_post_thumbnail'), 10 , 2);
	}
	static function get_instance(){
		if (null === static::$instance) {
        	static::$instance = new static();
    	}
    	return static::$instance;
	}
	function update_post_thumbnail($post_id, $args){
		if( !empty($args['thumbnail_id'])){
			set_post_thumbnail( $post_id, $args['thumbnail_id'] );
		}
	}
}