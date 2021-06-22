<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Package extends ST_Controller {
	
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
	
	public function download($start = 0, $length = self::DATA_LENGTH, $depth = self::DATA_DEPTH, $keyword = null) {
		$this->must_cli_mode();
		
		$cnt_total = 0;
		
		$lpses = Model\Eproc_lpse::where('status', Model\Eproc_lpse::LPSE_STATUS_ACTIVE)
//			->where('id >= ', 359)
			->like('name', $keyword)
			->or_like('url_spse', $keyword)
			->all();
		
		for ( $idx_lpse = 0; $idx_lpse < count($lpses); $idx_lpse++ ) {
			
			$lpse = $lpses[$idx_lpse];
			$cnt_total += $lpse->download_package($start, $length, $depth);
		}
		
		echo sprintf("\t----------------------------------- GRAND TOTAL: %5d package(s) -----------------------------------\n", $cnt_total);

	}
/*	
	public function download_package($start = 0, $length = self::DATA_LENGTH, $keyword = null) {
		$this->_must_cli_mode();
		ini_set('memory_limit', '2G');
		$mem_limit = ini_get('memory_limit');
		
		echo "Memory Limit: ".($mem_limit)."\n";
		$opts = array(
			//CURLOPT_USERAGENT  => "User-Agent: Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/61.0.3163.100 Safari/537.36",
			//CURLOPT_HTTPHEADER => array("X-Requested-With: XMLHttpRequest")
		);
		
		$this->output->enable_profiler(false);
		$cnt = 0;
		
		$LPSE = null;
		if ( $keyword ) {
			echo "Filtering: $keyword\n";
			$LPSE = Model\Eproc_lpse::like('url_spse', $keyword)->where('status', null)->all();
		} else {
			$LPSE = Model\Eproc_lpse::all();
		}
		
		for ( $i_lpse = 0; $i_lpse < count($LPSE); $i_lpse++ ) {
		
			for ( $start = 0; $start < 1; $start++ ) {

				$lpse = $LPSE[$i_lpse];
				$url_spse = $lpse->url_spse;
				echo $lpse->id .". $url_spse\n";
				//$url = "https://lpse.lkpp.go.id/eproc4/dt/lelang?draw=5&columns%5B0%5D%5Bdata%5D=0&columns%5B0%5D%5Bname%5D=&columns%5B0%5D%5Bsearchable%5D=true&columns%5B0%5D%5Borderable%5D=true&columns%5B0%5D%5Bsearch%5D%5Bvalue%5D=&columns%5B0%5D%5Bsearch%5D%5Bregex%5D=false&columns%5B1%5D%5Bdata%5D=1&columns%5B1%5D%5Bname%5D=&columns%5B1%5D%5Bsearchable%5D=true&columns%5B1%5D%5Borderable%5D=true&columns%5B1%5D%5Bsearch%5D%5Bvalue%5D=&columns%5B1%5D%5Bsearch%5D%5Bregex%5D=false&columns%5B2%5D%5Bdata%5D=2&columns%5B2%5D%5Bname%5D=&columns%5B2%5D%5Bsearchable%5D=true&columns%5B2%5D%5Borderable%5D=true&columns%5B2%5D%5Bsearch%5D%5Bvalue%5D=&columns%5B2%5D%5Bsearch%5D%5Bregex%5D=false&columns%5B3%5D%5Bdata%5D=3&columns%5B3%5D%5Bname%5D=&columns%5B3%5D%5Bsearchable%5D=false&columns%5B3%5D%5Borderable%5D=false&columns%5B3%5D%5Bsearch%5D%5Bvalue%5D=&columns%5B3%5D%5Bsearch%5D%5Bregex%5D=false&columns%5B4%5D%5Bdata%5D=4&columns%5B4%5D%5Bname%5D=&columns%5B4%5D%5Bsearchable%5D=true&columns%5B4%5D%5Borderable%5D=true&columns%5B4%5D%5Bsearch%5D%5Bvalue%5D=&columns%5B4%5D%5Bsearch%5D%5Bregex%5D=false&order%5B0%5D%5Bcolumn%5D=0&order%5B0%5D%5Bdir%5D=desc&start=$start&length=$length&search%5Bvalue%5D=&search%5Bregex%5D=false&_=".round(microtime(true)*1000);
				$url = $url_spse."/eproc4/dt/lelang?draw=5&columns%5B0%5D%5Bdata%5D=0&columns%5B0%5D%5Bname%5D=&columns%5B0%5D%5Bsearchable%5D=true&columns%5B0%5D%5Borderable%5D=true&columns%5B0%5D%5Bsearch%5D%5Bvalue%5D=&columns%5B0%5D%5Bsearch%5D%5Bregex%5D=false&columns%5B1%5D%5Bdata%5D=1&columns%5B1%5D%5Bname%5D=&columns%5B1%5D%5Bsearchable%5D=true&columns%5B1%5D%5Borderable%5D=true&columns%5B1%5D%5Bsearch%5D%5Bvalue%5D=&columns%5B1%5D%5Bsearch%5D%5Bregex%5D=false&columns%5B2%5D%5Bdata%5D=2&columns%5B2%5D%5Bname%5D=&columns%5B2%5D%5Bsearchable%5D=true&columns%5B2%5D%5Borderable%5D=true&columns%5B2%5D%5Bsearch%5D%5Bvalue%5D=&columns%5B2%5D%5Bsearch%5D%5Bregex%5D=false&columns%5B3%5D%5Bdata%5D=3&columns%5B3%5D%5Bname%5D=&columns%5B3%5D%5Bsearchable%5D=false&columns%5B3%5D%5Borderable%5D=false&columns%5B3%5D%5Bsearch%5D%5Bvalue%5D=&columns%5B3%5D%5Bsearch%5D%5Bregex%5D=false&columns%5B4%5D%5Bdata%5D=4&columns%5B4%5D%5Bname%5D=&columns%5B4%5D%5Bsearchable%5D=true&columns%5B4%5D%5Borderable%5D=true&columns%5B4%5D%5Bsearch%5D%5Bvalue%5D=&columns%5B4%5D%5Bsearch%5D%5Bregex%5D=false&order%5B0%5D%5Bcolumn%5D=0&order%5B0%5D%5Bdir%5D=desc&start=$start&length=$length&search%5Bvalue%5D=&search%5Bregex%5D=false&_=".round(microtime(true)*1000);

				//echo urldecode($url)."\n";

				$data = $this->get_data($url, $opts);
				$html = $data->html;
				echo "\tDownloaded data: ".$this->format_size(strlen($html))."\n";
				
				$lpse->status = null;
				$lpse->info   = null;
				
				$data = null; unset($data);
				
				if ( ! $html ) {
					$lpse->status = 'failed';
					$lpse->info   = $this->_last_error.$html;
					$lpse->save();
					echo "\n";
					break;
				}

				$json = json_decode($html);
				
				if ( ! $json ) {
					$lpse->status = 'failed';
					$lpse->info   = $this->_last_error.$html;
					$lpse->save();
					echo "\n";
					break;
				}
				
				$lpse->save();
				
				$this->_last_error = null;

				$pkgs = $json->data;
				for ( $i = 0; $i < count($pkgs); $i++ ) {
					$pkg = $pkgs[$i];
					//print_r($pkg);
					$p = array(
						'id'                 => $pkg[0],
						'name'               => $pkg[1],
						'instance'           => $pkg[2],
						'status'             => $pkg[3],
						'est_price'          => $pkg[4],
						'doc_method'         => $pkg[5],
						'method'             => $pkg[6],
						'elimination_method' => $pkg[7],
						'category'           => $pkg[8],
						'spse_version'       => $pkg[9],
						
						'lpse_id'            => $lpse->id
					);
					//echo $p->id;

					$this->show_status($i+1, count($pkgs), sprintf("\tPackage: %s", $p['id']));

					$r = null;
					if ( $r = Model\Eproc_package::find($p['id']) ) {
						$r->name                = $p['name'];
						$r->instance            = $p['instance'];
						$r->status              = $p['status'];
						$r->est_price           = $p['est_price'];
						$r->doc_method          = $p['doc_method'];
						$r->method              = $p['method'];
						$r->elimination_method  = $p['elimination_method'];
						$r->category            = $p['category'];
						$r->spse_version        = $p['spse_version'];
						
						$r->lpse_id             = $lpse->id;
					} else {
						$r = new Model\Eproc_package($p);

					}
					
					$r->save();
					
					$p = null; unset($p);
					$r = null; unset($r);
					
					$cnt++;
					
				}
				echo "\n";
				//echo count($pkgs)."\n";
			}
			
		}
		
		echo "Processed: $cnt\n";
	}
	
*/
	
	public function index($id = null)
	{
		$this->restricted('eproc-package-mgr');
		
		$this->data['PAGE_TITLE'] = 'Package';
		
		$this->include_datatables_assets(true);
		$this->enqueue_resource(array(
			'/resource/script/adminlte/eproc/js/package.js',
		));
		
		$this->dashboard('adminlte/eproc/package/index');
	}
	
	public function get($id = null) {
		
		
		$this->restricted();
		$this->load->model('de/eproc/Package_datatable');
		$this->Package_datatable->get();
	}
}


