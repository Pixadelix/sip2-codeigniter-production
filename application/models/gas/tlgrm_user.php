<?php

namespace Model;

use \Gas\Core;
use \Gas\ORM;

class Tlgrm_user extends ORM {
	
	public $table = TELEGRAM_TABLE_PREFIX.'user';
	
	public $primary_key = 'id';
	
	public $foreign_key = array(
		'\\model\\users' => 'username',
		'\\model\\tlgrm_user_chat' => 'id',
	);
	
	function _init() {
		
		self::$relationships = array(
			'users' => ORM::has_one('\\Model\\Users'),
			'chat' => ORM::has_one('\\Model\\Tlgrm_user_chat'),
		);
		
		self::$fields = array(
			'id'                     => ORM::field('auto'),
			'username'               => ORM::field('string'),

			'created_at'   => ORM::field('timestamp'),
			'updated_at'   => ORM::field('timestamp')			
			
		);
		
		$this->ts_fields = array('[created_at]', 'updated_at');
	}
}


