<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Archived_admdoc extends ST_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->restricted('admin');
		$this->breadcrumbs->push('Settings', '/settings');
	}
	
		
	public function index()
	{
        $this->include_datatables_assets(true);
        $this->enqueue_resource(array(
			'/resource/script/adminlte/setting/admdoc/js/admdoc.php',
		));
        
		$this->dashboard('adminlte/setting/admdoc/index');
	}
    
    public function get($id = null) {
		parent::get();
		$this->load->model('de/officeadm/AdminDocumentArchive_datatable', 'admdoc');
		$this->admdoc->get();
	}
	
    public function archive() {
        return;
        $sql = "
        INSERT IGNORE INTO `sip_admin_document_archive` (
            `id`,
            `type`,
            `group`,
            `refcode`,
            `refdate`,
            `notes`,
            `content`,
            `status`,
            `create_by`,
            `create_at`,
            `update_by`,
            `update_at`)
        SELECT * FROM `sip_admin_document`";
        $this->db->query($sql);
        
        $moved_to_archived = $this->db->affected_rows();
        
        $sql = "DELETE FROM `sip_admin_document`";
        $this->db->query($sql);
        
        $deleted_rows = $this->db->affected_rows();
        
        $sql = "ALTER TABLE `sip_admin_document` AUTO_INCREMENT = 1";
        $this->db->query($sql);
        
        echo $this->json_response(array('Archived' => $moved_to_archived, 'Deleted' => $deleted_rows));
    }
}
