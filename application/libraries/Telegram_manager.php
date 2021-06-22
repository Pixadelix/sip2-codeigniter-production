<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * CodeIgniter library handle for Telegram
 * 
 */

require_once APPPATH . 'third_party/telegram/vendor/autoload.php';

class Telegram_manager {
	
	private $_bot_api_key = null;
	private $_bot_username = null;
	
	public $telegram = null;
	public $ci = null;
    
    public function __construct($params) {
		$this->ci =& get_instance();
		//$this->ci->restricted();
		$this->_init($params['bot_api_key'], $params['bot_username']);
	}
	
	private function _init($bot_api_key, $bot_username, $mysql_credentials = null) {
		
		if ( $this->telegram ) return;
		
		$this->_bot_api_key = $bot_api_key;
		$this->_bot_username = $bot_username;
		$this->_mysql_credentials = $mysql_credentials;
		
		try {
			$this->telegram = new Longman\TelegramBot\Telegram(
				$this->_bot_api_key,
				$this->_bot_username
			);

			$this->telegram->enableExternalMySql($this->ci->db->conn_id, TELEGRAM_TABLE_PREFIX);
		}
		catch ( Longman\TelegramBot\Exception\TelegramException $e ) {

		}
	}
	
	public function getUpdates() {
		try {
			$this->telegram->handleGetUpdates();
		}
		catch ( Longman\TelegramBot\Exception\TelegramException $e ) {
			var_dump($e->message);
		}
		
	}
	
	public function sendMessage($chat_id, $text, $parse_mode = 'HTML') {
		$this->ci->restricted();
		return Longman\TelegramBot\Request::sendMessage(['chat_id' => $chat_id, 'text' => $text, 'parse_mode' => $parse_mode]);
	}
	
	public function sendMessageByUsername($username, $text) {
		
		$username = (mb_substr($username, 0, 1) === '@') ? mb_substr($username, 1, strlen($username)) : $username;
		$tlgrm_user = Model\Tlgrm_user::find_by_username($username);
		
		if ( ! $tlgrm_user || !is_array($tlgrm_user) || count($tlgrm_user) <= 0 ) { return;	}
		
		//$user_chat = $tlgrm_user[0]->chat();
		
		//if ( ! $user_chat ) return;
		//var_dump($text);
		$this->sendMessage($tlgrm_user[0]->id, $text);
	}
    
}
/** End of file Telegram_manager.php **/
/** Location: ./application/libraries/Telegram_manager.php **/