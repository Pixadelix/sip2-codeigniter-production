<?php

namespace Model;

use \Gas\Core;
use \Gas\ORM;

class Reimburse_dtl extends ORM {
	
	public $table = 'sip_reimburse_tickets_dtl';
	
	public $primary_key = 'id';
	
	public $foreign_key = array(
		'\\model\\reimburse' => 'ticket_id',
		'\\model\\users' => 'user_id'
	);

	
	function _init() {
		self::$relationships = array(
			'reimburse' => ORM::belongs_to('\\Model\\Reimburse'),
			'receipts' => ORM::has_many('\\Model\\Reimburse_receipts'),
			'user'     => ORM::belongs_to('\\Model\\Users'),
		);
		
		self::$fields = array(
			'id'             => ORM::field('auto'),
			'user_id'        => ORM::field('int'),
			'receipt_number' => ORM::field('string'),
			'notes'          => ORM::field('string', array('required')),
			'date'           => ORM::field('datetime', array('required')),
			'qty'            => ORM::field('decimal', array('required')),
			'amount'         => ORM::field('decimal', array('required')),
			'receipt'        => ORM::field('string', array('required')),
			'change_log'     => ORM::field('longtext'),
			'create_by'      => ORM::field('int[11]'),
			'create_at'      => ORM::field('timestamp'),
			'update_by'      => ORM::field('int[11]'),
			'update_at'      => ORM::field('timestamp')
		);
		
		$this->ts_fields = array('update_at', '[create_at]');
		
		//$this->_unique_fields = array('receipt_number');


	}
	
	function create_log() {
		$change_log = $this->change_log;
		if ( !$change_log ) {
			$change_log = array();
		}
		
		if (is_serial($change_log)) {
			$change_log = unserialize($change_log);
		}
		
		if( !is_array($change_log) ) {
			if($change_log){
				$change_log = array($change_log);
			}
		}
		
		$obj = (object) $this->record['data'];
		$obj->change_log = null;
		$change_log[] = $obj;
		
		//var_dump($task->notes_hist);
		
		$this->change_log = serialize($change_log);
		
	}
	
	/*
	function _unique_check($receipt_number) {
		//return true;
		$dtl = $this->find_by_receipt_number($receipt_number);
		//var_dump($dtl);
		
		if (count($dtl) != 0)
		{
//			echo 'fal';
			return true;
        } else {

//			echo 'tru';
			return false;
		}
		//die;
	}
	*/
}