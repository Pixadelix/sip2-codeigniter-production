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
class Projects_datatable extends CI_Editor_Model {
	
	public function __construct() {
		
		parent::__construct();
		$this->create_table();
		$this->init_editor();
		
	}

	public function create_table() {
		
		if ( $this->production() ) return;
		
		$this->db_datatables->sql(
			"CREATE TABLE IF NOT EXISTS `sip_projects` (
				`id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT,
				`name` varchar(100) NOT NULL,
				`description` varchar(255) NOT NULL,
				`client_id` mediumint(8) UNSIGNED NOT NULL,
				`create_by` mediumint(8) UNSIGNED NOT NULL DEFAULT '1',
				`create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
				`update_by` mediumint(8) UNSIGNED DEFAULT NULL,
				`update_at` datetime DEFAULT NULL,
				PRIMARY KEY (`id`),
				KEY `fk_projects_clients1` (`client_id`)
			)" 
		);

	}

	private function init_editor() {
		$this->editor = Editor::inst( $this->db_datatables, 'sip_projects', 'id' )
			->fields(
				Field::inst( 'sip_projects.id' ),
				Field::inst( 'sip_projects.name' ),
				Field::inst( 'sip_projects.description' ),
				Field::inst( 'sip_projects.client_id' )
					->options( Options::inst()
						->table( 'sip_clients' )
						->value( 'id' )
						->label( 'name' )
					)
				,
				
				Field::inst( 'sip_clients.name' )
			)
			->leftJoin( 'sip_clients', 'sip_clients.id', '=', 'sip_projects.client_id' )
		;
	}
	
	public function get_user_projects($user_id) {
		if ( !$user_id ) {
			show_404();
			exit;
		}
		$this->editor
			->leftJoin( 'sip_users_projects', 'sip_users_projects.project_id', '=', 'sip_projects.id' )
			->where( 'sip_users_projects.user_id', $user_id, '=' );
		parent::get();
	}
}