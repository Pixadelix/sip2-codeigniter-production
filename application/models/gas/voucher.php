<?php

namespace Model;

use \Gas\Core;
use \Gas\ORM;

class Voucher extends ORM {
	
	public $table = 'sip_voucher';
	
	public $primary_key = 'id';
	
	public $foreign_key = array(
        '\\model\\voucher\\reserved' => 'voucher_id',
	);
	
	function _init() {
		
		self::$relationships = array(
            'reserved_voucher' => ORM::has_many('\\Model\\Voucher\\Reserved'),
		);
		
		
		self::$fields = array(
			'id' => ORM::field('auto'),
            'used_by' => ORM::field('int[11]'),

			'create_by'   => ORM::field('int[11]'),
			'create_at'   => ORM::field('timestamp'),
			'update_by'   => ORM::field('int[11]'),
			'update_at'   => ORM::field('timestamp')
		);
		
		$this->ts_fields = array('[create_at]', 'update_at');
	}	
	
}

