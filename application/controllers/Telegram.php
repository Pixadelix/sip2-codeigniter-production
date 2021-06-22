<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Telegram extends ST_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->data['PAGE_TITLE'] = 'Telegram';
		$this->breadcrumbs->push('Telegram', '/telegram');
	}
	
		
	public function index()
	{
		$this->restricted( 'admin' );
		//$this->telegram_send_message('yusar', 'hai');
		
		$this->dashboard('adminlte/blank');
	}
	
	public function install() {
		define('INSTALL', true);
		$this->must_cli_mode();
		$tables = array(
			array('model' => 'de/telegram/User_datatable'),
			array('model' => 'de/telegram/Chat_datatable'),
			array('model' => 'de/telegram/User_chat_datatable'),
			array('model' => 'de/telegram/Inline_query_datatable'),
			array('model' => 'de/telegram/Chosen_inline_result_datatable'),
			array('model' => 'de/telegram/Message_datatable'),
			array('model' => 'de/telegram/Callback_query_datatable'),
			array('model' => 'de/telegram/Edited_message_datatable'),
			array('model' => 'de/telegram/Telegram_update_datatable'),
			array('model' => 'de/telegram/Conversation_datatable'),
			array('model' => 'de/telegram/Botan_shortener_datatable'),
			array('model' => 'de/telegram/Request_limiter_datatable'),
		);
		
		for ( $i = 0; $i < count($tables); $i++ ) {
			$table = $tables[$i];
			$this->load->model($table['model']);
			
			$this->show_progress_status($i+1, count($tables), $table['model']);
			
		}
	}
    
    public function register_resource() {
        $this->must_cli_mode();
        
        Model\Acl_resource::create_resource(
            'root-menu',
            'telegram',
            'Telegram',
            null,
            'fa-telegram'
        );
        
        Model\Acl_resource::create_resource(
            'telegram',
            'telegram-user',
            'Users',
            '/telegram/user',
            'fa-user-circle-o'
        );
    }
	
	public function get_updates() {
		$this->must_cli_mode();
		$this->init_telegram();
		$this->telegram_manager->getUpdates();
	}
	
	public function user() {
        $this->restricted( 'admin' );
		$this->data['PAGE_TITLE'] = 'Telegram User';
		$this->breadcrumbs->push('Telegram User', '/telegram/user');
		$this->include_datatables_assets(true);
		$this->enqueue_resource(array(
			'/resource/script/adminlte/telegram/user/js/user.js',
		));
		
		$this->dashboard('adminlte/telegram/user/index');
	}
	
	public function get_user() {
        $this->restricted( 'admin' );
		$this->load->model('de/telegram/User_datatable');
		$this->User_datatable->get();
	}

}