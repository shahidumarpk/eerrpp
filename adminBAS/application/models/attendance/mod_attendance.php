<?php
class mod_attendance extends CI_Model {
	
	function __construct(){
		
        parent::__construct();
    }

    
	// Get Users Attendance
	public function get_users_attendance (){
	 $this->db->dbprefix('attendance');
					
	
	$get_attendance = $this->db->get('attendance');
	$row_attendance['attendance_arr'] = $get_attendance->result_array();
	$row_attendance['attendance_count']=$get_attendance->num_rows;
	
		return $row_attendance;
	}
	
	
     //Get All users
	public function get_all_users(){
		
		$this->db->dbprefix('admin');
		$this->db->where('status',1);		
		$get_admin_user_list_limit = $this->db->get('admin');
		//echo $this->db->last_query();exit;
		
		$row_admin_user_list_limit['admin_list_result'] = $get_admin_user_list_limit->result_array();
		$row_admin_user_list_limit['admin_list_result_count'] = $get_admin_user_list_limit->num_rows;
		
		
		/*echo "<pre>";
		print_r($row_admin_user_list_limit);
		exit;*/
		
		return $row_admin_user_list_limit;		

		
	}//end get_all_employees
public function get_attendance_by_id($uid)
{
	 $this->db->dbprefix('attendance');
					
		$this->db->where('attendance.id',$uid);
	$get_attendance = $this->db->get('attendance');
	$row_attendance['attendance_arr'] = $get_attendance->row_array();
	$row_attendance['attendance_count']=$get_attendance->num_rows;
	
		return $row_attendance;
	
	
	}
	//Get All Attendance
	public function get_all_attendance(){
		
								
   	if($this->input->post('search_date') !=""){
			
		$search_date = date('Y-m-d',strtotime($_POST['search_date']));
		
	}else{
		//bydefault show current date
			$search_date = date('Y-m-d');
		
	}
				
				
				
				
		$this->db->dbprefix('admin');
		$this->db->select('admin.id as employee_id,admin.first_name,admin.last_name,attendance.*');
		$this->db->join('attendance',"admin.id = attendance.emp_code AND inno_attendance.attend_date = '$search_date'   ",'left');
			
			
		
		//$this->db->where('attendance.attend_date',$search_date);
			
		//$this->db->where('admin.status',1);
		
		
		
				

	
	

		$this->db->order_by('admin.created_date DESC');
		$get_admin_user_list_limit = $this->db->get('admin');


		//echo $this->db->last_query();
		$row_attendance['attendance_arr'] = $get_admin_user_list_limit->result_array();
		$row_attendance['attendance_count'] = $get_admin_user_list_limit->num_rows;
		
		
	
		
		/*echo "<pre>";
		print_r($row_attendance['attendance_arr']);
		exit;*/
	
		/*$this->db->dbprefix('attendance');
		$this->db->order_by('id DESC');
		$get_attendance = $this->db->get('attendance');

		//echo $this->db->last_query();
		$row_attendance['attendance_arr'] = $get_attendance->result_array();
		$row_attendance['attendance_count'] = $get_attendance->num_rows;
		
		for($i=0; $i<$row_attendance['attendance_count']; $i++){
			
			$admin_id= $row_attendance['attendance_arr'][$i]['emp_code'];
			
			$branch_id= $row_attendance['attendance_arr'][$i]['branch'];
			
			$this->db->dbprefix('admin');
			$this->db->where('id',$admin_id);
			$get_admin= $this->db->get('admin');
			$admin_arr = $get_admin->row_array();
			
			$row_attendance['attendance_arr'][$i]['emp_name'] =  $admin_arr['first_name']." ".$admin_arr['last_name'];
			
			$this->db->dbprefix('branches');
			$this->db->where('id',$branch_id);
			$get_branches= $this->db->get('branches');
			$branches_arr = $get_branches->row_array();
			
			$row_attendance['attendance_arr'][$i]['branch_name'] =  $branches_arr['branch_name'];
				
			
		}*/
	/*	
		
		
		*/
		return $row_attendance;
		
	}//end get_all_attendance

public function get_admin (){
	$this->db->dbprefix('admin');
		
		//$this->db->where('status',1);
		$get_users= $this->db->get('admin');
		//echo $this->db->last_query();
		$row_users['users_arr'] = $get_users->result_array();
		$row_users['users_count'] = $get_users->num_rows;
		
		
		return $row_users;
	
	}

	// Get Specific user Attendance
	public function get_attendance($id , $date)
	{


		 $this->db->dbprefix('attendance');
			$user_name=$this->input->post('user_name');
		$search_date=$this->input->post('search_date');			
		$this->db->select('admin.first_name,admin.last_name,attendance.*');
		$this->db->join('admin','admin.id = attendance.emp_code ','left');
		$this->db->where('attendance.emp_code',$id);
	
		$this->db->order_by('attendance.attend_date DESC');
	
		logit($date);
		if($date !=""){
			
	$date_arr = explode('/',$date);
	logit($date_arr)	;	

		$this->db->where('MONTH(inno_attendance.attend_date)',$date_arr[0]);
		
		
		$this->db->where('YEAR(inno_attendance.attend_date)',$date_arr[1]);
		
		
		
		
		
		
		
	}else{
		//bydefault show current date
		/*	$search_date = date('Y-m-d');
			$this->db->where('attendance.attend_date',$search_date);*/
		
	}
	
				

		
		
	


		$get_attendance = $this->db->get('attendance');
	
		//logit($this->db->last_query());
		
		$row_attendance['attendance_arr'] = $get_attendance->result_array();
		$row_attendance['attendance_count'] = $get_attendance->num_rows;
		
		$no_of_days = cal_days_in_month(CAL_GREGORIAN, $date_arr[0], $date_arr[1]);
		$month_array = array();
		for($d=1; $d<=$no_of_days; $d++){
	    $time=mktime(12, 0, 0,  $date_arr[0], $d,  $date_arr[1]);          
   		 $month_array[]=date('Y-m-d', $time);
		}

		//decending order for month days array;
		$month_array  = array_reverse($month_array );
	//logit($row_attendance);
	//logit($month_array);
		$filtered_data_complete_month = array();
		foreach($month_array as $day){
				$day_found = 0;
				foreach($row_attendance['attendance_arr'] as $row_day){
					
						if($row_day['attend_date'] == $day){
							$day_found = 1;
							$filtered_data_complete_month[]=$row_day; 
							break;
						}
				}
				
				
				
				if(!$day_found){
					$filtered_data_complete_month[]=array('attend_date'=>$day);
					
				}
			
			
			
		}


//logit($filtered_data_complete_month);
		
		
//		logit(	$date .' '. $no_of_days);
		
		/*for($i = 1; $i <=  date('t' strtotime($date)); $i++){
   // add the date to the dates array
  		 $dates[] = date('Y') . "-" . date('m') . "-" . str_pad($i, 2, '0', STR_PAD_LEFT);
		}
		*/
		
		$row_attendance['attendance_arr'] =   $filtered_data_complete_month;
		$row_attendance['attendance_count'] = count($filtered_data_complete_month);
		return $row_attendance;
			
		}
	// Get users Start time
	public function get_start_time ()
	{
	$this->db->dbprefix('admin');
	$this->db->select('admin.id,admin.start_time');
		
		$this->db->where('status',1);
		$get_users_time= $this->db->get('admin');
		//echo $this->db->last_query();
		$row_users['time_arr'] = $get_users_time->result_array();
		$row_users['time_count'] = $get_users_time->num_rows;
		
		
		return $row_users;	
		}
	//Upload Attendance
	
