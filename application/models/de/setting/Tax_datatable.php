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
class Tax_datatable extends CI_Editor_Model {
	
	public $table = 'tax';

	public function __construct() {
		parent::__construct();
		$this->create_table();
		$this->init_editor();
	}
	
	public function create_table() {
		
		if ( $this->production() ) return;

		$sql = sprintf(
			"CREATE TABLE IF NOT EXISTS `$this->table` (
				`id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT,
				
				`name` varchar(100) NOT NULL,
				`description` varchar(512) DEFAULT NULL,
				
				`factor` decimal(5, 2) NOT NULL DEFAULT 0.10,

				`create_by` mediumint(8) UNSIGNED NOT NULL DEFAULT '1',
				`create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
				`update_by` mediumint(8) UNSIGNED DEFAULT NULL,
				`update_at` datetime DEFAULT NULL,
				
				PRIMARY KEY( `id` )
			)
			;"
		);
		$this->db_datatables->sql($sql);
		
		$taxes = array(
			array(
				'name' => 'Tax Free',
				'description' => 'Free of tax',
				'factor' => 0
			),
			array(
				'name' => 'PPn (10%)',
				'description' => 'Pajak Pertambahan Nilai (10%)',
				'factor' => 0.10
			),
			array(
				'name' => 'Pajak Lain-lain',
				'description' => 'Pajak Lain-lain nya',
				'factor' => 0.10
			),
		);
		
		for ( $i = 0; $i < count($taxes); $i++ ) {
			Model\Tax::make($taxes[$i])->save();
		}
		
	}
	
	public function init_editor() {
		$this->editor = Editor::inst( $this->db_datatables, $this->table, 'id' )
			->fields(
				Field::inst( "$this->table.id" ),
				
				Field::inst( "$this->table.name" ),
				Field::inst( "$this->table.description" ),
				
				Field::inst( "$this->table.factor" ),
				
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