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

$data = $_POST;
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
$project_message = isset($_REQUEST['project_message'] )?$_REQUEST['project_message']:'' ;




	
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


if(!$project_message){

$response['success']=0;
$response['message']='Project Message is empty';
$response['data']=array();
die(json_encode($response)); 
}

// check the status of user
$db->where("id = $user_id");	
$user_details = $db->getone('admin');
if($user_details['status']==0)
{
	$response['success']=2;
$response['message']='Yor are not an authenticated user please contact administrator';
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
$response['data']=array();
die(json_encode($response)); 
	
}


//insert project message
$db_insert = array();

		$db_insert = array(
		    'project_id' => $project_id,
		    'to' => 1,
			'from' => $user_id,
			'message' => $project_message,
			'user_type' => 'u',
			'created_by' => $user_id,
		    'created_date' => date('Y-m-d G:i:s'),
		    'created_by_ip' => $_SERVER['REMOTE_ADDR']
		);		


//insert an entry in login
$project_message_id = $db->insert ('project_messages', $db_insert);

if(!$project_message_id){
	
		$response['success']=0;
		$response['message']='Server Error Posting Message';
		$response['data']=array();
		die(json_encode($response));
	
}



//send notificaitons
//get project detail first for member id's


$db->where("id = $project_id");

$project_details = $db->getOne('projects');

/*echo '<pre>';
print_r($project_details);
echo '</pre>';*/
	
//project members		 
$project_members =  explode(',',$project_details['project_assign']);
/*echo '<pre>';
print_r($project_members);		
echo '</pre>';*/	
	 
		 $project_notifications = array();
		 $message_subject="You have recieved a new message on project
		   (<b> <a href=".SURL."adminBAS/projects/manage-projects/project-detail/".$project_id." target='_blank' >
		   ".$project_details['project_title']."</a></b>)";
		
		$gcim_regid_arr = array();
		$gcim_regid_arr2 = array();
		 foreach($project_members as $member){
		
			if($member == $user_id || $member == ''){
				continue; //skip incase member matches current user_id or memberid is blank
			}
		
		
			$message_id = random_number_generator(7);
			 
			 $ins_data_row = array(
		    'to' => $member,
		    'from' => $user_id,
		    'subject' => $message_subject,
			//'message' => $this->db->escape_str(trim(nl2br($message))),
		    'message_id' => $message_id,
			'project_message_id' => $project_message_id,
			'attachment' => '',
			'created_by' => $user_id,
		    'date' => date('Y-m-d G:i:s'),
		    'created_by_ip' => $_SERVER['REMOTE_ADDR'],
			'notification' => 1
		    );
			
		

			 
				
 		$db->insert('messages', $ins_data_row);	
						 
			//send push notification as well
			
			$db->where("id = $member");

			$user_detail = $db->getOne('admin');

			$gcim_regid = $user_detail['gcm_regid'] ; 
			
			if($gcim_regid){
				
		$gcim_regid_arr[]=$gcim_regid ;
		$gcim_regid_arr2[]= $member;
				
				
	
			}
			 
		 }
		/* echo '<pre>';
		 print_r($gcim_regid_arr);
 		print_r($gcim_regid_arr2);*/


//SEND push notification to client as well


$client_id = $project_details['customer_id'];

//check if customer has gcim id
 //check for push notification
			$db->where("id = $client_id");

			$user_detail = $db->getOne('customers');

			$gcim_regid = $user_detail['gcm_regid'] ; 
			
			if($gcim_regid){
				
				$gcim_regid_arr[]=$gcim_regid ;
			$gcim_regid_arr2[]= $member;
				
				
	
			}
			


////send push notification
//
$registrationIDs = $gcim_regid_arr;
if(!empty($registrationIDs)){

$api_key = "AIzaSyAqnfloyjoEjhAcGNVdWTeRt1YDRFozNKg";
/*	
	$project_message = "text of this year ago today that its first week and the rest assured me that they were going through this process will have ";*/
	//"message_id" => 150, "project_id"=>100, 
		$message = array("project_title" => $project_details['project_title'], "message_detail" => $project_message, "from_name" => $user_details['first_name'] . ' ' .  $user_details['last_name']  , 'message_id'=> $message_id , 'project_id'=>$project_id);
	$url = 'https://android.googleapis.com/gcm/send';
	$fields = array(
                'registration_ids'  => $registrationIDs,
                'data'              => array( "message" => $message ),
                );

	$headers = array(
					'Authorization: key=' . $api_key,
					'Content-Type: application/json');
					
					
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt( $ch, CURLOPT_POST, true );
	curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers);
	curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
	curl_setopt( $ch, CURLOPT_POSTFIELDS, json_encode( $fields ) );
	$result = curl_exec($ch);
	curl_close($ch);
	
	//echo $result;
	
} 


	// echo '<pre>';
		// print_r($gcim_regid_arr);
 		//print_r($gcim_regid_arr2);
		
	
//all is well

	
		$response['success']=1;
		$response['message']='Projects Messages Posted Successfully';
		$response['data']=$data;
		die(json_encode($response)); 


?>