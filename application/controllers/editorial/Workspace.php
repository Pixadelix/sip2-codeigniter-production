<?php
defined('BASEPATH') OR exit('No direct script access allowed');



class Workspace extends ST_Controller {
	
	//public $workspace_model = 'de/workspace/Workspace_datatable';
	
	public function __construct() {
		parent::__construct();
		$this->data['PAGE_TITLE'] = 'Workspace Editor';
		$this->restricted(array('workspace', 'project-status'));
		
		$this->breadcrumbs->push('Workspace', '/workspace');
		
		$this->include_datatables_assets(true);
		
		$this->enqueue_scripts('app/common.js');
		$this->enqueue_scripts('app/editorial/workspace.js');
		$this->enqueue_scripts('app/editorial/worksheet.js');
		$this->enqueue_scripts('app/editorial/task.js');

	}
	
	public function index($id = null)
	{
		$this->data['id'] = $id;
		$this->data['WORKSHEET_CONTAINER'] = $this->load->view('/adminlte/editorial/worksheet/worksheet_container', $this->data, true);
		$this->data['TASK_CONTAINER'] = $this->load->view('/adminlte/editorial/tasks/task_container', $this->data, true);
		$this->dashboard('/adminlte/editorial/workspace/index');
		
	}
	
	public function get($id = null) {
		parent::get();
		$this->load->model('de/workspace/Workspace_datatable', 'workspace');
		$this->workspace->get($id);
	}
	
	public function get_by_project($project_id) {
		parent::get();
		$this->load->model('de/workspace/Workspace_datatable', 'workspace');
		$this->workspace->get_by_project($project_id);
	}
	
	public function get_worksheet($id = null) {
		parent::get();
		$this->load->model('de/workspace/Worksheet_datatable', 'worksheet');
		$this->worksheet->get($id);
	}
	
	public function get_task($id = null, $id2 = null) {
		parent::get();
		$this->load->model('de/workspace/Task_datatable', 'task');
		$this->task->get($id, $id2);
	}

	public function get_workload_chart($id = null) {
		$id = $id ? $id : 'null';
		$this->output->enable_profiler(false);
		$sql = <<<EOT
select u.first_name as 'label', count(*) as 'value'
  from sip_tasks t, sip_users u, sip_workspace w, sip_groups g, sip_users_groups ug
 where t.user_id = u.id
   and t.mag_id = w.id
   and u.id = ug.user_id
   and g.id = ug.group_id
--   and g.name in ('editor', 'reporter', 'fotografer')
   and (t.mag_id = $id or $id is null)
   and t.status not in ('cancel', 'done')
   and (w.status = 1 or $id is not null)
 group by t.user_id
EOT;

		header("Content-Type: application/json");
	
		$dataset['cols'] = array(
			array('label' => 'PIC', 'type' => 'string'),
			array('label' => 'Value', 'type' => 'number'),
		);
		$rows = $this->db->query($sql)->result_array();
		for ( $i = 0; $i < count($rows); $i++) {
			$tmp = array();

			$tmp[] = array('v' => $rows[$i]['label']);
			$tmp[] = array('v' => (int) $rows[$i]['value']);
			
			$dataset['rows'][] = array('c' => $tmp);
		}
		//var_dump($dataset);

		echo json_encode($dataset);
	}
	
	public function get_column_chart($id = null) {
		$id = $id ? $id : 'null';
		$this->output->enable_profiler(false);
		$sql = <<<EOT
select first_name,
       max(case when status = 'standby' then cnt else 0 end) as 'standby',
       max(case when status = 'cancel' then cnt else 0 end) as 'cancel',
	   max(case when status = 'ongoing' then cnt else 0 end) as 'ongoing',
       max(case when status = 'done' then cnt else 0 end) as 'done',
	   max(case when status = 'postpone' then cnt else 0 end) as 'postpone',
	   sum(cnt) as total
  from (
select u.first_name, count(*) as cnt, t.status
  from sip_tasks t, sip_users u, sip_workspace w, sip_groups g, sip_users_groups ug
 where t.user_id = u.id
   and t.mag_id = w.id
   and u.id = ug.user_id
   and g.id = ug.group_id
--   and g.name in ('editor', 'reporter', 'fotografer')
   and (t.mag_id = $id or $id is null)
   and (w.status = 1 /* ACTIVE WORKSPACE */ or $id is not null)
 group by t.user_id, t.status
) a
group by first_name
EOT;
		header("Content-Type: application/json");
		
		$dataset = array();
		
		$dataset['cols'] = array(
			array('label' => 'PIC', 'type' => 'string'),
			array('label' => 'Standby', 'type' => 'number'),
			array('label' => 'Cancel', 'type' => 'number'),
			array('label' => 'Ongoing', 'type' => 'number'),
			array('label' => 'Done', 'type' => 'number'),
			array('label' => 'Postpone', 'type' => 'number'),
			array('label' => 'Total', 'type' => 'number'),
		);
		
		$rows = $this->db->query($sql)->result_array();
		for ( $i = 0; $i < count($rows); $i++) {
			$tmp = array();

			$tmp[] = array('v' => $rows[$i]['first_name']);
			$tmp[] = array('v' => (int) $rows[$i]['standby']);
			$tmp[] = array('v' => (int) $rows[$i]['cancel']);
			$tmp[] = array('v' => (int) $rows[$i]['ongoing']);
			$tmp[] = array('v' => (int) $rows[$i]['done']);
			$tmp[] = array('v' => (int) $rows[$i]['postpone']);
			$tmp[] = array('v' => (int) $rows[$i]['total']);
			
			$dataset['rows'][] = array('c' => $tmp);
		}
		echo json_encode($dataset);
	}
}