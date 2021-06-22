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
class Digimag_datatable extends Posts_datatable {

    protected $post_cfg = null;
	
	public function __construct() {
		parent::__construct();
        $this->post_cfg = $this->ci->config->item('flipmag');
        $this->_process_upload();
        $this->init_editor();
	}
    
    protected function init_editor() {
		parent::init_editor();
		
		$this->editor
            ->field( "$this->table.post_parent" )
                ->setFormatter( 'Format::ifEmpty', 0 )
                ->upload(
                    Upload::inst( function ( $file, $id ) {
                        return $id;
                    } )
                    ->db( 'sip_posts', 'id', $this->_attachment )
                    ->where( function($q) { $q->where('post_type', Posts_datatable::TYPE_FLIPMAG_ATTACHMENT, '='); } )
                    //->validator( function ( $file ) {
					//	return $this->validator_max_size($file, $this->post_cfg['max_size']);
                    //} )
                    ->allowedExtensions( explode('|', $this->post_cfg['allowed_types']), 'Please upload a document file. '.$this->post_cfg['allowed_types'] )
                );
        
        $this->editor
            ->on( 'preCreate', function ( $editor, $values ) {
                $this->editor
                    ->field("$this->table.post_title")
                    ->setValue($this->_attachment['media_filename']);

                $this->editor
                    ->field("$this->table.post_status")
                    ->setValue(Posts_datatable::PUBLISHED);
                
                $this->editor
                    ->field("$this->table.post_type")
                    ->setValue(Posts_datatable::TYPE_FLIPMAG);
                
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
            } else if ( $_FILES['upload']['type'] == 'application/zip' ) {
                $thumbnail_path = ST_Controller::ICON_ZIP;
            } else if ( $_FILES['upload']['type'] == 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' ) {
                $thumbnail_path = ST_Controller::ICON_XLS;
			} else if ( $upload_data['is_image'] ) {
				$this->ci->resize_image($system_path);
			}

            $this->ci->unzip($system_path, $upload_path.$upload_data['raw_name']);
            $index_html = glob($upload_path.$upload_data["raw_name"].'/*.html');
            
            if ( !$index_html ) {
                return;
            }
            
            $cover_file = glob($upload_path.$upload_data["raw_name"].'/files/page/*.jpg');
            
            if ( !$cover_file ) {
                $cover_file = glob($upload_path.$upload_data["raw_name"].'/*.png');
            }
            
            if ( ! $cover_file ) {
                $cover_file = array('');
            }
			
			$this->_attachment = [
				'post_type'            => Posts_datatable::TYPE_FLIPMAG_ATTACHMENT,
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
                'post_content'         => $index_html[0],
                'post_excerpt'         => $cover_file[0],
			];
		} else {
            var_dump($this->ci->upload->data());
            echo $this->ci->upload->display_errors(); die;
            
        }
	}
	
	public function get($id = null, $id2 = null) {
        $this->output->enable_profiler(false);
		$this->editor
			->where('sip_posts.post_type', Posts_datatable::TYPE_FLIPMAG, '=');
		parent::get($id, $id2);
		
	}
	
}