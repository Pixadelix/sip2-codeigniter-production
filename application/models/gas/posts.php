<?php

namespace Model;

use \Gas\Core;
use \Gas\ORM;

class Posts extends ORM {
	
	public $table = 'sip_posts';
	
	public $primary_key = 'id';
	
	public $foreign_key = array(
		'\\model\\users' => 'post_author',
	);
	
	function _init() {

		self::$relationships = array(
			'author' => ORM::belongs_to('\\Model\\Users'),
		);
		
		self::$fields = array(
			'id'                      => ORM::field('auto'),
			'post_author'             => ORM::field('int'),
			'post_date'               => ORM::field('datetime'),
			'post_content'            => ORM::field('string'),
			'post_title'              => ORM::field('string'),
			'post_excerpt'            => ORM::field('string'),
			'post_status'             => ORM::field('string'),
			'post_name'               => ORM::field('string'),
			'post_parent'             => ORM::field('int'),
			'post_type'               => ORM::field('string'),
			'post_mime_type'          => ORM::field('string'),
			'post_password'           => ORM::field('string'),
			'media_filename'          => ORM::field('string'),
			'media_filesize'          => ORM::field('string'),
			'media_system_path'       => ORM::field('string'),
			'media_web_path'          => ORM::field('string'),
			'media_thumbnail_path'    => ORM::field('string'),
			'comment_status'          => ORM::field('string'),
			'comment_count'           => ORM::field('int'),
			'create_by'               => ORM::field('int'),
			'create_at'               => ORM::field('timestamp'),
			'update_by'               => ORM::field('int'),
			'update_at'               => ORM::field('timestamp'),
		);

	}
}
