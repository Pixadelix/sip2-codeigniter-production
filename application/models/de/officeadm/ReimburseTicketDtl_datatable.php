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
class ReimburseTicketDtl_datatable extends CI_Editor_Model {
    
    public $table = 'sip_reimburse_tickets_dtl';
	
	public $ci = null;
	protected $receipt = array(
        'full_path'      => null,
		'img_path'       => null,
		'thumbnail_path' => null,
		'content_type'   => null,
		'extn'           => null,
		'filename'       => null,
		'filesize'       => null,
		'mimetype'       => null,
		'system_path'    => null,
		'web_path'       => null,
    );
	protected $receipt_cfg = null;
	
	public function __construct() {
		
		parent::__construct();
		$this->create_table();
		
		$this->ci =& get_instance();
		$this->receipt_cfg = $this->ci->config->item('receipts');
        $this->_upload();
		$this->init_editor();
		
	}
	
	public function create_table() {
		
		if ( $this->production() ) return;

		$this->db_datatables->sql(
			"CREATE TABLE IF NOT EXISTS `$this->table` (
				`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
				`ticket_id` int(11) UNSIGNED NOT NULL,
				`user_id` int(11) UNSIGNED NOT NULL,
				`date` datetime NOT NULL,
				`type` varchar(50) NOT NULL,
				`receipt_number` varchar(100) DEFAULT NULL,
				`notes` text NOT NULL,
				`receipt` varchar(255) DEFAULT NULL,
				`amount` decimal(10,0) NOT NULL DEFAULT '0',
				`qty` decimal(10,0) NOT NULL DEFAULT '1',
				`status` varchar(20) NOT NULL DEFAULT 'process',
				`status_notes` text,
				`create_by` int(11) UNSIGNED NOT NULL,
				`create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
				`update_by` int(11) UNSIGNED DEFAULT NULL,
				`update_at` datetime DEFAULT NULL,
				`change_log` longtext,
				PRIMARY KEY (`id`)
			)
			;"
		);
		
	}
	
	private function init_editor() {
		
		// Build our Editor instance and process the data coming from _POST
		$this->editor = Editor::inst( $this->db_datatables, $this->table, 'id' )
			->fields(
				Field::inst( 'sip_reimburse_tickets_dtl.id' ),
				Field::inst( 'sip_reimburse_tickets_dtl.ticket_id' ),
				Field::inst( 'sip_reimburse_tickets_dtl.user_id' )->set(Field::SET_CREATE),
				Field::inst( 'sip_reimburse_tickets_dtl.date' )
					->validator('Validate::notEmpty')
					->validator( 'Validate::dateFormat', array( 'format'=>'d-m-Y H:i' ) )
					->getFormatter( 'Format::datetime', array( 'from'=>'Y-m-d H:i:s', 'to'  =>'d-m-Y H:i' ) )
					->setFormatter( 'Format::datetime', array( 'to'  =>'Y-m-d H:i:s', 'from'=>'d-m-Y H:i' ) ),
				Field::inst( 'sip_reimburse_tickets_dtl.type' )
				->options(function() {
						return array(
							array( 'value' => 'Reimburse', 'label' => '<i class="fa fa-fw fa-taxi"></i> Reimburse' ),
							array( 'value' => 'Allowance', 'label' => '<i class="fa fa-fw fa-clock-o"></i> Allowance' ),
							array( 'value' => 'Fee', 'label' => '<i class="fa fa-fw fa-user-plus"></i> Fee' ),
						);
					})
					->validator('Validate::notEmpty')
				,
				Field::inst( 'sip_reimburse_tickets_dtl.receipt_number' ),
				Field::inst( 'sip_reimburse_tickets_dtl.notes' )
					->validator('Validate::notEmpty')
				,
				Field::inst( 'sip_reimburse_tickets_dtl.receipt' ),
				Field::inst( 'sip_reimburse_tickets_dtl.amount' )
					->validator('Validate::notEmpty')
					->validator('Validate::numeric', array('decimal' => ','))
				,
				Field::inst( 'sip_reimburse_tickets_dtl.qty' )
					->validator('Validate::notEmpty')
					->validator('Validate::numeric')
				,
				Field::inst( 'sip_reimburse_tickets_dtl.status' ),
				Field::inst( 'sip_reimburse_tickets_dtl.create_by' )->set(Field::SET_CREATE),
				Field::inst( 'sip_reimburse_tickets_dtl.create_at' )->set(Field::SET_CREATE),
				Field::inst( 'sip_reimburse_tickets_dtl.update_by' )->set(Field::SET_EDIT),
				Field::inst( 'sip_reimburse_tickets_dtl.update_at' )->set(Field::SET_EDIT),
				Field::inst( 'sip_reimburse_tickets_dtl.change_log' ),
				
				Field::inst( 'sip_users.first_name' )
			)
			->leftJoin( 'sip_users', 'sip_users.id', '=', 'sip_reimburse_tickets_dtl.user_id' )
			->join(
				Mjoin::inst('sip_reimburse_receipts')
					->link( 'sip_reimburse_tickets_dtl.id', 'sip_reimburse_tickets_dtl_receipts.ticket_dtl_id' )
					->link( 'sip_reimburse_receipts.id', 'sip_reimburse_tickets_dtl_receipts.receipt_id' )
					->fields(
						Field::inst( 'id' )
							->upload( Upload::inst(function ($file, $id) {
								    //var_dump($file); die;
									//$file = $this->receipt;
									return $id;
								})
                                     /*
								->db2( 'sip_reimburse_receipts', 'id', function() {
									$this->_upload();
									return $this->receipt;
								})
                                */
                                ->db( 'sip_reimburse_receipts', 'id', $this->receipt )
								->where ( function ( $q ) /*use ( $ticket_id )*/ {
									//var_dump($_POST);
									$ticket_id = isset($_POST['ticket_id']) ? $_POST['ticket_id'] : null;
									if( $ticket_id ) {
										$q->where( 'id',
											"
											(
											 select a.receipt_id
											   from sip_reimburse_tickets_dtl_receipts a
											  where a.ticket_dtl_id in (
													select b.id from sip_reimburse_tickets_dtl b
													 where b.ticket_id = :ticket_id
													 )
											)
											"
											, 'IN', false );
										$q->bind(':ticket_id', $ticket_id);
									}
								})
								/*
								->dbClean( function ( $data ) {

									// Remove the files from the file system
									for ( $i=0, $ien=count($data) ; $i<$ien ; $i++ ) {
										if ( isset( $data[$i]['full_path'] ) ) {
											unlink( $data[$i]['full_path'] );
										}
									}

									// Have Editor remove the rows from the database
									return true;
								})
								*/
								->validator( function ( $file ) {
									return $this->validator_max_size($file, $this->receipt_cfg['max_size']);
								})
								->allowedExtensions( explode('|', $this->receipt_cfg['allowed_types']), "Please upload an image (gif/jpg/png/jpeg) or a pdf file" )
							)
						,
                        Field::inst( 'ticket_dtl_id' ),
						Field::inst( 'full_path' ),
						Field::inst( 'img_path' ),
						Field::inst( 'thumbnail_path' ),
						Field::inst( 'content_type' ),
						Field::inst( 'extn' ),
						Field::inst( 'filename' ),
						Field::inst( 'filesize' ),
						Field::inst( 'mimetype' ),
						Field::inst( 'system_path' ),
						Field::inst( 'web_path' )
					)
					
			)
			
			->on( 'preCreate', function ( $editor, $values ) {
				$editor
					->field( 'sip_reimburse_tickets_dtl.user_id' )
					->setValue( $this->ci->user_id );
				$editor
					->field( 'sip_reimburse_tickets_dtl.create_by' )
					->setValue( $this->ci->user_id );
				$editor
					->field( 'sip_reimburse_tickets_dtl.create_at' )
					->setValue( $this->ci->db_value_now() );
				
				
			})
			
			->on( 'preEdit', function ( $editor, $id, $values ) {
				$editor
					->field( 'sip_reimburse_tickets_dtl.update_by' )
					->setValue( $this->ci->user_id );
				$editor
					->field( 'sip_reimburse_tickets_dtl.update_at' )
					->setValue( $this->ci->db_value_now() );

				$this->create_log($editor, $id);
			})
			
		;
	}
	
	private function create_log($editor, $id) {
		
		$rec = Model\Reimburse_dtl::find($id);
		$rec->create_log();
		$rec->save();
	}
	
	private function _upload () {
		
		if (! $_FILES ) {
			return array();
		}
		
		//var_dump($_FILES); die;

		$upload_path = $this->receipt_cfg['upload_path'];
		
		$this->ci->load->library('upload');
		$this->ci->upload->initialize($this->receipt_cfg);
		
		if ( !file_exists( $upload_path) ) {
			mkdir ( $upload_path, 0777, true );
		}
		
		if ( $this->ci->upload->do_upload('upload') ) {
			// Code After Files Upload Success GOES HERE
			$upload_data    = $this->ci->upload->data();
			
			$system_path    = $upload_data['full_path'];
			
			$web_path       = $this->receipt_cfg['upload_path'].$upload_data['file_name'];
			$thumbnail_path = $this->receipt_cfg['upload_path'].$upload_data['raw_name'].'_thumb'.$upload_data['file_ext'];
			
			if ( $_FILES['upload']['type'] == 'application/pdf' ) {
				$thumbnail_path = 'assets/static/img/PDF-Icon.jpg';
			} else {
				$this->ci->resize_image($system_path);
			}

			$this->receipt = array(
				'full_path'      => $system_path,
				'img_path'       => $web_path,
				'thumbnail_path' => $thumbnail_path,
				'content_type'   => Upload::DB_CONTENT_TYPE,
				'extn'           => Upload::DB_EXTN,
				'filename'       => Upload::DB_FILE_NAME,
				'filesize'       => Upload::DB_FILE_SIZE,
				'mimetype'       => Upload::DB_MIME_TYPE,
				'system_path'    => $system_path,
				'web_path'       => $web_path,
			);
		} else {
			//var_dump($this->upload->display_errors());
			return false;
		}
		
		return $this->receipt;

	}
	
	public function get($id = null, $id2 = null) {
		$this->editor
			->where(  'ticket_id', $id, '=' );
		parent::get();
		
	}
	
}