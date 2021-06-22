<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Digimag_manager extends ST_Controller {
	
	public function __construct() {
		parent::__construct();
		
		$this->data['PAGE_TITLE'] = 'Portfolio';
		$this->breadcrumbs->push('Portfolio', '/content/portfolio');
        $this->breadcrumbs->push('Flipmag', '/content/portfolio/digimag');
		
	}
	
	public function index($year = null, $month = null, $date = null, $post_name = null) {
        $this->restricted( array('admin', 'digimag') );
		$this->include_datatables_assets(true);
		$this->enqueue_resource(array(
			'/resource/script/adminlte/content/portfolio/digimag/js/digimag.php',
		));
		$this->dashboard('adminlte/content/portfolio/digimag/index');
	}
	
	public function get($id1 = null, $id2 = null) {
        $this->restricted( array('admin', 'digimag') );
        parent::get();
		$this->load->model('de/content/portfolio/Digimag_datatable');
		$this->Digimag_datatable->get($id1, $id2);
	}
}


