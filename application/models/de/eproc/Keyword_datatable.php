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
class Keyword_datatable extends CI_Editor_Model {
	
	public $table = 'eproc_keyword';
	
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
				`keyword` varchar(512) NOT NULL,
				
				`create_by` mediumint(8) UNSIGNED NOT NULL DEFAULT '1',
				`create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
				`update_by` mediumint(8) UNSIGNED DEFAULT NULL,
				`update_at` datetime DEFAULT NULL,
				
				INDEX `idx_user_id` (`user_id`),
				
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
					->set(Field::SET_CREATE),
				Field::inst( "$this->table.keyword" ),
				
				Field::inst( "$this->table.create_by"                 )->set(Field::SET_CREATE),
				Field::inst( "$this->table.create_at"                 )->set(Field::SET_CREATE),
				Field::inst( "$this->table.update_by"                 )->set(Field::SET_EDIT),
				Field::inst( "$this->table.update_at"                 )->set(Field::SET_EDIT),
				
				Field::inst( 'sip_users.first_name' ),
				Field::inst( 'sip_users.last_name' )
			)
			->leftJoin( 'sip_users', 'sip_users.id', '=', "$this->table.user_id" )
			
			->on( 'preCreate', function ( $editor, $values ) {
				$ci =& get_instance();
				$editor
					->field( "$this->table.user_id" )
					->setValue( $ci->user_id );
				
				$this->default_create_log();
			})
			
			->on( 'preEdit', function ( $editor, $values ) {
				
				$this->default_edit_log();
			})
			
		;
	}
	
	public function get($id = null, $id2 = null) {
		$ci =& get_instance();
		$this->editor
			->where( "$this->table.user_id", $ci->user_id );
		
		parent::get($id, $id2);
	}
}