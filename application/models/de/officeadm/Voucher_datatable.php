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
class Voucher_datatable extends CI_Editor_Model {
	
	public $table = 'sip_voucher';
    
    const STATUS_VALID   = 1;
    const STATUS_INVALID = 0;
	
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
                    `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
                    `type` int(5) UNSIGNED NOT NULL,
                    `group` int(5) UNSIGNED NOT NULL,
                    
                    `name` varchar(200) NOT NULL,
                    `code` varchar(50) NOT NULL,
                    
                    `starting_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
                    `expired_date` datetime NOT NULL,
                    `notes`  text DEFAULT NULL,
                    
                    `used_by` int(11)  NULL DEFAULT NULL,
                    `used_at` datetime NULL  DEFAULT NULL,
                    
                    `status` int(1) UNSIGNED NOT NULL DEFAULT 1 comment '0 = invalid, 1 = valid',
                    
                    `create_by` mediumint(8) UNSIGNED NOT NULL DEFAULT '1',
                    `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                    `update_by` mediumint(8) UNSIGNED DEFAULT NULL,
                    `update_at` datetime DEFAULT NULL,

                    UNIQUE( `type`, `group`, `code`, `starting_date`, `expired_date`),
                    INDEX ( `used_by` ),
                    INDEX ( `code` ),
                    PRIMARY KEY( `id` )
                )

                ;" 
            );
            
		}
		
		catch( Exception $e ) {
			//show_error($e->message, 0);
		}
		
	}
    /*
    public function create_view() {
        if ( $this->production() ) return;
        
        $this->db_datatables->sql(
            "CREATE OR REPLACE VIEW `sip_voucher_available` AS
            SELECT *
              FROM `sip_voucher` v
             WHERE (NOT EXISTS (SELECT `voucher_id` FROM `sip_voucher_task` v2 WHERE v2.voucher_id = v.id)
                     OR EXISTS (SELECT `voucher_id` FROM `sip_voucher_task` v2 WHERE v2.voucher_id = v.id)
                   )
               AND v.starting_date <= CURRENT_DATE
               AND v.expired_date >= CURRENT_DATE
               LIMIT 2
               ;"
        );
    }
    */

	

	
	private function init_editor() {
		
		// Build our Editor instance and process the data coming from _POST
		$this->editor = Editor::inst( $this->db_datatables, $this->table, 'id' )
			->fields(
				Field::inst( "$this->table.id" ),
				Field::inst( "$this->table.type" )
					->options( Options::inst()
						->table( 'sip_voucher_type' )
						->value( 'id' )
						->label( 'type' )
					),
                Field::inst( "sip_voucher_type.type" ),
				Field::inst( "$this->table.group" )
					->options( Options::inst()
						->table( 'sip_voucher_group' )
						->value( 'id' )
						->label( 'group' )
					),
                Field::inst( "sip_voucher_group.group" ),
                Field::inst( "$this->table.name" ),
                Field::inst( "$this->table.code" ),
                Field::inst( "$this->table.starting_date" )
                    ->validator( Validate::dateFormat( 'j M Y' ) )
                    ->getFormatter( Format::datetime( 'Y-m-d H:i:s', 'j M Y' ) )
                    ->setFormatter( Format::datetime( 'j M Y', 'Y-m-d H:i:s' ) )
                ,
                Field::inst( "$this->table.expired_date" )
                    ->validator( Validate::dateFormat( 'j M Y' ) )
                    ->getFormatter( Format::datetime( 'Y-m-d H:i:s', 'j M Y' ) )
                    ->setFormatter( Format::datetime( 'j M Y', 'Y-m-d H:i:s' ) )
                    //->validator( Validate::dateFormat( 'j M Y H:i' ) )
                    //->getFormatter( Format::datetime( 'Y-m-d H:i:s', 'j M Y H:i' ) )
                    //->setFormatter( Format::datetime( 'j M Y H:i'  , 'Y-m-d H:i:s' ) )
                    //->validator( 'Validate::dateFormat', array( 'format'=>'d/m/Y H:m:s', 'message'=>'Please enter date (dd/mm/yyyy)' ) )
					//->getFormatter( 'Format::date_sql_to_format', 'd/m/Y H:m:s' )
					//->setFormatter( 'Format::date_format_to_sql', 'd/m/Y H:m:s' )
                ,
                Field::inst( "$this->table.notes" ),
                
				Field::inst( "$this->table.used_by" )
                    ->validator( Validate::numeric() )
                    ->setFormatter( Format::ifEmpty(null) )
                    ->options( Options::inst()
                        ->table( 'sip_users' )
                        ->value( 'id' )
                        ->label( 'first_name' )
                    )
                ,
                Field::inst( "sip_users.first_name" ),
				Field::inst( "$this->table.used_at" )
                    ->validator( Validate::dateFormat( 'd/m/Y H:i:s' ) )
                    ->getFormatter( Format::datetime( 'Y-m-d H:i:s', 'd/m/Y H:i:s' ) )
                    ->setFormatter( Format::datetime( 'd/m/Y H:i:s', 'Y-m-d H:i:s' ) )
                ,
                
                Field::inst( "$this->table.status" ),
                
                Field::inst( "$this->table.create_by" )->set(Field::SET_CREATE),
                Field::inst( "$this->table.create_at" )->set(Field::SET_CREATE),
                Field::inst( "$this->table.update_by" )->set(Field::SET_EDIT),
                Field::inst( "$this->table.update_at" )->set(Field::SET_EDIT),
                Field::inst( "sip_voucher_task.task_id" ),
                Field::inst( "sip_tasks.event_name" )
			)
            ->leftJoin( 'sip_voucher_type', 'sip_voucher_type.id', '=', "$this->table.type" )
            ->leftJoin( 'sip_voucher_group', 'sip_voucher_group.id', '=', "$this->table.group" )
            ->leftJoin( 'sip_users', 'sip_users.id', '=', "$this->table.used_by" )
            
            ->leftJoin( 'sip_voucher_task', 'sip_voucher_task.voucher_id', '=', "$this->table.id" )
            ->leftJoin( 'sip_tasks', 'sip_tasks.id', '=', "sip_voucher_task.task_id" )
            
            ->on( 'preCreate', function ( $editor, $values ) {
                $this->default_create_log();
            } )
            
            ->on( 'preEdit', function ( $editor, $values ) {
                $this->default_edit_log();
            } )
		;
	}	
}