<?php namespace Model\Users;

use \Gas\Core;
use \Gas\ORM;

class Projects extends ORM {
	
	public $table = 'sip_users_projects';
	
	public $primary_key = 'id';
	
	public $foreign_key = array(
		'\\model\\users' => 'user_id',
		'\\model\\projects' => 'project_id'
	);
	
	function _init() {
		self::$relationships = array(
			'users' => ORM::belongs_to('\\Model\\Users'),
			'projects' => ORM::belongs_to('\\Model\\Projects'),
		);
		
		self::$fields = array(
			'id'       => ORM::field('auto[3]'),
			'user_id'  => ORM::field('int[11]'),
			'project_id' => ORM::field('int[11]'),
		);
	}
}