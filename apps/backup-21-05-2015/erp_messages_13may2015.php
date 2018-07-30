<?php
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

$cols = array("m.subject", "m.message" , "m.date", "concat( a.first_name, ' ', a.last_name ) as from_name");

$db->join("admin a", "a.id=m.from", "LEFT");
$db->where ("m.to = $user_id");
$db->orderBy("m.date","desc");
$messages = $db->get('messages m', 10,$cols);
/*echo "Last executed query was ". $db->getLastQuery();
exit;*/
/*echo '<pre>';
print_r($messages);
$products = array();
foreach($messages as $message){
	$product = array();
	
	$product['subject']=$message['subject'];
	$product['message']=stripslashes($message['message']);
	$product['date']=$message['date'];
	$product['from_name']=$message['from_name'];
	
	$products[] = $product; 
	
	
}
echo '<pre>';
print_r($products);*/

$response['product']=$messages;
$response['success']=1;
$response['message']='Messages request successful';



die(json_encode($response)); 


?>