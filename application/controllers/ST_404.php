<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class ST_404 extends ST_Controller 
{
    public function __construct() 
    {
        parent::__construct();
		$this->output->enable_profiler(false);
    } 

    public function index() 
    {
        $this->output->set_status_header('404'); 
        $data['content'] = 'error_404'; // View name 
        $this->matrix_page('/adminlte/errors/html/error_404');//loading in my template 
    }
} 
?> 