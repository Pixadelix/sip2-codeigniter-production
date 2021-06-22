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
class AdminDocumentArchive_datatable extends CI_Editor_Model {
	
	public $table = 'sip_admin_document_archive';
	
	public function __construct() {
		
		parent::__construct();
		$this->create_table();
		$this->init_editor();
		
	}
	
	public function create_table() {

		if ( $this->production() ) return;

        try {
            
            $this->db_datatables->sql(
                "CREATE TABLE IF NOT EXISTS `$this->table` (
                    `archive_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
                    `id` int(11) UNSIGNED NOT NULL,
                    `type` varchar(200) NOT NULL,
                    `group` varchar(200) NOT NULL,
                    `refcode` varchar(200) DEFAULT NULL,
                    `refdate` datetime NOT NULL,
                    `notes` text DEFAULT NULL,
                    `content` text DEFAULT NULL,
                    `status` VARCHAR(50) DEFAULT NULL,
                    `create_by` mediumint(8) UNSIGNED NOT NULL DEFAULT '1',
                    `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                    `update_by` mediumint(8) UNSIGNED DEFAULT NULL,
                    `update_at` datetime DEFAULT NULL,
                    
                    UNIQUE ( `id`, `type`, `group`, `refdate` ),

                    PRIMARY KEY( `archive_id` )
                )

                ;" 
            );

		}
		
		catch( Exception $e ) {
			//show_error($e->message, 0);
		}
		
	}

	private function init_editor() {
		
		// Build our Editor instance and process the data coming from _POST
		$this->editor = Editor::inst( $this->db_datatables, $this->table, 'archive_id' )
			->fields(
                Field::inst( 'archive_id' ),
				Field::inst( 'id' ),
				Field::inst( 'type' )
					->options( Options::inst()
						->table( 'sip_admin_document_type' )
						->value( 'type' )
						->label( 'type' )
					),
				Field::inst( 'group' )
					->options( Options::inst()
						->table( 'sip_admin_document_group' )
						->value( 'group' )
						->label( 'group' )
					),
				Field::inst( 'refcode' ),
				Field::inst( 'refdate' )
					->validator( 'Validate::dateFormat', array( 'format'=>'d/m/y', 'message'=>'Please enter date (d/m/y)' ) )
					->getFormatter( 'Format::date_sql_to_format', 'd/m/y' )
					->setFormatter( 'Format::date_format_to_sql', 'd/m/y' ),
				Field::inst( 'notes' )
					->validator('Validate::notEmpty')
				,
				Field::inst( 'content' )
			)
		;
	}
	
}