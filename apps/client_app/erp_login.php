<?php
//mzm : script to log user in
//error_reporting(0);
//require db config class
require_once('db/db_config.php');
//all output will be in json
header('Content-type: application/json');

$enable_login = 0;


if($enable_login){

$data = ' GET DATA ' . print_r($_GET,1);
$data .= ' POST DATA ' . print_r($_POST,1);
$time = @date('[d/M/Y:H:i:s]');
error_log( $time .   $data  .PHP_EOL , 3, "erp_login.log");
}


//check if its a valid request from our IOS or Andriod Appuser
if(isset($_REQUEST['request']) &&  ($_REQUEST['request'] == 'ios' || $_REQUEST['request'] == 'android' )   ) {	
	$app_type =  $_REQUEST['request'];
}else{
	
		header('Content-type: application/json');
		$response['success']=0;
		$response['message']='Request is not Valid';
		//$response['data']=array();
		die(json_encode($response));	
	
}




$response = array();

$username = (isset($_REQUEST['username'] )?$_REQUEST['username']:'' ); 
$password = (isset($_REQUEST['password'] )?$_REQUEST['password']:'' ); 

//$agent_detail = (isset($_REQUEST['model'] )?$_REQUEST['model']:'' ); 


if(!$username || !$password ) {
	//check if username or password is empty
$response["success"] = 0;
$response["message"]="Username or Password cannot be emtpy";
//$response["data"]=array();	
die( json_encode($response));
}
	



//encrypt password 
$encrypt_password = md5($_REQUEST['password']);
//confirm username and password in db
$db->where("username = '$username'");
$db->where("password = '$encrypt_password'");	
$user_details = $db->getOne('customers');
/*echo '<pre>';
print_r($user_details);exit;*/

if($user_details){ //found
$user_id= $user_details['id'];

$data = array();
$data["user_id"]=$user_id;		
$data["display_name"]=$user_details['first_name'] . ' ' .  $user_details['last_name'];
$data["avatar"]=SURL.$user_id.'/'.$user_details['profile_image'];


$random = $user_id . '' .rand();
$token_open = uniqid($random, true);
$token_encrypted_fordb  = md5($token_open);

//update token in db

$db_insert = array();
$db_insert['last_signin_date'] = date('Y-m-d G:i:s');
$db_insert['last_signin_ip'] = $_SERVER['REMOTE_ADDR'];
$db_insert['token'] = $token_encrypted_fordb;


$db->where ('id',$user_id );
if (!$db->update ('customers', $db_insert)){
	
$response["success"] = 0;
$response["message"]="Error in Token Generation";
//$response["data"]=array();
die( json_encode($response));
}

$db_insert = array();
$db_insert['user_id'] = $user_id;
$db_insert['login_type'] = 0;
$db_insert['created_by'] = $user_id;
$db_insert['created_date'] = date('Y-m-d G:i:s');
$db_insert['created_by_ip'] = $_SERVER['REMOTE_ADDR'];
$db_insert['agent_detail'] = $app_type;

//insert an entry in login
$db->insert ('logging', $db_insert);
	



//json_encode(array('id',$user_details['id']))

$data["token"] = $token_open;

$response["success"] = 1;
$response["message"]="Login Successfull.";
$response["data"]= $data;
die( json_encode($response));


		
}else{ //error not found
$data=array("m" => "failed");
$response["success"] = 0;
$response["message"]="Invalid User Name Or Password";
//$response["data"]=$data;
die( json_encode($response));	
}







 


?>