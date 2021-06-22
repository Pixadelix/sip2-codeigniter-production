<?php

namespace Model;

use \Gas\Core;
use \Gas\ORM;

class Workspace extends ORM {
	
	public $table = 'sip_workspace';
	
	public $primary_key = 'id';
	
	public $foreign_key = array(
		'\\model\\projects' => 'project_id',
//		'\\model\\job' => 'j_id'
	);

	
	function _init() {
		self::$relationships = array(
			'project' => ORM::belongs_to('\\Model\\Projects'),
			'worksheet' => ORM::has_many('\\Model\\Worksheet'),
			'tasks' => ORM::has_many('\\Model\Tasks'),
		);
		
		self::$fields = array(
			'id'          => ORM::field('auto'),
			'name'        => ORM::field('string', array('required')),
			'edition'     => ORM::field('string', array('required')),
			'project_id'  => ORM::field('int', array('required')),
			'publish'     => ORM::field('date', array('required')),
			'due_date'    => ORM::field('datetime', array('required')),
			'create_by'   => ORM::field('int[11]'),
			'create_at'   => ORM::field('timestamp'),
			'update_by'   => ORM::field('int[11]'),
			'update_at'   => ORM::field('timestamp')
		);
		
		$this->ts_fields = array('update_at', '[create_at]');

	}
	
	function send_published_notification() {
		
		$to = 'pramana@media-vista.com';
		$cc = 'yusar@media-vista.com';
		
		$subject = 'S.I.P - '.$this->name." edition ".$this->edition;
		
		$mag_status_text = array(0 => 'Archived', 1 => 'Active', 2 => 'Fullscript', 10 => 'Published', 20 => 'Finished');
		$message = $this->name." edition ".$this->edition.", status changed to ".strtoupper($mag_status_text[$this->status]);
		
		$CI =& get_instance();		
		$CI->send_email($to, $subject, $message, $cc);
	}
}