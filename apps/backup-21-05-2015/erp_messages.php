<?php
exit;
//mzm : script to retrieve messages against a user id
//require db config class
require_once('db/db_config.php');


$user_id = isset($_REQUEST['id'] )?$_REQUEST['id']:'' ;

if(!$user_id){
$response['product']=array();
$response['success']=0;
$response['message']='User id is empty';
die(json_encode($response)); 
}

/*$cols = array("m.subject", "m.message" , "m.date", "concat( a.first_name, ' ', a.last_name ) as from_name");

$db->join("admin a", "a.id=m.from", "LEFT");
$db->where ("m.to = $user_id");
$db->orderBy("m.date","desc");
$messages = $db->get('messages m', 10,$cols);*/

//mzm updating to raw query as it involved 4 joins

$params = array($user_id);
$messages = $db->rawQuery("SELECT
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
where inno_messages.`to` = ?
ORDER BY inno_messages.date DESC LIMIT 20

", $params);








/*echo "Last executed query was ". $db->getLastQuery();

echo '<pre>';
print_r($messages);*/



//error for no messages

	if(empty($messages)){
		
		
		$response['product']=array();
		$response['success']=0;
		$response['message']='No Messages Found';
		die(json_encode($response));	
		
	}

	$products = array();
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
	
	
}
/*echo '<pre>';
print_r($products);


exit;*/
		$response['product']=$products;
		$response['success']=1;
		$response['message']='Messages request successful';



	die(json_encode($response)); 


?>