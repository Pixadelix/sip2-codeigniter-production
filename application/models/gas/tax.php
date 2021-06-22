<?php

namespace Model;

use \Gas\Core;
use \Gas\ORM;

class Tax extends ORM {
	
	public $table = 'tax';
	
	public $primary_key = 'id';
	
	public $foreign_key = array(
		
	);
	
	function _init() {
		
		self::$relationships = array(
			
		);
		
		self::$fields = array(
			'id'                     => ORM::field('auto'),
			
			'name'                   => ORM::field('string'),
			'description'            => ORM::field('string'),
			'value'                  => ORM::field('numeric'),
			
			
			'create_by'   => ORM::field('int[11]'),
			'create_at'   => ORM::field('timestamp'),
			'update_by'   => ORM::field('int[11]'),
			'update_at'   => ORM::field('timestamp')
		);
		
		$this->ts_fields = array('[create_at]', 'update_at');
	}
}
