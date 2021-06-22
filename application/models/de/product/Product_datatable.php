<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// DataTables PHP library and database connection
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
class Product_datatable extends CI_Editor_Model {
	
	public function __construct() {
		
		parent::__construct();
		$this->create_table();
		$this->init_editor();
	}
	
	private function create_table() {
		
		if ( $this->production() ) return;

		$this->db_datatables->sql(
"CREATE TABLE IF NOT EXISTS `product` (
	`id` int(10) NOT NULL auto_increment,
	`name` varchar(255) NOT NULL,
	`description` text DEFAULT NULL,
	`unit` varchar(255) NOT NULL,
	`price` numeric(15,2) NOT NULL DEFAULT 0,
	PRIMARY KEY( `id` )
);" );

	}
	
	private function init_editor() {

		$this->editor = Editor::inst( $this->db_datatables, 'mv_product', 'id' )
			->fields(
				Field::inst( 'name' ),
				Field::inst( 'description' ),
				Field::inst( 'unit' ),
				Field::inst( 'price' )
			)
		;
	}
	
}