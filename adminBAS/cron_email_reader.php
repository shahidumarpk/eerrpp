<?php
require_once("connections/conn.php"); // Database Connection
//include('functions.php'); 
// Functions
/***************************************************/
// Function Getting Parent ID . 
function get_customer_id($email){
	$sql_customer = "SELECT * FROM inno_customers WHERE email_address = '".$email."'" ;
	$exe_customer = mysql_query($sql_customer);              				
	$is_record = mysql_num_rows($exe_customer);


	if($is_record > 0){


		$res_customer = mysql_fetch_array($exe_customer);


		$customer_id = $res_customer['id'];	


	}else{


		$customer_id = 0;	


	}


	return $customer_id ;	


 } 





// Function Checking Ticket Number is exist in database . 


function checkticket($ticketnum){


	 $ticketnum = '##'.$ticketnum.'##';


	 $sql_ticket = mysql_query("SELECT * FROM inno_tickets  WHERE ticket_number = '".$ticketnum."'");                				


	 $ticket_count = mysql_num_rows($sql_ticket);				


 	 if($ticket_count > 0){


		 $status = 'success' ;  


	 }else{


		 $status = 'failure' ;  	


	 }


	return $status ; 


 } 





// Generating the random number . 


function generateticket($no){


		$totalChar = $no;  //length of random number


		$salt = "0123456789";  // salt to select chars


		srand((double)microtime()*1000000); // start the random generator


		$password=""; // set the inital variable


		for ($i=0;$i<$totalChar;$i++)  // loop and create number


		$randnumber= $randnumber. substr ($salt, rand() % strlen($salt),1);


		return '##'.$randnumber.'##' ;


 }


  





function emaifilter($emailmessages,$cust_email){


		 if(strpos($cust_email, 'gmail.com')){ 


			$messagearr = preg_split("/On Mon,|On Tue,|On Wed,|On Thu,|On Fri,|On Sat,|On Sun,/", $emailmessages);


		 }elseif(strpos($cust_email, 'yahoo.com')){


				if(strpos($emailmessages, '0A0A0A')){


					$messagearr = preg_split("/0A0A0A|0A/", $emailmessages);


				}else{


					$messagearr = preg_split("/=0A=0A=,|=0A,/", $emailmessages);	


				}


		 }


		 elseif(strpos($cust_email, 'hotmail.com')){


			$messagearr = preg_split("/To: ,/",$emailmessages);


			


		 }elseif(strpos($emailmessages, 'urn:schemas-microsoft-com:office:office')){


			 


			$messagearr = preg_split("/<div,/",$emailmessages);


			


		 }else{


			 $messagearr = preg_split("/On Mon,|On Tue,|On Wed,|On Thu,|On Fri,|On Sat,|On Sun,/", $emailmessages);


		 }


		 


		 if(strpos($messagearr[0],'InnoTech')){


			$messagearr 	= explode("InnoTech",$messagearr[0]);


			$messagearr[0] 	= substr( $messagearr[0],0,strlen($messagearr[0])-30);


			$messagearr[0]  = str_replace(".=20",'',$messagearr[0] );


		 }


 return $messagearr[0] ; 


					 


}





function getusername($id){


	 $sql_user = mysql_query("SELECT * FROM inno_customers WHERE id = '".$id."'");                				


	 $res_user = mysql_fetch_array($sql_user);			


	 return $res_user['first_name']." ".$res_user['last_name'];			


 }


 





/**************************************************/


require_once('ImapMailbox.php');


ini_set("max_execution_time",360);


define('EMAIL', 'support@biralsabia.net');


define('PASSWORD', '5XQ11a&h-REd');


define('ATTACHMENTS_DIR', dirname(__FILE__) . '/attachments');


function stripSingleTags($tags, $string)


{


    foreach( $tags as $tag )


    {


        $string = preg_replace('#</?'.$tag.'[^>]*>#is', '', $string);


    }


    return $string;


}





$mailbox = new ImapMailbox('{askinnotech.com:143/novalidate-cert}INBOX', EMAIL, PASSWORD, ATTACHMENTS_DIR, 'utf-8');


$mails = array();


// Get some mail


$mailsIds = $mailbox->searchMailBox('UNSEEN');





if(!$mailsIds) {


	die('Mailbox is empty');


}





