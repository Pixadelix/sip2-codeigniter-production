<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//include_once APPPATH . DATATABLE_EDITOR;

use
	DataTables\Editor,
	DataTables\Editor\Field,
	DataTables\Editor\Format,
	DataTables\Editor\Mjoin,
	DataTables\Editor\Options,
	DataTables\Editor\Upload,
	DataTables\Editor\Validate;

class CI_Editor_Model extends CI_Model {
	
	public $editor = null;
    public $ci = null;
    public $table = null;
	public $db_datatables = null;
    
    protected function default_create_log() {
        $this->editor
            ->field("$this->table.create_by")
            ->setValue( $this->ci->user_id );

        $this->editor
            ->field( "$this->table.create_at" )
            ->setValue( $this->ci->db_value_now() );
    }
    
    protected function default_edit_log() {
        $this->editor
            ->field("$this->table.update_by")
            ->setValue( $this->ci->user_id );

        $this->editor
            ->field( "$this->table.update_at" )
            ->setValue( $this->ci->db_value_now() );
    }

	public function __construct() {
		parent::__construct();

		global $db_datatables;
		
		$db_datatables->debug(false);
		
		$this->db_datatables = $db_datatables;
		$this->ci =& get_instance();
		
	}
	
	public function production() {
		if ( 'production' == ENVIRONMENT && defined('INSTALL') ) { 
			return false;
		}
		
		return 'production' == ENVIRONMENT;
	}

	public function get($id = null, $id2 = null) {
		$this->output->enable_profiler(false);
		$this->editor
			//->Debug( ENVIRONMENT == 'production' ? false : true )
			->process( $_POST )
			->json();
	}
    
	public function validator_max_size($file, $max_size = 4000) {
		$size = array('B','kB','MB','GB','TB','PB','EB','ZB','YB');
		$factor = floor((strlen($max_size) - 1) / 3);
		$bytes = ($max_size/2) * 1024;
		$bytes = sprintf("%.0f", $bytes / pow(1024, $factor)) . @$size[$factor];
		return $file['size'] >= ($max_size/2)*1024 ? "Files must be smaller than $bytes" : null;
	}
    
    public function version() {
        return $this->editor->version;
    }

}