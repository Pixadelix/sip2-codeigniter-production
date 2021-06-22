<?php
defined('BASEPATH') OR exit('No direct script access allowed');

defined('APP_VERSION') OR define('APP_VERSION', 'v2.0.0');

defined('PROJECT_NAME') OR define('PROJECT_NAME', 'MEDIAVISTA');

defined('DE_VERSION') OR define('DE_VERSION', '1.7.0');

/* Type Message */
defined('TYPE_MESSAGE_ERROR')   OR define('TYPE_MESSAGE_ERROR',   'message_error');
defined('TYPE_MESSAGE_WARNING') OR define('TYPE_MESSAGE_WARNING', 'message_warning');
defined('TYPE_MESSAGE_SUCCESS') OR define('TYPE_MESSAGE_SUCCESS', 'message_success');

/*
|----------------------------------------------------------------------------
| Workspace Status Codes
|----------------------------------------------------------------------------
*/
defined('WS_ARCHIVED'     )       OR define('WS_ARCHIVED'     ,  0 ); // archived
defined('WS_ACTIVE'       )       OR define('WS_ACTIVE'       ,  1 ); // active
defined('WS_FULLSCRIPT'   )       OR define('WS_FULLSCRIPT'   ,  2 ); // full script
defined('WS_FULLBOOK'     )       OR define('WS_FULLBOOK'     ,  5 ); // full script
defined('WS_PUBLISHED'    )       OR define('WS_PUBLISHED'    , 10 ); // published
defined('WS_FINISHED'     )       OR define('WS_FINISHED'     , 20 ); // finished

defined('TASK_STATUS_STANDBY')   OR define('TASK_STATUS_STANDBY',    'standby');
defined('TASK_STATUS_ONGOING')   OR define('TASK_STATUS_ONGOING',    'ongoing');
defined('TASK_STATUS_CANCEL')    OR define('TASK_STATUS_CANCEL',     'cancel');
defined('TASK_STATUS_POSTPONE')  OR define('TASK_STATUS_POSTPONE',   'postpone');
defined('TASK_STATUS_DONE')      OR define('TASK_STATUS_DONE',       'done');

defined('TASK_TYPE_COMMON')         OR define('TASK_TYPE_COMMON',         'Common'               );
defined('TASK_TYPE_COVERAGE')       OR define('TASK_TYPE_COVERAGE',       'Coverage'             );
defined('TASK_TYPE_INTERVIEW')      OR define('TASK_TYPE_INTERVIEW',      'Interview'            );
defined('TASK_TYPE_WRITING')        OR define('TASK_TYPE_WRITING',        'Writing'              );
defined('TASK_TYPE_PHOTO')          OR define('TASK_TYPE_PHOTO',          'Photo'                );
defined('TASK_TYPE_EDITING')        OR define('TASK_TYPE_EDITING',        'Editing'              );
defined('TASK_TYPE_DESIGN')         OR define('TASK_TYPE_DESIGN',         'Design'               );
defined('TASK_TYPE_OTHERS')         OR define('TASK_TYPE_OTHERS',         'Others'               );
defined('TASK_TYPE_MEETING')        OR define('TASK_TYPE_MEETING',        'Meeting'              );
defined('TASK_TYPE_MARKETING')      OR define('TASK_TYPE_MARKETING',      'Marketing'            );
defined('TASK_TYPE_PRESENTATION')   OR define('TASK_TYPE_PRESENTATION',   'Presentation'         );
defined('TASK_TYPE_CONTACT_REPORT') OR define('TASK_TYPE_CONTACT_REPORT', 'Contact Report'       );
defined('TASK_TYPE_FOLLOW_UP')      OR define('TASK_TYPE_FOLLOW_UP',      'Follow Up'            );
defined('TASK_TYPE_BAST')           OR define('TASK_TYPE_BAST',           'BAST'                 );
defined('TASK_TYPE_QC')             OR define('TASK_TYPE_QC',             'QC'                   );
defined('TASK_TYPE_FINAL_QC')       OR define('TASK_TYPE_FINAL_QC',       'Final QC'             );
defined('TASK_TYPE_DELIVER')        OR define('TASK_TYPE_DELIVER',        'Deliver'              );
defined('TASK_TYPE_PRODUCTION')     OR define('TASK_TYPE_PRODUCTION',     'Production'           );

//defined('MAX_GRAB_VOUCHER_QUOTA_PER_TASK') OR define('MAX_GRAB_VOUCHER_QUOTA_PER_TASK', 2);

