<?php

namespace Model;

use \Gas\Core;
use \Gas\ORM;

class Admdoc extends ORM {
	
	public $table = 'sip_admin_document';
	
	public $primary_key = 'id';
	
	function _init() {
		
		self::$fields = array(
			'id'          => ORM::field('auto'),
			'type'        => ORM::field('string'),
			'group'       => ORM::field('string'),
			'refcode'     => ORM::field('string'),
			'refdate'     => ORM::field('datetime'),
			'notes'       => ORM::field('text'),
			'content'     => ORM::field('text'),
			'status'      => ORM::field('string'),
			'create_by'   => ORM::field('int[11]'),
			'create_at'   => ORM::field('timestamp'),
			'update_by'   => ORM::field('int[11]'),
			'update_at'   => ORM::field('timestamp'),
		);
	}
}