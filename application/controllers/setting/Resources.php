<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Resources extends ST_Controller {
    
	public function __construct() {
		parent::__construct();
		
		$this->data['PAGE_TITLE'] = 'Menu Editor';
		
		//$this->restricted(array('menu-editor', 'insert'));

		$this->breadcrumbs->push('Resources Editor', '/setting/menu');
        
        $this->load->model('de/setting/Acl_resource_datatable', 'resources');

	}
	
		
	public function index()
	{
		$acl_resource = Model\Acl_resource::result()->order_by('position asc')->all()->to_array();
		
		$this->data['acl_resource'] = $acl_resource;
		$this->dashboard('adminlte/setting/resources/index');
	}
	
	public function search()
	{
		$needle = $this->input->get('table_search');
		if(!$needle) {
			redirect('/setting/menu', 'refresh');
		}
		$acl_resource = Model\Acl_resource::result()
			->like('label', $needle)
			->or_like('code', $needle)
			->or_like('url', $needle)
			->order_by('position asc')
			->get()
			->to_array();
		
		$this->data['acl_resource'] = $acl_resource;
		$this->dashboard('adminlte/setting/resources/index');
	}
	
	public function create_menu() {
		$this->breadcrumbs->push('Add new Resource', "/setting/resources/create_menu");
		
		
		if ( isset($_POST) && !empty($_POST) ) {
			$acl_resource = Model\Acl_resource::make($_POST);
			$last_menu = Model\Acl_resource::last('position');
			$acl_resource->position = $last_menu->position + 1;
			if ($acl_resource->save(true) ) {
				$last_acl_resource_id = Model\Acl_resource::last_created()->id;
				// restrice new menu to all groups except for admin
				$all_groups = Model\Groups::where_not_in('id', 1)->get();
				
				for($i=0; $i<count($all_groups); $i++){
					$data = array(
						'resource_id' => $last_acl_resource_id,
						'group_id' => $all_groups[$i]->id,
					);
					$acl_restricted_resource = Model\Acl_restricted_resource::make($data)->save(true);
					//var_dump($acl_restricted_resource);
					
				}
				//die;
				redirect('/setting/resources', 'refresh');
			};
		}
		
		$this->dashboard('/adminlte/setting/resources/create_menu');
	}
	
	public function edit($id) {
		$this->breadcrumbs->push('Edit Resource', "/setting/resources/edit/$id");
		
		if ( isset($_POST) && !empty($_POST) ) {
			if($id != $this->input->post('id')) {
				show_error('Invalid request.');
				return;
			}
		}
		
		$acl_resource = Model\Acl_resource::find($id);
		if ( !$acl_resource ) {
			show_404();
			exit();
		}
		
		if (isset($_POST) && !empty($_POST)) {
			//var_dump($_POST); die;
			$acl_resource->parent_id = $_POST['parent_id'];
			$acl_resource->code      = $_POST['code'];
			$acl_resource->label     = $_POST['label'];
			$acl_resource->url       = $_POST['url'];
			$acl_resource->menu_type = $_POST['menu_type'];
			$acl_resource->icon      = $_POST['icon'];
			
			
			if ( $acl_resource->save(true) ) {
				set_message_success('Record saved');
				redirect('/setting/resources', 'refresh');
			}else{
				set_message_error($acl_resource->errors);
			}
		}

		$this->data['acl_resource'] = $acl_resource;
		$this->dashboard('/adminlte/setting/resources/edit');
	}
	
	public function rearrange() {
		$acl_resource = Model\Acl_resource::order_by('position', 'asc')->get();
		
		if(!$acl_resource) {
			redirect('/setting/resources', 'refresh');
			return;
		}
		
		$i = 0;
		foreach($acl_resource as $acl):
			$acl->position = $i;
			$acl->save();
			$i++;
		endforeach;
		
		redirect('setting/resources', 'refresh');
	}
	
	public function move($menu_id, $direction) {
		$acl_resource = Model\Acl_resource::find($menu_id);
		
		if( !$acl_resource ) {
			show_404();
			return;
		}
		
		if(-1 == $direction && $acl_resource->position <= 0 ) {
			// position already at bottom
			redirect('/setting/resources', 'refresh');
			return;
		}
		
		$swap = Model\Acl_resource::where(array('position' => $acl_resource->position + $direction))->first();
		
		if(!$swap) {
			// no swap found, skipping
			redirect('/setting/resources', 'refresh');
			return;
		}
		
		$buffer_pos = $acl_resource->position;
		$acl_resource->position = $swap->position;
		$swap->position = $buffer_pos;
		
		$acl_resource->save();
		$swap->save();
		
		redirect('/setting/resources', 'refresh');
	}
	
	public function up($menu_id) {
		$this->move($menu_id, -1);
	}
	
	
	public function down($menu_id) {
		$this->move($menu_id, 1);
	}
	
	public function delete($menu_id) {
		$acl_resource = Model\Acl_resource::find($menu_id);
		$acl_resource->delete();
		redirect('/setting/resources', 'refresh');
	}
    
    private function _ra($parent, $code, $label, $url, $icon, $menu_type = null, $groups = null) {
        if ( ! $menu_type ) {
            $menu_type = $this->resources::TYPE_SIDEBAR;
        }
        return array(
            'parent'         => $parent,
            'code'           => $code,
            'label'          => $label,
            'url'            => $url,
            'icon'           => $icon,
            'menu_type'      => $menu_type,
            'enabled_groups' => $groups,
        );
    }
    
    public function register() {
        $this->must_cli_mode();
        $this->restricted('admin');
        echo "Registering Resources\n";
        
        $this->db->query("TRUNCATE TABLE `sip_acl_resource`");
        $this->db->query("TRUNCATE TABLE `sip_acl_restricted_resource`");
        
        $E      = array('editor');
        $R      = array('reporter');
        $F      = array('fotografer');
        $D      = array('designer');
        $O      = array('officeadm');
        $P      = array('portfolio');
        $EO     = array_merge($E, $O);
        $ERFDO  = array_merge($E,$R,$F,$D,$O);
        $ERFDOP = array_merge($ERFDO, $P);
        
        
        $resources = array(
            $this->_ra(null, 'root-sidebar', 'Application Menu', null, 'fa-bars', $this->resources::TYPE_SIDEBAR, $ERFDOP),
                $this->_ra('root-sidebar', 'settings', 'Settings', NULL, 'fa-gear', $this->resources::TYPE_SIDEBAR, $E),
                    //$this->_ra('settings', 'users', 'Users', '/auth', 'fa-male'),
                    $this->_ra('settings', 'users-management', 'User Management', '/setting/users', 'fa-male'),
                    $this->_ra('settings', 'acl', 'Access Control', '/setting/acl', 'fa-unlock-alt'),
                    $this->_ra('settings', 'resource-editor', 'Resource Editor', '/setting/resources', 'fa-cube'),
                    $this->_ra('settings', 'clients', 'Clients', '/setting/clients', 'fa-globe', $this->resources::TYPE_SIDEBAR, $E),
                    $this->_ra('settings', 'projects', 'Projects', '/setting/projects', 'fa-briefcase', $this->resources::TYPE_SIDEBAR, $E),
                    $this->_ra('settings', 'task-types', 'Task types', '/setting/task_types', 'fa-arrows-alt'),
                    $this->_ra('settings', 'archived-admdoc', 'Archived Documents', '/setting/archived_admdoc', 'fa-archive'),
                    $this->_ra('settings', 'cron', 'Cron Manager', '/cron', 'fa-hourglass-half'),
            
                $this->_ra('root-sidebar', 'editorial', 'Editorial', '/editorial', 'fa-keyboard-o', $this->resources::TYPE_SIDEBAR, $EO),
					$this->_ra('editorial', 'workspace', 'All Workspace', '/editorial/workspace', 'fa-table', $this->resources::TYPE_SIDEBAR, $EO),
					$this->_ra('editorial', 'calendar', 'Calendar', '/dashboard/dashboard/dev', 'fa-calendar'),

				$this->_ra('root-sidebar', 'project-status', 'Project Status', '/project_status', 'fa-line-chart'),
					$this->_ra('project-status', 'workspace-project-status', 'All Projects', '/project_status', 'fa-briefcase'),
            
				$this->_ra('root-sidebar', 'office-admin', 'Office Admin', '/officeadm', 'fa-building', $this->resources::TYPE_SIDEBAR, $O),
					$this->_ra('office-admin', 'reimburse-mgr', 'Reimburse Manager', '/officeadm/reimburse', 'fa-calculator', $this->resources::TYPE_SIDEBAR, $O),
					$this->_ra('office-admin', 'doc-admin', 'Document', '/officeadm/document', 'fa-paper-plane', $this->resources::TYPE_SIDEBAR, $O),
					//$this->_ra('office-admin', 'services', 'Product Services', '/product_services/products', 'fa-coffee', $this->resources::TYPE_SIDEBAR, $O),
                    $this->_ra('office-admin', 'voucher', 'Voucher Manager', '/officeadm/voucher_manager', 'fa-ticket', $this->resources::TYPE_SIDEBAR, $O),

				$this->_ra('root-sidebar', 'my-menu', 'My', '', 'fa-child', $this->resources::TYPE_SIDEBAR, $ERFDO),
					$this->_ra('my-menu', 'reimburse', 'Reimburse', '/my/my_reimburse', 'fa-calculator', $this->resources::TYPE_SIDEBAR, $ERFDO),
					$this->_ra('my-menu', 'my-tasks', 'Tasks', '/my/my_task', 'fa-tasks', $this->resources::TYPE_SIDEBAR, $ERFDO),
                    $this->_ra('my-menu', 'my-grab-voucher', ' Grab for Business', '/my/my_grab', 'fa-motorcycle', $this->resources::TYPE_SIDEBAR, $ERFDO),
            
                $this->_ra('root-sidebar', 'contents-mgr', 'Contents Manager', '/contents', 'fa-briefcase'),
					$this->_ra('contents-mgr', 'articles', 'Article Manager', '/content', 'fa-coffee'),
                    $this->_ra('contents-mgr', 'splash-screen', 'Splash Manager', '/contents/splash', 'fa-hourglass'),
                    //$this->_ra('contents-mgr', 'slider-screen', 'Slider Manager', '/contents/slider', 'fa-image'),
                    $this->_ra('contents-mgr', 'digimag-manager', 'Digimag Manager', '/contents/portfolio/digimag_manager', 'fa-book'),
            
                $this->_ra('root-sidebar', 'portfolio', 'Portfolio', null, 'fa-briefcase', $this->resources::TYPE_SIDEBAR, $ERFDOP),
                    $this->_ra('portfolio', 'digimag', 'Digital Magazines', '/our_portfolio/digimag', 'fa-book', $this->resources::TYPE_SIDEBAR, $ERFDOP),
            
            $this->_ra(null, 'root-navbar', 'Navbar Menu', null, 'fa-bars', $this->resources::TYPE_NAVBAR),
                /*
                $this->_ra('root-navbar', 'accounting', 'Accounting', '/accounting', 'fa-calculator', $this->resources::TYPE_NAVBAR),
                    $this->_ra('accounting', 'sales', 'Sales', '/accounting/sales', 'fa-dot-circle-o', $this->resources::TYPE_NAVBAR),
                    $this->_ra('accounting', 'purchase', 'Purchase', '/accounting/purchase', 'fa-dot-circle-o', $this->resources::TYPE_NAVBAR),
                    $this->_ra('accounting', 'journal', 'Journal', '/accounting/journal', 'fa-dot-circle-o', $this->resources::TYPE_NAVBAR),
            
                $this->_ra('root-navbar', 'hr', 'HR', '/hr', 'fa-users', $this->resources::TYPE_NAVBAR),
                    $this->_ra('hr', 'employee', 'Employee', '/hr/employee', 'fa-users', $this->resources::TYPE_NAVBAR),
                    $this->_ra('hr', 'payroll', 'Payroll', '/hr/payroll', 'fa-money', $this->resources::TYPE_NAVBAR),
                    
                $this->_ra('root-navbar', 'reporting', 'Reporting', '/reporting', 'fa-bar-chart', $this->resources::TYPE_NAVBAR),
                    $this->_ra('reporting', 'ledger', 'General Ledger', '/reporting/gl', 'fa-dot-circle-o', $this->resources::TYPE_NAVBAR),
                    $this->_ra('reporting', '-', '-', null, 'null', $this->resources::TYPE_NAVBAR),
                    $this->_ra('reporting', 'statement', 'Statement', '/statement', 'fa-pie-chart', $this->resources::TYPE_NAVBAR),
                        $this->_ra('statement', 'income', 'Income Statement', '/reporting/is', 'fa-bar-chart', $this->resources::TYPE_NAVBAR),
                        $this->_ra('statement', 'balance', 'Balance Statement', '/reporting/bs', 'fa-dot-circle-o', $this->resources::TYPE_NAVBAR),
            
                $this->_ra('root-navbar', 'finance-settings', 'Settings', '/finance/settings', 'fa-gear', $this->resources::TYPE_NAVBAR),
                    $this->_ra('finance-settings', 'finance-setting-accounts', 'Finance Accounts Setting', '/finance/settings/accounts', 'fa-briefcase', $this->resources::TYPE_NAVBAR),
                    //$this->_ra('finance-settings', 'Finance Accounts Setting', '/finance/settings/accounts', 'fa-briefcase', $this->resources::TYPE_NAVBAR),
                $this->_ra('root-navbar', 'news', 'News', '/news', 'fa-newspaper-o', $this->resources::TYPE_NAVBAR),
                */
            
                $this->_ra('root-navbar', 'eproc', 'E-Procurement', '/eproc', 'fa-bank', $this->resources::TYPE_NAVBAR),
                    $this->_ra('eproc', 'eproc-settings', 'Monitoring and Keywords Setup', '/eproc', 'fa-gears', $this->resources::TYPE_NAVBAR),
                    $this->_ra('eproc', '-', '-', null, 'null', $this->resources::TYPE_NAVBAR),
                    $this->_ra('eproc', 'eproc-admin-settings', 'Administrator', null, 'fa-gear', $this->resources::TYPE_NAVBAR),
                        $this->_ra('eproc-admin-settings', 'eproc-lpse', 'LPSE Manager', '/eprocs/lpse', 'fa-building', $this->resources::TYPE_NAVBAR),
                        $this->_ra('eproc-admin-settings', 'eproc-package', 'Package Manager', '/eprocs/package', 'fa-suitcase', $this->resources::TYPE_NAVBAR),
                        $this->_ra('eproc-admin-settings', 'eproc-subscriber', 'Subscriber Manager', '/eprocs/subscribers', 'fa-users', $this->resources::TYPE_NAVBAR),
            
            $this->_ra(null, 'web-services', 'Web Services', '', 'fa-gears', $this->resources::TYPE_WEBSVC, $ERFDO),
				$this->_ra('web-services', 'user-web-services', 'User Web Services', '', 'fa-cloud-download', $this->resources::TYPE_WEBSVC, $ERFDO),
                    $this->_ra('user-web-services', 'request-grab-code', 'Request Grab Code', '/voucher/request_grab', 'fa-motorcycle', $this->resources::TYPE_WEBSVC, $ERFDO),
				$this->_ra('web-services', 'open-web-services', 'Open Web Services', '', 'fa-cloud', $this->resources::TYPE_WEBSVC, $ERFDO),
        );
        
        //var_dump($resources);
        
        foreach ( $resources as $resource ) {
            Model\Acl_resource::register($resource);
        }
    }
    
    public function acl_check($first_name = null) {
        $this->must_cli_mode();

        $users = null;
        if ( $first_name ) {
            $users = Model\Users::find_by_first_name($first_name);
        } else {
            $users = Model\Users::where(array('active' => 1))->get();
        }
        
        if ( ! $users ) {
            return;
        }

        foreach( $users as $user ) {
            
            /*
            $groups = null;
            if ( !$group_name ) {
                $groups = Model\Groups::all();
            } else {
                $groups = Model\Groups::find_by_name($group_name);
            }
            */
            
            $groups = $user->groups();

            $resources = Model\Acl_resource::all();

            //var_dump($resources); die;

            foreach ( $groups as $group ) {

                //var_dump($group->restricted_resources());
                //continue;

                //echo sprintf("%-s:", $group->name).PHP_EOL;

                $restricted_resources = Model\Acl_restricted_resource::where(array('group_id' => $group->id))
                    ->get()
                    ;

                if ( ! $restricted_resources ) {
                    continue;
                }

                foreach( $resources as $r ) {
                    $access = true;
                    foreach( $restricted_resources as $restricted_resource ) {
                        if ( $restricted_resource->resource()->id == $r->id ) {
                            $access = false;
                            break;
                        }
                    }
                    echo sprintf("[%s][%s][%s]", $user->first_name, $group->name, ($access ? "\033[32m".$r->code."\033[0m" : "\033[31m".$r->code."\033[0m")).PHP_EOL;
                    //usleep(100000);
                }

                echo PHP_EOL;

            }
        }
    }
	
}