<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Our_portfolio extends ST_Controller {
	
	public function __construct() {
		parent::__construct();
		
		$this->data['PAGE_TITLE'] = 'Portfolio';
		$this->breadcrumbs->push('Portfolio', '/content/portfolio');
        $this->breadcrumbs->push('Digimag', '/content/portfolio/digimag');
		
	}
	
    public function digimag() {
        $this->restricted( 'digimag' );
        
        $this->enqueue_resource(array(
			'/resource/script/adminlte/content/portfolio/digimag/js/view.php',
		));
        
        $this->load->model('de/content/Posts_datatable');
        
        $digimags = Model\Posts::order_by('post_date', 'desc')
            ->where(array(
                'post_status' => $this->Posts_datatable::PUBLISHED,
                'post_type'   => $this->Posts_datatable::TYPE_FLIPMAG
            ))
            ->get();
        
        $this->data['digimags'] = is_array($digimags) ? $digimags : array($digimags);
            
        $this->dashboard('adminlte/content/portfolio/digimag/view');
    }	
}


