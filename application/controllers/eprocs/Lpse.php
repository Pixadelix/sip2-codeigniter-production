<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lpse extends ST_Controller {
	
	private $_start_time = null;
	private $_end_time = null;
	private $_elapsed_time = null;
	const DATA_LENGTH = 10;
	const DATA_DEPTH  = 100;
	const URL_LPSE = 'https://inaproc.lkpp.go.id/v3/daftar_lpse';
	
	private $_EXCLUDE_SITES = array(
		'http://inaproc.id/daftar-hitam',
		'http://www.lkpp.go.id/v3/',
		'http://monev.lkpp.go.id/profilPengadaan/profilPengadaan',
		'https://inaproc.lkpp.go.id/v3/public/sdp/sdp.htm',
	);
	
	public function __construct() {
		parent::__construct();
		$this->_start_time = microtime(true);
	}
	
	public function __destruct() {
		$this->_end_time = microtime(true);
		$time_diff = $this->_end_time - $this->_start_time;
		
		$s = $time_diff;
		
		$h = floor($s / 3600);
    	$s -= $h * 3600;
    	$m = floor($s / 60);
    	$s -= $m * 60;
    	$this->_elapsed_time = $h.':'.sprintf('%02d', $m).':'.sprintf('%02d', $s)."\n";
		
		if ( php_sapi_name() == 'cli' ) {
			echo $this->_elapsed_time;
		}
		
	}
	
	public function download($url = self::URL_LPSE) {
		//error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE);
		$this->must_cli_mode();
		
		$data = $this->curl_get_data($url);
		
		$links = $this->get_all_links($data->html);

		$i = 0;
		//Iterate over the extracted links and display their URLs
		foreach( $links as $link ) {
			
			$name = str_replace('  ', ' ', trim($link->nodeValue));
			$url_spse = filter_var(trim($link->getAttribute('href')), FILTER_VALIDATE_URL);
			
			$this->show_progress_status(++$i, $links->length, sprintf("CHECKING: %s", substr($url_spse, 0, 45)));
			
			if ( false !== array_search($url_spse, $this->_EXCLUDE_SITES) ) {
				continue;
			}

			// skip invalid url
			if ( ! $url_spse ) {
				continue;
			}

			$lpse = array(
				'name' => $name,
				'url_spse' => $url_spse,
			);
			
			$r = Model\Eproc_lpse::find_by_url_spse($url_spse, false);
			
			if ( ! $r ) {
				$r = new Model\Eproc_lpse();
			}
			
			$r->name     = $lpse['name'];
			$r->url_spse = $lpse['url_spse'];
			
			$r->validate_spse();
			$r->save();
			
			$lpse = null; unset($lpse);
			$r = null; unset($r);
			
		}
	}
	
	public function index($id = null)
	{
		
		$this->restricted('eproc-lpse-mgr');
		$this->data['PAGE_TITLE'] = 'LPSE';
		
		$this->include_datatables_assets(true);
		$this->enqueue_resource(array(
			'/resource/script/adminlte/eproc/js/lpse.js',
		));
		
		$this->dashboard('adminlte/eproc/lpse/index');
	}
	
	public function get($id = null) {
		
		$this->restricted('eproc-lpse-mgr');
		$this->load->model('de/eproc/Lpse_datatable');
		$this->Lpse_datatable->get($id);
	}
}


