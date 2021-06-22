<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tasks extends ST_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->data['PAGE_TITLE'] = 'Tasks';
		$this->restricted('workspace');
		
		$this->breadcrumbs->push('Workspace', '/workspace');
		$this->breadcrumbs->push('Tasks', '/tasks');
	}
	
	public function index() {

	}
	
	public function get_all($mag_id = 0) {
		$this->output->enable_profiler(false);
		if(!$mag_id) return;
		
		$workspace = \Model\Workspace::find($mag_id);
		$this->data['workspace']   = $workspace;
		$this->load->view('/adminlte/editorial/tasks/index', $this->data);
	}
	
	public function get($tab_id = 0)
	{
		$this->output->enable_profiler(false);
		if(!$tab_id) return;
		
		$tabs = \Model\Tabs::find($tab_id);
		//var_dump($tabs); die;
		$workspace = $tabs->workspace();
		
		$this->data['workspace'] = $workspace;
		$this->data['tabs']      = $tabs;
		$this->load->view('/adminlte/editorial/tasks/index', $this->data);
	}
	
}