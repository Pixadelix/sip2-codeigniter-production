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
class User_chat_datatable extends CI_Editor_Model {
	
	public $table = TELEGRAM_TABLE_PREFIX.'user_chat';
	
	public function __construct() {
		parent::__construct();
		$this->create_table();
		$this->init_editor();
	}
	
	public function create_table() {
		
		if ( $this->production() ) return;
		
		$sql = sprintf("
CREATE TABLE IF NOT EXISTS `$this->table` (
  `user_id` bigint COMMENT 'Unique user identifier',
  `chat_id` bigint COMMENT 'Unique user or chat identifier',

  PRIMARY KEY (`user_id`, `chat_id`),

  FOREIGN KEY (`user_id`) REFERENCES `%suser` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (`chat_id`) REFERENCES `%schat` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

"
					   , TELEGRAM_TABLE_PREFIX, TELEGRAM_TABLE_PREFIX);
		
		$this->db_datatables->sql($sql);
		
	}
	
	public function init_editor() {
		$this->editor = Editor::inst( $this->db_datatables, $this->table, 'id' )
			->fields(
				Field::inst( "$this->table.user_id" ),
				Field::inst( "$this->table.chat_id" )
			)
		;
	}

}