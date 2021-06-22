<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends ST_Controller {
	
	// Task Timeline Query
	private $sql_task_timeline = <<<EOT
select date_format(ref_date, '%d %M %Y') as `timeline_date`,
       date_format(ref_date, '%H %i') as `timeline_time`,
       dayname(ref_date) as `timeline_day`,
       a.*
from (
select coalesce(coalesce(t.event_date, t.due_date), t.create_at) as `ref_date`,
       t.id as `task_id`,
       ws.name as `workspace_name`,
       ws.edition,
       ws2.rubric,
       ws2.content,
       t.status as `task_status`,
       t.*,
       concat('/my/my_task/', t.id) as `url`,
       u.first_name, u.last_name,
       (select tt.icon from sip_task_types tt where tt.label = t.type) as `icon`,
       (select media_web_path from sip_posts p where p.id = u.profile_photo) as `media_web_path`
  from sip_tasks t, sip_workspace ws, sip_worksheet ws2,
       sip_users u
 where t.mag_id = ws.id
   and t.tab_id = ws2.id
   and t.user_id = u.id
--  order by `ref_date` desc
) a
  order by a.ref_date desc
  limit 20
EOT;
	
	public function __construct() {
		parent::__construct();
		$this->restricted();
	}
	public function index()
	{		
		$this->enqueue_style(array(
			'../../js/fullcalendar-scheduler-1.6.2/lib/fullcalendar.min.css',
			'../../js/fullcalendar-scheduler-1.6.2/scheduler.min.css',
			'../../css/jquery.qtip.min.css',

		));
		$this->enqueue_scripts(array(
			'../../js/fullcalendar-scheduler-1.6.2/lib/moment.min.js',
			'../../js/fullcalendar-scheduler-1.6.2/lib/fullcalendar.min.js',
			'../../js/fullcalendar-scheduler-1.6.2/lib/gcal.min.js',
			'../../js/fullcalendar-scheduler-1.6.2/scheduler.min.js',
			'../../js/fullcalendar-scheduler-1.6.2/locale/id.js',
			'../../js/jquery.qtip.min.js',
			//'app/dashboard/calendar.js',
			//'app/dashboard/timeline.js'
		));
        
        $this->enqueue_resource(array(
            '/resource/script/adminlte/dashboard/js/calendar.js',
			'/resource/script/adminlte/dashboard/js/timeline.js'
        ));
		
        
        if ( !$this->restricted( 'user-web-services', false ) ) {
		  $this->data['TASK_SUMMARY']       = $this->load->view('/adminlte/dashboard/task_summary', $this->data, true);
		  $this->data['TIMELINE_CONTAINER'] = $this->load->view('/adminlte/dashboard/timeline_container', $this->data, true);
		  $this->data['POST_CONTENTS']      = $this->load->view('/adminlte/dashboard/post_contents', $this->data, true);
        }
		
		$this->dashboard('adminlte/home');
	}
	
	public function dev() {
		$this->data['PAGE_TITLE'] = 'This page is still under development';
		$this->dashboard('/adminlte/development');
	}

	
	public function get_timeline($id = null) {
		global $TASK_TYPE_ICONS;
		$this->restricted('user-web-services', false);
		$this->get();
		
		$this->db->query("SET lc_time_names = 'id_ID'");
		$rows = $this->db->query($this->sql_task_timeline)->result_array();
		
		$timeline = array();
		$items = array();
		
		$timeline_date = null;
        $timeline_day  = null;
		
		for ( $i = 0; $i < count($rows); $i++ ) {
			$r = $rows[$i];
			if ( $timeline_date != $r['timeline_date'] ) {
				
				if( count($items) > 0 ) {
					array_push( $timeline, array( 'date' => $timeline_date, 'day' => $timeline_day, 'items' => $items ) );
					unset($items);
					$items = array();
				}
				$timeline_date = $r['timeline_date'];
                $timeline_day  = $r['timeline_day'];
            }
			//$r['task_icon'] = $TASK_TYPE_ICONS[$r['type']];
            $r['task_icon'] = $r['icon'];
			switch ( $r['status'] ) {
				case TASK_STATUS_STANDBY:
					$bg_task = 'bg-white';
					break;
				case TASK_STATUS_ONGOING:
					$bg_task = 'bg-orange';
					break;
				case TASK_STATUS_CANCEL:
					$bg_task = 'bg-red';
					break;
				case TASK_STATUS_POSTPONE:
					$bg_task = 'bg-blue';
					break;
				case TASK_STATUS_DONE:
					$bg_task = 'bg-green';
					break;
			}
            $r['bg_task'] = $bg_task;
            
			array_push( $items, $r );
            			
			
		}
        
        // push if only 1 item
        if ( $items ) {
            array_push( $timeline, array( 'date' => $timeline_date, 'day' => $timeline_day, 'items' => $items ) );
        }

		//echo json_encode( $timeline );
		echo json_encode(array('timeline' => $timeline));
	}

	public function goaccess() {
		$this->output->enable_profiler = false;

		$host = $this->input->get('host');
		$host = $host ? $host : "//sip2.mediavista.id/dashboard/dashboard/goaccess";

		$g = $this->config->load('goaccess', true);
		#var_dump($g); die;
		$cmd = $this->config->item($host, 'goaccess');

		#var_dump($host);
		#var_dump($cmd);


		#$output = shell_exec('goaccess -f /var/www/vhosts/logs/sip2.mediavista.id/vhost_access_log');
		$output = shell_exec($cmd);
		echo "$output";
	}

	public function webstat() {
		$host = $this->input->get('host');
		$host = $host ? $host : "//sip2.mediavista.id/dashboard/dashboard/goaccess";

		$this->data['host'] = $host;
		$this->dashboard('/adminlte/dashboard/webstat');
	}
	
}
