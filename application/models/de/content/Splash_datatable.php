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
include_once('Posts_datatable.php');
class Splash_datatable extends Posts_datatable {

    protected $splash_cfg = null;
	
	public function __construct() {
		parent::__construct();
        $this->_process_upload();
        $this->init_editor();
	}
    
    protected function init_editor() {
        parent::init_editor();
        $this->splash_cfg = $this->ci->config->item('splash');
        $this->editor
            ->field( "$this->table.post_parent" )
				//->validator( 'Validate::required' )
                ->setFormatter( 'Format::ifEmpty', null )
                ->upload(
                    Upload::inst( function ( $file, $id ) {
                        return $id;
                    } )
                    ->db( 'sip_posts', 'id', $this->_attachment )
                    ->where( function($q) { $q->where('post_type', Posts_datatable::TYPE_SPLASH_ATTACHMENT, '='); } )
                    ->validator( function ( $file ) {
						return $this->validator_max_size($file, $this->splash_cfg['max_size']);
                    } )
                    ->allowedExtensions( explode('|', $this->splash_cfg['allowed_types']), "Please upload a compressed zip files")
                );
        
        $this->editor
            ->on( 'preCreate', function ( $editor, $values ) {
                $this->editor
                    ->field("$this->table.post_type")
                    ->setValue(Posts_datatable::TYPE_SPLASH);
            } )
            
            ->on( 'preEdit', function ( $editor, $values ) {
                
            } )
            ;
    }
	
	private function _process_upload() {
		if ( ! $_FILES ) {
			return;
		}

		$this->ci->load->library('upload');
        $this->splash_cfg = $this->ci->config->item('splash');
		$this->ci->upload->initialize($this->splash_cfg);		
		$upload_path = $this->splash_cfg['upload_path'];
		
		if ( !file_exists( $upload_path ) ) {
			mkdir ( $upload_path, 0755, true );
		}
        
        if ( $this->ci->upload->do_upload('upload') ) {
			$upload_data    = $this->ci->upload->data();
			$system_path    = $upload_data['full_path'];
			$web_path       = $upload_path.$upload_data['file_name'];
			//$thumbnail_path = $upload_path.$upload_data['raw_name'].'_thumb'.$upload_data['file_ext'];
            
            //$this->ci->resize_image($system_path);
			
			$this->ci->unzip($system_path, $upload_path.$upload_data['raw_name']);
			
			$index_html = glob($upload_path.$upload_data["raw_name"].'/*.html');
			
			if ( !$index_html ) {
				return;
			}
			
			$this->_attachment = [
				'post_type'            => Posts_datatable::TYPE_SPLASH_ATTACHMENT,
				'post_mime_type'       => $upload_data['file_type'],
				'media_filename'       => $upload_data['file_name'],
				'media_filesize'       => $upload_data['file_size'],
				'media_system_path'    => $system_path,
				'media_web_path'       => $web_path,
				'media_thumbnail_path' => $index_html[0],
				'media_file_extn'      => $upload_data['file_ext'],
				'media_content_type'   => $upload_data['file_type'],
				'comment_status'       => 'closed',
			];

		}
	}
	
	public function get($id = null, $id2 = null) {
        $this->output->enable_profiler(false);
		$this->editor
			->where('sip_posts.post_type', 'splash', '=');
		parent::get($id, $id2);
		
	}
	
}