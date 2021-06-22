<?php
defined('BASEPATH') OR exit('No direct script access allowed');

defined('INSTALL') OR define('INSTALL', true);

/*
function show_status($done, $total, $label, $size=15) {

    static $start_time;

    // if we go over our bound, just ignore it
    if($done > $total) return;

    if(empty($start_time)) $start_time=time();
    $now = time();

    $perc=(double)($done/$total);

    $bar=floor($perc*$size);

    $status_bar="\r".sprintf('%-55s', $label)."[";
    $status_bar.=str_repeat("=", $bar);
    if($bar<$size){
        $status_bar.=">";
        $status_bar.=str_repeat(" ", $size-$bar);
    } else {
        $status_bar.="=";
    }

    $disp=number_format($perc*100, 0);

    $status_bar.="] $disp%  $done/$total";

    $rate = ($now-$start_time)/$done;
    $left = $total - $done;
    $eta = round($rate * $left, 2);

    $elapsed = $now - $start_time;

    $status_bar.= " remaining: ".number_format($eta)." sec.  elapsed: ".number_format($elapsed)." sec.";

    echo "$status_bar  ";

    flush();

    // when done, send a newline
    if($done == $total) {
        echo "\n";
    }

	//usleep(10000);
}
*/


class Install extends ST_Controller {

/*
 ooooo  oooo ooooooo                    ooooo        ooo o        ooo o  
oo___oo__oo__oo____oo_____oo____o_____oo____oo_____oo___oo______oo___oo__
_oo______oo__oo____oo_____oo____o___________oo____oo___o_oo____oo___o_oo_
___oo____oo__oooooo_______oo___o__________ooo_____oo__o__oo____oo__o__oo_
oo___oo__oo__oo____________oo_o_________ooo____oo__ooo__oo__oo__ooo__oo__
_ooooo__oooo_oo_____________oo________oooooooo_oo___oooo____oo___oooo____
                                                   o            o       
*/
	
	
	protected $source_db = null;
	protected $target_db = null;
	private $_initialized = false;
    
	protected $tables = array(
	
		// SETTING
		array('model' => 'de/setting/Groups_datatable'                      , 'source' => 'groups'                 , 'target' => 'sip_groups'),
		array('model' => 'de/setting/Users_datatable'                       , 'source' => 'users'                  , 'target' => 'sip_users'),
		array('model' => 'de/setting/Clients_datatable'                     , 'source' => 'clients'                , 'target' => 'sip_clients'),
		array('model' => 'de/setting/Projects_datatable'                    , 'source' => 'projects'               , 'target' => 'sip_projects'),
		array('model' => 'de/setting/Users_groups_datatable'                , 'source' => 'users_groups'           , 'target' => 'sip_users_groups'),
		array('model' => 'de/setting/Users_projects_datatable'              , 'source' => null                     , 'target' => 'sip_users_projects'),
		array('model' => 'de/setting/Acl_resource_datatable'                , 'source' => null                     , 'target' => 'sip_acl_resource'),
		array('model' => 'de/setting/Acl_restricted_resource_datatable'     , 'source' => null                     , 'target' => 'sip_acl_restricted_resource'),
		array('model' => 'de/setting/Task_types_datatable'                  , 'source' => null                     , 'target' => 'sip_task_types'),

		// WORKSPACE
		array('model' => 'de/workspace/Workspace_datatable'                 , 'source' => 'mags'                   , 'target' => 'sip_workspace'),
		array('model' => 'de/workspace/Worksheet_datatable'                 , 'source' => 'tabs'                   , 'target' => 'sip_worksheet'),
		array('model' => 'de/workspace/Task_datatable'                      , 'source' => 'tasks'                  , 'target' => 'sip_tasks'),

		// OFFICE ADMINISTRATIF
		array('model' => 'de/officeadm/AdminDocument_datatable'             , 'source' => null                     , 'target' => 'sip_admin_document'),
        array('model' => 'de/officeadm/AdminDocumentArchive_datatable'),
		array('model' => 'de/officeadm/AdminDocumentGroup_datatable'        , 'source' => null                     , 'target' => 'sip_admin_document_group'),
		array('model' => 'de/officeadm/AdminDocumentType_datatable'         , 'source' => null                     , 'target' => 'sip_admin_document_type'),

		array('model' => 'de/officeadm/ReimburseTicket_datatable'           , 'source' => 'reimburs_tickets'       , 'target' => 'sip_reimburse_tickets'),
		array('model' => 'de/officeadm/ReimburseTicketDtl_datatable'        , 'source' => 'reimburs_tickets_dtl'   , 'target' => 'sip_reimburse_tickets_dtl'),
		array('model' => 'de/officeadm/ReimburseReceipts_datatable'         , 'source' => 'reimburs_receipts'      , 'target' => 'sip_reimburse_receipts'),
        array('model' => 'de/officeadm/Voucher_datatable'),
        array('model' => 'de/officeadm/VoucherGroup_datatable'),
        array('model' => 'de/officeadm/VoucherType_datatable'),
        array('model' => 'de/officeadm/VoucherTask_datatable'),
		
		// ADDITIONAL REIMBURSE DETAIL RECEIPTS
		array('model' => 'de/officeadm/ReimburseTicketDtlReceipts_datatable', 'source'  => 'sip_reimburse_receipts', 'target'  => 'sip_reimburse_tickets_dtl_receipts'),

		// POSTS
		array('model' => 'de/content/Posts_datatable'),
        
        // SHOP
        array('model' => 'de/shop/Shop_cart_datatable'),
        array('model' => 'de/shop/Shop_cart_item_datatable'),
        array('model' => 'de/shop/Shop_datatable'),
        array('model' => 'de/shop/Shop_product_category_datatable'),
        array('model' => 'de/shop/Shop_product_datatable'),
		
	);

