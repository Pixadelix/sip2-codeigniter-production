<?php

namespace Model;

use \Gas\Core;
use \Gas\ORM;

class Shop_cart_item extends ORM {
	
	public $table = 'shop_cart_item';
	
	public $primary_key = 'id';
	
	public $foreign_key = array(
		'\\model\\users' => 'user_id',
		'\\model\\shop_cart' => 'cart_id',
		'\\model\\shop_product' => 'product_id',
	);
	
	function _init() {
		
		self::$relationships = array(
			'owner' => ORM::has_many('\\Model\\Users'),
			'cart' => ORM::belongs_to('\\Model\\Shop_cart'),
			'product' => ORM::belongs_to('\\Model\\Shop_product')
		);
		
		self::$fields = array(
			'id'                     => ORM::field('auto'),
			
			'cart_id'     => ORM::field('int', array('required')),
			'user_id'     => ORM::field('int', array('required')),
			'shop_id'     => ORM::field('int', array('required')),
			'product_id'  => ORM::field('int', array('required')),
			
			'base_price'  => ORM::field('numeric'),
			'qty'         => ORM::field('int'),
			
			'status'      => ORM::field('string'),
			
			'due_date'    => ORM::field('datetime'),
			
			'create_by'   => ORM::field('int[11]'),
			'create_at'   => ORM::field('timestamp'),
			'update_by'   => ORM::field('int[11]'),
			'update_at'   => ORM::field('timestamp')
		);
		
		$this->ts_fields = array('[create_at]', 'update_at');
	}
}
