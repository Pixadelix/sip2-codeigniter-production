<?php

namespace Model;

use \Gas\Core;
use \Gas\ORM;

class Reimburse_receipts extends ORM {
	
	public $primary_key = 'id';
	public $table = 'reimburs_receipts';
	
	public $foreign_key = array(
		'\\model\reimburs' => 'ticket_id',
		'\\model\\reimburs_dtl' => 'ticket_dtl_id'
	);

	
	function _init() {
		self::$relationships = array(
			'receipts' => ORM::belongs_to('\\Model\\Receipts'),
			'reimburs' => ORM::belongs_to('\\Model\\Reimburs_dtl'),
		);
		
		self::$fields = array(
			'id'          => ORM::field('auto'),
		);
	}
}