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
class Clients_datatable extends CI_Editor_Model {
	
	public function __construct() {
		
		parent::__construct();
		$this->create_table();
		$this->init_editor();
		
	}

	public function create_table() {
		
		if ( $this->production() ) return;
		
		$this->db_datatables->sql(
			"CREATE TABLE IF NOT EXISTS `sip_clients` (
				`id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT,
				`name` varchar(100) NOT NULL,
				`description` varchar(255) NOT NULL,
				`website` varchar(100) DEFAULT NULL,
				`phone` varchar(20) DEFAULT NULL,
				`create_by` mediumint(8) UNSIGNED NOT NULL DEFAULT '1',
				`create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
				`update_by` mediumint(8) UNSIGNED DEFAULT NULL,
				`update_at` datetime DEFAULT NULL,
				PRIMARY KEY (`id`)
			)" 
		);

	}

	private function init_editor() {
		$this->editor = Editor::inst( $this->db_datatables, 'sip_clients', 'id' )
			->fields(
				Field::inst( 'id' ),
				Field::inst( 'name' ),
				Field::inst( 'description' ),
				Field::inst( 'website' ),
				Field::inst( 'phone' )
			)
		;
	}
	
}