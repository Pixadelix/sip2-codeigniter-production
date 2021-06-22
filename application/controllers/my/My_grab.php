<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class My_grab extends ST_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->restricted('my-grab-voucher');
		
		$this->breadcrumbs->push('Grab for Business', '/my/my_grab');
        $this->include_datatables_assets(true);
		$this->enqueue_resource(array(
            '/resource/script/adminlte/my/grab/js/grab.php',
        ));
        $this->data['PAGE_TITLE'] = 'Grab for Business';
	}
    
    public function index() {
        $this->dashboard('adminlte/my/grab/index');
    }
    
    public function get( $id = null, $id2 = null ) {
        parent::get($id, $id2);
        //$this->load->library('Datatable_editor');
        $this->load->model('de/officeadm/Voucher_datatable', 'voucher');
        $this->voucher
            ->editor
            ->where( 'used_by', $this->user_id, '=' );
            
        $this->voucher->get();
    
    }
}
