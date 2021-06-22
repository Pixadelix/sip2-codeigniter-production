<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Settings extends ST_Controller {
	
	public function __construct() {
		parent::__construct();
	}
	
	public function get_monitored($id = null) {
		$this->restricted();
		$this->load->model('de/eproc/Monitored_datatable');
		$this->Monitored_datatable->get();
	}
	
	public function get_keyword($id = null) {
		$this->restricted();
		$this->load->model('de/eproc/Keyword_datatable');
		$this->Keyword_datatable->get();
	}
	
}