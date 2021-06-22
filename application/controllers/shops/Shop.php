<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Shop extends ST_Controller {
	
	public function __construct() {
		parent::__construct();
		
		$this->restricted(array(

			)
		);
		
		$this->breadcrumbs->push('Shop', '/Shop');
		
	}
	
	public function index()
	{
		$this->data['PAGE_TITLE'] = 'Shop';
		
		$this->include_datatables_assets(true);
		$this->enqueue_resource(array(
			'/resource/script/adminlte/shops/js/shop.js',
		));
		
		$this->dashboard('adminlte/shops/shops/index');
	}
	
	public function get($id = null) {
		$this->restricted('shop-mgr');
		$this->load->model('de/shop/Shop_datatable');
		$this->Shop_datatable->get($id);
	}
	
}