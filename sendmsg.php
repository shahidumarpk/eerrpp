<?php
// please enter the api_key you received from google console
	$api_key = "AIzaSyAqnfloyjoEjhAcGNVdWTeRt1YDRFozNKg";
/*        $name = $_POST['name'];
        $deal = $_POST['deal'];
        $valid = $_POST['valid'];
        $address = $_POST['address'];
	*/
	// please enter the registration id of the device on which you want to send the message
	$registrationIDs= array("APA91bGyB4khpgYeZ4xn97jcR72YquLzvHZCWQOZuay4_syDhWnoadZGlpovd4bxisFjQS5O8apcjid3DnJ9_HeokYmK0EQ_L9WTBc_yAmSrjdcIO-fQ2vgXLRLYgmYdAxxEOSg31pxN");
	
	$project_message = "text of this year ago today that its first week and the rest assured me that they were going through this process will have ";
	//"message_id" => 150, "project_id"=>100, 
		$message = array("project_title" => "ERP PROJECT ANDRIOD APP", "message_detail" => $project_message, "from_name" => 'Shahid Umar' , 'message_id'=> 100 , 'project_id'=>150);
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
	
echo $result;
?>