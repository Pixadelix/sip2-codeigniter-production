<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Eproc extends ST_Controller {
	
	public function __construct() {
		parent::__construct();
		
		$this->restricted(array(
				'eproc-setting',
			)
		);
		
		$this->breadcrumbs->push('Subscriptions', '/eproc');
		
	}
	
	public function index()
	{
		$this->data['PAGE_TITLE'] = 'Subscriptions';
		
		$this->include_datatables_assets(true);
		$this->enqueue_resource(array(
			'/resource/script/adminlte/eproc/js/setting.js',
			'/resource/script/midtrans/js/payment.js',
		));
		
		$this->load->model('de/shop/Shop_datatable');
		$this->load->model('de/shop/Shop_product_datatable');
		
		$shops = Model\Shop
			//::limit(1)
			::where('status', $this->Shop_datatable::SHOP_STATUS_OPEN)
			->where('name', 'mediavista')
			->or_where('name', 'e-proc 2')
			->order_by('id', 'asc')
			->get();
			;
		
		if ( $shops ) {
			
			$all_products = array();
			
			$shops = is_array($shops) ? $shops : array($shops);
			for ( $i = 0; $i < count($shops); $i++ ) {
				
				$shop = $shops[$i];
		
				$products = Model\Shop_product
					::where('status', $this->Shop_product_datatable::PRODUCT_STATUS_READY)
					->where('shop_id', $shop->id)
					->all();
				
				
				$products = is_array($products) ? $products : array($products);
				//var_dump(count($products));
				
				$all_products = array_merge($all_products, $products);
				//var_dump(count($all_products));
			}
			//die;
			$this->data['products'] = $all_products;
		}
		
		$subs = Model\Eproc_subscribers
			::limit(1)
			->select(array('user_id'))
			->select_min('create_at')
			->select_max('expired_date')
			->where(array(
				'user_id' => $this->user_id,
				'expired_date >=' => date('Y-m-d'),
			))
			->group_by('user_id')
			->get();
		
		$this->data['subscriptions'] = $subs;
		
		$this->dashboard('adminlte/eproc/index');
	}
	
	public function register() {
		if (
			!isset($_POST['name']) || empty($_POST['name']) ||
			!isset($_POST['email']) || empty($_POST['email']) ||
			!isset($_POST['password']) || empty($_POST['password']) ||
			!isset($_POST['retype']) || empty($_POST['retype'])
		   ) {
			$this->load->view('adminlte/eproc/register/register', $this->data);
			return;
		} else {
			var_dump($_POST);
		}
	}
	
}