	public function tardy_calculation($attend_date , $intime,$user_start_time , $user_tardy_count , $user_id,$salary_per_day){
		
		//get prefrences
		// Loading Preferences
	/*	print_r('USer id  '.$user_id. '  ');*/
		$tardy_penality_time = $this->mod_preferences->get_preferences_setting('tardy_penality_time');
	  
	    $tardy_penality_time= $tardy_penality_time['setting_value'];
		
		$tardy_penality_count = $this->mod_preferences->get_preferences_setting('tardy_penality_count');
	  
	    $tardy_penality_count= $tardy_penality_count['setting_value'];
		
		
		
		//$time_in_24_hour_format  = date("H:i", strtotime($intime));
	/*	echo '<br>';
	echo 'intime ' .  $intime  . '<br>';
		
		echo 'user_start_time ' .  $user_start_time  . '<br>';
		echo 'tardy_count ' .  $user_tardy_count  . '<br>';
		echo 'user_id ' .  $user_id  . '<br>';
		
		echo 'tardy_penality_time ' .  $tardy_penality_time  . '<br>';
		echo 'tardy_penality_count ' .  $tardy_penality_count  . '<br>';
	*/
		
		
		
		
		
		
		//$from_time = strtotime("2008-12-13 10:21:00");
		
		$difference = strtotime($intime)  - strtotime($user_start_time) ;
		
		
		$mintues =  round(abs(strtotime($intime)  - strtotime($user_start_time)) / 60,2);;
		//echo 'Minutes Late <br>';
		
		if($difference > 0){
			
		$calc['timein_status'] = $mintues . " Minutes Late"	;
		
			//check for tardy 
			
			if($mintues >   $tardy_penality_time ){
			$calc['is_tardy'] = 1 ;	
			}else{
				$calc['is_tardy'] = 0;
			}
		
	
		}else{
			
			$calc['timein_status'] = $mintues . " Minutes Early"	;
			$calc['is_tardy']  = 0;
			
			
			
		}
		
		
		
		
		if($calc['is_tardy'] == 1) {
		//update user tardy count send in notificiation alert plus see if tardy fine is applicable	
			
		//	print_r($salary_per_day);
			
			$user_tardy_count = $user_tardy_count + 1;
		//	print_r($user_tardy_count);
		//	print_r($tardy_penality_count);
			if( $user_tardy_count >=  $tardy_penality_count  ){
				
				//add tardy fne entry and update user about the fine.
					$date = date('Y-m-d G:i:s');
				   	$transaction_date = date("Y-m-d");
					$created_date = date('Y-m-d G:i:s');
					$ip_address = $this->input->ip_address();
					$created_by = $this->session->userdata('admin_id');
					$type='tardy';
					$status='confirm';
			
			$ins_data = array(
		 
		     'user_id' => $this->db->escape_str(trim($user_id)),
		    'transaction_type' => $this->db->escape_str(trim($type)),
			'transaction_status' => $this->db->escape_str(trim($status)),
			'transaction_date'=>$this->db->escape_str(trim($transaction_date)),
			'description'=>'Fine Type Tardy Confirmed ',
			'amount' => $this->db->escape_str(trim($salary_per_day)),

		    'created_date' => $this->db->escape_str(trim($created_date)),
		    'created_by' => $this->db->escape_str(trim($created_by)),
		    'created_by_ip' => $this->db->escape_str(trim($ip_address))
		);	
		
	
		//Updating the record into the database.
		
		$this->db->dbprefix('payroll_ledger');
			
		$ins_into_db = $this->db->insert('payroll_ledger', $ins_data);
		
		
	
				//reset the count
				//INSERT query for payral entry
				
				#notificiation message and subject
				$notification_subject = "Automated Tardy Fine Alert for " . $attend_date ;
				$notification_message = "System has added a tardy fine for your account. 
				<br/>
				This is your $user_tardy_count tardy. System has automatically added a tardy fine of Rs. $salary_per_day . <br/>
				Your Tardy count has been reset
							
				" ;
				$user_tardy_count = 0;
				
				
			}else{
				
			
				$notification_subject = "Automated Tardy Alert for " . $attend_date ;
				$notification_message = "System has added your tardy for $attend_date. 
				<br/>
				Your current tardy count is  $user_tardy_count.  
				<br/>
				System will automatically add a tardy fine of Rs. $salary_per_day on your $tardy_penality_count tardy. <br/>
				
				";
				
				
				
			}


			 $message_id = $this->mod_common->random_number_generator(7);
				   $message_id = $this->mod_messages->message_id_generator($message_id);
				   $notification='1';
				   $notification_by = $this->session->userdata('admin_id');
				   $notification_date = date('Y-m-d G:i:s');
			//mzm-todo : send alert notification
			//NOTIFICATION QUERY
			 $ins_notification = array(
					'to' => $this->db->escape_str(trim($user_id)),
					'from' => $this->db->escape_str(trim($notification_by)),
					'subject' => $this->db->escape_str(trim($notification_subject)),
					'message' => $this->db->escape_str(trim(nl2br($notification_message))),
					'message_id' => $this->db->escape_str(trim($message_id)),
					'attachment' => $this->db->escape_str(trim($attachment_name)),
					'created_by' => $this->db->escape_str(trim($created_by)),
					'date' => $this->db->escape_str(trim($notification_date)),
					'created_by_ip' => $this->db->escape_str(trim($ip_address)),
					'notification' => $this->db->escape_str(trim($notification)),
					);		

				   //Inserting the record into the database.
				  $this->db->dbprefix('messages');
				  $ins_into_db = $this->db->insert('messages', $ins_notification);
			
			
			
			
			
			//mzm-todo: update user  current tardy count
			
			
			
			
			
			//UPDATE query for  user tardy count update
			
		$created_date = date('Y-m-d G:i:s');
					$ip_address = $this->input->ip_address();
					$created_by = $this->session->userdata('admin_id');
		$this->db->dbprefix('admin');
		$data = array(
		'current_tardy_count' =>$this->db->escape_str(trim($user_tardy_count)),
		 'last_modified_date' => $this->db->escape_str(trim($created_date)),
		    'last_modified_by' => $this->db->escape_str(trim($created_by)),
		    'last_modified_ip' => $this->db->escape_str(trim($ip_address))
		);
		$this->db->where('id',$user_id);
		$upd_into_db = $this->db->update('admin', $data);
		
		
		
		}
		
			
		
		return $calc;
			
		
		
		
		
		
		
		
		
	}
	public function absent_alert ($emp_id,$date,$per_day_salary_formated){
		
			
				$date=(date("Y-m-d G:i:s",strtotime($date)));
				   	$transaction_date = date("Y-m-d");
					$created_date = date('Y-m-d G:i:s');
					$ip_address = $this->input->ip_address();
					$created_by = $this->session->userdata('admin_id');
					$type='fine';
					$status='confirm';
					// Getting data to be inserted into PayRoll Table
					$ins_data = array(
		 
		    'user_id' => $this->db->escape_str(trim($emp_id)),
		    'transaction_type' => $this->db->escape_str(trim($type)),
			'transaction_status' => $this->db->escape_str(trim($status)),
			'transaction_date'=>$this->db->escape_str(trim($date)),
			'description'=>'Absentee Fine for ' . $date,
			'amount' => $this->db->escape_str(trim($per_day_salary_formated)),

		    'created_date' => $this->db->escape_str(trim($created_date)),
		    'created_by' => $this->db->escape_str(trim($created_by)),
		    'created_by_ip' => $this->db->escape_str(trim($ip_address))
		);	
		$notification_subject = "Automated Absent Fine Alert for " . $date ;
				$notification_message = "
				System has automatically added a  fine of Rs. $per_day_salary_formated . for your account. <br/> Absent date is $date
				
							
				" ;
				
	
		//Updating the record into the database.
		
		$this->db->dbprefix('payroll_ledger');
			
		$ins_into_db = $this->db->insert('payroll_ledger', $ins_data);
			$message_id = $this->mod_common->random_number_generator(7);
				   $message_id = $this->mod_messages->message_id_generator($message_id);
				   $notification='1';
				   $notification_by = $this->session->userdata('admin_id');
				   $notification_date = date('Y-m-d G:i:s');
			//mzm-todo : send alert notification
			//NOTIFICATION QUERY
			 $ins_notification = array(
					'to' => $this->db->escape_str(trim($emp_id)),
					'from' => $this->db->escape_str(trim($notification_by)),
					'subject' => $this->db->escape_str(trim($notification_subject)),
					'message' => $this->db->escape_str(trim(nl2br($notification_message))),
					'message_id' => $this->db->escape_str(trim($message_id)),
					'attachment' => $this->db->escape_str(trim($attachment_name)),
					'created_by' => $this->db->escape_str(trim($created_by)),
					'date' => $this->db->escape_str(trim($notification_date)),
					'created_by_ip' => $this->db->escape_str(trim($ip_address)),
					'notification' => $this->db->escape_str(trim($notification)),
					);		

				   //Inserting the record into the database.
				  $this->db->dbprefix('messages');
				  $ins_into_db = $this->db->insert('messages', $ins_notification);
				
				
		
		}
		function single_upload_attendance ($data)
		{
			
	// Getting All users
			$users_data=$this->get_all_users();
			$result_data=$users_data['admin_list_result'];
		// Getting Attendance
		$users_attendance=$this->get_users_attendance();
	$result_attendance=$users_attendance['attendance_arr'];
		
	// Array To store Result with Respect to ID Index 
		$data_arr=array();
	// Creating New Elements for Each USerId COUT,CIN,OUT,BACKOUT	
			foreach ( $result_data as  $i => $userid )
			{
				$userid['C/Out']='';
					$userid['C/In']='';
						$userid['Out Back']='';
							$userid['Out']='';
						$id=$userid['id'];
				$data_arr[$id]=$userid;
				
			}
			
			
			
			//Create User Directory if not exist
			$attendance_folder_path = './assets/attendance/';
			
			if(!is_dir($attendance_folder_path))
			mkdir($attendance_folder_path,0777);
	
			
			$name = $_FILES['file']['name'];		
	 	    $file_name = 	'attendance_'.date('YmdGis')."_".$name;

			$config['upload_path'] = $attendance_folder_path;
			$config['allowed_types'] = 'csv';
			$config['max_size']	= '6000';
			$config['overwrite'] = true;
			$config['file_name'] = $file_name;
			
			$this->load->library('upload', $config);

			if(!$this->upload->do_upload('file')){
				//return error
				$error = array('error_code'=>1,
										'error_detail' => $this->upload->display_errors(),
										'error_msg' =>'Error...! File Not Uploaded',
				);
				
				
				return $error ;
	
	
				
			}
			
			 //Read CSV file
			 $this->load->library('csvreader');
			 $ins_array=array();
			 $filePath = $attendance_folder_path."/".$file_name;
             $data = $this->csvreader->parse_file($filePath);
			 
			 if(empty($data)){
				return 	$error = array('error_code'=>2, 'error_msg' =>'File empty or Error in reading file contents');
				}
				
			// Reading Data From File
			$attend = '';
			foreach ($data as $sheet){
				


		// Time with Date
			$attend=($sheet['Time'])?$sheet['Time']:'';
	
		//emp_code is comming as following column
		$emp_code=$sheet['AC-No.'];
	//get status to check  values 
		$state=$sheet['State'];
		
if(!array_key_exists($emp_code , $data_arr )){ //incase file employeed code doesn't match or global users data then move on skip the row
						continue ;	//move to next row
				}


	// Variables to Hold First Coming Status for Each User
			
		
		// Switch to Handle States 
		
	
			switch($state){
		
			case "C/In" :
			//very first check-in logic
		
		if(empty($data_arr[$emp_code]['C/In'])){
	// if data is previously NOT  added
				
			
			
			$data_arr[$emp_code]['C/In']=$attend;
		
		}
		
			
			
			
	
			
			
			break;
			
			
			case "C/Out" :
				
			if(empty($data_arr[$emp_code]['C/Out']))
			{
			
	
			$data_arr[$emp_code]['C/Out']=$attend;
			
			}
			
			break;
			
			
			
			case "Out" :
			
	if(empty($data_arr[$emp_code]['Out']))
			{
				

	$data_arr[$emp_code]['Out']=$attend;
			}
			
			
			break;
			
			
			
			case "Out Back" :
			
		if(empty($data_arr[$emp_code]['Out Back']))
			{
			
		
	$data_arr[$emp_code]['Out Back']=$attend;
			}
		
			
			break;	
			}// Ending  SWITCH
		// Ending IF
		} // Ending FOREACH
		
		// UPD ARRAY
		$upd_arr=array();
		// INSERT ARRAY
		$ins_arr=array();
		
	$users=array();
	$check_absent=0;

// $emp_id,$date,$per_day_salary_formated
foreach ($data_arr as $key=>$data){
		$check_out_time=' ';
	$check_in_time=' ';
	$out_time=' ';
	$out_back_time='';
		if($data_arr[$key]['C/In']!=''){
	
	$chek_in_date=(date("Y-m-d",strtotime($data_arr[$key]['C/In'])));
	}
	
	if($data_arr[$key]['C/In']==''){
		
		
	continue; //no need to insert data move to next row
	
	}else{
	$attend_date=(date("Y-m-d",strtotime($data_arr[$key]['C/In'])));	
	$check_in_time=(date("H:i:s",strtotime($data_arr[$key]['C/In'])));
	}
	
		
	if($data_arr[$key]['C/Out']!=''){
	
	$check_out_time=(date("H:i:s",strtotime($data_arr[$key]['C/Out'])));
	}
	
		
		
	if($data_arr[$key]['Out']!=''){
	
	$out_time=(date("H:i:s",strtotime($data_arr[$key]['Out'])));
		}
	
		
		if($data_arr[$key]['Out Back']!=''){
	
	$out_back_time=(date("H:i:s",strtotime($data_arr[$key]['Out Back'])));
		}


	// Reading Date And Time and Separating time and Date
	
	
		$chek_out_date=(date("Y-m-d",strtotime($data_arr[$key]['C/Out'])));

		$out_date=(date("Y-m-d",strtotime($data_arr[$key]['Out'])));
	
		
		$chek_in_date=(date("Y-m-d",strtotime($data_arr[$key]['C/In'])));

		$out_back_date=(date("Y-m-d",strtotime($data_arr[$key]['Out Back'])));
		
	
		// DB FORMATIING CONVERSIONS
			
		$status='P';
		
		

		
		
	
		
			// General Fields Date,IP ADDRESS and MODIFICATIONS		
		$created_date = date('Y-m-d G:i:s');
		$ip_address = $this->input->ip_address();
	    $created_by = $this->session->userdata('admin_id');
		$last_modified_date = date('Y-m-d G:i:s');
		$last_modified_ip = $this->input->ip_address();
		$last_modified_by = $this->session->userdata('admin_id');	
		
		// Calculate Per Day Salary from Users Salary divided by 30 
		$per_day_salary=$data['salary']/30;

	// Round Salary to two digits 
		$formatted_number = round( $per_day_salary,2,PHP_ROUND_HALF_UP);
		 
		 // Get User Start Time
		$user_start_time=$data['start_time'];
		 // User Tardy Count to Update Tardy Accordingly
		$user_tardy_count=$data['current_tardy_count'];
		
		// Get All Attendace results to Upadte Them Later Where Key and Date are Matching with Sheet Data
		$this->db->dbprefix('attendance');			
		$this->db->where('attendance.emp_code',$key);
		$this->db->where('attendance.attend_date',$attend_date);
		$get_attendance = $this->db->get('attendance' );
		$row_attendance['attendance_arr'] = $get_attendance->row_array();



	if(!$row_attendance['attendance_arr'])
	{ 
	
	
	$tardy_calculation = $this->tardy_calculation($attend_date,$check_in_time , $user_start_time , $user_tardy_count , $key, $formatted_number);
	
	
				$ins_data = array(
				'emp_Code'  => $key,
			
			   'attend_date' => $this->db->escape_str(trim($attend_date)),
			 	 'time_in' => $this->db->escape_str(trim($check_in_time)),
			 	'time_out' => $this->db->escape_str(trim($check_out_time)),
			   'break_in' => $this->db->escape_str(trim($out_back_time)),
			   'break_out' => $this->db->escape_str(trim($out_time)),
			      'per_day_salary'=>$this->db->escape_str(trim($formatted_number)),

			  
			   'astatus' => $this->db->escape_str(trim($status)),
			    'user_id' => $this->db->escape_str(trim($created_by)),
			    'upload_time' => $this->db->escape_str(trim($created_date)),
			    
			   'created_by' => $this->db->escape_str(trim($created_by)),
			 'created_by_ip' => $this->db->escape_str(trim($ip_address)),
			'created_date' => $this->db->escape_str(trim($created_date)),
			 'is_tardy'=> $tardy_calculation['is_tardy'],
			'timein_status'=> $this->db->escape_str(trim($tardy_calculation['timein_status'])), //todo
		
			
			); 
		$this->db->dbprefix('attendance');
		$ins_into_db = $this->db->insert('attendance',$ins_data); 

		
		}
		else
		{
	
	
			
			$upd_data = array(
			    'emp_Code' =>$key,
			    'attend_date' => $this->db->escape_str(trim($attend_date)),
			    'per_day_salary'=>$this->db->escape_str(trim($formatted_number)),
	
			 
			   'time_out' => $this->db->escape_str(trim($check_out_time)),
			   'break_in' => $this->db->escape_str(trim($out_back_time)),
			   'break_out' => $this->db->escape_str(trim($out_time)),
			    'astatus' => $this->db->escape_str(trim($status)),
		  
			     'last_modified_date' => $this->db->escape_str(trim($last_modified_date)),
		    	 'last_modified_by' => $this->db->escape_str(trim($last_modified_by)),
		    	 'last_modified_ip' => $this->db->escape_str(trim($last_modified_ip)),
				 'is_tardy'=> $this->db->escape_str($row_attendance['attendance_arr']['is_tardy']),
		
			    
		);
//Update the record into the database.

$this->db->dbprefix('attendance');
		$this->db->where('attendance.emp_code',$key);
			$this->db->where('attendance.attend_date',$attend_date);
		$upd_into_db = $this->db->update('attendance', $upd_data);	
	
				}
				
 }//end of insertion/updation loop
	
if($upd_into_db ){
			$this->session->set_flashdata('ok_message', 'Employee Attendance record(s) are Updated successfully.');
			redirect(base_url().'attendance/manage-attendance/upload');
			
			
		}
	

	}

//Ending attend_date




 		
		//mzm : New Funtion to handle absent scenario and multidates
		function multi_attendance_upload ($data)
		{
	// Getting All users
			$users_data=$this->get_all_users();
			$result_data=$users_data['admin_list_result'];
	
		
	// Array To store Result with Respect to ID Index 
		$data_arr=array();
	// Creating New Elements for Each USerId COUT,CIN,OUT,BACKOUT	
			foreach ( $result_data as  $i => $userid )
			{
					$userid['Attendance']=array();
					
					
					$id=$userid['id'];
				$data_arr[$id]=$userid;
				
			}
	
			//Create User Directory if not exist
			$attendance_folder_path = './assets/attendance/';
			
			if(!is_dir($attendance_folder_path))
			mkdir($attendance_folder_path,0777);
	
			
			$name = $_FILES['file']['name'];		
	 	    $file_name = 	'attendance_'.date('YmdGis')."_".$name;

			$config['upload_path'] = $attendance_folder_path;
			$config['allowed_types'] = 'csv';
			$config['max_size']	= '6000';
			$config['overwrite'] = true;
			$config['file_name'] = $file_name;
			
			$this->load->library('upload', $config);

			if(!$this->upload->do_upload('file')){
				//return error
				$error = array('error_code'=>1,
										'error_detail' => $this->upload->display_errors(),
										'error_msg' =>'Error...! File Not Uploaded',
				);
				
				
				return $error ;
	
	
				
			}
	
	
			 //Read CSV file
			 $this->load->library('csvreader');
			 $ins_array=array();
			 $filePath = $attendance_folder_path."/".$file_name;
             $data = $this->csvreader->parse_file($filePath);
			 $date_array=array();
			 if(empty($data)){
				return 	$error = array('error_code'=>2, 'error_msg' =>'File empty or Error in reading file contents');
				}
					$new_data_array=array();
			// Reading Data From File
			foreach ($data as $sheet){
		// Time with Date
			$attend=$sheet['Time'];
	
	//separating Date
		$separate_date=(date("Y-m-d",strtotime($sheet['Time'])));
		
		$time_in=(date("H:i:s",strtotime($sheet['Time'])));
	
		//emp_code is comming as following column
		$emp_code=$sheet['AC-No.'];
	//get status to check  values 
		$state=$sheet['State'];


			

	
		

// Checking C/In

	if(array_key_exists($emp_code,$data_arr)){
	
	
	
	
switch($state){
		
			case "C/In" :
			//very first check-in logic
		
		if(!isset($data_arr[$emp_code]['Attendance'][$separate_date]['C/In'])){
	// if data is previously NOT  added
				
			
			
			$data_arr[$emp_code]['Attendance'][$separate_date]['C/In']=$time_in;
		
		}
		
			
			
			
	
			
			
			break;
			
			
			case "C/Out" :
				
			if(!isset($data_arr[$emp_code]['Attendance'][$separate_date]['C/Out']))
			{
			
	
		$data_arr[$emp_code]['Attendance'][$separate_date]['C/Out']=$time_in;
			
			}
			
			break;
			
			
			
			case "Out Back" :
			
	if(!isset($data_arr[$emp_code]['Attendance'][$separate_date]['Out_Back']))
			{
				

	$data_arr[$emp_code]['Attendance'][$separate_date]['Out_Back']=$time_in;
			}
			
			
			break;
			
			
			
			case "Out" :
			
		if(!isset($data_arr[$emp_code]['Attendance'][$separate_date]['Out']))
			{
			
		
	$data_arr[$emp_code]['Attendance'][$separate_date]['OUT']=$time_in;
			}
		
			
			break;	
			}	 // Ending  SWITCH
	
	}
	
			} // Ending FOREACH
		
	

		
		// UPD ARRAY
		$upd_arr=array();
		// INSERT ARRAY
		$ins_arr=array();
		
	$users=array();
	

// $emp_id,$date,$per_day_salary_formated

foreach ($data_arr as $key=>$data){
		

	$check_out_time='';
	$check_in_time='';
	$out_time='';
	$out_back_time='';

	if($data_arr[$key]['C/In']==''){
		
	continue; //no need to insert data move to next row
		
	}else{
	$attend_date=(date("Y-m-d",strtotime($data_arr[$key]['C/In'])));	
	$check_in_time=(date("H:i:s",strtotime($data_arr[$key]['C/In'])));
	}
	
		
	if($data_arr[$key]['C/Out']!=''){
	
	$check_out_time=(date("H:i:s",strtotime($data_arr[$key]['C/Out'])));
	}
	
		
		
	if($data_arr[$key]['OUT']!=''){
	
	$out_time=(date("H:i:s",strtotime($data_arr[$key]['OUT'])));
		}
	
		
		if($data_arr[$key]['Out Back']!=''){
	
	$out_back_time=(date("H:i:s",strtotime($data_arr[$key]['Out Back'])));
		}
	
	

	// Reading Date And Time and Separating time and Date
	
	
		$chek_out_date=(date("Y-m-d",strtotime($data['C/Out'])));

		$out_date=(date("Y-m-d",strtotime($data['Out'])));
	
		
		$chek_in_date=(date("Y-m-d",strtotime($data['C/In'])));

		$out_back_date=(date("Y-m-d",strtotime($data['Out Back'])));
		
	
		// DB FORMATIING CONVERSIONS
			
		$status='P';
		
		

		
		
	
		
			// General Fields Date,IP ADDRESS and MODIFICATIONS		
		$created_date = date('Y-m-d G:i:s');
		$ip_address = $this->input->ip_address();
	    $created_by = $this->session->userdata('admin_id');
		$last_modified_date = date('Y-m-d G:i:s');
		$last_modified_ip = $this->input->ip_address();
		$last_modified_by = $this->session->userdata('admin_id');	
		
		// Calculate Per Day Salary from Users Salary divided by 30 
		$per_day_salary=$data['salary']/30;

	// Round Salary to two digits 
		$formatted_number = round( $per_day_salary,2,PHP_ROUND_HALF_UP);
		 
		 // Get User Start Time
		$user_start_time=$data['start_time'];
		 // User Tardy Count to Update Tardy Accordingly
		$user_tardy_count=$data['current_tardy_count'];
		
		// Get All Attendace results to Upadte Them Later Where Key and Date are Matching with Sheet Data
		$this->db->dbprefix('attendance');			
		$this->db->where('attendance.emp_code',$key);
		$this->db->where('attendance.attend_date',$attend_date);
		$get_attendance = $this->db->get('attendance' );
		$row_attendance['attendance_arr'] = $get_attendance->row_array();
	

	if(!$row_attendance['attendance_arr'])
	{ 
	
	
	$tardy_calculation = $this->tardy_calculation($attend_date,$check_in_time , $user_start_time , $user_tardy_count , $key, $formatted_number);
	
	
				$ins_data = array(
				'emp_Code'  => $key,
			
			   'attend_date' => $this->db->escape_str(trim($attend_date)),
			 	 'time_in' => $this->db->escape_str(trim($check_in_time)),
			 	'time_out' => $this->db->escape_str(trim($check_out_time)),
			   'break_in' => $this->db->escape_str(trim($out_back_time)),
			   'break_out' => $this->db->escape_str(trim($out_time)),
			      'per_day_salary'=>$this->db->escape_str(trim($formatted_number)),

			  
			   'astatus' => $this->db->escape_str(trim($status)),
			    'user_id' => $this->db->escape_str(trim($created_by)),
			    'upload_time' => $this->db->escape_str(trim($created_date)),
			    
			   'created_by' => $this->db->escape_str(trim($created_by)),
			 'created_by_ip' => $this->db->escape_str(trim($ip_address)),
			'created_date' => $this->db->escape_str(trim($created_date)),
			 'is_tardy'=> $tardy_calculation['is_tardy'],
			'timein_status'=> $this->db->escape_str(trim($tardy_calculation['time_in_status'])), //todo
		
			
			); 
				
$this->db->dbprefix('attendance');
		$ins_into_db = $this->db->insert('attendance',$ins_data); 
		
		}
		else
		{
	
	
			
			$upd_data = array(
			    'emp_Code' =>$key,
			    'attend_date' => $this->db->escape_str(trim($attend_date)),
			    'per_day_salary'=>$this->db->escape_str(trim($formatted_number)),
	
			 
			   'time_out' => $this->db->escape_str(trim($check_out_time)),
			   'break_in' => $this->db->escape_str(trim($out_back_time)),
			   'break_out' => $this->db->escape_str(trim($out_time)),
			    'astatus' => $this->db->escape_str(trim($status)),
		  
			     'last_modified_date' => $this->db->escape_str(trim($last_modified_date)),
		    	 'last_modified_by' => $this->db->escape_str(trim($last_modified_by)),
		    	 'last_modified_ip' => $this->db->escape_str(trim($last_modified_ip)),
				 'is_tardy'=> $this->db->escape_str(trim($user_tardy_count)),
		
			    
		);
//Update the record into the database.
		$this->db->dbprefix('attendance');
		$this->db->where('attendance.emp_code',$key);
			$this->db->where('attendance.attend_date',$attend_date);
		$upd_into_db = $this->db->update('attendance', $upd_data);	
	
				}
 }//end of insertion/updation loop
 
if($upd_into_db ){
			$this->session->set_flashdata('ok_message', 'Employee Attendance record(s) are Updated successfully.');
			redirect(base_url().'attendance/manage-attendance/upload');
			
			
		}


 			} // Ending attendance_upload
			
