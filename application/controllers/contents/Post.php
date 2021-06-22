<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Post extends ST_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->restricted( 'open-web-services' );
		
	}
	
	public function index($year = null, $month = null, $date = null, $id = null, $post_name = null) {

		if ( !$year || !$month || !$date || !$id || !$post_name ) {
			show_404();
			return;
		}
		
		$post = null;
		if ( is_numeric($id) ) {
			$post = Model\Posts::find($id);
		} 

		if ( ! $post ) show_404();
		
		$this->enqueue_scripts('../../js/html5lightbox/html5lightbox.js');
		
		$post_attachment = Model\Posts::find($post->post_parent);

		//if ( ! $post_attachment )  show_404();
		$this->data['post'] = $post;
		$this->data['post_attachment'] = $post_attachment;
		$this->dashboard('adminlte/content/post/view');
	}
}