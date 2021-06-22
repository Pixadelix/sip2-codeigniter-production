<?php

namespace Model;

use \Gas\Core;
use \Gas\ORM;

class Tlgrm_user_chat extends ORM {
	
	public $table = TELEGRAM_TABLE_PREFIX.'user_chat';
	
	public $primary_key = 'user_id';
	
	public $foreign_key = array(
		'\\model\\tlgrm_user' => 'user_id'
	);
	
	function _init() {
		
		self::$relationships = array(
			'tlgrm_user' => ORM::belongs_to('\\Model\\Tlgrm_user'),
		);
		
		self::$fields = array(
			'user_id'                     => ORM::field('auto'),
			'chat_id'                     => ORM::field('string'),

		);
		
	}
}


