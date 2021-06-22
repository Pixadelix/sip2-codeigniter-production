<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends ST_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->restricted();
		$this->data['PAGE_TITLE'] = 'User Profile';
		$this->breadcrumbs->push('User Profile', '/profile');
		
		$this->include_datatables_assets(true);

	}
	
		
	public function index($id = null)
	{
		$profile = Model\Users::find($id ? $id : $this->user_id);
        
        if ( !$profile ) {
            show_404();
            return;
        }
        
        $this->data['profile'] = $profile;
        
        if ( $profile->id == $this->user_id ) {
            $this->data['settings'] = true;
            $this->enqueue_resource('/resource/script/adminlte/profile/js/profile.js');
        }

        $task_summary = $this->db->query("select status, count(*) as `total` from sip_tasks where user_id = $profile->id group by status")->result_array();
        $this->data['task_summary'] = $task_summary;
		$this->dashboard('adminlte/profile/index');
	}
    
    public function get($id = null) {
        $this->output->enable_profiler(false);
        $this->load->model('de/setting/Users_datatable', 'user');
        $this->user->get($this->user_id);
    }
    
    public function edit() {
        $this->output->enable_profiler(false);
        $this->load->model('de/setting/Users_datatable', 'user');
        $this->user->get($this->user_id);
    }
    
    public function upload() {
        $this->edit();
    }
    
}