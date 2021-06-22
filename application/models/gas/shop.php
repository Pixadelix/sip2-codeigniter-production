<?php

namespace Model;

use \Gas\Core;
use \Gas\ORM;

class Shop extends ORM {
	
	public $table = 'shop_shop';
	
	public $primary_key = 'id';
	
	public $foreign_key = array(
		'\\model\\users' => 'user_id',
		'\\model\\shop_product' => 'shop_id',
	);
	
	function _init() {
		
		self::$relationships = array(
			'owner' => ORM::belongs_to('\\Model\\Users'),
			'products' => ORM::has_many('\\Model\\Shop_product'),
		);
		
		self::$fields = array(
			'id'          => ORM::field('auto'),

			'user_id'     => ORM::field('int', array('required')),
			
			'name'        => ORM::field('string'),
			'description' => ORM::field('string'),
			
			'status'      => ORM::field('string')
		);
	}
}