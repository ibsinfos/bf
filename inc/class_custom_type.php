<?php

/**
 * this class will be extend by message or notify class.
 */
Class Box_Custom_Type{
	public $type;
	static protected $instance;
	function __construct($typ){
		$this->type = $type;
	}
	static function get_instance(){
		if (null === static::$instance) {
        	static::$instance = new static();
    	}
    	return static::$instance;
	}

}