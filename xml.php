<?php
require_once("connections/conn.php"); // Database Connection

if(isset($_GET['username']) && isset($_GET['password'])){
	
	$username=$_GET['username'];
	$password=md5($_GET['password']);
	
	
	//check user record
	$query=mysql_query("select * from inno_admin where username='$username' and password='$password'") or die(mysql_error());
	$count=mysql_num_rows($query); 

	$user_record=mysql_fetch_assoc($query);
	
	if($count >0)
	{
		$user_id= $user_record['id'];
		$created_date = date('Y-m-d G:i:s');
		$created_by_ip=$_SERVER['REMOTE_ADDR'];
		$n_notify= $user_record['n_notify'];
		
		if($n_notify==1)
		{
			$notify='<notify>1</notify>';
		}
		
		
		$insert_qeury="INSERT INTO `inno_logging` (`user_id`, `login_type`, `created_by`, `created_date`, `created_by_ip`) VALUES ('".$user_id."',0, '".$user_id."', '".$created_date."', '".$created_by_ip."')";
		
		mysql_query($insert_qeury); 
		//Fetch Messages From database
	    $count_query="select COUNT(message_id) as num_messages from inno_messages where`to`='".$user_id."' and message_status='0' ";
		$count_result=mysql_query($count_query);
		$count_messages=mysql_fetch_assoc($count_result);
		
		$sql="SELECT * from inno_messages WHERE `to`='".$user_id."' and message_status='0' order by id DESC limit 0,15";
		$query=mysql_query($sql) or die(mysql_error());
		$message_count=mysql_num_rows($query);
		$xml ='<Users>
	'.$notify.'
	<User>  
	<UserID>'.$user_record['id'].'</UserID>
	<UserName>'.$user_record['username'].'</UserName>
	<TotalNewMessages>'.$count_messages['num_messages'].'</TotalNewMessages>
		   <Messages>';
			   while($result=mysql_fetch_array($query)){
					   //Fetch user Record  
					   $user_id=$result['from'];
					   $sql="SELECT * from inno_admin WHERE `id`='".$user_id."'";
					   $user_result=mysql_query($sql);
					   $user_arr=mysql_fetch_assoc($user_result);
		$xml .='<Message>  
					   <To>'.$user_record['display_name'].'</To>
					   <From>'.$user_arr['display_name'].'</From>
					   <Subject>'.strip_tags($result['subject']).'</Subject>
					   <MsgDate>'.strip_tags($result['date']).'</MsgDate>
				</Message>';
			   }
			   
			$xml .= '	
		 </Messages>
	</User>
</Users>';
	   		
	}
	else{
$xml ='<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<Messages>
	<Message>Invalid User</Message> 
</Messages>';
			
	}
	
	
}
echo $xml ; 
exit;

?>