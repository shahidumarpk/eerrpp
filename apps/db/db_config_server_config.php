<?php
//mzm database connection

//include db library
require_once('db/mysqlidb.php');

//include global helper
require_once('db/helper.php');

$hostname_conn = '104.131.168.241';
$database_conn = 'taleemeq_erp';
$username_conn = 'taleemeq_erpusr';
$password_conn = 'VB$gLEW*LST0';

//intialize connect db
//MysqliDb('host', 'username', 'password', 'databaseName');
$db = new MysqliDb($hostname_conn,$username_conn,$password_conn,$database_conn);
$db->setPrefix ('inno_');

define('SURL','http://'.$_SERVER['HTTP_HOST'].'/erp/'); 

?>