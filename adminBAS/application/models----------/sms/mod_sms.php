<?php
class mod_sms extends CI_Model {
	
	function __construct(){
		
        parent::__construct();
    }
	
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

	//Verify If User is Login on the authorized Pages.
	public function verify_is_admin_login(){
		
		if(!$this->session->userdata('admin_id')){
			

			$this->session->set_flashdata('err_message', '- You have to login to access this page.');
			redirect(base_url().'login/login');
			
		}//if(!$this->session->userdata('id'))
		
	}//end verify_is_user_login()

    //Get Admin User Record
	public function get_admin_user_data(){
		
		
		//Show users of all branches
		$permission = (in_array(134,$this->session->userdata('permissions_arr'))) ? 1 : 0;
		
		if($permission==1){
			
			
			
			$this->db->dbprefix('admin');
			$this->db->where('status',1);
			$get_admin = $this->db->get('admin');
		}
		else{
			
			
		
			$user_id=$this->session->userdata('admin_id');
			
			$this->db->dbprefix('admin');
			$this->db->where('id',$user_id);
			$this->db->where('status',1);
			$get_user = $this->db->get('admin');
			//echo $this->db->last_query();
			$row_user= $get_user->row_array();
			$branch_id=$row_user['branch_id'];
			
			$this->db->dbprefix('admin');
			$this->db->where('branch_id',$branch_id);
			$this->db->or_where('branch_id',0);
			$get_admin = $this->db->get('admin');
			//echo $this->db->last_query();exit;
		}
		
		$row_admin['admin_user_arr'] = $get_admin->result_array();
		$row_admin['admin_user_count'] = $get_admin->num_rows;
		
		for($i=0;$i<$row_admin['admin_user_count']; $i++){
			
			$branch_id=$row_admin['admin_user_arr'][$i]['branch_id'];
			$this->db->dbprefix('branches');
			$this->db->select('short_name');
			$this->db->where('id',$branch_id);
			$get_branch = $this->db->get('branches');
			//echo $this->db->last_query();
			$row_branch= $get_branch->row_array();
			$row_admin['admin_user_arr'][$i]['short_name']= $row_branch['short_name'];
		}

		/*echo "<pre>";
		print_r($row_admin['admin_user_arr']);
		exit;*/
		return $row_admin;
		
	}//end get_admin_user_data


