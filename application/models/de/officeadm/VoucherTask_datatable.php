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
class VoucherTask_datatable extends CI_Editor_Model {
	
	public $table = 'sip_voucher_task';
	
	public function __construct() {
		
		parent::__construct();
		$this->create_table();
	}
	
	public function create_table() {

		if ( $this->production() ) return;

        try {
            
            $this->db_datatables->sql(
                "CREATE TABLE IF NOT EXISTS `$this->table` (
                    `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
                    
                    `voucher_id` int(11) UNSIGNED NOT NULL,
                    `task_id` int(11) UNSIGNED DEFAULT NULL,
                    `user_id` int(11) UNSIGNED DEFAULT NULL,
                    
                    `create_by` mediumint(8) UNSIGNED NOT NULL DEFAULT '1',
                    `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                    `update_by` mediumint(8) UNSIGNED DEFAULT NULL,
                    `update_at` datetime DEFAULT NULL,
                    
                    INDEX ( `voucher_id` ),
                    INDEX ( `task_id` ),
                    INDEX ( `user_id` ),

                    PRIMARY KEY( `id` )
                )

                ;" 
            );
		}
		
		catch( Exception $e ) {
			//show_error($e->message, 0);
		}
		
	}

	
}