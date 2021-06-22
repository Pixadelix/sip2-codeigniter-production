<?php namespace Model\Voucher;

use \Gas\Core;
use \Gas\ORM;

class Task extends ORM {
	
	public $table = 'sip_voucher_task';
	
	public $primary_key = 'id';
	
	public $foreign_key = array(
        '\\model\\voucher' => 'voucher_id',
        '\\model\\tasks' => 'task_id',
	);
	
	function _init() {
		self::$relationships = array(
			'task' => ORM::belongs_to('\\Model\\Tasks'),
			'voucher' => ORM::belongs_to('\\Model\\Voucher'),
		);
		
		self::$fields = array(
			'id'          => ORM::field('auto[3]'),
			'voucher_id'  => ORM::field('int[11]'),
			'task_id'     => ORM::field('int[11]'),
            'user_id'     => ORM::field('int[11]'),
		);
	}
}