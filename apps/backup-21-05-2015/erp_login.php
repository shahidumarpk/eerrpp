<?php
exit;
//mzm : script to log user in

//require db config class
require_once('db/db_config.php');


$product = array();
$response = array();

$username = (isset($_REQUEST['username'] )?$_REQUEST['username']:'' ); 
$password = (isset($_REQUEST['password'] )?$_REQUEST['password']:'' ); ;


if(!$username || !$password ) {
	//check if username or password is empty
$product["id"] = 0;
$response["success"] = 0;
$response["message"]="Username or Password cannot be emtpy";
$response["product"]=$product;	
die( json_encode($response));
}
	



//encrypt password 
$encrypt_password = md5($_REQUEST['password']);
//confirm username and password in db
$db->where("username = '$username'");
$db->where("password = '$encrypt_password'");	
$user_details = $db->getOne('admin');


//json_encode(array('id',$user_details['id']))
if($user_details){ //found
$user_id= $user_details['id'];
$response["success"] = 1;
$response["message"]=" You are successfully login";
$response["user_id"]=$user_id;				
}else{ //error not found

$response["success"] = 0;
$response["message"]="Invalid User Name Or Password";
$response["user_id"]=$user_id;
	
}

die( json_encode($response));
 


?>