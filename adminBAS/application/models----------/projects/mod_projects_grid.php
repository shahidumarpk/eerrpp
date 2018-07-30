<?php
class mod_projects extends CI_Model {
	
	function __construct(){
		
        parent::__construct();
    }

	//Verify If User is Login on the authorized Pages.
	public function verify_is_admin_login(){
		
		if(!$this->session->userdata('admin_id')){
			

			$this->session->set_flashdata('err_message', '- You have to login to access this page.');
			redirect(base_url().'login/login');
			
		}//if(!$this->session->userdata('id'))
		
	}//end verify_is_user_login()

	
	//Get All Branches
		public function get_all_branches(){
			
			$this->db->dbprefix('branches');
			$this->db->order_by('id DESC');
			$get_branches = $this->db->get('branches');
	
			//echo $this->db->last_query();
			$row_branches['branches_arr'] = $get_branches->result_array();
			$row_branches['branches_count'] = $get_branches->num_rows;
			
			return $row_branches;
			
		}//end get_all_branches
		


    //Get projects  Record
	public function get_projects(){
		
		
	    $user_id=$this->session->userdata('admin_id');
		
		 if($this->input->post('branch_id')!="" && $this->input->post('search_status')!=""){
		
			 
	    $this->db->dbprefix('projects');
		$this->db->select('projects.*,customers.first_name,customers.last_name');
        $this->db->from('projects');
		$this->db->where('projects.branch_id',$this->input->post('branch_id'));
		$this->db->where('projects.status',$this->input->post('search_status'));
        $this->db->join('customers', 'projects.customer_id = customers.id');
		$this->db->order_by('id',DESC);
		$get_projects= $this->db->get();
		//echo $this->db->last_query();exit;
			
		 }
		
		 elseif($this->input->post('search_status')!=""){
			 
	    $this->db->dbprefix('projects');
		$this->db->select('projects.*,customers.first_name,customers.last_name');
        $this->db->from('projects');
		$this->db->where('projects.status',$this->input->post('search_status'));
        $this->db->join('customers', 'projects.customer_id = customers.id');
		$this->db->order_by('id',DESC);
		$get_projects= $this->db->get();
			
			
		 }
		 elseif($this->input->post('branch_id')!=""){
			 
	    $this->db->dbprefix('projects');
		$this->db->select('projects.*,customers.first_name,customers.last_name');
        $this->db->from('projects');
		$this->db->where('projects.branch_id',$this->input->post('branch_id'));
        $this->db->join('customers', 'projects.customer_id = customers.id');
		$this->db->order_by('id',DESC);
		$get_projects= $this->db->get();
			
			
		 }
		
		 else{
			
		$this->db->dbprefix('projects');
		$this->db->select('projects.*,customers.first_name,customers.last_name');
        $this->db->from('projects');
		$this->db->where('projects.status',1);
		$this->db->or_where('projects.status',0);
        $this->db->join('customers', 'projects.customer_id = customers.id');
		$this->db->order_by('id',DESC);
		$get_projects= $this->db->get();
		//echo $this->db->last_query();exit;
		 }

		//echo $this->db->last_query();
		
		$row_projects_arr['projects_arr'] = $get_projects->result_array();
		
		for($i=0; $i<count($row_projects_arr['projects_arr']); $i++){
			
			$branch_id=$row_projects_arr['projects_arr'][$i]['branch_id'];
			$this->db->dbprefix('branches');
			$this->db->select('branch_name');
			$this->db->from('branches');
			$this->db->where('id',$branch_id);
		    $get_branches = $this->db->get();
			$row_branch= $get_branches->row_array();
			$row_projects_arr['projects_arr'][$i]['branch_name']=$row_branch['branch_name'];
			
			}
		
		//echo "<pre>"; print_r($row_projects['projects_arr']); exit;
		if($user_id != '1'){ //Admin Check
					$counter = 0 ; 	
					$h = 0 ;
					for($k=0;$k<count($row_projects_arr['projects_arr']);$k++){
					$explode_arr = explode(',',$row_projects_arr['projects_arr'][$k]['project_assign']);
						
							if(in_array($user_id,$explode_arr))
							
							{
								
				//	$row_projects['projects_filter'] = $row_projects['projects_arr'][$k] ; 
								
					$row_projects['projects_filter'][$h]['id'] = $row_projects_arr['projects_arr'][$k]['id'] ;
					$row_projects['projects_filter'][$h]['project_id'] = $row_projects_arr['projects_arr'][$k]['project_id'] ;
					$row_projects['projects_filter'][$h]['customer_id'] = $row_projects_arr['projects_arr'][$k]['customer_id'] ;
					$row_projects['projects_filter'][$h]['project_title'] = $row_projects_arr['projects_arr'][$k]['project_title'] ;
					$row_projects['projects_filter'][$h]['project_amount'] = $row_projects_arr['projects_arr'][$k]['project_amount'] ;
					$row_projects['projects_filter'][$h]['start_date'] = $row_projects_arr['projects_arr'][$k]['start_date'] ;
					$row_projects['projects_filter'][$h]['end_date'] = $row_projects_arr['projects_arr'][$k]['end_date'] ;
					$row_projects['projects_filter'][$h]['project_detail'] = $row_projects_arr['projects_arr'][$k]['project_detail'] ;
					$row_projects['projects_filter'][$h]['project_assign'] = $row_projects_arr['projects_arr'][$k]['project_assign'] ;
					
					$row_projects['projects_filter'][$h]['status'] = $row_projects_arr['projects_arr'][$k]['status'] ;
					
					$row_projects['projects_filter'][$h]['created_by'] = $row_projects_arr['projects_arr'][$k]['created_by'] ;
					$row_projects['projects_filter'][$h]['created_date'] = $row_projects_arr['projects_arr'][$k]['created_date'] ;
					$row_projects['projects_filter'][$h]['created_by_ip'] = $row_projects_arr['projects_arr'][$k]['created_by_ip'] ;
					$row_projects['projects_filter'][$h]['last_modified_by'] = $row_projects_arr['projects_arr'][$k]['last_modified_by'] ;
					$row_projects['projects_filter'][$h]['last_modified_date'] = $row_projects_arr['projects_arr'][$k]['last_modified_date'] ;
					$row_projects['projects_filter'][$h]['last_modified_ip'] = $row_projects_arr['projects_arr'][$k]['last_modified_ip'] ;
					$row_projects['projects_filter'][$h]['first_name'] = $row_projects_arr['projects_arr'][$k]['first_name'] ;
					$row_projects['projects_filter'][$h]['last_name'] = $row_projects_arr['projects_arr'][$k]['last_name'] ;
                  
				   
				   for($i=0; $i<count($row_projects_arr['projects_arr']); $i++){
			
			$branch_id=$row_projects_arr['projects_arr'][$h]['branch_id'][$i] = $row_projects_arr['projects_arr'][$k]['branch_id'] ;
			
			$this->db->dbprefix('branches');
			$this->db->select('branch_name');
			$this->db->from('branches');
			$this->db->where('id',$branch_id);
		    $get_branches = $this->db->get();
			$row_branch= $get_branches->row_array();
			$row_projects['projects_filter'][$h]['branch_name']=$row_branch['branch_name'];
			
			}
				   
								$h++;
								$counter  = $counter + 1 ;   
								
							//echo "<pre>"; print_r($row_projects['projects_filter']); exit; 	
							}
					
					}
			
			//echo "<pre>"; print_r($row_projects['projects_filter']); exit; 
			}else{
					
					$row_projects['projects_filter'] = $row_projects_arr['projects_arr'] ; 
					$counter = $get_projects->num_rows;		
					
			}
		
		$row_projects['projects_count'] = $counter ; 
		
		return $row_projects;
		
	}//end Project Records
  
  
  
  
   //Get All Forums
	public function get_all_forums(){
		
		$this->db->dbprefix('forums');
		$get_forums= $this->db->get('forums');
		//echo $this->db->last_query();
		$row_forums['forums_arr'] = $get_forums->result_array();
		$row_forums['forums_count'] = $get_forums->num_rows;
		
		return $row_forums;
		
	}//end all Forums
  
  
   //Get All users
	public function get_all_users(){
		
		$this->db->dbprefix('admin');
		$this->db->where('id !=',1);
		$get_projects= $this->db->get('admin');
		//echo $this->db->last_query();
		$row_users['users_arr'] = $get_projects->result_array();
		$row_users['users_count'] = $get_projects->num_rows;
		
		return $row_users;
		
	}//end all users


