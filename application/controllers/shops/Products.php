<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Products extends ST_Controller {
	
	public function __construct() {
		parent::__construct();
		
		$this->restricted(array(
				'shops'
			)
		);
		
		$this->breadcrumbs->push('Products', '/shops/products');
	
	}
	
	public function index()
	{
		$this->data['PAGE_TITLE'] = 'Products';
		
		$this->enqueue_scripts(array(
			'https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.0/jquery.mask.js',
		));
		$this->include_datatables_assets(true);
		
		$this->enqueue_resource(array(
			'/resource/script/adminlte/shops/js/product.js',
		));
		
		$this->dashboard('adminlte/shops/products/index');
	}
	
	public function get($id = null) {
		
		$this->restricted();
		$this->load->model('de/shop/Shop_product_datatable');
		$this->Shop_product_datatable->get($id);
	}

	public function categories()
	{
		$this->breadcrumbs->push('Categories', '/shops/products/categories');
		$this->data['PAGE_TITLE'] = 'Categories';
		
		$this->include_datatables_assets(true);
		$this->enqueue_resource(array(
			'/resource/script/adminlte/shops/js/category.js',
		));
		
		$this->dashboard('adminlte/shops/products/category/index');
	}
	
	public function get_categories() {
	
		$this->restricted();
		$this->load->model('de/shop/Shop_product_category_datatable');
		$this->Shop_product_category_datatable->get();
	}
	
}