	protected $additional = array(
		//array('model' => 'de/officeadm/ReimburseTicketDtlReceipts_datatable', 'source'  => 'sip_reimburse_receipts', 'target'  => 'sip_reimburse_tickets_dtl_receipts')
	);
	
	public function __construct() {
		parent::__construct();
		if(php_sapi_name() == "cli") {
			//In cli-mode
		} else {
			//Not in cli-mode
			echo 'This module can only be running in CLI Mode';
			exit();
		}
        $this->output->enable_profiler(false);

//		echo $this::SIP_LOGO;
        
        $this->target_db = $this->db; //$this->load->database('pdo');
//        var_dump($this->target_db);

        /*
		// connect to source database if provided
		$this->source_db = $this->load->database('source', false);
		
		// connect to target database
		$this->target_db = $this->load->database('target', TRUE);
		
        if( $this->source_db ) {
		    echo "Import from: `".$this->source_db->database."'".PHP_EOL;
        }
		echo "Install to : `".$this->target_db->database."'".PHP_EOL.PHP_EOL;
        */
        
		/*
		echo "Application database will be installed on `".$this->target_db->database."'".PHP_EOL;
		echo "Are you sure want to do this?  Type 'yes' to continue: ";
		$handle = fopen ("php://stdin","r");
		$line = fgets($handle);
		if(trim($line) != 'yes'){
			echo "ABORTING!\n";
			exit;
		}
		fclose($handle);
		*/
		//echo "\n"; 
		//echo "Thank you, continuing...\n";

		$this->_load_models();
    }
    
    private function _load_models() {
        
        if ( $this->_initialized ) return;
        
		echo "Please wait...".PHP_EOL.PHP_EOL;
		
		for ( $i = 0; $i < count($this->tables); $i++ ) {
			$table = $this->tables[$i];
			$source = $table['source'];
			$target = $table['target'];
            
            $target = $target ? $target : $table['model'];
			
			//printf("Load model: %-30s", $target);
            $this->show_progress_status($i+1, count($this->tables)+1, sprintf("%-10s : %-30s", "Initialize", $target));
            
            $this->load->model($table['model'], $target ? $target : $table['model'], $this->target_db);
            
			//print("\n");
		}
		$this->show_progress_status($i+1, count($this->tables)+1, sprintf("%-10s : %-30s", "Initialize", "Done"));
		print("\n");
		
		$this->_initialized = true;
		
		return;
	}
	
	public function __destruct() {
		if ( ! $this->input->is_cli_request() ) {
			return;
		}
		echo <<<EOL


Installation is finished. Good luck and thank you.

EOL;
        parent::__destruct();
	}
	
	public function help() {
		echo <<<EOL
List of available options:
  - tables    : install tables
  - baseline  : install baseline value for all tables
  - model     : call specific [model_function] specified in the [model_name]
    parameters [model_name] [model_function]
EOL;
	}

	public function index()
	{

		$error_level = error_reporting();
		error_reporting($error_level & ~E_NOTICE);

		$this->help();
		
		error_reporting($error_level);
	}
	
	public function all() {
		$this->index();
		$this->baseline();
		$this->migrate();
		$this->additional();
	}
	

	
	public function tables() {
		for ( $i = 0; $i < count($this->tables); $i++ ) {
			$table = $this->tables[$i];
			$source = $table['source'];
			$target = $table['target'];
            
            $target = $target ? $target : $table['model'];
			
			//printf("Create Table: %-30s", $target);
			$this->show_progress_status($i+1, count($this->tables)+1, sprintf("%-10s : %-30s", "Installing", $target));
            $this->load->model($table['model'], $target, $this->target_db);
			
			$this->$target->create_table();
			

			if ( method_exists($this->$target, 'create_view') ) {
				//print("\n");
				$this->$target->create_view();
			}

			//print("\n");
		}
		
		//print("\n");
		$this->show_progress_status($i+1, count($this->tables)+1, sprintf("%-10s : %-30s", "Installing", "Completed"));
	
		return;
	}
	
