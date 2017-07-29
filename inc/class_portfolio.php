<?php
Class Box_Portfolio extends BX_Post {
	static protected $instance;
	function __construct(){
		$this->post_type = 'portfolio';
		add_action('after_insert_portfolio', array($this,'set_post_thumbnail'), 10 , 2);
		add_action('after_update_portfolio', array($this,'update_post_thumbnail'), 10 , 2);

	}
	static function get_instance(){
		if (null === static::$instance) {
        	static::$instance = new static();
    	}
    	return static::$instance;
	}
	function set_post_thumbnail($post_id, $args){
		if( !empty($args['thumbnail_id'])){
			set_post_thumbnail( $post_id, $args['thumbnail_id'] );
		}
	}
	function update_post_thumbnail($post_id, $args){
		$post_thumbnail_id = get_post_thumbnail_id($post_id);
		if( !empty($args['thumbnail_id']) && $args['thumbnail_id'] != $post_thumbnail_id ){

			set_post_thumbnail( $post_id, $args['thumbnail_id'] );
		}
	}
}