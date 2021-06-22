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
class Users_groups_datatable extends CI_Editor_Model {
	
	public function __construct() {
		
		parent::__construct();
		$this->create_table();
		$this->init_editor();
		
	}

	public function create_table() {
		
		if ( $this->production() ) return;
		
		$this->db_datatables->sql(
			"CREATE TABLE IF NOT EXISTS `sip_users_groups` (
				`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
				`user_id` int(11) UNSIGNED NOT NULL,
				`group_id` mediumint(8) UNSIGNED NOT NULL,
				PRIMARY KEY (`id`),
				UNIQUE KEY `uc_users_groups` (`user_id`,`group_id`),
				KEY `fk_users_groups_users1_idx` (`user_id`),
				KEY `fk_users_groups_groups1_idx` (`group_id`)
			)" 
		);
	}
	
	public function baseline_values() {
		
		if ( $this->production() ) return;
		
		//printf("Generating default: %30s", "sip_users_groups");
		
		$this->db_datatables->sql(
			"INSERT IGNORE INTO `sip_users_groups` (`user_id`, `group_id`) VALUES
			(1,1),
			(1,2)"
		);
		
		//printf("%30s".PHP_EOL, 'done');

	}

	private function init_editor() {
		$this->editor = Editor::inst( $this->db_datatables, 'sip_users_groups', 'id' )
			->fields(
				Field::inst( 'id' ),
				Field::inst( 'user_id' ),
				Field::inst( 'group_id' )
			)
		;
	}

}