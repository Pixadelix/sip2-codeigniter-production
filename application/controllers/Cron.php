<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cron extends ST_Controller {

	public function __construct() {
		parent::__construct();
		
		$this->data['PAGE_TITLE'] = 'Cron';
		$this->breadcrumbs->push('Cron Manager', '/cron');
	}
    
    public function register_resource() {
        $this->must_cli_mode();
        
        Model\Acl_resource::create_resource(
            'settings',
            'cron',
            'Cron',
            '/cron',
            'fa-microchip'
        );
    }
	
	public function index() {
		$this->restricted( 'admin' );
		$this->include_datatables_assets(true);
		$this->enqueue_resource(array(
			'/resource/script/adminlte/setting/cron/js/cron.js',
		));
		$this->dashboard('adminlte/setting/cron/index');
	}

	public function run() {
		$this->must_cli_mode();
		$this->load->library('CronRunner');
		$cron = new CronRunner();
		$cron->run();
	}
	
	public function get($id = null, $id2 = null) {
        $this->restricted( 'admin' );
		$this->load->model('de/setting/Cron_datatable');
		return $this->Cron_datatable->get($id, $id2);
	}
}