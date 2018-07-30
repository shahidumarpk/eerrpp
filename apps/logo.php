<?php
//mzm : script to retrieve messages against a user id
//require db config class
require_once('db/db_config.php');
//all output will be in json
header('Content-type: application/json');



$query="select * from inno_logo_images limit 1";


$logos= $db->rawQuery($query);

if($logos){

$result_array=array();
foreach($logos as $logos_result){
	
	$logo_array=array();
	$logo_array['id']=$logos_result['id'];
	$logo_array['logos']=SURL."adminBAS/assets/img/".$logos_result['images'];
    
	
	
	}


  header('Content-type: application/json');
		$response['success']=1;
		$response['message']="Data Showing Below";
		$response['data']=$logo_array;
		die(json_encode($response));

}


else{
	
	header('Content-type: application/json');
		$response['success']=0;
		$response['message']="no data found";
		$response['data']=array();
		die(json_encode($response));
	
	
	
	}




?>