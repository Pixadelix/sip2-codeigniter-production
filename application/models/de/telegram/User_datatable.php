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
class User_datatable extends CI_Editor_Model {
	
	public $table = TELEGRAM_TABLE_PREFIX.'user';
	
	public function __construct() {
		parent::__construct();
		$this->create_table();
		$this->init_editor();
	}
	
	public function create_table() {
		
		if ( $this->production() ) return;
		
		$this->db_datatables->sql(
			"CREATE TABLE IF NOT EXISTS `$this->table` (
			`id` bigint COMMENT 'Unique user identifier',
			`is_bot` tinyint(1) DEFAULT 0 COMMENT 'True if this user is a bot',
			`first_name` CHAR(255) NOT NULL DEFAULT '' COMMENT 'User''s first name',
			`last_name` CHAR(255) DEFAULT NULL COMMENT 'User''s last name',
			`username` CHAR(191) DEFAULT NULL COMMENT 'User''s username',
			`language_code` CHAR(10) DEFAULT NULL COMMENT 'User''s system language',
			`created_at` timestamp NULL DEFAULT NULL COMMENT 'Entry date creation',
			`updated_at` timestamp NULL DEFAULT NULL COMMENT 'Entry date update',

			PRIMARY KEY (`id`),
			KEY `username` (`username`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
		;"
		);
		
	}
	
	public function init_editor() {
		$this->editor = Editor::inst( $this->db_datatables, $this->table, 'id' )
			->fields(
				Field::inst( "id" ),
				Field::inst( "is_bot" ),
				Field::inst( "first_name" ),
				Field::inst( "last_name" ),
				Field::inst( "username" ),
				Field::inst( "language_code" ),
				Field::inst( "created_at" ),
				Field::inst( "updated_at" )
			)
		;
	}
	
	public function get_by_username($username) {
		return $this->editor
			->where('username', $username, '=')
			->process( null )
			->data()['data'];
			
			
			
		
		//parent::get(null, null);
	}

}