<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Calendar extends ST_Controller {
	
	private $_colors = array();
	
	public function __construct() {
		parent::__construct();
		$this->breadcrumbs->push('Calendar', 'calendar');
		
		$this->restricted( 'user-web-services' );
		
		$users_colors = array(
			'#F06543',
//			'#E8E9EB',
			'#B8B7AF',
			'#F09D51',
			
			'#B796AC',

			'#9ED0E6',
			'#82A7A6',
			
			'#2A9D8F',
			'#E9C46A',
			'#F4A261',
			'#E76F51',
			'#1BE7FF',
			'#6EEB83',
			'#E4FF1A',
//			'#E8AA14',
			'#FF5714',
			
			
			'gold',
			'yellow',
			'moccasin',
			'khaki',
			'darkkhaki',
			'lavender',
			'violet',
			'magenta',
			'greenyellow',
			'lime',
			'limegreen',
			'aqua',
			
			// similar color
			'lightyellow',
			'lemonchiffon',
			'lightgoldenrodyellow',
			'papayawhip',
			'peachpuff',
			'palegoldenrod',
			
		);

		$this->_colors['users_colors'] = $users_colors;
		
		$mags_colors = array(
			'#313638',
			'#473834',
			'#264653',
			'#241A28',
			'blueviolet',
			'slateblue',
			'blue',
			'darkgreen',
			'darkolivegreen',
			'darkslateblue',
			'darkmagenta',
			'olive',
			'maroon',
			'saddlebrown',
			'purple',
		);
		
		$this->_colors['mags_colors'] = $mags_colors;
		
	}
	
	public function index() {
		// still nothing to do here
	}
	
	public function resources() {
        
		$resources = array();
		
		$groups = Model\Groups::where_in('name', array('editor', 'reporter', 'fotografer', 'designer', 'officeadm'))->get();
		//$groups = Model\Groups::get();
		
		foreach($groups as $group) {
			$users = $group->users('order_by:first_name[asc]');
			$user_list = array();
			foreach($users as $user) {
				$user_list[] = array(
					'id' => 'user:'.$user->id,
					'title' => $user->first_name.' '.$user->last_name,
					'eventColor' => array_shift($this->_colors['users_colors']), //'#'.dechex(rand(0xAAAAAA, 0xFFFFFF)),
				);
			}
			$resources[] = array(
				'id' => $group->name,
				'title' => $group->description,
				'children' => $user_list
			);
		}
		
		$mags = Model\Workspace::where_in('status', array('1, 10'))->get();
		foreach ($mags as $mag) {
			$mag_list[] = array(
				'id' => 'mag:'.$mag->id,
				'title' => strtoupper($mag->name).'  '.strtolower($mag->edition),
				'eventColor' => array_shift($this->_colors['mags_colors']),
			);
		}
		$resources[] = array(
			'id' => 'project',
			'title' => 'Magazine/Project',
			'children' => $mag_list
		);
		
		$this->output->enable_profiler(false);
		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode($resources));
		
	}
	
	public function events() {
        
		$st_dt = $this->input->get('start');
		$ed_dt = $this->input->get('end');
		
		$events = array();
		
		
		//$tasks = Model\Tasks::where_in('status', array('standby', 'ongoing', 'postpone', 'cancel', 'done'))
		//$tasks = Model\Tasks::order_by('create_at asc, due_date asc')
		$tasks = $this->db->select('*')->from('sip_tasks')
			->group_start()
			->where('create_at > ', $st_dt)
			->where('create_at < ', $ed_dt)
			->group_end()
			->or_group_start()
			->where('due_date > ', $st_dt)
			->where('due_date < ', $ed_dt)
			->group_end()
			->get()
			->result()
		;
		//var_dump($tasks); die;
		//var_dump($this->db->last_query()); die;
		//die;
		foreach($tasks as $task) {
			//var_dump($task); die;
			$user = Model\Users::find($task->user_id); //$task->user();
			$mag  = Model\Workspace::find($task->mag_id); //$task->workspace();
			$tab  = Model\Worksheet::find($task->tab_id); //$task->worksheet();

			$start = $task->event_date ? $task->event_date : ($task->due_date ? $task->due_date : $task->create_at);
			$end = date("Y-m-d H:i:s", strtotime("$start +2 hours"));
			
			$date_start = date_format(date_create($start), 'Y-m-d\TH:i:s');
			$date_end   = date_format(date_create($end), 'Y-m-d\TH:i:s');
			$allDay = true;
			
			
			if(stristr($task->type, 'coverage') || stristr($task->type, 'photo') || stristr($task->type, 'interview')) {
				//$date_end   = date_format(date_create($end), 'Y-m-d\T22:00:00');
				$allDay = false;
			}
			
			$time_start = date_format(date_create($start), 'H:i:s');
			$time_end   = date_format(date_create($end), 'H:i:s');

			$task_status = $task->status;
			$title = strtoupper($user->first_name).' - '.strtolower($task->type).($task->event_date ? " ($task_status [E])" : " ($task_status [D])");
			if($allDay){
				$description = "<ul>"."<li>".'Workspace: '.strtoupper($mag->name).'</li><li>Edition: '.$mag->edition.('</li><li>Worksheet: '.$tab->rubric).($task->event_name ? ' </li><li>Event: '.$task->event_name : '').($tab->notes ? ' </li<li>Notes: '.$tab->notes : '').' </li><li>Content: '.$tab->content.'</li></ul>';
			}else{
				$description = "<ul>".($task->event_date ? "<li>Time: $time_start - $time_end</li>" : '')."<li>".'Workspace: '.strtoupper($mag->name).'</li><li>Edition: '.$mag->edition.('</li><li>Worksheet: '.$tab->rubric).($task->event_name ? ' </li><li>Event: '.$task->event_name : '').($tab->notes ? ' </li<li>Notes: '.$tab->notes : '').' </li><li>Content: '.$tab->content.'</li></ul>';
			}

			$events[] = array(
				'id' => 'event-user:'.$task->id,
				'resourceId' => 'user:'.$task->user_id,
				'start' => $date_start,
				'end' => $date_end,
				'title' => $title,
				'textColor' => '#000',
				'description' => $description,
				//'url' => '/task/'.$task->id,
				'allDay' => $allDay,
				//'backgroundColor' => "#f56954", //red
				//'borderColor' => "#f56954" //red
			);

		}
		
		$mags = Model\Workspace::where_in('status', array('1, 10'))->get();
		foreach ($mags as $mag) {
			$events[] = array(
				'id' => 'event-mag:'.$mag->id,
				'resourceId' => 'mag:'.$mag->id,
				'start' => $mag->publish,
				'end' => $mag->publish,
				'title' => strtoupper($mag->name).' '.strtolower($mag->edition).' (publish)',
				'textColor' => '#fff',
				'allDay' => 'false',
			);
			
			$events[] = array(
				'id' => 'event-mag:'.$mag->id,
				'resourceId' => 'mag:'.$mag->id,
				'start' => $mag->due_date,
				'end' => $mag->due_date,
				'title' => strtoupper($mag->name).' '.strtolower($mag->edition).' (deadline)',
				'textColor' => '#fff',
				'allDay' => 'false',
			);
		}
		
		$this->output->enable_profiler(false);
		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode($events));
	}
	
}
