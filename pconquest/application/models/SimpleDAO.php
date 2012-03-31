<?php
class SimpleDAO {
	protected static $instance = null;
	
	protected function __construct() {
		
	}
	
	protected function __clone() {
		
	}
	
	public static function getInstance() {
		if (self::$instance === null) {
			self::$instance = new static();
		}
		
		return self::$instance;
	}
	
	public function doStuff() {
		return array();
	}
}