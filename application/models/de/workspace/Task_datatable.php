<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// DataTables PHP library and database connection
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

class Task_datatable extends CI_Editor_Model {
    
    public $table = 'sip_tasks';
    private $_ci = null;
	
	public function __construct() {
		
		parent::__construct();
        $this->_ci =& get_instance();
        
		$this->create_table();
		$this->init_editor();
	}
	
	public function create_table() {

		if ( $this->production() ) return;
		
		$this->db_datatables->sql(
			"CREATE TABLE IF NOT EXISTS `$this->table` (
				`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
				`user_id` int(11) UNSIGNED NOT NULL,
				`mag_id` mediumint(11) UNSIGNED NOT NULL,
				`tab_id` mediumint(8) UNSIGNED NOT NULL,
				`type` varchar(200) NOT NULL,
				`event_name` varchar(200) DEFAULT NULL,
				`event_date` datetime DEFAULT NULL,
				`event_place` varchar(200) DEFAULT NULL,
				`status` varchar(50) NOT NULL DEFAULT 'standby',
				`due_date` datetime DEFAULT NULL,
				`start_at` datetime DEFAULT NULL,
				`complete_at` datetime DEFAULT NULL,
				`notes` text,
				`notes_hist` longtext,
				`repeat` varchar(20) DEFAULT NULL,
                `fgrab` int(1) UNSIGNED NOT NULL DEFAULT 0 comment '0 = disabled, 1 = enabled',
				`create_by` mediumint(8) UNSIGNED NOT NULL DEFAULT '1',
				`create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
				`update_by` mediumint(8) UNSIGNED DEFAULT NULL,
				`update_at` datetime DEFAULT NULL,
			  
				PRIMARY KEY( `id` )
			);" 
		);
        
        $this->db_datatables->sql(
            "ALTER TABLE `sip_tasks` CHANGE `notes` `notes` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL"
        );
        
