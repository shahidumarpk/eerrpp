<?php
//mzm : script to log user in

//require db config class
require_once('db/db_config.php');
//all output will be in json
header('Content-type: application/json');

$product = array();
$response = array();

$username = (isset($_REQUEST['username'] )?$_REQUEST['username']:'' ); 
$password = (isset($_REQUEST['password'] )?$_REQUEST['password']:'' ); 

$agent_detail = (isset($_REQUEST['model'] )?$_REQUEST['model']:'' ); 


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
$db->where("password ='$encrypt_password'");	
$user_details = $db->getOne('admin');
/*echo '<pre>';
print_r($user_details);exit;*/
//json_encode(array('id',$user_details['id']))
if($user_details)
{
$user_id= $user_details['id'];
$status=$user_details['status'];
if($status==0)
{
	
	
	$response["success"] = 2;
$response["message"]="Authentication failed contact admin to active your account";
//$response["user_id"]=$user_id;
$response["data"]=array();	
die( json_encode($response));
 
exit;	
}
$response["success"] = 1;
$response["message"]="You are successfully login";
$response["user_id"]=$user_id;		
$response["display_name"]=$user_details['display_name'];
$response["avatar"]='http://biralsabia.net/erp/adminBAS/assets/user_files/'.$user_id.'/'.$user_details['avatar_image'];

/*<img src="http://biralsabia.net/erp/adminBAS/assets/user_files//9045/user_avatar9045.jpg">*/



$random = $user_id . '' .rand();
$token_open = uniqid($random, true);
$token_encrypted_fordb  = md5($token_open);

//update token in db

$db_insert = array();
$db_insert['last_signin_date'] = date('Y-m-d G:i:s');
$db_insert['last_signin_ip'] = $_SERVER['REMOTE_ADDR'];
$db_insert['token'] = $token_encrypted_fordb;


$db->where ('id',$user_id );
if (!$db->update ('admin', $db_insert)){
	
	$response["success"] = 0;
$response["message"]="Error in Token Generation";
$response["user_id"]=$user_id;
}

$db_insert = array();
$db_insert['user_id'] = $user_id;
$db_insert['login_type'] = 0;
$db_insert['created_by'] = $user_id;
$db_insert['created_date'] = date('Y-m-d G:i:s');
$db_insert['created_by_ip'] = $_SERVER['REMOTE_ADDR'];
$db_insert['agent_detail'] = $agent_detail;
//insert an entry in login
$db->insert ('logging', $db_insert);
$response["token"] = $token_open;


//update login with current token)id

		
}
else
{ //error not found

$response["success"] = 0;
$response["message"]="Invalid User Name Or Password";
//$response["user_id"]=$user_id;
$response["display_name"]='';	
}

die( json_encode($response));
 


?>