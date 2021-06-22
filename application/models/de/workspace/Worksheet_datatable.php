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
class Worksheet_datatable extends CI_Editor_Model {
	
	public function __construct() {
		
		parent::__construct();
		$this->create_table();
		$this->init_editor();
	}
	
	public function create_table() {

		if ( $this->production() ) return;
		
		$this->db_datatables->sql(
			"CREATE TABLE IF NOT EXISTS `sip_worksheet` (
				`id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT,
				`mag_id` mediumint(8) UNSIGNED NOT NULL,
				`rubric` text NOT NULL,
				`content` text,
				`source` varchar(50) DEFAULT NULL,
				`due_date` date DEFAULT NULL,
				`status` tinyint(3) UNSIGNED NOT NULL DEFAULT '1',
				`replaced_for` mediumint(8) UNSIGNED DEFAULT NULL,
				`position` tinyint(3) UNSIGNED NOT NULL DEFAULT '1',
				`pages` tinyint(3) UNSIGNED NOT NULL DEFAULT '1',
				`notes` text,
				`f_script` varchar(1) NOT NULL DEFAULT 'N',
				`f_editing` varchar(1) NOT NULL DEFAULT 'N',
				`f_foto` varchar(1) NOT NULL DEFAULT 'N',
				`f_layout` varchar(1) NOT NULL DEFAULT 'N',
				`create_by` mediumint(8) UNSIGNED NOT NULL DEFAULT '1',
				`create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
				`update_by` mediumint(8) UNSIGNED DEFAULT NULL,
				`update_at` datetime DEFAULT NULL,
				`change_logs` text,
				PRIMARY KEY (`id`),
				KEY `fk_sip_tabs_mags1` (`mag_id`)
			)"
		);
	}

	private function init_editor() {
		$this->editor = Editor::inst( $this->db_datatables, 'sip_worksheet', 'id' )
			->fields(
				Field::inst( 'id' ),
				Field::inst( 'mag_id' )
					->options( Options::inst()
						->table( 'sip_workspace' )
						->value( 'sip_workspace.id' )
						->label( 'sip_workspace.name, sip_workspace.edition' )
						->order( 'sip_workspace.name' )
						->where( function ( $q ) {
							$q->where( 'status', WS_ACTIVE, '=' );
						})
						->render( function ( $r ) {
							return $r['sip_workspace.name'].' <em class="note">'.$r['sip_workspace.edition'].'</em>';
						})
					)
					->validator( 'Validate::notEmpty' )
				,
				Field::inst( 'rubric' )
					->validator( 'Validate::notEmpty' )
				,
				Field::inst( 'content' ),
				Field::inst( 'source' )
					->validator( 'Validate::notEmpty' )
					->options(function() {
						return array(
							array('value' => 'Writing'    , 'label' => 'Penulisan'),
							array('value' => 'Research'   , 'label' => 'Riset'),
							array('value' => 'Coverage'   , 'label' => 'Liputan'),
							array('value' => 'Interview'  , 'label' => 'Wawancara'),
							array('value' => 'From Client', 'label' => 'Dari Klien'),
							array('value' => 'DMC'        , 'label' => 'DMC'),
							array('value' => 'other'      , 'label' => 'Lain-lain'),
						);
					})
				,
				Field::inst( 'due_date' )
					//->validator( 'Validate::notEmpty' )
					->validator( 'Validate::dateFormat', array( 'format'=>'d/m/Y H:i' ) )
					->getFormatter( 'Format::datetime', array( 'from'=>'Y-m-d H:i:s', 'to'  =>'d/m/Y H:i' ) )
					->setFormatter( 'Format::datetime', array( 'to'  =>'Y-m-d H:i:s', 'from'=>'d/m/Y H:i' ) ),
				Field::inst( 'status' ),
				Field::inst( 'replaced_for' ),
				Field::inst( 'position' )
					->options(function() {
						$pages = array();
						for($i = 1; $i <= 100; $i++) {
							$pages[] = array('value' => $i, 'label' => $i);
						}
						return $pages;
					})
					->validator( 'Validate::notEmpty' )
					->validator( 'Validate::numeric' )
				,
				Field::inst( 'pages' )
					->options(function() {
						$pages = array();
						for($i = 1; $i <= 10; $i++) {
							$pages[] = array('value' => $i, 'label' => $i);
						}
						return $pages;
					})
					->validator( 'Validate::notEmpty' )
					->validator( 'Validate::numeric' )
				,
				Field::inst( 'notes' ),
				Field::inst( 'f_script' ),
				Field::inst( 'f_editing' ),
				Field::inst( 'f_foto' ),
				Field::inst( 'f_layout' ),
				Field::inst( 'change_logs' )
			)			
		;			
	}
	
	public function get($id = null, $id2 = null) {
		
		// Filter workspace select options
		global $_id;
		$_id = $id;
		
		$this->editor->field( 'mag_id' )->options()
			->where( function ( $q ) {
				global $_id;
				//$q->where( 'sip_workspace.id', $_id );
			})
		;
		
		$this->editor
			->where( 'mag_id', $id, '=' );
		parent::get();
	}
	
}