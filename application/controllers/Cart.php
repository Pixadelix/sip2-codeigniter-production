<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cart extends ST_Controller {
	
	public function __construct() {
		parent::__construct();
		
		$this->restricted(array(

			)
		);
		
		$this->breadcrumbs->push('Subscriptions', '/eproc');
		
		$this->load->model('de/shop/Shop_cart_datatable', 'Shop_cart');
		
	}
	
	public function index()
	{
		$this->data['PAGE_TITLE'] = 'Shoping Cart';
		
		$this->include_datatables_assets(true);
		$this->enqueue_resource(array(
			'/resource/script/adminlte/shops/js/cart.js',
		));
		
		$carts = Model\Shop_cart
			::where(array(
				'user_id' => $this->user_id,
				'status'  => $this->Shop_cart::CART_STATUS_OPEN
			))
			->get()
			;
		
		if ( $carts ) {
			$this->data['carts'] = is_array($carts) ? $carts : array($carts);
			$this->dashboard('adminlte/shops/cart/invoice');
		} else {
			$this->dashboard('adminlte/blank');
		}
	}
	
	public function add_item($product_id) {
		
		$product = Model\Shop_product::find($product_id);
		
		if ( ! $product ) {
			show_404();
			exit();
		}

		$cart = Model\Shop_cart
			::limit(1)
			->where(array(
				'user_id' => $this->user_id,
				'shop_id' => $product->shop_id,
				'status' => $this->Shop_cart::CART_STATUS_OPEN,
			))
			->get();
		
		if ( ! $cart ) {
			// Create a new open cart
			
			try {
				
				$new_cart = Model\Shop_cart::make(
					array(
						'user_id'     => $this->user_id,
						'shop_id'     => $product->shop_id,
						'status'      => $this->Shop_cart::CART_STATUS_OPEN,
						'due_date'    => date('Y-m-d', strtotime('+30 days')),
					)
				);
				
				if ( !$new_cart->save() ) {
					 echo 'The raw errors were : ';
        			print_r($new_cart->errors);
				}
				
			
				$last_created_cart_id = Model\Shop_cart::last_created()->id;
				$cart = Model\Shop_cart::find($last_created_cart_id)->get();
				
			}
			catch ( Exception $e ) {
				var_dump($e->message);
				exit();
			}
			
			
		}
		
		$existing_item = Model\Shop_cart_item
			::limit(1)
			->where(array(
				'cart_id'    => $cart->id,
				'user_id'    => $this->user_id,
				'shop_id'    => $product->shop_id,
				'product_id' => $product->id,
			))
			->get();
		
		if ( $existing_item ) {
			$existing_item->qty = $existing_item->qty + 1;
			$existing_item->save();
			//var_dump($existing_item); die;
		} else {
			$new_item = Model\Shop_cart_item::make(array(
				'cart_id'     => $cart->id,
				'user_id'     => $this->user_id,
				'shop_id'     => $product->shop_id,
				'product_id'  => $product->id,			
				'base_price'  => $product->base_price,
				'qty'         => 1
			))->save(true);
		}
		
		//$this->dashboard('adminlte/shops/cart/invoice');
		redirect('/cart', 'refresh');
	}
	
}