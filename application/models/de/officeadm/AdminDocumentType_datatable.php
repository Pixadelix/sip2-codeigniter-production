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
class AdminDocumentType_datatable extends CI_Editor_Model {
	
	public $table = 'sip_admin_document_type';
	
	public function __construct() {
		
		parent::__construct();
		$this->create_table();
		$this->init_editor();
	}
	
	public function create_table() {

		if ( $this->production() ) return;
		
		$this->db_datatables->sql(
			"CREATE TABLE IF NOT EXISTS `$this->table` (
				`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
				`type` varchar(200) NOT NULL,
				`desc` varchar(200) DEFAULT NULL,
				`create_by` mediumint(8) UNSIGNED NOT NULL DEFAULT '1',
				`create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
				`update_by` mediumint(8) UNSIGNED DEFAULT NULL,
				`update_at` datetime DEFAULT NULL,
			  
				PRIMARY KEY( `id` )
			);"
		);
	}
	
	public function baseline_values() {
		
		if ($this->production()) return;
		
		//printf("Generating baseline: %30s", $this->table);

		$this->db_datatables->sql(
			"INSERT IGNORE INTO `$this->table` (`type`, `desc`, `create_by`, `create_at`, `update_by`, `update_at`) VALUES
			('INV', 'Regular invoice', 1, now(), NULL, NULL),
			('INV.ILU', 'Invoice illustrasi', 1, now(), NULL, NULL),
			('TT', 'Tanda Terima', 1, now(), NULL, NULL),
			('INV.MD', 'Media', 1, now(), NULL, NULL);"
		);
		
		//printf("%30s".PHP_EOL, 'done');
	}
	
	public function init_editor() {

		$this->editor = Editor::inst( $this->db_datatables, $this->table, 'id' )
			->fields(
				Field::inst( 'id' ),
				Field::inst( 'type' )
					->validator('Validate::notEmpty')
				,
				Field::inst( 'desc' )
			)
		;
	}
	
}