<?php
//mzm : script to retrieve messages against a user id
//require db config class
require_once('db/db_config.php');
//all output will be in json
header('Content-type: application/json');

$request = $_REQUEST['request'];

if($request!='ios'){
	
		$response['success']=0;
		$response['message']='Request Param is Missing';
		$response['data']=array();
		die(json_encode($response));	
 
}

$params = array();
$projects = $db->rawQuery("

SELECT
	`inno_projects`.*, `inno_customers`.`first_name`,
	`inno_customers`.`last_name`,
	`inno_branches`.`branch_name`
FROM
	(`inno_projects`)
LEFT JOIN `inno_customers` ON `inno_projects`.`customer_id` = `inno_customers`.`id`
LEFT JOIN `inno_branches` ON `inno_projects`.`branch_id` = `inno_branches`.`id`


ORDER BY
	
	`id` DESC
	
	LIMIT 10 

");



/*	`inno_projects`.`status` IN (0, 1)
AND */




/*echo "Last executed query was ". $db->getLastQuery();

echo '<pre>';
print_r($projects);exit;*/



//error for no messages

	if(empty($projects)){
		
		
		
		$response['success']=0;
		$response['message']='No Projects Found';
		$response['data']=array();
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


//exit;*/
		
		$response['success']=1;
		$response['message']='Projects request successful';
		$response['data']=$products;

/*
echo '<pre>';
print_r($response);*/


	die(json_encode($response)); 


?>