<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$bot_api_key  = '471080874:AAGVSozuKruZ_TorNczWns0hwLXd6Q1A28o';
$bot_username = 'MEDIAVISTA_bot';

$config['telegram'] = array(
	'default' => array(
		'bot_api_key'  => $bot_api_key,
		'bot_username' => $bot_username,
	)
);

defined('TELEGRAM_BOT_USERNAME') OR define('TELEGRAM_BOT_USERNAME', $bot_username);

defined('TELEGRAM_TABLE_PREFIX') OR define('TELEGRAM_TABLE_PREFIX', 'tlgrm_'.TELEGRAM_BOT_USERNAME.'_');