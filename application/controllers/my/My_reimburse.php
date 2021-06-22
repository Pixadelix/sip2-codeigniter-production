<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class My_reimburse extends ST_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->restricted('reimburse');
		
		$this->breadcrumbs->push('My Reimbursement', '/my/reimburse');
		
		$this->include_datatables_assets(true);
		
		$this->enqueue_scripts(array(
			'../../js/html5lightbox/html5lightbox.js',
			//'../../js/jquery.mask.min.js',
			//'../../js/autoNumeric.js',
			'../../js/jquery.inputmask.bundle.js',
			'app/my/my-reimburse.js'
		));
	}
	
	public function index() {
		$this->data['PAGE_TITLE'] = 'My Reimbursement';
		$this->data['ACTIVE_REIMBURSE_CONTAINER'] = $this->load->view('adminlte/my/reimburse/index', $this->data, true);
		
		$this->dashboard('adminlte/my/reimburse/reimburse');
	}
	
	public function get($id = null) {
		parent::get();
		$this->load->model('de/officeadm/ReimburseTicket_datatable', 'reimburse_ticket');
		$this->reimburse_ticket->get_by_user_id($this->user_id);
	}
	
	public function get_dtl($id) {
		parent::get();
		$this->load->model('de/officeadm/ReimburseTicketDtl_datatable', 'reimburse_ticket_dtl');
		$this->reimburse_ticket_dtl->get($id);
	}
	
}