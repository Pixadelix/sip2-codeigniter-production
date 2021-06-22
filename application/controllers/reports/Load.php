<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Load extends ST_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->data['PAGE_TITLE'] = 'Load Report';
		$this->restricted('reports');
		
		$this->include_datatables_assets(true);
		
		$this->breadcrumbs->push('Report', '/reports');
		$this->breadcrumbs->push('Load Report', '/reports/load');
		
	}
	
	public function index() {
		
		$this->enqueue_style(
			'../plugins/daterangepicker/daterangepicker.css'
		);
		
		$this->enqueue_scripts(array(
			'../plugins/daterangepicker/daterangepicker.js',
			'app/reports/load.js'
		));
		$this->dashboard('/adminlte/reports/load/index');
	}
	
	public function get_chart($id = null) {
		$this->output->enable_profiler(false);
		
		header("Content-Type: application/json");
		
		$start_date = $this->input->post('start_date');
		$end_date   = $this->input->post('end_date');
		
		//var_dump($_POST); die;
		
		$sql = <<<EOL
select date_format(case when t.event_date is null then t.due_date when t.due_date is null then t.create_at else t.create_at end, '%Y/%m') as `report_date`
  from sip_tasks t, sip_users u
 where t.user_id = u.id
   and year(case when t.event_date is null then t.due_date when t.due_date is null then t.create_at else t.create_at end) = year(curdate())
 group by report_date
 order by report_date
EOL;
		
		if ( $start_date && $end_date ) {
		
			$sql = <<<EOL
select date_format(case when t.event_date is null then t.due_date when t.due_date is null then t.create_at else t.create_at end, '%Y/%m') as `report_date`
  from sip_tasks t, sip_users u
 where t.user_id = u.id
   and t.create_at between '$start_date' and '$end_date'
 group by report_date
 order by report_date
EOL;
		}
		
//var_dump($sql); die;
		
		$dataset = array();
		$dataset['cols'] = array(
			array('label' => 'Month', 'type' => 'string'),
			
			/*
			array('label' => 'Jan', 'type' => 'number'),
			array('label' => 'Feb', 'type' => 'number'),
			array('label' => 'Mar', 'type' => 'number'),
			array('label' => 'Apr', 'type' => 'number'),
			array('label' => 'Mei', 'type' => 'number'),
			array('label' => 'Jun', 'type' => 'number'),
			array('label' => 'Jul', 'type' => 'number'),
			array('label' => 'Aug', 'type' => 'number'),
			array('label' => 'Sep', 'type' => 'number'),
			array('label' => 'Okt', 'type' => 'number'),
			array('label' => 'Nov', 'type' => 'number'),
			array('label' => 'Des', 'type' => 'number'),
			
			array('label' => 'Total', 'type' => 'number'),
			*/
		);
		
		$rows = $this->db->query($sql)->result_array();
		for ( $i = 0; $i < count($rows); $i++) {
			
			$report_date = $rows[$i]['report_date'];
			
			$tmp = array();

			$tmp[] = array('v' => $report_date);
			
			$sql = <<<EOL
select u.first_name,
       max(t2.cnt) as `cnt`
  from (
select t.user_id,
       count(t.id) as `cnt`
  from sip_tasks t
 where date_format(case when t.event_date is null then t.due_date when t.due_date is null then t.create_at else t.create_at end, '%Y/%m') = '$report_date'
 group by t.user_id
 order by t.user_id
) t2 left outer join sip_users u on t2.user_id = u.id
 where u.id > 2
 group by u.first_name
 order by u.first_name
EOL;

			$counts = $this->db->query($sql)->result_array();
			
			for ( $j = 0; $j < count($counts); $j++ ) {

				$first_name = $counts[$j]['first_name'];
				
				if ( false == array_search( array('label' => $first_name, 'type' => 'number'), $dataset['cols']) ) {
					$dataset['cols'][] = array('label' => $first_name, 'type' => 'number');
				}
				
				
				$tmp[] = array('v' => (int) $counts[$j]['cnt']);
				
				/*
				$tmp[] = array('v' => (int) $counts[$j]['jan']);
				$tmp[] = array('v' => (int) $counts[$j]['feb']);
				$tmp[] = array('v' => (int) $counts[$j]['mar']);
				$tmp[] = array('v' => (int) $counts[$j]['apr']);
				$tmp[] = array('v' => (int) $counts[$j]['mei']);
				$tmp[] = array('v' => (int) $counts[$j]['jun']);
				$tmp[] = array('v' => (int) $counts[$j]['jul']);
				$tmp[] = array('v' => (int) $counts[$j]['aug']);
				$tmp[] = array('v' => (int) $counts[$j]['sep']);
				$tmp[] = array('v' => (int) $counts[$j]['okt']);
				$tmp[] = array('v' => (int) $counts[$j]['nov']);
				$tmp[] = array('v' => (int) $counts[$j]['des']);
				*/
			
			}

			//$tmp[] = array('v' => (int) $rows[$i]['total']);
			
			$dataset['rows'][] = array('c' => $tmp);
		}
		
		//var_dump($dataset); die;
		echo json_encode($dataset);

		
	}
	
}