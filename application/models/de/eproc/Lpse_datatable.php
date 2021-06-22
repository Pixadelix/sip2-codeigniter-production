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
class Lpse_datatable extends CI_Editor_Model {
	
	public $table = 'eproc_lpse';
	
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
				
				`name` varchar(512) NOT NULL,
				`url_spse` varchar(512) NOT NULL UNIQUE,

				`status` varchar(255) DEFAULT NULL,
				`info` longtext DEFAULT NULL,
				
				`redirect_url` varchar(512) DEFAULT NULL,
				
				`scheme` varchar(10) DEFAULT NULL,
				`host` varchar(512) DEFAULT NULL,
				`port` varchar(5) DEFAULT NULL,
				`user` varchar(20) DEFAULT NULL,
				`pass` varchar(20) DEFAULT NULL,
				`path`  varchar(512) DEFAULT NULL,
				`query`  varchar(512) DEFAULT NULL,
				`fragment`  varchar(100) DEFAULT NULL,
				
				`create_by` mediumint(8) UNSIGNED NOT NULL DEFAULT '1',
				`create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
				`update_by` mediumint(8) UNSIGNED DEFAULT NULL,
				`update_at` datetime DEFAULT NULL,
				
				PRIMARY KEY( `id` )
			)
			;"
		);
	}
	
	public function init_editor() {
		
		$this->editor = Editor::inst( $this->db_datatables, $this->table, 'id' )
			->fields(
				Field::inst( "$this->table.id" ),
				Field::inst( "$this->table.name" ),
				Field::inst( "$this->table.url_spse" ),
				Field::inst( "$this->table.status" ),
				Field::inst( "$this->table.info" ),
				
				Field::inst( "$this->table.create_by"                 )->set(Field::SET_CREATE),
				Field::inst( "$this->table.create_at"                 )->set(Field::SET_CREATE),
				Field::inst( "$this->table.update_by"                 )->set(Field::SET_EDIT),
				Field::inst( "$this->table.update_at"                 )->set(Field::SET_EDIT)
			);
	}
}