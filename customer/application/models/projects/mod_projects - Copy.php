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
		
		
		/*$this->db->dbprefix('projects');
		$this->db->select('projects.*,customers.first_name,customers.last_name');
        $this->db->from('projects');
        $this->db->join('customers', 'projects.customer_id = customers.id');
		$this->db->where('projects.customer_id',$this->session->userdata('customer_id'));
		$this->db->order_by('projects.customer_id',DESC);
		$get_projects= $this->db->get();*/
		
		
		$this->db->dbprefix('projects');
		$this->db->select('projects.*, customers.first_name, customers.last_name');
		$this->db->from('projects');
		$this->db->join('customers', 'projects.customer_id = customers.id');
		$this->db->where('projects.customer_id',$customer_id);
		$this->db->order_by('id',DESC);
		$get_projects = $this->db->get();
		
		$row_projects['projects_arr'] = $get_projects->result_array();
		$row_projects['projects_count'] = $get_projects->num_rows;
		
		
		}else{
			
		
			
		//$this->db->dbprefix('projects');
		//$get_projects= $this->db->get('projects');
		
		$this->db->dbprefix('projects');
		$this->db->select('projects.*, customers.first_name, customers.last_name');
		$this->db->from('projects');
		$this->db->like('projects.employee_assign',",".$customer_id.",");
		//$this->db->where('projects.customer_id',$customer_id);
		
		$this->db->join('customers', 'projects.customer_id = customers.id');
		$this->db->order_by('id',DESC);
		$get_projects = $this->db->get();
	//	echo $this->db->last_query();exit;
		
		$row_projects['projects_arr'] = $get_projects->result_array();
		$row_projects['projects_count'] = $get_projects->num_rows;
		
	//	echo "<pre>"; print_r($row_projects['projects_arr']); exit; 
		
		/*//echo "<pre>"; print_r($row_projects_arr['projects_arr']); exit;
		
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
					
		}*/
	
		//$row_projects['projects_count'] = $counter ; 
		
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
			  //$autoload_latest_messages[$i]['user_role']= $admin_role_arr['role_title'];
			  $autoload_latest_messages[$i]['avatar_image']= $name_array['avatar_image'];
			  
			  
			  $autoload_latest_messages[$i]['admin_rating']= $admin_avg_rating['average_rating'];  
			   
			
			}
		if($user_type=='c'){
			
		      $this->db->dbprefix('customers');
		      $this->db->where('id',$from);
		      $get_project_messages= $this->db->get('customers');
		      $name_array= $get_project_messages->row_array();
			  $autoload_latest_messages[$i]['user']= $name_array['first_name']." ".$name_array['last_name'];
			
			}
			
			
		}//End for
		
		return $autoload_latest_messages;	
		
		
		
		}	
	

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
		
		$customer_name= strtoupper($this->session->userdata("customer_name"));
	    $project_title= $get_team_arr["team_arr"]["project_title"];
		
		
		$project_assign_team = trim($get_team_arr['team_arr']['project_assign'],",");
		$team_members=explode(',',$project_assign_team); 
		
		//Get Api Key
		$get_api_key = $this->mod_preferences->get_preferences_setting('api_key');
		$api_key = $get_api_key['setting_value'];
		
		
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
			 
			 
			  //Send App notifications to all team
			 //Get user Registration App ID
			  $this->db->dbprefix('admin');
			  $this->db->select('gcm_regid');
		 	  $this->db->where('id',$team_members[$i]);
		      $get_admin_app_id= $this->db->get('admin');
			  $admin_app_id_arr = $get_admin_app_id->row_array();
			  
			 if($admin_app_id_arr['gcm_regid'] !=""){
			
				// please enter the registration id of the device on which you want to send the message
				
				$registrationIDs= array($admin_app_id_arr['gcm_regid']); 
				
				$message = array("project_title" => $project_title, "message_detail" => $message_reply, "from_name" => $customer_name , 'message_id'=> $message_id , 'project_id'=>$project_id);
				
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
			
		 }//end if user app id not empty
			 
			 
		}//End message to all assigned team
		
		 
	   
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
		$this->db->limit(10);
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
		
	}//end load_more
	
	
	
	
	public function get_messages_count(){
		
			
		$this->db->dbprefix('projects');
		$this->db->where('customer_id',$this->session->userdata('customer_id'));
		$this->db->order_by('id',DESC);
		$get_projects = $this->db->get('projects');
		
		$row_projects['projects_arr'] = $get_projects->result_array();
		$row_projects['projects_count'] = $get_projects->num_rows;
		
		for($i=0; $i<$row_projects['projects_count']; $i++){
			
			 $project_id= $row_projects['projects_arr'] [$i]['id'];
			  
		    $this->db->dbprefix('project_messages');
			$this->db->select('COUNT(status) as num_messages');
			$this->db->where('user_type','u');
			$this->db->where('to',$this->session->userdata('customer_id'));
			$this->db->where('status',0);
			$this->db->where('project_id',$project_id);
			$this->db->group_by('project_id');
			$get_messages= $this->db->get('project_messages');
			$message_att_arr['message_arr'] = $get_messages->row_array();
			$message_att_arr['message_count'] = $get_messages->num_rows();
			
			$row_projects['projects_arr'][$i]['num_messages']= $message_att_arr['message_arr']['num_messages'];
			
		}
		
		/*echo "<pre>";
		print_r($row_projects['projects_arr']);
		exit;*/
		
		return $row_projects;
		
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
	
	
	
	public function get_project_task($project_id){
		
	
		$this->db->dbprefix('project_task');
		$this->db->select('project_task.*,projects.project_title');
        $this->db->from('project_task');
		$this->db->where('project_task.project_id',$project_id);
        $this->db->join('projects', 'project_task.project_id = projects.id');
		$this->db->order_by('project_task.id',DESC);
		$get_project_task= $this->db->get();
		//echo $this->db->last_query();
	
		$row_project_task_arr['project_task_arr'] = $get_project_task->result_array();
		$row_project_task_arr['project_task_count'] = $get_project_task->num_rows();
		  
		
		/*echo "<pre>";
		print_r( $row_assign_task_arr['assign_task_arr']);
		exit;*/
		
	
		return $row_project_task_arr;		
		
	}//end get_project_task
	
	
	public function get_all_tasks_ajax($project_id, $status){
		
		
		$this->db->dbprefix('project_task');
		$this->db->select('project_task.*,projects.project_title');
        $this->db->from('project_task');
		$this->db->where('project_task.status',$status);
		$this->db->where('project_task.project_id',$project_id);
        $this->db->join('projects', 'project_task.project_id = projects.id');
		$this->db->order_by('project_task.id',DESC);
		$get_project_task= $this->db->get();
		//echo $this->db->last_query();
		
	
		$row_project_task_arr['project_task_arr'] = $get_project_task->result_array();
		$row_project_task_arr['project_task_count'] = $get_project_task->num_rows();
		  
		
		/*echo "<pre>";
		print_r( $row_assign_task_arr['assign_task_arr']);
		exit;*/
		
	
		return $row_project_task_arr;		
		
	}//end get_project_task
	
	
	
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
		    'employee_assign' => $this->db->escape_str(trim(",".$new_name.","))
		);
		
		
		//Updating the record into the database.
		$this->db->dbprefix('projects');
		$this->db->where('id',$project_id);
		$upd_into_db = $this->db->update('projects', $update_data);
		
		
	   return true;
		
	}//End Project Assign
	
	
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
	 
	 
	 
	 public  function daily_tasks(){
		//closing projects in range for last 5 days plus future 5 days
		
		//last 10 days created projects which have an amount and are marked as awarded
		//group by day to show a single ammount per day
			$this->db->dbprefix('project_task');
			
			//inno_projects.is_awarded = 1 AND inno_projects.project_amount > 0 AND
			$query = "SELECT
						inno_project_task.id,
						count(inno_project_task.id) as tasks_count,
						date(created_date) as formated_created_date ,
						GROUP_CONCAT(inno_project_task.title) as task_title
						
						FROM
											inno_project_task
											
											
						WHERE

					
												
						inno_project_task.created_date  >= ( CURDATE() - INTERVAL 5 DAY ) AND
						inno_project_task.created_date  <= ( CURDATE() + INTERVAL 5 DAY )
						
									
						GROUP BY formated_created_date
						ORDER BY formated_created_date


					 "; 
			
			
			$query = $this->db->query($query);
		
	
		
		//echo $this->db->last_query(); 
		$orders_data = $query->result_array();
		
		
	/*	echo "<pre>";
		print_r($orders_data);
		exit;*/
		return $orders_data;
		
		
	}
			
	
	
	
	
}
?>