	//Sent Sms
	public function sent_sms($data){
		
		  extract($data);
		  
		  
		  echo "hi";
		  exit;
		  
		
		//Uploading Message Attachments
		if($_FILES['attachment']['name'] != ''){
			
		    //Create User Directory if not exist
		    $messages_folder_path = '../assets/messages_attachments';
		
		   if(!is_dir($messages_folder_path))
			mkdir($messages_folder_path);
		
			$attachment_name=str_replace(' ','_',$_FILES['attachment']['name']);		
			$attachment_name = 	$message_id."_".date('YmdGis').$attachment_name;
			
			$config['upload_path'] = $messages_folder_path;
			$config['allowed_types'] = 'jpg|jpeg|gif|tiff|png|doc|zip|rar|docx|xlsx';
			$config['max_size']	= '5000';
			$config['overwrite'] = true;
			$config['file_name'] = $attachment_name;
			
			$this->load->library('upload', $config);
			$this->upload->do_upload('attachment');
			if(!$this->upload->do_upload('attachment')){
				
				$error_file_arr = array('error' => $this->upload->display_errors());
				return $error_file_arr;
				
			}
		
		}//End Attachment
	
	       $created_date = date('Y-m-d G:i:s');
		   $created_by_ip = $this->input->ip_address();
		   $created_by = $this->session->userdata('admin_id');
		   
		  
		   if($branch_id !=""){
			   
			   
		      
			   $this->db->dbprefix('admin');
			   $this->db->where('branch_id',$branch_id);
		       $get_admin = $this->db->get('admin');
			   //echo $this->db->last_query();
			   $row_admin= $get_admin->result_array();
			   for($i=0;$i<count($row_admin); $i++){
					   
				   $message_id = $this->mod_common->random_number_generator(7);
				   $message_id = $this->mod_messages->message_id_generator($message_id);
				   
				  $user_id=$row_admin[$i]['id'];
				  $ins_data = array(
					'to' => $this->db->escape_str(trim($user_id)),
					'from' => $this->db->escape_str(trim($created_by)),
					'subject' => $this->db->escape_str(trim($subject)),
					'message' => $this->db->escape_str(trim(nl2br($message))),
					'message_id' => $this->db->escape_str(trim($message_id)),
					'attachment' => $this->db->escape_str(trim($attachment_name)),
					'created_by' => $this->db->escape_str(trim($created_by)),
					'date' => $this->db->escape_str(trim($created_date)),
					'created_by_ip' => $this->db->escape_str(trim($created_by_ip))
					);		

				   //Inserting the record into the database.
				  $this->db->dbprefix('messages');
				  $ins_into_db = $this->db->insert('messages', $ins_data);
				   
			   }//End For
			}//End IF
			
		if($user_name !=""){
			
			for($j=0;$j<count($user_name); $j++){
				
			   $message_id = $this->mod_common->random_number_generator(7);
		       $message_id = $this->mod_messages->message_id_generator($message_id);
				 
				 $ins_data = array(
					'to' => $this->db->escape_str(trim($user_name[$j])),
					'from' => $this->db->escape_str(trim($created_by)),
					'subject' => $this->db->escape_str(trim($subject)),
					'message' => $this->db->escape_str(trim(nl2br($message))),
					'message_id' => $this->db->escape_str(trim($message_id)),
					'attachment' => $this->db->escape_str(trim($attachment_name)),
					'created_by' => $this->db->escape_str(trim($created_by)),
					'date' => $this->db->escape_str(trim($created_date)),
					'created_by_ip' => $this->db->escape_str(trim($created_by_ip))
					);		

				   //Inserting the record into the database.
				  $this->db->dbprefix('messages');
				  $ins_into_db = $this->db->insert('messages', $ins_data);
				   
			   }//End For
			}//End if
			
			 if($branch_id !="" && $user_name !=""){
			   
			   return false;
			}
		   
		  
	     return true;
		
		
	}//end Compose
	
	

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
	
	
	public function get_messages(){
		
       $this->db->dbprefix('messages');
       $this->db->select('messages.*,admin.* ,COUNT(message_id) as num_messages');
       $this->db->from('messages');
       $this->db->join('admin', 'messages.to = admin.id');
	   $this->db->group_by('messages.message_id');
	   $this->db->order_by('messages.id',DESC);
	   $this->db->where('messages.from',$this->session->userdata('admin_id'));
	   $get_messages= $this->db->get();
	   //echo $this->db->last_query();
			
		$get_messages_arr['messages_result'] = $get_messages->result_array();
		$get_messages_arr['messages_count'] = $get_messages->num_rows;
		
		
		return $get_messages_arr;		
		
	}//end get_messages
	
	
	 //Get Sent Message Details Record
	public function get_sent_message_detail($message_id){
		
		$this->db->dbprefix('messages');
		$this->db->select('messages.*,admin.*');
        $this->db->from('messages');
        $this->db->join('admin', 'messages.to = admin.id');
		$this->db->where('messages.message_id',$message_id);
		$this->db->order_by('messages.id',DESC);
		$get_messages= $this->db->get();
		

		//echo $this->db->last_query();
		$row_message['message_detail_arr'] = $get_messages->result_array();
		$row_message['message_detail_count'] = $get_messages->num_rows();
		
		
	    $to=$row_message['message_detail_arr']['to'];
		$this->db->dbprefix('admin');
		$this->db->where('id',$to);
		$get_customer= $this->db->get('admin');
		$row_message['users_arr'] = $get_customer->row_array();
         
		 //print_r($row_message['customer_arr']);
	   
		return $row_message;
		
	}//end 
	
	
	
	 //Get get_inbox_message_detail
	public function get_inbox_message_detail($message_id){
		
		$this->db->dbprefix('messages');
		$this->db->select('messages.*,admin.*');
        $this->db->from('messages');
        $this->db->join('admin', 'messages.from = admin.id');
		$this->db->where('messages.message_id',$message_id);
		$this->db->order_by('messages.id',DESC);
		$get_messages= $this->db->get();

		//echo $this->db->last_query();
		$row_message['message_detail_arr'] = $get_messages->result_array();
		$row_message['message_detail_count'] = $get_messages->num_rows();
		
		//print_r($row_message['message_detail_arr']);
	    $from=$row_message['message_detail_arr']['from'];
		$this->db->dbprefix('admin');
		$this->db->where('id',$from);
		$get_customer= $this->db->get('admin');
		$row_message['users_arr'] = $get_customer->row_array();
         
		 //print_r($row_message['customer_arr']);
	   
		return $row_message;
		
	}//end get_inbox_message_detail
	
	
	
