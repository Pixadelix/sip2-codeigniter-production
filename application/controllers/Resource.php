<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Resource extends ST_Controller {
	
	public function __construct() {
		parent::__construct();
        $this->output->enable_profiler(false);
		$this->restricted();
	}
	
    public function index() {
        // do not use, use script handler instead
        die;
    }
    
    public function style(
        $path1 = null,
        $path2 = null,
        $path3 = null,
        $path4 = null,
        $path5 = null,
        $path6 = null
    ) {
        $path = $path1
            .($path2?"/$path2":'')
            .($path3?"/$path3":'')
            .($path4?"/$path4":'')
            .($path5?"/$path5":'')
            .($path6?"/$path6":'')
        ;

        $this->data['path'] = $path;
        $this->load->view($path, $this->data);
	}
    
	public function script(
        $path1 = null,
        $path2 = null,
        $path3 = null,
        $path4 = null,
        $path5 = null,
        $path6 = null
    ) {
        $path = $path1
            .($path2?"/$path2":'')
            .($path3?"/$path3":'')
            .($path4?"/$path4":'')
            .($path5?"/$path5":'')
            .($path6?"/$path6":'')
        ;

        $finfo = pathinfo($path);
        $this->data['path'] = $path;
        switch ( $finfo['extension'] ) {
            case 'png':
                $path = APPPATH.'views/'.$path;
                $fp = fopen($path, 'rb');
                #die(var_dump($fp));
                header('Content-Type: image/png');
                #header("Content-Length: " . filesize($path));
                fpassthru($fp);
                break;
            case 'js':
            default:
                header('Content-Type: text/javascript');
                $this->load->view($path, $this->data);
                break;
        }
	}
    
    public function splash($code = 'default') {
        if($spinner_page == 'sinal'){
            $spinner_page = '/spinner/signal';
        } else {
            $spinner_page = "/spinner/$spinner_page/$spinner_page";
        }
        $this->load->view($spinner_page);
    }
    
    public function slider($code = 'default') {
        
    }

}   