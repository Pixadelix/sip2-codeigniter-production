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
class Inline_query_datatable extends CI_Editor_Model {
	
	public $table = TELEGRAM_TABLE_PREFIX.'inline_query';
	
	public function __construct() {
		parent::__construct();
		$this->create_table();
		$this->init_editor();
	}
	
	public function create_table() {
		
		if ( $this->production() ) return;
		
		$sql = sprintf("
CREATE TABLE IF NOT EXISTS `$this->table` (
  `id` bigint UNSIGNED COMMENT 'Unique identifier for this query',
  `user_id` bigint NULL COMMENT 'Unique user identifier',
  `location` CHAR(255) NULL DEFAULT NULL COMMENT 'Location of the user',
  `query` TEXT NOT NULL COMMENT 'Text of the query',
  `offset` CHAR(255) NULL DEFAULT NULL COMMENT 'Offset of the result',
  `created_at` timestamp NULL DEFAULT NULL COMMENT 'Entry date creation',

  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),

  FOREIGN KEY (`user_id`) REFERENCES `%suser` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

"
					   , TELEGRAM_TABLE_PREFIX);
		
		$this->db_datatables->sql($sql);
		
	}
	
	public function init_editor() {
		$this->editor = Editor::inst( $this->db_datatables, $this->table, 'id' )
			->fields(
				Field::inst( "$this->table.id" )
			)
		;
	}

}