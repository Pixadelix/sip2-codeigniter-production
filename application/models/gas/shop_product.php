<?php

namespace Model;

use \Gas\Core;
use \Gas\ORM;

class Shop_product extends ORM {
	
	public $table = 'shop_product';
	
	public $primary_key = 'id';
	
	public $foreign_key = array(
		'\\model\\products\\categories' => 'product_id',
		'\\model\\shop_cart_item' => 'product_id',
	);
	
	function _init() {
		
		self::$relationships = array(
			'categories' => ORM::has_many('\\Model\\Products\\Categories => \\Model\\Shop_product_category'),
			'item' => ORM::has_many('\\Model\\Shop_cart_item'),
		);
		
		self::$fields = array(
			'id' => ORM::field('auto'),
			
			'user_id' => ORM::field('int'),
			'shop_id' => ORM::field('int'),
			
			'name' => ORM::field('string'),
			'description' => ORM::field('string'),
			'base_price' => ORM::field('decimal'),
			
		);
	}
}