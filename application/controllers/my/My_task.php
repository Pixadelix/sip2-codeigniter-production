<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class My_task extends ST_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->restricted('my-tasks');
		
		$this->breadcrumbs->push('My task', '/my/task');
		
		$this->enqueue_style('../../css/jquery-confirm.css');
		
		$this->enqueue_scripts(array(
			'../../js/jquery-confirm.js',
			'//maps.google.com/maps/api/js?sensor=false&libraries=places&language=id&key=AIzaSyAX3T1fe2Po7r02nVlCxer-K4qZ0Trdp4c',
			'../../js/locationpicker.jquery.js',
		));
		$this->enqueue_scripts('app/my/my-task.js');
	}
	
	public function index($id = null)
	{
		$this->data['PAGE_TITLE'] = 'My task';
		if ( $id ) {
			$this->breadcrumbs->push("# $id", "/my/my_task/$id");

			$task = Model\Tasks::find($id);
		
			if ( !$task ) {
				show_404();
				exit;
			}
			$this->data['task'] = $task;
			$this->dashboard('adminlte/my/task/task');
		} else {
			$tasks = Model\Tasks::where_in('status', array('standby', 'ongoing', 'postpone'))
				->where('user_id', $this->user_id)
				->get();
			
			$this->data['tasks'] = $tasks;
			$this->dashboard('adminlte/my/task/task_list');
		}

	}
	
	public function confirm($id, $msg) {
		
		$this->output->enable_profiler(false);
		
		$task = Model\Tasks::find($id);
		
		if ( !$task ) {
			show_404();
			return;
		}
		
		echo $msg;
	}
	
	public function confirm_done($id) {
		$this->data['task_id'] = $id;
		$content = $this->load->view('adminlte/my/task/confirm_done', $this->data, true);
		$this->confirm($id, $content);
	}

	public function set_done() {
		$id = $this->input->post('task_id');
		$notes = $this->input->post('notes');

		if ( !isset($_POST) || !$_POST || !$id ) {
			show_error('Invalid request', 422);
			exit;
		}
		
		$task = Model\Tasks::find($id);

		if(!$task){
			$this->json_error('Task not found', 404);
		}
		
		$task->create_log();
		
		$task->complete_at = $this->db_value_now(); //(new DateTime())->format('Y-m-d H:i:s');
		$task->notes = trim($notes) ? $notes : '';
		$task->status = TASK_STATUS_DONE;
		$task->update_by = $this->user_id;

		if(!$task->save(true)){
			$this->json_error($task->errors);
		}
	}
	
	public function confirm_cancel($id) {
		
		$this->data['task_id'] = $id;
		$content = $this->load->view('adminlte/my/task/confirm_cancel', $this->data, true);
		$this->confirm($id, $content);
	}
	
	public function set_cancel() {

		$id = $this->input->post('task_id');
		$notes = $this->input->post('reason');
		
		if ( !isset($_POST) || !$_POST || !$id || !$notes ) {
			show_error('Invalid request', 422);
			exit;
		}
		
		$task = Model\Tasks::find($id);

		if(!$task){
			$this->json_error('Task not found', 404);
		}
		
		if(!trim($notes)){
			$this->json_error('Reason/Notes is required', 422);
		}

		$task->create_log();
		
		$task->notes = $notes;
		$task->status = TASK_STATUS_CANCEL;
		$task->update_by = $this->user_id;

		if(!$task->save(true)){
			$this->json_error($task->errors);
		}
	}
	
	public function confirm_postpone($id) {
		$task = Model\Tasks::find($id);
	
		if(!$task){
			show_404();
			exit;
		}
		
		$this->data['task_id'] = $id;
		$this->data['task'] = $task;
		$content = $this->load->view('adminlte/my/task/confirm_postpone', $this->data, true);
		$this->confirm($id, $content);
	}
	
	public function set_postpone() {
		$id = $this->input->post('task_id');
		$notes = $this->input->post('reason');
		
		$event_date  = $this->input->post('event_date');
		$event_name  = $this->input->post('event_name');
		$event_place = $this->input->post('event_place');
		
		if ( !isset($_POST) || !$_POST || !$id || !$notes ) {
			show_error('Invalid request', 422);
			exit;
		}
		
		$task = Model\Tasks::find($id);

		if(!$task){
			$this->json_error('Task not found', 404);
		}
		
		if(!trim($notes)){
			$this->json_error('Reason/Notes is required', 422);
		}
		
		$task->create_log();
		
		$task->event_date = DateTime::createFromFormat('d/m/Y H.i', $event_date)->format('Y-m-d H:i');
		$task->notes = $notes;
		$task->event_name = $event_name;
		$task->event_place = $event_place;

		$task->status = TASK_STATUS_POSTPONE;
		
		$task->update_by = $this->user_id;

		if(!$task->save(true)){
			$this->json_error($task->errors);
		}
	}
    
    public function request_grab($task_id) {
        
        // Access level check
        $this->restricted('request-grab-code');
        
        $task_id = $task_id ? $task_id : $this->input->post('task_id');
        $task = Model\Tasks::find($task_id);
        
        // Validation check
        if ( !$task ) show_404();
        if ( $task->user_id != $this->user_id ||
             $task->status != TASK_STATUS_STANDBY ||
             !$task->fgrab
        ) {
            show_error('Invalid request.', 403, 'Invalid request.');
        }
        
        // Quota check
        $vouchers_used = Model\Voucher_task::where(
            array(
                'task_id' => $task_id,
                'user_id' => $this->user_id,
            ))
            ->get();
            ;
        if ( count($vouchers_used) >= $task->fgrab ) {
            redirect('/my/my_task/'.$task->id, 'refresh');
            //show_error('Limit quota reached.', 403, 'Invalid request.');
        }

        $this->load->model('de/officeadm/Voucher_datatable');
        $this->load->model('de/officeadm/VoucherType_datatable');
        
        $grab_corp_type = Model\Voucher_type::where(
            array(
                'type' => $this->VoucherType_datatable::TYPE_GRAB_CORP,
            ))
            ->get()
            ->limit(1)
            ;
        
        // Get the voucher code
        $voucher = Model\Voucher::where(
            array(
                'used_by' => null,
                'starting_date <=' => $this->db_value_now(),
                'expired_date >=' => $this->db_value_now(),
                'status' => $this->Voucher_datatable::STATUS_VALID,
                'type' => $grab_corp_type->id,
            ))
            ->order_by('id asc')
            ->limit(1)
            ->get()
            ;
        
        if ( !$voucher ) {
            show_error('Voucher not available.', 404, 'Grab for Business.');
        }
        
        //$voucher->task_id = $task_id;
        $voucher->used_by = $this->user_id;
        $voucher->used_at = $this->db_value_now();
        $voucher->notes   = $task->event_place;
        
        $voucher_task = Model\Voucher_task::make(
            array(
                'voucher_id' => $voucher->id,
                'task_id'    => $task->id,
                'user_id'    => $this->user_id,
            )
        );
        
        $voucher_task->save();
        
        $voucher->save();
        
        redirect('/my/my_task/'.$task->id, 'refresh');
        
        //var_dump($voucher);
        
        //echo $this->json_response(array('code' => $voucher->code));
    }
}
