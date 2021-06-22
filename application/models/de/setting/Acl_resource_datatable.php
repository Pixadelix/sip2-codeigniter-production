<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// DataTables PHP library and database connection
//include_once APPPATH . DATATABLE_EDITOR;

// Alias Editor classes so they are easy to use
use
	DataTables\Editor,
	DataTables\Editor\Field,
	DataTables\Editor\Format,
	DataTables\Editor\Mjoin,
	DataTables\Editor\Options,
	DataTables\Editor\Upload,
	DataTables\Editor\Validate;
	
load_class('Editor_Model', 'core');
class Acl_resource_datatable extends CI_Editor_Model {
	
	public $table = 'sip_acl_resource';
	
	public function __construct() {
		
		parent::__construct();
		$this->create_table();
		$this->init_editor();
		
	}

	public function create_table() {
		
		if ( $this->production() ) return;
		
		$this->db_datatables->sql(
			"CREATE TABLE IF NOT EXISTS `$this->table` (
				`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
				`parent_id` int(11) UNSIGNED DEFAULT NULL,
				`code` varchar(50) NOT NULL,
				`label` varchar(255) NOT NULL,
				`url` varchar(255) DEFAULT NULL,
				`icon` varchar(50) DEFAULT NULL,
				`position` int(5) DEFAULT '0',
				`menu_type` varchar(20) NOT NULL DEFAULT 'core',
                UNIQUE( `code`),
				PRIMARY KEY (`id`)
			)" 
		);
	}
	
	public function baseline_values() {
		
		if ( $this->production() ) return;
		
		//printf("Generating baseline: %30s", $this->table);
		/*
		$this->db_datatables->sql("TRUNCATE TABLE `$this->table`");
		$this->db_datatables->sql(
			"INSERT IGNORE INTO `$this->table` (`parent_id`, `code`, `label`, `url`, `icon`, `position`, `menu_type`) VALUES
			(0, 'root-menu', 'Application Menu', '', 'fa-bars', 0, 'core'),
			
				(1, 'settings', 'Settings', NULL, 'fa-gear', 1, 'core'),
					(2, 'users', 'Users', '/auth', 'fa-male', 2, 'core'),
					(2, 'users-management', 'User Management', '/setting/users', 'fa-male', 3, 'core'),
					(2, 'acl', 'Access Control', '/setting/acl', 'fa-unlock-alt', 4, 'core'),
					(2, 'resource-editor', 'Resource Editor', '/setting/resources', 'fa-cube', 5, 'core'),
					(2, 'clients', 'Clients', '/setting/clients', 'fa-globe', 6, 'core'),
					(2, 'projects', 'Projects', '/setting/projects', 'fa-briefcase', 7, 'core'),
					(2, 'task-types', 'Task types', '/setting/task_types', 'fa-arrows-alt', 8, 'core'),

				(1, 'editorial', 'Editorial', '/editorial', 'fa-keyboard-o', 8, 'core'),
					(10, 'workspace', 'All Workspace', '/editorial/workspace', 'fa-table', 9, 'core'),
					(10, 'calendar', 'Calendar', '/dashboard/dashboard/dev', 'fa-calendar', 10, 'core'),

				(1, 'project-status', 'Project Status', '/project_status', 'fa-line-chart', 11, 'custom'),
					(13, 'workspace-project-status', 'All Projects', '/project_status', 'fa-briefcase', 12, 'core'),

				(1, 'office-admin', 'Office Admin', '/officeadm', 'fa-building', 13, 'core'),
					(15, 'reimburse-mgr', 'Reimburse Manager', '/officeadm/reimburse', 'fa-calculator', 14, 'core'),
					(15, 'doc-admin', 'Document', '/officeadm/document', 'fa-paper-plane', 15, 'core'),
					(15, 'services', 'Product Services', '/product_services/products', 'fa-coffee', 16, 'core'),

				(1, 'my-menu', 'My', '', 'fa-child', 17, 'core'),
					(19, 'reimburse', 'Reimburse', '/my/my_reimburse', 'fa-calculator', 18, 'core'),
					(19, 'my-tasks', 'Tasks', '/my/my_task', 'fa-tasks', 19, 'core'),

                (1, 'contents', 'Contents', '/contents', 'fa-briefcase', 20, 'core'),
					(22, 'content', 'Content', '/content', 'fa-coffee', 21, 'core'),
                    (22, 'splash-screen', 'Splash', '/contents/splash', 'fa-hourglass', 22, 'core'),
                    (22, 'slider-screen', 'Slider', '/contents/slider', 'fa-image', 23, 'core'),
					
					
			(0, 'web-services', 'Web Services', '', 'fa-gears', 24, 'core'),
				(26, 'user-web-services', 'User Web Services', '', 'fa-cloud-download', 25, 'core'),
				(26, 'open-web-services', 'Open Web Services', '', 'fa-cloud', 26, 'custom')
                
            

			;"
		);
        */

		//printf("%30s".PHP_EOL, 'done');
	}

	private function init_editor() {
		$this->editor = Editor::inst( $this->db_datatables, 'sip_acl_resource', 'id' )
			->fields(
				Field::inst( 'id' ),
				Field::inst( 'parent_id' ),
				Field::inst( 'code' ),
				Field::inst( 'label' ),
				Field::inst( 'url' ),
				Field::inst( 'icon' ),
				Field::inst( 'position' ),
				Field::inst( 'menu_type' )
			)
		;
	}

}