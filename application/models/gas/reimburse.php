<?php

namespace Model;

use \Gas\Core;
use \Gas\ORM;

class Reimburse extends ORM {
	
	public $primary_key = 'id';
	public $table = 'sip_reimburs_tickets';
	
	public $foreign_key = array(
		'\\model\\users' => 'user_id',
		'\\model\\reimburs_dtl' => 'ticket_id'

	);

	
	function _init() {
		self::$relationships = array(
			'users' => ORM::belongs_to('\\Model\\Users'),
			'dtl' => ORM::has_many('\\Model\\Reimburs_dtl'),
		);
		
		self::$fields = array(
			'id'          => ORM::field('auto'),
			'create_at'   => ORM::field('timestamp'),
			'update_at'   => ORM::field('timestamp')
		);
		
		$this->ts_fields = array('update_at', '[create_at]');

	}
}