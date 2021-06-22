<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Task_types extends ST_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->restricted( 'task-types' );
		$this->data['PAGE_TITLE'] = 'Task types';
		$this->breadcrumbs->push('Task types', '/setting/task_types');
	}
	
		
	public function index()
	{
		$this->include_datatables_assets(true);
		
		$this->enqueue_resource(
			array(
				'/resource/script/adminlte/setting/task_types/js/task-types.js'
			)
		);

		$this->dashboard('adminlte/setting/task_types/index');
	}
	
	public function get($id = null) {
		parent::get();
		$this->load->model('de/setting/Task_types_datatable', 'task_types');
		$this->task_types->get($id);
	}
}   