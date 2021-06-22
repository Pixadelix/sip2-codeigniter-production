<?php



namespace Model;

use \Gas\Core;
use \Gas\ORM;

include_once('eproc_package.php');

class Eproc_lpse extends ORM {
	
	public $table = 'eproc_lpse';
	
	public const URL_LIST_LPSE = 'https://inaproc.lkpp.go.id/v3/daftar_lpse';
	
	public const LPSE_STATUS_ACTIVE = 'active';
	public const LPSE_STATUS_FAILED = 'failed';
	
	public $CI = null;
	
	public $primary_key = 'id';
	
	public $foreign_key = array(
		'\\model\\eproc_package' => 'lpse_id'
	);
	
	function _init() {
		
		$this->CI =& get_instance();
		
		self::$relationships = array(
			'packages' => ORM::has_many('\\Model\\Eproc_package'),
		);
		
		self::$fields = array(
			'id'                      => ORM::field('auto', array('required')),
			
			'name'                    => ORM::field('string', array('required')),
			'url_spse'                => ORM::field('string', array('required')),
			
			'status'                  => ORM::field('string'),
			'info'                    => ORM::field('string'),
			
			'redirect_url'            => ORM::field('string'),
			
			'scheme'                  => ORM::field('string'),
			'host'                    => ORM::field('string'),
			'port'                    => ORM::field('string'),
			'user'                    => ORM::field('string'),
			'pass'                    => ORM::field('string'),
			'path'                    => ORM::field('string'),
			'query'                   => ORM::field('string'),
			'fragment'                => ORM::field('string'),
			
			'create_by'               => ORM::field('int'),
			'create_at'               => ORM::field('datetime'),
			'update_by'               => ORM::field('int'),
			'update_at'               => ORM::field('datetime'),
		);
		
		$this->ts_fields = array('[create_at]', 'update_at');

	}
	
	function validate_spse() {

		$row = $this->record->get('data');

		$check = $this->CI->curl_get_data($row['url_spse']);
		
		if ( ! $check ) {
			return $this;
		}

		if ( ! $check->html ) {
			$row['status'] = self::LPSE_STATUS_FAILED;
			$row['info']   = $check->error.$check->html;
		} else {
			$row['status'] = self::LPSE_STATUS_ACTIVE;
			$row['info'] = null;
		}

		$row['redirect_url'] = isset($check->redirect_url) && $check->redirect_url ? $check->redirect_url : null;

		$parsed_url      = $row['redirect_url'] ? parse_url($row['redirect_url']) : parse_url($row['url_lpse']);
		
		$row['scheme'  ] = isset($parsed_url['scheme'])   ? $parsed_url['scheme']   : null;
		$row['host'    ] = isset($parsed_url['host'])     ? $parsed_url['host']     : null;
		$row['port'    ] = isset($parsed_url['port'])     ? $parsed_url['port']     : null;
		$row['user'    ] = isset($parsed_url['user'])     ? $parsed_url['user']     : null;
		$row['pass'    ] = isset($parsed_url['pass'])     ? $parsed_url['pass']     : null;
		$row['path'    ] = isset($parsed_url['path'])     ? $parsed_url['path']     : null;
		$row['query'   ] = isset($parsed_url['query'])    ? $parsed_url['query']    : null;
		$row['fragment'] = isset($parsed_url['fragment']) ? $parsed_url['fragment'] : null;
		
		$check = null; unset($check);
		
		$this->record->set('data', $row);
		
		return $this;
	}
	
	function download_package($start, $length, $depth) {
		
		$cnt_total = 0;
		
		$lpse = (object) $this->record->get('data');
		
		$url = $lpse->scheme.'://'.$lpse->host;
		echo "$lpse->id [$url]\n";
		
		
		$continue = true;
		$draw = 0;
		while ( $continue ) {
			$draw++;
			$query_string = "/eproc4/dt/lelang?draw=$draw&columns%5B0%5D%5Bdata%5D=0&columns%5B0%5D%5Bname%5D=&columns%5B0%5D%5Bsearchable%5D=true&columns%5B0%5D%5Borderable%5D=true&columns%5B0%5D%5Bsearch%5D%5Bvalue%5D=&columns%5B0%5D%5Bsearch%5D%5Bregex%5D=false&columns%5B1%5D%5Bdata%5D=1&columns%5B1%5D%5Bname%5D=&columns%5B1%5D%5Bsearchable%5D=true&columns%5B1%5D%5Borderable%5D=true&columns%5B1%5D%5Bsearch%5D%5Bvalue%5D=&columns%5B1%5D%5Bsearch%5D%5Bregex%5D=false&columns%5B2%5D%5Bdata%5D=2&columns%5B2%5D%5Bname%5D=&columns%5B2%5D%5Bsearchable%5D=true&columns%5B2%5D%5Borderable%5D=true&columns%5B2%5D%5Bsearch%5D%5Bvalue%5D=&columns%5B2%5D%5Bsearch%5D%5Bregex%5D=false&columns%5B3%5D%5Bdata%5D=3&columns%5B3%5D%5Bname%5D=&columns%5B3%5D%5Bsearchable%5D=false&columns%5B3%5D%5Borderable%5D=false&columns%5B3%5D%5Bsearch%5D%5Bvalue%5D=&columns%5B3%5D%5Bsearch%5D%5Bregex%5D=false&columns%5B4%5D%5Bdata%5D=4&columns%5B4%5D%5Bname%5D=&columns%5B4%5D%5Bsearchable%5D=true&columns%5B4%5D%5Borderable%5D=true&columns%5B4%5D%5Bsearch%5D%5Bvalue%5D=&columns%5B4%5D%5Bsearch%5D%5Bregex%5D=false&order%5B0%5D%5Bcolumn%5D=0&order%5B0%5D%5Bdir%5D=desc&start=$start&length=$length&search%5Bvalue%5D=&search%5Bregex%5D=false&_=".round(microtime(true)*1000);	
			//echo urldecode($url)."\n";
			
			$data = $this->CI->curl_get_data($url.$query_string);
			
			if ( $start >= $depth ) {
				$continue = false; break;
			}
			
			if ( ! $data ) {
				$start = $start + $length + 1;
				$continue = false; break;
			}
			
			$json = json_decode($data->html);
			
			if ( ! $json ) {
				$start = $start + $length + 1;
				$continue = false; break;
			}
			
			$pkgs = isset($json->data) ? $json->data : null;
			
			if ( ! $pkgs ) {
				$start = $start + $length + 1;
				$continue = false;
				break;
			}
			
			for ( $i = 0; $i < count($pkgs); $i++ ) {
				//usleep(1000);
				$pkg = $pkgs[$i];
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
				$this->CI->show_progress_status($i+1, count($pkgs), sprintf("Page: %4d - %-4d Package: %8d", $start, $start + $length, $p['id']));
				
				$r = \Model\Eproc_package::find($p['id']);

				if ( ! $r ) {
					$r = new \Model\Eproc_package();
				}

				$r->id                  = $p['id'];
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
				
				$r->save();
				
				$r = null; unset($r);
				$p = null; unset($p);

				$cnt_total++;
				
				$pkg  = null; unset($pkg);
			}
			
			$pkgs = null; unset($pkgs);
			
			$start = $start + $length + 1;
		}
		echo sprintf("\t----------------------------------- Sub Total: %5d package(s) -----------------------------------\n", $cnt_total);
		
		return $cnt_total;
	}
	
}
