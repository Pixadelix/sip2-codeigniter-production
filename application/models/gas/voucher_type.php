<?php

namespace Model;

use \Gas\Core;
use \Gas\ORM;

class Voucher_type extends ORM {
	
	public $table = 'sip_voucher_type';
	
	public $primary_key = 'id';
	
	function _init() {
		
		self::$fields = array(
			'id'          => ORM::field('auto'),
			'type'        => ORM::field('string'),
			'desc'        => ORM::field('string'),
			'create_by'   => ORM::field('int[11]'),
			'create_at'   => ORM::field('timestamp'),
			'update_by'   => ORM::field('int[11]'),
			'update_at'   => ORM::field('timestamp'),
		);
	}
}