	public function message_reply($data){
		
		extract($data);
		
		//Uploading Message Attachments
		if($_FILES['attachment']['name'] != ''){
			
		    //Create User Directory if not exist
		    $messages_folder_path = '../assets/messages_attachments';
		
		  /*  if(!is_dir($messages_folder_path))
			mkdir($messages_folder_path);*/
			
			$attachment_name=str_replace(' ','_',$_FILES['attachment']['name']);		
			$attachment_name = 	$message_id."_".date('YmdGis').$attachment_name;
			
			$config['upload_path'] = $messages_folder_path;
			$config['allowed_types'] = 'jpg|jpeg|gif|tiff|png|doc|zip|rar|docx|xlsx';
			$config['max_size']	= '5000';
			$config['overwrite'] = true;
			$config['file_name'] = $attachment_name;
			
			$this->load->library('upload', $config);
			$this->upload->do_upload('attachment');
			if(!$this->upload->do_upload('attachment')){
				
				$error_file_arr = array('error' => $this->upload->display_errors());
				return $error_file_arr;
				
			}
		
		}//End Attachment
		
	
		   $created_date = date('Y-m-d G:i:s');
		   $created_by_ip = $this->input->ip_address();
		   $created_by = $this->session->userdata('admin_id');
		   
		   
		   //Fetching message Details
		   $this->db->dbprefix('messages');
		   $this->db->where('message_id',$message_id);
		   $this->db->order_by('id',ASC);
		   $this->db->limit(1);
		   $get_msg= $this->db->get('messages');
           $row_msg= $get_msg->row_array();
		  
		   //Sender Information
	       $temp_to = $row_msg['to'];
		   $temp_from = $row_msg['from'];
		   
		   $from = $this->session->userdata('admin_id');
		   
		   if($temp_to!= $from)
		   		$to = $temp_to;
			else
				$to = $temp_from;
		 
		   $subject=$row_msg['subject'];
		
		   $ins_data = array(
		    'to' => $this->db->escape_str(trim($to)),
		    'from' => $this->db->escape_str(trim($from)),
		    'subject' => $this->db->escape_str(trim($subject)),
			'message' => $this->db->escape_str(trim(nl2br($message_reply))),
		    'message_id' => $this->db->escape_str(trim($message_id)),
			'attachment' => $this->db->escape_str(trim($attachment_name)),
		    'created_by' => $this->db->escape_str(trim($created_by)),
		    'date' => $this->db->escape_str(trim($created_date)),
		    'created_by_ip' => $this->db->escape_str(trim($created_by_ip))
		    );		

		   //Inserting the record into the database.
		  $this->db->dbprefix('messages');
		  $ins_into_db = $this->db->insert('messages', $ins_data);
		
			 
	     return true;
		
		
	}//end message reply
	
	
	public function get_inbox_messages(){
		
		
		$this->db->dbprefix('messages');
		$this->db->select('messages.*,admin.* ,COUNT(message_id) as num_messages');
		$this->db->where('messages.message_status',0);
        $this->db->join('admin', 'messages.from = admin.id');
		$this->db->group_by('messages.message_id');
		$this->db->order_by('messages.message_status', ASC);
		$this->db->order_by('messages.id', DESC);
		$this->db->where('messages.to',$this->session->userdata('admin_id'));
		$get_messages= $this->db->get('messages');
	    //echo $this->db->last_query(); exit;
		
		$get_messages_arr['messages_result'] = $get_messages->result_array();
		$get_messages_arr['messages_count'] = $get_messages->num_rows;
		
		
		for($i=0; $i<$get_messages_arr['messages_count']; $i++){
			
		    $message_id=$get_messages_arr['messages_result'][$i]['message_id'];
		  
		    $this->db->dbprefix('messages');
			$this->db->select('COUNT(message_status) as num_messages');
			$this->db->where('message_status',0);
			$this->db->where('message_id',$message_id);
			$this->db->where('messages.to',$this->session->userdata('admin_id'));
			$this->db->group_by('message_id');
			//$this->db->order_by('message_id',DESC);
			$get= $this->db->get('messages');
			//echo $this->db->last_query();exit;
			
			$get_messages_arr['unread_msg'] = $get->row_array();
			$get_unread_count = $get->num_rows();
			
			if($get_unread_count >0)
			{
				 $count+=$get_unread_count;
				 
			}
			
			$get_messages_arr['messages_result'][$i]['unread_msg']=$get_messages_arr['unread_msg']['num_messages'] ;
			
			}
		
	
	   $get_messages_arr['unread_message_count']=$count;
	   /* echo "<pre>";
		print_r($get_messages_arr['messages_result']);
		exit;*/
		
		
		
		$this->db->dbprefix('messages');
		$this->db->select('messages.*,admin.*');
        $this->db->join('admin', 'messages.from = admin.id');
		$this->db->group_by('messages.message_id');
		
		$this->db->where('messages.message_status',1);
		//$this->db->order_by('messages.id', DESC);
		$this->db->where('messages.to',$this->session->userdata('admin_id'));
		$this->db->order_by('messages.id', DESC);
		$get_read_messages= $this->db->get('messages');
	    // echo $this->db->last_query(); exit;
		
		$get_messages_arr['read_messages_result'] = $get_read_messages->result_array();
		$get_messages_arr['read_messages_count'] = $get_read_messages->num_rows;
		
		
		
		$this->db->dbprefix('messages');
		$this->db->group_by('messages.message_id');
		$this->db->where('messages.to',$this->session->userdata('admin_id'));
		$total_messages= $this->db->get('messages');
	    //echo $this->db->last_query(); exit;
	    $get_messages_arr['total_messages'] = $total_messages->num_rows;
		
		/*echo "<pre>";
		print_r($get_messages_arr['read_messages_result']);
		exit;
		*/
	
		
		return $get_messages_arr;		
		
	}//end get_inbox_messages
	

	public function update_inbox_message($message_id){
	
	    $update_data = array(
		    'message_status' => $this->db->escape_str(trim(1))	  
		    );		
		
		$this->db->dbprefix('messages');
		$this->db->where('message_id',$message_id);
		$this->db->where('to',$this->session->userdata('admin_id'));
	  	$get_messages= $this->db->update('messages',$update_data);
        //echo $this->db->last_query();
		
		return true;		
		
	}//end update_inbox_message
	
   
   

}
?>