	//Add new Project
	public function add_project($data){
		
		  extract($data);
		
		   $start_date = date("Y-m-d", strtotime($start_date));
		   $end_date = date("Y-m-d", strtotime($end_date));
		
	
		   $created_date = date('Y-m-d G:i:s');
		   $created_by_ip = $this->input->ip_address();
		   $created_by = $this->session->userdata('admin_id');
		   
		   $users= $this->mod_common->assign_project_users();
		  
		   
		   if($project_assign !=""){
			   
			    $assign=array_merge($users,$project_assign);
		        $new_project_assign=array_unique($assign);
		        $fnl_project_assign= array_values($new_project_assign);
			    $project_assign=implode(',',$new_project_assign);
				
			   
		   }
		   else{
			   
		    $fnl_project_assign=$users; 
		    $project_assign=implode(',',$users);
			
		   }//End if
		   
		
		   
		   $ins_data = array(
		    'branch_id' => $this->db->escape_str(trim($branch_id)),
		    'project_id' => $this->db->escape_str(trim($project_id)),
		    'customer_id' => $this->db->escape_str(trim($customer_id)),
			'forum_id' => $this->db->escape_str(trim($forum_id)),
			'project_title' => $this->db->escape_str(trim($project_subject)),
			'project_amount' => $this->db->escape_str(trim($project_amount)),
		    'start_date' => $this->db->escape_str(trim($start_date)),
			'end_date' => $this->db->escape_str(trim($end_date)),
		    'project_detail' => $this->db->escape_str(trim(nl2br($project_detail))),
			'live_url' => $this->db->escape_str(trim($live_url)),
			'local_url' => $this->db->escape_str(trim($local_url)),
			'project_assign' => $this->db->escape_str(trim($project_assign)),
			'status' => $this->db->escape_str(trim($status)),
		    'created_by' => $this->db->escape_str(trim($created_by)),
		    'created_date' => $this->db->escape_str(trim($created_date)),
		    'created_by_ip' => $this->db->escape_str(trim($created_by_ip))
		    );		

		   //Inserting the record into the database.
		  $this->db->dbprefix('projects');
		  $ins_into_db = $this->db->insert('projects', $ins_data);
		  $project_id= $this->db->insert_id();
		 
	
			
	      for($i=0; $i<count($_FILES['attachments']['name']); $i++)
		   {
			   
			 if($_FILES['attachments']['name'][$i] !=""){
				 
			
		     $projects_folder_path = '../assets/project_attachments/'.$project_id;
			 
			 
			 if(!is_dir($projects_folder_path))
			 mkdir($projects_folder_path,0777);
			 
			 copy('../assets/img/index.html','../assets/project_attachments/'.$project_id.'/index.html');
			 $attach_name[$i]=str_replace(' ','_',$_FILES['attachments']['name'][$i]);
			  		
		     $attachment_name = "project_".$project_id.'_'.$attach_name[$i]; 
		   
		   $this->load->helper(array('form', 'url'));
		   $config['upload_path'] = $projects_folder_path;
			$config['allowed_types'] = 'jpg|jpeg|gif|tiff|png|doc|docx|xls|xlsx|pdf|txt|zip|rar';
			$config['max_size']	= '5000';
			$config['overwrite'] = true;
	
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			$this->load->library('multipleupload',$config);

			$upload_epaper =  $this->multipleupload->do_multi_upload_project('attachments',TRUE,$project_id);
			if(!$upload_epaper){
				
				return $error_file_arr = array('error' =>"Opps...! Error in File Uploading");
		     }else{
				 
				 $ins_attachment = array(
			    'project_id' => $this->db->escape_str(trim($project_id)),
				'attachment_name' => $this->db->escape_str(trim($attachment_name)),
				'created_by' => $this->db->escape_str(trim($created_by)),
				'created_date' => $this->db->escape_str(trim($created_date)),
				'created_by_ip' => $this->db->escape_str(trim($created_by_ip))
			 );			
	
		
		      //Inserting the record into the database.
		      $this->db->dbprefix('project_attachments');
		      $ins_into_db = $this->db->insert('project_attachments', $ins_attachment);
				 
		     }
			//echo $this->db->last_query(); exit;
	
		   
		 }//End if
		 
		}//End for loop
		
	    
		//Send Message to Assign Users
		for($j=0;$j<count($fnl_project_assign); $j++){
			
			//Mesage id Generator
		    $message_id = $this->mod_common->random_number_generator(7);
		    $message_id = $this->mod_projects->message_id_generator($message_id);
		 
			
			$subject='New Project Assigned to you : '.$project_subject;
			$message="Dear User, a new project is assigned to you. Please go to Project section to see more details. Thank  You!";
			
			$to_user = $fnl_project_assign[$j];
			
			 $ins_msg_data = array(
		    'to' => $this->db->escape_str(trim($to_user)),
		    'from' => $this->db->escape_str(trim($created_by)),
		    'subject' => $this->db->escape_str(trim($subject)),
			'message' => $this->db->escape_str(trim(nl2br($message))),
		    'message_id' => $this->db->escape_str(trim($message_id)),
		    'created_by' => $this->db->escape_str(trim($created_by)),
		    'date' => $this->db->escape_str(trim($created_date)),
		    'created_by_ip' => $this->db->escape_str(trim($created_by_ip))
		    );		

		   //Inserting the record into the database.
		  $this->db->dbprefix('messages');
		  $ins_into_db = $this->db->insert('messages', $ins_msg_data);
			
		}//End For////////// End Message to Assign Users	
		
	
		
		 /********************************/
		//Customer Email  Contents
		
		$this->db->dbprefix('customers');
		$this->db->where('id',$customer_id);
		$get_customer= $this->db->get('customers');
		//echo $this->db->last_query();
		$row_customer['customer_arr'] = $get_customer->row_array();
		
	    $customer_first_last_name=$row_customer['customer_arr']['first_name']." ".$row_customer['customer_arr']['last_name'];
		$email_address =$row_customer['customer_arr']['email_address'];
		
		
		$email_from_txt_arr = $this->mod_preferences->get_preferences_setting('email_from_txt');
		$email_from_txt = $email_from_txt_arr['setting_value'];
		$noreply_email_arr = $this->mod_preferences->get_preferences_setting('noreply_email');
	    $noreply_email = $noreply_email_arr['setting_value'];
		
		$sitename_arr = $this->mod_preferences->get_preferences_setting('site_name');
		$site_name = $sitename_arr['setting_value'];
		$sitelogo_arr = $this->mod_preferences->get_preferences_setting('site_logo');
		$site_logo = $sitelogo_arr['setting_value'];
		
		$get_email_data = $this->mod_email->get_email(10);
		$email_subject = $get_email_data['email_arr']['email_subject'];
		$email_body = $get_email_data['email_arr']['email_body'];
		$search_arr = array('[SITE_URL]','[SITE_NAME]','[SITE_LOGO]','[CUSTOMER_FIRST_LAST_NAME]','[PROJECT_TITLE]','[PROJECT_DESCIPTION]');
		$replace_arr = array(MURL,$site_name,$site_logo,$customer_first_last_name,$project_subject,$project_detail);
		$email_body = str_replace($search_arr,$replace_arr,$email_body);
	
	
		//Preparing Sending Email
		$config['charset'] = 'utf-8';
		$config['mailtype'] = 'html';
		$config['wordwrap'] = TRUE;			
		$config['protocol'] = 'mail';
			
		$this->load->library('email',$config);

		$this->email->from($noreply_email, $email_from_txt);
		$this->email->to($email_address);
		$this->email->subject($email_subject);
		$this->email->message($email_body);
		$this->email->send();
		//echo $this->email->print_debugger();
		$this->email->clear();
	    //echo $this->db->last_query(); exit;	
	
		
	     return true;
		
		
	}//end Add new Project

	
	public function get_project_details($project_id){
		
	
		$this->db->dbprefix('projects');
		$this->db->where('id',$project_id);
		$get_messages= $this->db->get('projects');
        //echo $this->db->last_query();
		$project_detail_arr['project_detail_result'] = $get_messages->row_array();
		
		//Get Project Attachments
		$this->db->dbprefix('project_attachments');
		$this->db->where('project_id',$project_id);
		$get_project_attachments= $this->db->get('project_attachments');
		
		$project_detail_arr['project_attachments'] = $get_project_attachments->result_array();
		$project_detail_arr['project_attachments_count'] = $get_project_attachments->num_rows;
		
		
		return $project_detail_arr;		
		
	}//end get_project_details
	

	
	public function edit_project($data){
		
		extract($data);
		
		$last_modified_date = date('Y-m-d G:i:s');
		$last_modified_ip = $this->input->ip_address();
		$last_modified_by = $this->session->userdata('admin_id');
		
		$start_date = date("Y-m-d", strtotime($start_date));
	    $end_date = date("Y-m-d", strtotime($end_date));
		
		$users= $this->mod_common->assign_project_users();
		
		if($project_assign !=""){
			
		 $assign=array_merge($users,$project_assign);
		 $new_project_assign=array_unique($assign);
		 $fnl_project_assign= array_values($new_project_assign);
	     $project_assign=implode(',',$new_project_assign);
		
		}
		else{
			
			 $project_assign=implode(',',$users);
			
			}	
		
		$upd_data = array(
		    'branch_id' => $this->db->escape_str(trim($branch_id)),
		    'project_id' => $this->db->escape_str(trim($project_id)),
		    'customer_id' => $this->db->escape_str(trim($customer_id)),
			'forum_id' => $this->db->escape_str(trim($forum_id)),
			'project_title' => $this->db->escape_str(trim($project_subject)),
			'project_amount' => $this->db->escape_str(trim($project_amount)),
		    'start_date' => $this->db->escape_str(trim($start_date)),
			'end_date' => $this->db->escape_str(trim($end_date)),
		    'project_detail' => $this->db->escape_str(trim(nl2br($project_detail))),
			'live_url' => $this->db->escape_str(trim($live_url)),
			'local_url' => $this->db->escape_str(trim($local_url)),
			'project_assign' => $this->db->escape_str(trim($project_assign)),
			'status' => $this->db->escape_str(trim(nl2br($status))),
		    'last_modified_date' => $this->db->escape_str(trim($last_modified_date)),
		    'last_modified_by' => $this->db->escape_str(trim($last_modified_by)),
		    'last_modified_ip' => $this->db->escape_str(trim($last_modified_ip))
		);	
		
	
		//Updating the record into the database.
		$this->db->dbprefix('projects');
		$this->db->where('id',$id);
		$upd_into_db = $this->db->update('projects', $upd_data);
		
			
		for($i=0; $i<count($_FILES['attachments']['name']); $i++)
		   
		   {	
		   
		   if($_FILES['attachments']['name'][$i] !=""){
			   
			 $projects_folder_path = '../assets/project_attachments/'.$id;
			 
			 if(!is_dir($projects_folder_path))
			 mkdir($projects_folder_path,0777);
			 $attach_name[$i]=str_replace(' ','_',$_FILES['attachments']['name'][$i]);
		     $attachment_name = "project_".$id.'_'.$attach_name[$i]; 
			
			$this->load->helper(array('form', 'url'));
			$config['upload_path'] = $projects_folder_path;
			$config['allowed_types'] = 'jpg|jpeg|gif|tiff|png|doc|docx|xls|xlsx|pdf|txt|zip|rar';
			$config['max_size']	= '5000';
			$config['overwrite'] = true;
	
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			$this->load->library('multipleupload',$config);

			$upload_epaper =  $this->multipleupload->do_multi_upload_project('attachments',TRUE,$id);
			if(!$upload_epaper){
				return $error_file_arr = array('error' =>"Opps...! Error in File Uploading");
				
			}
			$ins_attachment = array(
			    'project_id' => $this->db->escape_str(trim($id)),
				'attachment_name' => $this->db->escape_str(trim($attachment_name)),
				'created_by' => $this->db->escape_str(trim($created_by)),
				'created_date' => $this->db->escape_str(trim($created_date)),
				'created_by_ip' => $this->db->escape_str(trim($created_by_ip))
			 );	
		   //Inserting the record into the database.
		   $this->db->dbprefix('project_attachments');
		   $ins_into_db = $this->db->insert('project_attachments', $ins_attachment);
			
		   }//End for loop if attachment is not empty
		}//End For loop
		
		
	     return true;
		
	}//end Edit Project
	
	
	//Delete project_project_attachment
	public function delete_project_attachment($attachment_id){
		
		//Get Record
		$this->db->dbprefix('project_attachments');
		$this->db->where('id',$attachment_id);
		$get_record = $this->db->get('project_attachments');
		$get_attachment_arr= $get_record->row_array();
		
		 //print_r($get_attachment_arr);
		
		$attachment_name=$get_attachment_arr['attachment_name'];
		$project_id=$get_attachment_arr['project_id'];
		
		$projects_folder_path = '../assets/project_attachments/'.$project_id;
		
		//Delete Existing Image
		if(file_exists($projects_folder_path.'/'.$attachment_name)){
			
			unlink($projects_folder_path.'/'.$attachment_name);
			
		}//end if
		
		
		//Delete the record from the database.
		$this->db->dbprefix('project_attachments');
		$this->db->where('id',$attachment_id);
		$del_into_db = $this->db->delete('project_attachments');
		//$this->db->last_query();
		
		if($del_into_db) return true;

	}//end
	
	
	
