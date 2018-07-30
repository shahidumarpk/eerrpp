<?php
//mzm database connection

//include db library
require_once('db/mysqlidb.php');

//include global helper
require_once('db/helper.php');

$hostname_conn = 'localhost';
$database_conn = 'erp';
$username_conn = 'root';
$password_conn = '123123';

//intialize connect db
//MysqliDb('host', 'username', 'password', 'databaseName');
$db = new MysqliDb($hostname_conn,$username_conn,$password_conn,$database_conn);
$db->setPrefix ('inno_');

define('SURL','http://'.$_SERVER['HTTP_HOST'].'/erp/'); 

?>