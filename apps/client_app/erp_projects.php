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
error_log( $time .   $data  .PHP_EOL , 3, "erp_projects.log");
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


$user_id = isset($_REQUEST['user_id'] )?$_REQUEST['user_id']:'' ;
$token  = isset($_REQUEST['token'] )?$_REQUEST['token']:'' ;

if(!$user_id){

$response['success']=0;
$response['message']='Autentication error. User id is empty';
//$response['data']=array();
die(json_encode($response)); 
}

//check if token is emtpy
if(!$token){

$response['success']=0;
$response['message']='Autentication error. Token is empty';
//$response['data']=array();
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
//$response['data']=array();
die(json_encode($response)); 
	
}





$params = array($user_id , ",%$user_id%,");


$projects = $db->rawQuery("

SELECT
	`inno_projects`.*, `inno_customers`.`first_name`,
	`inno_customers`.`last_name`
	
FROM
	(`inno_projects`)
LEFT JOIN `inno_customers` ON `inno_projects`.`customer_id` = `inno_customers`.`id`
WHERE

`inno_projects`.`customer_id` = ?

OR

`inno_projects`.`employee_assign` LIKE  ?

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
		
		
	
		$response['success']=0;
		$response['message']='No Projects Found';
		//$response['data']=array();
		die(json_encode($response));	
		
	}

//$product['customer_name']= stripcslashes(strip_tags($project['first_name'] .' '. $project['last_name']  ));
	$data = array();
	foreach($projects as $project){
			$row = array();
			$row['project_id']=$project['id'];
			$row['project_title']= stripcslashes(strip_tags($project['project_title']));
			
			$row['start_date']= date('d, M Y', strtotime($project['start_date'])) ;
			$row['end_date']= date('d, M Y', strtotime($project['end_date'])) ;
			
			
			
	
	
	$data[] = $row; 
	
	
}
/*echo '<pre>';
print_r($products);


exit;*/
		
		$response['success']=1;
		$response['message']='Projects request successful';
		$response['data']=$data;


	die(json_encode($response)); 


?>