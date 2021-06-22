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

//load_class('Editor_Model', 'core');
include_once(APPPATH.'models/de/content/Posts_datatable.php');
class VoucherFiles_datatable extends Posts_datatable {

    protected $post_cfg = null;
	
	public function __construct() {
		parent::__construct();
        $this->_process_upload();
        $this->init_editor();
	}
    
    protected function init_editor() {
		parent::init_editor();
		$this->post_cfg = $this->ci->config->item('voucher');
		$this->editor
            ->field( "$this->table.post_parent" )
                ->setFormatter( 'Format::ifEmpty', 0 )
                ->upload(
                    Upload::inst( function ( $file, $id ) {
                        return $id;
                    } )
                    ->db( 'sip_posts', 'id', $this->_attachment )
                    ->where( function($q) { $q->where('post_type', Posts_datatable::TYPE_VOUCHER_ATTACHMENT, '='); } )
                    ->validator( function ( $file ) {
						return $this->validator_max_size($file, $this->post_cfg['max_size']);
                    } )
                    ->allowedExtensions( explode('|', $this->post_cfg['allowed_types']), 'Please upload a document file. '.$this->post_cfg['allowed_types'] )
                );
        
        $this->editor
            ->on( 'preCreate', function ( $editor, $values ) {
                $this->editor
                    ->field("$this->table.post_title")
                    ->setValue($this->_attachment['media_filename']);

                $this->editor
                    ->field("$this->table.post_status")
                    ->setValue(Posts_datatable::WAIT);
                
                $this->editor
                    ->field("$this->table.post_type")
                    ->setValue(Posts_datatable::TYPE_VOUCHER);
                
                $this->editor
                    ->field("$this->table.post_author")
                    ->setValue($this->ci->user_id);
                
                $this->editor
                    ->field("$this->table.post_date")
                    ->setValue($this->ci->db_value_now());
            } )
        
            ->on( 'preEdit', function ( $editor, $id, $values ) {
                
            } )
            ;
	}
	
	private function _process_upload() {
        //var_dump($_FILES); die;
		if ( ! $_FILES ) {
			return;
		}
        
		$this->ci->load->library('upload');
		$this->post_cfg = $this->ci->config->item('voucher');
		$this->ci->upload->initialize($this->post_cfg);
		$upload_path = $this->post_cfg['upload_path'];
		
		if ( !file_exists( $upload_path ) ) {
			mkdir ( $upload_path, 0755, true );
		}
        
		if ( $this->ci->upload->do_upload('upload') ) {
			$upload_data       = $this->ci->upload->data();
			$system_path       = $upload_data['full_path'];
			$web_path          = $upload_path.$upload_data['file_name'];
			$thumbnail_path    = $upload_path.$upload_data['raw_name'].'_thumb'.$upload_data['file_ext'];
            
            //application/vnd.openxmlformats-officedocument.spreadsheetml.sheet
			if ( $_FILES['upload']['type'] == 'application/pdf' ) {
                
				$thumbnail_path = ST_Controller::ICON_PDF;
                
            } else if ( $_FILES['upload']['type'] == 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' ) {
                
                $thumbnail_path = ST_Controller::ICON_XLS;
                
			} else if ( $upload_data['is_image'] ) {
                
				$this->ci->resize_image($system_path);
                
			}
			
			$this->_attachment = [
				'post_type'            => Posts_datatable::TYPE_VOUCHER_ATTACHMENT,
				'post_mime_type'       => $upload_data['file_type'],
				'media_filename'       => $upload_data['file_name'],
				'media_filesize'       => $upload_data['file_size'],
				'media_system_path'    => $system_path,
				'media_web_path'       => $web_path,
				'media_thumbnail_path' => $thumbnail_path,
				'media_file_extn'      => $upload_data['file_ext'],
				'media_content_type'   => $upload_data['file_type'],
				'comment_status'       => 'closed',
                'post_status'          => Posts_datatable::ATTACHMENT,
                'post_title'           => $upload_data['file_name'],
                'post_name'            => $upload_data['file_name'],
                'post_author'          => $this->ci->user_id,
                'post_date'            => $this->ci->db_value_now(),
			];
		} else {
            var_dump($this->ci->upload->data());
            echo $this->ci->upload->display_errors(); die;
            
        }
	}
	
	public function get($id = null, $id2 = null) {
        $this->output->enable_profiler(false);
		$this->editor
			->where('sip_posts.post_type', Posts_datatable::TYPE_VOUCHER, '=');
		parent::get($id, $id2);
		
	}
	
}