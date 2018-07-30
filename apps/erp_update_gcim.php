<?php
//mzm : script to log user in

//require db config class
require_once('db/db_config.php');
//all output will be in json
header('Content-type: application/json');

$enable_login = 0;


if($enable_login){

$data = ' GET DATA ' . print_r($_GET,1);
$data .= ' POST DATA ' . print_r($_POST,1);
$time = @date('[d/M/Y:H:i:s]');
error_log( $time .   $data  .PHP_EOL , 3, "request.log");
}



$user_id = isset($_REQUEST['user_id'] )?$_REQUEST['user_id']:'' ;
$token  = isset($_REQUEST['token'] )?$_REQUEST['token']:'' ;
$regid  = isset($_REQUEST['regid'] )?$_REQUEST['regid']:'' ;
if(!$user_id){
$response['product']=array();
$response['success']=0;
$response['message']='Autentication error. User id is empty';
die(json_encode($response)); 
}

//check if token is emtpy
if(!$token){
$response['product']=array();
$response['success']=0;
$response['message']='Autentication error. Token is empty';
die(json_encode($response)); 
}

//check if gcim/regiid is emtpy
if(!$regid){
$response['product']=array();
$response['success']=0;
$response['message']='Autentication error. Token is empty';
die(json_encode($response)); 
}


$encrypted_token = md5($token);
//validate token }
$db->where("id = $user_id");
$db->where("token = '$encrypted_token'");	
$user_details = $db->getOne('admin');

if(empty($user_details )){
	
$response['product']=array();
$response['success']=0;
$response['message']='Autentication error. Token is Invalid';
die(json_encode($response)); 
	
}


//update token in db

$db_insert = array();
$db_insert['last_signin_date'] = date('Y-m-d G:i:s');
$db_insert['last_signin_ip'] = $_SERVER['REMOTE_ADDR'];
$db_insert['gcm_regid'] = $regid;


$db->where ('id',$user_id );
if (!$db->update ('admin', $db_insert)){
	
$response["success"] = 0;
$response["message"]="Error in updating gcim id";
$response["user_id"]=$user_id;
die(json_encode($response));
}else{
	
	$response["success"] = 1;
$response["message"]="gcim id updated successfully";
$response["user_id"]=$user_id;
die(json_encode($response));
	
}




 


?>