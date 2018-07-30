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



    //get_project_milestones
	public function get_project_milestones($project_id){
		
		$this->db->dbprefix('project_milestones');
		$this->db->where('project_id', $project_id);
		$get_project_milestones = $this->db->get('project_milestones');

		//echo $this->db->last_query();
		$row_project_milestones['project_milestones_arr'] = $get_project_milestones->result_array();
		$row_project_milestones['project_milestones_count'] = $get_project_milestones->num_rows;
		
		return $row_project_milestones;
		
	}//end get_project_milestones
		
		
	
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
		
		
	//Get get_project_action
		public function get_project_action($project_id){
			
			$this->db->dbprefix('projects');
			$this->db->select('status');
			$this->db->where('id', $project_id);
			$get_projects = $this->db->get('projects');
	
			//echo $this->db->last_query();
			$row_projects['project_action'] = $get_projects->row_array();
			
			
			return $row_projects;
			
		}//end get_project_action	
		


    //Get projects  Record
	public function get_projects(){
		
		
	    $user_id=$this->session->userdata('admin_id');
		
		 if($this->input->post('branch_id')!="" && $this->input->post('search_status')!="" && $this->input->post('important_projects')!="" && $this->input->post('is_awarded')!=""){
		
			 
	    $this->db->dbprefix('projects');
		$this->db->select('projects.*, customers.first_name, customers.last_name, branches.branch_name');
        $this->db->from('projects');
		$this->db->where('projects.branch_id',$this->input->post('branch_id'));
		$this->db->where('projects.status',$this->input->post('search_status'));
		$this->db->where('projects.is_important',1);
		$this->db->where('projects.is_awarded',1);
		//$this->db->or_like('projects.project_assign',$user_id.",");
		//$this->db->or_like('projects.project_assign',",".$user_id);
        $this->db->join('customers', 'projects.customer_id = customers.id');
		$this->db->join('branches', 'projects.branch_id = branches.id');	
		$this->db->order_by('id',DESC);
		$get_projects= $this->db->get();
	
		
		 }elseif($this->input->post('branch_id')!="" && $this->input->post('search_status')!=""){
		
			 
	    $this->db->dbprefix('projects');
		$this->db->select('projects.*, customers.first_name, customers.last_name, branches.branch_name');
        $this->db->from('projects');
		$this->db->where('projects.branch_id',$this->input->post('branch_id'));
		$this->db->where('projects.status',$this->input->post('search_status'));
		//$this->db->or_like('projects.project_assign',$user_id.",");
		//$this->db->or_like('projects.project_assign',",".$user_id);
        $this->db->join('customers', 'projects.customer_id = customers.id');
		$this->db->join('branches', 'projects.branch_id = branches.id');	
		$this->db->order_by('id',DESC);
		$get_projects= $this->db->get();
		//echo $this->db->last_query();exit;
			
		 } 
		
		 elseif($this->input->post('search_status')!=""){
			 
	    $this->db->dbprefix('projects');
		$this->db->select('projects.*, customers.first_name, customers.last_name, branches.branch_name');
        $this->db->from('projects');
		$this->db->where('projects.status',$this->input->post('search_status'));
		//$this->db->or_like('projects.project_assign',$user_id.",");
		//$this->db->or_like('projects.project_assign',",".$user_id);
        $this->db->join('customers', 'projects.customer_id = customers.id');
		$this->db->join('branches', 'projects.branch_id = branches.id');	
		$this->db->order_by('id',DESC);
		$get_projects= $this->db->get();
			
			
		 }
		 elseif($this->input->post('branch_id')!=""){
			 
	    $this->db->dbprefix('projects');
		$this->db->select('projects.*, customers.first_name, customers.last_name, branches.branch_name');
        $this->db->from('projects');
		$this->db->where('projects.branch_id',$this->input->post('branch_id'));
		//$this->db->or_like('projects.project_assign',$user_id.",");
		//$this->db->or_like('projects.project_assign',",".$user_id);
        $this->db->join('customers', 'projects.customer_id = customers.id');
		$this->db->join('branches', 'projects.branch_id = branches.id');	
		$this->db->order_by('id',DESC);
		$get_projects= $this->db->get();
			
			
		 }elseif($this->input->post('important_projects')!=""){
			 
		
	    $this->db->dbprefix('projects');
		$this->db->select('projects.*, customers.first_name, customers.last_name, branches.branch_name');
        $this->db->from('projects');
		$this->db->where('projects.is_important',1);
		//$this->db->or_like('projects.project_assign',$user_id.",");
		//$this->db->or_like('projects.project_assign',",".$user_id);
        $this->db->join('customers', 'projects.customer_id = customers.id');
		$this->db->join('branches', 'projects.branch_id = branches.id');	
		$this->db->order_by('id',DESC);
		$get_projects= $this->db->get();
			
			
		 }elseif($this->input->post('is_awarded')!=""){
			 
		
	    $this->db->dbprefix('projects');
		$this->db->select('projects.*, customers.first_name, customers.last_name, branches.branch_name');
        $this->db->from('projects');
		$this->db->where('projects.is_awarded',1);
		//$this->db->or_like('projects.project_assign',$user_id.",");
		//$this->db->or_like('projects.project_assign',",".$user_id);
        $this->db->join('customers', 'projects.customer_id = customers.id');
		$this->db->join('branches', 'projects.branch_id = branches.id');	
		$this->db->order_by('id',DESC);
		$get_projects= $this->db->get();
			
			
		 }else{
			 
			
			$this->db->dbprefix('projects');
			$this->db->select('projects.*, customers.first_name, customers.last_name, branches.branch_name');
			$this->db->from('projects');
			$this->db->where_in('projects.status',array(0,1));
			//$this->db->or_where('projects.status',0);
			$this->db->like('projects.project_assign',",".$user_id.",");
			//$this->db->or_like('projects.project_assign',",".$user_id);
			$this->db->join('customers', 'projects.customer_id = customers.id');
			$this->db->join('branches', 'projects.branch_id = branches.id');			
			$this->db->order_by('id',DESC);
			$get_projects = $this->db->get();
		 	//echo $this->db->last_query();exit;
			
			//	echo $this->db->last_query();exit;
	  }
		
		$row_projects['projects_filter'] = $get_projects->result_array();
		$row_projects['projects_count'] = $get_projects->num_rows;
		
		
		/*
		
		for($i=0; $i<count($row_projects['projects_filter']); $i++){
			
			$branch_id=$row_projects['projects_filter'][$i]['branch_id'];
			$this->db->dbprefix('branches');
			$this->db->select('branch_name');
			$this->db->from('branches');
			$this->db->where('id',$branch_id);
		    $get_branches = $this->db->get();
			$row_branch= $get_branches->row_array();
			$row_projects['projects_filter'][$i]['branch_name']=$row_branch['branch_name'];
		}
		
		*/
		/*echo "<pre>"; 
		print_r($row_projects_arr['projects_arr']);
		exit;*/
		
		
		/*if($user_id != '1'){ //Admin Check
					$counter = 0 ; 	
					$h = 0 ;
					for($k=0;$k<count($row_projects_arr['projects_arr']);$k++){
					$explode_arr = explode(',',$row_projects_arr['projects_arr'][$k]['project_assign']);
						
							if(in_array($user_id,$explode_arr))
							
							{
								
				    //$row_projects['projects_filter'] = $row_projects['projects_arr'][$k]; 
								
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
					$row_projects['projects_filter'][$h]['project_label'] = $row_projects_arr['projects_arr'][$k]['project_label'] ;
					$row_projects['projects_filter'][$h]['is_important'] = $row_projects_arr['projects_arr'][$k]['is_important'] ;
					$row_projects['projects_filter'][$h]['is_awarded'] = $row_projects_arr['projects_arr'][$k]['is_awarded'] ;
					$row_projects['projects_filter'][$h]['payment_due'] = $row_projects_arr['projects_arr'][$k]['payment_due'] ;
                  
				   
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
					
			}*/
		
		
		
		return $row_projects;
		
	}//end Project Records
  
  
  public function my_projects(){
	    $user_id=$this->session->userdata('admin_id');
	 	 $this->db->dbprefix('projects');
			$this->db->select('projects.*, customers.first_name, customers.last_name');
			$this->db->from('projects');
			$this->db->join('customers', 'projects.customer_id = customers.id');
						$this->db->like('projects.project_assign',",".$user_id.",");	
			$this->db->order_by('id',DESC);
			$my_projects = $this->db->get();
		 	//echo $this->db->last_query();
	
		
		$row_projects['my_projects_data'] = $my_projects->result_array();
		$row_projects['my_projects_count'] = $my_projects->num_rows;
	  return $row_projects;
	  }
  
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
		//$this->db->where('id !=',1);
		$this->db->where('status',1);
		$get_projects= $this->db->get('admin');
		//echo $this->db->last_query();
		$row_users['users_arr'] = $get_projects->result_array();
		$row_users['users_count'] = $get_projects->num_rows;
		
		return $row_users;
		
	}//end all users
	
	
	//Get assign_team
	public function get_assign_team($project_id){
		
		$this->db->dbprefix('projects');
		$this->db->select('project_assign');
		$this->db->where('id',$project_id);
		$get_assign_team= $this->db->get('projects');
		//echo $this->db->last_query();
		$row_assign_team= $get_assign_team->row_array();
		
		$assign_team= explode(',', $row_assign_team['project_assign']);
		
		/*echo "<pre>";
		print_r($assign_team);
		exit;*/
		
		return $assign_team;
		
	}//end assign_team


	//Add new Project
	public function add_project($data){
		
		  extract($data);
		  
		  
		
		   $start_date = date("Y-m-d", strtotime($start_date));
		   $end_date = date("Y-m-d", strtotime($end_date));
		
	
		   $created_date = date('Y-m-d G:i:s');
		   $created_by_ip = $this->input->ip_address();
		   $created_by = $this->session->userdata('admin_id');
		   
		  //$users= $this->mod_common->assign_project_users();
		   
		//  echo $default_users;exit;
		   
		   $users= explode(',',$default_users);
		   
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
		   
		//echo $project_assign;exit;
		
		   
		   $ins_data = array(
		    'branch_id' => $this->db->escape_str(trim($branch_id)),
		    'project_id' => $this->db->escape_str(trim($project_id)),
		    'customer_id' => $this->db->escape_str(trim($customer_id)),
			'forum_id' => $this->db->escape_str(trim($forum_id)),
			'project_title' => $this->db->escape_str(trim($project_subject)),
			'project_amount' => $this->db->escape_str(trim($project_amount)),
			'received_amount' => $this->db->escape_str(trim($received_amount)),
		    'start_date' => $this->db->escape_str(trim($start_date)),
			'end_date' => $this->db->escape_str(trim($end_date)),
		    'project_detail' => $this->db->escape_str(trim(nl2br($project_detail))),
			'live_url' => $this->db->escape_str(trim($live_url)),
			'local_url' => $this->db->escape_str(trim($local_url)),
			'design_url' => $this->db->escape_str(trim($design_url)),
			'prototype_url' => $this->db->escape_str(trim($prototype_url)),
			'project_assign' => $this->db->escape_str(trim(",".$project_assign.",")),
			'status' => $this->db->escape_str(trim($status)),
			'is_awarded' => $this->db->escape_str(trim($is_awarded)),
			'project_label' => $this->db->escape_str(trim($project_label)),
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
			$config['allowed_types'] = 'jpg|jpeg|gif|tiff|tif|png|doc|docx|xls|xlsx|pdf|txt|zip|rar|odt|csv|pptx|ppt';
			$config['max_size']	= '15000';
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
		 
			
			$subject='New Project <b>('.$project_subject.')</b> Assigned to you ';
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
		    'created_by_ip' => $this->db->escape_str(trim($created_by_ip)),
			'notification' => $this->db->escape_str(trim(1))
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
		
		
		/////////////////Add Project Milestones //////////////
		
		for($i=0; $i<count($milestones); $i++){
		   $milestone_data = array(
		    'project_id' => $this->db->escape_str(trim($project_id)),
			'milestone_name' => $this->db->escape_str(trim($milestones[$i])),
		    'created_date' => $this->db->escape_str(trim($created_date))
		    );		

		   //Inserting the record into the database.
		  $this->db->dbprefix('project_milestones');
		  $ins_into_db = $this->db->insert('project_milestones', $milestone_data);
		
		}
		
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
		
		//$users= $this->mod_common->assign_project_users();
		
		/*if($project_assign !=""){
			
		 $assign=array_merge($users,$project_assign);
		 $new_project_assign=array_unique($assign);
		 $fnl_project_assign= array_values($new_project_assign);
	     $project_assign=implode(',',$new_project_assign);
		
		}
		else{
			
			 $project_assign=implode(',',$users);
			
			}	*/
			
		
		$project_assign=implode(',',$project_assign);
			
					
		$upd_data = array(
		    'branch_id' => $this->db->escape_str(trim($branch_id)),
		    'project_id' => $this->db->escape_str(trim($project_id)),
		    'customer_id' => $this->db->escape_str(trim($customer_id)),
			'forum_id' => $this->db->escape_str(trim($forum_id)),
			'project_title' => $this->db->escape_str(trim($project_subject)),
			'project_amount' => $this->db->escape_str(trim($project_amount)),
			'received_amount' => $this->db->escape_str(trim($received_amount)),
		    'start_date' => $this->db->escape_str(trim($start_date)),
			'end_date' => $this->db->escape_str(trim($end_date)),
		    'project_detail' => $this->db->escape_str(trim(nl2br($project_detail))),
			'live_url' => $this->db->escape_str(trim($live_url)),
			'local_url' => $this->db->escape_str(trim($local_url)),
			'design_url' => $this->db->escape_str(trim($design_url)),
			'prototype_url' => $this->db->escape_str(trim($prototype_url)),
			'project_assign' => $this->db->escape_str(trim(",".$project_assign.",")),
			'status' => $this->db->escape_str(trim(nl2br($status))),
			'is_awarded' => $this->db->escape_str(trim($is_awarded)),
			'project_label' => $this->db->escape_str(trim($project_label)),
			'project_rating' => $this->db->escape_str(trim($project_rating)),
			'feedback' => $this->db->escape_str(trim($project_feedback)),
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
			$config['allowed_types'] = 'jpg|jpeg|gif|tiff|tif|png|doc|docx|xls|xlsx|pdf|txt|zip|rar|odt|csv|pptx|ppt';
			$config['max_size']	= '15000';
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
		
		
		//Get Milestone
		$this->db->dbprefix('project_milestones');
		$this->db->where('project_id',$id);
	    $get_project_milestones= $this->db->get('project_milestones');
		$project_milestones_arr= $get_project_milestones->result_array();
		
		//Delet old milestones
		//$this->db->dbprefix('project_milestones');
		//$this->db->where('project_id',$id);
		//$this->db->delete('project_milestones');
	
		
		/////////////////Add Project Milestones //////////////
		
		
		for($i=0; $i<count($milestones); $i++){

				if($milestones_id[$i] == $project_milestones_arr[$i]['id'] ){	
				
			
				  $upd_milestone_data = array(
						'milestone_name' => $this->db->escape_str(trim($milestones[$i]))
					);		
			
				   //Inserting the record into the database.
				  $this->db->dbprefix('project_milestones');
				  $this->db->where('id',$milestones_id[$i] );
				  $this->db->update('project_milestones', $upd_milestone_data);
		
				  
			}
		
		}
		
		
		
		if($new_milestones[0] !=""){
	
		
		if(count($new_milestones) >0){
			
			
			for($j=0; $j<count($new_milestones); $j++){
			
			 $milestone_data = array(
								'project_id' => $this->db->escape_str(trim($id)),
								'milestone_name' => $this->db->escape_str(trim($new_milestones[$j])),
								'created_date' => $this->db->escape_str(trim($created_date))
							);		
								
			  //Inserting the record into the database.
			  $this->db->dbprefix('project_milestones');
			  $this->db->insert('project_milestones', $milestone_data);	
			}
			
			
		 }
				
		
		}

	
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
		// Get the User Details
		$this->db->dbprefix('projects');
		$this->db->select('projects.*,customers.first_name,customers.last_name,customers.id');
        $this->db->from('projects');
        $this->db->join('customers', 'projects.customer_id = customers.id');
		$this->db->where('projects.id',$project_id);
		$get_project_details = $this->db->get();
		$get_project_details_arr['project_details_result'] = $get_project_details->row_array();
			
	
		//Get Project Attachments
		$this->db->dbprefix('project_attachments');
		$this->db->where('project_id',$project_id);
		$get_project_attachments= $this->db->get('project_attachments');
		$get_project_details_arr['project_attachments'] = $get_project_attachments->result_array();
		$get_project_details_arr['project_attachments_count'] = $get_project_attachments->num_rows;
		//echo $this->db->last_query();
		
		$project_assign_team = trim($get_project_details_arr['project_details_result']['project_assign'],",");
		
		$project_assign_id = explode(',', $project_assign_team);
	
		if(in_array($this->session->userdata('admin_id'), $project_assign_id)){
			
			for($i=0; $i < count($project_assign_id); $i++){
			
			$this->db->dbprefix('admin');
			$this->db->select('admin.id, admin.admin_role_id, admin.first_name, admin.last_name, admin_roles.role_title');
			$this->db->from('admin');
			$this->db->join('admin_roles', 'admin_roles.id = admin.admin_role_id');
			$this->db->where('admin.id', $project_assign_id[$i]);
			$get_user= $this->db->get();
			$get_user_arr['user_arr'] = $get_user->row_array();
			$get_project_details_arr['project_assign_team'][$i]['user_name'] = $get_user_arr['user_arr']['first_name']." ".
																				$get_user_arr['user_arr']['last_name'];
	 		$get_project_details_arr['project_assign_team'][$i]['id'] = $get_user_arr['user_arr']['id'];
		    $get_project_details_arr['role'][$i] = $get_user_arr['user_arr']['role_title'];
/*			  $admin_role_id = $get_user_arr['user_arr']['admin_role_id']; 
			  $this->db->dbprefix('admin_roles');
			  $this->db->select('role_title');
			  $this->db->from('admin_roles');
			  $this->db->where('id',$admin_role_id);
			  $get_role= $this->db->get();
			  $get_role_arr['user_arr'] = $get_role->row_array();

*/			  
			
			}
	    /*  echo "<pre>";	
		   print_r( $get_project_details_arr);	
		
	        exit;*/
		return $get_project_details_arr;
			
		
			
		}else{
			
			return  $get_project_details_arr['error']= array('error' =>"Opps...! Project not found...!!");
			
		}
		
		
				
		
	}//end project_detail
	

   public function get_autoload_latest_messages($data){
		
		extract($data);
		
	
		//$user_id_to =$this->session->userdata('admin_id');
		
		$this->db->dbprefix('project_messages');
		$this->db->where('project_id',$project_id);
		$this->db->where('id >',$last_row_id);
		//$this->db->order_by('id',DESC);
		
		$get_project_messages= $this->db->get('project_messages');
       // echo $this->db->last_query();exit;
		$autoload_latest_messages = $get_project_messages->result_array();
		
	
		for($i=0; $i<count($autoload_latest_messages); $i++)
		{
			
		   $user_type=$autoload_latest_messages[$i]['user_type'];
		   $from=$autoload_latest_messages[$i]['from'];
		
		if($user_type=='u'){
			
		       $this->db->dbprefix('admin');
		       $this->db->where('id',$from);
		       $get_project_messages= $this->db->get('admin');
			   $name_array= $get_project_messages->row_array();
			   
			  $role_id= $name_array['admin_role_id'];
			  $this->db->dbprefix('admin_roles');
			  $this->db->select('role_title');
		      $this->db->where('id',$role_id);
		      $get_admin_role= $this->db->get('admin_roles');
			  $admin_role_arr= $get_admin_role->row_array();
			   
			  $autoload_latest_messages[$i]['admin_id']= $name_array['id'];
			  $autoload_latest_messages[$i]['user']= $name_array['first_name']." ".$name_array['last_name'];
			  $autoload_latest_messages[$i]['user_role']= $admin_role_arr['role_title'];
			  $autoload_latest_messages[$i]['avatar_image']= $name_array['avatar_image'];
			  
			  $admin_avg_rating= $this->mod_admin->get_average_rating($from);
			  
			  $autoload_latest_messages[$i]['admin_rating']= $admin_avg_rating['average_rating'];  
			   
			
			}
		if($user_type=='c'){
			
		      $this->db->dbprefix('customers');
		      $this->db->where('id',$from);
		      $get_project_messages= $this->db->get('customers');
		      $name_array= $get_project_messages->row_array();
			  $autoload_latest_messages[$i]['user']= $name_array['first_name']." ".$name_array['last_name'];
			
			}
			
			
		$project_message_id=$autoload_latest_messages[$i]['id'];
		$project_messages_attachments = $this->get_message_attachments($project_message_id);	
		
		
		for($j=0;$j<count($project_messages_attachments);$j++){
			
			$autoload_latest_messages[$i]['project_attachments'][$j]['file_name'] = $project_messages_attachments[$j]['attachments'];
			
			
			$autoload_latest_messages[$i]['project_attachments'][$j]['file_original_name']  = $project_messages_attachments[$j]['file_original_name'];
			
		}//end for*/
			
			
			
		}//End for
		
		return $autoload_latest_messages;	
		
		
		
		}	


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
		
		
		//insertion in projects messages
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
		$project_message_id= $this->db->insert_id();
		
		
		$upd_attch_data = array(
		   'project_message_id' => $this->db->escape_str(trim($project_message_id))
		);
		
		
		if(isset($attachment_id)){
		
		for($i=0; $i<count($attachment_id); $i++){
		
			$this->db->dbprefix('project_messages_attachments');
			$this->db->where('id',$attachment_id[$i]);
			$ins_into_db = $this->db->update('project_messages_attachments', $upd_attch_data);
		
		}
		
		}
		
		
		$get_team_arr['team_arr'] = $get_project_messages->row_array();
		
		
		//andriod push notificaiton 
		
		
		$project_assign_team = trim($get_team_arr['team_arr']['project_assign'],",");
		
		$team_members=explode(',',$project_assign_team); 
		
		
		//Get Api Key
		$get_api_key = $this->mod_preferences->get_preferences_setting('api_key');
		$api_key = $get_api_key['setting_value'];
		
		$from_name= $this->session->userdata('display_name');
		
		
		//$api_key = "AIzaSyAqnfloyjoEjhAcGNVdWTeRt1YDRFozNKg";
		
		  $andriodapp_pushnotifiction_gcimids = array();
		
		for($i=0; $i<count($team_members); $i++){
			
			 $message_id = $this->mod_common->random_number_generator(7);
			 $message_id = $this->mod_projects->message_id_generator($message_id);
	
		     $message_subject="You have recieved a new message on project  (<b> <a href=".base_url()."projects/manage-projects/project-detail/".$project_id." target='_blank' > ".$get_team_arr['team_arr']['project_title']."</a></b>)  by ".strtoupper($this->session->userdata('display_name'));
			 
			
	 // $message='To see complete message please click on the link below:<br /><a href="'.base_url().'projects/manage-projects/project-detail/'.$project_id.'">'.base_url().'projects/manage-projects/project-detail/'.$project_id.'</a>';
			
			 $ins_data = array(
				'to' => $this->db->escape_str(trim($team_members[$i])),
				'from' => $this->db->escape_str(trim($created_by)),
				'subject' => $this->db->escape_str(trim($message_subject)),
				//'message' => $this->db->escape_str(trim(nl2br($message))),
				'message_id' => $this->db->escape_str(trim($message_id)),
				'project_message_id' => $this->db->escape_str(trim($project_message_id)),
				'attachment' => $this->db->escape_str(trim($attachment_name)),
				'created_by' => $this->db->escape_str(trim($created_by)),
				'date' => $this->db->escape_str(trim($created_date)),
				'created_by_ip' => $this->db->escape_str(trim($created_by_ip)),
				'notification' => $this->db->escape_str(trim(1))
				);		
  
			 if($created_by != $team_members[$i]){ // don't insert notification for created by user
			   //Inserting the record into the database.
			  $this->db->dbprefix('messages');
			  $ins_into_db = $this->db->insert('messages', $ins_data);
			 
			 
			 
			 
			 //Send App notifications to all team
			 //Get user Registration App ID
			  $this->db->dbprefix('admin');
			  $this->db->select('gcm_regid');
		 	  $this->db->where('id',$team_members[$i]);
		      $get_admin_app_id= $this->db->get('admin');
			  $admin_app_id_arr = $get_admin_app_id->row_array();
			  
			 if($admin_app_id_arr['gcm_regid'] !=""){
			
				// please enter the registration id of the device on which you want to send the message
				
				$andriodapp_pushnotifiction_gcimids[] = $admin_app_id_arr['gcm_regid'];
				
				
				//echo $result;
			
		 }//end if user app id not empty
			
			
			
			} // don't send notification to self scheck
			
			 
		}//End for message to all assigned team
		
		
		
		//Send Email to Customer
		$this->load->helper(array('email', 'url'));
	
		//Preparing Sending Email
		$config['charset'] = 'utf-8';
		$config['mailtype'] = 'html';
		$config['wordwrap'] = TRUE;			
		$config['protocol'] = 'mail';
		
		$this->load->library('email',$config);
		
	  //Send Email to customers and Subusers
	   $explode_arr = explode(',',$get_team_arr['team_arr']['employee_assign']);
	   
	   $customer[]= $to;
	   
	   $all_customers= array_merge($customer,$explode_arr);
	   
		/*echo "<pre>";
		print_r($all_customers);
		exit;*/
		
		
	
	 for($i=0; $i<count($all_customers); $i++){
		
	   //fetching email data from site preferences
   	   $this->db->dbprefix('customers');
	   $this->db->where('id',$all_customers[0]);
	   $get = $this->db->get('customers');
	   $email_data= $get->row_array();
	   
	  $to_customer= $email_data['email_address'];
	  
	  if($email_data['gcm_regid']){
	  $andriodapp_pushnotifiction_gcimids[] =  $email_data['gcm_regid']; 
	  }
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
	 
	}
	   
		
		
	// mzm send push notification for andriod app	
		//echo '<pre>';
		//print_r($andriodapp_pushnotifiction_gcimids);
		if(!empty( $andriodapp_pushnotifiction_gcimids)) { // we have valid gcimids lets do push notification
		$registrationIDs=  $andriodapp_pushnotifiction_gcimids ; 
				
				$message = array("project_title" => $get_team_arr['team_arr']['project_title'], "message_detail" => $message_reply, "from_name" => $from_name , 'message_id'=> $message_id , 'project_id'=>$project_id);
				
				$url = 'https://android.googleapis.com/gcm/send';
				$fields = array(
					'registration_ids'  => $registrationIDs,
					'data'              => array( "message" => $message ),
					);
				//print_r($fields );
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
				
		}
				
				//exit;
	}//end project_messages
	
	
	public function submit_portfolio($data){
		
		extract($data);
		
		 $created_date = date('Y-m-d G:i:s');
		 $created_by_ip = $this->input->ip_address();
		 
		 $created_by = $this->session->userdata('admin_id');
		 
		
	 	$project_portfolio="<b>Project Portfolio</b><br /><br /> <b>Project URL:</b> ".$url. " <br /> <b>Project Description:</b><br /> ". $description;
		
		$insrt_data = array(
		    'project_id' => $this->db->escape_str(trim($project_id)),
		    'to' => $this->db->escape_str(trim($to)),
			'from' => $this->db->escape_str(trim($created_by)),
			'message' => $this->db->escape_str(trim(nl2br($project_portfolio))),
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
			$config['allowed_types'] = 'jpg|jpeg|gif|tiff|tif|png|doc|docx|xls|xlsx|pdf|txt||zip|rar|odt|csv|ppt|pptx';
			$config['max_size']	= '15000';
			$config['overwrite'] = true;
	
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			$this->load->library('multipleupload',$config);
			
			
			$upload_epaper =  $this->multipleupload->do_multi_upload_project_message_attachments('attachments',TRUE,$message_id);
			
			if(!$upload_epaper){
				
				/*echo "<pre>";
			print_r($upload_epaper);
			exit;*/

				
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
	
	
	public function get_message_attachments($project_message_id){
		
		$this->db->dbprefix('project_messages_attachments');
		$this->db->where('project_message_id',$project_message_id);
		//$this->db->order_by('project_message_id',DESC);
		$get_messages_attachments = $this->db->get('project_messages_attachments');
		
		$message_att_arr = $get_messages_attachments->result_array();
		/*
		//$final_message_attach_arr = array();
		
		//echo $this->db->last_query(); exit;
		for($i=0;$i<count($message_att_arr);$i++){
			
			$final_message_attach_arr[$message_att_arr[$i]['project_message_id']][$i]['file_name'] = $message_att_arr[$i]['attachments'];
			$final_message_attach_arr[$message_att_arr[$i]['project_message_id']][$i]['file_original_name'] = $message_att_arr[$i]['file_original_name'];
			
		}//end for*/
		
		
		return $message_att_arr;
		
	}//end get_message_attachments
	
	public function get_project_messages($project_id){
	
		$this->db->dbprefix('project_messages');
		$this->db->where('project_id',$project_id);
		$this->db->order_by('id',DESC);
		$this->db->limit(10);
		$get_project_messages= $this->db->get('project_messages');
        //echo $this->db->last_query();
		$get_project_messages_arr['project_messages_result'] = $get_project_messages->result_array();
		$get_project_messages_arr['project_messages_count'] = $get_project_messages->num_rows();
		
		
		for($i=0; $i<$get_project_messages_arr['project_messages_count']; $i++)
		{
			
		   $project_message_id=$get_project_messages_arr['project_messages_result'][$i]['id'];
		   $user_type=$get_project_messages_arr['project_messages_result'][$i]['user_type'];
		   $from=$get_project_messages_arr['project_messages_result'][$i]['from'];
		
		if($user_type=='u'){
			
		       $this->db->dbprefix('admin');
		       $this->db->where('id',$from);
		       $get_project_messages= $this->db->get('admin');
			   $name_array= $get_project_messages->row_array();
			   
			  $role_id= $name_array['admin_role_id'];
			  $this->db->dbprefix('admin_roles');
			  $this->db->select('role_title');
		      $this->db->where('id',$role_id);
		      $get_admin_role= $this->db->get('admin_roles');
			  $admin_role_arr= $get_admin_role->row_array();
			   
			  $get_project_messages_arr['project_messages_result'][$i]['admin_id']= $name_array['id'];
			  $get_project_messages_arr['project_messages_result'][$i]['user']= $name_array['first_name']." ".$name_array['last_name'];
			  $get_project_messages_arr['project_messages_result'][$i]['user_role']= $admin_role_arr['role_title'];
			  $get_project_messages_arr['project_messages_result'][$i]['avatar_image']= $name_array['avatar_image'];
			  
			  $admin_avg_rating= $this->mod_admin->get_average_rating($from);
			  
			  $get_project_messages_arr['project_messages_result'][$i]['admin_rating']= $admin_avg_rating['average_rating'];  
			   
			
			}
		if($user_type=='c'){
			
		      $this->db->dbprefix('customers');
		      $this->db->where('id',$from);
		      $get_project_messages= $this->db->get('customers');
		      $name_array= $get_project_messages->row_array();
			  $get_project_messages_arr['project_messages_result'][$i]['user']= $name_array['first_name']." ".$name_array['last_name'];
			
			}
			
		$project_messages_attachments = $this->get_message_attachments($project_message_id);	
		
		
		for($j=0;$j<count($project_messages_attachments);$j++){
			
			$get_project_messages_arr['project_messages_result'][$i]['project_attachments'][$j]['file_name'] = $project_messages_attachments[$j]['attachments'];
			
			
			$get_project_messages_arr['project_messages_result'][$i]['project_attachments'][$j]['file_original_name']  = $project_messages_attachments[$j]['file_original_name'];
			
		}//end for*/
		
	
			
		}//End for
		
			
	   /* echo "<pre>";
		print_r($get_project_messages_arr);
	    exit;*/
			
		
	
		return $get_project_messages_arr;	
		
	}//end get_project_messages
	
	
	
	//load_more
	public function load_more($project_id){
		
		
		$this->db->dbprefix('project_messages');
		$this->db->where('id <',$this->input->post('id'));
		$this->db->where('project_id',$project_id);
		$this->db->order_by('id',DESC);
		$this->db->limit(5);
		$get_project_messages= $this->db->get('project_messages');
       // echo $this->db->last_query();
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
			   
			  $role_id= $name_array['admin_role_id'];
			  $this->db->dbprefix('admin_roles');
			  $this->db->select('role_title');
		      $this->db->where('id',$role_id);
		      $get_admin_role= $this->db->get('admin_roles');
			  $admin_role_arr= $get_admin_role->row_array();
			   
			  $get_project_messages_arr['project_messages_result'][$i]['admin_id']= $name_array['id'];
			  $get_project_messages_arr['project_messages_result'][$i]['user']= $name_array['first_name']." ".$name_array['last_name'];
			  $get_project_messages_arr['project_messages_result'][$i]['user_role']= $admin_role_arr['role_title'];
			  $get_project_messages_arr['project_messages_result'][$i]['avatar_image']= $name_array['avatar_image'];
			  
			  $admin_avg_rating= $this->mod_admin->get_average_rating($from);
			  
			  $get_project_messages_arr['project_messages_result'][$i]['admin_rating']= $admin_avg_rating['average_rating'];  
			   
			
			}
		if($user_type=='c'){
			
		      $this->db->dbprefix('customers');
		      $this->db->where('id',$from);
		      $get_project_messages= $this->db->get('customers');
		      $name_array= $get_project_messages->row_array();
			  $get_project_messages_arr['project_messages_result'][$i]['user']= $name_array['first_name']." ".$name_array['last_name'];
			
			}
			
			
		
		$project_message_id=$get_project_messages_arr['project_messages_result'][$i]['id'];
		$project_messages_attachments = $this->get_message_attachments($project_message_id);	
		
		
		for($j=0;$j<count($project_messages_attachments);$j++){
			
			$get_project_messages_arr['project_messages_result'][$i]['project_attachments'][$j]['file_name'] = $project_messages_attachments[$j]['attachments'];
			
			
			$get_project_messages_arr['project_messages_result'][$i]['project_attachments'][$j]['file_original_name']  = $project_messages_attachments[$j]['file_original_name'];
			
		}//end for*/
			
			
		}//End for
		
	
		return $get_project_messages_arr;	
		
	}//end load_more
	
	
	
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
		
		//Get project record
		$this->db->dbprefix('projects');
		$this->db->where('id',$project_id);
		$get_data = $this->db->get('projects');
		$project_arr['project_arr'] = $get_data->row_array();
		
		$get_assign_team=$project_arr['project_arr']['project_assign'];
		
		$assign_team_arr= explode(',',rtrim($get_assign_team,','));
		
		
		//$users= $this->mod_common->assign_project_users();
		if($name !=""){
		$assign=array_merge($assign_team_arr,$name);
		$new_project_assign=array_unique($assign);
		$fnl_project_assign= array_values($new_project_assign);
		}else{
			
		$fnl_project_assign= $assign_team_arr;
		}
		
	  
		
		$new_name=implode(',',$fnl_project_assign);
		
	
		 
		$update_data = array(
		    'project_assign' => $this->db->escape_str(trim($new_name.","))
		);		

		//Updating the record into the database.
		$this->db->dbprefix('projects');
		$this->db->where('id',$project_id);
		$upd_into_db = $this->db->update('projects', $update_data);
		
		
	    //Send Message to Assign Users
		if($name !=""){
			
			/*echo "<pre>";
			print_r($name);
			exit;*/
	
		for($j=0;$j<count($name); $j++){
			
			//Mesage id Generator
		    $message_id = $this->mod_common->random_number_generator(7);
		    $message_id = $this->mod_projects->message_id_generator($message_id);
		 
			
			$subject='New Project <b>('.$project_arr['project_arr']['project_title'].')</b> Assigned to you. ';
			$message="Dear User, a new project is assigned to you. Please go to Project section to see more details. Thank  You!";
			$to_user = $name[$j];
			
			 $ins_msg_data = array(
		    'to' => $this->db->escape_str(trim($to_user)),
		    'from' => $this->db->escape_str(trim($created_by)),
		    'subject' => $this->db->escape_str(trim($subject)),
			'message' => $this->db->escape_str(trim(nl2br($message))),
		    'message_id' => $this->db->escape_str(trim($message_id)),
		    'created_by' => $this->db->escape_str(trim($created_by)),
		    'date' => $this->db->escape_str(trim($created_date)),
		    'created_by_ip' => $this->db->escape_str(trim($created_by_ip)),
			'notification' => $this->db->escape_str(trim(1))
		    );		

		   //Inserting the record into the database.
		  $this->db->dbprefix('messages');
		  $ins_into_db = $this->db->insert('messages', $ins_msg_data);
			
		}//End For////////// End Message to Assign Users
		}//endif team assign
		
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
		   
			$datetime1 = strtotime($start_date);
			$datetime2 = strtotime($end_date);
			$interval  = abs($datetime2 - $datetime1);
			$minutes   = round($interval / 60);
			//echo 'Diff. in minutes is: '.$minutes; 
		   
		  //  $newstartdate = date("Y-m-d h:i:s a", strtotime($startdate));
		   
		   $created_date = date('Y-m-d G:i:s');
		   $created_by_ip = $this->input->ip_address();
		   $created_by = $this->session->userdata('admin_id');
		   
		   
		   
		
		
		  //echo $total_time;exit; 
			   
			/*$this->db->dbprefix('projects');
			$this->db->where('id',$project_id);
			$get_data = $this->db->get('projects');
			$users_arr['users_arr'] = $get_data->row_array();
			
		    $user_id= $users_arr['users_arr']['project_assign'];*/
			
			
			$user_id=implode(',',$task_assign);
			
			
			
		   $ins_data = array(
		    'user_id' => $this->db->escape_str(trim($user_id)),
		    'project_id' => $this->db->escape_str(trim($project_id)),
			'milestone' => $this->db->escape_str(trim($milestone)),			  
			'title' => $this->db->escape_str(trim($title)),
		    'start_date' => $this->db->escape_str(trim($start_date)),
			'end_date' => $this->db->escape_str(trim($end_date)),
			'total_time' => $this->db->escape_str(trim($minutes)),
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
			$config['allowed_types'] = 'jpg|jpeg|gif|tiff|tif|png|doc|docx|xls|xlsx|pdf|txt|zip|rar|odt|csv|pptx|ppt';
			$config['max_size']	= '15000';
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
		
		//$assign_to= $users_arr['users_arr']['project_assign'];
		//$user_id= explode(',',$users_arr['users_arr']['project_assign']); 
		
		/*echo "<pre>";
		print_r($task_assign);
		exit;
		*/
		for($j=0;$j<count($task_assign); $j++){
			
			//Mesage id Generator
		    $message_id = $this->mod_common->random_number_generator(7);
		    $message_id = $this->mod_projects->message_id_generator($message_id);
		 
			
			$subject='New Task is assign to you against Project : '.$users_arr['users_arr']['project_title'];
			
			$message="Dear User,<br><br> New Task is assigned to you against Project:" ."<strong> (<a href='".SURL."projects/manage-projects/project-detail/".$project_id."' title='Click for project detail'>".$users_arr['users_arr']['project_title']."</a>)</strong> ". " Please go to your task section to see more details or click the link below. Thank You! <br><br><a href='".SURL."projects/manage-projects/assign-task-detail/".$project_task_id."'>".SURL."projects/manage-projects/assign-task-detail/".$project_task_id."</a> ";
			$to_user = $task_assign[$j];
			
			
			 $ins_msg_data = array(
		    'to' => $this->db->escape_str(trim($to_user)),
		    'from' => $this->db->escape_str(trim($created_by)),
		    'subject' => $this->db->escape_str(trim($subject)),
			'message' => $this->db->escape_str(trim($message)),
		    'message_id' => $this->db->escape_str(trim($message_id)),
		    'created_by' => $this->db->escape_str(trim($created_by)),
		    'date' => $this->db->escape_str(trim($created_date)),
		    'created_by_ip' => $this->db->escape_str(trim($created_by_ip)),
			'notification' => $this->db->escape_str(trim(1))
		    );		

         if($to_user !=$this->session->userdata('admin_id')){

			   //Inserting the record into the database.
			  $this->db->dbprefix('messages');
			  $ins_into_db = $this->db->insert('messages', $ins_msg_data);
		   }
			
		}//End For
		
		 $event_url=SURL."projects/manage-projects/assign-task-detail/".$project_task_id;
		
		  //Inset Data in Calender Table
		 $this->load->model('common/mod_common');
		
		 $this->mod_common->calendar('project task', $title, $description,$event_url,$start_date,$end_date, $project_task_id, $user_id);
		
		  
		
	     return true;
		
		
	}//end Assign Task
	
	
	 //Get Assign task  Record
	public function get_assign_task(){
		
		
		if($this->input->post('search_status')!=""){
			
		$this->db->dbprefix('project_task');
		$this->db->select('project_task.*,projects.project_title');
        $this->db->from('project_task');
		$this->db->where('project_task.status',$this->input->post('search_status'));
        $this->db->join('projects', 'project_task.project_id = projects.id');
		$this->db->order_by('project_task.id',DESC);
		$get_projects= $this->db->get();
		
		$get_projects = $this->db->query("SELECT (TIMESTAMPDIFF(MINUTE,inno_project_task.start_date,inno_project_task.end_date)) as allocatedtime, (TIMESTAMPDIFF(MINUTE,inno_project_task.task_started_date,inno_project_task.task_close_date)) as consumedtime, inno_project_task.title,inno_project_task.start_date,inno_project_task.end_date,inno_project_task.rating,inno_project_task.rating_status,inno_project_task.created_date,inno_project_task.user_id,inno_project_task.status,inno_project_task.task_started_date,inno_project_task.task_close_date,inno_project_task.total_time, inno_projects.project_title FROM `inno_project_task` join inno_projects on inno_projects.id= inno_project_task.project_id  WHERE inno_project_task.status=".$this->input->post('search_status')." order by inno_project_task.id DESC   ");
		
			
			
			
		}else{
		
	
		
		$get_projects = $this->db->query('SELECT (TIMESTAMPDIFF(MINUTE,inno_project_task.start_date,inno_project_task.end_date)) as allocatedtime, (TIMESTAMPDIFF(MINUTE,inno_project_task.task_started_date,inno_project_task.task_close_date)) as consumedtime,inno_project_task.id, inno_project_task.title,inno_project_task.start_date,inno_project_task.end_date,inno_project_task.rating,inno_project_task.rating_status,inno_project_task.created_date,inno_project_task.user_id,inno_project_task.status,inno_project_task.task_started_date,inno_project_task.task_close_date,inno_project_task.total_time, inno_projects.project_title FROM `inno_project_task` join inno_projects on inno_projects.id= inno_project_task.project_id order by inno_project_task.id DESC  ');
		
		}
		
		$row_assign_task_arr['assign_task_arr'] = $get_projects->result_array();
		$row_assign_task_arr['assign_task_count'] = $get_projects->num_rows();
		
		/*echo "<pre>";
		print_r($row_assign_task_arr['assign_task_arr']);
		exit;*/
		
		
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
					$row_assign_task['assign_task_filter'][$h]['total_time'] = $row_assign_task_arr['assign_task_arr'][$k]['total_time'] ;
					
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
					$row_assign_task['assign_task_filter'][$h]['rating'] = $row_assign_task_arr['assign_task_arr'][$k]['rating'] ;
					$row_assign_task['assign_task_filter'][$h]['rating_status'] = $row_assign_task_arr['assign_task_arr'][$k]['rating_status'] ;
					
					$row_assign_task['assign_task_filter'][$h]['task_started_date'] = $row_assign_task_arr['assign_task_arr'][$k]['task_started_date'] ;
					
					$row_assign_task['assign_task_filter'][$h]['task_close_date'] = $row_assign_task_arr['assign_task_arr'][$k]['task_close_date'] ;
					
					$row_assign_task['assign_task_filter'][$h]['allocatedtime'] = $row_assign_task_arr['assign_task_arr'][$k]['allocatedtime'] ;
					
					$row_assign_task['assign_task_filter'][$h]['consumedtime'] = $row_assign_task_arr['assign_task_arr'][$k]['consumedtime'] ;
					
						        $h++;
								$counter  = $counter + 1 ;   
								
							//echo "<pre>"; print_r($row_projects['projects_filter']); exit; 	
							}
			}
			
		$row_assign_task['assign_task_count'] = $counter ;
		
			
		
	/*	echo "<pre>";
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
		$this->db->select('project_title,project_assign');
		$this->db->where('id',$project_id);
		$get_project= $this->db->get('projects');
		$project_arr['project_result'] = $get_project->row_array();
		
		
		//Get Assign to Users
		$assign_to_users= $assign_task_arr['assign_task_result']['user_id'];
		
		$assign_team= explode(',',$assign_to_users);
		
		for($i=0; $i<count($assign_team); $i++){
			
			$this->db->dbprefix('admin');
			$this->db->select('id,first_name,last_name');
			$this->db->where('id',$assign_team[$i]);
			$get_admin= $this->db->get('admin');
			$admin_arr= $get_admin->row_array();
			$assign_task_arr['assign_task_result']['assign_to']['name'][$i]= $admin_arr['first_name']." ".$admin_arr['last_name'];
			$assign_task_arr['assign_task_result']['assign_to']['user_id'][$i]= $admin_arr['id'];
				
		}
		
		
		//Get Assign by
		$assign_by= $assign_task_arr['assign_task_result']['created_by'];
		$this->db->dbprefix('admin');
		$this->db->select('id,first_name,last_name');
		$this->db->where('id',$assign_by);
		$get_admin_by= $this->db->get('admin');
		$admin_by_arr= $get_admin_by->row_array();
		$assign_task_arr['assign_task_result']['assign_by']= $admin_by_arr['first_name']." ".$admin_by_arr['last_name'];
		$assign_task_arr['assign_task_result']['assign_by_id']= $admin_by_arr['id'];
		/*
		echo "<pre>";
		print_r($assign_task_arr['assign_task_result']);
		exit;*/
		
		$project_assign=$project_arr['project_result']['project_assign'];
		
		$assign_arr= explode(',',$project_assign);
		$user_id = $this->session->userdata('admin_id');
		
		if(!in_array($user_id, $assign_arr)){
			
			return false;
			
		}else{
			
		
		$assign_task_arr['assign_task_result']['project_title']=$project_arr['project_result']['project_title'];
		
		//Get Project Attachments
		$this->db->dbprefix('project_task_attachments');
		$this->db->where('project_task_id',$assign_task_id);
		$get_assign_task_attachments= $this->db->get('project_task_attachments');
		
		$assign_task_arr['assign_task_attachments'] = $get_assign_task_attachments->result_array();
		$assign_task_arr['assign_task_attachments_count'] = $get_assign_task_attachments->num_rows;
		
	
	  
		return $assign_task_arr;	
			
		}
		
	
		
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
		    'description' => $this->db->escape_str(trim($description)),
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
			$config['allowed_types'] = 'jpg|jpeg|gif|tiff|tif|png|doc|docx|xls|xlsx|pdf|txt|zip|rar|odt|csv|pptx|ppt';
			$config['max_size']	= '15000';
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
		
		//Get Task Record
	    $this->db->dbprefix('project_task');
	    $this->db->where('id',$assign_task_id);
	    $get= $this->db->get('project_task');
	    $get_arr= $get->row_array();
		
		if($status==1){
			
			$previous_status= $get_arr['status'];
			
			if($previous_status==1){
				
			 return $error = array('start_error' =>"Oops! Project task is already started.");	
				
			}
		
		}
		
	    $project_id=$get_arr['project_id'];
		
		//Get project record
		$this->db->dbprefix('projects');
	    $this->db->where('id',$project_id);
	    $get_project_arr= $this->db->get('projects');
	    $get_project= $get_project_arr->row_array();
	    $project_name=$get_project['project_title'];
		
		$assign_to=$get_project['project_assign'];
		$user_id= explode(',',$assign_to); 
		
	    $task_title= $get_arr['title'];
		
	  if($status=='1')	
	  {	
	  
	     //Check if already Start Task
	    $this->db->dbprefix('project_task');
		$this->db->where('status',1);
	    $get_project_task= $this->db->get('project_task');
	    $get_project_task_arr= $get_project_task->result_array();
		
		for($k=0;$k<count($get_project_task_arr);$k++){
		
			
		$explode_arr = explode(',',$get_project_task_arr[$k]['user_id']);
		
		//$user_id=$this->session->userdata('admin_id');
			
				if(in_array($this->session->userdata('admin_id'),$explode_arr))
				{
					 return $error = array('already_start_task' =>"One of your previous task is already started. Please close/hold your existing started task and then try again.
");	
				}
		}
	
	
	//Update TaskTime
	//echo $task_start_date= $get_arr['start_date'];
	
	$task_start_date = strtotime($get_arr['start_date']);
	//$task_start_date = strtotime('2015-01-22 11:40:00');
	
	$now_time = time();
	
	$subTime = $now_time - $task_start_date;
	
	$y = ($subTime/(60*60*24*365));
	$d = ($subTime/(60*60*24))%365;
	$h = ($subTime/(60*60))%24;
	
	$m = ($subTime/60)%60;
	
	$task_start_date= date('Y-m-d H:i:s',$now_time);
	
	if($h>0 or $m>0){
	
	     $ontime_start=0;
		
	}else{
		
		 $ontime_start=1;	
		
	}
	
	//echo "Difference between ".date('Y-m-d H:i:s',$task_start_date)." and ".date('Y-m-d H:i:s',$now_time)." is:\n";
	
	
	//echo $y." years\n";
	//echo $d." days\n";
	//echo $h." hours\n";
	//echo $m." minutes\n";
	//exit;
	
	    //Send Message to Assign Task Users
		//Update Task Record
		$upd_data = array(
			    'status' => $this->db->escape_str(trim($status)),
				'task_started_by' => $this->db->escape_str(trim($created_by)),
				'task_started_date' => $this->db->escape_str(trim($task_start_date)),
				'ontime_start' => $this->db->escape_str(trim($ontime_start))
			 );	
			 	
		$this->db->dbprefix('project_task');
		$this->db->where('id',$assign_task_id);
		$get= $this->db->update('project_task',$upd_data);
		
		
	/*	for($j=0;$j<count($user_id); $j++){
			
			
			//Mesage id Generator
		    $message_id = $this->mod_common->random_number_generator(7);
		    $message_id = $this->mod_projects->message_id_generator($message_id);
		 
			
			$subject='Project Task Started For Project (<b> <a href='.SURL.'projects/manage-projects/project-detail/'.$project_id.' target="_blank" > '.$project_name.'</a></b>)';
			$message="Project Task  <b>(<a href='".SURL."projects/manage-projects/assign-task-detail/".$assign_task_id."' title='Click for task detail' target='_blank'>".$task_title."</a>)</b> is Initiated on ".date("d, M Y h:i:s a", strtotime($created_date));
			
			
			$to_user = $user_id[$j];
			
			
			 $ins_msg_data = array(
		    'to' => $this->db->escape_str(trim($user_id[$j])),
		    'from' => $this->db->escape_str(trim($created_by)),
		    'subject' => $this->db->escape_str(trim($subject)),
			'message' => $this->db->escape_str(trim($message)),
		    'message_id' => $this->db->escape_str(trim($message_id)),
		    'created_by' => $this->db->escape_str(trim($created_by)),
		    'date' => $this->db->escape_str(trim($created_date)),
		    'created_by_ip' => $this->db->escape_str(trim($created_by_ip)),
			'notification' => $this->db->escape_str(trim(1))
		    );		

			 if($to_user !=$this->session->userdata('admin_id')){
				   //Inserting the record into the database.
				  $this->db->dbprefix('messages');
				  $ins_into_db = $this->db->insert('messages', $ins_msg_data);
			  
			  }
		}//End For*/
	  
	  
	   //Send Message to Project Detail Message Board::
	    $customer_id=$get_project['customer_id'];
		
	    $subject='Project Task Started For Project (<b> <a href='.SURL.'projects/manage-projects/project-detail/'.$project_id.' target="_blank" > '.$project_name.'</a></b>)';
			
		$message="Project Task  <b>(<a href='".SURL."projects/manage-projects/assign-task-detail/".$assign_task_id."' title='Click for task detail' target='_blank'>".$task_title."</a>)</b> is Initiated on ".date("d, M Y h:i:s a", strtotime($created_date));
		
		
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
		   
		   $task_started_by= $get_arr['task_started_by'];
		   
		   if($task_started_by != $created_by){
			   
			 return $error = array('hold_error' =>"Oops! Only who started the task can hold this task.");	 
			    
		    }
			
			
			//Update Task Record
			$upd_data = array(
					'status' => $this->db->escape_str(trim($status)),
					'task_started_by' => $this->db->escape_str(trim($created_by)),
					'task_started_date' => $this->db->escape_str(trim($created_date))
				 );	
					
			$this->db->dbprefix('project_task');
			$this->db->where('id',$assign_task_id);
			$get= $this->db->update('project_task',$upd_data);
			
		   
	 
	  
	      //Send Message to Assign Task Users
	  
	 /* echo"<pre>";
	  print_r($user_id);
	  exit;*/
		
	/*	for($j=0;$j<count($user_id); $j++){
			
			//Mesage id Generator
		    $message_id = $this->mod_common->random_number_generator(7);
		    $message_id = $this->mod_projects->message_id_generator($message_id);
		 
			
			$subject='Task Hold For Project (<b> <a href='.SURL.'projects/manage-projects/project-detail/'.$project_id.' target="_blank"> '.$project_name.'</a></b>)';
		
			$message="Project Task <b>(<a href='".SURL."projects/manage-projects/assign-task-detail/".$assign_task_id."' title='Click for task detail' target='_blank'> ".$task_title." </a>)</b>  is Hold for Reason ".$reason. " on ".date("d, M Y h:i:s a", strtotime($created_date));
			
			 $ins_msg_data = array(
		    'to' => $this->db->escape_str(trim($user_id[$j])),
		    'from' => $this->db->escape_str(trim($created_by)),
		    'subject' => $this->db->escape_str(trim($subject)),
			'message' => $this->db->escape_str(trim($message)),
		    'message_id' => $this->db->escape_str(trim($message_id)),
		    'created_by' => $this->db->escape_str(trim($created_by)),
		    'date' => $this->db->escape_str(trim($created_date)),
		    'created_by_ip' => $this->db->escape_str(trim($created_by_ip)),
			'notification' => $this->db->escape_str(trim(1))
		    );		

          if($user_id[$j]!= $this->session->userdata('admin_id')){
			   //Inserting the record into the database.
			  $this->db->dbprefix('messages');
			  $ins_into_db = $this->db->insert('messages', $ins_msg_data);
		  }
			
		}//End For*/
		
		 //Send Message to Project Detail Message Board::
	    $customer_id=$get_project['customer_id'];
		
		$subject='Task Hold For Project (<b> <a href='.SURL.'projects/manage-projects/project-detail/'.$project_id.' target="_blank"> '.$project_name.'</a></b>)';
		
		$message="Project Task <b>(<a href='".SURL."projects/manage-projects/assign-task-detail/".$assign_task_id."' title='Click for task detail' target='_blank'> ".$task_title." </a>)</b>  is Hold for Reason ".$reason. " on ".date("d, M Y h:i:s a", strtotime($created_date));
		
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
		
	  
	  }//end if project status is 2
	  
	  if($status=='3')	
	  {	
	  
	       $task_started_by= $get_arr['task_started_by'];
		   
		   if($task_started_by != $created_by){
			   
			 return $error = array('closed_error' =>"Oops! Only who started the task can close this task.");	 
			    
		    }
			
		  
	  //Update TaskTime
     $task_start_date= $get_arr['start_date'];
	 
	 
	 $task_end_date = strtotime($get_arr['end_date']);
	 
	 
	 
	//echo "2015-01-26 19:30:00<br />"; 
	
	//$task_end_date= strtotime('2015-03-07 17:10:00');
	 
	 //echo date('Y-m-d G:i:s')."<br />";
	 
	 
    $now_time = strtotime(date('Y-m-d G:i:s'));
	
	
	$subTime = $now_time - $task_end_date;
	
	$y = ($subTime/(60*60*24*365));
	$d = ($subTime/(60*60*24))%365;
	$h = ($subTime/(60*60))%24;
	
	$m = ($subTime/60)%60;
	
	$task_close_date= date('Y-m-d H:i:s',$now_time);
	
	
	//echo $d." Days<br />";
	//echo $h." hours <br />";
//	echo $m." mints <br />";
   

	if($d<=0 and $h<=0 and $m<= -30){
		
	 $rating= 6;	
		
	}elseif($d<=0 and $h<=0 and $m<=0){
		
	 $rating= 6;	
		
	}
	elseif($d==0 and $h<0){
		
	 $rating= 6;	
		
	}elseif($d==0 and $h==0 and $m<=30){
		
	  
	$rating= 5;	
		
	}elseif($d==0 and $h==0 and $m<59){
	 	
	  $rating=4.5;
	  	
	}elseif($d==0 and $h==1){
		
	  $rating=4;	
	  
	}elseif($d==0 and $h==2){
		
	  $rating=3.5;	
	  
	}elseif($d==0 and $h==3){
		
	  $rating=3;	
	  
	}elseif($d==0 and $h==4){
		
	  $rating=2.5;	
	  
	}elseif($d==0 and $h==5){
		
	  $rating=2;	
	  
	}elseif($d==0 and $h==6){
		
	  $rating=1.5;	
	  
	}elseif($d==0 and $h==7){
		
	  $rating=1;	
	  
	}else{
		
	   $rating=0;	
	}
	


	
	if($h>0 or $m>0){
	
	     $ontime_closed=0;
		 
		
	}else{
		
		 $ontime_closed=1;
		
	}
  		
//echo "Rating => ".$rating;
//exit;
	  
	    $admin_user_id=$get_arr['user_id'];
	    //Get admin user name
	    $this->db->dbprefix('admin');
	    $this->db->where('id',$admin_user_id);
	    $get_admin= $this->db->get('admin');
	    $get_admin_arr= $get_admin->row_array();
		
		$admin_name= $get_admin_arr['display_name'];
	   
	    
	   //Send Task Rating Notification
	   $notification_team= $this->mod_common->assign_project_users();
	  
		for($j=0;$j<count($notification_team); $j++){
			
			//Mesage id Generator
		    $message_id = $this->mod_common->random_number_generator(7);
		    $message_id = $this->mod_projects->message_id_generator($message_id);
		 
			$subject='Task Rating awarded for task ('.$task_title.')';
			
		    $message= $rating ." Rating is awarded to ".$admin_name." against Project Task(".$task_title."). To Approve this Rating please go to Task Detail page on Click the link below <br /><br /> <a class='anchor_style' href='".SURL."projects/manage-projects/assign-task-detail/".$assign_task_id."'>Click Here</a>";
			
			 $ins_msg_data = array(
		    'to' => $this->db->escape_str(trim($notification_team[$j])),
		    'from' => $this->db->escape_str(trim($created_by)),
		    'subject' => $this->db->escape_str(trim($subject)),
			'message' => $this->db->escape_str(trim($message)),
		    'message_id' => $this->db->escape_str(trim($message_id)),
		    'created_by' => $this->db->escape_str(trim($created_by)),
		    'date' => $this->db->escape_str(trim($created_date)),
		    'created_by_ip' => $this->db->escape_str(trim($created_by_ip)),
			'notification' => $this->db->escape_str(trim(2))
		    );		
			
			   //Inserting the record into the database.
			  $this->db->dbprefix('messages');
			  $ins_into_db = $this->db->insert('messages', $ins_msg_data);
		
		}//End For Send task rating notification
	  
	  
		  //Update Task Record
			$upd_data = array(
					'status' => $this->db->escape_str(trim($status)),
					'task_started_by' => $this->db->escape_str(trim($created_by)),
					'task_close_date' => $this->db->escape_str(trim($task_close_date)),
					'ontime_closed' => $this->db->escape_str(trim($ontime_closed)),
					'rating' => $this->db->escape_str(trim($rating)),
					'rating_status' => $this->db->escape_str(trim(1))
				 );	
					
			$this->db->dbprefix('project_task');
			$this->db->where('id',$assign_task_id);
			$get= $this->db->update('project_task',$upd_data);
			
			 
		 
	    //Send Message to Assign Task Users
		/*for($j=0;$j<count($user_id); $j++){
			
			
			//Mesage id Generator
		    $message_id = $this->mod_common->random_number_generator(7);
		    $message_id = $this->mod_projects->message_id_generator($message_id);
		 
			
			$subject='Task Closed For Project (<b> <a href='.SURL.'projects/manage-projects/project-detail/'.$project_id.' target="_blank" > '.$project_name.'</a></b>)';
			$message="Project Task <b>(<a href='".SURL."projects/manage-projects/assign-task-detail/".$assign_task_id."' title='Click for task detail' target='_blank'>".$task_title."</a>)</b>  is Closed on ".date("d, M Y h:i:s a", strtotime($created_date));
			
			 $ins_msg_data = array(
		    'to' => $this->db->escape_str(trim($user_id[$j])),
		    'from' => $this->db->escape_str(trim($created_by)),
		    'subject' => $this->db->escape_str(trim($subject)),
			'message' => $this->db->escape_str(trim($message)),
		    'message_id' => $this->db->escape_str(trim($message_id)),
		    'created_by' => $this->db->escape_str(trim($created_by)),
		    'date' => $this->db->escape_str(trim($created_date)),
		    'created_by_ip' => $this->db->escape_str(trim($created_by_ip)),
			'notification' => $this->db->escape_str(trim(1))
		    );		
			
	     if($user_id[$j] !=$this->session->userdata('admin_id')){
			   //Inserting the record into the database.
			  $this->db->dbprefix('messages');
			  $ins_into_db = $this->db->insert('messages', $ins_msg_data);
		 }
			
		}//End For*/
		
		 //Send Message to Project Detail Message Board::
	    $customer_id=$get_project['customer_id'];
		
		$subject='Task Closed For Project (<b> <a href='.SURL.'projects/manage-projects/project-detail/'.$project_id.' target="_blank" > '.$project_name.'</a></b>)';
			
			
		$message="Project Task <b>(<a href='".SURL."projects/manage-projects/assign-task-detail/".$assign_task_id."' title='Click for task detail' target='_blank'>".$task_title."</a>)</b>  is Closed on ".date("d, M Y h:i:s a", strtotime($created_date));
		
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
	  
	  }//end if project status is 3.
	  
	  
	   if($status=='4')	
	  {	
	  
	       $task_started_by= $get_arr['task_started_by'];
		   
		   if($task_started_by != $created_by){
			   
			 return $error = array('closed_error' =>"Oops! Only who started the task can resume this task again.");	 
			    
		    }
			
	
		  //Update Task Record
			$upd_data = array(
					'status' => $this->db->escape_str(trim($status)),
					'task_started_by' => $this->db->escape_str(trim($created_by)),
					'task_started_date' => $this->db->escape_str(trim($created_date))
				 );	
					
			$this->db->dbprefix('project_task');
			$this->db->where('id',$assign_task_id);
			$get= $this->db->update('project_task',$upd_data);
			
			 
		 
	    //Send Message to Assign Task Users
		/*for($j=0;$j<count($user_id); $j++){
			
			
			//Mesage id Generator
		    $message_id = $this->mod_common->random_number_generator(7);
		    $message_id = $this->mod_projects->message_id_generator($message_id);
		 
			
			$subject='Task Resume For Project (<b> <a href='.SURL.'projects/manage-projects/project-detail/'.$project_id.' target="_blank" > '.$project_name.'</a></b>) ';
			$message="Project Task <b>(<a href='".SURL."projects/manage-projects/assign-task-detail/".$assign_task_id."' title='Click for task detail' target='_blank'>".$task_title."</a>)</b>  is resume again on ".date("d, M Y h:i:s a", strtotime($created_date));
			
			 $ins_msg_data = array(
		    'to' => $this->db->escape_str(trim($user_id[$j])),
		    'from' => $this->db->escape_str(trim($created_by)),
		    'subject' => $this->db->escape_str(trim($subject)),
			'message' => $this->db->escape_str(trim($message)),
		    'message_id' => $this->db->escape_str(trim($message_id)),
		    'created_by' => $this->db->escape_str(trim($created_by)),
		    'date' => $this->db->escape_str(trim($created_date)),
		    'created_by_ip' => $this->db->escape_str(trim($created_by_ip)),
			'notification' => $this->db->escape_str(trim(1))
		    );		
			
	     if($user_id[$j] !=$this->session->userdata('admin_id')){
			   //Inserting the record into the database.
			  $this->db->dbprefix('messages');
			  $ins_into_db = $this->db->insert('messages', $ins_msg_data);
		 }
			
		}//End For*/
		
		 //Send Message to Project Detail Message Board::
	    $customer_id=$get_project['customer_id'];
		
		$subject='Task Resume For Project (<b> <a href='.SURL.'projects/manage-projects/project-detail/'.$project_id.' target="_blank" > '.$project_name.'</a></b>) ';
			
		$message="Project Task <b>(<a href='".SURL."projects/manage-projects/assign-task-detail/".$assign_task_id."' title='Click for task detail' target='_blank'>".$task_title."</a>)</b>  is resume again on ".date("d, M Y h:i:s a", strtotime($created_date));
			
		
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
	  
	  }//end if project status is 4.
	  
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
				'feedback' => $this->db->escape_str(trim($feedback)),
				'project_rating' => $this->db->escape_str(trim($project_rating))
			 );		
		
		//Update Record
		$this->db->dbprefix('projects');
		$this->db->where('id',$project_id);
		$get= $this->db->update('projects',$upd_data);
		
		
		return true;
	}//End Project_action
	
	
	public function get_total_task_timings($project_id){
		
		/* $this->db->dbprefix('project_task');
		 $this->db->select('total_time,task_started_date,task_close_date');
		 $this->db->where('project_id',$project_id);
		 $get_task_arr= $this->db->get('project_task');
         //echo $this->db->last_query();exit;*/
		 
		$get_task_arr= $this->db->query("SELECT sum(TIMESTAMPDIFF(MINUTE,start_date,end_date)) as allocatedtime, sum(TIMESTAMPDIFF(MINUTE,task_started_date,task_close_date)) as consumedtime FROM `inno_project_task` WHERE project_id=".$project_id."");
		 
		 $project_tasks = $get_task_arr->row_array();
		 
		/*echo "<pre>";
		print_r($project_tasks);
		exit;
	*/
		
		 if($project_tasks['allocatedtime'] >=60){ 
								 
				   $total_hours= floor($project_tasks['allocatedtime'] / 60);
				   
				   $total_mints= ($project_tasks['allocatedtime'] % 60);
				   
				   $allocatedtime=  $total_hours.":".$total_mints;
				
			 }else{
				 
				  $allocatedtime= "00:".$project_tasks['allocatedtime']; 
			
		}
			
			
		if($project_tasks['consumedtime'] >=60){ 
			 
			   $consumed_hours= floor($project_tasks['consumedtime'] / 60);
			
			   $consumed_mints = ($project_tasks['consumedtime']  % 60);
			 
			   $consumedtime= $consumed_hours.":".$consumed_mints;
			 
			   
			 }else{
				 
				$consumedtime= "00:".$project_tasks['consumedtime'];
			
		}	
		
		
		
		$project_task_arr['total_task_time']=$allocatedtime;
		
		
		$project_task_arr['total_task_consumed_time']=$consumedtime;	
		
		
		return $project_task_arr;
		
	}
	
	
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
		 
		 
		
		$get_total_task_timings = $this->mod_projects->get_total_task_timings($project_id);
		 
		$project_task_arr['total_task_time']=$get_total_task_timings['total_task_time'];
		$project_task_arr['total_task_consumed_time']=$get_total_task_timings['total_task_consumed_time'];
		
		
		/*echo "<pre>";
		print_r( $project_task_arr);
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
					$row_assign_task['assign_task_filter'][$h]['total_time'] = $row_assign_task_arr['assign_task_arr'][$k]['total_time'] ;
					
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
					
					$row_assign_task['assign_task_filter'][$h]['total_time'] = $row_assign_task_arr['assign_task_arr'][$k]['total_time'] ;
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
					$row_assign_task['assign_task_filter'][$h]['rating'] = $row_assign_task_arr['assign_task_arr'][$k]['rating'] ;
					$row_assign_task['assign_task_filter'][$h]['rating_status'] = $row_assign_task_arr['assign_task_arr'][$k]['rating_status'] ;
					
					
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
			
		
		$get_project_task = $this->db->query("SELECT (TIMESTAMPDIFF(MINUTE,inno_project_task.start_date,inno_project_task.end_date)) as allocatedtime, (TIMESTAMPDIFF(MINUTE,inno_project_task.task_started_date,inno_project_task.task_close_date)) as consumedtime, inno_project_task.title,inno_project_task.id,inno_project_task.start_date,inno_project_task.end_date,inno_project_task.rating,inno_project_task.rating_status,inno_project_task.created_date,inno_project_task.user_id,inno_project_task.status,inno_project_task.task_started_date,inno_project_task.task_close_date,inno_project_task.total_time, inno_projects.project_title FROM `inno_project_task` join inno_projects on inno_projects.id= inno_project_task.project_id  WHERE inno_project_task.status=".$status." AND inno_project_task.project_id=".$project_id."  ");
		
		//echo $this->db->last_query();
		
		}else{
		
	
		$get_project_task = $this->db->query("SELECT (TIMESTAMPDIFF(MINUTE,inno_project_task.start_date,inno_project_task.end_date)) as allocatedtime, (TIMESTAMPDIFF(MINUTE,inno_project_task.task_started_date,inno_project_task.task_close_date)) as consumedtime, inno_project_task.title,inno_project_task.id,inno_project_task.start_date,inno_project_task.end_date,inno_project_task.rating,inno_project_task.rating_status,inno_project_task.created_date,inno_project_task.user_id,inno_project_task.status,inno_project_task.task_started_date,inno_project_task.task_close_date,inno_project_task.total_time, inno_projects.project_title FROM `inno_project_task` join inno_projects on inno_projects.id= inno_project_task.project_id  WHERE inno_project_task.project_id=".$project_id."  ");
		
		//echo $this->db->last_query();
		
		}
		
		$row_project_task_arr['project_task_arr'] = $get_project_task->result_array();
		$row_project_task_arr['project_task_count'] = $get_project_task->num_rows();
		
		  
		/*echo "<pre>";
		print_r( $row_assign_task_arr['assign_task_arr']);
		exit;*/
		
	
		return $row_project_task_arr;		
		
	}//end get_project_task
	
	
	public function get_project_team($project_id){
		
		$this->db->dbprefix('projects');
		$this->db->select(project_assign);
		$this->db->where('id',$project_id);
		$get_team_list = $this->db->get('projects');
		$row_team_list= $get_team_list->row_array();
		
		$project_team= explode(',',$row_team_list['project_assign']);
		
		$row_project_team= array();
		
		for($i=0; $i<count($project_team); $i++){
			
			$user_id=$project_team[$i];
			
			$this->db->dbprefix('admin');
			$this->db->select('id,display_name');
			$this->db->where('id',$user_id);
			$get_user = $this->db->get('admin');
			$row_user= $get_user->row_array();
			
			$row_project_team[$i]['id']= $row_user['id'];
			$row_project_team[$i]['name']= $row_user['display_name'];
				
			
		}
		
	/*	echo "<pre>";
		print_r($row_project_team);
		exit;
		*/
		
		return $row_project_team;		
		
	}//end get_states
	
	
	//Get Start Task Report
	public function get_tasks_report(){
		
		
		//echo $today_date = date('Y-m-d');
		//exit;
		
		 if($this->input->post('search_date') !="")
		{
			
		    $search_date = date('Y-m-d',strtotime($_POST['search_date']));
			  $where="(status=1 or status=4)";
		   
			$this->db->dbprefix('project_task');
			$this->db->where( $where);
			$this->db->like('task_started_date',$search_date);
			$this->db->order_by('task_started_date',DESC);
		    ///echo $this->db->last_query();exit;
			
	   }else{
		   
		    $where="(status=1 or status=4)";
		   
		    $this->db->dbprefix('project_task');
			$this->db->where( $where);
			//$this->db->or_where('status',4);
			$this->db->like('task_started_date',date('d'));
			$this->db->order_by('task_started_date',DESC);
			//echo $this->db->last_query();exit;
		   
		 }
		
		
		$get_task_report = $this->db->get('project_task');
		$row_task_report= $get_task_report->result_array();
	    //echo $this->db->last_query();exit;
		
		for($i=0; $i<count($row_task_report); $i++){
			
			//Get Project Name
		    $project_id=$row_task_report[$i]['project_id'];
		    $this->db->dbprefix('projects');
			$this->db->select('id,project_title');
			$this->db->where('id',$project_id);
			$get_project = $this->db->get('projects');
			$row_project= $get_project->row_array();
			$project_id=$row_project['id'];
			$project_name=$row_project['project_title'];
			$row_task_report[$i]['project_id']=$project_id;
			$row_task_report[$i]['project_name']=$project_name;
			
			//Get User Name
		    $user_id=$row_task_report[$i]['task_started_by'];
		    $this->db->dbprefix('admin');
			$this->db->select('id,first_name,last_name');
			$this->db->where('id',$user_id);
			$get_user = $this->db->get('admin');
			$row_user= $get_user->row_array();
			$user_id=$row_user['id'];
			$user_name=$row_user['first_name'].$row_user['last_name'];
			$row_task_report[$i]['user_name']=$user_name;
			$row_task_report[$i]['user_id']=$user_id;
		
		}
		
		
		/*echo "<pre>";
		print_r($row_task_report);
		exit;*/
		
		
		return $row_task_report;		
		
	}//end get_tasks_report
	
	//Get Hold Task Report
	public function get_hold_tasks_report(){
		
		//echo $today_date = date('Y-m-d');
		//exit;
		
		 if($this->input->post('search_date') !="")
		{
			
		    $search_date = date('Y-m-d',strtotime($_POST['search_date']));
		   
			$this->db->dbprefix('project_task');
			$this->db->where('status',2);
			$this->db->like('task_started_date',$search_date);
			$this->db->order_by('task_started_date',DESC);
		//	echo $this->db->last_query();exit;
			
	   }else{
		   
		    $this->db->dbprefix('project_task');
			$this->db->where('status',2);
			$this->db->like('task_started_date',date('d'));
			$this->db->order_by('task_started_date',DESC);
		   
		 }
		
		
		$get_task_report = $this->db->get('project_task');
		$row_task_report= $get_task_report->result_array();
	    //echo $this->db->last_query();exit;
		
		for($i=0; $i<count($row_task_report); $i++){
			
			//Get Project Name
		    $project_id=$row_task_report[$i]['project_id'];
		    $this->db->dbprefix('projects');
			$this->db->select('id,project_title');
			$this->db->where('id',$project_id);
			$get_project = $this->db->get('projects');
			$row_project= $get_project->row_array();
			$project_id=$row_project['id'];
			$project_name=$row_project['project_title'];
			$row_task_report[$i]['project_id']=$project_id;
			$row_task_report[$i]['project_name']=$project_name;
			
			//Get User Name
		    $user_id=$row_task_report[$i]['task_started_by'];
		    $this->db->dbprefix('admin');
			$this->db->select('id,first_name,last_name');
			$this->db->where('id',$user_id);
			$get_user = $this->db->get('admin');
			$row_user= $get_user->row_array();
			$user_id=$row_user['id'];
			$user_name=$row_user['first_name'].$row_user['last_name'];
			$row_task_report[$i]['user_name']=$user_name;
			$row_task_report[$i]['user_id']=$user_id;
		
		}
		
		
		/*echo "<pre>";
		print_r($row_task_report);
		exit;*/
		
		
		return $row_task_report;		
		
	}//end get_hold_tasks_report
	
	//Get Closed Task Report
	public function get_closed_tasks_report(){
		
		//echo $today_date = date('Y-m-d');
		//exit;
		
		 if($this->input->post('search_date') !="")
		{
			
		    $search_date = date('Y-m-d',strtotime($_POST['search_date']));
		   
			$this->db->dbprefix('project_task');
			$this->db->where('status',3);
			$this->db->like('task_started_date',$search_date);
			$this->db->order_by('task_started_date',DESC);
		//	echo $this->db->last_query();exit;
			
	   }else{
		   
		    $this->db->dbprefix('project_task');
			$this->db->where('status',3);
			$this->db->like('task_started_date',date('d'));
			$this->db->order_by('task_started_date',DESC);
		   
		 }
		
		
		$get_task_report = $this->db->get('project_task');
		$row_task_report= $get_task_report->result_array();
	    //echo $this->db->last_query();exit;
		
		for($i=0; $i<count($row_task_report); $i++){
			
			//Get Project Name
		    $project_id=$row_task_report[$i]['project_id'];
		    $this->db->dbprefix('projects');
			$this->db->select('id,project_title');
			$this->db->where('id',$project_id);
			$get_project = $this->db->get('projects');
			$row_project= $get_project->row_array();
			$project_id=$row_project['id'];
			$project_name=$row_project['project_title'];
			$row_task_report[$i]['project_id']=$project_id;
			$row_task_report[$i]['project_name']=$project_name;
			
			//Get User Name
		    $user_id=$row_task_report[$i]['task_started_by'];
		    $this->db->dbprefix('admin');
			$this->db->select('id,first_name,last_name');
			$this->db->where('id',$user_id);
			$get_user = $this->db->get('admin');
			$row_user= $get_user->row_array();
			$user_id=$row_user['id'];
			$user_name=$row_user['first_name'].$row_user['last_name'];
			$row_task_report[$i]['user_name']=$user_name;
			$row_task_report[$i]['user_id']=$user_id;
		
		}
		
		
		/*echo "<pre>";
		print_r($row_task_report);
		exit;*/
		
		
		return $row_task_report;		
		
	}//end get_closed_tasks_report
	
	
   //show_all_tasks
	public function show_all_tasks(){
		
		if($this->input->post('search_status')!=""){
			
		 $get_all_task= $this->db->query('SELECT (TIMESTAMPDIFF(MINUTE,start_date,end_date)) as allocatedtime, TIMESTAMPDIFF(MINUTE,task_started_date,task_close_date) as consumedtime,id, title,start_date,end_date,rating,rating_status,created_date,user_id,project_id,status,task_started_date,task_close_date,total_time FROM inno_project_task WHERE status='.$this->input->post('search_status').' order by id DESC');
			
			
			
		}else{
		
	   $get_all_task= $this->db->query('SELECT (TIMESTAMPDIFF(MINUTE,start_date,end_date)) as allocatedtime, TIMESTAMPDIFF(MINUTE,task_started_date,task_close_date) as consumedtime, id, title,start_date,end_date,rating,rating_status,created_date,user_id,project_id,status,task_started_date,task_close_date,total_time FROM inno_project_task order by id DESC');
		
		}
		
		
		//echo $this->db->last_query();
		$row_all_task['all_tasks_arr'] = $get_all_task->result_array();
		$row_all_task['all_tasks_count'] = $get_all_task->num_rows;

		for($i=0; $i<$row_all_task['all_tasks_count']; $i++){
			
			//Get Project Name
		    $project_id=$row_all_task['all_tasks_arr'][$i]['project_id'];
		    $this->db->dbprefix('projects');
			$this->db->select('id,project_title');
			$this->db->where('id',$project_id);
			$get_project = $this->db->get('projects');
			$row_project= $get_project->row_array();
			$project_id=$row_project['id'];
			$project_name=$row_project['project_title'];
			$row_all_task['all_tasks_arr'][$i]['project_id']=$project_id;
			$row_all_task['all_tasks_arr'][$i]['project_name']=$project_name;
			
		}
		
		
	
		return $row_all_task;
		
	}//end show_all_tasks
	
	
	//project_workspace
	public function project_workspace($data, $project_id){
		
		/*echo $project_id;
		exit;
		print_r($_FILES);
		exit;*/
		
	
		$created_date = date('Y-m-d G:i:s');
		$created_by_ip = $this->input->ip_address();
		$created_by = $this->session->userdata('admin_id');
		
		//Uploading attachment
		if($_FILES['file']['name'] != ''){
			
		 //$file_name= $_FILES["file"]['name'];
			
		    $projects_folder_path = '../assets/project_attachments/'.$project_id;
			 
			 if(!is_dir($projects_folder_path))
			 mkdir($projects_folder_path,0777);
			 
			 //copy('../assets/img/index.html','../assets/project_attachments/'.$project_id.'/index.html');
			 
			 $attach_name=str_replace(' ','_',$_FILES['file']['name']);
			  		
		     $attachment_name = "project_".$project_id.'_'.$attach_name; 
			

			$config['upload_path'] = $projects_folder_path;
			$config['allowed_types'] = 'jpg|jpeg|gif|tiff|tif|png|doc|docx|xls|xlsx|pdf|txt|zip|rar|odt|csv|pptx|ppt';
			$config['max_size']	= '15000';
			$config['overwrite'] = true;
			$config['file_name'] = $attachment_name;
			
			$this->load->library('upload', $config);
			
			
			if(!$this->upload->do_upload('file')){
				
				 
				$error_file_arr = array('error' => $this->upload->display_errors());
				
				return $error_file_arr;
				
			}
			
		}//end if($_FILES['attachment']['name'] != '')
		

		$ins_data = array(
		   'project_id' => $this->db->escape_str(trim($project_id)),
		   'attachments' => $this->db->escape_str(trim($attachment_name)),
		   'created_date' => $this->db->escape_str(trim($created_date)),
		   'created_by' => $this->db->escape_str(trim($created_by))
		);		

		//Inserting the record into the database.
		$this->db->dbprefix('project_workspace');
		$ins_into_db = $this->db->insert('project_workspace', $ins_data);
		
		//echo $this->db->last_query(); exit;
		return true;
				
	}//end project_workspace
	
	
	//Get Project workspace
	public function get_project_workspace($project_id){
		
	
		$this->db->dbprefix('project_workspace');
		$this->db->where('project_id',$project_id);
		$this->db->order_by('id',DESC);
		$get_project_workspace= $this->db->get('project_workspace');
		
		//echo $this->db->last_query();
		$row_project_workspace['project_workspace_arr'] = $get_project_workspace->result_array();
		$row_project_workspace['project_workspace_count'] = $get_project_workspace->num_rows;
		
		for($i=0; $i<$row_project_workspace['project_workspace_count']; $i++){
			
			//Get admin Name
		    $admin_id=$row_project_workspace['project_workspace_arr'][$i]['created_by'];
		    $this->db->dbprefix('admin');
			$this->db->select('id,display_name');
			$this->db->where('id',$admin_id);
			$get_admin= $this->db->get('admin');
			$row_admin= $get_admin->row_array();
			$admin_id=$row_admin['id'];
			$admin_name=$row_admin['display_name'];
			$row_project_workspace['project_workspace_arr'][$i]['admin_id']=$admin_id;
			$row_project_workspace['project_workspace_arr'][$i]['admin_name']=$admin_name;
			
		}
		
		/*echo "<pre>";
		print_r($row_all_task);
		exit;*/
		
		return $row_project_workspace;
		
	}//end get_project_workspace
	
	

	//Approve Task Rating
	public function approve_task_rating($task_id){
		
		$upd_data = array(
		   'rating_status' => $this->db->escape_str(trim(1))
		);		

		
		$this->db->dbprefix('project_task');
		$this->db->where('id', $task_id);
		$this->db->update('project_task', $upd_data);
		
		return true;
		
	}//end Task approve status
	
	
	//DisApprove Task Rating
	public function disapprove_task_rating($task_id){
		
		
		$this->db->dbprefix('project_task');
		$this->db->where('id',$task_id);
		$get_task= $this->db->get('project_task');
		$row_task = $get_task->row_array();
		
	 	$user_id= $row_task['user_id'];
		$task_title= $row_task['title'];
		
		//Send notification to admin user
		$message_id = $this->mod_common->random_number_generator(7);
		$message_id = $this->mod_projects->message_id_generator($message_id);
		
		$created_by = $this->session->userdata('admin_id');
		
		$subject='Project Task('.$task_title.') Rejected';
		
	 	$message="Project Task <b>(<a href='".SURL."projects/manage-projects/assign-task-detail/".$task_id."' title='Click for task detail' target='_blank'>".$task_title."</a>)</b>  is rejected on ".date("d, M Y h:i:s a", strtotime(date('Y-m-d G:i:s')))." please go to your task section to resume  your task again";
		
		
		 $ins_msg_data = array(
			'to' => $this->db->escape_str(trim($user_id)),
			'from' => $this->db->escape_str(trim($created_by)),
			'subject' => $this->db->escape_str(trim($subject)),
			'message' => $this->db->escape_str(trim($message)),
			'message_id' => $this->db->escape_str(trim($message_id)),
			'created_by' => $this->db->escape_str(trim($created_by)),
			'date' => $this->db->escape_str(trim(date('Y-m-d G:i:s'))),
			'created_by_ip' => $this->db->escape_str(trim($created_by_ip)),
			'notification' => $this->db->escape_str(trim(1))
			);		
		
		   //Inserting the record into the database.
		  $this->db->dbprefix('messages');
		  $ins_into_db = $this->db->insert('messages', $ins_msg_data);
	
		
		$upd_data = array(
		   'status' => $this->db->escape_str(trim(2)),
		   'rating_status' => $this->db->escape_str(trim(2))
		);		

		
		$this->db->dbprefix('project_task');
		$this->db->where('id', $task_id);
		$this->db->update('project_task', $upd_data);
		
	
		return true;
		
	}//end Task approve status
	
	
	//Important project
	public function important_project($project_id){
		
		$upd_data = array(
		   'is_important' => $this->db->escape_str(trim(1))
		);		

		
		$this->db->dbprefix('projects');
		$this->db->where('id', $project_id);
		$this->db->update('projects', $upd_data);
		
		return true;
		
		
		
	}//end Task approve status
	
	
	//Important project
	public function unimportant_project($project_id){
		
		$upd_data = array(
		   'is_important' => $this->db->escape_str(trim(0))
		);		

		
		$this->db->dbprefix('projects');
		$this->db->where('id', $project_id);
		$this->db->update('projects', $upd_data);
		
		return true;
		
	}//end Task approve status
	
	
	//user_add_task
  	public function user_add_task($data){
		
	     extract($data);
		 
		
	   $start_date = date('Y-m-d G:i:s');
	   $end_date = date("Y-m-d H:i:s", strtotime($end_date));
	   
	    $datetime1 = strtotime($start_date);
		$datetime2 = strtotime($end_date);
		$interval  = abs($datetime2 - $datetime1);
		$minutes   = round($interval / 60);
		//echo 'Diff. in minutes is: '.$minutes; 
	
	   
	   $created_date = date('Y-m-d G:i:s');
	   $created_by_ip = $this->input->ip_address();
	   $created_by = $this->session->userdata('admin_id');
	   
	
		   
		//Check if already Start Task
	    $this->db->dbprefix('project_task');
		$this->db->where('status',1);
	    $get_project_task= $this->db->get('project_task');
	    $get_project_task_arr= $get_project_task->result_array();
		
		for($k=0;$k<count($get_project_task_arr);$k++){
		
			
		$explode_arr = explode(',',$get_project_task_arr[$k]['user_id']);
		
		//$user_id=$this->session->userdata('admin_id');
			
				if(in_array($this->session->userdata('admin_id'),$explode_arr))
				{
					 
					 return $error = array('already_start_task' =>"One of your previous task is already started. Please close/hold your existing started task and then try again.
");	
				}
		}
		
		 
		   $ins_data = array(
		    'user_id' => $this->db->escape_str(trim($created_by)),
		    'project_id' => $this->db->escape_str(trim($project_id)),
			'title' => $this->db->escape_str(trim($title)),
		    'start_date' => $this->db->escape_str(trim($start_date)),
			'end_date' => $this->db->escape_str(trim($end_date)),
		    'description' => $this->db->escape_str(trim(nl2br($description))),
			'status' => $this->db->escape_str(trim(1)),
			'task_started_by' => $this->db->escape_str(trim($created_by)),
			'task_started_date' => $this->db->escape_str(trim($start_date)),
			'ontime_start' => $this->db->escape_str(trim(1)),
			'total_time' => $this->db->escape_str(trim($minutes)),
		    'created_by' => $this->db->escape_str(trim($created_by)),
		    'created_date' => $this->db->escape_str(trim($created_date)),
		    'created_by_ip' => $this->db->escape_str(trim($created_by_ip))
		    );		

		   //Inserting the record into the database.
		  $this->db->dbprefix('project_task');
		  $ins_into_db = $this->db->insert('project_task', $ins_data);
		  $project_task_id= $this->db->insert_id();
		  
			
		 if($_FILES['attachments']['name'] !=""){
				 	
		     $projects_folder_path = '../assets/project_attachments/'.$project_id;
			 
			 
			 if(!is_dir($projects_folder_path))
			 
			 mkdir($projects_folder_path,0777);
			 
			 $projects_task_folder_path = '../assets/project_attachments/'.$project_id.'/project_task';
			 
			  if(!is_dir($projects_task_folder_path))
			 
			  mkdir($projects_task_folder_path,0777);
			 
			  copy('../assets/img/index.html','../assets/project_attachments/'.$project_id.'/project_task'.'/index.html');
			
			 $attach_name=str_replace(' ','_',$_FILES['attachments']['name']);			
		     $attachment_name = "project_task_".$project_id.'_'.$attach_name ; 
		   
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
		   
		   
		    $config['upload_path'] = $projects_task_folder_path;
			$config['allowed_types'] = 'jpg|jpeg|gif|tiff|tif|png|doc|docx|xls|xlsx|pdf|txt|zip|rar|odt|csv|pptx|ppt';
			$config['max_size']	= '15000';
			$config['overwrite'] = true;
			$config['file_name'] = $attachment_name;
		
			$this->load->library('upload', $config);

			if(!$this->upload->do_upload('attachments')){
				
				$error_file_arr = array('error' => $this->upload->display_errors());
				
				return $error_file_arr;
				
			}
			//echo $this->db->last_query(); exit;
		 }//End if
		 
		 $event_url=SURL."projects/manage-projects/assign-task-detail/".$project_task_id;
		
		  //Inset Data in Calender Table
		 $this->load->model('common/mod_common');
		
		 $this->mod_common->calendar('project task', $title, $description,$event_url,$start_date,$end_date, $project_task_id, $created_by);
	
		
		//GET Admin Name
		$this->db->dbprefix('admin');
		$this->db->where('id',$created_by);
	    $get_admin= $this->db->get('admin');
		$admin_arr= $get_admin->row_array();
		
		$admin_name= $admin_arr['display_name'];
		 
		/*$this->db->dbprefix('projects');
		$this->db->where('id',$project_id);
	    $get_projects= $this->db->get('projects');
		$project_arr= $get_projects->row_array();
		
	    $project_name= $project_arr['project_title'];
		$project_team_arr = explode(',',$project_arr['project_assign']);*/
		
		
		
		
		/*for($j=0;$j<count($project_team_arr); $j++){
			
			
			//Mesage id Generator
		    $message_id = $this->mod_common->random_number_generator(7);
		    $message_id = $this->mod_projects->message_id_generator($message_id);
		 
		
		 	 $subject="Project Task (<b>".$title."</b>) Added by **".$admin_name." For Project (<b> <a href='".SURL."projects/manage-projects/project-detail/".$project_id."' target='_blank'>".$project_name."</a></b>)";
			
		
			 $message="Project Task  <b>(<a href='".SURL."projects/manage-projects/assign-task-detail/".$project_task_id."' title='Click for task detail' target='_blank'>".$title."</a>)</b> is Initiated on ".date("d, M Y h:i:s a", strtotime($created_date));
			
		
			 $ins_msg_data = array(
				'to' => $this->db->escape_str(trim($project_team_arr[$j])),
				'from' => $this->db->escape_str(trim($created_by)),
				'subject' => $this->db->escape_str(trim($subject)),
				'message' => $this->db->escape_str(trim($message)),
				'message_id' => $this->db->escape_str(trim($message_id)),
				'created_by' => $this->db->escape_str(trim($created_by)),
				'date' => $this->db->escape_str(trim($created_date)),
				'created_by_ip' => $this->db->escape_str(trim($created_by_ip)),
				'notification' => $this->db->escape_str(trim(1))
			);		

			  if($project_team_arr[$j] !=$this->session->userdata('admin_id')){
				   //Inserting the record into the database.
				  $this->db->dbprefix('messages');
				  $ins_into_db = $this->db->insert('messages', $ins_msg_data);
			  
			  }
		}//End For*/
	  
	  
	   //Send Message to Project Detail Message Board::
	    $customer_id=$project_arr['customer_id'];
		
		$subject="Project Task (<b>".$title."</b>) Added by **".$admin_name." For Project (<b> <a href='".SURL."projects/manage-projects/project-detail/".$project_id."' target='_blank'>".$project_name."</a></b>)";
			
		
		$message="Project Task  <b>(<a href='".SURL."projects/manage-projects/assign-task-detail/".$project_task_id."' title='Click for task detail' target='_blank'>".$title."</a>)</b> is Initiated on ".date("d, M Y h:i:s a", strtotime($created_date));
		
		
		
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
		

		
	     return true;
		
		
	}//end user_add_task
	
	
	//inprogress
	public function inprogress_milestone($project_id,$milestone_id){
		
	   $created_date = date('Y-m-d G:i:s');
	   $created_by_ip = $this->input->ip_address();
	   $created_by = $this->session->userdata('admin_id');
		
		//Update Task Record
		$upd_data = array(
				'status' => $this->db->escape_str(trim(1))
			 );	
				
		$this->db->dbprefix('project_milestones');
		$this->db->where('id',$milestone_id);
		$this->db->update('project_milestones',$upd_data);
		
		//Get Project
		$this->db->dbprefix('projects');
		$this->db->where('id',$project_id);
	    $get_projects= $this->db->get('projects');
		$project_arr= $get_projects->row_array();
		
	    $project_name= $project_arr['project_title'];
		
		$project_team_arr = explode(',',$project_arr['project_assign']);
	
		
		//Get Milestone
		$this->db->dbprefix('project_milestones');
		$this->db->where('id',$milestone_id);
	    $get_project_milestones= $this->db->get('project_milestones');
		$project_milestones_arr= $get_project_milestones->row_array();
		
	    $milestone_name= $project_milestones_arr['milestone_name'];
		
		
	
		for($j=0;$j<count($project_team_arr); $j++){
			
			//Mesage id Generator
		    $message_id = $this->mod_common->random_number_generator(7);
		    $message_id = $this->mod_projects->message_id_generator($message_id);
		 
			
			$subject='Project Milestone (<b> '.$milestone_name.'</b>) Inprogress for Project (<b>'.$project_name.'</b>)';
		
		 	$message='Project Milestone (<b> '.$milestone_name.'</b>) Inprogress for Project (<b> <a href='.SURL.'projects/manage-projects/project-detail/'.$project_id.' target="_blank" >'.$project_name. '</a></b>)on '.date('d, M Y h:i:s a', strtotime($created_date)) .' by '.$this->session->userdata('display_name');
			
			 $ins_msg_data = array(
					'to' => $this->db->escape_str(trim($project_team_arr[$j])),
					'from' => $this->db->escape_str(trim($created_by)),
					'subject' => $this->db->escape_str(trim($subject)),
					'message' => $this->db->escape_str(trim($message)),
					'message_id' => $this->db->escape_str(trim($message_id)),
					'created_by' => $this->db->escape_str(trim($created_by)),
					'date' => $this->db->escape_str(trim($created_date)),
					'created_by_ip' => $this->db->escape_str(trim($created_by_ip)),
					'notification' => $this->db->escape_str(trim(3))
				);		

          if($project_team_arr[$j]!= $this->session->userdata('admin_id')){
			   //Inserting the record into the database.
			  $this->db->dbprefix('messages');
			  $ins_into_db = $this->db->insert('messages', $ins_msg_data);
		 }
			
		}
		
		return true;
		
	}//end inprogress_milestone
	
	
	
	public function close_milestone($project_id,$milestone_id){
		
	   $created_date = date('Y-m-d G:i:s');
	   $created_by_ip = $this->input->ip_address();
	   $created_by = $this->session->userdata('admin_id');
		
		//Update Task Record
		$upd_data = array(
				'status' => $this->db->escape_str(trim(2))
			 );	
				
		$this->db->dbprefix('project_milestones');
		$this->db->where('id',$milestone_id);
		$this->db->update('project_milestones',$upd_data);
		
		//Get Project
		$this->db->dbprefix('projects');
		$this->db->where('id',$project_id);
	    $get_projects= $this->db->get('projects');
		$project_arr= $get_projects->row_array();
		
	    $project_name= $project_arr['project_title'];
		
		$project_team_arr = explode(',',$project_arr['project_assign']);
	
		
		//Get Milestone
		$this->db->dbprefix('project_milestones');
		$this->db->where('id',$milestone_id);
	    $get_project_milestones= $this->db->get('project_milestones');
		$project_milestones_arr= $get_project_milestones->row_array();
		
	    $milestone_name= $project_milestones_arr['milestone_name'];
		
		
	
		for($j=0;$j<count($project_team_arr); $j++){
			
			//Mesage id Generator
		    $message_id = $this->mod_common->random_number_generator(7);
		    $message_id = $this->mod_projects->message_id_generator($message_id);
		 
			
			$subject='Project Milestone (<b> '.$milestone_name.'</b>) closed for Project (<b>'.$project_name.'</b>)';
		
		 	$message='Project Milestone (<b> '.$milestone_name.'</b>) closed for Project (<b> <a href='.SURL.'projects/manage-projects/project-detail/'.$project_id.' target="_blank" >'.$project_name. '</a></b>)on '.date('d, M Y h:i:s a', strtotime($created_date)) .' by '.$this->session->userdata('display_name');
			
			 $ins_msg_data = array(
					'to' => $this->db->escape_str(trim($project_team_arr[$j])),
					'from' => $this->db->escape_str(trim($created_by)),
					'subject' => $this->db->escape_str(trim($subject)),
					'message' => $this->db->escape_str(trim($message)),
					'message_id' => $this->db->escape_str(trim($message_id)),
					'created_by' => $this->db->escape_str(trim($created_by)),
					'date' => $this->db->escape_str(trim($created_date)),
					'created_by_ip' => $this->db->escape_str(trim($created_by_ip)),
					'notification' => $this->db->escape_str(trim(3))
				);		

          if($project_team_arr[$j]!= $this->session->userdata('admin_id')){
			   //Inserting the record into the database.
			  $this->db->dbprefix('messages');
			  $ins_into_db = $this->db->insert('messages', $ins_msg_data);
		 }
			
		}
		
		return true;
		
	}//end close_milestone
	
	
	
	//reopen milestone
	public function reopen_milestone($project_id,$milestone_id){
		
	   $created_date = date('Y-m-d G:i:s');
	   $created_by_ip = $this->input->ip_address();
	   $created_by = $this->session->userdata('admin_id');
		
		//Update Task Record
		$upd_data = array(
				'status' => $this->db->escape_str(trim(3))
			 );	
				
		$this->db->dbprefix('project_milestones');
		$this->db->where('id',$milestone_id);
		$this->db->update('project_milestones',$upd_data);
		
		//Get Project
		$this->db->dbprefix('projects');
		$this->db->where('id',$project_id);
	    $get_projects= $this->db->get('projects');
		$project_arr= $get_projects->row_array();
		
	    $project_name= $project_arr['project_title'];
		
		$project_team_arr = explode(',',$project_arr['project_assign']);
	
		
		//Get Milestone
		$this->db->dbprefix('project_milestones');
		$this->db->where('id',$milestone_id);
	    $get_project_milestones= $this->db->get('project_milestones');
		$project_milestones_arr= $get_project_milestones->row_array();
		
	    $milestone_name= $project_milestones_arr['milestone_name'];
		
		
	
		for($j=0;$j<count($project_team_arr); $j++){
			
			//Mesage id Generator
		    $message_id = $this->mod_common->random_number_generator(7);
		    $message_id = $this->mod_projects->message_id_generator($message_id);
		 
			
			$subject='Project Milestone (<b> '.$milestone_name.'</b>) ReOpen for Project (<b>'.$project_name.'</b>)';
		
		 	$message='Project Milestone (<b> '.$milestone_name.'</b>) ReOpen for Project (<b> <a href='.SURL.'projects/manage-projects/project-detail/'.$project_id.' target="_blank" >'.$project_name. '</a></b>)on '.date('d, M Y h:i:s a', strtotime($created_date)) .' by '.$this->session->userdata('display_name');
			
			 $ins_msg_data = array(
					'to' => $this->db->escape_str(trim($project_team_arr[$j])),
					'from' => $this->db->escape_str(trim($created_by)),
					'subject' => $this->db->escape_str(trim($subject)),
					'message' => $this->db->escape_str(trim($message)),
					'message_id' => $this->db->escape_str(trim($message_id)),
					'created_by' => $this->db->escape_str(trim($created_by)),
					'date' => $this->db->escape_str(trim($created_date)),
					'created_by_ip' => $this->db->escape_str(trim($created_by_ip)),
					'notification' => $this->db->escape_str(trim(3))
				);		

          if($project_team_arr[$j]!= $this->session->userdata('admin_id')){
			   //Inserting the record into the database.
			  $this->db->dbprefix('messages');
			  $ins_into_db = $this->db->insert('messages', $ins_msg_data);
		 }
			
		}
		
		return true;
		
	}//end reopen_milestone
	
	
	//payment_due
	public function payment_due($project_id){
		
	   $created_date = date('Y-m-d G:i:s');
	   $created_by_ip = $this->input->ip_address();
	   $created_by = $this->session->userdata('admin_id');
		
		//Update Task Record
		$upd_data = array(
				'payment_due' => $this->db->escape_str(trim(1))
			 );	
				
		$this->db->dbprefix('projects');
		$this->db->where('id',$project_id);
		$this->db->update('projects',$upd_data);
		
		
		//////Send Notification
		//Get Project
		$this->db->dbprefix('projects');
		$this->db->where('id',$project_id);
	    $get_projects= $this->db->get('projects');
		$project_arr= $get_projects->row_array();
		
	    $project_name= $project_arr['project_title'];
		$project_id= $project_arr['id'];
		
		$users= $this->mod_common->assign_project_users();
	
		for($j=0;$j<count($users); $j++){
			
			//Mesage id Generator
		    $message_id = $this->mod_common->random_number_generator(7);
		    $message_id = $this->mod_projects->message_id_generator($message_id);
		 
			
		 $subject='Project (<b> '.$project_name.'</b>) Payment Due ';
		
		 $message='Project (<b> <a href='.SURL.'projects/manage-projects/project-detail/'.$project_id.' target="_blank" >'.$project_name. '</a></b>) Payment due.';
			
			 $ins_msg_data = array(
					'to' => $this->db->escape_str(trim($users[$j])),
					'from' => $this->db->escape_str(trim($created_by)),
					'subject' => $this->db->escape_str(trim($subject)),
					'message' => $this->db->escape_str(trim($message)),
					'message_id' => $this->db->escape_str(trim($message_id)),
					'created_by' => $this->db->escape_str(trim($created_by)),
					'date' => $this->db->escape_str(trim($created_date)),
					'created_by_ip' => $this->db->escape_str(trim($created_by_ip)),
					'notification' => $this->db->escape_str(trim(1))
				);		

          if($users[$j]!= $this->session->userdata('admin_id')){
			   //Inserting the record into the database.
			  $this->db->dbprefix('messages');
			  $ins_into_db = $this->db->insert('messages', $ins_msg_data);
		 }
		 
		 
		}
		
		return true;
		
		
	}//payment_due
	
	
	//payment_recieve
	public function payment_recieve($project_id){
		
	   $created_date = date('Y-m-d G:i:s');
	   $created_by_ip = $this->input->ip_address();
	   $created_by = $this->session->userdata('admin_id');
		
		//Update Task Record
		$upd_data = array(
				'payment_due' => $this->db->escape_str(trim(0))
			 );	
				
		$this->db->dbprefix('projects');
		$this->db->where('id',$project_id);
		$this->db->update('projects',$upd_data);
		
		return true;
		
		
	}//payment_recieve
		
	//mzm
	function get_awarded_projects_chart(){
		
		//last 10 days created projects which have an amount and are marked as awarded
		//group by day to show a single ammount per day
			$this->db->dbprefix('projects');
			
			
			$query = "SELECT
					inno_projects.id,
					
						sum(inno_projects.project_amount) as amount,
				 	 inno_projects.received_amount ,
					inno_projects.start_date,
					
					date(inno_projects.created_date) as formated_created_date,
					GROUP_CONCAT(inno_projects.project_title) as project_title
					
					FROM
					inno_projects
					WHERE
					inno_projects.is_awarded = 1 AND
					inno_projects.project_amount > 0 AND
						
					inno_projects.created_date  >= ( CURDATE() - INTERVAL 10 DAY )
					GROUP BY formated_created_date
					ORDER BY inno_projects.created_date

					 "; 
			
			
			$query = $this->db->query($query);
		
	
		
		//echo $this->db->last_query(); 
		$orders_data = $query->result_array();
		return $orders_data;
		
		
	}
	
	
	
		function closing_projects(){
		//closing projects in range for last 5 days plus future 5 days
		
		//last 10 days created projects which have an amount and are marked as awarded
		//group by day to show a single ammount per day
			$this->db->dbprefix('projects');
			
			//inno_projects.is_awarded = 1 AND inno_projects.project_amount > 0 AND
			$query = "SELECT
						inno_projects.id,
						count(inno_projects.id) as project_count,
						Sum(inno_projects.project_amount) AS amount,
						
						
						
						date(end_date) as formated_end_date ,
						GROUP_CONCAT(inno_projects.project_title) as project_title
						
						FROM
											inno_projects
						WHERE

						
												
						inno_projects.end_date  >= ( CURDATE() - INTERVAL 5 DAY ) AND
						inno_projects.end_date  <= ( CURDATE() + INTERVAL 5 DAY )
						
									
						GROUP BY end_date
						ORDER BY end_date


					 "; 
			
			
			$query = $this->db->query($query);
		
	
		
		//echo $this->db->last_query(); 
		$orders_data = $query->result_array();
		return $orders_data;
		
		
	}
	
	
	public function ajax_upload_message_attachments($data){
		
		extract($data);
		
		$created_date= date('Y-m-d G:i:s');
		$created_by_ip= $this->input->ip_address();
		$created_by = $this->session->userdata('admin_id');
		
		
		//Uploading Job Image
		if($_FILES['file']['name'] != ''){
			

			//Create User Directory if not exist
			$msg_material_folder_path = '../assets/project_attachments/'.$project_id;
			
			
			 if(!is_dir($msg_material_folder_path))
			 mkdir($msg_material_folder_path,0777);
			 
			$orignal_file_name = $_FILES['file']['name'];
			$file_ext           = ltrim(strtolower(strrchr($_FILES['file']['name'],'.')),'.'); 	
			
			$rand_num= rand(1, 1000); 
					
			$file_name = 	'file-'.date('YmdGis').$rand_num.".".$file_ext ;
			
			$file_original_name= $_FILES['file']['name'];

			$config['upload_path'] = $msg_material_folder_path;
			$config['allowed_types'] = 'jpg|jpeg|gif|tiff|tif|png|doc|docx|xls|xlsx|pdf|txt|zip|rar|odt|csv|pptx|ppt';
			$config['overwrite'] = true;
			$config['file_name'] = $file_name;
		
			$this->load->library('upload', $config);

			if(!$this->upload->do_upload('file')){
				
				$error_file_arr = array('error' => $this->upload->display_errors());
			
				return $error_file_arr;
				
			}else{

				$data_image_upload = array('upload_image_data' => $this->upload->data());
				
				//Resize the Uploaded Image 800 * 600
				$config_profile['image_library'] = 'gd2';
				$config_profile['source_image'] = $msg_material_folder_path.'/'.$file_name;
				$config_profile['create_thumb'] = TRUE;
				$config_profile['thumb_marker'] = '';
				
				$config_profile['maintain_ratio'] = TRUE;
				$config_profile['width'] = 800;
				$config_profile['height'] = 600;
				
				$this->load->library('image_lib');
				$this->image_lib->initialize($config_profile);
				$this->image_lib->resize();
				$this->image_lib->clear();

				//Creating Thumbmail 28 * 28
				//Uploading is successful now resizing the uploaded image 
				$config_profile['image_library'] = 'gd2';
				$config_profile['source_image'] = $msg_material_folder_path.'/'.$file_name;
				$config_profile['new_image'] = $msg_material_folder_path.'/thumb/'.$file_name;
				$config_profile['create_thumb'] = TRUE;
				$config_profile['thumb_marker'] = '';
				
				$config_profile['maintain_ratio'] = TRUE;
				$config_profile['width'] = 230;
				$config_profile['height'] = 150;
				
				$this->load->library('image_lib');
				$this->image_lib->initialize($config_profile);
				$this->image_lib->resize();
				$this->image_lib->clear();
				
			}//end if(!$this->upload->do_upload('prof_image'))

		}//end if($_FILES['file']['name'] != '')
		
		$created_date = date('Y-m-d G:i:s');
		
		 
		 $ins_attachment = array(
			    'project_id' => $this->db->escape_str(trim($project_id)),
				'attachments' => $this->db->escape_str(trim($file_name)),
				'file_original_name' => $this->db->escape_str(trim($file_original_name)),
				'created_by' => $this->db->escape_str(trim($created_by)),
				'created_date' => $this->db->escape_str(trim($created_date)),
				'created_by_ip' => $this->db->escape_str(trim($created_by_ip))
			 );				
	
	

		//Insert the record into the database.
		$this->db->dbprefix('project_messages_attachments');
		$this->db->insert('project_messages_attachments', $ins_attachment);
		//echo $this->db->last_query();
		return array('file_id'=>$this->db->insert_id(),'file_name'=>$file_name); 
		 

		}//end ajax_upload_message_attachments
		
		
		
	//Delete Image
	public function delete_file($data){
		
		extract($data);
		
		echo $server_file_id;exit;


		$get_file_data = $this->mod_projects->get_file($server_file_id);
		$get_file_data_arr = $get_file_data['file_arr'];
		
		//Create User Directory if not exist
		$folder_path = '../assets/project_attachments/'.$get_file_data_arr['project_id'];
		$old_file_name = $get_file_data_arr['file_name'];
		//Delete Existing Image
		if(file_exists($folder_path.'/'.$old_file_name )){
			unlink($folder_path.'/'.$old_file_name);
			
		}//end if
		
		//Delete the record from the database.
		$this->db->dbprefix('project_messages_attachments');
		$this->db->where('id',$server_file_id);
		$del_into_db = $this->db->delete('project_messages_attachments');
		//echo $this->db->last_query(); exit;
		
		if($del_into_db) return true;

	}//end delete_page()
	
	
	 //Get  Record
	public function get_file($file_id){
		
		$this->db->dbprefix('project_messages_attachments');
		$this->db->where('id',$file_id);
		$get_file= $this->db->get('project_messages_attachments');

		//echo $this->db->last_query(); exit;
		$row_file['file_arr'] = $get_file->row_array();
		
		return $row_file;
		
	 }//end get_file
	 
	 
	
	//Upload Task
	public function upload_task($data){
		
		extract($data);
		
			
		 $created_date = date('Y-m-d G:i:s');
		 $ip_address = $this->input->ip_address();
		 $created_by = $this->session->userdata('admin_id');
		
	
	   //Create User Directory if not exist
			$upload_task_folder_path = './assets/upload_task/';
			
			if(!is_dir($upload_task_folder_path))
			mkdir($upload_task_folder_path,0777);
	
			
			$name=str_replace(' ','_',$_FILES['file']['name']);
	 	    $file_name = 	'upload_task_'.date('YmdGis')."_".$name;

			$config['upload_path'] = $upload_task_folder_path;
			$config['allowed_types'] = 'csv';
			$config['max_size']	= '6000';
			$config['overwrite'] = true;
			$config['file_name'] = $file_name;
			
			$this->load->library('upload', $config);
			$this->upload->do_upload('file');

			 //Read CSV file
			 $this->load->library('csvreader');
			 $ins_array=array();
			 $filePath = $upload_task_folder_path."/".$file_name;
             $csv_data = $this->csvreader->parse_file($filePath);
			 
			 if(empty($csv_data)){
				return 	$error = array('error_msg' =>'File empty or Error in reading file contents');
				}
				
				
	
	//loop the file data.	
	
	foreach($csv_data as $row){
		
		$start_date = date("Y-m-d H:i:s", strtotime($row['Start_Date']));
	 	$end_date = date("Y-m-d H:i:s", strtotime($row['End_Date']));
		
		 
		$datetime1 = strtotime($start_date);
		$datetime2 = strtotime($end_date);
		$interval  = abs($datetime2 - $datetime1);
		$minutes   = round($interval / 60);
		//echo 'Diff. in minutes is: '.$minutes; 
		
		$user_id= $row['Team'];
			
		
			
		   $ins_data = array(
		    'user_id' => $this->db->escape_str(trim($user_id)),
		    'project_id' => $this->db->escape_str(trim($project_id)),
			'milestone' => $this->db->escape_str(trim($row['Milestone'])),			  
			'title' => $this->db->escape_str(trim($row['Title'])),
		    'start_date' => $this->db->escape_str(trim($start_date)),
			'end_date' => $this->db->escape_str(trim($end_date)),
			'total_time' => $this->db->escape_str(trim($minutes)),
		    'description' => $this->db->escape_str(trim(nl2br($row['Description']))),
		    'created_by' => $this->db->escape_str(trim($created_by)),
		    'created_date' => $this->db->escape_str(trim($created_date)),
		    'created_by_ip' => $this->db->escape_str(trim($created_by_ip))
		    );		

		   //Inserting the record into the database.
		  $this->db->dbprefix('project_task');
		  $ins_into_db = $this->db->insert('project_task', $ins_data);
		  $project_task_id= $this->db->insert_id();
		  
			
		//Send Message to Assign Task Users
		$user_id= explode(',',$row['Team']); 
		
		/*echo "<pre>";
		print_r($user_id);
		exit;*/
		
		
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
				'created_by_ip' => $this->db->escape_str(trim($created_by_ip)),
				'notification' => $this->db->escape_str(trim(1))
				);		
	
			if($to_user !=$this->session->userdata('admin_id')){
	
				   //Inserting the record into the database.
				  $this->db->dbprefix('messages');
				  $ins_into_db = $this->db->insert('messages', $ins_msg_data);
			  }
				
			}//End For
		
		
		$event_url=SURL."projects/manage-projects/assign-task-detail/".$project_task_id;
		
		  //Inset Data in Calender Table
		 $this->load->model('common/mod_common');
		
		 $this->mod_common->calendar('project task', $title, $description,$event_url,$start_date,$end_date, $project_task_id, $to_user);
		
		
		
	
	}//end foreach
	
	
	//Delete UPloaded File
	if(file_exists($upload_task_folder_path."/".$file_name)){
		
		unlink($upload_task_folder_path."/".$file_name);
		
	}//end if
	
	return true;

	}//end upload_task()
	
	
	public function download_csv_file($project_id){
	
	
		$this->db->dbprefix('project_task');
		$this->db->select('title as task_title,start_date,end_date,total_time,task_started_date,task_close_date');
        $this->db->from('project_task');
		$this->db->where('project_id',$project_id);
		$this->db->order_by('project_task.id',DESC);
		$get_project_task= $this->db->get();
		//echo $this->db->last_query();
	
		
		$project_task_arr = $get_project_task->result_array();
		
		
		for($i=0; $i<count($project_task_arr); $i++){
			
		
				 
			$total_time=   $project_task_arr[$i]['total_time'];
			
				
				 
			$task_started_date= $project_task_arr[$i]['task_started_date']; 
			$task_close_date= $project_task_arr[$i]['task_close_date']; 
			 
			$datetime1 = strtotime($task_started_date);
			$datetime2 = strtotime($task_close_date);
			$interval  = abs($datetime2 - $datetime1);
			
			$consumed_minutes   = round($interval / 60);
								 
			$consumed_time=  $consumed_minutes;
		
			$project_task_arr[$i]['total_time']= $total_time;
			
			$project_task_arr[$i]['consumed_time']= $consumed_time;
			
			
		}
		
	
	
		$this->load->dbutil();
	
		
		/*echo "<pre>";
		print_r($project_task_arr);
		exit;*/
		
		//$delimiter = ";";
		//$newline = "\r\n";

	
		
		$download_csv = $this->dbutil->csv_from_result($project_task_arr); 
		
		
		return $download_csv;
	
	}//end download_csv_file($deal_id)
	
	
	
	//Get get_all_project_defauls
	public function get_all_project_defauls(){
		
		
		$this->db->dbprefix('site_preferences');
		$this->db->like('setting_name','project-default');
		$get_setting = $this->db->get('site_preferences');
		
		$default_user_arr = $get_setting->result_array();

		//echo $this->db->last_query(); exit;
		
		return $default_user_arr ;
		
		
		/*echo "<pre>";
		print_r($default_user_arr);
		exit;*/
		
	}//end get_preferences_setting
	
	
	
	
	
	//Get Users Ajax
	public function get_users_ajax($ids){
		
		  $user_ids_arr = explode(',',$ids);
			
		   $user_name_arr= array();
		   
		   for($i=0; $i<count($user_ids_arr); $i++){
				
				$this->db->dbprefix('admin');
				$this->db->where('id',$user_ids_arr[$i]);
				$get_user= $this->db->get('admin');
		
				//echo $this->db->last_query();
				$row_user = $get_user->row_array();
				
				$users_name_arr[$i]=$row_user['first_name']." ".$row_user['last_name']; 
				
			}
			
		 	$user_name=implode(' , ',$users_name_arr); 
		
			
			return $user_name;
			
	}//end get_users_ajax
	
}
?>