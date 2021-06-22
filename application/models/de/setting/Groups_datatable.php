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
class Groups_datatable extends CI_Editor_Model {
	
	public $table = 'sip_groups';
	
	public function __construct() {
		
		parent::__construct();
		$this->create_table();
		$this->init_editor();
		
	}

	public function create_table() {
		
		if ( $this->production() ) return;
		
		$this->db_datatables->sql(
			"CREATE TABLE IF NOT EXISTS `$this->table` (
				`id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT,
				`name` varchar(20) NOT NULL,
				`description` varchar(100) NOT NULL,
				PRIMARY KEY (`id`)
			)"
		);
		
		$this->db_datatables->sql(
			"ALTER TABLE `$this->table` ADD UNIQUE(`name`)"
		);
	}
	
	public function baseline_values() {
		
		if ( $this->production() ) return;
		
		//printf("Generating baseline: %30s", $this->table);
		
		$this->db_datatables->sql(
			"INSERT IGNORE INTO `$this->table` (`id`, `name`, `description`) VALUES
			(1,'admin','Administrator'),
			(2,'members','General User'),
			(3,'editor', 'Editor'),
			(4,'reporter', 'Reporter'),
			(5,'fotografer', 'Fotografer'),
            (6,'designer', 'Designer'),
			(7,'officeadm', 'Office Admin'),
            (8,'portfolio', 'Portfolio'),
            (9,'freelance', 'Freelance')"
		);
		
		//printf("%30s".PHP_EOL, 'done');
	}

	private function init_editor() {
		$this->editor = Editor::inst( $this->db_datatables, $this->table, 'id' )
			->fields(
				Field::inst( 'id' ),
				Field::inst( 'name' ),
				Field::inst( 'description' )
			)
		;
	}

}