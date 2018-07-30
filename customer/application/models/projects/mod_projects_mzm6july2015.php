<?php
class mod_projects extends CI_Model {
	
	function __construct(){
		
        parent::__construct();
    }

	//Verify If User is Login on the authorized Pages.
	public function verify_is_admin_login(){
		
		if(!$this->session->userdata('customer_id')){
			

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


   public function get_projects_portfolio(){
		
	    $customer_id= $this->session->userdata('customer_id');
		
		
		$this->db->dbprefix('projects');
		$this->db->select('projects.*,customers.first_name,customers.last_name');
        $this->db->from('projects');
        $this->db->join('customers', 'projects.customer_id = customers.id');
		$this->db->where('projects.status',3);
		$this->db->where('projects.project_amount >',0.00);
		$this->db->where('projects.is_awarded ',1);
		$this->db->order_by('projects.end_date',DESC);
		$get_projects= $this->db->get();
		$row_projects_portfolio['projects_portfolio_arr'] = $get_projects->result_array();
		$row_projects_portfolio['projects_portfolio_count'] = $get_projects->num_rows;
		
		return $row_projects_portfolio;
		
	}//End projects_portfolio
	
	
	
    //Get projects  Record
	public function get_projects(){
		
	    $customer_id= $this->session->userdata('customer_id');
			
		$this->db->dbprefix('customers');
		$this->db->select('id,customer_id');
		$this->db->where('id',$customer_id);
		$get_customer = $this->db->get('customers');
		//echo $this->db->last_query();
		$row_customer = $get_customer->row_array();
		
		if($row_customer['customer_id'] ==0){
		
		
		$this->db->dbprefix('projects');
		$this->db->select('projects.*,customers.first_name,customers.last_name');
        $this->db->from('projects');
        $this->db->join('customers', 'projects.customer_id = customers.id');
		$this->db->where('projects.customer_id',$this->session->userdata('customer_id'));
		$this->db->order_by('projects.customer_id',DESC);
		$get_projects= $this->db->get();
		$row_projects['projects_arr'] = $get_projects->result_array();
		$row_projects['projects_count'] = $get_projects->num_rows;
		
		
		}else{
			
		$this->db->dbprefix('projects');
		$get_projects= $this->db->get('projects');
		
		$row_projects_arr['projects_arr'] = $get_projects->result_array();
		$row_projects_arr['projects_count'] = $get_projects->num_rows;
		
		//echo "<pre>"; print_r($row_projects['projects_arr']); exit;
		
					$counter = 0 ; 	
					$h = 0 ;
					for($k=0;$k<count($row_projects_arr['projects_arr']);$k++){
					$explode_arr = explode(',',$row_projects_arr['projects_arr'][$k]['employee_assign']);
						
					if(in_array($customer_id,$explode_arr))
					
					{
								
				    //$row_projects['projects_filter'] = $row_projects['projects_arr'][$k]; 
								
					$row_projects['projects_arr'][$h]['id'] = $row_projects_arr['projects_arr'][$k]['id'] ;
					$row_projects['projects_arr'][$h]['project_id'] = $row_projects_arr['projects_arr'][$k]['project_id'] ;
					$row_projects['projects_arr'][$h]['customer_id'] = $row_projects_arr['projects_arr'][$k]['customer_id'] ;
					$row_projects['projects_arr'][$h]['project_title'] = $row_projects_arr['projects_arr'][$k]['project_title'] ;
					$row_projects['projects_arr'][$h]['project_amount'] = $row_projects_arr['projects_arr'][$k]['project_amount'] ;
					$row_projects['projects_arr'][$h]['start_date'] = $row_projects_arr['projects_arr'][$k]['start_date'] ;
					$row_projects['projects_arr'][$h]['end_date'] = $row_projects_arr['projects_arr'][$k]['end_date'] ;
					$row_projects['projects_arr'][$h]['project_detail'] = $row_projects_arr['projects_arr'][$k]['project_detail'] ;
					$row_projects['projects_arr'][$h]['project_assign'] = $row_projects_arr['projects_arr'][$k]['project_assign'] ;
					
					$row_projects['projects_arr'][$h]['status'] = $row_projects_arr['projects_arr'][$k]['status'] ;
					
					$row_projects['projects_arr'][$h]['created_by'] = $row_projects_arr['projects_arr'][$k]['created_by'] ;
					$row_projects['projects_arr'][$h]['created_date'] = $row_projects_arr['projects_arr'][$k]['created_date'] ;
					$row_projects['projects_arr'][$h]['created_by_ip'] = $row_projects_arr['projects_arr'][$k]['created_by_ip'] ;
					$row_projects['projects_arr'][$h]['last_modified_by'] = $row_projects_arr['projects_arr'][$k]['last_modified_by'] ;
					$row_projects['projects_arr'][$h]['last_modified_date'] = $row_projects_arr['projects_arr'][$k]['last_modified_date'] ;
					$row_projects['projects_arr'][$h]['last_modified_ip'] = $row_projects_arr['projects_arr'][$k]['last_modified_ip'] ;
					$row_projects['projects_arr'][$h]['first_name'] = $row_projects_arr['projects_arr'][$k]['first_name'] ;
					$row_projects['projects_arr'][$h]['last_name'] = $row_projects_arr['projects_arr'][$k]['last_name'] ;
                  
						   
				  for($i=0; $i<count($row_projects_arr['projects_arr']); $i++){
					
					$branch_id=$row_projects_arr['projects_arr'][$h]['branch_id'][$i] = $row_projects_arr['projects_arr'][$k]['branch_id'] ;
					
					$this->db->dbprefix('branches');
					$this->db->select('branch_name');
					$this->db->from('branches');
					$this->db->where('id',$branch_id);
					$get_branches = $this->db->get();
					$row_branch= $get_branches->row_array();
					$row_projects['projects_arr'][$h]['branch_name']=$row_branch['branch_name'];
					
					$customer=  $row_projects_arr['projects_arr'][$i]['customer_id'];
					$this->db->dbprefix('customers');
					$this->db->where('id',$customer);
					$get_customer= $this->db->get('customers');
					$row_customer= $get_customer->row_array();
					
					$row_projects['projects_arr'][$i]['first_name']=  $row_customer['first_name'];
					$row_projects['projects_arr'][$i]['last_name']=  $row_customer['last_name'];
					
				
					
					}
				   
				$h++;
				$counter  = $counter + 1 ;   
				
			//echo "<pre>"; print_r($row_projects['projects_filter']); exit; 	
			}
					
		}
	
		$row_projects['projects_count'] = $counter ; 
		
		}

	return $row_projects;
	
	}//end Project Records


	
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
		
		$project_assign_team = trim($get_project_details_arr['project_details_result']['project_assign'],",");
		
		$project_assign_id = explode(',', $project_assign_team);	
	
		//$project_assign_id= explode(',',$get_project_details_arr['project_details_result']['project_assign']);
		
		//$subuser_assign= $get_project_details_arr['project_details_result']['employee_assign'];
		
		$subuer_arr= explode(',',$get_project_details_arr['project_details_result']['employee_assign']);
		
		$customer_id[]= $get_project_details_arr['project_details_result']['customer_id'];
		
		$array_merge= array_merge($customer_id,$subuer_arr);
		
		/*echo "<pre>";
		print_r($array_merge);
		exit;*/
		
		if(in_array($this->session->userdata('customer_id'), $array_merge)){
			
			
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
			
			return  $get_project_details_arr['error']= array('error' =>"Opps...! Project not found...!!");
			
		}
		
		
				
		
	}//end get_messages
	
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
	

	public function project_messages($data){
		
		extract($data);
		
		 $created_date = date('Y-m-d G:i:s');
		 $created_by_ip = $this->input->ip_address();
		 $created_by = $this->session->userdata('customer_id');
		 
		 
		  ///////////////////
		 //Send message to all team assigned
		
		 $this->db->dbprefix('projects');
		 $this->db->where('id',$project_id);
		 $get_project_messages= $this->db->get('projects');
		//echo $this->db->last_query();
		
		
		$insrt_data = array(
		    'project_id' => $this->db->escape_str(trim($project_id)),
		    'to' => $this->db->escape_str(trim('1')),
			'from' => $this->db->escape_str(trim($this->session->userdata('customer_id'))),
			'message' => $this->db->escape_str(trim(nl2br($message_reply))),
			'user_type' => $this->db->escape_str('c'),
			'created_by' => $this->db->escape_str(trim($created_by)),
		    'created_date' => $this->db->escape_str(trim($created_date)),
		    'created_by_ip' => $this->db->escape_str(trim($created_by_ip))
		);		

		//inserting the record into the database.
		$this->db->dbprefix('project_messages');
		$upd_into_db = $this->db->insert('project_messages', $insrt_data);
		$project_message_id= $this->db->insert_id();
		
		
		
		$get_team_arr['team_arr'] = $get_project_messages->row_array();
		$team_members=explode(',',$get_team_arr['team_arr']['project_assign']);
		
		/*echo "<pre>";
		print_r($team_members);
		exit; 
		*/
		
		for($i=0; $i<count($team_members); $i++){
			
			 $message_id = $this->mod_common->random_number_generator(7);
			 $message_id = $this->mod_projects->message_id_generator($message_id);
	
		     $message_subject="You have recieved a new message on project (<b> <a href=".ADMIN_SURL."projects/manage-projects/project-detail/".$project_id." target='_blank' > ".$get_team_arr['team_arr']['project_title']."</a></b>) by ".strtoupper($this->session->userdata('customer_name'));
			 
			
	  //$message='To see complete message please click on the link below:<br /><a href="'.ADMIN_SURL.'projects/manage-projects/project-detail/'.$project_id.'" target="_blank">'.ADMIN_SURL.'projects/manage-projects/project-detail/'.$project_id.'</a>';
			
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
			'type' => $this->db->escape_str(trim('c')),
			'notification' => $this->db->escape_str(trim(1))
		    );		
  
			 if($created_by != $team_members[$i]){
			   //Inserting the record into the database.
			  $this->db->dbprefix('messages');
			  $ins_into_db = $this->db->insert('messages', $ins_data);
			 }
		}//End message to all assigned team
		
		 
		for($i=0; $i<count($_FILES['attachments']['name']); $i++)
		   
		   {	
		   
		 
		   if($_FILES['attachments']['name'][$i] !=""){
			
		     $project_folder_path = '../assets/project_attachments/'.$project_id;
			 
			 if(!is_dir($project_folder_path))
			 mkdir($project_folder_path,0777);
			
			 $attach_name[$i]=str_replace(' ','_',$_FILES['attachments']['name'][$i]);
			
		     $attachment_name = "project_message_".$project_message_id.'_'.$attach_name[$i]; 
			
			$this->load->helper(array('form', 'url'));
			$config['upload_path'] = $project_folder_path;
			$config['allowed_types'] = 'jpg|jpeg|gif|tiff|tif|png|doc|docx|xls|xlsx|pdf|txt||zip|rar|odt|csv|ppt|pptx';
			$config['max_size']	= '15000';
			$config['overwrite'] = true;
	
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			$this->load->library('multipleupload',$config);
				
			
			$upload_epaper =  $this->multipleupload->do_multi_upload_project_message_attachments('attachments',TRUE,$project_message_id);
			
			if(!$upload_epaper){
				
		    
			return $error_file_arr = array('error' =>"Opps...! Error in File Uploading");
				
			}
	
		
			
			$ins_attachment = array(
			    'project_id' => $this->db->escape_str(trim($project_id)),
				'project_message_id' => $this->db->escape_str(trim($project_message_id)),
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
	   

	   $customer_name= strtoupper($this->session->userdata("customer_name"));
	   $project_title= $get_team_arr["team_arr"]["project_title"];
	   
	   //Send SMS notification
	    $message="You have recieved a new message from ".$customer_name." on project ".$project_title;
	   
	 
	   
		$message = urlencode($message);
		$this->mod_common->send_sms_notification($message);
	
	
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
			   
			
			   
			 // $get_project_messages_arr['project_messages_result'][$i]['user']= $name_array['first_name']." ".$name_array['last_name'];
			  
			  $get_project_messages_arr['project_messages_result'][$i]['admin_id']= $name_array['id'];
			  $get_project_messages_arr['project_messages_result'][$i]['user']= $name_array['first_name']." ".$name_array['last_name'];
			 
			  $get_project_messages_arr['project_messages_result'][$i]['avatar_image']= $name_array['avatar_image'];
			   
			
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
	    $this->db->where('user_type','u');
		$this->db->where('to',$this->session->userdata('customer_id'));
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
		
	}//get_messages_count
	
	
	public function update_project_messages_count($project_id){
		
		
		$upd_data = array(
		    'status' => $this->db->escape_str(trim(1))
		);		
		$this->db->dbprefix('project_messages');
		$this->db->where('project_id',$project_id);
		$this->db->where('user_type','u');
		$get_messages= $this->db->update('project_messages',$upd_data);
	
		return true;
		
	}//End update_project_messages_count
	
	
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
		   'created_date' => $this->db->escape_str(trim($created_date))
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
		
		
		return $row_project_workspace;
		
	}//end get_project_workspace
	
	
	
	//Project Assign
	public function project_assign($data){
		
		extract($data);
		
		$created_date = date('Y-m-d G:i:s');
		$created_by_ip = $this->input->ip_address();
		$created_by = $this->session->userdata('admin_id');
		
		$new_name=implode(',',$name);
		
		$update_data = array(
		    'employee_assign' => $this->db->escape_str(trim($new_name))
		);		

		//Updating the record into the database.
		$this->db->dbprefix('projects');
		$this->db->where('id',$project_id);
		$upd_into_db = $this->db->update('projects', $update_data);
		
		
	   return true;
		
	}//End Project Assign
	
	
	
	
}
?>