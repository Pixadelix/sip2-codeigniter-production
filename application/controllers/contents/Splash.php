<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Splash extends ST_Controller {
	
	public function __construct() {
		parent::__construct();
		
	}
	
	public function index($year = null, $month = null, $date = null, $id = null, $post_name = null) {

		if ( $year && $month && $date && $id && $post_name ) {
			$this->_view($id, $post_name);
			return;
		}
		
		$this->restricted( 'admin' );
		$this->data['PAGE_TITLE'] = 'Splash Manager';
		$this->breadcrumbs->push('Splash', '/contents/splash');
		
		$this->include_datatables_assets(true);
		$this->enqueue_scripts(array(
			'https://cdn.rawgit.com/zenorocha/clipboard.js/v1.7.1/dist/clipboard.min.js',
		));
		
		$this->enqueue_resource(array(
			'/resource/script/adminlte/content/js/splash.js',
		));
		$this->dashboard('adminlte/content/splash/index');
	}
	
	public function get($id = null, $id2 = null) {
		$this->restricted( 'admin' );
		$this->load->model('de/content/Splash_datatable');
		$this->Splash_datatable->get($id, $id2);
	}

	private function _view($id, $name) {
		$this->output->enable_profiler(false);
		$splash = null;
		if ( is_numeric($id) ) {
			$splash = Model\Posts::find($id);
		} 

		if ( ! $splash ) show_404();
		$splash_attachment = Model\Posts::find($splash->post_parent);

		if ( ! $splash_attachment )  show_404();
		$this->data['splash'] = $splash;
		$this->data['splash_attachment'] = $splash_attachment;
		$this->load->view('splash/index', $this->data);
	}
}