	public function migrate() {
        if( !$this->source_db ) {
            echo "Source data not provided, Aborting.".PHP_EOL;
            return;
        }
        
		echo "Migrating data, please wait...".PHP_EOL;

		for ( $i = 0; $i < count($this->tables); $i++ ) {
			$table = $this->tables[$i];
			$source = $table['source'];
			$target = $table['target'];

			if ( $source ) {
				printf("Migrating: %30s -> %-30s", ($source ? $source : 'NULL'), $target);
				$this->migrate_data($source, $target);
				print("\n");
				
				if ( method_exists($this->$target, 'post_migrate') ) {
					printf("Post Migrate for: %30s\n", $target);
					try {
						$this->$target->post_migrate();
					}
					
					catch (Exception $e) {
						echo 'Caught exception: ',  $e->getMessage(), PHP_EOL;
					}
				}
			}
		}
		
		//print("\n");
	
	}
	
	private function migrate_data($src, $tgt) {
        if ( !$this->source_db ) {
            return;
        }
		if ( !$src ) {
			return;
		}
		// use master database
		$rows = $this->source_db->get($src);
		try {
			
			// clean up target table
			$this->target_db->query("TRUNCATE TABLE `$tgt`");
			$affected_rows = $this->target_db->insert_batch($tgt, $rows->result_array());
			
			printf(" %5d inserted", $affected_rows);
		}
		catch (Exception $e) {
			echo 'Caught exception: ',  $e->getMessage(), PHP_EOL;
		}

	}
	
	public function baseline() {
		//printf("Populating baseline values, please wait...".PHP_EOL);
		//try {
			for ( $i = 0; $i < count($this->tables); $i++ ) {
				$table = $this->tables[$i];
				$source = $table['source'];
				$target = $table['target'];
                
                $target = $target ? $target : $table['model'];
                
                if ( ! isset($this->target) ) {
                    $this->load->model($table['model'], $target, $this->target_db);
                }

				$this->show_progress_status($i+1, count($this->tables)+1, sprintf("%-10s : %-30s", "Baseline", $target));
				if ( method_exists($this->$target, 'baseline_values') ) {
					$this->$target->baseline_values();
				}
				
				

			}
			
			$this->show_progress_status($i+1, count($this->tables)+1, sprintf("%-10s : %-30s", "Baseline", 'Completed'));
			
			//$this->reset_acl_restricted_resource();
		//}
		//catch (Exception $e) {
			//echo 'Caught exception: ', $e->getMessage(), PHP_EOL;
		//}
		
		print("\n");
	}
    
    // alias/shortcode for reset_acl_restricted_resource
    public function reset_acl() {
        $this->reset_acl_restricted_resource();
    }
	
	private function reset_acl_restricted_resource() {
		//printf("Generating default: %30s", "sip_acl_restricted_resource");
		//var_dump($this->target_db);die;
        
		//$this->target_db->query("TRUNCATE TABLE `sip_acl_restricted_resource`");
		//var_dump($this->db); die;
		$groups = $this->db->get('sip_groups')->result_array();
		$resource = $this->db->get('sip_acl_resource')->result_array();
	
		$progress = 1;
		$total = (count($groups) * count($resource));
		for ( $i = 0; $i < count($groups); $i++ ) {
			
			if ( $groups[$i]['name'] == 'admin' ) {
				continue;
			}
			for ( $j = 0; $j < count($resource); $j++ ) {
				$r = new Model\Acl_restricted_resource();
				$r->resource_id = $resource[$j]['id'];
				$r->group_id    = $groups[$i]['id'];
				$r->save();
				
				$this->show_progress_status(++$progress, $total, sprintf("%-10s : %-30s", "ACL", $groups[$i]['name'].' ('.$resource[$j]['code'].')'));
			}
			
			$this->show_progress_status(++$progress, $total, sprintf("%-10s : %-30s", "ACL", $groups[$i]['name']));
		}
		
		$this->show_progress_status($total, $total, sprintf("%-10s : %-30s", "ACL", 'Completed'));
		
		//printf("%30s".PHP_EOL, 'done');
	}
	
	public function additional() {

		printf("Additional:\n");
		for ( $i = 0; $i < count($this->additional); $i++ ) {
			$table = $this->additional[$i];
			$source = $table['source'];
			$target = $table['target'];
			
			printf("Loading model: %-30s", $target);
			$this->load->model($table['model'], $target, $this->target_db);
			print("\n");
		}
		//print("\n");
		
		//echo "Installing, please wait...".PHP_EOL;
		
		for ( $i = 0; $i < count($this->additional); $i++ ) {
			$table = $this->additional[$i];
			$source = $table['source'];
			$target = $table['target'];
			
			printf("Installing additional table: %-30s\n", $target);

			$this->$target->create_table();
			
			if ( method_exists($this->$target, 'migrate_data') ) {
				$this->$target->migrate_data($this->target_db, $source, $target);
			}

			//print("\n");
		}

		//print("\n");
	}
	
	public function migrate_admin_document() {
		$this->sip_admin_document->migrate();
	}
	
	// call model function
	public function model($model_name = null, $model_function = null) {
        
        if( !$model_name ) {
            $this->help();
            return;
        }
        
        $model_name = str_replace('-', '/', $model_name);
        
        echo "Load model: $model_name".PHP_EOL;
		$this->load->model($model_name, $model_name, $this->target_db);
		
		if( $model_function ) {
			if ( method_exists($this->$model_name, $model_function) ) {
                echo "Execute: $model_name->$model_function";
				$this->$model_name->$model_function();
			}
		}
	}
}
