<?php



namespace Model\Users;

use \Gas\Core;
use \Gas\ORM;

class Eproc_lpse extends ORM {
	
	public $table = 'eproc_monitored';
	
	public $primary_key = 'id';
	
	public $foreign_key = array(
		'\\model\\users' => 'user_id',
		'\\model\\eproc_lpse' => 'lpse_id',
	);
	
	function _init() {
		
		self::$relationships = array(
			'user' => ORM::belongs_to('\\Model\\Users'),
			'lpse' => ORM::belongs_to('\\Model\\Eproc_lpse'),
		);
		
		/*
		self::$fields = array(
			'id'                      => ORM::field('auto', array('required')),
			
			'user_id'                 => ORM::field('int', array('required')),
			'lpse_id'                 => ORM::field('int', array('required')),

			'create_by'               => ORM::field('int'),
			'create_at'               => ORM::field('datetime'),
			'update_by'               => ORM::field('int'),
			'update_at'               => ORM::field('datetime'),
		);
		
		$this->ts_fields = array('[create_at]', 'update_at');
		*/

	}
	
}
