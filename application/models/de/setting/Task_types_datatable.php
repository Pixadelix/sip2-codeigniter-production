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
class Task_types_datatable extends CI_Editor_Model {
	
	public $table = 'sip_task_types';
	
	public function __construct() {
		parent::__construct();
		$this->create_table();
		$this->init_editor();
	}
	
	public function create_table() {
		if ( $this->production() ) return;
		
		$this->db_datatables->sql(
			"CREATE TABLE IF NOT EXISTS `$this->table` (
				`id` int(4) UNSIGNED NOT NULL AUTO_INCREMENT,
				`label` varchar(255) NOT NULL,
				`description` varchar(255),
--				`code` varchar(255),
				`icon` varchar(255),
				`create_by` int(11) UNSIGNED NOT NULL DEFAULT 0,
				`create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
				`update_by` int(11) UNSIGNED DEFAULT NULL,
				`update_at` datetime DEFAULT NULL,
				PRIMARY KEY (`id`),
				UNIQUE KEY `uc_task_types` (`label`)
			)"
		);
	}
	
	public function init_editor() {
		$this->editor = Editor::inst( $this->db_datatables, $this->table, 'id' )
			->fields(
				Field::inst( 'id' ),
				Field::inst( 'label' ),
				Field::inst( 'description' ),
				//Field::inst( 'code' ),
				Field::inst( 'icon' )
			)
		;
	}
	
	public function baseline_values() {
		if ( $this->production() ) return;
		
		//printf("Generating baseline: %30s", $this->table);
		
		$this->db_datatables->sql(
			"INSERT IGNORE INTO `$this->table` (`label`, `icon`) VALUES
			( 'Common'        , 'vidCommon'         ), -- 'TASK_TYPE_COMMON'          , 'fa-desktop';
			( 'Coverage'      , 'vidCoverage'       ), -- 'TASK_TYPE_COVERAGE'        , 'fa-video-camera'; //'fa-building';
			( 'Interview'     , 'vidInterview'      ), -- 'TASK_TYPE_INTERVIEW'       , 'fa-microphone'; //'fa-phone';
			( 'Writing'       , 'vidWriting'        ), -- 'TASK_TYPE_WRITING'         , 'fa-pencil';
			( 'Photo'         , 'vidPhoto'          ), -- 'TASK_TYPE_PHOTO'           , 'fa-camera';
			( 'Editing'       , 'vidEditing'        ), -- 'TASK_TYPE_EDITING'         , 'fa-edit';
			( 'Design'        , 'vidDesign'         ), -- 'TASK_TYPE_DESIGN'          , 'fa-image';
			( 'Others'        , 'vidOthers'         ), -- 'TASK_TYPE_OTHERS'          , 'fa-check';
			( 'Meeting'       , 'vidMeeting'        ), -- 'TASK_TYPE_MEETING'         , 'fa-briefcase';
			( 'Marketing'     , 'vidMarketing'      ), -- 'TASK_TYPE_MARKETING'       , 'fa-bullhorn'; //'fa-dollar';
			( 'Presentation'  , 'vidPresentation'   ), -- 'TASK_TYPE_PRESENTATION'    , 'fa-film';
			( 'Contact Report', 'vidContact-Report' ), -- 'TASK_TYPE_CONTACT_REPORT'  , 'fa-hand-o-right';
			( 'Follow Up'     , 'vidFollow-Up'      ), -- 'TASK_TYPE_FOLLOW_UP'       , 'fa-hand-o-up';
			( 'BAST'          , 'vidBAST'           ), -- 'TASK_TYPE_BAST'            , 'fa-angle-double-right';
			( 'QC'            , 'vidQC'             ), -- 'TASK_TYPE_QC'              , 'fa-arrow-right';
			( 'Final QC'      , 'vidFinal-QC'       ), -- 'TASK_TYPE_FINAL_QC'        , 'fa-arrows-alt';
			( 'Deliver'       , 'vidDeliver'        ), -- 'TASK_TYPE_DELIVER'         , 'fa-truck';
			( 'Production'    , 'vidProduction'     )  -- 'TASK_TYPE_PRODUCTION'      , 'fa-trophy';
			"
		);
		
	}
}