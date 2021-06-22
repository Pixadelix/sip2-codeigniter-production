<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Datatables PHP library and database connection
//include_once APPPATH . DATATABLE_EDITOR;

// Alias Editor classes so they are easy to use
use
	DataTables\Editor,
	DataTables\Editor\Field,
	DataTables\Editor\Format,
	DataTables\Editor\Mjoin,
	DataTables\Editor\Options,
	DataTables\Editor\Upload,
	DataTables\Editor\Validate;

load_class('Editor_Model', 'core');
class Shop_datatable extends CI_Editor_Model {
	
	public $table = 'shop_shop';
	
	const SHOP_STATUS_OPEN = 'open';
	const SHOP_STATUS_CLOSED = 'closed';
	const SHOP_STATUS_BANNED = 'banned';
	
	public function __construct() {
		parent::__construct();
		$this->create_table();
		$this->init_editor();
	}
	
	public function create_table() {
		
		if ( $this->production() ) return;
		
		$sql = sprintf("CREATE TABLE IF NOT EXISTS `$this->table` (
            `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,

            `user_id` int(11) UNSIGNED NOT NULL,

            `name` varchar(512) UNIQUE NOT NULL,
            `description` longtext DEFAULT NULL,

            `status` varchar(50) NOT NULL DEFAULT '%s',

            `create_by` mediumint(8) UNSIGNED NOT NULL DEFAULT '1',
            `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `update_by` mediumint(8) UNSIGNED DEFAULT NULL,
            `update_at` datetime DEFAULT NULL,

            INDEX `idx_shop_name` (`name`),

            PRIMARY KEY( `id` )
        )
        ;", self::SHOP_STATUS_OPEN);
		$this->db_datatables->sql($sql);
		
		$this->db_datatables->sql(
			"CREATE TABLE IF NOT EXISTS `shop_manager` (
				`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
				`shop_id` int(11) UNSIGNED NOT NULL,
				`user_id` int(11) UNSIGNED NOT NULL,
				
				INDEX `idx_shop_id` (`shop_id`),
				INDEX `idx_user_id` (`user_id`),
				
				PRIMARY KEY ( `id` )
			)
			;"
		);
		
	}
	
	public function init_editor() {
		$this->editor = Editor::inst( $this->db_datatables, $this->table, 'id' )
			->fields(
				Field::inst( "$this->table.id" ),
				
				Field::inst( "$this->table.user_id" )
					->options( Options::inst()
						->table( 'sip_users' )
						->value( 'sip_users.id' )
						->label( 'sip_users.first_name, sip_users.last_name' )
						->order( 'sip_users.first_name' )
						->where( function ( $q ) {
							$q->where( 'id', 2, '>' );
							$q->where( 'first_name', null, 'is not');
							$q->where( 'first_name', '', '!=');
						})
						->render( function ( $row ) {
							return $row['sip_users.first_name'].' '.$row['sip_users.last_name'];
						})
					)
					->validator( 'Validate::notEmpty' )
					->validator( 'Validate::dbValues' )
				,

				Field::inst( "$this->table.name" ),
				Field::inst( "$this->table.description" ),
				Field::inst( "$this->table.status" )
					->options( function() {
							return array(
								array('value' => self::SHOP_STATUS_OPEN, 'label' => strtoupper(self::SHOP_STATUS_OPEN)),
								array('value' => self::SHOP_STATUS_CLOSED, 'label' => strtoupper(self::SHOP_STATUS_CLOSED)),
								array('value' => self::SHOP_STATUS_BANNED, 'label' => strtoupper(self::SHOP_STATUS_BANNED)),
							);
						}
					)
				,
				
				Field::inst( "$this->table.create_by"                 )->set(Field::SET_CREATE),
				Field::inst( "$this->table.create_at"                 )->set(Field::SET_CREATE),
				Field::inst( "$this->table.update_by"                 )->set(Field::SET_EDIT),
				Field::inst( "$this->table.update_at"                 )->set(Field::SET_EDIT)
				
				,
				Field::inst( 'su1.first_name' ),
				Field::inst( 'su1.last_name' )

			)
			
			->leftJoin( 'sip_users as su1', 'su1.id', '=', "$this->table.user_id" )
			
			->join(
				Mjoin::inst( 'sip_users' )
					->link( 'shop_shop.id', 'shop_manager.shop_id' )
					->link( 'sip_users.id', 'shop_manager.user_id' )
					//->order( 'sip_users.first_name asc' )
					->fields(
						Field::inst( 'id' )->set(false)
							->validator( 'Validate::required' )
							->options( Options::inst()
								->table( 'sip_users' )
								->value( 'id' )
								->label( 'first_name' )
								->order( 'first_name' )
								->where( function ( $q ) {
									$q->where( 'id', 2, '>' );
									$q->where( 'first_name', null, 'is not' );
									$q->where( 'first_name', '', '!=' );
								})
							),
						Field::inst( 'first_name' )
					)
			)
			
			->on( 'preCreate', function ( $editor, $values ) {
				$this->default_create_log();
			})
			
			->on( 'preEdit', function ( $editor, $values ) {
				$this->default_edit_log();
			})
		;
	}
	
}