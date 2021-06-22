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
class Telegram_update_datatable extends CI_Editor_Model {
	
	public $table = TELEGRAM_TABLE_PREFIX.'telegram_update';
	
	public function __construct() {
		parent::__construct();
		$this->create_table();
		$this->init_editor();
	}
	
	public function create_table() {
		
		if ( $this->production() ) return;
		
		$sql = sprintf("
CREATE TABLE IF NOT EXISTS `$this->table` (
  `id` bigint UNSIGNED COMMENT 'Update''s unique identifier',
  `chat_id` bigint NULL DEFAULT NULL COMMENT 'Unique chat identifier',
  `message_id` bigint UNSIGNED DEFAULT NULL COMMENT 'Unique message identifier',
  `inline_query_id` bigint UNSIGNED DEFAULT NULL COMMENT 'Unique inline query identifier',
  `chosen_inline_result_id` bigint UNSIGNED DEFAULT NULL COMMENT 'Local chosen inline result identifier',
  `callback_query_id` bigint UNSIGNED DEFAULT NULL COMMENT 'Unique callback query identifier',
  `edited_message_id` bigint UNSIGNED DEFAULT NULL COMMENT 'Local edited message identifier',

  PRIMARY KEY (`id`),
  KEY `message_id` (`chat_id`, `message_id`),
  KEY `inline_query_id` (`inline_query_id`),
  KEY `chosen_inline_result_id` (`chosen_inline_result_id`),
  KEY `callback_query_id` (`callback_query_id`),
  KEY `edited_message_id` (`edited_message_id`),

  FOREIGN KEY (`chat_id`, `message_id`) REFERENCES `%smessage` (`chat_id`, `id`),
  FOREIGN KEY (`inline_query_id`) REFERENCES `%sinline_query` (`id`),
  FOREIGN KEY (`chosen_inline_result_id`) REFERENCES `%schosen_inline_result` (`id`),
  FOREIGN KEY (`callback_query_id`) REFERENCES `%scallback_query` (`id`),
  FOREIGN KEY (`edited_message_id`) REFERENCES `%sedited_message` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
"
					   ,
					   TELEGRAM_TABLE_PREFIX,
					   TELEGRAM_TABLE_PREFIX,
					   TELEGRAM_TABLE_PREFIX,
					   TELEGRAM_TABLE_PREFIX,
					   TELEGRAM_TABLE_PREFIX);
		
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