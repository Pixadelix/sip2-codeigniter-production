<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tax extends ST_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->restricted();
		$this->breadcrumbs->push('Tax', '/setting/tax');
	}
	
		
	public function index()
	{
		$this->include_datatables_assets(true);
		$this->dashboard('adminlte/setting/tax');
	}
	
	public function get($id = null) {
		parent::get();
		$this->load->model('de/setting/Tax_datatable');
		$this->Tax_datatable->get($id);
	}
}