	//Delete project_project
	public function delete_project($project_id){
		
		//Delete the record from the database.
		$this->db->dbprefix('projects');
		$this->db->where('id',$project_id);
		$del_into_db = $this->db->delete('projects');
		//$this->db->last_query();
		
		//Get project Attachments Record
		$this->db->dbprefix('project_attachments');
		$this->db->where('project_id',$project_id);
		$get_record = $this->db->get('project_attachments');
		$get_attachment_arr= $get_record->result_array();
		$get_attachment_count= $get_record->num_rows();
	
	
	    $projects_folder_path = '../assets/project_attachments/'.$project_id;
		
			
		 //Delete projects folder path
	   $this->mod_common->remove_directory($projects_folder_path,true);	
			
		//Delete Project messages
		$this->db->dbprefix('project_messages');
		$this->db->where('project_id',$project_id);
		$del_into_db = $this->db->delete('project_messages');
		
		//Get Project Messages Attachments
		$this->db->dbprefix('project_messages_attachments');
		$this->db->where('project_id',$project_id);
		$get_message_attach= $this->db->get('project_messages_attachments');
		$get_message_attach_arr= $get_message_attach->result_array();
		$get_message_attach_count= $get_message_attach->num_rows();	
		
	
		if($del_into_db) return true;

	}//end delete_project
	
	
	public function project_detail($project_id){
		
		
	
		$this->db->dbprefix('projects');
		
		$this->db->select('projects.*,customers.first_name,customers.last_name,customers.id');
        $this->db->from('projects');
        $this->db->join('customers', 'projects.customer_id = customers.id');
		$this->db->where('projects.id',$project_id);
		$get_project_details= $this->db->get();
		
		
		
		//Get Project Attachments
		$this->db->dbprefix('project_attachments');
		$this->db->where('project_id',$project_id);
		$get_project_attachments= $this->db->get('project_attachments');
		
		$get_project_details_arr['project_attachments'] = $get_project_attachments->result_array();
		$get_project_details_arr['project_attachments_count'] = $get_project_attachments->num_rows;
		
        //echo $this->db->last_query();
		
		$get_project_details_arr['project_details_result'] = $get_project_details->row_array();
		
		
		$project_assign_id= explode(',',$get_project_details_arr['project_details_result']['project_assign']);
		
		if(in_array($this->session->userdata('admin_id'),$project_assign_id)){
			
			
			for($i=0;$i<count($project_assign_id); $i++){
			
			$this->db->dbprefix('admin');
			$this->db->select('id,admin_role_id,first_name,last_name');
			$this->db->from('admin');
			$this->db->where('id',$project_assign_id[$i]);
			$get_user= $this->db->get();
			$get_user_arr['user_arr'] = $get_user->row_array();
	  $get_project_details_arr['project_assign_team'][$i]['user_name']= $get_user_arr['user_arr']['first_name']." ".$get_user_arr['user_arr']['last_name'];
	  
	 $get_project_details_arr['project_assign_team'][$i]['id']= $get_user_arr['user_arr']['id'];
	  
	          $admin_role_id= $get_user_arr['user_arr']['admin_role_id']; 
			  $this->db->dbprefix('admin_roles');
			  $this->db->select('role_title');
			  $this->db->from('admin_roles');
			  $this->db->where('id',$admin_role_id);
			  $get_role= $this->db->get();
			  $get_role_arr['user_arr'] = $get_role->row_array();
			  
			  $get_project_details_arr['role'][$i]=$get_role_arr['user_arr']['role_title'];
			  
			
			}
	    /*  echo "<pre>";	
		   print_r( $get_project_details_arr);	
		
	        exit;*/
		return $get_project_details_arr;
			
		
			
		}else{
			
			return  $get_project_details_arr['error']= array('error' =>"Opps...! Error in File Uploading");
			
		}
		
		
				
		
	}//end get_messages
	

   


	public function project_messages($data){
		
		extract($data);
		
		 $created_date = date('Y-m-d G:i:s');
		 $created_by_ip = $this->input->ip_address();
		 
		 $created_by = $this->session->userdata('admin_id');
		 
		 ///////////////////
		 //Send message to all team assigned
		
		 $this->db->dbprefix('projects');
		 $this->db->where('id',$project_id);
		 $get_project_messages= $this->db->get('projects');
		//echo $this->db->last_query();
		$get_team_arr['team_arr'] = $get_project_messages->row_array();
		$team_members=explode(',',$get_team_arr['team_arr']['project_assign']); 
		
		
		for($i=0; $i<count($team_members); $i++){
			
			 $message_id = $this->mod_common->random_number_generator(7);
			 $message_id = $this->mod_projects->message_id_generator($message_id);
	
		     $message_subject="You have recieved a new message on project ".$get_team_arr['team_arr']['project_title']." by ".strtoupper($this->session->userdata('display_name'));
			 
			
	  $message='To see complete message please click on the link below:<br /><a href="'.base_url().'projects/manage-projects/project-detail/'.$project_id.'">'.base_url().'projects/manage-projects/project-detail/'.$project_id.'</a>';
			
			 $ins_data = array(
		    'to' => $this->db->escape_str(trim($team_members[$i])),
		    'from' => $this->db->escape_str(trim($created_by)),
		    'subject' => $this->db->escape_str(trim($message_subject)),
			'message' => $this->db->escape_str(trim(nl2br($message))),
		    'message_id' => $this->db->escape_str(trim($message_id)),
			'attachment' => $this->db->escape_str(trim($attachment_name)),
		    'created_by' => $this->db->escape_str(trim($created_by)),
		    'date' => $this->db->escape_str(trim($created_date)),
		    'created_by_ip' => $this->db->escape_str(trim($created_by_ip))
		    );		
  
			 if($created_by != $team_members[$i]){
			   //Inserting the record into the database.
			  $this->db->dbprefix('messages');
			  $ins_into_db = $this->db->insert('messages', $ins_data);
			 }
		}//End message to all assigned team
		
		
		$insrt_data = array(
		    'project_id' => $this->db->escape_str(trim($project_id)),
		    'to' => $this->db->escape_str(trim($to)),
			'from' => $this->db->escape_str(trim($created_by)),
			'message' => $this->db->escape_str(trim(nl2br($message_reply))),
			'user_type' => $this->db->escape_str('u'),
			'created_by' => $this->db->escape_str(trim($created_by)),
		    'created_date' => $this->db->escape_str(trim($created_date)),
		    'created_by_ip' => $this->db->escape_str(trim($created_by_ip))
		);		

		//inserting the record into the database.
		$this->db->dbprefix('project_messages');
		$upd_into_db = $this->db->insert('project_messages', $insrt_data);
		$message_id= $this->db->insert_id();
		
		
		for($i=0; $i<count($_FILES['attachments']['name']); $i++)
		   
		   {	
			
		   if($_FILES['attachments']['name'][$i] !=""){
			   
			   
		     $project_folder_path = '../assets/project_attachments/'.$project_id;
			 
			 if(!is_dir($project_folder_path))
			 mkdir($project_folder_path,0777);
			
			 $attach_name[$i]=str_replace(' ','_',$_FILES['attachments']['name'][$i]);
			
		     $attachment_name = "project_message_".$message_id.'_'.$attach_name[$i]; 
			
			$this->load->helper(array('form', 'url'));
			$config['upload_path'] = $project_folder_path;
			$config['allowed_types'] = 'jpg|jpeg|gif|tiff|png|doc|docx|xls|xlsx|pdf|txt||zip|rar';
			$config['max_size']	= '5000';
			$config['overwrite'] = true;
	
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			$this->load->library('multipleupload',$config);

			$upload_epaper =  $this->multipleupload->do_multi_upload_project_message_attachments('attachments',TRUE,$message_id);
			
			if(!$upload_epaper){
				
			return $error_file_arr = array('error' =>"Opps...! Error in File Uploading");
				
			}
			
			$ins_attachment = array(
			    'project_id' => $this->db->escape_str(trim($project_id)),
				'project_message_id' => $this->db->escape_str(trim($message_id)),
				'attachments' => $this->db->escape_str(trim($attachment_name)),
				'created_by' => $this->db->escape_str(trim($created_by)),
				'created_date' => $this->db->escape_str(trim($created_date)),
				'created_by_ip' => $this->db->escape_str(trim($created_by_ip))
			 );			
	
		
		   //Inserting the record into the database.
		    $this->db->dbprefix('project_messages_attachments');
		    $ins_into_db = $this->db->insert('project_messages_attachments', $ins_attachment);
			//echo $this->db->last_query(); exit;
			
		   }//End for loop if attachment is not empty
	   }//End for loop
		
		
		//Send Email to Customer
		$this->load->helper(array('email', 'url'));
	
		//Preparing Sending Email
		$config['charset'] = 'utf-8';
		$config['mailtype'] = 'html';
		$config['wordwrap'] = TRUE;			
		$config['protocol'] = 'mail';
		
		$this->load->library('email',$config);
		
	   //fetching email data from site preferences
   	   $this->db->dbprefix('customers');
	   $this->db->where('id',$to);
	   $get = $this->db->get('customers');
	   $email_data= $get->row_array();
	   
	   $to_customer=$email_data['email_address'];
	
	  $this->load->model('site_preferences/mod_preferences');		 
	  $email_from_txt_arr = $this->mod_preferences->get_preferences_setting('email_from_txt');
	  $email_from_txt = $email_from_txt_arr['setting_value'];
	  $noreply_email_arr = $this->mod_preferences->get_preferences_setting('noreply_email');
	  $noreply_email = $noreply_email_arr['setting_value'];
	  $subject = $project_title;
	  
	  $email_body="Your Have Recieve One New Message:<br /><br /> " .$message_reply;
		 
	  $this->email->from($noreply_email, $email_from_txt);
	  $this->email->to($to_customer);
	  $this->email->subject($subject);
	  $this->email->message($email_body);
	 // $this->email->attach($invoice_pdf_path);
	  $this->email->send();
	//$this->email->print_debugger();
	 $this->email->clear();
		
	     return true;
		
	}//end project_messages
	
	
	public function get_message_attachments($project_id){
		
		$this->db->dbprefix('project_messages_attachments');
		$this->db->where('project_id',$project_id);
		$get_messages_attachments = $this->db->get('project_messages_attachments');
		
		$message_att_arr = $get_messages_attachments->result_array();
		
		$final_message_attach_arr = array();
		
		//echo $this->db->last_query(); exit;
		for($i=0;$i<count($message_att_arr);$i++){
			
			$final_message_attach_arr[$message_att_arr[$i]['project_message_id']][] = $message_att_arr[$i]['attachments'];
			
		}//end for
		//print_r($final_message_attach_arr);
	
		return $final_message_attach_arr;
		
	}//end get_message_attachments
	
