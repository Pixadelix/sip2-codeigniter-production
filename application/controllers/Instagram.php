<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Instagram extends ST_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->output->enable_profiler(false);
	}
	
	public function index()
	{
		$this->load->view('instagram');
	}
}
