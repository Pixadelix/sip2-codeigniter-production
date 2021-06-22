<?php
defined('BASEPATH') OR exit('No direct script access allowed');



class Voucher_manager extends ST_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->data['PAGE_TITLE'] = 'Voucher Manager';
		
		
		$this->breadcrumbs->push('Voucher Manager', '/officeadm/voucher_manager');
		
		$this->include_datatables_assets(true);
		
        $this->enqueue_resource(array(
			'/resource/script/adminlte/officeadm/voucher/js/voucher.php',
            '/resource/script/adminlte/officeadm/voucher/js/uploader.php',
		));
	}
    
    public function register_resource() {
        $this->must_cli_mode();
        
        Model\Acl_resource::create_resource(
            'office-admin',
            'voucher-manager',
            'Voucher Manager',
            '/officeadm/voucher_manager',
            'fa-ticket'
        );
    }
	
	public function index() {
        $this->restricted('office-admin');
		$this->dashboard('/adminlte/officeadm/voucher/index');
	}
	
	public function get($id = null) {
        $this->restricted('office-admin');
		parent::get();
		$this->load->model('de/officeadm/Voucher_datatable', 'voucher');
        
        if ( 'avail' === $id ) {
            $this->voucher->editor
                ->where('sip_voucher.used_by', null, '=')
                ->where('sip_voucher.status', $this->voucher::STATUS_VALID, '=')
                ->where('sip_voucher.expired_date', $this->db_value_now(), '>=');
        } else if ( 'used' === $id ) {
            $this->voucher->editor
                ->where( function ( $q ) {
                    $q->where( function ( $r ) {
                        $r->where('sip_voucher.used_by', null, '!=');
                        $r->or_where('sip_voucher.expired_date', $this->db_value_now(), '<');
                        $r->or_where('sip_voucher.status', $this->voucher::STATUS_INVALID, '=');
                    });
                });
                
        }
		$this->voucher->get();
	}
	
	public function get_voucher_type() {
        $this->restricted('office-admin');
		parent::get();
		$this->load->model('de/officeadm/VoucherType_datatable', 'vouchertype');
		$this->vouchertype->get();
	}
	
	public function get_voucher_group() {
        $this->restricted('office-admin');
		parent::get();
		$this->load->model('de/officeadm/VoucherGroup_datatable', 'vouchergroup');
		$this->vouchergroup->get();
	}
    
    public function get_files() {
        $this->restricted('office-admin');
        parent::get();
        $this->load->model('de/officeadm/VoucherFiles_datatable', 'voucherfiles');
        $this->voucherfiles->get();
    }
    
    public function do_import() {
        $this->_import_from_xlsx();
    }
    
    private function _import_from_csv() {
        
    }
    
    private function _import_from_xlsx() {
        $post_parent    = $this->input->post('post_parent');
        $voucher_type   = $this->input->post('voucher_type');
        $voucher_group  = $this->input->post('voucher_group');
        $voucher_status = $this->input->post('voucher_status');
        $this->restricted('office-admin');
        $xlsx = Model\Posts::result()->find($post_parent)->to_array();
        //var_dump($xlsx);
        
        if ( ! $xlsx ) {
            show_404();
            exit();
        }
        
        $this->load->library('excel');
        $filename = $xlsx[0]['media_system_path'];
        $type = PHPExcel_IOFactory::identify($filename);
        $objReader = PHPExcel_IOFactory::createReader($type);
        $objReader->setReadDataOnly(true);
        $objPHPExcel = $objReader->load($filename);
        $ymd = date('Y.m-');
        
        foreach ( $objPHPExcel->getWorksheetIterator() as $worksheet ) {
            $sheet_data = $worksheet->toArray(null, null, null, null);
            $data = array();
            for ( $i = 1; $i < count($sheet_data); $i++ ) {
                $data[] = array(
                    'name'          => strtoupper("$ymd$i"),
                    'code'          => $sheet_data[$i][0],
                    'starting_date' => $sheet_data[$i][1],
                    'expired_date'  => $sheet_data[$i][2],
                    'type'          => $voucher_type,
                    'group'         => $voucher_group,
                    'status'        => $voucher_status,
                );
            }
            
            $row_affected = 0;
            try {
                $this->db->db_debug = false;
                $row_affected = $this->db->update_batch('sip_voucher', $data, 'code');
                if ( ! $row_affected ) {
                    $row_affected = $this->db->insert_batch('sip_voucher', $data);
                }
                
                //if ( $row_affected ) {
                include_once(APPPATH.'models/de/content/Posts_datatable.php');
                    $post = Model\Posts::find_by_post_parent($post_parent);
                    $post[0]->post_status = $voucher_status ? Posts_datatable::IN_SYSTEM : Posts_datatable::IN_SYSTEM_INVALID;
                    $post[0]->save();
                //}
            }
            catch (Exception $e) {
                
            }
            
            unset($data);
        }
        $this->json_response($row_affected);
    }
    
    public function form_group_and_type() {
        $this->output->enable_profiler(false);
        $data = null;
        $this->data = $data;
        echo $this->load->view('adminlte/officeadm/voucher/form_group_and_type', $this->data, true);
    }
    
    public function upload() {
        $this->load->library('excel');

        $filename = "sample.xlsx";
        
        $this->load->helper('mime_type');
        
        //$mime_type = get_file_mime_type($filename, true);
        //var_dump($mime_type);
        
        $finfo = finfo_open(FILEINFO_MIME_TYPE); // return mime type ala mimetype extension
        foreach (glob("*") as $filename) {
            //echo $filename.': '.finfo_file($finfo, $filename) . "\n";
            $mime_type = get_file_mime_type($filename, false);
            echo "$filename: ";
            echo is_array($mime_type) ? var_dump($mime_type) : $mime_type."\n";
        }
        finfo_close($finfo);
        die;
        $type = PHPExcel_IOFactory::identify($filename);
        $objReader = PHPExcel_IOFactory::createReader($type);
        $objReader->setReadDataOnly(true);
        $objPHPExcel = $objReader->load($filename);
        
        foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
            //$worksheets[$worksheet->getTitle()] = $worksheet->toArray(null, true, true, true);
            //$sheet = $worksheet->toArray(null, true, true, true);
            $sheet = $worksheet->toArray(null, null, null, null);
            
            //var_dump($sheet); die;
            
            $data = array();
            for ($i = 1; $i<count($sheet);$i++) {
                $data[]  = array(
                    'name' => $sheet[$i][0],
                    'code' => $sheet[$i][1],
                    'expired_date' => $sheet[$i][2]
                );
            }
            
            //var_dump($data);
            
            
            try {
                //$this->db->insert_batch('sip_voucher', $data);
                $this->db->update_batch('sip_voucher', $data, 'code');
            }
            
            catch (Exception $e) {
                
            }
        }

        //var_dump($worksheets);
        
        
        
    }
}