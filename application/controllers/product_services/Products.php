<?php
defined('BASEPATH') OR exit('No direct script access allowed');



class Products extends ST_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->data['PAGE_TITLE'] = 'Product Services';
	}
	
	public function index() {
		$this->dashboard('/adminlte/development');
	}

}