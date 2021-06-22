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
class Package_datatable extends CI_Editor_Model {
	
	public $table = 'eproc_package';
	
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
				
				`name` varchar(512) NOT NULL, -- Web Portal
				`instance` varchar(512) NOT NULL, -- Kementrian Keuangan
				`status` varchar(255) NOT NULL, -- Lelang sudah selesai
				`est_price` varchar(100) NOT NULL, -- 50jt
				`doc_method` varchar(100) DEFAULT NULL, -- Pascakualifikasi Satu File
				`method` varchar(100) DEFAULT NULL, -- e-Seleksi Sederhana
				`elimination_method` varchar(100) DEFAULT NULL, -- Sistem Gugur
				`category` varchar(100) DEFAULT NULL, -- Jasa Lainnya
				`spse_version` varchar(10) DEFAULT NULL, -- 2
				
				`lpse_id` int(11) UNSIGNED NOT NULL,
				
				`create_by` mediumint(8) UNSIGNED NOT NULL DEFAULT '1',
				`create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
				`update_by` mediumint(8) UNSIGNED DEFAULT NULL,
				`update_at` datetime DEFAULT NULL,
				
				PRIMARY KEY( `id` )
			)
			;"
		);
		
		$this->db_datatables->sql("ALTER TABLE `$this->table` ADD INDEX(`lpse_id`);");
	}
	
	public function init_editor() {
		$this->editor = Editor::inst( $this->db_datatables, $this->table, 'id' )
			->fields(
				Field::inst( "$this->table.id" ),
				Field::inst( "$this->table.name" ),
				Field::inst( "$this->table.instance" ),
				Field::inst( "$this->table.status" ),
				Field::inst( "$this->table.est_price" ),
				Field::inst( "$this->table.doc_method" ),
				Field::inst( "$this->table.method" ),
				Field::inst( "$this->table.elimination_method" ),
				Field::inst( "$this->table.category" ),
				Field::inst( "$this->table.spse_version" ),
				
				Field::inst( "$this->table.lpse_id" ),
				
				Field::inst( "$this->table.create_by"                 )->set(Field::SET_CREATE),
				Field::inst( "$this->table.create_at"                 )->set(Field::SET_CREATE),
				Field::inst( "$this->table.update_by"                 )->set(Field::SET_EDIT),
				Field::inst( "$this->table.update_at"                 )->set(Field::SET_EDIT)
				
				, Field::inst( "eproc_lpse.scheme" ),
				Field::inst( "eproc_lpse.host" )
			)
			->leftJoin( 'eproc_lpse', 'eproc_lpse.id', '=', "$this->table.lpse_id" )
		;
	}
}