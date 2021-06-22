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
class Monitored_datatable extends CI_Editor_Model {
	
	public $table = 'eproc_monitored';
	
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
				`lpse_id` int(11) UNSIGNED NOT NULL,
				
				`create_by` mediumint(8) UNSIGNED NOT NULL DEFAULT '1',
				`create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
				`update_by` mediumint(8) UNSIGNED DEFAULT NULL,
				`update_at` datetime DEFAULT NULL,
				
				INDEX `idx_user_id` (`user_id`),
				INDEX `idx_lpse_id` (`lpse_id`),
				
				PRIMARY KEY( `id` )
			)
			;"
		);
		
		//CREATE TABLE `dev1-mv-sip2db`. ( `id` INT NOT NULL , `user_id` INT NOT NULL , INDEX `dsds` (`user_id`)) ENGINE = InnoDB;
		
		//$this->db_datatables->sql("ALTER TABLE `$this->table` ADD INDEX(`user_id`);");
		//$this->db_datatables->sql("ALTER TABLE `$this->table` ADD INDEX(`lpse_id`);");
	}

	public function init_editor() {
		$this->editor = Editor::inst( $this->db_datatables, $this->table, 'id' )
			->fields(
				Field::inst( "$this->table.id" ),
				Field::inst( "$this->table.user_id" )
					->set(Field::SET_CREATE)
				,
				Field::inst( "$this->table.lpse_id" )
					->options( Options::inst()
						->table( 'eproc_lpse' )
						->value( 'eproc_lpse.id' )
						->label( 'eproc_lpse.name' )
						->order( 'eproc_lpse.name' )
						->where( function ( $q ) {
							$q->where( 'status', \Model\Eproc_lpse::LPSE_STATUS_ACTIVE, '=' );
							} )
					)
				,
				
				Field::inst( "eproc_lpse.name" )
			)
			->leftJoin( 'eproc_lpse', 'eproc_lpse.id', '=', "$this->table.lpse_id" )
			
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