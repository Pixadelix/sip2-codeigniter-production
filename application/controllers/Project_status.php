<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Project_status extends ST_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->data['PAGE_TITLE'] = 'Project Status';
		$this->restricted('project-status');
		$this->breadcrumbs->push('Project Status', '/project-status');
		
		$this->include_datatables_assets(true);
		
		$this->enqueue_scripts('app/common.js');
		$this->enqueue_scripts('app/project-status/project-workspace.js');
		$this->enqueue_scripts('app/project-status/project-worksheet.js');
		$this->enqueue_scripts('app/project-status/project-task.js');
	}
	
		
	public function index($id = null)
	{
		$this->data['id'] = $id;
		$this->data['WORKSHEET_CONTAINER'] = $this->load->view('/adminlte/project-status/worksheet/worksheet_container', $this->data, true);
		$this->data['TASK_CONTAINER'] = $this->load->view('/adminlte/project-status/tasks/task_container', $this->data, true);
		$this->dashboard('/adminlte/project-status/workspace/index');
	}
	
	public function get($id = null) {
		parent::get();
		$this->load->model('de/setting/Projects_datatable', 'projects');
		$this->projects->get($id);
	}
	
	public function get_by_users_projects() {
		parent::get();
		$this->load->model('de/setting/Projects_datatable', 'projects');
		$this->projects->get_user_projects($this->user_id);
	}
}