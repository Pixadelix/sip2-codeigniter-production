<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends ST_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->restricted('admin');
		$this->breadcrumbs->push('User Management', '/setting/users');
	}
	
		
	public function index()
	{
		$this->include_datatables_assets(true);
		
		$this->enqueue_scripts('app/common.js');
		//$this->enqueue_scripts('app/setting/users.js');
        
        $this->enqueue_resource('/resource/script/adminlte/setting/users/js/users.js');
        $this->enqueue_resource('/resource/script/adminlte/setting/users/js/groups.js');

		$this->dashboard('adminlte/setting/users/index');
	}
	
	public function get($id = null) {
		parent::get();
		$this->load->model('de/setting/Users_datatable', 'users');
		$this->users->get($id);
	}
    
    public function get_groups($id = null) {
        parent::get();
        $this->load->model('de/setting/Groups_datatable', 'groups');
        $this->groups->get($id);
    }
}