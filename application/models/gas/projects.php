<?php

namespace Model;

use \Gas\Core;
use \Gas\ORM;

class Projects extends ORM {
	
	public $table = 'sip_projects';
	
	public $primary_key = 'id';
	
	public $foreign_key = array(
		'\\model\\clients' => 'client_id',
		'\\model\\workspace' => 'id',
		
		'\\model\\users\\projects' => 'id',
	);
	
	function _init() {
		self::$relationships = array(
			'client' => ORM::belongs_to('\\Model\Clients'),
			'workspace' => ORM::has_many('\\Model\\Workspace'),
			'active_workspace' => ORM::has_many('\\Model\\Workspace', array('where:status='.WS_ACTIVE)),
			
			'users' => ORM::has_many('\\Model\\User\\Projects => \\Model\\Users'),
		);
		
		self::$fields = array(
			'id' => ORM::field('auto[10]'),
			'name' => ORM::field('string', array('required')),
			'client_id' => ORM::field('mediumint', array('required')),
		);
	}
}