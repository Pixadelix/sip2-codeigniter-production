<?php

namespace Model;

use \Gas\Core;
use \Gas\ORM;

class Worksheet extends ORM {
	
	public $table = 'sip_worksheet';
	
	public $primary_key = 'id';
	
	public $foreign_key = array(
		'\\model\\workspace' => 'mag_id',
	);
	
	function _init() {
		self::$relationships = array(
			'workspace' => ORM::belongs_to('\\Model\\Workspace'),
			'tasks' => ORM::has_many('\\Model\Tasks')
		);
		
		self::$fields = array(
			'id' => ORM::field('auto'),
			'mag_id' => ORM::field('int'),
			'rubric' => ORM::field('string', array('required')),
			'content' => ORM::field('string'),
//			'due_date'    => ORM::field('datetime'),
			'create_by'   => ORM::field('int[11]'),
			'create_at'   => ORM::field('timestamp'),
			'update_by'   => ORM::field('int[11]'),
			'update_at'   => ORM::field('timestamp')
		);
		
		$this->ts_fields = array('update_at', '[create_at]');
	}
}