<?php

namespace Model;

use \Gas\Core;
use \Gas\ORM;

class Tasks extends ORM {
	
	public $table = 'sip_tasks';
	
	public $primary_key = 'id';
	
	public $foreign_key = array(
		'\\model\\worksheet' => 'tab_id',
		'\\model\\users' => 'user_id',
		'\\model\\workspace' => 'mag_id',
        '\\model\\voucher\\task' => 'task_id',
	);
	
	function _init() {
		
		self::$relationships = array(
			'workspace' => ORM::belongs_to('\\Model\Workspace'),
			'worksheet' => ORM::belongs_to('\\Model\\Worksheet'),
			'user' => ORM::belongs_to('\\Model\\Users'),
            'vouchers' => ORM::has_many('\\Model\\Voucher\\Task'),
		);
		
		
		self::$fields = array(
			'id' => ORM::field('auto'),
			'user_id' => ORM::field('int'),
			'mag_id' => ORM::field('int'),
			'tab_id' => ORM::field('int'),
			
			'status' => ORM::field('string', array('required')),
			
			'due_date'    => ORM::field('timestamp'),
			'complete_at' => ORM::field('timestamp', null, 'null'),
			'notes_hist'  => ORM::field('longtext'),
			'create_by'   => ORM::field('int[11]'),
			'create_at'   => ORM::field('timestamp'),
			'update_by'   => ORM::field('int[11]'),
			'update_at'   => ORM::field('timestamp')
		);
		
		$this->ts_fields = array('[create_at]', 'update_at');
	}
	
	function create_log() {
		$notes_hist = $this->notes_hist;
		if ( !$notes_hist ) {
			$notes_hist = array();
		}
		
		if (is_serial($notes_hist)) {
			$notes_hist = unserialize($notes_hist);
		}
		
		if( !is_array($notes_hist) ) {
			if($notes_hist){
				$notes_hist = array($notes_hist);
			}
		}
		$obj = (object) $this->record['data'];
		$obj->notes_hist = null;
		$notes_hist[] = $obj;
		
		//var_dump($task->notes_hist);
		
		$this->notes_hist = serialize($notes_hist);
		
	}
}

//'project_file' => ORM::field('string', array('required'), 'TINYBLOB, null'),
