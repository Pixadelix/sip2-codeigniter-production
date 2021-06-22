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
class ReimburseTicket_datatable extends CI_Editor_Model {
	
	public $table = 'sip_reimburse_tickets';
	
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
				`ref_code` varchar(100) NOT NULL,
				`user_id` int(11) UNSIGNED NOT NULL,
				`status` varchar(20) NOT NULL DEFAULT 'open',
				`closed_date` datetime DEFAULT NULL,
				`create_by` int(11) UNSIGNED NOT NULL,
				`create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
				`update_by` int(11) UNSIGNED DEFAULT NULL,
				`update_at` datetime DEFAULT NULL,
				PRIMARY KEY (`id`)
			)
			;"
		);
		
	}
	
	private function init_editor() {
		
		// Build our Editor instance and process the data coming from _POST
		$this->editor = Editor::inst( $this->db_datatables, $this->table, 'id' )
			->fields(
				Field::inst( "$this->table.id" ),
				Field::inst( "$this->table.ref_code" )->set(Field::SET_CREATE),
				Field::inst( "$this->table.user_id" )->set(Field::SET_CREATE),
				Field::inst( "$this->table.status" ),
				Field::inst( "$this->table.closed_date" ),
				Field::inst( "$this->table.create_by" )->set(Field::SET_CREATE),
				Field::inst( "$this->table.create_at" )->set(Field::SET_CREATE),
				Field::inst( "$this->table.update_by" )->set(Field::SET_EDIT),
				Field::inst( "$this->table.update_at" )->set(Field::SET_EDIT),
				
				Field::inst( 'sip_users.first_name' )
			)
			->leftJoin( 'sip_users', 'sip_users.id', '=', "$this->table.user_id" )
			
			->on( 'preCreate', function ( $editor, $values ) {
				$ci =& get_instance();
				$editor
					->field( "$this->table.ref_code" )
					->setValue( $ci->generate_reimburse_ref_code() );
					
				$editor
					->field( "$this->table.status" )
					->setValue( 'open' );
					
				$editor
					->field( "$this->table.user_id" )
					->setValue( $ci->user_id );
					
				$editor
					->field( "$this->table.create_by" )
					->setValue( $ci->user_id );
				$editor
					->field( "$this->table.create_at" )
					->setValue( $ci->db_value_now() );
				
				
			})
			
			->on( 'preEdit', function ( $editor, $id, $values ) {
				$ci =& get_instance();
				
				if ( 'closed' == $values[$this->table]['status'] ) {
					$editor
						->field( "$this->table.closed_date" )
						->setValue( $ci->db_value_now() );
				}
				$editor
					->field( "$this->table.update_by" )
					->setValue( $ci->user_id );
				$editor
					->field( "$this->table.update_at" )
					->setValue( $ci->db_value_now() );

			})
			
			->on( 'postEdit', function ( $editor, $id, $values ) {
				$ci =& get_instance();
				$updated_status = $editor->field( "$this->table.status" )->getValue();
				$closed_date = $editor->field( "$this->table.closed_date" )->getValue();
				if( 'closed' == $updated_status && !$closed_date ) {
					$editor
						->field( "$this->table.closed_date" )
						->setValue( $ci->db_value_now() );
				}
			})
			
		;
	}
	
	public function get_by_user_id($user_id) {
		$this->editor
			->where( 'user_id', $user_id, '=' );
			
		parent::get();
	}
	
}