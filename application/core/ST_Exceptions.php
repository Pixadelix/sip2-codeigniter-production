<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class ST_Exceptions extends CI_Exceptions {
	
	private $CI;

	public function __construct() {
		parent::__construct();

		$this->CI =& get_instance();
		$this->CI->data['PAGE_TITLE'] = 'An Error has occured';
		$this->CI->data['DEFAULT_PAGE_TITLE'] = PROJECT_NAME;
	}

	public function show_error($heading, $message, $template = '/adminlte/errors/html/error_general', $status_code = 500) {
		$ci = $this->CI;
		
		if(!$ci) {
			return parent::show_error($heading, $message, $template, $status_code);
		} else {
			if (!$page = $ci->uri->uri_string()) {
				$page = 'home';
			}
            
            $mode = is_cli() ? '/errors/cli' : '/adminlte/errors/html';
			
			switch($status_code) {
				case 403:
					$heading = 'Access Forbidden';
					$template = '/adminlte/errors/html/error_general';
                    $template = "$mode/error_general";
					break;
				case 404:
					$heading = 'Page Not Found';
					$template = '/adminlte/errors/html/error_404';
                    $template = "$mode/error_404";
					break;
				case 422:
					$heading = 'Unprocessable Entity';
					$template = '/adminlte/errors/html/error_general';
                    $template = "$mode/error_general";
					break;
				case 500:
					$heading = 'What? What did I just say?';
					$template = '/adminlte/errors/html/error_500';
                    $template = "$mode/error_500";
					break;
				case 503:
					$heading = 'Undergoing Maintenance';
					$template = '/adminlte/errors/html/error_general';
					break;
			}
			log_message('error', $status_code . ' ' . $heading . ' --> '. $page);

			if(is_array($message)) {
				$message = '<p>'.implode('</p><p>', $message).'</p>';
			}
		
			$ci->data['status_code'] = $status_code;
			$ci->data['heading'] = $heading;
			$ci->data['message'] = $message;
		
			$theme = 'adminlte';
//			$tpl = $ci->dashboard($template, 'adminlte', true);

//			echo $tpl;

			echo $this->CI->load->view("/adminlte/matrix/meta_header", $this->CI->data, true);
			echo $this->CI->load->view($template, $this->CI->data, true);
			echo $this->CI->load->view("/adminlte/matrix/meta_footer", $this->CI->data, true);
			return;
		}

        //return parent::show_error($heading, $message, 'error_general', $status_code);
		
	}


	public function show_404($page = '', $log_error = TRUE) {
		
		$this->CI->output->set_status_header('404'); 
		
		echo $this->CI->load->view("/adminlte/matrix/meta_header", $this->CI->data, true);
		echo $this->CI->load->view("/adminlte/errors/html/error_404", $this->CI->data, true);
		echo $this->CI->load->view("/adminlte/matrix/meta_footer", $this->CI->data, true);
		
	}
}

?>