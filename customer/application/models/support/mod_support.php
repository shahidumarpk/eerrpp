<?php
class mod_support extends CI_Model {
	
	function __construct(){
        parent::__construct();
    }
	
	//0 - Open Ticket , 1 - Process Ticket , 2 - Close Request , 3 - Closed Ticket  
	
	//Get Ticket Data Record
	public function get_ticket_detail_data($ticket_id){
		
		$ticket_id = '##'.$ticket_id.'##' ;
		
		$this->db->dbprefix('tickets');
		$this->db->select('tickets.*,customers.first_name,customers.last_name');
		$this->db->join('customers','customers.id = tickets.created_by','left');
		$this->db->where('ticket_number',$ticket_id);
		$this->db->where('is_parent','1');
		$get_ticket_data = $this->db->get('tickets');
		
		//echo $this->db->last_query();
		
		$row_data['ticket_data_arr'] = $get_ticket_data->row_array();
		$row_data['ticket_data_count'] = $get_ticket_data->num_rows;
		return $row_data;
		
	}//end get_customer_user_data


	//Get All Ticket replies User Record
	public function get_all_ticket_replies($ticket_id){
		$ticket_id = '##'.$ticket_id.'##' ;
		$this->db->dbprefix('tickets');
		$this->db->where('ticket_number',$ticket_id);
		$this->db->where('is_parent','0');
		$this->db->order_by('created_date DESC');
		
		$get_ticket_replies = $this->db->get('tickets');
		
		
		//echo $this->db->last_query(); exit;
		$row_ticket_replies['ticket_replies_arr'] = $get_ticket_replies->result_array();
		$row_ticket_replies['ticket_replies_count'] = $get_ticket_replies->num_rows;
		return $row_ticket_replies;
		
	}//end get_customer_user_data
	
	
	//Get All Ticket Attachment  Record
	public function get_ticket_attachments($ticket_id){
		$ticket_id = '##'.$ticket_id.'##' ;
		$this->db->dbprefix('email_attachments');
		$this->db->where('ticket_number',$ticket_id);
		$this->db->order_by('created_date DESC');
		$get_ticket_attachment = $this->db->get('email_attachments');
		
		
		//echo $this->db->last_query(); exit;
		$row_ticket_replies['ticket_attachment_arr'] = $get_ticket_attachment->result_array();
		$row_ticket_replies['ticket_attachment_count'] = $get_ticket_attachment->num_rows;
		return $row_ticket_replies;
		
	}//end get_customer_user_data
	
	
	
	//Get Total Number of Tickets in Database
	public function count_total_tickets(){
		
		$this->db->dbprefix('tickets');
		return $this->db->count_all("tickets");
		
	}//end count_total_tickets

	//Get All Tickets record.
	public function get_ticket_limit($start, $limit){
		
		$customer_id=$this->session->userdata('customer_id');
		
		$this->db->dbprefix('tickets');
		$this->db->where('is_parent','1');
		$this->db->where('customer_id',$customer_id);
		$this->db->limit($limit,$start);
		$this->db->order_by('created_date DESC');
		
		
		$this->db->dbprefix('tickets');
		$this->db->select('tickets.*,customers.first_name,customers.last_name');
		$this->db->join('customers','customers.id = tickets.created_by','left');
		$get_ticket_list_limit = $this->db->get('tickets');
		//echo $this->db->last_query();exit;
		
		
		
		$row_ticket_list_limit['ticket_list_result'] = $get_ticket_list_limit->result_array();
		
		
		$row_ticket_list_limit['ticket_list_result_count'] = $get_ticket_list_limit->num_rows;
		
		return $row_ticket_list_limit;		
		
		
	}//end get_all_ticket_limit
	

