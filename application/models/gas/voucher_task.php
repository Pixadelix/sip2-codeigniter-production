<?php

namespace Model;

use \Gas\Core;
use \Gas\ORM;

class Voucher_task extends ORM {
	
	public $table = 'sip_voucher_task';
	
	public $primary_key = 'id';
	
	public $foreign_key = array(
        
	);
	
	function _init() {
		
		self::$relationships = array(
            
		);
		
		
		self::$fields = array(
			'id'          => ORM::field('auto'),
            'voucher_id'  => ORM::field('int'),
            'task_id'     => ORM::field('int'),
            'user_id'     => ORM::field('int'),

			'create_by'   => ORM::field('int[11]'),
			'create_at'   => ORM::field('timestamp'),
			'update_by'   => ORM::field('int[11]'),
			'update_at'   => ORM::field('timestamp')
		);
		
		$this->ts_fields = array('[create_at]', 'update_at');
	}
	
	
}

