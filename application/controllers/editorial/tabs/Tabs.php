<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tabs extends ST_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->data['PAGE_TITLE'] = 'Tabs';
		$this->restricted('workspace');
		
		$this->breadcrumbs->push('Workspace', '/workspace');
		$this->breadcrumbs->push('Tabs', '/tabs');
	}
	
	public function index() {
		
	}
	
	public function get($mag_id = 0)
	{
		$this->output->enable_profiler(false);
		if(!$mag_id) return;
		
		$workspace = \Model\Workspace::find($mag_id);
		$this->data['workspace'] = $workspace;
		$this->load->view('/adminlte/editorial/tabs/index', $this->data);
	}
	
}