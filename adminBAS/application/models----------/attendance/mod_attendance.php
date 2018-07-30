<?php
class mod_attendance extends CI_Model {
	
	function __construct(){
		
        parent::__construct();
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

	//Get All Attendance
	public function get_all_attendance(){
		
		$this->db->dbprefix('attendance');
		$this->db->order_by('id DESC');
		$get_attendance = $this->db->get('attendance');

		//echo $this->db->last_query();
		$row_attendance['attendance_arr'] = $get_attendance->result_array();
		$row_attendance['attendance_count'] = $get_attendance->num_rows;
		
		return $row_attendance;
		
	}//end get_all_attendance

	//Get Attendance Record
	public function get_advertisement($add_id){
		
		$this->db->dbprefix('advertisements');
		$this->db->where('id',$add_id);
		$get_advertisement = $this->db->get('advertisements');

		//echo $this->db->last_query(); exit;
		$row_advertisement['advertisement_arr'] = $get_advertisement->row_array();
		$row_advertisement['advertisement_count'] = $get_advertisement->num_rows;
		return $row_advertisement;
		
	}//end get_advertisement
	
	
	//Upload Attendance
	public function upload($data){
		
		 extract($data);
		
		 $created_date = date('Y-m-d G:i:s');
		 $ip_address = $this->input->ip_address();
		 $created_by = $this->session->userdata('admin_id');
		
	
	    if($this->input->post('upload')){
			
		//Uploading Advertisement Image
		if($_FILES['file']['name'] != ''){

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
				
				$error_file_arr = array('error' => $this->upload->display_errors());
				echo "<pre>";
				print_r($error_file_arr);
				exit;
				
				return $error_file_arr;
				
			}
			
			 //Read CSV file
			 $this->load->library('csvreader');
			 
			 $filePath = $attendance_folder_path."/".$file_name;
             $data = $this->csvreader->parse_file($filePath);
			 
		    
			 foreach( $data as $field){

				$ins_data = array(
						   'emp_Code' => $this->db->escape_str(trim($field['Emp_Code'])),
						   'emp_name' => $this->db->escape_str(trim($field['Emp_Name'])),
						   'branch' => $this->db->escape_str(trim($field['Branch'])),
						   'attend_date' => $this->db->escape_str(trim($field['Attend_date'])),
						   'per_day_salary' => $this->db->escape_str(trim($field['per_day_salary'])),
						   'time_in' => $this->db->escape_str(trim($field['time_in'])),
						   'time_out' => $this->db->escape_str(trim($field['time_out'])),
						   'astatus' => $this->db->escape_str(trim($field['astatus'])),
						   'remarks' => $this->db->escape_str(trim($field['remarks'])),
						   'user_id' => $this->db->escape_str(trim($field['user_id'])),
						   'enty_type' => $this->db->escape_str(trim($field['entry_type'])),
						   'reason' => $this->db->escape_str(trim($field['reason'])),
						   'upload_time' => $this->db->escape_str(trim($field['upload_time'])),
						   'early_timeout_reason' => $this->db->escape_str(trim($field['early_timeout_reason'])),
						   'created_by' => $this->db->escape_str(trim($created_by)),
						   'created_by_ip' => $this->db->escape_str(trim($ip_address)),
						   'created_date' => $this->db->escape_str(trim($created_date))
										  
						);

				//Insert the record into the database.
				$this->db->dbprefix('attendance');
				$ins_into_db = $this->db->insert('attendance', $ins_data);
				//echo $this->db->last_query();
				
            }
			
		}//end if($_FILES['image']['name'] != '')
	   }//End if type Upload
	
	 if($this->input->post('uload_manually')){
		
		$date = date("Y-m-d", strtotime($date));
		$in_time=date("H:i", strtotime($intime));
		$out_time=date("H:i", strtotime($outtime));
		
		//$time_in_12_hour_format  = date("g:i a", strtotime("13:30"));
		
		$this->db->dbprefix('admin');
		$this->db->where('id',$user_id);
		$get_user = $this->db->get('admin');

		//echo $this->db->last_query();
		$row_user= $get_user->row_array();
	    $user_salary=$row_user['salary'];
		
		$month=date('m');
		$year=date('Y');
		$days=cal_days_in_month(CAL_GREGORIAN,$month,$year);
	    $per_day_salary=$user_salary/$days;

		$ins_data = array(
			   'emp_Code' => $this->db->escape_str(trim($row_user['id'])),
			   'emp_name' => $this->db->escape_str(trim($row_user['username'])),
			   'branch' => $this->db->escape_str(trim($row_user['branch_id'])),
			   'attend_date' => $this->db->escape_str(trim($date)),
			   'per_day_salary' => $this->db->escape_str(trim($per_day_salary)),
			   'time_in' => $this->db->escape_str(trim($in_time)),
			   'time_out' => $this->db->escape_str(trim($out_time)),
			   'astatus' => $this->db->escape_str(trim($status)),
			   'remarks' => $this->db->escape_str(trim('')),
			   'user_id' => $this->db->escape_str(trim($created_by)),
			   'enty_type' => $this->db->escape_str(trim()),
			   'reason' => $this->db->escape_str(trim('')),
			   'upload_time' => $this->db->escape_str(trim($created_date)),
			   'early_timeout_reason' => $this->db->escape_str(trim('')),
			   'created_by' => $this->db->escape_str(trim($created_by)),
			   'created_by_ip' => $this->db->escape_str(trim($ip_address)),
			   'created_date' => $this->db->escape_str(trim($created_date))
											  
			);

		//Insert the record into the database.
		$this->db->dbprefix('attendance');
		$ins_into_db = $this->db->insert('attendance', $ins_data);
		//echo $this->db->last_query();
		
	    }//End if type manually Upload
		
		return true;

	}//end add_advertisement()
	

	//Delete Advertisement
	public function delete_advertisement($add_id){


		$get_data = $this->mod_advertisements->get_advertisement($add_id);
		$get_data_arr = $get_data['advertisement_arr'];
		
		//Create User Directory if not exist
		$advertisement_folder_path = '../assets/advertisements';

	    $old_file_name = $get_data_arr['image'];
		

		//Delete Existing Image
		if(file_exists($advertisement_folder_path.'/'.$old_file_name)){
			
			unlink($advertisement_folder_path.'/'.$old_file_name);
			unlink($advertisement_folder_path.'/thumb/'.$old_file_name);
		}//end if
		
		//Delete the record from the database.
		$this->db->dbprefix('advertisements');
		$this->db->where('id',$add_id);
		$del_into_db = $this->db->delete('advertisements');
		//echo $this->db->last_query(); exit;
		
		if($del_into_db) return true;

	}//end delete_advertisement()

}
?>