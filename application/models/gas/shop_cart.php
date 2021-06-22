<?php

namespace Model;

use \Gas\Core;
use \Gas\ORM;

class Shop_cart extends ORM {
	
	public $table = 'shop_cart';
	
	public $primary_key = 'id';
	
	public $foreign_key = array(
		'\\model\\users' => 'user_id',
		'\\model\\shop_cart_item' => 'cart_id',
		'\\model\\shop' => 'shop_id',
	);
	
	function _init() {
		
		self::$relationships = array(
			'items' => ORM::has_many('\\Model\\Shop_cart_item'),
			'shop'  => ORM::belongs_to('\\Model\\Shop'),
			'customer' => ORM::belongs_to('\\Model\\Users'),
		);
		
		self::$fields = array(
			'id'          => ORM::field('auto'),

			'user_id'     => ORM::field('int', array('required')),
			'shop_id'     => ORM::field('int', array('required')),
			'status'      => ORM::field('string'),
			
			'due_date'    => ORM::field('datetime'),
			'paid_date'   => ORM::field('datetime'),
			
			'create_by'   => ORM::field('int[11]'),
			'create_at'   => ORM::field('timestamp'),
			'update_by'   => ORM::field('int[11]'),
			'update_at'   => ORM::field('timestamp')
		);
		
		$this->ts_fields = array('[create_at]', 'update_at');
	}
}

