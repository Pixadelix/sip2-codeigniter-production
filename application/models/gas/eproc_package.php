<?php

namespace Model;

use \Gas\Core;
use \Gas\ORM;

class Eproc_package extends ORM {
	
	public $table = 'eproc_package';
	
	public $primary_key = 'id';
	
	public $foreign_key = array(
		'\\model\\eproc_lpse' => 'lpse_id'
	);
	
	function _init() {
		
		self::$relationships = array(
			'lpse' => ORM::belongs_to('\\Model\\Eproc_lpse'),
		);

		self::$fields = array(
			'id'                      => ORM::field('auto'),
			
			'name'                    => ORM::field('string'),
			'instance'                => ORM::field('string'),
			'status'                  => ORM::field('string'),
			'est_price'               => ORM::field('string'),
			'doc_method'              => ORM::field('string'),
			'method'                  => ORM::field('string'),
			'elimitaion_method'       => ORM::field('string'),
			'category'                => ORM::field('string'),
			'spse_version'            => ORM::field('string'),
			
			'lpse_id'                 => ORM::field('int'),
			
			'create_by'               => ORM::field('int'),
			'create_at'               => ORM::field('timestamp'),
			'update_by'               => ORM::field('int'),
			'update_at'               => ORM::field('timestamp'),
		);
		
		$this->ts_fields = array('[create_at]', 'update_at');

	}
}