echo "<pre>";


$mailId = reset($mailsIds);


echo count($mailsIds) ; 


exit;


//0 - Open Ticket , 1 - Process Ticket , 2 - Close Request , 3 - Closed Ticket  





for($g=0;$g<count($mailsIds);$g++){ // Total Number of emails 


	$mail = $mailbox->getMail($mailsIds[$g]);


	$attachments = $mail->getAttachments();


	foreach($mail->attachments as $key => $value){


	$attachment_name[] = $value->id.'_'.$value->name ;


	}


	//echo "<pre>";


	//print_r($attachment_name);


	//exit;


/***********************************************************************************************************/


		


		$ticketnum = '';  





		$subject = '' ; 


		$ticketnumberarr = explode('##',$mail->subject); // going to seperating the ticket number


//echo "<pre>"; print_r($ticketnumberarr); exit;


 		$ticketnum = $ticketnumberarr['1'] ;





		$subject = addslashes($ticketnumberarr['2']) ;





		$tstatus = checkticket($ticketnum) ; //Checking Ticket Number is exist in database . 





			// IF Checking Ticket Number is exist in database . 


			if($tstatus == 'success'){ 


				


				$cust_email = $mail->fromAddress ;





				$pid = get_customer_id($cust_email) ; 	// Getting Parent ID from Database .





				 $ctnumber = $ticketnum;





				 $ticketnum = '##'.$ticketnum.'##';


				 


				


								 if($mail->textHtml != ""){ 	


				 					$message_detail = $mail->textHtml ;


								 }else{


									$message_detail = $mail->textPlain ;


								 }


								


								 $msgemaifilter =  emaifilter($message_detail,$cust_email) ; // Email Filter


				


								 $explod_message = explode('###',$msgemaifilter);


				


								 $message_detail = $explod_message[0];// explode message


				


								 $tags = array('div,p');


								 $message_detail = stripSingleTags($tags,$message_detail);


								 


								 $message_detail = addslashes($message_detail);


				 





				//If Parent ID is not equal to zero , (Parent ID is Exist in Database) .


				if($pid != 0){


				 // Fetching Re


				 $sql_ticket = mysql_query("SELECT * FROM inno_tickets WHERE ticket_number = '".$ticketnum."' order by id DESC") or die(mysql_error());


				 $ticket_count = mysql_num_rows($sql_ticket);					


				 $res_ticket = mysql_fetch_array($sql_ticket);	


				 //inserting the record into Database.


				$sql_insert = "INSERT INTO inno_tickets  SET customer_id = '".$res_ticket['customer_id']."' ,department_id = '".$res_ticket['department_id']."' ,source = 'Email',subject = '".$subject."' ,priority = '".$res_ticket['priority']."',details = '".$message_detail."',commited_date = '".$res_ticket['commited_date']."',user_type = 'C',ticket_number = '".$ticketnum."',ticket_status = '1',created_by='".$res_ticket['customer_id']."',created_date=NOW();" ;


				$exe = mysql_query($sql_insert) or die(mysql_error()); //Inserting the tickets


				


				for($t=0;$t<count($attachment_name);$t++){


					$sql_insert = "INSERT INTO inno_email_attachments  SET attachment='".$attachment_name[$t]."',ticket_number ='".$ticketnum."',created_by='0',created_date ='".date('Y-m-d g:i:a')."',created_by_ip = '".$_SERVER['REMOTE_ADDR']."'" ;


					$exe = mysql_query($sql_insert) or die(mysql_error()); //Inserting the tickets Attachments .


				 }


				 


				 


				if($exe){ echo "Done"; }


				}else{


					


				 $sql_ticket = mysql_query("SELECT * FROM inno_tickets WHERE ticket_number = '".$ticketnum."' order by id DESC")  or die(mysql_error());                				


				 $ticket_count = mysql_num_rows($sql_ticket);					


				 $res_ticket = mysql_fetch_array($sql_ticket);	


				 //inserting the record into Database.


				 echo $sql_insert = "INSERT INTO inno_tickets  SET customer_id = '0' ,department_id = '".$res_ticket['department_id']."' ,source = 'Email', subject = '".$subject."' ,priority = '".$res_ticket['priority']."',details = '".$message_detail."',commited_date = '".$res_ticket['commited_date']."',user_type = 'C',ticket_number = '".$ticketnum."',ticket_status = '1',created_by='".$res_ticket['customer_id']."',created_date=NOW();" ;


			 $exe = mysql_query($sql_insert) or die(mysql_error()); //Inserting the tickets


			


			for($t=0;$t<count($attachment_name);$t++){


					$sql_insert = "INSERT INTO inno_email_attachments  SET attachment='".$attachment_name[$t]."',ticket_number ='".$ticketnum."',created_by='0',created_date ='".date('Y-m-d g:i:a')."',created_by_ip = '".$_SERVER['REMOTE_ADDR']."'" ;


					$exe = mysql_query($sql_insert) or die(mysql_error()); //Inserting the tickets Attachments .


			 }


				 


			 


					if($exe){ echo "Done"; }


			  } // END Of If Parent ID is not equal to zero , (Parent ID is Exist in Database) .





			}elseif($tstatus == 'failure'){


					


				//From Email Address


				$cust_email = $mail->fromAddress ;





				$pid = get_customer_id($cust_email) ; 	// Getting Parent ID from Database .


                	$temp_committed_date = mktime(0, 0, 0, date("m"), date("d")+3, date("y"));


					$committed_date =  date("Y-m-d", $temp_committed_date); 


					//If Parent Id email exists in database .


					if($pid != 0){


								$cutomer_name 	= getusername($pid);


								$department_id	=	'23';	


								$tnumber 		= generateticket(8); // Generating the New Ticket number


								$ctnumber 		= str_replace('#','',$tnumber) ;


							    


								


								 if($mail->textHtml != ""){ 	


				 					$message_detail = $mail->textHtml ;


								 }else{


									$message_detail = $mail->textPlain ;


								 }


								


								 $msgemaifilter =  emaifilter($message_detail,$cust_email) ; // Email Filter


				


								 $explod_message = explode('###',$msgemaifilter);


				


								 $message_detail = $explod_message[0];// explode message


								 


				                $tags = array('div,p');


								 $message_detail = stripSingleTags($tags,$message_detail);


								 


								 $message_detail = addslashes($message_detail);


								


								//inserting the record into Database.


								 $sql_insert = "INSERT INTO inno_tickets  SET customer_id = '".$pid."' ,department_id = '".$department_id."' ,source = 'Email', subject = '".addslashes($mail->subject)."' ,priority = 'normal',details = '".$message_detail."',commited_date = '".$committed_date."',user_type = 'C',ticket_number = '".$tnumber."',is_parent = '1',ticket_status = '0',created_by='".$pid."',created_date=NOW();" ;


								$exe 			= mysql_query($sql_insert) or die(mysql_error().$sql_insert); //Inserting the tickets


								$tid 			= mysql_insert_id();//auto incremnt last id from tickets


								


								for($t=0;$t<count($attachment_name);$t++){


					$sql_insert = "INSERT INTO inno_email_attachments  SET attachment='".$attachment_name[$t]."',ticket_number ='".$tnumber."',created_by='0',created_date ='".date('Y-m-d g:i:a')."',created_by_ip = '".$_SERVER['REMOTE_ADDR']."'" ;


					$exe = mysql_query($sql_insert) or die(mysql_error()); //Inserting the tickets Attachments .


			 						}


								


								


							/*********************** Sending Email to Customer ********************/


								echo $to =  $mail->fromAddress ;


								$from = 'support@innotech.com' ; 


								$subject = $tnumber.' '.stripslashes($mail->subject) ;


								$emailbody = '<table align="center" width="100%">


								<tr>


									<td align="left">Dear valuable Customer,</td>


								</tr>


								<tr>


									<td align="left"> Thank you for contacting us. This is an automated response confirming  the receipt of your ticket. One of our agents will get back to you as  soon as possible. For your records, the details of the ticket are listed below.Our Customer Support team will make sure that your queries and issues are addressed within 48 to 72 working hours. 


									<br/>


									Ticket ID:  <b>'.$ctnumber.'</b> <br />


									Subject: <b>'.stripslashes($mail->subject).'</b>.<br />  


								 </td>


								</tr>


								<tr><td>&nbsp;</td></tr>


								<tr>


									<td>


									<b>Regards</b>,<br>


									Customer Support


									Inno Tech<br>


									</td>


								</tr>


								</table>' ;


								// To send HTML mail, the Content-type header must be set


								$headers  = 'MIME-Version: 1.0' . "\r\n";


								$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";


								// Additional headers


								$headers .= 'From: Inno Tech<no-reply@innotech.com>' . "\r\n";


								// Mail it


								$sendemail = mail($to, $subject, $emailbody, $headers);


						}else{


								 //Does not exist in Database.


								$department_id	=	'23';	


								$tnumber 		= generateticket(8); // Generating the New Ticket number


								$ctnumber 		= str_replace('#','',$tnumber) ;





								


								 if($mail->textHtml != ""){ 	


				 					$message_detail = $mail->textHtml ;


								 }else{


									$message_detail = $mail->textPlain ;


								 }


								


								 $msgemaifilter =  emaifilter($message_detail,$cust_email) ; // Email Filter


				


								 $explod_message = explode('###',$msgemaifilter);


				


								 $message_detail = $explod_message[0];// explode message


								 


								 $tags = array('div,p');


								 $message_detail = stripSingleTags($tags,$message_detail);


								 


								 $message_detail = addslashes($message_detail);


								


								 $cust_name = $mail->fromName ; 	





							//inserting the record into Database.


								 $sql_insert = "INSERT INTO inno_tickets  SET customer_id = '0' ,department_id = '".$department_id."' , source = 'Email',subject = '".addslashes($mail->subject)."' ,priority = 'normal',details = '".$message_detail."',commited_date = '".$committed_date."',user_type = 'C',ticket_number = '".$tnumber."',is_parent = '1',ticket_status = '0',created_by='0',created_date=NOW();" ;


								$exe 			= mysql_query($sql_insert) or die(mysql_error().$sql_insert); //Inserting the tickets


								$tid 			= mysql_insert_id();//auto incremnt last id from tickets


							


							for($t=0;$t<count($attachment_name);$t++){


							$sql_insert = "INSERT INTO inno_email_attachments  SET attachment='".$attachment_name[$t]."',ticket_number ='".$tnumber."',created_by='0',created_date ='".date('Y-m-d g:i:a')."',created_by_ip = '".$_SERVER['REMOTE_ADDR']."'" ;


							$exe = mysql_query($sql_insert) or die(mysql_error()); //Inserting the tickets Attachments .


			 				}					


								


							/************************INSERT INTO CALENDAR*********************/


							$sql_insert = "INSERT INTO inno_guest_customers  SET email_address = '".$cust_email."',customer_name = '".$cust_name."',tid = '".$tid."',ticket_number = '".$tnumber."'" ;


			     			$exe = mysql_query($sql_insert) or die(mysql_error()); //Inserting the tickets_email


						/*********************** Sending Email to Customer ********************/


							$to =  $mail->fromAddress ;


							


							$from = 'support@innotech.com' ; 


							$subject = $tnumber.' '.stripslashes($mail->subject) ;


							$emailbody = '<table align="center" width="100%">


							<tr>


								<td align="left">Dear valuable Customer,</td>


							</tr>


							<tr>





								<td align="left"> Thank you for contacting us. This is an automated response confirming  the receipt of your ticket. One of our agents will get back to you as  soon as possible. For your records, the details of the ticket are listed below.Our Customer Support team will make sure that your queries and issues are addressed within 48 to 72 working hours. 


								<br/>


								Ticket ID:  <b>'.$ctnumber.'</b> <br />


								Subject: <b>'.stripslashes($mail->subject).'</b>.<br />  


							 </td>


							</tr>


							<tr>


								<td>&nbsp;</td></tr>


							<tr>


								<td>


								<b>Regards</b>,<br>


								Customer Support


								Inno Tech</td>


							</tr>


						</table>' ;


						// To send HTML mail, the Content-type header must be set





				$headers  = 'MIME-Version: 1.0' . "\r\n";





				$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";





				





				// Additional headers





			//	$headers .= 'To: '.$to.'' . "\r\n";





				$headers .= 'From: InnoTech<no-reply@innotech.com>' . "\r\n";





				// Mail it





				$sendemail = mail($to, $subject, $emailbody, $headers);





				} // End of If Parent Id email exists in database .





			}  // End of IF Checking Ticket Number is exist in database . 





	/***********************************************************************************************************/


}