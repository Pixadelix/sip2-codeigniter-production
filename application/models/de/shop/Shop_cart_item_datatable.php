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
class Shop_cart_item_datatable extends CI_Editor_Model {
	
	public $table = 'shop_cart_item';
	
	const CART_ITEM_STATUS_OPEN     = 'open';      // customer add new item in cart
	const CART_ITEM_STATUS_PAID     = 'paid';      // customer paid item in cart
	const CART_ITEM_STATUS_CANCELED = 'canceled';  // customer cancel items in cart
	const CART_ITEM_STATUS_DUE      = 'expired';   // customer did not paid at all
	
	public function __construct() {
		parent::__construct();
		$this->create_table();
		$this->init_editor();
	}
	
	public function create_table() {
		
		if ( $this->production() ) return;
		
		
        $sql = sprintf("CREATE TABLE IF NOT EXISTS `$this->table` (
            `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,

            `cart_id`    int(11) NOT NULL,
            `user_id`    int(11) NOT NULL,
            `shop_id`    int(11) NOT NULL,
            `product_id` int(11) NOT NULL,

            `base_price` decimal(20,0) NOT NULL DEFAULT 0,
            `qty`        int(11) NOT NULL DEFAULT 1,

            `status`  varchar(50) NOT NULL DEFAULT '%s',

            `due_date` datetime NOT NULL,

            `create_by` mediumint(8) UNSIGNED NOT NULL DEFAULT '1',
            `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `update_by` mediumint(8) UNSIGNED DEFAULT NULL,
            `update_at` datetime DEFAULT NULL,

            INDEX `idx_user` (`user_id`),
            INDEX `idx_shop` (`shop_id`),
            INDEX `idx_status` (`status`),

            PRIMARY KEY( `id` )
        )
        ;", self::CART_ITEM_STATUS_OPEN);
		
		$this->db_datatables->sql($sql);
		
	}
	
	public function init_editor() {
		$this->editor = Editor::inst( $this->db_datatables, $this->table, 'id' )
			->fields(
				Field::inst( "$this->table.id" ),

				Field::inst( "$this->table.cart_id" ),
				Field::inst( "$this->table.user_id" ),
				Field::inst( "$this->table.shop_id" ),
				Field::inst( "$this->table.product_id" ),
				Field::inst( "$this->table.base_price" ),
				Field::inst( "$this->table.qty" ),
				Field::inst( "$this->table.status" ),
				Field::inst( "$this->table.due_date" ),
				
				Field::inst( "$this->table.create_by"                 )->set(Field::SET_CREATE),
				Field::inst( "$this->table.create_at"                 )->set(Field::SET_CREATE),
				Field::inst( "$this->table.update_by"                 )->set(Field::SET_EDIT),
				Field::inst( "$this->table.update_at"                 )->set(Field::SET_EDIT)

			)
			
			->on( 'preCreate', function ( $editor, $values ) {
				$this->default_create_log();
			})
			
			->on( 'preEdit', function ( $editor, $values ) {
				$this->default_edit_log();
			})
		;
	}
	
}