	//Ticket Reply Process
	public function ticket_reply($data){
	
		extract($data);
		
		$last_modified_date = date('Y-m-d G:i:s');
		$last_modified_ip = $this->input->ip_address();
		$last_modified_by = $this->session->userdata('admin_id');
		
		$upd_data = array(
		'ticket_status' => $this->db->escape_str(trim('1')));	
			
		//Updating the record into the database.
		$this->db->dbprefix('tickets');
		$this->db->where('ticket_number',$ticket_id);
		$upd_into_db = $this->db->update('tickets', $upd_data);
		//echo $this->db->last_query(); exit;
		
		$ticket_id = str_replace("#","",$ticket_id);
		$ticket_data = $this->mod_support->get_ticket_detail_data($ticket_id) ;
		$data['ticket_data_arr'] = $ticket_data['ticket_data_arr'];
		
		$ins_data = array(
		   'customer_id' => $this->db->escape_str(trim($data['ticket_data_arr']['customer_id'])),
		   'department_id' => $this->db->escape_str(trim($data['ticket_data_arr']['department_id'])),
		   'subject' => $this->db->escape_str(addslashes($data['ticket_data_arr']['subject'])),
		   'priority' => $this->db->escape_str(trim($data['ticket_data_arr']['priority'])),		   
		   'details' => $this->db->escape_str(addslashes(trim($ticket_reply))),
		   'commited_date' => $this->db->escape_str($data['ticket_data_arr']['commited_date']),
		   'user_type' => $this->db->escape_str('A'),
		   'ticket_number' => $this->db->escape_str($data['ticket_data_arr']['ticket_number']),
		   'ticket_status' => $this->db->escape_str('1'),
		   'created_by' => $this->db->escape_str(trim($last_modified_by)),
		   'created_date' => $this->db->escape_str(trim($last_modified_date))
		);		
  
		
		//Inserting the record into the database.
		$this->db->dbprefix('tickets');
		$ins_into_db = $this->db->insert('tickets', $ins_data);
		
		/********************************/
		//Email Contents
		if($ins_into_db){
			
		if($ins_data['customer_id'] == '0'){
			$customer_data = $this->mod_customer->get_guest_customer_profile($ins_data['ticket_number']);
			$email_address =  $customer_data['guest_customer_profile_arr']['email_address'] ;
		}else{
			$customer_data = $this->mod_customer->get_customer_profile($ins_data['customer_id']);
			$email_address =  $customer_data['customer_profile_arr']['email_address'] ;
		}
		
		$email_from_txt_arr = $this->mod_preferences->get_preferences_setting('email_from_txt');
		$email_from_txt = $email_from_txt_arr['setting_value'];
		$noreply_email_arr = $this->mod_preferences->get_preferences_setting('noreply_email');
		$noreply_email = $noreply_email_arr['setting_value'];
		
		 $sitename_arr = $this->mod_preferences->get_preferences_setting('site_name');
		 $site_name = $sitename_arr['setting_value'];
			
		 $sitelogo_arr = $this->mod_preferences->get_preferences_setting('site logo');
	     $site_logo = $sitelogo_arr['setting_value'];
		
		
	     $get_email_data = $this->mod_email->get_email(9);
		 $email_body = $get_email_data['email_arr']['email_body'];
		 
		 $ticket_reply=nl2br($ticket_reply);
			
		 $search_arr = array('[SITE_URL]','[SITE_NAME]','[SITE_LOGO]','[TICKET_NUMBER]','[TICKET_SUBJECT]','[TICKET_REPLY]');
		 $replace_arr = array(MURL,$site_name,$site_logo,$ticket_number,$subject,$ticket_reply);
		 $email_body = str_replace($search_arr,$replace_arr,$email_body);
		
		
	   
		$email_subject = 'RE: '.$data['ticket_data_arr']['ticket_number'].' '.$data['ticket_data_arr']['subject'] ;
		
		
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
			//Unset POST values from session
		
			return true ;
		
		}else{
			
			return false ;
		}
		
	}//end Ticket Reply Process
	
	
	