$TASK_TYPES = array();
$TASK_TYPES[ TASK_TYPE_COMMON         ]  = TASK_TYPE_COMMON;
$TASK_TYPES[ TASK_TYPE_COVERAGE       ]  = TASK_TYPE_COVERAGE;
$TASK_TYPES[ TASK_TYPE_INTERVIEW      ]  = TASK_TYPE_INTERVIEW;
$TASK_TYPES[ TASK_TYPE_WRITING        ]  = TASK_TYPE_WRITING;
$TASK_TYPES[ TASK_TYPE_PHOTO          ]  = TASK_TYPE_PHOTO;
$TASK_TYPES[ TASK_TYPE_EDITING        ]  = TASK_TYPE_EDITING;
$TASK_TYPES[ TASK_TYPE_DESIGN         ]  = TASK_TYPE_DESIGN;
$TASK_TYPES[ TASK_TYPE_OTHERS         ]  = TASK_TYPE_OTHERS;
$TASK_TYPES[ TASK_TYPE_MEETING        ]  = TASK_TYPE_MEETING;
$TASK_TYPES[ TASK_TYPE_MARKETING      ]  = TASK_TYPE_MARKETING;
$TASK_TYPES[ TASK_TYPE_PRESENTATION   ]  = TASK_TYPE_PRESENTATION;
$TASK_TYPES[ TASK_TYPE_CONTACT_REPORT ]  = TASK_TYPE_CONTACT_REPORT;
$TASK_TYPES[ TASK_TYPE_FOLLOW_UP      ]  = TASK_TYPE_FOLLOW_UP;
$TASK_TYPES[ TASK_TYPE_BAST           ]  = TASK_TYPE_BAST;
$TASK_TYPES[ TASK_TYPE_QC             ]  = TASK_TYPE_QC;
$TASK_TYPES[ TASK_TYPE_FINAL_QC       ]  = TASK_TYPE_FINAL_QC;
$TASK_TYPES[ TASK_TYPE_DELIVER        ]  = TASK_TYPE_DELIVER;
$TASK_TYPES[ TASK_TYPE_PRODUCTION     ]  = TASK_TYPE_PRODUCTION;

$TASK_TYPE_ICONS = array();
$TASK_TYPE_ICONS[TASK_TYPE_COMMON]         = 'vidCommon'; //'fa-desktop';
$TASK_TYPE_ICONS[TASK_TYPE_COVERAGE]       = 'vidCoverage'; //'fa-video-camera'; //'fa-building';
$TASK_TYPE_ICONS[TASK_TYPE_INTERVIEW]      = 'vidInterview'; //'fa-microphone'; //'fa-phone';
$TASK_TYPE_ICONS[TASK_TYPE_WRITING]        = 'vidWriting'; //'fa-pencil';
$TASK_TYPE_ICONS[TASK_TYPE_PHOTO]          = 'vidPhoto'; //'fa-camera';
$TASK_TYPE_ICONS[TASK_TYPE_EDITING]        = 'vidEditing'; //'fa-edit';
$TASK_TYPE_ICONS[TASK_TYPE_DESIGN]         = 'vidDesign'; //'fa-image';
$TASK_TYPE_ICONS[TASK_TYPE_OTHERS]         = 'vidOthers'; //'fa-check';
$TASK_TYPE_ICONS[TASK_TYPE_MEETING]        = 'vidMeeting'; //'fa-briefcase';
$TASK_TYPE_ICONS[TASK_TYPE_MARKETING]      = 'vidMarketing'; //'fa-bullhorn'; //'fa-dollar';
$TASK_TYPE_ICONS[TASK_TYPE_PRESENTATION]   = 'vidPresentation'; //'fa-film';
$TASK_TYPE_ICONS[TASK_TYPE_CONTACT_REPORT] = 'vidContact-Report'; //'fa-hand-o-right';
$TASK_TYPE_ICONS[TASK_TYPE_FOLLOW_UP]      = 'vidFollow-Up'; //'fa-hand-o-up';
$TASK_TYPE_ICONS[TASK_TYPE_BAST]           = 'vidBAST'; //'fa-angle-double-right';
$TASK_TYPE_ICONS[TASK_TYPE_QC]             = 'vidQC'; //'fa-arrow-right';
$TASK_TYPE_ICONS[TASK_TYPE_FINAL_QC]       = 'vidFinal-QC'; //'fa-arrows-alt';
$TASK_TYPE_ICONS[TASK_TYPE_DELIVER]        = 'vidDeliver'; //'fa-truck';
$TASK_TYPE_ICONS[TASK_TYPE_PRODUCTION]     = 'vidProduction'; //'fa-trophy';


/*
|--------------------------------------------------------------------------
| Reimbursement Status Code
|--------------------------------------------------------------------------
|*/
defined('REIM_STATUS_PROCESS')    OR define('REIM_STATUS_PROCESS',    'process');
defined('REIM_STATUS_CANCEL')     OR define('REIM_STATUS_CANCEL',     'canceled');
defined('REIM_STATUS_APPROVED')   OR define('REIM_STATUS_APPROVED',   'approved');
defined('REIM_STATUS_REJECTED')   OR define('REIM_STATUS_REJECTED',   'rejected');
defined('REIM_STATUS_COMPLETED')  OR define('REIM_STATUS_COMPLETED',  'compledted');


/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
defined('SHOW_DEBUG_BACKTRACE') OR define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
defined('FILE_READ_MODE')  OR define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') OR define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE')   OR define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE')  OR define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
defined('FOPEN_READ')                           OR define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE')                     OR define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE')       OR define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE')  OR define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE')                   OR define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE')              OR define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT')            OR define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT')       OR define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/
defined('EXIT_SUCCESS')        OR define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR')          OR define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG')         OR define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE')   OR define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS')  OR define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') OR define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     OR define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE')       OR define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')      OR define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      OR define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code
