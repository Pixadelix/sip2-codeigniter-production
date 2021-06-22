<?php

namespace Model;

use \Gas\Core;
use \Gas\ORM;

class Users extends ORM {
	
	public $table = 'sip_users';
	
	public $primary_key = 'id';
	
	public $foreign_key = array(
		
		
		'\\model\\users\\groups' => 'user_id',
		'\\model\\gas\\users\\projects' => 'user_id',
		'\\model\\gas\\tasks' => 'user_id',
		
		'\\model\\users\\eproc_lpse' => 'user_id',
		'\\model\\users\\eproc_keywords' => 'user_id',
		
		
	);
	
	function _init() {
		
		self::$relationships = array(
			'groups' => ORM::has_many('\\Model\\Users\\Groups => \\Model\\Groups'),
			'projects' => ORM::has_many('\\Model\\Users\\Projects => \\Model\\Projects'),
			'tasks' => ORM::has_many('\\Model\\Tasks'),
			
			'monitored_lpses' => ORM::has_many('\\Model\\Users\\Eproc_lpse'),
			'eproc_keywords' => ORM::has_many('\\Model\\Users\\Eproc_keywords'),
		
		);
		
		self::$fields = array(
			'id' => ORM::field('auto'),
			'ip_address' => ORM::field('string'),
			'username' => ORM::field('string'),
			'first_name' => ORM::field('string'),
			'email' => ORM::field('string'),
			'phone' => ORM::field('string'),
			'telegram_username' => ORM::field('string'),
            'profile_photo' => ORM::field('int'),
            'created_on' => ORM::field('timestamp'),
		);
	}
}