	public function get_project_messages($project_id){
	
		$this->db->dbprefix('project_messages');
		$this->db->where('project_id',$project_id);
		$this->db->order_by('id',DESC);
		$get_project_messages= $this->db->get('project_messages');
        //echo $this->db->last_query();
		$get_project_messages_arr['project_messages_result'] = $get_project_messages->result_array();
		$get_project_messages_arr['project_messages_count'] = $get_project_messages->num_rows();
		
		
		for($i=0; $i<$get_project_messages_arr['project_messages_count']; $i++)
		{
			
		   $user_type=$get_project_messages_arr['project_messages_result'][$i]['user_type'];
		   $from=$get_project_messages_arr['project_messages_result'][$i]['from'];
		
		if($user_type=='u'){
			
		       $this->db->dbprefix('admin');
		       $this->db->where('id',$from);
		       $get_project_messages= $this->db->get('admin');
			   $name_array= $get_project_messages->row_array();
			   
			  $get_project_messages_arr['project_messages_result'][$i]['user']= $name_array['first_name']." ".$name_array['last_name'];
			   
			
			}
		if($user_type=='c'){
			
		      $this->db->dbprefix('customers');
		      $this->db->where('id',$from);
		      $get_project_messages= $this->db->get('customers');
		      $name_array= $get_project_messages->row_array();
			  $get_project_messages_arr['project_messages_result'][$i]['user']= $name_array['first_name']." ".$name_array['last_name'];
			
			}
			
			
		}//End for
		
		
		return $get_project_messages_arr;	
		
	}//end get_project_messages
	
	
	
	public function get_messages_count(){
		
		$this->db->dbprefix('project_messages');
		$this->db->select('project_id, COUNT(status) as num_messages');
	    $this->db->where('user_type','c');
		$this->db->where('status',0);
		$this->db->group_by('project_id');
		$get_messages= $this->db->get('project_messages');
		$message_att_arr['message_arr'] = $get_messages->result_array();
		$message_att_arr['message_count'] = $get_messages->num_rows();
	//	echo $this->db->last_query(); exit;
		

		for($i=0; $i<$message_att_arr['message_count']; $i++){
			
			$project_id=$message_att_arr['message_arr'][$i]['project_id'];
			  
		      $this->db->dbprefix('projects');
		      $this->db->where('id',$project_id);
		      $get_project_messages= $this->db->get('projects');
		      $name_array= $get_project_messages->row_array();
			
			  $message_att_arr['message_arr'][$i]['project_title']= $name_array['project_title'];
			
			}
		
		return $message_att_arr;
		
	}//
	
	
	public function update_project_messages_count($project_id){
		
		
		$upd_data = array(
		    'status' => $this->db->escape_str(trim(1))
		);		
		$this->db->dbprefix('project_messages');
		$this->db->where('project_id',$project_id);
		$this->db->where('user_type','c');
		$get_messages= $this->db->update('project_messages',$upd_data);
	
		return true;
		
	}//
	
	
	//Project Assign
	public function project_assign($data){
		
		extract($data);
		
		$created_date = date('Y-m-d G:i:s');
		$created_by_ip = $this->input->ip_address();
		$created_by = $this->session->userdata('admin_id');
		
		
		$users= $this->mod_common->assign_project_users();
		 
		$assign=array_merge($users,$name);
		$new_project_assign=array_unique($assign);
		$fnl_project_assign= array_values($new_project_assign);
		
		$new_name=implode(',',$new_project_assign);
		 
		$update_data = array(
		    'project_assign' => $this->db->escape_str(trim($new_name))
		);		

		//Updating the record into the database.
		$this->db->dbprefix('projects');
		$this->db->where('id',$project_id);
		$upd_into_db = $this->db->update('projects', $update_data);
		
		
	    //Send Message to Assign Users
		//Get project record
		$this->db->dbprefix('projects');
		$this->db->where('id',$project_id);
		$get_data = $this->db->get('projects');
		$project_arr['project_arr'] = $get_data->row_array();
	
		for($j=0;$j<count($fnl_project_assign); $j++){
			
			//Mesage id Generator
		    $message_id = $this->mod_common->random_number_generator(7);
		    $message_id = $this->mod_projects->message_id_generator($message_id);
		 
			
			$subject='New Project Assigned : '.$project_arr['project_arr']['project_title'];;
			$message="Dear User, a new project is assigned to you. Please go to Project section to see more details. Thank  You!";
			$to_user = $fnl_project_assign[$j];
			
			 $ins_msg_data = array(
		    'to' => $this->db->escape_str(trim($to_user)),
		    'from' => $this->db->escape_str(trim($created_by)),
		    'subject' => $this->db->escape_str(trim($subject)),
			'message' => $this->db->escape_str(trim(nl2br($message))),
		    'message_id' => $this->db->escape_str(trim($message_id)),
		    'created_by' => $this->db->escape_str(trim($created_by)),
		    'date' => $this->db->escape_str(trim($created_date)),
		    'created_by_ip' => $this->db->escape_str(trim($created_by_ip))
		    );		

		   //Inserting the record into the database.
		  $this->db->dbprefix('messages');
		  $ins_into_db = $this->db->insert('messages', $ins_msg_data);
			
		}//End For////////// End Message to Assign Users		
		
	   return true;
		
	}//End Project Assign
	
	
	//Message id Generater.
	public function message_id_generator($message_id){

			$this->db->dbprefix('messages');
			$this->db->select('id');
			$this->db->where('message_id', $message_id); 
			$rs_count_rec = $this->db->get('messages');
		    $this->db->last_query();
			
			if($rs_count_rec->num_rows == 0) return $message_id;
			else{
				//Add Postfix and generate concatenate.
			return 	$generate_message_id = $this->mod_common->random_number_generator(7);
				
			}//end if
		
	}//end 
	
	
	
