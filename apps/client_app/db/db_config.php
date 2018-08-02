<?php
//mzm database connection

//include db library
require_once('db/mysqlidb.php');

//include global helper
require_once('db/helper.php');
define('SURL','http://'.$_SERVER['HTTP_HOST'].'/');


if($_SERVER['SERVER_NAME']=='localhost'){
    $username_conn = 'root';
    $password_conn = '123123';
}else{
    $username_conn = 'erpuser';
    $password_conn = 'v4RzMsCNMJF8tRwM';
}



$hostname_conn = 'localhost';
$database_conn = 'erp';

//intialize connect db
//MysqliDb('host', 'username', 'password', 'databaseName');
$db = new MysqliDb($hostname_conn,$username_conn,$password_conn,$database_conn);
$db->setPrefix ('inno_');


?>