	//Ticket Reply Process
	public function close_ticket($ticket_id){
	
		$last_modified_date = date('Y-m-d G:i:s');
		$last_modified_ip = $this->input->ip_address();
		$last_modified_by = $this->session->userdata('admin_id');
		
		$upd_data = array(
		'ticket_status' => $this->db->escape_str(trim('2')));	 // Close Request Sent.
			
		
		$ticket_id = str_replace("#","",$ticket_id);
		$ticket_data = $this->mod_support->get_ticket_detail_data($ticket_id) ;
		$data['ticket_data_arr'] = $ticket_data['ticket_data_arr'];
		//echo "<pre>"; print_r($data['ticket_data_arr']); exit;
		
		
		$ins_data = array(
		   'customer_id' => $this->db->escape_str(trim($data['ticket_data_arr']['customer_id'])),
		   'department_id' => $this->db->escape_str(trim($data['ticket_data_arr']['department_id'])),
		   'subject' => $this->db->escape_str(addslashes($data['ticket_data_arr']['subject'])),
		   'priority' => $this->db->escape_str(trim($data['ticket_data_arr']['priority'])),		   
		   'details' => $this->db->escape_str('Close Request Sent'),
		   'commited_date' => $this->db->escape_str($data['ticket_data_arr']['commited_date']),
		   'user_type' => $this->db->escape_str('A'),
		   'ticket_number' => $this->db->escape_str($data['ticket_data_arr']['ticket_number']),
		   'ticket_status' => $this->db->escape_str('2'),
		   'created_by' => $this->db->escape_str(trim($last_modified_by)),
		   'created_date' => $this->db->escape_str(trim($last_modified_date))
		);		
  
		
		//Inserting the record into the database.
		$this->db->dbprefix('tickets');
		$ins_into_db = $this->db->insert('tickets', $ins_data);
		
		/********************************/
		//Email Contents
		if($ins_into_db){
			
		if($ins_data['customer_id'] == '0'){
			$customer_data = $this->mod_customer->get_guest_customer_profile($ins_data['ticket_number']);
			$email_address =  $customer_data['guest_customer_profile_arr']['email_address'] ;
		}else{
			$customer_data = $this->mod_customer->get_customer_profile($ins_data['customer_id']);
			$email_address =  $customer_data['customer_profile_arr']['email_address'] ;
		}
		
		$email_from_txt_arr = $this->mod_preferences->get_preferences_setting('email_from_txt');
		$email_from_txt = $email_from_txt_arr['setting_value'];
		$noreply_email_arr = $this->mod_preferences->get_preferences_setting('noreply_email');
		$noreply_email = $noreply_email_arr['setting_value'];
		
		
		$sitename_arr = $this->mod_preferences->get_preferences_setting('site_name');
		$site_name = $sitename_arr['setting_value'];
			
	    $sitelogo_arr = $this->mod_preferences->get_preferences_setting('site logo');
	    $site_logo = $sitelogo_arr['setting_value'];
		
		//Email Contents
			$get_email_data = $this->mod_email->get_email(3);
			
			//$email_
			$email_subject = 'RE: '.$data['ticket_data_arr']['ticket_number'].' '.$data['ticket_data_arr']['subject'] ;
			
			$email_body = $get_email_data['email_arr']['email_body'];
			
			$ticket_subject=$data['ticket_data_arr']['subject'];
			
			$link = FRONT_SURL.'customer/ticket_feedback/ticket-feedback/feedback/'.$ticket_id ;  
			$link = '<a href="'.$link.'">CLOSE TICKET</a>';
			
			$search_arr = array('[SITE_URL]','[SITE_NAME]','[SITE_LOGO]','[TICKET_NUMBER]','[CLOSE_TICKET_LINK]','[TICKET_NUMBER]','[TICKET_SUBJECT]');
			$replace_arr = array(MURL,$site_name,$site_logo,$ticket_id,$link,$ticket_id,$ticket_subject);
			
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
			//Unset POST values from session
		
			return true ;
		
		}else{
			
			return false ;
		}
		
	}//end Ticket Reply Process
	
	
	
