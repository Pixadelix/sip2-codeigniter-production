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
class ReimburseReceipts_datatable extends CI_Editor_Model {
	
	public $table = 'sip_reimburse_receipts';
	
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
				`ticket_id` int(11) UNSIGNED NOT NULL,
				`ticket_dtl_id` int(11) UNSIGNED NOT NULL,
				`full_path` varchar(255) NOT NULL,
				`img_path` varchar(255) DEFAULT NULL,
				`thumbnail_path` varchar(255) DEFAULT NULL,
				PRIMARY KEY (`id`)
			)
			;"
		);
		
        $this->post_migrate();
	}
	
	public function post_migrate() {
		
		try {
			$this->db_datatables->sql(
				"ALTER TABLE `$this->table`
					CHANGE `ticket_id` `ticket_id` INT(11) UNSIGNED NULL DEFAULT NULL,
					CHANGE `ticket_dtl_id` `ticket_dtl_id` INT(11) UNSIGNED NULL DEFAULT NULL,
					CHANGE `full_path` `full_path` VARCHAR(255) NULL DEFAULT NULL
				;"
			);
		
			$this->db_datatables->sql(
				"ALTER TABLE `$this->table`
					ADD `content_type` VARCHAR(255) NULL DEFAULT NULL AFTER `thumbnail_path`,
					ADD `extn` VARCHAR(10) NULL DEFAULT NULL AFTER `content_type`,
					ADD `filename` VARCHAR(255) NULL DEFAULT NULL AFTER `extn`,
					ADD `filesize` INT UNSIGNED NULL DEFAULT NULL AFTER `filename`,
					ADD `mimetype` VARCHAR(255) NULL DEFAULT NULL AFTER `filesize`,
					ADD `system_path` VARCHAR(512) NULL DEFAULT NULL AFTER `mimetype`,
					ADD `web_path` VARCHAR(512) NULL DEFAULT NULL AFTER `system_path`;"
			);
		}
		catch (Exception $e) {
			
		}
		
	}
	
	private function init_editor() {
		
		// Build our Editor instance and process the data coming from _POST
		$this->editor = Editor::inst( $this->db_datatables, $this->table, 'id' )
			->fields(
				Field::inst( 'sip_reimburse_receipts.id' ),
				Field::inst( 'sip_reimburse_receipts.ticket_id' ),
				Field::inst( 'sip_reimburse_receipts.ticket_dtl_id' ),
				Field::inst( 'sip_reimburse_receipts.full_path' ),
				Field::inst( 'sip_reimburse_receipts.img_path' ),
				Field::inst( 'sip_reimburse_receipts.thumbnail_path' ),
				
				Field::inst( 'sip_reimburse_receipts.content_type' ),
				Field::inst( 'sip_reimburse_receipts.extn' ),
				Field::inst( 'sip_reimburse_receipts.filename' ),
				Field::inst( 'sip_reimburse_receipts.filesize' ),
				Field::inst( 'sip_reimburse_receipts.mimetype' ),
				Field::inst( 'sip_reimburse_receipts.system_path' ),
				Field::inst( 'sip_reimburse_receipts.web_path' )
			)
		
		;
	}
	
	public function get($id = null, $id2 = null) {
		$this->editor
			->where( 'ticket_id', $id, '=');
			
		if( $id2 ) {
			$this->editor
				->where(  'ticket_dtl_id', $id2, '=' );
		}
		
		parent::get();
	}
	
}