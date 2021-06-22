<?php



namespace Model;

use \Gas\Core;
use \Gas\ORM;

include_once('eproc_package.php');

class Eproc_subscribers extends ORM {
	
	public $table = 'eproc_subscribers';
	
	public $primary_key = 'id';
	
	public $foreign_key = array(
		'\\model\\users' => 'user_id',
	);
	
	function _init() {
		
		self::$relationships = array(
			'user' => ORM::belongs_to('\\Model\\Users'),
		);
		
		self::$fields = array(
			'id'                      => ORM::field('auto', array('required')),
			
			'user_id'                 => ORM::field('int', array('required')),
			'expired_date'            => ORM::field('datetime', array('required')),

			'create_by'               => ORM::field('int'),
			'create_at'               => ORM::field('datetime'),
			'update_by'               => ORM::field('int'),
			'update_at'               => ORM::field('datetime'),
		);
		
		$this->ts_fields = array('[create_at]', 'update_at');

	}
	
}
