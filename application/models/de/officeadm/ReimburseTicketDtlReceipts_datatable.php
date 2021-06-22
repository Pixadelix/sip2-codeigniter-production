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
class ReimburseTicketDtlReceipts_datatable extends CI_Editor_Model {
	
	public function __construct() {
		
		parent::__construct();
		$this->create_table();
		$this->init_editor();
		
	}

	public function create_table() {
		
		if ( $this->production() ) return;
		
		$this->db_datatables->sql(
			"CREATE TABLE IF NOT EXISTS `sip_reimburse_tickets_dtl_receipts` (
				`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
				`ticket_dtl_id` int(11) UNSIGNED NOT NULL,
				`receipt_id` int(11) UNSIGNED NOT NULL,
				PRIMARY KEY (`id`),
				UNIQUE KEY `uc_reimburse_tickets_dtl_receipts` (`ticket_dtl_id`,`receipt_id`),
				KEY `fk_reimburse_tickets_dtl_receipts_ticket_dtl1_idx` (`ticket_dtl_id`),
				KEY `fk_reimburse_tickets_dtl_receipts_receipts1_idx` (`receipt_id`)
			)" 
		);

	}

	private function init_editor() {
		$this->editor = Editor::inst( $this->db_datatables, 'sip_reimburse_tickets_dtl_receipts', 'id' )
			->fields(
				Field::inst( 'id' ),
				Field::inst( 'ticket_dtl_id' ),
				Field::inst( 'receipt_id' )
			)
		;
	}
	
	public function migrate_data($db, $source, $target) {
		printf("Migrating: %30s -> %-30s", ($source ? $source : 'NULL'), $target);
		
		$db->query("TRUNCATE TABLE `$target`");
			
		$rows = $db->query("select ticket_dtl_id, id as `receipt_id` from $source");
			
		try {
			$affected_rows = $db->insert_batch($target, $rows->result_array());
				
			printf(" %5d inserted", $affected_rows);
		}
		catch (Exception $e) {
			echo 'Caught exception: ', $e->getMessage(), PHP_EOL;
		}
	}
	
}