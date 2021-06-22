<?php namespace Model\Products;

use \Gas\Core;
use \Gas\ORM;

class Categories extends ORM {
	
	public $table = 'shop_products_categories';
	
	public $primary_key = 'id';
	
	public $foreign_key = array(
		'\\model\\shop_product' => 'product_id',
		'\\model\\shop_product_category' => 'category_id'
	);
	
	function _init() {
		self::$relationships = array(
			'product' => ORM::belongs_to('\\Model\\Shop_product'),
			'category' => ORM::belongs_to('\\Model\\Shop_product_category'),
		);
		
		self::$fields = array(
			'id'       => ORM::field('auto[3]'),
			'product_id'  => ORM::field('int[11]'),
			'category_id' => ORM::field('int[11]'),
		);
	}
}