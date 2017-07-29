<?php
Class Box_Portfolio extends BX_Post {
	static protected $instance;
	function __construct(){
		$this->post_type = PROJECT;
	}
	static function get_instance(){
		if (null === static::$instance) {
        	static::$instance = new static();
    	}
    	return static::$instance;
	}
}