<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Sekati CodeIgniter Asset Helper
 *
 * @package		Sekati
 * @author		Jason M Horwitz
 * @copyright	Copyright (c) 2013, Sekati LLC.
 * @license		http://www.opensource.org/licenses/mit-license.php
 * @link		http://sekati.com
 * @version		v1.2.7
 * @filesource
 *
 * @usage 		$autoload['config'] = array('asset');
 * 				$autoload['helper'] = array('asset');
 * @example		<img src="<?=asset_url();?>imgs/photo.jpg" />
 * @example		<?=img('photo.jpg')?>
 *
 * @install		Copy config/asset.php to your CI application/config directory
 *				& helpers/asset_helper.php to your application/helpers/ directory.
 * 				Then add both files as autoloads in application/autoload.php:
 *
 *				$autoload['config'] = array('asset');
 * 				$autoload['helper'] = array('asset');
 *
 *				Autoload CodeIgniter's url_helper in `application/config/autoload.php`:
 *				$autoload['helper'] = array('url');
 *
 * @notes		Organized assets in the top level of your CodeIgniter 2.x app:
 *					- assets/
 *						-- css/
 *						-- download/
 *						-- img/
 *						-- js/
 *						-- less/
 *						-- swf/
 *						-- upload/
 *						-- xml/
 *					- application/
 * 						-- config/asset.php
 * 						-- helpers/asset_helper.php
 */

/*
|--------------------------------------------------------------------------
| Custom Asset Paths for asset_helper.php
|--------------------------------------------------------------------------
|
| URL Paths to static assets library
|
*/

$config['asset_path'] 		  = 'assets/';
$config['css_path'] 		  = 'assets/static/adminlte/css/';
$config['download_path'] 	  = 'assets/download/';
$config['less_path'] 		  = 'assets/less/';
$config['js_path'] 			  = 'assets/static/adminlte/js/';
$config['img_path'] 		  = 'assets/img/';
$config['swf_path'] 		  = 'assets/swf/';
$config['upload_path'] 		  = 'assets/upload/';
$config['xml_path'] 		  = 'assets/xml/';
$config['allowed_upload_ext'] = 'gif|jpg|png|jpeg|pdf|xls|xlsx|doc|docx';
$config['portfolio_path']     = 'assets/upload/portfolio';

$config['receipts'] = array(
	'upload_path'   => $config['upload_path'] . 'receipts/' . date('Y/md') . '/',
	'allowed_types' => 'gif|jpg|png|jpeg|pdf',
	'max_size'      => 16000, //in kb
	'max_width'     => 8000, //in pixels
	'max_height'    => 8000, //in pixels
	'encrypt_name'  => true,
);

$config['profile_photo'] = array(
	'upload_path'   => $config['upload_path'] . 'profile_photo/' . date('Y/md') . '/',
	'allowed_types' => 'gif|jpg|png|jpeg',
	'max_size'      => 4000, //in kb
	'max_width'     => 8000, //in pixels
	'max_height'    => 8000, //in pixels
	'encrypt_name'  => true,
);

$config['splash'] = array(
	'upload_path'   => $config['upload_path'] . 'splash/' . date('Y/md') . '/',
	'allowed_types' => 'zip',
	'max_size'      => 16000, //in kb
	'max_width'     => 8000, //in pixels
	'max_height'    => 8000, //in pixels
	'encrypt_name'  => false,
	'overwrite'     => true,
	'remove_spaces' => true,
);

$config['post'] = array(
	'upload_path'   => $config['upload_path'] . 'post/' . date('Y/md') . '/',
	'allowed_types' => 'gif|jpg|png|jpeg|pdf|xls|xlsx|doc|docx',
	'max_size'      => 64000, //in kb
	'max_width'     => 8000, //in pixels
	'max_height'    => 8000, //in pixels
	'encrypt_name'  => true,
	'overwrite'     => false,
	'remove_spaces' => true,
);

$config['voucher'] = array(
	'upload_path'   => $config['upload_path'] . 'voucher/' . date('Y/md') . '/',
	'allowed_types' => 'xls|xlsx|csv|txt',
	'max_size'      => 64000, //in kb
	'max_width'     => 8000, //in pixels
	'max_height'    => 8000, //in pixels
	'encrypt_name'  => false,
	'overwrite'     => false,
	'remove_spaces' => true,
);


$config['flipmag'] = array(
	'upload_path'   => $config['upload_path'] . 'flipmag/', // . date('Y/md') . '/',
	'allowed_types' => 'zip',
	'max_size'      => 10000000, //in kb
	'max_width'     => 800000, //in pixels
	'max_height'    => 800000, //in pixels
	'encrypt_name'  => false,
	'overwrite'     => true,
	'remove_spaces' => true,
);

$config['imlib_thumb'] = array(
	'image_library'  => 'gd2',
	'maintain_ratio' => true,
	'width'	         => 75,
	'height'	     => 75,
	'quality'        => '50%',
	'create_thumb'   => true,
);

$config['imlib'] = array(
	'image_library'  => 'gd2',
	'maintain_ratio' => true,
	'width'	         => 800,
	'height'	     => 600,
	'quality'        => '90%',
	'create_thumb'   => false,
);


/* End of file asset.php */
