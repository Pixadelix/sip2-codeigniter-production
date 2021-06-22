<?php

namespace Model;

use \Gas\Core;
use \Gas\ORM;

class Shop_product_category extends ORM {
	
	public $table = 'shop_product_category';
	
	public $primary_key = 'id';
	
	public $foreign_key = array(
		'\\model\\products\\categories' => 'category_id',
	);
	
	function _init() {
		
		self::$relationships = array(
			'products' => ORM::has_many('\\Model\\Products\\Categories => \\Model\\Shop_product'),
		);
		
		self::$fields = array(
			'id' => ORM::field('auto'),
			
			'name' => ORM::field('string'),
			
		);
	}
}