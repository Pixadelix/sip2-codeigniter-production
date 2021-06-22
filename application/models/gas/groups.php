<?php namespace Model;

use \Gas\Core;
use \Gas\ORM;

class Groups extends ORM {
	
	public $table = 'sip_groups';
	
	public $primary_key = 'id';
	
	public $foreign_key = array(
		'\\model\\users\\groups' => 'group_id',
        '\\model\\acl_restricted_resource' => 'group_id',
	);
	
	function _init() {
		self::$relationships = array(
			'users' => ORM::has_many('\\Model\\Users\\Groups => \\Model\\Users'),
            'restricted_resources' => ORM::has_many('\\Model\Acl_restricted_resource'),
			
		);
		
		self::$fields = array(
			'id'          => ORM::field('auto[10]'),
			'name'        => ORM::field('string'),
			'description' => ORM::field('string')
		);
	}
}