	//Get projects  Record
	public function get_projects_for_task(){
	
		$this->db->dbprefix('projects');
        $this->db->where('project_assign !=',"");
		$this->db->where('status !=',3);
		$get_projects= $this->db->get('projects');
		$row_projects_arr['projects_arr'] = $get_projects->result_array();
		$row_projects_arr['projects_count'] = $get_projects->num_rows();
		
		return $row_projects_arr;
		
	}//get_projects_for_task
	
	
	//Assign Task
  	public function assign_task($data){
		
	       extract($data);
		   
		   
		   $start_date = date("Y-m-d H:i:s", strtotime($start_date));
		   $end_date = date("Y-m-d H:i:s", strtotime($end_date));
		   
		  //  $newstartdate = date("Y-m-d h:i:s a", strtotime($startdate));
		   
		   $created_date = date('Y-m-d G:i:s');
		   $created_by_ip = $this->input->ip_address();
		   $created_by = $this->session->userdata('admin_id');
		   
			   
			$this->db->dbprefix('projects');
			$this->db->where('id',$project_id);
			$get_data = $this->db->get('projects');
			$users_arr['users_arr'] = $get_data->row_array();
			
		    $user_id= $users_arr['users_arr']['project_assign'];
			
		   $ins_data = array(
		    'user_id' => $this->db->escape_str(trim($user_id)),
		    'project_id' => $this->db->escape_str(trim($project_id)),
			'milestone' => $this->db->escape_str(trim($milestone)),			  
			'title' => $this->db->escape_str(trim($title)),
		    'start_date' => $this->db->escape_str(trim($start_date)),
			'end_date' => $this->db->escape_str(trim($end_date)),
		    'description' => $this->db->escape_str(trim(nl2br($description))),
		    'created_by' => $this->db->escape_str(trim($created_by)),
		    'created_date' => $this->db->escape_str(trim($created_date)),
		    'created_by_ip' => $this->db->escape_str(trim($created_by_ip))
		    );		

		   //Inserting the record into the database.
		  $this->db->dbprefix('project_task');
		  $ins_into_db = $this->db->insert('project_task', $ins_data);
		  $project_task_id= $this->db->insert_id();
		  
			
	      for($i=0; $i<count($_FILES['attachments']['name']); $i++)
		   {
			   
			 if($_FILES['attachments']['name'][$i] !=""){
				 	
		     $projects_folder_path = '../assets/project_attachments/'.$project_id;
			 
			 
			 if(!is_dir($projects_folder_path))
			 
			 mkdir($projects_folder_path,0777);
			 
			 $projects_task_folder_path = '../assets/project_attachments/'.$project_id.'/project_task';
			 
			  if(!is_dir($projects_task_folder_path))
			 
			  mkdir($projects_task_folder_path,0777);
			 
			  copy('../assets/img/index.html','../assets/project_attachments/'.$project_id.'/project_task'.'/index.html');
			
			 $attach_name[$i]=str_replace(' ','_',$_FILES['attachments']['name'][$i]);			
		     $attachment_name = "project_task_".$project_id.'_'.$attach_name[$i] ; 
		   
			 $ins_attachment = array(
			    'project_task_id' => $this->db->escape_str(trim($project_task_id)),
				'attachment_name' => $this->db->escape_str(trim($attachment_name)),
				'created_by' => $this->db->escape_str(trim($created_by)),
				'created_date' => $this->db->escape_str(trim($created_date)),
				'created_by_ip' => $this->db->escape_str(trim($created_by_ip))
			 );			
	
		
		   //Inserting the record into the database.
		   $this->db->dbprefix('project_task_attachments');
		   $ins_into_db = $this->db->insert('project_task_attachments', $ins_attachment);
		   
		   
		   $this->load->helper(array('form', 'url'));
			$config['upload_path'] = $projects_task_folder_path;
			$config['allowed_types'] = 'jpg|jpeg|gif|tiff|png|doc|docx|xls|xlsx|pdf|txt|zip|rar';
			$config['max_size']	= '60000';
			$config['overwrite'] = true;
	
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			$this->load->library('multipleupload',$config);

			$upload_epaper =  $this->multipleupload->do_multi_upload_project_task('attachments',TRUE,$project_id);
			//echo $this->db->last_query(); exit;
		 }//End if
		 
		}//End for loop
		
			
		//Send Message to Assign Task Users
		$this->db->dbprefix('projects');
		$this->db->where('id',$project_id);
		$get_data = $this->db->get('projects');
		$users_arr['users_arr'] = $get_data->row_array();
		
		$assign_to= $users_arr['users_arr']['project_assign'];
		$user_id= explode(',',$users_arr['users_arr']['project_assign']); 
		for($j=0;$j<count($user_id); $j++){
			
			//Mesage id Generator
		    $message_id = $this->mod_common->random_number_generator(7);
		    $message_id = $this->mod_projects->message_id_generator($message_id);
		 
			
			$subject='New Task is assign to you against Project : '.$users_arr['users_arr']['project_title'];
			
			$message="Dear User,<br><br> New Task is assigned to you against Project:" ."<strong> (<a href='".SURL."projects/manage-projects/project-detail/".$project_id."' title='Click for project detail'>".$users_arr['users_arr']['project_title']."</a>)</strong> ". " Please go to your task section to see more details or click the link below. Thank You! <br><br><a href='".SURL."projects/manage-projects/assign-task-detail/".$project_task_id."'>".SURL."projects/manage-projects/assign-task-detail/".$project_task_id."</a> ";
			$to_user = $user_id[$j];
			
			
			 $ins_msg_data = array(
		    'to' => $this->db->escape_str(trim($to_user)),
		    'from' => $this->db->escape_str(trim($created_by)),
		    'subject' => $this->db->escape_str(trim($subject)),
			'message' => $this->db->escape_str(trim($message)),
		    'message_id' => $this->db->escape_str(trim($message_id)),
		    'created_by' => $this->db->escape_str(trim($created_by)),
		    'date' => $this->db->escape_str(trim($created_date)),
		    'created_by_ip' => $this->db->escape_str(trim($created_by_ip))
		    );		

		   //Inserting the record into the database.
		  $this->db->dbprefix('messages');
		  $ins_into_db = $this->db->insert('messages', $ins_msg_data);
		  
			
		}//End For
		
		 $event_url=SURL."projects/manage-projects/assign-task-detail/".$project_task_id;
		
		  //Inset Data in Calender Table
		 $this->load->model('common/mod_common');
		
		 $this->mod_common->calendar('project task', $title, $description,$event_url,$start_date,$end_date, $project_task_id, $assign_to);
		
		   //Message To admin
		   
		  /* //Mesage id Generator
		    $message_id = $this->mod_common->random_number_generator(7);
		    $message_id = $this->mod_projects->message_id_generator($message_id);
		 
			
			$subject='New Task Added For Project : '.$users_arr['users_arr']['project_title'];
			$message="Hi Dear User This is your task.... Enjoy";
		
			 $ins_msg_data = array(
		    'to' => $this->db->escape_str(trim(1)),
		    'from' => $this->db->escape_str(trim($created_by)),
		    'subject' => $this->db->escape_str(trim($subject)),
			'message' => $this->db->escape_str(trim(nl2br($message))),
		    'message_id' => $this->db->escape_str(trim($message_id)),
		    'created_by' => $this->db->escape_str(trim($created_by)),
		    'date' => $this->db->escape_str(trim($created_date)),
		    'created_by_ip' => $this->db->escape_str(trim($created_by_ip))
		    );		

		   //Inserting the record into the database.
		  $this->db->dbprefix('messages');
		  $ins_into_db = $this->db->insert('messages', $ins_msg_data);
			*/
	
		
	     return true;
		
		
	}//end Assign Task
	
	
	 //Get projects  Record
	public function get_assign_task(){
		
		
		if($this->input->post('search_status')!=""){
			
		$this->db->dbprefix('project_task');
		$this->db->select('project_task.*,projects.project_title');
        $this->db->from('project_task');
		$this->db->where('project_task.status',$this->input->post('search_status'));
        $this->db->join('projects', 'project_task.project_id = projects.id');
		$this->db->order_by('project_task.id',DESC);
		$get_projects= $this->db->get();
			
			
			
		}else{
		
			
		$this->db->dbprefix('project_task');
		$this->db->select('project_task.*,projects.project_title');
        $this->db->from('project_task');
		$this->db->where('project_task.status',0);
		$this->db->or_where('project_task.status',1);
        $this->db->join('projects', 'project_task.project_id = projects.id');
		$this->db->order_by('project_task.id',DESC);
		$get_projects= $this->db->get();
		//echo $this->db->last_query();exit;
		}
		
		$row_assign_task_arr['assign_task_arr'] = $get_projects->result_array();
		$row_assign_task_arr['assign_task_count'] = $get_projects->num_rows();
		
		
		//////
		            $counter = 0 ; 	
					$h = 0 ;
					for($k=0;$k<$row_assign_task_arr['assign_task_count'];$k++){
					
						
					$explode_arr = explode(',',$row_assign_task_arr['assign_task_arr'][$k]['user_id']);
					
					$user_id=$this->session->userdata('admin_id');
						
							if(in_array($user_id,$explode_arr))
							
							{
								
				//	$row_projects['projects_filter'] = $row_projects['projects_arr'][$k] ; 
								
					$row_assign_task['assign_task_filter'][$h]['id'] = $row_assign_task_arr['assign_task_arr'][$k]['id'] ;
					$row_assign_task['assign_task_filter'][$h]['user_id'] = $row_assign_task_arr['assign_task_arr'][$k]['user_id'] ;
					$row_assign_task['assign_task_filter'][$h]['project_id'] = $row_assign_task_arr['assign_task_arr'][$k]['project_id'] ;
					$row_assign_task['assign_task_filter'][$h]['milestone'] = $row_assign_task_arr['assign_task_arr'][$k]['milestone'] ;
					$row_assign_task['assign_task_filter'][$h]['title'] = $row_assign_task_arr['assign_task_arr'][$k]['title'] ;
					$row_assign_task['assign_task_filter'][$h]['start_date'] = $row_assign_task_arr['assign_task_arr'][$k]['start_date'] ;
					$row_assign_task['assign_task_filter'][$h]['end_date'] = $row_assign_task_arr['assign_task_arr'][$k]['end_date'] ;
					$row_assign_task['assign_task_filter'][$h]['description'] =$row_assign_task_arr['assign_task_arr'][$k]['description'] ;
					$row_assign_task['assign_task_filter'][$h]['status'] =$row_assign_task_arr['assign_task_arr'][$k]['status'] ;	
					
					$row_assign_task['assign_task_filter'][$h]['created_by'] = $row_assign_task_arr['assign_task_arr'][$k]['created_by'] ;
					$row_assign_task['assign_task_filter'][$h]['created_date'] =$row_assign_task_arr['assign_task_arr'][$k]['created_date'] ;
					$row_assign_task['assign_task_filter'][$h]['created_by_ip'] =$row_assign_task_arr['assign_task_arr'][$k]['created_by_ip'] ;
					$row_assign_task['assign_task_filter'][$h]['last_modified_by'] = $row_assign_task_arr['assign_task_arr'][$k]['last_modified_by'] ;
					$row_assign_task['assign_task_filter'][$h]['last_modified_date'] = $row_assign_task_arr['assign_task_arr'][$k]['last_modified_date'] ;
					$row_assign_task['assign_task_filter'][$h]['last_modified_ip'] = $row_assign_task_arr['assign_task_arr'][$k]['last_modified_ip'] ;
					$row_assign_task['assign_task_filter'][$h]['project_title'] = $row_assign_task_arr['assign_task_arr'][$k]['project_title'] ;
					
						        $h++;
								$counter  = $counter + 1 ;   
								
							//echo "<pre>"; print_r($row_projects['projects_filter']); exit; 	
							}
			}
			
		$row_assign_task['assign_task_count'] = $counter ;
		
			
		/*	
		echo "<pre>";
		print_r($row_assign_task['assign_task_filter']);
		exit;*/
		
		return $row_assign_task;
		
	}//end Project Records
  
    
	
	public function get_assign_task_detail($assign_task_id){
		
	
		$this->db->dbprefix('project_task');
		$this->db->where('id',$assign_task_id);
		$get_assign_projects_detail= $this->db->get('project_task');
        //echo $this->db->last_query();
		$assign_task_arr['assign_task_result'] = $get_assign_projects_detail->row_array();
		
		$project_id= $assign_task_arr['assign_task_result']['project_id'];
		$this->db->dbprefix('projects');
		$this->db->select('project_title');
		$this->db->where('id',$project_id);
		$get_project= $this->db->get('projects');
		$project_arr['project_result'] = $get_project->row_array();
		$assign_task_arr['assign_task_result']['project_title']=$project_arr['project_result']['project_title'];
		
		//Get Project Attachments
		$this->db->dbprefix('project_task_attachments');
		$this->db->where('project_task_id',$assign_task_id);
		$get_assign_task_attachments= $this->db->get('project_task_attachments');
		
		$assign_task_arr['assign_task_attachments'] = $get_assign_task_attachments->result_array();
		$assign_task_arr['assign_task_attachments_count'] = $get_assign_task_attachments->num_rows;
		
	
		return $assign_task_arr;		
		
	}//end get_project_details
	
	
	
