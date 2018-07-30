<?php
//mzm database connection

//include db library
require_once('db/mysqlidb.php');

//include global helper
require_once('db/helper.php');
define('SURL','http://'.$_SERVER['HTTP_HOST'].'/projects/erp/');



$hostname_conn = '104.131.168.241';
$database_conn = 'taleemeq_erp';
$username_conn = 'taleemeq_erpusr';
$password_conn = 'VB$gLEW*LST0';


$hostname_conn = 'localhost';
$database_conn = 'bas_erp';
$username_conn = 'root';
$password_conn = 'XaPPPU1@VV';

//intialize connect db
//MysqliDb('host', 'username', 'password', 'databaseName');
$db = new MysqliDb($hostname_conn,$username_conn,$password_conn,$database_conn);
$db->setPrefix ('inno_');


?>