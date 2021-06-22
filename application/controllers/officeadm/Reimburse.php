<?php
defined('BASEPATH') OR exit('No direct script access allowed');



class Reimburse extends ST_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->data['PAGE_TITLE'] = 'Reimburse Manager';
		$this->restricted('office-admin');
		
		$this->breadcrumbs->push('Reimburse Manager', '/officeadm/reimburse');
		
		$this->include_datatables_assets(true);
		
		
		$this->enqueue_scripts('../../js/html5lightbox/html5lightbox.js');
		
		$this->enqueue_scripts('app/common.js');
		$this->enqueue_scripts('app/officeadm/reimburse.js');
	}
	
	public function index() {
		$this->dashboard('/adminlte/officeadm/reimburse/index');
	}
	
	public function get($id = null) {
		parent::get();
		$this->load->model('de/officeadm/ReimburseTicket_datatable', 'reimburse_ticket');
		$this->reimburse_ticket->get();
	}
	
	public function get_dtl($id) {
		parent::get();
		$this->load->model('de/officeadm/ReimburseTicketDtl_datatable', 'reimburse_ticket_dtl');
		$this->reimburse_ticket_dtl->get($id);
	}
	
	public function get_change_log($ticket_id, $dtl_id) {
		parent::get();
		$sql = "SELECT `change_log` FROM `sip_reimburse_tickets_dtl` WHERE `ticket_id` = ? AND `id` = ?";
		$rows = $this->db->query($sql, array($ticket_id, $dtl_id))->result_array();
		$change_log = $rows[0]['change_log'];

		
		
		if(is_serial($change_log)) {
			$change_log = unserialize($change_log);
		}
		
		$bgcolor = array(
			'process'   => 'label-default',
			'approved'  => 'bg-lightblue',
			'canceled'  => 'bg-darkred',
			'rejected'  => 'bg-red',
			'completed' => 'bg-lightgreen'
		);
		
		$icon = array(
			'process'   => 'fa-arrow-circle-o-right',
			'approved'  => 'fa-check-circle-o',
			'canceled'  => 'fa-times-circle',
			'rejected'  => 'fa-ban',
			'completed' => 'fa-check-square-o'
		);
		
		$update_by = Model\Users::result()->all()->to_array();
		//var_dump($update_by); die;
		
		
		$retval = array();
		if (is_array($change_log)) {
			for ($i = 0; $i < count($change_log); $i++ ) {
				$log = $change_log[$i];
			
				if(is_object($log)) {
					
					$u = array_search($log->update_by ? $log->update_by : $log->create_by, array_column($update_by, 'id'));
					
					$log_size = mb_strlen(serialize($log));

					$retval[] = array(
						'date'       => _ldate_($log->date),
						'status'     => ucfirst($log->status),
						'update_by'  => $update_by[$u]['first_name'],
						'update_at'  => $log->update_at ? _ldate_($log->update_at, '%d/%b/%Y %H:%M') : _ldate_($log->create_at, '%d/%b/%Y %H:%M'),
						'icon'       => $icon[$log->status],
						'labelcolor' => $bgcolor[$log->status],
						'log_size'   => $log_size,
					);
				} else {
					$retval[] = array(
						'change_log' => nl2br($log)
					);
				}
			}
		}else{
			$retval[] = array(
				'change_log' => nl2br($change_log)
			);
		}

		echo json_encode(array('logs' => $retval));
	
	}
	
	/*
	public function get_receipts($ticket_id, $dtl_id = null) {
		parent::get();
		$sql = "SELECT * FROM `sip_reimburse_receipts` WHERE `ticket_id` = ? and (`ticket_dtl_id` = ? or ? is null)";
		$rows = $this->db->query($sql, array($ticket_id, $dtl_id, $dtl_id))->result_array();
		
		echo json_encode(
			array(
				'receipts' => array(
					'img' => $rows,
//					'pdf' => array(),
					'pdf' => array(
						'img_path' => 'assets/upload/pdf/biznet.pdf',
						'thumbnail_path' => 'assets/static/img/PDF-Icon.jpg',
						'ticket_dtl_id' => 'dummy',
					)
				)
			)
		);
	}
	*/
}