        $this->create_view();
	}
	
	public function create_view() {
		
		if ( $this->production() ) return;
		
		//printf("Create View : %-30s", 'sip_view_workspace_progress_1'.PHP_EOL);
		$this->db_datatables->sql(
			"CREATE OR REPLACE VIEW `sip_view_workspace_progress_1` AS
			SELECT `t`.`mag_id`     AS `mag_id`,
			        count(0)        AS `cnt_total`,
					if((`t`.`status` = 'done'), count(0), 0) AS `cnt_done`,
					if((`t`.`status` <> 'done'), count(0), 0) AS `cnt_not_done`,
					`t`.`status`     AS `status`
			  FROM `sip_tasks` `t`
			 GROUP BY `t`.`mag_id`, `t`.`status`;"
		);
		
		//printf("Create View : %-30s", 'sip_view_workspace_progress_2'.PHP_EOL);
		$this->db_datatables->sql(
			"CREATE OR REPLACE VIEW `sip_view_workspace_progress_2` AS
			SELECT `a`.`mag_id`              AS `mag_id`,
						sum(`a`.`cnt_total`)      AS `total`,
						sum(`a`.`cnt_done`)       AS `done`,
						sum(`a`.`cnt_not_done`)   AS `not_done`
				 FROM sip_view_workspace_progress_1 `a`
				 GROUP BY `a`.`mag_id`;"
		);
		
		//printf("Create View : %-30s", 'sip_view_workspace_progress'.PHP_EOL);
		$this->db_datatables->sql(
			"CREATE OR REPLACE VIEW `sip_view_workspace_progress` AS
			SELECT `b`.`mag_id`                       AS `mag_id`,
				  ((`b`.`done` / `b`.`total`) * 100) AS `progress_task`
			FROM sip_view_workspace_progress_2 `b`;"
			);
	}
	
	private function init_editor() {

		// Build our Editor instance and process the data coming from _POST
		$this->editor = Editor::inst( $this->db_datatables, $this->table, 'id' )
			->fields(
				Field::inst( "$this->table.id" ),
				Field::inst( "$this->table.user_id" )
                    ->set(Field::SET_BOTH)
					->options( Options::inst()
						->table( 'sip_users' )
						->value( 'sip_users.id' )
						->label( 'sip_users.first_name, sip_users.last_name' )
						->order( 'sip_users.first_name' )
						->where( function ( $q ) {
							//$q->where( 'id', 2, '>' );
							$q->where( 'first_name', null, 'is not');
							$q->where( 'first_name', '', '!=');
                            $q->where( 'active', 1, '=');
						})
						->render( function ( $row ) {
							return $row['sip_users.first_name'].' <small>'.$row['sip_users.last_name'].'</small>';
						})
					)
					->validator( 'Validate::notEmpty' )
					->validator( 'Validate::dbValues' )
				,
				Field::inst( "$this->table.mag_id" )
					->options( Options::inst()
						->table( 'sip_workspace' )
						->value( 'sip_workspace.id' )
						->label( 'sip_workspace.name, sip_workspace.edition' )
						->order( 'sip_workspace.name' )
						->where( function ( $q ) {
							$q->where( 'status', WS_ACTIVE, '=' );
						})
						->render( function ( $r ) {
							return $r['sip_workspace.name'].' <em class="note">'.$r['sip_workspace.edition'].'</em>';
						})
					)
					->validator( 'Validate::notEmpty' )
				,
				Field::inst( "$this->table.tab_id" )
					->options( Options::inst()
						->table( 'sip_worksheet' )
						->value( 'sip_worksheet.id' )
						->label( 'sip_worksheet.mag_id, sip_worksheet.rubric, sip_worksheet.content, sip_worksheet.position, sip_worksheet.pages' )
						->order( 'sip_worksheet.position asc' )
						->where( 'sip_worksheet.mag_id', 'sip_workspace.id', '=')
						->render( function ( $r ) {
							return $r['sip_worksheet.rubric'].' <em class="note">'.substr($r['sip_worksheet.content'], 0, 65).'</em>';
						})
					)
					->validator( 'Validate::notEmpty' )
				,
				Field::inst( "$this->table.type" )
				
				/* */
					->options( Options::inst()
						->table( 'sip_task_types' )
						->value( 'sip_task_types.label' )
						->label( 'sip_task_types.icon' )
						->order( 'sip_task_types.label asc' )
						->render( function ( $r ) {
							return '<i class="fa fa-fw '.$r['sip_task_types.icon'].'"></i> '.$r['sip_task_types.label'];
						})
					)
				/* */
				/* 
					->options( function() {
							$task_type = array(
								array('value' => TASK_TYPE_COMMON        , 'label' => '<i class="fa fa-fw '.get_task_icon(TASK_TYPE_COMMON          ).'"></i> ' . TASK_TYPE_COMMON          ),
								array('value' => TASK_TYPE_COVERAGE      , 'label' => '<i class="fa fa-fw '.get_task_icon(TASK_TYPE_COVERAGE        ).'"></i> ' . TASK_TYPE_COVERAGE        ),
								array('value' => TASK_TYPE_INTERVIEW     , 'label' => '<i class="fa fa-fw '.get_task_icon(TASK_TYPE_INTERVIEW       ).'"></i> ' . TASK_TYPE_INTERVIEW       ),
								array('value' => TASK_TYPE_WRITING       , 'label' => '<i class="fa fa-fw '.get_task_icon(TASK_TYPE_WRITING         ).'"></i> ' . TASK_TYPE_WRITING         ),
								array('value' => TASK_TYPE_PHOTO         , 'label' => '<i class="fa fa-fw '.get_task_icon(TASK_TYPE_PHOTO           ).'"></i> ' . TASK_TYPE_PHOTO           ),
								array('value' => TASK_TYPE_EDITING       , 'label' => '<i class="fa fa-fw '.get_task_icon(TASK_TYPE_EDITING         ).'"></i> ' . TASK_TYPE_EDITING         ),
								array('value' => TASK_TYPE_DESIGN        , 'label' => '<i class="fa fa-fw '.get_task_icon(TASK_TYPE_DESIGN          ).'"></i> ' . TASK_TYPE_DESIGN          ),
								array('value' => TASK_TYPE_OTHERS        , 'label' => '<i class="fa fa-fw '.get_task_icon(TASK_TYPE_OTHERS          ).'"></i> ' . TASK_TYPE_OTHERS          ),
								array('value' => TASK_TYPE_MEETING       , 'label' => '<i class="fa fa-fw '.get_task_icon(TASK_TYPE_MEETING         ).'"></i> ' . TASK_TYPE_MEETING         ),
								array('value' => TASK_TYPE_MARKETING     , 'label' => '<i class="fa fa-fw '.get_task_icon(TASK_TYPE_MARKETING       ).'"></i> ' . TASK_TYPE_MARKETING       ),
								array('value' => TASK_TYPE_PRESENTATION  , 'label' => '<i class="fa fa-fw '.get_task_icon(TASK_TYPE_PRESENTATION    ).'"></i> ' . TASK_TYPE_PRESENTATION    ),
								array('value' => TASK_TYPE_CONTACT_REPORT, 'label' => '<i class="fa fa-fw '.get_task_icon(TASK_TYPE_CONTACT_REPORT  ).'"></i> ' . TASK_TYPE_CONTACT_REPORT  ),
								array('value' => TASK_TYPE_FOLLOW_UP     , 'label' => '<i class="fa fa-fw '.get_task_icon(TASK_TYPE_FOLLOW_UP       ).'"></i> ' . TASK_TYPE_FOLLOW_UP       ),
								array('value' => TASK_TYPE_BAST          , 'label' => '<i class="fa fa-fw '.get_task_icon(TASK_TYPE_BAST            ).'"></i> ' . TASK_TYPE_BAST            ),
								array('value' => TASK_TYPE_QC            , 'label' => '<i class="fa fa-fw '.get_task_icon(TASK_TYPE_QC              ).'"></i> ' . TASK_TYPE_QC              ),
								array('value' => TASK_TYPE_FINAL_QC      , 'label' => '<i class="fa fa-fw '.get_task_icon(TASK_TYPE_FINAL_QC        ).'"></i> ' . TASK_TYPE_FINAL_QC        ),
								array('value' => TASK_TYPE_DELIVER       , 'label' => '<i class="fa fa-fw '.get_task_icon(TASK_TYPE_DELIVER         ).'"></i> ' . TASK_TYPE_DELIVER         ),
								array('value' => TASK_TYPE_PRODUCTION    , 'label' => '<i class="fa fa-fw '.get_task_icon(TASK_TYPE_PRODUCTION      ).'"></i> ' . TASK_TYPE_PRODUCTION      ),
							);
							sort($task_type);
							return $task_type;
						}
					)
				 */
				,
				Field::inst( "$this->table.event_name" )
                    ->set(Field::SET_BOTH)
					->setFormatter( 'Format::nullEmpty' )
				,
				Field::inst( "$this->table.event_date" )
                    ->set(Field::SET_BOTH)
					->validator( 'Validate::dateFormat', array( 'format'=>'d-m-Y H:i' ) )
					->getFormatter( 'Format::datetime', array( 'from'=>'Y-m-d H:i:s', 'to'  =>'d-m-Y H:i' ) )
					->setFormatter( 'Format::datetime', array( 'to'  =>'Y-m-d H:i:s', 'from'=>'d-m-Y H:i' ) )
					,
				Field::inst( 'sip_tasks.event_place' )
                    ->set(Field::SET_BOTH)
                    ,
				Field::inst( 'sip_tasks.status' )
					->options(function() {
						return array(
							array('value' => TASK_STATUS_STANDBY,  'label' => '<span class="text-standby"><i class="fa fa-fw fa-arrow-circle-down"></i>'               .TASK_STATUS_STANDBY   .'</span>'),
							array('value' => TASK_STATUS_ONGOING,  'label' => '<span class="text-ongoing"><i class="fa fa-fw fa-arrow-circle-right text-ongoing"></i>' .TASK_STATUS_ONGOING   .'</span>'),
							array('value' => TASK_STATUS_CANCEL,   'label' => '<span class="text-cancel"><i class="fa fa-fw fa-times-circle text-cancel"></i>'         .TASK_STATUS_CANCEL    .'</span>'),
							array('value' => TASK_STATUS_POSTPONE, 'label' => '<span class="text-postpone"><i class="fa fa-fw fa-arrow-circle-left text-postpone"></i>'.TASK_STATUS_POSTPONE  .'</span>'),
							array('value' => TASK_STATUS_DONE,     'label' => '<span class="text-done"><i class="fa fa-fw fa-check-circle text-done"></i>'             .TASK_STATUS_DONE      .'</span>'),
						);
					})
				,
				Field::inst( 'sip_tasks.due_date' )
                    ->set(Field::SET_BOTH)
					//->validator( 'Validate::notEmpty' )
					->validator( 'Validate::dateFormat', array( 'format'=>'d-m-Y' ) )
					->getFormatter( 'Format::datetime', array( 'from'=>'Y-m-d H:i:s', 'to'  =>'d-m-Y' ) )
					->setFormatter( 'Format::datetime', array( 'to'  =>'Y-m-d H:i:s', 'from'=>'d-m-Y' ) )
					,
				Field::inst( 'sip_tasks.start_at' )
					->validator( 'Validate::dateFormat', array( 'format'=>'d/m/Y H:i' ) )
					->getFormatter( 'Format::datetime', array( 'from'=>'Y-m-d H:i:s', 'to'  =>'d/m/Y H:i' ) )
					->setFormatter( 'Format::datetime', array( 'to'  =>'Y-m-d H:i:s', 'from'=>'d/m/Y H:i' ) )
					,
				Field::inst( 'sip_tasks.complete_at' )
					->validator( 'Validate::dateFormat', array( 'format'=>'d/m/Y H:i' ) )
					->getFormatter( 'Format::datetime', array( 'from'=>'Y-m-d H:i:s', 'to'  =>'d/m/Y H:i' ) )
					->setFormatter( 'Format::datetime', array( 'to'  =>'Y-m-d H:i:s', 'from'=>'d/m/Y H:i' ) )
					,
				Field::inst( 'sip_tasks.notes' )
                    ->set(Field::SET_BOTH)
					->setFormatter( 'Format::nullEmpty' )
				,
				Field::inst( 'sip_tasks.notes_hist' )
					->getFormatter(function($val, $data, $opts) {
						if( is_serial($val) ) {
							$hist = unserialize($val);
							
							$notes_hist = '';

							if( is_array( $hist) ) {
								for ( $i = 0; $i < count($hist); $i++ ) {
									$o = $hist[$i];
									if(!$o) continue;
									//var_dump($o);
									if(is_object($o)) { //} && isset($o->notes)){
										$notes_hist .= _ldate_(trim($o->update_at) ? $o->update_at : $o->create_at).': '.$o->notes;
									}else {
										$notes_hist .= $o;
									}
									$notes_hist .= '<br/>';
								}
							}
							//die;
							return $notes_hist;
						} else {
							return $val;
						}
						
					})
				,
				Field::inst( 'sip_tasks.repeat' ),
                Field::inst( 'sip_tasks.fgrab' ),
				Field::inst( 'sip_tasks.create_by' )->set(Field::SET_CREATE),
				Field::inst( 'sip_tasks.create_at' )->set(Field::SET_CREATE),
				Field::inst( 'sip_tasks.update_by' )->set(Field::SET_EDIT),
				Field::inst( 'sip_tasks.update_at' )->set(Field::SET_EDIT),
				
				// Relation
				Field::inst( 'sip_users.first_name' ),
				
				Field::inst( 'sip_workspace.name' ),
				
				//Field::inst( 'sip_worksheet.rubric' ),
				
				Field::inst( 'sip_task_types.icon' )

			)
			->leftJoin( 'sip_users', 'sip_users.id', '=', 'sip_tasks.user_id' )
			->leftJoin( 'sip_workspace', 'sip_workspace.id', '=', 'sip_tasks.mag_id' )
			//->leftJoin( 'sip_worksheet', 'sip_worksheet.id', '=', 'sip_tasks.tab_id' )
			->leftJoin( 'sip_task_types', 'sip_task_types.label', '=', 'sip_tasks.type' )
            
            /*
            ->join(
                Mjoin::inst( 'sip_voucher' )
                    ->link( "$this->table.id", 'sip_voucher_task.task_id' )
                    ->link( "sip_voucher.id", 'sip_voucher_task.voucher_id' )
                    ->order( 'code asc' )
                    ->fields(
                        Field::inst( 'id' )
                            ->options( Options::inst()
                                //->table( 'sip_voucher' )
                                ->table( 'sip_voucher_available' )
                                ->value( 'id' )
                                ->label( 'name' )
                                //->where( 'used_by', null )
                                ->where( function ($q ) {
                                    //$q->where( 'task_id', null );
                                    //$q->or_where( 'task_id', 'sip_tasks.id', '=' );
                                })
                                ->order( 'id', 'asc' )
                                ->limit( 20 )
                            )
                        ,
                        Field::inst( 'name ' ),
                        Field::inst( 'starting_date' ),
                        Field::inst( 'expired_date' )
                    )
            )
            */
			
			->on( 'preCreate', function ( $editor, $values ) {
				$ci =& get_instance();
				$editor
					->field( 'sip_tasks.create_by' )
					->setValue( $ci->user_id );
				$editor
					->field( 'sip_tasks.create_at' )
					->setValue( $ci->db_value_now() );
			})
			
			->on( 'preEdit', function ( $editor, $id, $values ) {
				$ci =& get_instance();
				$editor
					->field( 'sip_tasks.update_by' )
					->setValue( $ci->user_id );
				$editor
					->field( 'sip_tasks.update_at' )
					->setValue( $ci->db_value_now() );

				$this->create_log($editor, $id);
			})
            
            ->on( 'postCreate', function ( $editor, $id, $values, $row ) {
				//var_dump($id); die;\
				//$editor->transaction(false);
                /* still need workaround about this transaction in between database connection */
                $this->send_notification( $id, $row, 'NEW' );
            })
            
            ->on( 'postEdit', function ( $editor, $id, $values, $row ) {
                //$this->send_notification( $id, $row, 'UPDATE' );
            })
			
		;

	}
	
	private function create_log($editor, $id) {
		
		$rec = Model\Tasks::find($id);
		$rec->create_log();
		$rec->save();
	}
    
    private function send_notification( $id, $row, $mode ) {
		
		$task      = $row['sip_tasks'];
		$workspace = Model\Workspace::find($task['mag_id']);
		$worksheet = Model\Worksheet::find($task['tab_id']);
		$user      = Model\Users::find($task['user_id']);
        
        if ( !$task || !$workspace || !$worksheet || !$user ) {
            return;
        }


        $this->email->from('no-reply@media-vista.com', 'No Reply');
        if ( 'production' === ENVIRONMENT ) {
            $this->email->to($user->email);
            $cc = array();
            if ( $user->email != 'yusar@media-vista.com' ) {
                $cc[] = 'yusar@media-vista.com';                
            }
            if ( $user->email != 'saras@media-vista.com' ) {
                $cc[] = 'saras@media-vista.com';
            }
            $this->email->cc($cc);
        } else {
            $this->email->to('yusar@media-vista.com');
        }
        
        
		$this->email->subject("[SIP] - #".$id.'-'.$workspace->name.'-'.$task['type']." ($mode)");
		
        $data['task']      = $task;
		$data['workspace'] = $workspace;
		$data['worksheet'] = $worksheet;
		$data['user']      = $user;

        $mail_body = $this->load->view('email/task/notification', $data, true);
        $this->email->message($mail_body);

        if ( ! $this->email->send(false) ) {
            //echo $this->email->print_debugger();
        }
		
		if ( $user->telegram_username ) {
			$telegram_text = $this->load->view('telegram/task/notification', $data, true);
			$this->ci->telegram_send_message($user->telegram_username, $telegram_text);
		}

    }
	
	public function get($id = null, $id2 = null) {
		
		// Filter workspace select options
		global $_id;
		$_id = $id;
		
		$this->editor->field( 'sip_tasks.mag_id' )->options()
			->where( function ( $q ) {
				global $_id;
				$q->where( 'sip_workspace.id', $_id );
			})
		;
		
		// Filter worksheet select options
		$this->editor->field( 'sip_tasks.tab_id' )->options()
			->where( function ( $q ) {
				global $_id;
				$q->where( 'sip_worksheet.mag_id', $_id );
			})
		;

		$this->editor
			->where( 'mag_id', $id, '=' );
		if( $id2 )
			$this->editor
				->where( 'tab_id', $id2, '=');
		
		try {
			parent::get();
		}
		catch( Exception $e ) {
			var_dump($e->errorMessage);
			
		}
	}
	
}