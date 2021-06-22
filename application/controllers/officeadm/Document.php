<?php
defined('BASEPATH') OR exit('No direct script access allowed');



class Document extends ST_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->data['PAGE_TITLE'] = 'Document Admin';
		$this->restricted('office-admin');
		
		$this->breadcrumbs->push('Document Admin', '/officeadm/document');
		
		$this->include_datatables_assets(true);
		
		$this->enqueue_scripts('app/common.js');
		$this->enqueue_scripts('app/officeadm/admdoc.js');
	}
	
	public function index() {
		$this->dashboard('/adminlte/officeadm/document/index');
	}
	
	public function get($id = null) {
		parent::get();
		$this->load->model('de/officeadm/AdminDocument_datatable', 'admdoc');
		$this->admdoc->get();
	}
	
	public function get_doctype() {
		parent::get();
		$this->load->model('de/officeadm/AdminDocumentType_datatable', 'admdoctype');
		$this->admdoctype->get();
	}
	
	public function get_docgroup() {
		parent::get();
		$this->load->model('de/officeadm/AdminDocumentGroup_datatable', 'admdocgroup');
		$this->admdocgroup->get();
	}
}