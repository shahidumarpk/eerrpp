<?php
//mzm : script to retrieve messages against a user id
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


//check if its a valid request from our IOS or Andriod Appuser
if(isset($_REQUEST['request']) &&  ($_REQUEST['request'] == 'ios' || $_REQUEST['request'] == 'android' )   ) {
	
	
	$app_type =  $_REQUEST['request'];
	
}else{
	
header('Content-type: application/json');
		$response['success']=0;
		$response['message']='Request is not Valid';
		$response['data']=array();
		die(json_encode($response));	
	
}


$user_id = isset($_REQUEST['user_id'] )?$_REQUEST['user_id']:'' ;
$token  = isset($_REQUEST['token'] )?$_REQUEST['token']:'' ;
$project_id = isset($_REQUEST['project_id'] )?$_REQUEST['project_id']:'' ;

$limit_start = isset($_REQUEST['limit_start'])?$_REQUEST['limit_start']:-1;
$limit = 10;


	
if(!$user_id){

$response['success']=0;
$response['message']='Autentication error. User id is empty';
$response['data']=array();
die(json_encode($response)); 
}

//check if token is emtpy
if(!$token){

$response['success']=0;
$response['message']='Autentication error. Token is empty';
$response['data']=array();
die(json_encode($response)); 
}


if(!$project_id){

$response['success']=0;
$response['message']='Project Id is empty';
$response['data']=array();
die(json_encode($response)); 
}


if($limit_start==(-1)){
	
header('Content-type: application/json');
	
	$response['product']=array();
	$response['success']=0;
	$response['message']='Limit Start is missing';
	die(json_encode($response));
	
}
	

$encrypted_token = md5($token);
//validate token }
$db->where("id = $user_id");
$db->where("token = '$encrypted_token'");	
$user_details = $db->getOne('customers');

if(empty($user_details )){
	

$response['success']=0;
$response['message']='Autentication error. Token is Invalid';
$response['data']=array();
die(json_encode($response)); 
	
}





$params = array($project_id);


$messages = $db->rawQuery("

SELECT
inno_project_messages.id,
inno_project_messages.project_id,
inno_project_messages.`to`,
inno_project_messages.`from`,
inno_project_messages.message,
inno_project_messages.user_type,
inno_project_messages.`status`,
inno_project_messages.created_by,
inno_project_messages.created_date,
inno_project_messages.created_by_ip,
concat( inno_admin.first_name , ' ' , inno_admin.last_name ) AS admin_name,
concat( inno_customers.first_name , ' ' , inno_customers.last_name ) AS client_name
FROM
inno_project_messages
LEFT JOIN inno_admin ON inno_project_messages.`from` = inno_admin.id
LEFT JOIN inno_customers ON inno_project_messages.`from` = inno_customers.id
WHERE
inno_project_messages.project_id = ?
ORDER BY
inno_project_messages.created_date DESC


LIMIT $limit_start , $limit

", $params);




$limit_start = $limit_start + $limit;




/*	`inno_projects`.`status` IN (0, 1)
AND */




/*echo "Last executed query was ". $db->getLastQuery();

echo '<pre>';
print_r($messages);exit;*/



//error for no messages

	if(empty($messages)){
		
		
	
		$response['success']=0;
		$response['message']='No Project Messages Found';
			$response['data']=array();
		die(json_encode($response));	
		
	}

//$product['customer_name']= stripcslashes(strip_tags($project['first_name'] .' '. $project['last_name']  ));
	$data = array();
	foreach($messages as $message){
			$row = array();
			$row['message_id']=$message['id'];
			
			
			if($message['user_type']=='c'){
			$row['from_name'] = $message['client_name'];	
			}else{
			$row['from_name'] =  $message['admin_name'];
			}
	
			$message_detail = $message['message'];
			$message_detail = preg_replace('/\v+|\\\[rn]/','',$message_detail); //removing /n
			$message_detail  = stripslashes($message_detail); //strip slashes
				$message_detail  = strip_tags( $message_detail,'<br><br/>');
			$row['message']=$message_detail;
	
	
			$row['date_posted']= date('d, M Y', strtotime($message['created_date'])) ;
			
			
			
	
	
	$data[] = $row; 
	
	
}
/*echo '<pre>';
print_r($products);


exit;*/
		
		$response['success']=1;
		$response['message']='Projects Messages Request Successful';
		$response['data']=$data;
		$response['limit_start']=(string)$limit_start;

	die(json_encode($response)); 


?>