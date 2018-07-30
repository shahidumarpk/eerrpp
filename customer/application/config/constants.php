<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

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
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ',							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE',		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE',					'ab');
define('FOPEN_READ_WRITE_CREATE',				'a+b');
define('FOPEN_WRITE_CREATE_STRICT',				'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');

date_default_timezone_set('Asia/Karachi');

define('DEFAULT_TITLE','Welcome to NSOL ERP');
define('DEFAULT_META_KEYWORDS','NSOL');
define('DEFAULT_META_DESCRIPTION','NSOL');

define('SURL','http://'.$_SERVER['HTTP_HOST'].'/erp/customer/');
define('MURL','http://'.$_SERVER['HTTP_HOST'].'/erp/');
define('FRONT_SURL','http://'.$_SERVER['HTTP_HOST'].'/erp/');
define('ADMIN_SURL','http://'.$_SERVER['HTTP_HOST'].'/erp/adminBAS/');

define('IMG',SURL.'assets/img/');
define('CSS',SURL.'assets/css/');
define('FONTS',SURL.'assets/fonts/');
define('JS',SURL.'assets/js/');
define('VENDOR',SURL.'assets/vendor/');
define('AJAX',SURL.'assets/ajax/');
define('USER_FOLDER',SURL.'assets/user_files');

define('CUSTOMER_FOLDER',SURL.'../assets/customer_files');

define('ATTACHMENT',SURL.'../attachments/');

/* End of file constants.php */
/* Location: ./application/config/constants.php */