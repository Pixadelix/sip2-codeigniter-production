<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// DataTables PHP library and database connection
//include_once APPPATH . DATATABLE_EDITOR;

// Alias Editor classes so they are easy to use
use	DataTables\Editor,
	DataTables\Editor\Field,
	DataTables\Editor\Format,
	DataTables\Editor\Mjoin,
	DataTables\Editor\Options,
	DataTables\Editor\Upload,
	DataTables\Editor\Validate;

load_class('Editor_Model', 'core');
class Workspace_datatable extends CI_Editor_Model {
	
    public function __construct() {
		
        parent::__construct();
		$this->create_table();
		$this->init_editor();
		
	}
	
	public function create_table() {
		
		if ( $this->production() ) return;
		
		$this->db_datatables->sql(
			"CREATE TABLE IF NOT EXISTS `sip_workspace` (
				`id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT,
				`name` varchar(100) NOT NULL,
				`edition` varchar(50) NOT NULL,
				`publish` date NOT NULL,
				`due_date` datetime DEFAULT NULL,
				`project_id` mediumint(8) UNSIGNED NOT NULL,
				`status` tinyint(3) UNSIGNED NOT NULL DEFAULT '1',
				`create_by` mediumint(8) UNSIGNED NOT NULL DEFAULT '1',
				`create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
				`update_by` mediumint(8) UNSIGNED DEFAULT NULL,
				`update_at` datetime DEFAULT NULL,
				PRIMARY KEY (`id`),
				KEY `fk_sip_workspace_projects1` (`project_id`)
			);" 
		);
		
	}
		
	private function init_editor() {
		
        // Build our Editor instance and process the data coming from _POST
		$this->editor = Editor::inst( $this->db_datatables, 'sip_workspace' )
			->fields(
				Field::inst( 'sip_workspace.id' ),
				Field::inst( 'sip_workspace.name' )->validator( 'Validate::notEmpty' ),
				Field::inst( 'sip_workspace.edition' )->validator( 'Validate::notEmpty' ),
				Field::inst( 'sip_workspace.due_date' )
					->validator( 'Validate::notEmpty' )
					->validator( 'Validate::dateFormat', array( 'format'=>'d-m-Y' ) )
					->getFormatter( 'Format::datetime', array( 'from'=>'Y-m-d H:i:s', 'to'  =>'d-m-Y' ) )
					->setFormatter( 'Format::datetime', array( 'to'  =>'Y-m-d H:i:s', 'from'=>'d-m-Y' ) )
					/*
					->validator( 'Validate::dateFormat', array(
						"format"  => Format::DATE_ISO_8601,
						"message" => "Please enter a date in the format d-m-Y"
				) )
					*/
					//->getFormatter( 'Format::date_sql_to_format', Format::DATE_ISO_8601 )
					//->setFormatter( 'Format::date_format_to_sql', Format::DATE_ISO_8601 )
				,
				Field::inst( 'sip_workspace.publish' )
					->validator( 'Validate::dateFormat', array( 'format'=>'d-m-Y' ) )
					->getFormatter( 'Format::datetime', array( 'from'=>'Y-m-d', 'to'  =>'d-m-Y' ) )
					->setFormatter( 'Format::datetime', array( 'to'  =>'Y-m-d', 'from'=>'d-m-Y' ) ),
					/*
					->validator( 'Validate::dateFormat', array(
						"format"  => Format::DATE_ISO_8601,
						"message" => "Please enter a date in the format yyyy-mm-dd"
				) )
					->getFormatter( 'Format::date_sql_to_format', Format::DATE_ISO_8601 )
					->setFormatter( 'Format::date_format_to_sql', Format::DATE_ISO_8601 ),
					*/
				Field::inst( 'sip_workspace.project_id' )
					->options( Options::inst()
						->table( 'sip_projects' )
						->value( 'id' )
						->label( 'name' )
					)
					->validator( 'Validate::notEmpty' )
					->validator( 'Validate::dbValues' ),
				Field::inst( 'sip_projects.name' ),
				Field::inst( 'sip_workspace.status' )
					->validator( 'Validate::notEmpty' )
					->options(
						function() {
							return array(
								array('value' => WS_ACTIVE,        'label' => '<i class="fa fa-fw fa-circle-o"></i> Active'),
								array('value' => WS_FULLSCRIPT,    'label' => '<i class="fa fa-fw fa-star-half"></i> Fullscript'),
								array('value' => WS_FULLBOOK,      'label' => '<i class="fa fa-fw fa-star-o"></i> Fullbook'),
								array('value' => WS_PUBLISHED,     'label' => '<i class="fa fa-fw fa-star-half-o"></i> Published'),
								array('value' => WS_FINISHED,      'label' => '<i class="fa fa-fw fa-star"></i> Finished'),
								array('value' => WS_ARCHIVED,      'label' => '<i class="fa fa-fw fa-archive"></i> Archived'),
							);
						})
					,
				Field::inst( 'sip_users.first_name' ),
				Field::inst( 'sip_view_workspace_progress.progress_task' )
			)
			->leftJoin( 'sip_projects', 'sip_projects.id', '=', 'sip_workspace.project_id' )
			->leftJoin( 'sip_users', 'sip_users.id', '=', 'sip_workspace.create_by' )
			->leftJoin( 'sip_view_workspace_progress', 'sip_view_workspace_progress.mag_id', '=', 'sip_workspace.id' )
			;
    }
	
	public function get($id = null, $id2 = null) {
		if( $id ) {
			$this->editor
				->where( 'sip_workspace.id', $id, '=' );
		}
		parent::get();
	}
	
	public function get_by_project($project_id) {
		$this->editor
			->where( 'sip_workspace.project_id', $project_id, '=' );
		parent::get();
	}
	
	public function get_by_users_project($project_id) {
		$this->editor
			->leftJoin( 'sip_users_projects', 'sip_users_projects.project_id', '=', 'sip_workspace.project_id' )
			->where( 'sip_users_projects.project_id', $project_id, '=' );
		parent::get();
	}
}
