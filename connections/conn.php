<?php

# FileName="Connection_php_mysql.htm"

# Type="MYSQL"

# HTTP="true"

//error_reporting(0);

$hostname_conn = 'localhost';
$database_conn = 'erp';
$username_conn = 'root';
$password_conn = 'F1F4@soft';
$conn = mysql_connect($hostname_conn, $username_conn, $password_conn) or trigger_error(mysql_error(),E_USER_ERROR); 
mysql_select_db($database_conn, $conn);
?>