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
class Cron_datatable extends CI_Editor_Model {
	
	public $table = 'cron';
	
	public function __construct() {
		
		parent::__construct();
		$this->create_table();
		$this->init_editor();
		
	}

	public function create_table() {
		
		if ( $this->production() ) return;
		
		$this->db_datatables->sql(
			"CREATE TABLE IF NOT EXISTS `$this->table` (
				`id` int(5) NOT NULL AUTO_INCREMENT,
				`name` varchar(100) DEFAULT NULL,
				`command` varchar(255) NOT NULL,
				`interval_sec` int(10) NOT NULL,
				`last_run_at` datetime DEFAULT NULL,
				`next_run_at` datetime DEFAULT NULL,
				`is_active` tinyint(1) NOT NULL DEFAULT '1',
				PRIMARY KEY (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8;" 
		);

	}

	private function init_editor() {
		$this->editor = Editor::inst( $this->db_datatables, $this->table, 'id' )
			->fields(
				Field::inst( "$this->table.id" ),
				Field::inst( "$this->table.name" ),
				Field::inst( "$this->table.command" ),
				Field::inst( "$this->table.interval_sec" )
					->options( function() {
						return array(
							array('value' => 60,       'label' => ' 1 min'),
							array('value' => 60*5,     'label' => ' 5 min'),
							array('value' => 60*10,    'label' => '10 min'),
							array('value' => 60*60,    'label' => ' 1 hour'),
							array('value' => 60*60*2,  'label' => ' 2 hours'),
							array('value' => 60*60*6,  'label' => ' 6 hours'),
							array('value' => 60*60*12, 'label' => '12 hours'),
							array('value' => 60*60*24, 'label' => '24 hours')
						);
					})
				,
				Field::inst( "$this->table.last_run_at" ),
				Field::inst( "$this->table.next_run_at" ),
				Field::inst( "$this->table.is_active" )
			)
		;
	}
	
}