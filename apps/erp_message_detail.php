<?php
//mzm : script to retrieve messages against a user id
//require db config class
require_once('db/db_config.php');
//all output will be in json
//header('Content-type: application/json');


$message_id = isset($_REQUEST['message_id'] )?$_REQUEST['message_id']:'' ;
$user_id = isset($_REQUEST['id'] )?$_REQUEST['id']:'' ;
$token  = isset($_REQUEST['token'] )?$_REQUEST['token']:'' ;


if(!$message_id){

$response['success']=0;
$response['message']='Message id is empty';
die(json_encode($response)); 
}


if(!$user_id){

$response['success']=0;
$response['message']='Autentication error. User id is empty';
die(json_encode($response)); 
}

//check if token is emtpy
if(!$token){

$response['success']=0;
$response['message']='Autentication error. Token is empty';
die(json_encode($response)); 
}
// check the status of user
$db->where("id = $user_id");	
$user_details = $db->getone('admin');
if($user_details['status']==0)
{
	$response['success']=2;
$response['message']='Yor are not an authenticated user please contact administrator ';
die(json_encode($response));
	
}



$encrypted_token = md5($token);
//validate token }
$db->where("id = $user_id");
$db->where("token = '$encrypted_token'");	
$user_details = $db->getOne('admin');

if(empty($user_details )){
	

$response['success']=0;
$response['message']='Autentication error. Token is Invalid';
die(json_encode($response)); 
	
}



/*$cols = array("m.subject", "m.message" , "m.date", "concat( a.first_name, ' ', a.last_name ) as from_name");

$db->join("admin a", "a.id=m.from", "LEFT");
$db->where ("m.to = $user_id");
$db->orderBy("m.date","desc");
$messages = $db->get('messages m', 10,$cols);*/

//mzm updating to raw query as it involved 4 joins

$params = array($message_id);
$messages = $db->rawQuery("SELECT
inno_messages.`id`,
inno_messages.`to`,
inno_messages.`from`,
inno_messages.`subject`,
inno_messages.message,
inno_messages.message_id,
inno_messages.project_message_id,
inno_project_messages.message AS project_message,
inno_project_messages.user_type,
inno_messages.date,
concat(inno_admin.first_name , ' ' , inno_admin.last_name  ) as admin_name ,
concat(inno_customers.first_name , ' ' , inno_customers.last_name  ) as customer_name

FROM
inno_messages
LEFT JOIN inno_project_messages ON inno_messages.project_message_id = inno_project_messages.id
LEFT JOIN inno_admin ON inno_messages.`from` = inno_admin.id
LEFT JOIN inno_customers ON inno_messages.`from` = inno_customers.id
where inno_messages.`id` =  ?


", $params);








/*echo "Last executed query was ". $db->getLastQuery();

echo '<pre>';
print_r($messages); exit;*/



//error for no messages

	if(empty($messages)){
		
		

		$response['success']=0;
		$response['message']='No Messages Found';
		die(json_encode($response));	
		
	}
	
	
	$message = $messages[0];
	
	
	$response['message_id']=$message['id'];
	$response['subject']= strip_tags( stripslashes($message['subject']));
	$response['date']=$message['date'];
	
	//check if it is customer message or admin message
	
	if($message['user_type']=='c'){
			$response['from_name'] = $message['customer_name'];	
	}else{
			$response['from_name'] =  $message['admin_name'];
	}
	
	//check message id is zero read from messages table. Otherwise read from project messages 
	
	if($message['project_message_id']==0){
		
			$message=  $message['message'];		
	}else{
			$message =  $message['project_message'];
		
	}
	
	//string operation remove tags and extra slashes
	//$response['message_detail'] = strip_tags( stripslashes($message),'<br><br/>');
	
	//$response['message_detail'] = strip_tags( stripslashes($message),'');
	
	
	//$response['message_detail'] = (nl2br($message)) ;//stripslashes(nl2br($message));
	
	//nl2br not working so lets try manual replace
	
	//$message  = stripslashes($message);
	$message = preg_replace('/\v+|\\\[rn]/','',$message); //removing /n
	$message  = stripslashes($message); //strip slashes
	
	$response['message_detail'] = $message;

	
	

	/*$products = array();
	foreach($messages as $message){
			$product = array();
		
			$product['subject']= strip_tags( stripslashes($message['subject']));
			$product['date']=$message['date'];
	
	//check if it is customer message or admin message
	
	if($message['user_type']=='c'){
			$product['from_name'] = $message['customer_name'];	
	}else{
			$product['from_name'] =  $message['admin_name'];
	}
	
	//check message id is zero read from messages table. Otherwise read from project messages 
	
	if($message['project_message_id']==0){
		
			$message=  $message['message'];		
	}else{
			$message =  $message['project_message'];
		
	}
	
	//string operation remove tags and extra slashes
	$product['message'] = strip_tags( stripslashes($message),'<br><br/>');
	
	//$product['message'] = strip_tags( stripslashes($message));
	
	$products[] = $product; 
	
	
}*/
/*echo '<pre>';
print_r($products);


exit;*/



		
		$response['success']=1;
		$response['message']='Messages request successful';



//update messages read status
	$db_insert = array();
	$db_insert['message_status']=1;
	$db_insert['last_modified_date'] = date('Y-m-d G:i:s');
	$db_insert['last_modified_ip'] = 'Andriod App';
	$db_insert['last_modified_by'] = $user_id;
	
	$db->where ('id',$message_id );
	if (!$db->update ('messages', $db_insert)){
	
	
	
		
		$response['success']=0;
		$response['message']='Error in Mesage Status Update';
		
		die(json_encode($response));
	}
	
	


	die(json_encode($response)); 


?>