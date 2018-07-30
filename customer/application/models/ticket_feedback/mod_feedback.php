<?php
class mod_feedback extends CI_Model {
	function __construct(){
		
        parent::__construct();
    }
	

	public function add_feedback($data){

		extract($data);
	
		$ins_data = array(
		   'ticket_id' => $this->db->escape_str(trim($ticket_id)),
		   'issue_resolved' => $this->db->escape_str(trim($issue_resolved)),
		   'customer_support' => $this->db->escape_str(trim($customer_support)),
		   'customer_satisfaction' => $this->db->escape_str(trim($customer_satisfaction)),
		   'customer_feedback' => $this->db->escape_str(trim($customer_feedback))		   
		);
		
		//Insert the record into the database.
		$this->db->dbprefix('ticket_feedback');
		$ins_into_db = $this->db->insert('ticket_feedback', $ins_data);
		
		
		//fetching email data from site preferences
		$this->db->dbprefix('site_preferences');
		$this->db->where('id',3);
		$get = $this->db->get('site_preferences');
		$email_data= $get->row_array();
		
	    $from=$email_data['setting_value'];
		
		
		//fetching customer email  
	    $new_ticket_id="##".$ticket_id."##";
		$this->db->dbprefix('tickets');
		$this->db->where('ticket_number',$new_ticket_id);
		$get_customer = $this->db->get('tickets');
		$customer_data=$get_customer->row_array();
		
	    $subject="RE: ".$new_ticket_id." ".$customer_data['subject']; 
		  
		 //Fetching data from customer table
		  $customer_id=$customer_data['customer_id'];
		  
		 //Cheking the customer record
		 if($customer_id !=0){ 
		  $this->db->dbprefix('customers');
		  $this->db->where('id',$customer_id);
		  $get_customer_data = $this->db->get('customers');
		  $customer_record=$get_customer_data->row_array();
		  
		  $to=$customer_record['email_address'];// if customer is regular
		  
		 }
		 else{
			 
			 $this->db->dbprefix('guest_customers');
		     $this->db->where('ticket_number',$new_ticket_id);
		     $get_customer_data = $this->db->get('guest_customers');
		     $customer_record=$get_customer_data->row_array();
			 
			 $to=$customer_record['email_address'];// if customer is Guest
			 
			 }
		  
		// $to=$customer_record['email_address'];
		
		 $ticket_id=$this->input->post('ticket_id');
		 $customer_feedback=$this->input->post('customer_feedback');
		 $issue_resolved=$this->input->post('issue_resolved');
		 $customer_support=$this->input->post('customer_support');
		 $customer_satisfaction=$this->input->post('customer_satisfaction');
	
        $msg='<table width="351" height="364" border="0">
        <tr>
          <td width="341" height="51">Ticket ID :  .'.$ticket_id.'.</td>
        </tr>
       <tr>
        <td width="341" height="51">is your issue resolved?</td>
       </tr>
       <tr>
         <td height="27">.'.$issue_resolved.'.</td>
       </tr>
       <tr>
         <td height="81">Have the customer support representative served you well?</td>
       </tr>
       <tr>
          <td height="30">.'.$customer_support.'.</td>
       </tr>
       <tr>
         <td height="48">Are you satisfied with our services?</td>
       </tr>
        <tr>
           <td>.'.$customer_satisfaction.'.</td>
       </tr>
       <tr>
         <td height="39"> Customer Feedback :</td>
        </tr>
       <tr>
          <td height="45">.'.$customer_feedback.'.</td>
        </tr>
       </table>';
		
		$this->load->helper(array('email', 'url'));
		//send email
		//Preparing Sending Email
			$config['charset'] = 'utf-8';
			$config['mailtype'] = 'html';
			$config['wordwrap'] = TRUE;			
			$config['protocol'] = 'mail';
			
			$this->load->library('email',$config);

			$this->email->from($from, $subject);
			$this->email->to($to);
			$this->email->subject($subject);
			$this->email->message($msg);
			$this->email->send();
		    $this->email->print_debugger();
			
		
			$this->email->clear();
	
        
	    //updating Ticket record
		$update_ticket = array(
		   'ticket_status' =>3
		  );
		
		$new_ticket_id="##".$ticket_id."##";
		$this->db->dbprefix('tickets');
		$this->db->where('ticket_number',$new_ticket_id);
		
		$upd_db = $this->db->update('tickets', $update_ticket);
		
		return $upd_db;
		
		
		
		
		
		
	}//end get_admin_menu_list
	
	public function get_feedback($ticket_id){
		
		$new_ticket_id="##".$ticket_id."##";
		$this->db->dbprefix('tickets');
		
		$this->db->where('ticket_number',$new_ticket_id);
		
		$get = $this->db->get('tickets');
		 
		return  $get->row_array();
		
		}

}

?>