			public function check_absent ($date)
			
			{
				
				
					$this->db->dbprefix('admin');
		$this->db->select('admin.id,admin.salary ,admin.first_name,admin.last_name,attendance.attend_date,attendance.emp_code,attendance.attend_date,attendance.per_day_salary,attendance.time_in,attendance.time_out,attendance.astatus,attendance.is_tardy,attendance.timein_status,,attendance.break_in,attendance.break_out'
		);
		
		$this->db->join('attendance',"admin.id = attendance.emp_code AND inno_attendance.attend_date = '$date'   ",'left');
			
		
	
		$get_present_users = $this->db->get('admin');
		
		


		//echo $this->db->last_query();
		$row_attendance['attendance_arr'] = $get_present_users->result_array();
		
		echo '<pre>';
		print_r($row_attendance);
		// General Fields Date,IP ADDRESS and MODIFICATIONS		
		$created_date = date('Y-m-d G:i:s');
		$ip_address = $this->input->ip_address();
	    $created_by = $this->session->userdata('admin_id');
		$last_modified_date = date('Y-m-d G:i:s');
		$last_modified_ip = $this->input->ip_address();
		$last_modified_by = $this->session->userdata('admin_id');	
		foreach($row_attendance['attendance_arr'] as $users)
		{
			if($users['attend_date']=='')
			{
				
			$users_id=$users['id'];
			$users_salary=$users['salary'];
			$per_day_salary=$users_salary/30;
			$per_day_salary_formated = round( $per_day_salary,2,PHP_ROUND_HALF_UP);
$this->absent_alert($users_id,$date,$per_day_salary_formated);

$ins_data = array(
				'emp_Code'  => $users_id,
			
			   'attend_date' => $this->db->escape_str($date),
			 	 'time_in' => '',
			 	'time_out' => '',
			   'break_in' => '',
			   'break_out' =>'',
			      'per_day_salary'=>$this->db->escape_str(trim($per_day_salary_formated)),

			  
			   'astatus' => 'A',
			    'user_id' => $this->db->escape_str(trim($created_by)),
			    'upload_time' => $this->db->escape_str(trim($created_date)),
			    
			   'created_by' => $this->db->escape_str(trim($created_by)),
			 'created_by_ip' => $this->db->escape_str(trim($ip_address)),
			'created_date' => $this->db->escape_str(trim($created_date)),
			 'is_tardy'=>'0',
			'timein_status'=>'', //todo
		
			
			); 
		
		$this->db->dbprefix('attendance');
		
		$ins_into_db = $this->db->insert('attendance',$ins_data); 
		echo $this->db->last_query();
		echo '<hr>';
	//echo '<br> ID = '.$users_id.' <br> DATE = '.$date. '<br> PER DAY SALARY = '.$per_day_salary_formated;
		
			}
			
			}
		


		//echo $this->db->last_query();
	
		
				}
	public function upload($data){
		
		
	
	// Comparing Start Time with in_Time
			
$data_array=array();
	
	

		 
		$date = date("Y-m-d", strtotime($data['date']));
			
	 	$user_ids =$data['user_id'];
		
		
		 //$users_string = implode(',',$user_ids ) ;
	 
		$already_marked_users = $this->get_already_marked_attendance($user_ids,$date);
			
			
		/* echo 'ALREADY MARKED ATTENDANCE USERS ARRAY<br>';
		 print_r($already_marked_users);*/
	 
		// Checking  Arrays Differences
		
		$new_users = array_diff( $user_ids , $already_marked_users);
	
		
		
		
		/* echo 'NEW USERS AFTER ARRAY DIFF <br>';
		 print_r($new_users);*/
		
				
		
			
		if(empty($new_users)){
			
		//return error 
		return $error_file_arr = array('error_code'=>1, 'error_msg' =>"This employee record(s) is already added");
	
		//Attendence of user(s) already marked for given date	
			
		}
		
		
		
	
		$users_information = $this->get_user_details($new_users);
		
	  
	/*echo $this->db->last_query() ;
	*/	
		/*echo '<pre> users Information';
		print_r($users_information);*/
		
	//	exit;	
	
		
		$batch_insert_data = array();
		
			
		 $created_date = date('Y-m-d G:i:s');
		 $ip_address = $this->input->ip_address();
		 $created_by = $this->session->userdata('admin_id');
		 $is_tardy=0;
		 
		 
		  if($data['status']=='A' || $data['status']=='L'){
				$time_in='00:00:00';
				$time_out='00:00:00';
			
				
				
			}else{
			
		
			
			
				$time_in  = date("H:i:s", strtotime($data['intime']));
			
	
				if($outtime){
			 	$time_out  = date("H:i:s", strtotime($data['outtime']));
				}else{
					$time_out='00:00:00';
				}
				
				
		}
			
				
	
		//	$intime=date("H:i", strtotime($intime));   // Displaying Hours:: Minutes 
		//	$outtime=date("H:i", strtotime($outtime));  // Displaying Hours:: Minutes
	
		
		
		
		
		// Checking Row User Result
		
	/*	echo '<pre>';echo '<br>';
		print_r($row_user);
		echo '......................... <br>';*/
	//	print_r($time_in); echo '<br>';
	//	print_r($time_out);
		
	// EMP_name, Branch_id and Salary per Day is Removed From Insertion Area plus From the Database as they can Be checked Through Join
	
		 $created_date = date('Y-m-d G:i:s');
		
	
	
	
		$user_batch_insert_data = array(); ///final array to be inserted into db

		//loop the user information to prepare batch insert data
		//read sallary , start time and current count from usersheet information. Read date and time from the upload sheet
		foreach($users_information  as $user_detail)
	{
			
		
				//calculate is_tardy
				//get_user_start_time
				
				
// Stroing New Users Id to emp_id so we can  use Them for Tardy Count and Inserting to DB 
				$emp_id= $user_detail['id'];
				$user_start_time = $user_detail['start_time'];
				$user_tardy_count = $user_detail['current_tardy_count'];
				 $user_salary=$user_detail['salary'];
		
		// Salaray Calculations
		
	
		
	    $per_day_salary=$user_salary/30;
		$per_day_salary_formated = round( $per_day_salary,2,PHP_ROUND_HALF_UP);
			
			if($data['status']=='A')
			{
				$this->absent_alert($emp_id,$date,$per_day_salary_formated);
		
				}
			
			//tardy calculations
						if($data['status'] == 'P' ) {	
				$tardy_calculation = $this->tardy_calculation($date,$time_in ,
				 $user_start_time , $user_tardy_count  ,$emp_id, $per_day_salary_formated );
	
				}else{
					$tardy_calculation = array('is_tardy'=>0 , 'timein_status' => '');
					
				}
				
				
			/*	echo '<pre>';
				print_r($tardy_calculation);
				
				exit;*/
			$batch_insert_item_array = array();
				
			  	$batch_insert_item_array['emp_Code']  = $emp_id;
				
			  $batch_insert_item_array[ 'attend_date'] = $this->db->escape_str(trim($date));
			   $batch_insert_item_array['time_in'] = $this->db->escape_str(trim($time_in));
			       $batch_insert_item_array['per_day_salary']=$this->db->escape_str(trim($per_day_salary_formated));

			  
			    $batch_insert_item_array['astatus'] = $this->db->escape_str(trim($data['status']));
			    $batch_insert_item_array['user_id'] = $this->db->escape_str(trim($created_by));
			    $batch_insert_item_array['upload_time'] = $this->db->escape_str(trim($created_date));
			    
			    $batch_insert_item_array['created_by'] = $this->db->escape_str(trim($created_by));
		 $batch_insert_item_array['created_by_ip'] = $this->db->escape_str(trim($ip_address));
			    $batch_insert_item_array['created_date'] = $this->db->escape_str(trim($created_date));
			      $batch_insert_item_array['is_tardy'] = $tardy_calculation['is_tardy'];
				 $batch_insert_item_array['timein_status'] = $tardy_calculation['timein_status'];
											  
		
			
			
			//add row to master array
				 $user_batch_insert_data[] = 	$batch_insert_item_array;
				
				
									  
			
		}

	//Insert the record into the database.
	/*echo '<pre> inserted Data to B added ';
		print_r($user_batch_insert_data);
		exit;*/
		$this->db->dbprefix('attendance');
		$ins_into_db = $this->db->insert_batch('attendance', $user_batch_insert_data);
		//echo $this->db->last_query();
		
	   
		return true;
		
	 

	}//end upload_attendance()
	
	
public function get_already_marked_attendance($user_ids,$attend_date){
	
	//search current users in attendance
		$this->db->dbprefix('attendance');
		$this->db->where('attend_date',$attend_date);
		$this->db->where_in('emp_code',$user_ids);
		$get_attendance_check= $this->db->get('attendance');
		
		$already_attendance_check_data =  $get_attendance_check->result_array();
		
		
		
	
		//make an array of already marked users
		$sheet_already_marked_users = array();
		if(!empty($already_attendance_check_data)){
			
				foreach($already_attendance_check_data as $attendence_sheet_entry){
					
					$sheet_already_marked_users[]=	$attendence_sheet_entry['emp_code'];
					
				}
		
		}
		
		
		return $sheet_already_marked_users;	
	
	
}

public function get_user_details($users){
	
	
		$this->db->dbprefix('admin');
		$this->db->where_in('id',$users);
		//$this->db->where_in('emp_code',$users_string);
		$query_result= $this->db->get('admin');
		$userssheet_information =  $query_result->result_array();

		return $userssheet_information;	
}
	
public function upload_attendance_sheet($data){
	

			//Create User Directory if not exist
			$attendance_folder_path = './assets/attendance/';
			
			if(!is_dir($attendance_folder_path))
			mkdir($attendance_folder_path,0777);
	
			
			$name = $_FILES['file']['name'];		
	 	    $file_name = 	'attendance_'.date('YmdGis')."_".$name;

			$config['upload_path'] = $attendance_folder_path;
			$config['allowed_types'] = 'csv';
			$config['max_size']	= '6000';
			$config['overwrite'] = true;
			$config['file_name'] = $file_name;
			
			$this->load->library('upload', $config);

			if(!$this->upload->do_upload('file')){
				//return error
				$error = array('error_code'=>1,
										'error_detail' => $this->upload->display_errors(),
										'error_msg' =>'Error...! File Not Uploaded',
				);
				
				
				return $error ;
	
	
				
			}
			
			 //Read CSV file
			 $this->load->library('csvreader');
			 $ins_array=array();
			 $filePath = $attendance_folder_path."/".$file_name;
             $data = $this->csvreader->parse_file($filePath);
			 
			 if(empty($data)){
				return 	$error = array('error_code'=>2, 'error_msg' =>'File empty or Error in reading file contents');
				}
			 
			 
		/* echo '<h3>FILE DATA</h3><pre>';	 
		print_r($data); */
		//loop the file data.	
		
		$db_data_array = array(); // array to hold filtered values for the database
	
	foreach($data as $row){
		//seprate attend data and time
		$attend_date=(date("Y-m-d",strtotime($row['Time'])));
		$time_in=(date("H:i:s",strtotime($row['Time'])));
		
		//emp_code is comming as following column
		
		$emp_code=$row['AC-No.'];
		
		//get status to check checkin values only
		$state=$row['State'];

	

		//prepare an array of required elements only
		
		$required_array = array();
		$required_array['emp_code'] = $emp_code;
		$required_array['attend_date'] = $attend_date;
		$required_array['time_in'] = $time_in;
		$required_array['state'] = $state;

//$filter_array=array('emp_code'=>$emp_code,$attend_date,$time_in,$state);



//check if employee data not already added to db_data_array and then the state is only checkin
//requirement is to add only first checkin array. File can have multiple checkins.
if(!array_key_exists ($emp_code,$db_data_array)&&($state == "C/In")){	
	
	
		//for easy searching and index related operations use employee code as index.	
		$db_data_array[$emp_code]=$required_array;

		}

		
}//end of filtering loop. Now we have proper db_data_array.
		
		
		/*echo '<pre> <strong>MASTER ARRAY</strong>';
			print_r($db_data_array);*/
			
	//get all the user_ids to be inserted		
	$users_id=array_keys($db_data_array);
	
	
		/*echo '<hr><pre> <strong>USER IDS</strong>';
		print_r($users_id);
		*/

			
		//check if users to be inserted are already present marked for this day or not.
		//limiration : following logic restricts usage of only 1 date in the file.
		//taking attend date from the very first row
		$attend_date=(date("Y-m-d",strtotime($data[0]['Time'])));
		
		
		$sheet_already_marked_users = $this->get_already_marked_attendance($users_id, $attend_date);	
			
			/*echo '<hr><pre> <strong>Already Marked Users</strong>';
			print_r($sheet_already_marked_users);
		*/

		
		
		// Checking  Arrays Differences. Subtract the already found users from the master records so that we don't insert those users again  		
		
		$new_users_att = array_diff( $users_id , $sheet_already_marked_users);
	
		
		/*
		echo '<hr>NEW USERS AFTER ARRAY DIFF <br>';
		 print_r($new_users_att);*/
		
		
		//if no new record return back the error	
		if(empty($new_users_att)){
			
			return 	$error = array('error_code'=>3, 'error_msg' =>'Employee Attendance record(s) are already added');		
			
		}
		
	//get full details of user_ids to be inserted in the datbase. We need to know their sallary start time , current tardy count	
	$userssheet_information =$this->get_user_details($new_users_att);
		
		
			if(empty($userssheet_information)){
			
			return 	$error = array('error_code'=>5, 'error_msg' =>'Employee Detail Information not found');		
			
		}
		
		
		/*echo '<h3>USER SHEET INFORMATION </h3>';
		print_r($userssheet_information);
		*/
		 $created_date = date('Y-m-d G:i:s');
		 $ip_address = $this->input->ip_address();
		 $created_by = $this->session->userdata('admin_id');
	
		 
		 
		 $sheet_batch_insert_data = array(); ///final array to be inserted into db

		//loop the user information to prepare batch insert data
		//read sallary , start time and current count from usersheet information. Read date and time from the upload sheet
		foreach($userssheet_information  as $user_detail){
			
			   $user_id  = $user_detail['id'];
			   $user_start_time =  $user_detail['start_time'];
			   $user_tardy_count =  $user_detail['current_tardy_count'];
			   $user_salary=$user_detail['salary'];
			   $per_day_salary=$user_salary/30;
			   $per_day_salary_formated = round( $per_day_salary,2,PHP_ROUND_HALF_UP);
			   $is_tardy = 0;		
			//tardy calculations
	$tardy_calculation = $this->tardy_calculation($attend_date,$db_data_array[$user_id]['time_in'] ,
	 $user_start_time , $user_tardy_count  , $user_id , $per_day_salary_formated );
	
			
			
			$batch_insert_item_array = array();
		
						
			$batch_insert_item_array['emp_Code']= $user_id;
			$batch_insert_item_array['attend_date']= $db_data_array[$user_id]['attend_date'];;
			$batch_insert_item_array['per_day_salary']= $per_day_salary_formated;
			$batch_insert_item_array['time_in']= $db_data_array[$user_id]['time_in'];
			
			$batch_insert_item_array['astatus']= 'P';			
			$batch_insert_item_array['user_id']= $created_by;
		
			$batch_insert_item_array['created_by']= $created_by;
			$batch_insert_item_array['created_by_ip']= $ip_address;
			$batch_insert_item_array['created_date']= $created_date;
			
			$batch_insert_item_array['is_tardy']= $tardy_calculation['is_tardy'];
			$batch_insert_item_array['timein_status']= $tardy_calculation['timein_status'];
			
			//add row to master array
				 $sheet_batch_insert_data[] = 	$batch_insert_item_array;
		}
		
		
	/*	$count=count($new_users_att);
		
		
		
		for($i =0; $i<$count; $i++){
			
			   $user_id  = $userssheet_information[$i]['id'];
			   $user_start_time =  $userssheet_information[$i]['start_time'];
			   $user_tardy_count =  $userssheet_information[$i]['current_tardy_count'];
			   $user_salary=$userssheet_information[$i]['salary'];


 $per_day_salary[$i]=$user_salary/30;
		$formatted_number = round( $per_day_salary[$i],2,PHP_ROUND_HALF_UP);
				
		
				$is_tardy = 0;
			
						if($status == 'P' ) {	
				$tardy_calculation = $this->tardy_calculation($attend_date,$data_array[$user_id]['time_in'] , $user_start_time , $user_tardy_count  ,  $new_users_att[$i], $formatted_number );
	
				}else{
					$tardy_calculation = array('is_tardy'=>0 , 'timein_status' => '');
					
				}

			$sheet_batch_insert_data[$i]  = array(
						   'emp_Code' => $users_id[$i],
						   'attend_date' => $this->db->escape_str(trim($attend_date)),
						   'per_day_salary' => $this->db->escape_str(trim($formatted_number)),
						   'time_in' => $data_array[$user_id]['time_in'],
						   'time_out' => $time_out,
						   'astatus' => $this->db->escape_str(trim($status)),
						   'remarks' => $this->db->escape_str(trim('')),
						   'user_id' => $this->db->escape_str(trim($created_by)),
						   'enty_type' => $this->db->escape_str(trim('')),
						   'reason' => $this->db->escape_str(trim('')),
						   'upload_time' => $this->db->escape_str(trim($created_date)),
						   'early_timeout_reason' => $this->db->escape_str(trim('')),
						   'created_by' => $this->db->escape_str(trim($created_by)),
						   'created_by_ip' => $this->db->escape_str(trim($ip_address)),
						   'created_date' => $this->db->escape_str(trim($created_date)),
						   'is_tardy'=> $tardy_calculation['is_tardy'],
				'timein_status' => $tardy_calculation['timein_status']
										  
						);
					
		//Insert the record into the database.
				
				//echo $this->db->last_query();
				
            }*/
			
			
			/*echo '<h3>BATCH INSERT FINAL DATA</h3>';
			print_r($sheet_batch_insert_data);*/
				//batch insert records
				$this->db->dbprefix('attendance');
				$ins_into_db = $this->db->insert_batch('attendance', $sheet_batch_insert_data);
			
			
			//exit;
		
	
}
public function edit_attendance_process($data){
		
		extract($data);
		
		 if($data['status']=='A' || $data['status']=='L'){
				$intime='00:00:00';
				$outtime='00:00:00';
			
				
				
		}else{
			
		
		
		
				
			
			
				$intime  = date("H:i:s", strtotime($data['intime']));
			
	
				if($outtime){
			 	$outtime  = date("H:i:s", strtotime($data['outtime']));
				}else{
					$outtime='00:00:00';
				}
				
				
		}
		
	$this->db->dbprefix('admin');
		$this->db->where_in('id',$user_id);
		//$this->db->where_in('emp_code',$users_string);
		$query_result= $this->db->get('admin');
		
		
		
		$users_information =  $query_result->row_array();
		
		
		$last_modified_date = date('Y-m-d G:i:s');
		$last_modified_ip = $this->input->ip_address();
		$last_modified_by = $this->session->userdata('admin_id');
$user_start_time =  $users_information['start_time'];
				$user_tardy_count =  $users_information['current_tardy_count'];
				 $user_salary=$users_information['salary'];
		
		//
		
		
	    $per_day_salary=$user_salary/30;
		$formatted_number = round( $per_day_salary,2,PHP_ROUND_HALF_UP);
				
		
		
			
						if($status == 'P' ) {	
				$tardy_calculation = $this->tardy_calculation($date,$intime , $user_start_time , $user_tardy_count  ,  $user_id, $formatted_number );
	
				}else{
					$tardy_calculation = array('is_tardy'=>0 , 'timein_status' => '');
					
				}
			/*	echo '.................... <br>';
				echo '<pre>';
				print_r($tardy_calculation);*/
			
					$date = date("Y-m-d", strtotime($date));
		$upd_data = array(
			    'emp_Code' => $user_id,
			    'attend_date' => $this->db->escape_str(trim($date)),
			    'per_day_salary'=>$this->db->escape_str(trim($formatted_number)),

			   'time_in' => $this->db->escape_str(trim($intime)),
			   'time_out' => $this->db->escape_str(trim($outtime)),
			   'astatus' => $this->db->escape_str(trim($status)),
			   
			  
			  
			     'last_modified_date' => $this->db->escape_str(trim($last_modified_date)),
		    	 'last_modified_by' => $this->db->escape_str(trim($last_modified_by)),
		    	 'last_modified_ip' => $this->db->escape_str(trim($last_modified_ip)),
			     'is_tardy' => $tardy_calculation['is_tardy'],
				 'timein_status' => $tardy_calculation['timein_status']
		);
/*		echo '<pre> <br>';
print_r($upd_data);
echo '...';
exit;*/
		//Update the record into the database.
		$this->db->dbprefix('attendance');
		$this->db->where('attendance.id',$page_id);
		
		$upd_into_db = $this->db->update('attendance', $upd_data);
		//echo $this->db->last_query(); exit;
		
		if($upd_into_db) return true;

	}//end edit_attendance()
	
}
?>