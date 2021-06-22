<?php namespace Model\Users;

use \Gas\Core;
use \Gas\ORM;

class Groups extends ORM {
	
	public $table = 'sip_users_groups';
	
	public $primary_key = 'id';
	
	public $foreign_key = array(
		'\\model\\users' => 'user_id',
		'\\model\\groups' => 'group_id'
	);
	
	function _init() {
		self::$relationships = array(
			'users' => ORM::belongs_to('\\Model\\Users'),
			'groups' => ORM::belongs_to('\\Model\\Groups'),
		);
		
		self::$fields = array(
			'id'       => ORM::field('auto[3]'),
			'user_id'  => ORM::field('int[11]'),
			'group_id' => ORM::field('int[11]'),
		);
	}
}