	//Edit Assign Task
  	public function edit_assign_task($data){
		
	       extract($data);
		   
		   $start_date = date("Y-m-d H:i:s", strtotime($start_date));
		   
		   $end_date = date("Y-m-d H:i:s", strtotime($end_date));
		   
		
	
		   $last_modified_date = date('Y-m-d G:i:s');
		   $last_modified_ip = $this->input->ip_address();
		   $last_modified_by = $this->session->userdata('admin_id');
		  
		   $upd_data = array(
		    'project_id' => $this->db->escape_str(trim($project_id)),
			'milestone' => $this->db->escape_str(trim($milestone)),			  
			'title' => $this->db->escape_str(trim($title)),
		    'start_date' => $this->db->escape_str(trim($start_date)),
			'end_date' => $this->db->escape_str(trim($end_date)),
		    'description' => $this->db->escape_str(trim(nl2br($description))),
		    'status' => $this->db->escape_str(trim(nl2br($status))),
		    'last_modified_by' => $this->db->escape_str(trim($last_modified_by)),
		    'last_modified_date' => $this->db->escape_str(trim($last_modified_date)),
		    'last_modified_ip' => $this->db->escape_str(trim($last_modified_ip))
		    );		

		   //Inserting the record into the database.
		  $this->db->dbprefix('project_task');
		  $this->db->where('id',$assign_task_id);
		  $ins_into_db = $this->db->update('project_task', $upd_data);
		
			
	      for($i=0; $i<count($_FILES['attachments']['name']); $i++)
		   {
			   
			 if($_FILES['attachments']['name'][$i] !=""){
				 	
		     $projects_folder_path = '../assets/project_attachments/'.$project_id;
			 
			 
			 if(!is_dir($projects_folder_path))
			 
			 mkdir($projects_folder_path,0777);
			 
			 $projects_task_folder_path = '../assets/project_attachments/'.$project_id.'/project_task';
			 
			  if(!is_dir($projects_task_folder_path))
			 
			  mkdir($projects_task_folder_path,0777);
			 
			  copy('../assets/img/index.html','../assets/project_attachments/'.$project_id.'/project_task'.'/index.html');
				
			 $attach_name[$i]=str_replace(' ','_',$_FILES['attachments']['name'][$i]);			
		     $attachment_name = "project_task_".$project_id.'_'.$attach_name[$i] ; 
		   
			 $ins_attachment = array(
			    'project_task_id' => $this->db->escape_str(trim($assign_task_id)),
				'attachment_name' => $this->db->escape_str(trim($attachment_name)),
				'created_by' => $this->db->escape_str(trim($created_by)),
				'created_date' => $this->db->escape_str(trim($created_date)),
				'created_by_ip' => $this->db->escape_str(trim($created_by_ip))
			 );			
	
		
		   //Inserting the record into the database.
		   $this->db->dbprefix('project_task_attachments');
		   $ins_into_db = $this->db->insert('project_task_attachments', $ins_attachment);
		 }//End if
		 
		}//End for loop
		
	
			$this->load->helper(array('form', 'url'));
			$config['upload_path'] = $projects_task_folder_path;
			$config['allowed_types'] = 'jpg|jpeg|gif|tiff|png|doc|docx|xls|xlsx|pdf|txt|zip|rar';
			$config['max_size']	= '60000';
			$config['overwrite'] = true;
	
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			$this->load->library('multipleupload',$config);

			$upload_epaper =  $this->multipleupload->do_multi_upload_project_task('attachments',TRUE,$project_id);
			//echo $this->db->last_query(); exit;
		
			 
		   $event_url=SURL."projects/manage-projects/assign-task-detail/".$assign_task_id;
		
			$this->db->dbprefix('projects');
			$this->db->where('id',$project_id);
			$get_data = $this->db->get('projects');
			$users_arr['users_arr'] = $get_data->row_array();
			
			$assign_to= $users_arr['users_arr']['project_assign'];
		
		
		  //Inset Data in Calender Table
		 $this->load->model('common/mod_common');
		 $this->mod_common->edit_calendar('project task', $title, $description,$event_url,$start_date, $end_date, $assign_task_id, $assign_to);
		
	     return true;
		
		
	}//end Edit Assign Task
	
	
	//Delete assign_task_attachment
	public function delete_assign_task_attachment($task_attachment_id,$task_id){
		
		//Get Record
		$this->db->dbprefix('project_task_attachments');
		$this->db->where('id',$task_attachment_id);
		$get_record = $this->db->get('project_task_attachments');
		$get_attachment_arr= $get_record->row_array();
		
		//Get Project ID
		$this->db->dbprefix('project_task');
		$this->db->where('id',$task_id);
		$get= $this->db->get('project_task');
		$get_arr= $get->row_array();
		$project_id=$get_arr['project_id'];
		
		$attachment_name=$get_attachment_arr['attachment_name'];
		
		
		$projects_folder_path = '../assets/project_attachments/'.$project_id."/project_task";
		
		//Delete Existing Image
		if(file_exists($projects_folder_path.'/'.$attachment_name)){
			
			unlink($projects_folder_path.'/'.$attachment_name);
			
		}//end if
		
		
		//Delete the record from the database.
		$this->db->dbprefix('project_task_attachments');
		$this->db->where('id',$task_attachment_id);
		$del_into_db = $this->db->delete('project_task_attachments');
		//$this->db->last_query();
		
		if($del_into_db) return true;

	}//end
	
	
	//Delete assign_task_attachment
	public function delete_assign_task($task_id){
		
		//Get Record
		$this->db->dbprefix('project_task');
		$this->db->where('id',$task_id);
		$get= $this->db->get('project_task');
		$get_arr= $get->row_array();
		$project_id=$get_arr['project_id'];
		
		
		//Get Record
		$this->db->dbprefix('project_task_attachments');
		$this->db->where('project_task_id',$task_id);
		$get_record = $this->db->get('project_task_attachments');
		$get_attachment_arr= $get_record->result_array();
		$get_attachment_count= $get_record->num_rows();
		
	    $projects_folder_path = '../assets/project_attachments/'.$project_id."/project_task";
		
		$this->mod_common->remove_directory($projects_folder_path,true);
			
		
		/*for($i=0;$i<$get_attachment_count; $i++){
		
		   $attachment_name=$get_attachment_arr[$i]['attachment_name'];
		
			//Delete Existing Image
			if(file_exists($projects_folder_path.'/'.$attachment_name)){
				
				unlink($projects_folder_path.'/'.$attachment_name);
				
			}//end if
		
		}//End For
		
		
		 //Remove Project folder
		 rmdir($projects_folder_path);*/
		 
		 
		 //Delete the record from the database.
		$this->db->dbprefix('project_task');
		$this->db->where('id',$task_id);
		$del_into_db = $this->db->delete('project_task');
		
		//Delete the record from the database.
		$this->db->dbprefix('project_task_attachments');
		$this->db->where('project_task_id',$task_id);
		$del_into_db = $this->db->delete('project_task_attachments');
		
		
		//Delete the record from the database.
		$this->db->dbprefix('calendar');
		$this->db->where('event_id',$task_id);
		$del_into_db = $this->db->delete('calendar');
		
		if($del_into_db) return true;

	}//end
	
	
	//Update_task_status 
	public function update_task_status($status,$assign_task_id){
		
		$created_date = date('Y-m-d G:i:s');
		$created_by_ip = $this->input->ip_address();
		$created_by = $this->session->userdata('admin_id');
		
		 $upd_data = array(
			    'status' => $this->db->escape_str(trim($status))
			 );		
		
	
		//Update Record
		$this->db->dbprefix('project_task');
		$this->db->where('id',$assign_task_id);
		$get= $this->db->update('project_task',$upd_data);
		
		
	  if($status=='1')	
	  {	
	  
	  //Send Message to Assign Task Users
		 $this->db->dbprefix('project_task');
	    $this->db->where('id',$assign_task_id);
	    $get= $this->db->get('project_task');
	    $get_arr= $get->row_array();
	    $project_id=$get_arr['project_id'];
		
		//Get project record
		$this->db->dbprefix('projects');
	    $this->db->where('id',$project_id);
	    $get_project_arr= $this->db->get('projects');
	    $get_project= $get_project_arr->row_array();
	    $project_name=$get_project['project_title'];
		
		$assign_to=$get_arr['user_id'];
		
		$user_id= explode(',',$assign_to); 
		
		for($j=0;$j<count($user_id); $j++){
			
			
			//Mesage id Generator
		    $message_id = $this->mod_common->random_number_generator(7);
		    $message_id = $this->mod_projects->message_id_generator($message_id);
		 
			
			$subject='Project Task Started For Project : '.$project_name;
			$message="Project Task Has been Started. Thank You!";
			$to_user = $user_id[$j];
			
			
			 $ins_msg_data = array(
		    'to' => $this->db->escape_str(trim($user_id[$j])),
		    'from' => $this->db->escape_str(trim($created_by)),
		    'subject' => $this->db->escape_str(trim($subject)),
			'message' => $this->db->escape_str(trim($message)),
		    'message_id' => $this->db->escape_str(trim($message_id)),
		    'created_by' => $this->db->escape_str(trim($created_by)),
		    'date' => $this->db->escape_str(trim($created_date)),
		    'created_by_ip' => $this->db->escape_str(trim($created_by_ip))
		    );		

		   //Inserting the record into the database.
		  $this->db->dbprefix('messages');
		  $ins_into_db = $this->db->insert('messages', $ins_msg_data);
		  
			
		}//End For
	  
	  
	   //Send Message to Project Detail Message Board::
	    $this->db->dbprefix('project_task');
	    $this->db->where('id',$assign_task_id);
	    $get= $this->db->get('project_task');
	    $get_arr= $get->row_array();
	    $project_id=$get_arr['project_id'];
		
		//Get project record
		$this->db->dbprefix('projects');
	    $this->db->where('id',$project_id);
	    $get= $this->db->get('projects');
	    $get_arr= $get->row_array();
	    $customer_id=$get_arr['customer_id'];
		
		$message="Project Task has Been Started...!!";
		$insrt_data = array(
		    'project_id' => $this->db->escape_str(trim($project_id)),
		    'to' => $this->db->escape_str(trim($customer_id)),
			'from' => $this->db->escape_str(trim($created_by)),
			'message' => $this->db->escape_str(trim(nl2br($message))),
			'user_type' => $this->db->escape_str('u'),
			'created_by' => $this->db->escape_str(trim($created_by)),
		    'created_date' => $this->db->escape_str(trim($created_date)),
		    'created_by_ip' => $this->db->escape_str(trim($created_by_ip))
		);		

		//inserting the record into the database.
		$this->db->dbprefix('project_messages');
		$upd_into_db = $this->db->insert('project_messages', $insrt_data);
	  }//end if project status is 1.
	  
	   if($status=='2')	
	  {	
	  
	   $reason= $this->input->post('hold_reason');
	 
	  
	  //Send Message to Assign Task Users
		 $this->db->dbprefix('project_task');
	    $this->db->where('id',$assign_task_id);
	    $get= $this->db->get('project_task');
	    $get_arr= $get->row_array();
	    $project_id=$get_arr['project_id'];
		
		//Get project record
		$this->db->dbprefix('projects');
	    $this->db->where('id',$project_id);
	    $get_project_arr= $this->db->get('projects');
	    $get_project= $get_project_arr->row_array();
	    $project_name=$get_project['project_title'];
		
		$assign_to=$get_arr['user_id'];
		
		$user_id= explode(',',$assign_to); 
		
		for($j=0;$j<count($user_id); $j++){
			
			
			//Mesage id Generator
		    $message_id = $this->mod_common->random_number_generator(7);
		    $message_id = $this->mod_projects->message_id_generator($message_id);
		 
			
			$subject='Task Hold For Project : '.$project_name;
			$message="Project Task Has been Hold for Reason ".$reason. ". Thank You!";
			
			 $ins_msg_data = array(
		    'to' => $this->db->escape_str(trim($user_id[$j])),
		    'from' => $this->db->escape_str(trim($created_by)),
		    'subject' => $this->db->escape_str(trim($subject)),
			'message' => $this->db->escape_str(trim($message)),
		    'message_id' => $this->db->escape_str(trim($message_id)),
		    'created_by' => $this->db->escape_str(trim($created_by)),
		    'date' => $this->db->escape_str(trim($created_date)),
		    'created_by_ip' => $this->db->escape_str(trim($created_by_ip))
		    );		

		   //Inserting the record into the database.
		  $this->db->dbprefix('messages');
		  $ins_into_db = $this->db->insert('messages', $ins_msg_data);
		  
			
		}//End For
	  
	  }//end if project status is 2
	  
	  if($status=='3')	
	  {	
	  
	  //Send Message to Assign Task Users
		 $this->db->dbprefix('project_task');
	    $this->db->where('id',$assign_task_id);
	    $get= $this->db->get('project_task');
	    $get_arr= $get->row_array();
	    $project_id=$get_arr['project_id'];
		
		//Get project record
		$this->db->dbprefix('projects');
	    $this->db->where('id',$project_id);
	    $get_project_arr= $this->db->get('projects');
	    $get_project= $get_project_arr->row_array();
	    $project_name=$get_project['project_title'];
		
		$assign_to=$get_arr['user_id'];
		
		$user_id= explode(',',$assign_to); 
		
		for($j=0;$j<count($user_id); $j++){
			
			
			//Mesage id Generator
		    $message_id = $this->mod_common->random_number_generator(7);
		    $message_id = $this->mod_projects->message_id_generator($message_id);
		 
			
			$subject='Task Closed For Project : '.$project_name;
			$message="Project Task Has been Closed... Thank You!";
			
			 $ins_msg_data = array(
		    'to' => $this->db->escape_str(trim($user_id[$j])),
		    'from' => $this->db->escape_str(trim($created_by)),
		    'subject' => $this->db->escape_str(trim($subject)),
			'message' => $this->db->escape_str(trim($message)),
		    'message_id' => $this->db->escape_str(trim($message_id)),
		    'created_by' => $this->db->escape_str(trim($created_by)),
		    'date' => $this->db->escape_str(trim($created_date)),
		    'created_by_ip' => $this->db->escape_str(trim($created_by_ip))
		    );		

		   //Inserting the record into the database.
		  $this->db->dbprefix('messages');
		  $ins_into_db = $this->db->insert('messages', $ins_msg_data);
		  
			
		}//End For
	  
	  }//end if project status is 1.
	  
		return true;
		
	}//Update_task_status
	
	
	//Update_task_status 
	public function get_calendar(){
	
		//Get Record
		$this->db->dbprefix('calendar');
	    $this->db->where('event_type',"project task");
		//$this->db->where('',"project task");
		$get= $this->db->get('calendar');
		$get_calendar_arr['calender_arr']= $get->result_array();
		$get_calendar_arr['calendar_count']= $get->num_rows();
		
			$counter = 0 ; 	
			$h = 0 ;
			for($k=0;$k<$get_calendar_arr['calendar_count'];$k++){
						
					$explode_arr = explode(',',$get_calendar_arr['calender_arr'][$k]['assign_to']);
					
					$user_id=$this->session->userdata('admin_id');
						
							if(in_array($user_id,$explode_arr))
							
							{
								
				//	$row_projects['projects_filter'] = $row_projects['projects_arr'][$k] ; 
								
					$get_calendar['calender_arr'][$h]['id'] = $get_calendar_arr['calender_arr'][$k]['id'] ;
					$get_calendar['calender_arr'][$h]['event_type'] = $get_calendar_arr['calender_arr'][$k]['event_type'] ;
					$get_calendar['calender_arr'][$h]['event_title'] = $get_calendar_arr['calender_arr'][$k]['event_title'] ;
					$get_calendar['calender_arr'][$h]['event_description'] = $get_calendar_arr['calender_arr'][$k]['event_description'] ;
					$get_calendar['calender_arr'][$h]['event_url'] = $get_calendar_arr['calender_arr'][$k]['event_url'] ;
					$get_calendar['calender_arr'][$h]['event_start_date'] = $get_calendar_arr['calender_arr'][$k]['event_start_date'] ;
					$get_calendar['calender_arr'][$h]['event_end_date'] = $get_calendar_arr['calender_arr'][$k]['event_end_date'] ;
					$get_calendar['calender_arr'][$h]['event_id'] = $get_calendar_arr['calender_arr'][$k]['event_id'] ;
					
					
						        $h++;
								$counter  = $counter + 1 ;   
								
							//echo "<pre>"; print_r($row_projects['projects_filter']); exit; 	
							}
							
			}
		
		$get_calendar['calendar_count']=$counter;
		/*echo "<pre>";
		print_r($get_calendar);
		exit;*/
		
		return $get_calendar;
		
	}//Update_task_status
	
	
	//Project action 
	public function project_action($data){
		
		extract($data);
		
		
		$upd_data = array(
			    'status' => $this->db->escape_str(trim($status)),
				'feedback' => $this->db->escape_str(trim($feedback))
			 );		
		
		//Update Record
		$this->db->dbprefix('projects');
		$this->db->where('id',$project_id);
		$get= $this->db->update('projects',$upd_data);
		
		
		return true;
	}//End Project_action
	
	
	public function get_project_tasks($project_id){
		
	
		$this->db->dbprefix('project_task');
		$this->db->where('project_id',$project_id);
		$get_tasks= $this->db->get('project_task');
        //echo $this->db->last_query();
		//$project_task_arr['project_task_result'] = $get_tasks->result_array();
		$project_task_count= $get_tasks->num_rows();
		
		$this->db->where('project_id',$project_id);
		$this->db->where('status',1);
		$get_open_task= $this->db->get('project_task');
        //echo $this->db->last_query();
		$get_open_task_count= $get_open_task->num_rows();
		
		$this->db->where('project_id',$project_id);
		$this->db->where('status',2);
		$get_hold_task= $this->db->get('project_task');
        //echo $this->db->last_query();
		$get_hold_task_count= $get_hold_task->num_rows();
		
		$this->db->where('project_id',$project_id);
		$this->db->where('status',3);
		$get_closed_task= $this->db->get('project_task');
        //echo $this->db->last_query();
		$get_closed_task_count= $get_closed_task->num_rows();
		
		
		 $project_task_arr['total_task']=$project_task_count;
		 $project_task_arr['open_task']=$get_open_task_count;
		 $project_task_arr['hold_task']=$get_hold_task_count;
		 $project_task_arr['closed_task']=$get_closed_task_count;
		 
		
		 $where="(status=0 or status=1)";
		 
		 $this->db->dbprefix('project_task');
		 $this->db->where('project_id',$project_id);
		 $this->db->where($where);
		 $this->db->order_by('id',DESC);
		 $this->db->limit(10);
		 $get_project_task_arr= $this->db->get('project_task');
         //echo $this->db->last_query();exit;
		 $project_task_arr['project_task_result'] = $get_project_task_arr->result_array();
		
		/*echo "<pre>";
		print_r( $project_task_arr['project_task_result']);
		exit;*/
		
	
		return $project_task_arr;		
		
	}//end get_project_tasks
	
	
	public function get_user_task($user_id,$status){
		
		
		if($status!=0){
			
			
		$this->db->dbprefix('project_task');
		$this->db->select('project_task.*,projects.project_title');
        $this->db->from('project_task');
		$this->db->where('project_task.status',$status);
        $this->db->join('projects', 'project_task.project_id = projects.id');
		$this->db->order_by('project_task.id',DESC);
		$get_projects= $this->db->get();
		//echo $this->db->last_query();
		
		$row_assign_task_arr['assign_task_arr'] = $get_projects->result_array();
		$row_assign_task_arr['assign_task_count'] = $get_projects->num_rows();
		
		//echo "<pre>"; print_r($row_assign_task_arr['assign_task_arr']); exit; 	
		
		//////
		            $counter = 0 ; 	
					$h = 0 ;
					for($k=0;$k<$row_assign_task_arr['assign_task_count'];$k++){
					
						
					$explode_arr = explode(',',$row_assign_task_arr['assign_task_arr'][$k]['user_id']);
					
						
					if(in_array($user_id,$explode_arr))
					
					{
						
						
						
								
				//	$row_projects['projects_filter'] = $row_projects['projects_arr'][$k] ; 
								
					$row_assign_task['assign_task_filter'][$h]['id'] = $row_assign_task_arr['assign_task_arr'][$k]['id'] ;
					$row_assign_task['assign_task_filter'][$h]['user_id'] = $row_assign_task_arr['assign_task_arr'][$k]['user_id'] ;
					$row_assign_task['assign_task_filter'][$h]['project_id'] = $row_assign_task_arr['assign_task_arr'][$k]['project_id'] ;
					$row_assign_task['assign_task_filter'][$h]['milestone'] = $row_assign_task_arr['assign_task_arr'][$k]['milestone'] ;
					$row_assign_task['assign_task_filter'][$h]['title'] = $row_assign_task_arr['assign_task_arr'][$k]['title'] ;
					$row_assign_task['assign_task_filter'][$h]['start_date'] = $row_assign_task_arr['assign_task_arr'][$k]['start_date'] ;
					$row_assign_task['assign_task_filter'][$h]['end_date'] = $row_assign_task_arr['assign_task_arr'][$k]['end_date'] ;
					$row_assign_task['assign_task_filter'][$h]['description'] =$row_assign_task_arr['assign_task_arr'][$k]['description'] ;
					$row_assign_task['assign_task_filter'][$h]['status'] =$row_assign_task_arr['assign_task_arr'][$k]['status'] ;	
					
					$row_assign_task['assign_task_filter'][$h]['created_by'] = $row_assign_task_arr['assign_task_arr'][$k]['created_by'] ;
					$row_assign_task['assign_task_filter'][$h]['created_date'] =$row_assign_task_arr['assign_task_arr'][$k]['created_date'] ;
					$row_assign_task['assign_task_filter'][$h]['created_by_ip'] =$row_assign_task_arr['assign_task_arr'][$k]['created_by_ip'] ;
					$row_assign_task['assign_task_filter'][$h]['last_modified_by'] = $row_assign_task_arr['assign_task_arr'][$k]['last_modified_by'] ;
					$row_assign_task['assign_task_filter'][$h]['last_modified_date'] = $row_assign_task_arr['assign_task_arr'][$k]['last_modified_date'] ;
					$row_assign_task['assign_task_filter'][$h]['last_modified_ip'] = $row_assign_task_arr['assign_task_arr'][$k]['last_modified_ip'] ;
					$row_assign_task['assign_task_filter'][$h]['project_title'] = $row_assign_task_arr['assign_task_arr'][$k]['project_title'] ;
					
						        $h++;
								$counter  = $counter + 1 ;   
								
							//echo "<pre>"; print_r($row_projects['projects_filter']); exit; 	
							}
			}
			
		$row_assign_task['assign_task_count'] = $counter ; 	
		
			
		
			
		}else{
		
		$this->db->dbprefix('project_task');
		$this->db->select('project_task.*,projects.project_title');
        $this->db->from('project_task');
        $this->db->join('projects', 'project_task.project_id = projects.id');
		$this->db->order_by('project_task.id',DESC);
		$get_projects= $this->db->get();
		//echo $this->db->last_query();
		
		$row_assign_task_arr['assign_task_arr'] = $get_projects->result_array();
		$row_assign_task_arr['assign_task_count'] = $get_projects->num_rows();
		
		//////
		            $counter = 0 ; 	
					$h = 0 ;
					for($k=0;$k<$row_assign_task_arr['assign_task_count'];$k++){
					
						
					$explode_arr = explode(',',$row_assign_task_arr['assign_task_arr'][$k]['user_id']);
					
						
							if(in_array($user_id,$explode_arr))
							
							{
								
				//	$row_projects['projects_filter'] = $row_projects['projects_arr'][$k] ; 
								
					$row_assign_task['assign_task_filter'][$h]['id'] = $row_assign_task_arr['assign_task_arr'][$k]['id'] ;
					$row_assign_task['assign_task_filter'][$h]['user_id'] = $row_assign_task_arr['assign_task_arr'][$k]['user_id'] ;
					$row_assign_task['assign_task_filter'][$h]['project_id'] = $row_assign_task_arr['assign_task_arr'][$k]['project_id'] ;
					$row_assign_task['assign_task_filter'][$h]['milestone'] = $row_assign_task_arr['assign_task_arr'][$k]['milestone'] ;
					$row_assign_task['assign_task_filter'][$h]['title'] = $row_assign_task_arr['assign_task_arr'][$k]['title'] ;
					$row_assign_task['assign_task_filter'][$h]['start_date'] = $row_assign_task_arr['assign_task_arr'][$k]['start_date'] ;
					$row_assign_task['assign_task_filter'][$h]['end_date'] = $row_assign_task_arr['assign_task_arr'][$k]['end_date'] ;
					$row_assign_task['assign_task_filter'][$h]['description'] =$row_assign_task_arr['assign_task_arr'][$k]['description'] ;
					$row_assign_task['assign_task_filter'][$h]['status'] =$row_assign_task_arr['assign_task_arr'][$k]['status'] ;	
					
					$row_assign_task['assign_task_filter'][$h]['created_by'] = $row_assign_task_arr['assign_task_arr'][$k]['created_by'] ;
					$row_assign_task['assign_task_filter'][$h]['created_date'] =$row_assign_task_arr['assign_task_arr'][$k]['created_date'] ;
					$row_assign_task['assign_task_filter'][$h]['created_by_ip'] =$row_assign_task_arr['assign_task_arr'][$k]['created_by_ip'] ;
					$row_assign_task['assign_task_filter'][$h]['last_modified_by'] = $row_assign_task_arr['assign_task_arr'][$k]['last_modified_by'] ;
					$row_assign_task['assign_task_filter'][$h]['last_modified_date'] = $row_assign_task_arr['assign_task_arr'][$k]['last_modified_date'] ;
					$row_assign_task['assign_task_filter'][$h]['last_modified_ip'] = $row_assign_task_arr['assign_task_arr'][$k]['last_modified_ip'] ;
					$row_assign_task['assign_task_filter'][$h]['project_title'] = $row_assign_task_arr['assign_task_arr'][$k]['project_title'] ;
					
						        $h++;
								$counter  = $counter + 1 ;   
								
							//echo "<pre>"; print_r($row_projects['projects_filter']); exit; 	
							}
			}
			
		$row_assign_task['assign_task_count'] = $counter ; 	
		}
	
		
		/*echo "<pre>";
		print_r( $row_assign_task);
		exit;*/
		
	
		return $row_assign_task;		
		
	}//end get_user_task
	
	
	
	
	public function get_project_task($project_id,$status){
		
		
		if($status!=0){
			
		$this->db->dbprefix('project_task');
		$this->db->select('project_task.*,projects.project_title');
        $this->db->from('project_task');
		$this->db->where('project_task.status',$status);
		$this->db->where('project_task.project_id',$project_id);
        $this->db->join('projects', 'project_task.project_id = projects.id');
		$this->db->order_by('project_task.id',DESC);
		$get_project_task= $this->db->get();
		//echo $this->db->last_query();
		
		}else{
		
		$this->db->dbprefix('project_task');
		$this->db->select('project_task.*,projects.project_title');
        $this->db->from('project_task');
		$this->db->where('project_task.project_id',$project_id);
        $this->db->join('projects', 'project_task.project_id = projects.id');
		$this->db->order_by('project_task.id',DESC);
		$get_project_task= $this->db->get();
		//echo $this->db->last_query();
		
		}
		
		$row_project_task_arr['project_task_arr'] = $get_project_task->result_array();
		$row_project_task_arr['project_task_count'] = $get_project_task->num_rows();
		  
		
		/*echo "<pre>";
		print_r( $row_assign_task_arr['assign_task_arr']);
		exit;*/
		
	
		return $row_project_task_arr;		
		
	}//end get_project_task
	
	
	//Filter Grid for Manage Projects
	public function get_filter_projects_grid_data(){
		
		  $user_id=$this->session->userdata('admin_id');
		
		/* Array of database columns which should be read and sent back to DataTables. Use a space where
		* you want to insert a non-database field (for example a counter or static image)
		*/
        $aColumns = array('project_title','customer_id','start_date','end_date','branch_id','project_assign','status','id');
        
        // DB table to use
        $sTable = 'projects';
		$this->db->order_by('id', DESC);
        //
    
        $iDisplayStart = $this->input->get_post('iDisplayStart', true);
        $iDisplayLength = $this->input->get_post('iDisplayLength', true);
        $iSortCol_0 = $this->input->get_post('iSortCol_0', true);
        $iSortingCols = $this->input->get_post('iSortingCols', true);
        $sSearch = $this->input->get_post('sSearch', true);
        $sEcho = $this->input->get_post('sEcho', true);
    
        // Paging
        if(isset($iDisplayStart) && $iDisplayLength != '-1')
        {
            $this->db->limit($this->db->escape_str($iDisplayLength), $this->db->escape_str($iDisplayStart));
        }
        
        // Ordering
        if(isset($iSortCol_0))
        {
            for($i=0; $i<intval($iSortingCols); $i++)
            {
                $iSortCol = $this->input->get_post('iSortCol_'.$i, true);
                $bSortable = $this->input->get_post('bSortable_'.intval($iSortCol), true);
                $sSortDir = $this->input->get_post('sSortDir_'.$i, true);
    
                if($bSortable == 'true')
                {
                    $this->db->order_by($aColumns[intval($this->db->escape_str($iSortCol))], $this->db->escape_str($sSortDir));
                }
            }
        }
        
				/*
		* Filtering
		* NOTE this does not match the built-in DataTables filtering which does it
		* word by word on any field. It's possible to do here, but concerned about efficiency
		* on very large tables, and MySQL's regex functionality is very limited
		*/
        if(isset($sSearch) && !empty($sSearch))
        {
            for($i=0; $i<count($aColumns); $i++)
            {
                $bSearchable = $this->input->get_post('bSearchable_'.$i, true);
                
                // Individual column filtering
                if(isset($bSearchable) && $bSearchable == 'true')
                {
                    $this->db->or_like($aColumns[$i], $sSearch);
                }
            }
        }


        // Select Data
        $this->db->select('SQL_CALC_FOUND_ROWS '.str_replace(' , ', ' ', implode(', ', $aColumns)), false);
		$this->db->dbprefix($sTable);
        $rResult = $this->db->get($sTable);
        //echo $this->db->last_query(); exit;
        // Data set length after filtering
		$this->db->dbprefix($sTable);
        $this->db->select('FOUND_ROWS() AS found_rows');
        $iFilteredTotal = $this->db->get()->row()->found_rows;
    
        // Total data set length
        $iTotal = $this->db->count_all($sTable);

    
        // Output
        $output = array(
            'sEcho' => intval($sEcho),
            'iTotalRecords' => $iTotal,
            'iTotalDisplayRecords' => $iFilteredTotal,
            'aaData' => array()
        );
        foreach($rResult->result_array() as $aRow){
            $row = array();
            $option_html = '';
			
			
			//echo "<pre>";
			//print_r($aColumns);
			//exit;
            foreach($aColumns as $col)
            {
			
			  
			 $explode_arr = explode(',', $aRow['project_assign']);
	        if(in_array($user_id,$explode_arr))
							
			{
				
				if($col == 'project_title'){
					 
					 $row[] = $aRow['project_title'];
					
				}
				elseif($col == 'start_date'){
					 $row[] = date('d, M Y h:i:s a', strtotime($aRow['start_date']));
					
				}
				elseif($col == 'end_date'){
					$row[] = date('d, M Y h:i:s a', strtotime(stripslashes($aRow['end_date'])));
					
				}elseif($col == 'status'){
					
					$row[] = ($aRow[$col] == 1) ? '<span class="label btn-success">Active</span>' : '<span class="label btn-danger">InActive</span>';

				}elseif($col == 'id'){
					$option_html .= '<div class="btn-group">';
					if(in_array(62,$this->session->userdata('permissions_arr'))){ 
						$option_html .= "<a href=".SURL."customers/manage-customers/edit-customer/".$aRow['id']." type='button' class='btn btn-info btn-gradient'> <span class='glyphicons glyphicons-edit'></span> </a>";
					}//end if
					
					if(in_array(63,$this->session->userdata('permissions_arr'))){ 
						$option_html .= "<a href=".SURL."customers/manage-customers/delete-customer/".$aRow['id']." type='button' class='btn btn-danger btn-gradient' onClick=\"return confirm('Are you sure you want to delete?')\"> <span class='glyphicons glyphicons-remove'></span> </a>";
					}//end if
					
					 $option_html .= '</div>';
					$row[] = $option_html;
					$row[] = 'kjk';
					
				}
				else
				$row[] = $aRow[$col];
            }
    
            $output['aaData'][] = $row;
        }//End if
		
		}//End for

		
        echo json_encode($output);
    }//end get_filter_projects_grid_data
	
}
?>