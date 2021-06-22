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
class Subscribers_datatable extends CI_Editor_Model {
	
	public $table = 'eproc_subscribers';
	
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
				
				`user_id` int(11) UNSIGNED NOT NULL,
				`plan_id` int(5) UNSIGNED DEFAULT NULL,
				`expired_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
				
				`create_by` mediumint(8) UNSIGNED NOT NULL DEFAULT '1',
				`create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
				`update_by` mediumint(8) UNSIGNED DEFAULT NULL,
				`update_at` datetime DEFAULT NULL,
				
				INDEX `idx_user_id` (`user_id`),
				INDEX `idx_plan_id` (`plan_id`),
				
				PRIMARY KEY( `id` )
			)
			;"
		);
		
	}

	public function init_editor() {
		$this->editor = Editor::inst( $this->db_datatables, $this->table, 'id' )
			->fields(
				Field::inst( "$this->table.id" ),
				Field::inst( "$this->table.user_id" )
					->set(Field::SET_CREATE)
					->options( Options::inst()
						->table( 'sip_users' )
						->value( 'sip_users.id' )
						->label( 'sip_users.first_name, sip_users.last_name' )
						->order( 'sip_users.first_name' )
						->where( function ( $q ) {
							$q->where( 'id', 2, '>' );
							$q->where( 'first_name', null, 'is not');
							$q->where( 'first_name', '', '!=');
						})
						->render( function ( $row ) {
							return $row['sip_users.first_name'].' '.$row['sip_users.last_name'];
						})
					)
				,
				Field::inst( "$this->table.expired_date" )
					->validator( 'Validate::dateFormat', array( 'format'=>'Y-m-d' ) )
					->getFormatter( 'Format::datetime', array( 'from'=>'Y-m-d H:i:s', 'to'  =>'Y-m-d' ) )
					->setFormatter( 'Format::datetime', array( 'to'  =>'Y-m-d H:i:s', 'from'=>'Y-m-d' ) )
				,
				
				Field::inst( "$this->table.create_by"                 )->set(Field::SET_CREATE),
				Field::inst( "$this->table.create_at"                 )->set(Field::SET_CREATE),
				Field::inst( "$this->table.update_by"                 )->set(Field::SET_EDIT),
				Field::inst( "$this->table.update_at"                 )->set(Field::SET_EDIT),
				
				Field::inst( 'sip_users.first_name' ),
				Field::inst( 'sip_users.last_name' )
			)
			->leftJoin( 'sip_users', 'sip_users.id', '=', "$this->table.user_id" )
		;
	}
}