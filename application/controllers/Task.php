<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Task extends ST_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->restricted('my-tasks');
		
		$this->breadcrumbs->push('Task', '/task');
		
		$this->enqueue_scripts(array(
			
		));
//		$this->enqueue_scripts('app/my/task.js');
	}
	
	public function index($id = null)
	{
		$this->data['PAGE_TITLE'] = 'Task';
		if ( $id ) {
			$this->breadcrumbs->push("# $id", "/task/$id");

			$task = Model\Tasks::find($id);
		
			if ( !$task ) {
				show_404();
				exit;
			}
			$this->data['task'] = $task;
			$this->dashboard('adminlte/task/task');
		}

	}
}