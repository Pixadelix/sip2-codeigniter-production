<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Datatables PHP library and database connection
//include_once APPPATH . DATATABLE_EDITOR;

// Alias Editor classes so they are easy to use
use
	DataTables\Editor,
	DataTables\Editor\Field,
	DataTables\Editor\Format,
	DataTables\Editor\Mjoin,
	DataTables\Editor\Options,
	DataTables\Editor\Upload,
	DataTables\Editor\Validate;

load_class('Editor_Model', 'core');
class Shop_product_datatable extends CI_Editor_Model {
	
	public $table = 'shop_product';
	
	const PRODUCT_STATUS_READY = 'ready';
	const PRODUCT_STATUS_SOLD_OUT = 'sold-out';
	const PRODUCT_STATUS_BANNED = 'banned';
	
	public function __construct() {
		parent::__construct();
		$this->create_table();
		$this->init_editor();
	}
	
	public function create_table() {
		
		if ( $this->production() ) return;
		
		
        $sql = sprintf("CREATE TABLE IF NOT EXISTS `$this->table` (
            `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,

            `user_id` int(11) UNSIGNED NOT NULL,
            `shop_id` int(11) UNSIGNED DEFAULT NULL,

            `name` varchar(512) NOT NULL,
            `description` longtext DEFAULT NULL,

            `tax_id` int(5) UNSIGNED NOT NULL,

            `base_price` decimal(20, 0) NOT NULL DEFAULT 0,

            `status` varchar(50) NOT NULL DEFAULT '%s',

            `change_log` longtext DEFAULT NULL,

            `create_by` mediumint(8) UNSIGNED NOT NULL DEFAULT '1',
            `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `update_by` mediumint(8) UNSIGNED DEFAULT NULL,
            `update_at` datetime DEFAULT NULL,

            INDEX `idx_cat_name` (`name`),

            PRIMARY KEY( `id` )
        )
        ;", self::PRODUCT_STATUS_READY);
		$this->db_datatables->sql($sql);
		
		$this->db_datatables->sql(
			"CREATE TABLE IF NOT EXISTS `shop_products_categories` (
				`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
				
				`product_id` int(11) UNSIGNED NOT NULL,
				`category_id` int(11) UNSIGNED NOT NULL,
				
				INDEX `idx_product_id` (`product_id`),
				INDEX `idx_category_id` (`category_id`),
				
				PRIMARY KEY ( `id` )
			)
			;"
		);
		
	}
	
	public function init_editor() {
		$this->editor = Editor::inst( $this->db_datatables, $this->table, 'id' )
			->fields(
				Field::inst( "$this->table.id" ),
				
				Field::inst( "$this->table.user_id" ),
				Field::inst( "$this->table.shop_id" )
					->options( Options::inst()
						->table( 'shop_shop' )
						->value( 'shop_shop.id' )
						->label( 'shop_shop.name' )
						->order( 'shop_shop.name asc' )
					)
				,

				Field::inst( "$this->table.name" ),
				Field::inst( "$this->table.description" ),
				
				Field::inst( "$this->table.tax_id" ),
				Field::inst( "$this->table.base_price" ),
				
				Field::inst( "$this->table.status" ),
				
				Field::inst( "$this->table.change_log" ),
				
				Field::inst( "$this->table.create_by"                 )->set(Field::SET_CREATE),
				Field::inst( "$this->table.create_at"                 )->set(Field::SET_CREATE),
				Field::inst( "$this->table.update_by"                 )->set(Field::SET_EDIT),
				Field::inst( "$this->table.update_at"                 )->set(Field::SET_EDIT)
				
				,
				Field::inst( 'shop_shop.name' )

			)
			->leftJoin( 'shop_shop', 'shop_shop.id', '=', "$this->table.shop_id" )
			
			->join(
				Mjoin::inst( 'shop_product_category' )
					->link( 'shop_product.id', 'shop_products_categories.product_id' )
					->link( 'shop_product_category.id', 'shop_products_categories.category_id' )
					->order( 'shop_product_category.name asc' )
					->fields(
						Field::inst( 'id' )
							->validator( 'Validate::required' )
							->options( Options::inst()
								->table( 'shop_product_category' )
								->value( 'id' )
								->label( 'name' )
							),
						Field::inst( 'name' )
					)
			)
			
			->on( 'preCreate', function ( $editor, $values ) {
				$editor
					->field( "$this->table.user_id" )
					->setValue( $this->ci->user_id );
				
				$editor
					->field( "$this->table.shop_id" )
					->setValue( isset($this->ci->shop_id) && $this->ci->shop_id ? $this->ci->shop_id : null );
				
				$this->default_create_log();
			})
			
			->on( 'preEdit', function ( $editor, $values ) {
				
				$editor
					->field( "$this->table.shop_id" )
					->setValue( isset($this->ci->shop_id) && $this->ci->shop_id ? $this->ci->shop_id : null );
				
				$this->default_edit_log();
			})
		;
	}
	
}