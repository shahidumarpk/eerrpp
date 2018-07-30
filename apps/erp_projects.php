<?php
//mzm : script to retrieve messages against a user id
//require db config class
require_once('db/db_config.php');
//all output will be in json
header('Content-type: application/json');


$user_id = isset($_REQUEST['id'] )?$_REQUEST['id']:'' ;
$token  = isset($_REQUEST['token'] )?$_REQUEST['token']:'' ;

if(empty($user_id)){
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





$user_search = "%,$user_id,%";
$params = array($user_search);


$projects = $db->rawQuery("

SELECT
	`inno_projects`.*, `inno_customers`.`first_name`,
	`inno_customers`.`last_name`,
	`inno_branches`.`branch_name`
FROM
	(`inno_projects`)
LEFT JOIN `inno_customers` ON `inno_projects`.`customer_id` = `inno_customers`.`id`
LEFT JOIN `inno_branches` ON `inno_projects`.`branch_id` = `inno_branches`.`id`
WHERE

`inno_projects`.`project_assign` LIKE ?

ORDER BY
	
	`id` DESC

", $params);



/*	`inno_projects`.`status` IN (0, 1)
AND */




/*echo "Last executed query was ". $db->getLastQuery();

echo '<pre>';
print_r($messages);exit;*/



//error for no messages

	if(empty($projects)){
		
		
		$response['product']=array();
		$response['success']=0;
		$response['message']='No Projects Found';
		die(json_encode($response));	
		
	}

	$products = array();
	foreach($projects as $project){
			$product = array();
			$product['project_id']=$project['id'];
			$product['project_title']= stripcslashes(strip_tags($project['project_title']));
			$product['customer_name']= stripcslashes(strip_tags($project['first_name'] .' '. $project['last_name']  ));
			$product['start_date']= date('d, M Y', strtotime($project['start_date'])) ;
			$product['end_date']= date('d, M Y', strtotime($project['end_date'])) ;
			$product['branch_name']= stripcslashes(strip_tags($project['branch_name']));
			
			
	
	
	$products[] = $product; 
	
	
}
/*echo '<pre>';
print_r($products);


exit;*/
		$response['product']=$products;
		$response['success']=1;
		$response['message']='Projects request successful';



	die(json_encode($response)); 


?>