	public function add_ticket($data){
		
		extract($data);
		
		
		
		$created_date = date('Y-m-d G:i:s');
		$created_by = $this->session->userdata('admin_id');
		
		$this->load->model('common/mod_common');
		
		$ticket_number=$this->mod_common->random_ticket_number(8);
		
		
		$ins_data = array(
		   'customer_id' => $this->db->escape_str(trim($customer_id)),
		   'subject' => $this->db->escape_str(trim($subject)),
		   'priority' => $this->db->escape_str(trim($proirity)),
		   'details' => $this->db->escape_str(trim(nl2br($details))),
		   'ticket_number' => $this->db->escape_str(trim($ticket_number)),
		   'is_parent' => 1,
		   'commited_date' => $this->db->escape_str(trim($commited_date)),
		   'ticket_status' => $this->db->escape_str(trim($status)),
		   'created_by' => $this->db->escape_str(trim($customer_id)),
		   'created_date' => $this->db->escape_str(trim($created_date))
		);		

		//Inserting the record into the database.
		$this->db->dbprefix('tickets');
		$ins_into_db = $this->db->insert('tickets', $ins_data);
		
		
		    //fetching email data from site preferences
		    $sitename_arr = $this->mod_preferences->get_preferences_setting('site_name');
		    $site_name = $sitename_arr['setting_value'];
			
		    $sitelogo_arr = $this->mod_preferences->get_preferences_setting('site logo');
	     	$site_logo = $sitelogo_arr['setting_value'];
		
		
	        $get_email_data = $this->mod_email->get_email(5);
			
			$email_body = $get_email_data['email_arr']['email_body'];
			
			$search_arr = array('[SITE_URL]','[SITE_NAME]','[SITE_LOGO]','[TICKET_NUMBER]','[TICKET_SUBJECT]');
			$replace_arr = array(MURL,$site_name,$site_logo,$ticket_number,$subject);
			$email_body = str_replace($search_arr,$replace_arr,$email_body);
		 
        
		    $this->db->dbprefix('site_preferences');
		    $this->db->where('id',12);
		    $get = $this->db->get('site_preferences');
		    $email_data= $get->row_array();
		    $from=$email_data['setting_value'];
		  
		
			 
		  $this->db->dbprefix('customers');
		  $this->db->where('id',$customer_id);
		  $get_customer_data = $this->db->get('customers');
		  $customer_record=$get_customer_data->row_array();
		  $customer_name=$customer_record['first_name'].$customer_record['last_name'];
		  
		  $to_customer=$customer_record['email_address'];
	
	      $subjt = $ticket_number.' '.stripslashes($subject) ;
	
	      $this->load->model('site_preferences/mod_preferences');		 
		  $email_from_txt_arr = $this->mod_preferences->get_preferences_setting('email_from_txt');
		  $email_from_txt = $email_from_txt_arr['setting_value'];
		  $noreply_email_arr = $this->mod_preferences->get_preferences_setting('noreply_email');
		  $noreply_email = $noreply_email_arr['setting_value'];
		  $subject = 'Inno Tech Invoice '.date('d F,Y').'';
		
		    //Send Email
		    $this->load->helper(array('email', 'url'));
			
		
		    //Preparing Sending Email
			$config['charset'] = 'utf-8';
			$config['mailtype'] = 'html';
			$config['wordwrap'] = TRUE;			
			$config['protocol'] = 'mail';
			
			$this->load->library('email',$config);
 
			$this->email->from($noreply_email, $email_from_txt);
			$this->email->to($to_customer);
			$this->email->subject($subjt);
			$this->email->message($email_body);
			$this->email->send();
		  // echo  $this->email->print_debugger(); exit;
		   
		  
		    $this->email->clear();
		
	     return true;
		
		
	}//end add_ticket
	
	
	
	public function get_customer_tickets($customer_id){
		
		$this->db->dbprefix('tickets');
		$this->db->where('is_parent','1');
		$this->db->where('customer_id',$customer_id);
		$this->db->limit(5);
		$this->db->order_by('created_date DESC');
		
		$get_ticket_list_limit = $this->db->get('tickets');
		//echo $this->db->last_query();exit;
		
		$row_ticket_list_limit['ticket_list_result'] = $get_ticket_list_limit->result_array();
		$row_ticket_list_limit['ticket_list_result_count'] = $get_ticket_list_limit->num_rows;
		
		return $row_ticket_list_limit;		
		
		
	}//end get_customer_tickets
	
}
?>