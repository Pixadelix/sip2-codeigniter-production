<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include_once('contents/Splash.php');

class Content extends ST_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->restricted( 'admin' );
		$this->data['PAGE_TITLE'] = 'Contents';
		$this->breadcrumbs->push('Contents', '/contents');
		
	}
	
	public function index($year = null, $month = null, $date = null, $post_name = null) {
		$this->include_datatables_assets(true);
		$this->enqueue_resource(array(
			'/resource/script/adminlte/content/js/post.js',
		));
		$this->dashboard('adminlte/content/post/index');
	}
	
	public function get($id1 = null, $id2 = null) {
		$this->load->model('de/content/Post_datatable');
		$this->Post_datatable->get($id1, $id2);
	}
	
}


