 <?php
//mzm : script to retrieve messages against a user id
//require db config class
require_once('db/db_config.php');
//all output will be in json







if(isset($_GET['form_test']) &&  $_REQUEST['form_test']==1){
	
?>

<form method="post" action="">
User Name : <input type="text" name="name">
<input type="hidden"  value="ios" name="request">
<input type="hidden"  value="0" name="form_test">
<input type="submit">
</form>


<?php	
	
	
	exit;
	
}

header('Content-type: application/json');
$request = $_REQUEST['request'];
if($request!='ios'){
	
		$response['success']=0;
		$response['message']='Request Param is Missing';
		$response['data']=array();
		die(json_encode($response));	
 
}



if(empty($_POST)){
	
		$response['success']=0;
		$response['message']='No Post Data Recieved';
		$response['data']=array();
		die(json_encode($response));	
	
}



$data = array();

/*$data['user_id'] = '1';
$data['user_displayname'] = 'Loviza';
$data['account_status'] = '1';*/


		
		
		
$to = "zeeshanmalik2011@gmail.com";
$subject = "Investigator IOS Signup Webservice";
$txt = "Investigator IOS SIGNUP WEBSERVICE DATA <br><br><br>" . print_r($_POST,1); 


$headers = "From: biralsabia.net" . "\r\n" .
"";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

mail($to,$subject,$txt,$headers);
		
		
		$response['success']=1;
		$response['message']='Data Recieved';
		$response['data']= $_POST;
		die(json_encode($response));
		
		
	


		



?>