<?php
defined('BASEPATH') OR exit('No direct script access allowed');



class Tasks extends ST_Controller {
	
	public $workspace_model = 'de/workspace/Workspace_datatable';
	
	public function __construct() {
		parent::__construct();
		$this->data['PAGE_TITLE'] = 'Task Editor';
		$this->restricted('workspace');
		
		$this->breadcrumbs->push('Task', '/workspace/task');
		
		$this->load->model('de/workspace/Task_datatable', 'tasks');
	}
	
	public function index()
	{
		
	}
	
	public function get() {
		$this->output->enable_profiler(false);
		$this->tasks->get();
	}