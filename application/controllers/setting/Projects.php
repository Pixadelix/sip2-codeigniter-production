<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Projects extends ST_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->restricted('projects');
		$this->breadcrumbs->push('Clients & Projects', '/setting/clients_projects');
	}
	
		
	public function index()
	{
		$this->include_datatables_assets(true);
		
		$this->enqueue_scripts('app/common.js');
		$this->enqueue_scripts('app/setting/clients_projects.js');

		$this->dashboard('adminlte/setting/clients_projects');
	}
	
	public function get($id = null) {
		parent::get();
		$this->load->model('de/setting/Projects_datatable', 'projects');
		$this->projects->get($id);
	}
}