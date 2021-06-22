<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Subscribers extends ST_Controller {
	
	public function __construct() {
		parent::__construct();
		
	}

	public function index($id = null)
	{
		
		$this->restricted('eproc-subscribers');
		
		$this->data['PAGE_TITLE'] = 'Subscriptions';
		
		$this->include_datatables_assets(true);
		$this->enqueue_resource(array(
			'/resource/script/adminlte/eproc/js/subscribers.js',
		));
		
		$this->dashboard('adminlte/eproc/subscribers/index');
	}
	
	public function get($id = null) {
		
		$this->restricted();
		$this->load->model('de/eproc/Subscribers_datatable');
		$this->Subscribers_datatable->get($id);
	}
	
	public function process_keywords() {
			
		$this->must_cli_mode();
		
		$subs = Model\Eproc_subscribers
			::select('user_id')
			->select_max('expired_date')
			->group_by('user_id')
			->where('expired_date >=', 'current_date', false)
			->all();
		
		for ( $i = 0; $i < count($subs); $i++ ) {
		
			$sub = $subs[$i];
			
			$user = $sub->user();
			
			$keywords = $user->eproc_keywords();

			if ( ! $keywords ) {
				continue;
			}
			
			echo sprintf("Subscriber: %s %s. Expired: %s\n", $user->first_name, $user->last_name, _ldate_($sub->expired_date));
			$monitored_lpses = $user->monitored_lpses();
			
			foreach ( $monitored_lpses as $lpse ) {
				
				//echo sprintf("\t%5d: %-50s\n", $lpse->lpse_id, $lpse->lpse()->name);
				
				$packages = $lpse->lpse()->packages();
				
				foreach ( $packages as $package ) {
					
					foreach ( $keywords as $keyword ) {
						if ( false !== stripos( $package->name, $keyword->keyword ) ) {
							echo sprintf("[%8d] %-25s -> %s\n", $package->id, $lpse->lpse()->name, $package->name);
							break;
						}
					}		
				}
			}
			
			
		}
		
		//$this->dashboard('adminlte/blank');
	}
}


