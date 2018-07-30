<?php
class mod_login extends CI_Model {
	function __construct(){
		
        parent::__construct();
        
    }
	
	//Validation of Login
	public function validate_credentials($username, $password){
		
		$this->db->dbprefix('customers');
		
		$this->db->where('username', strip_quotes($username));
		$this->db->where('password', strip_quotes(md5($password)));
		$this->db->where('status',1);
		$get = $this->db->get('customers');
		
		$get->row_array();
		

		//echo $this->db->last_query(); 		exit;
		
		if($get->num_rows > 0) return $get->row_array();

	}//end function validate	

	//Email Address Validation
	public function verify_email($email_address){
		
		$this->db->dbprefix('customers');
		$this->db->where('email_address', strip_quotes($email_address));
		$this->db->where('status',1);
		$get = $this->db->get('customers');
		
		//echo $this->db->last_query(); 		exit;

		if($get->num_rows > 0) return $get->row_array();

	}//end function verify_email	
	
	
	//Random Password Generator
	public function random_number_generator($digit){

		$randnumber = '';
		$totalChar = $digit;  //length of random number
		$salt = "0123456789";  // salt to select chars
		srand((double)microtime()*1000000); // start the random generator
		$password=""; // set the inital variable
		
		for ($i=0;$i<$totalChar;$i++)  // loop and create number
		$randnumber = $randnumber. substr ($salt, rand() % strlen($salt), 1);
		
		return $randnumber;
		
	}// random_password_generator()
	

	//Send New password
	public function send_new_password($customer_id){
		
		//Customer data
	    $this->db->dbprefix('customers');
		$this->db->where('id', strip_quotes($customer_id));
		$this->db->where('status',1);
		$get = $this->db->get('customers');
		$customer_data=$get->row_array();

	    $customer_first_last_name = ucwords(strtolower(stripslashes($customer_data['first_name'].' '.$customer_data['last_name'])));
		
		
		
		$username = stripslashes($customer_data['username']);
		
	    $new_password = $this->mod_login->random_number_generator(6);
	
		
		$email_address = stripslashes(trim($customer_data['email_address']));
		
		//Updating New Password into the database

		$last_modified_date = date('Y-m-d G:i:s');
		$last_modified_ip = $this->input->ip_address();
		$last_modified_by = $this->session->userdata('customer_id');
	

		$upd_data = array(
		   'password' => $this->db->escape_str(trim(md5($new_password))),
		   'last_modified_by' => $this->db->escape_str(trim($last_modified_by)),
		   'last_modified_date' => $this->db->escape_str(trim($last_modified_date)),
		   'last_modified_ip' => $this->db->escape_str(trim($last_modified_ip))
		);

		//Update the record into the database.
		$this->db->dbprefix('customers');
		$this->db->where('id',$customer_id);
		$upd_into_db = $this->db->update('customers', $upd_data);
		
		if($upd_into_db){
			
			$email_from_txt_arr = $this->mod_preferences->get_preferences_setting('email_from_txt');
			$email_from_txt = $email_from_txt_arr['setting_value'];
			
			$noreply_email_arr = $this->mod_preferences->get_preferences_setting('noreply_email');
			$noreply_email = $noreply_email_arr['setting_value'];
			
			
			$sitename_arr = $this->mod_preferences->get_preferences_setting('site_name');
			$site_name = $sitename_arr['setting_value'];
			
			$sitelogo_arr = $this->mod_preferences->get_preferences_setting('site_logo');
			
		    $site_logo = $sitelogo_arr['setting_value'];
		
		
			//Email Contents
			$get_email_data = $this->mod_email->get_email(8);
			
		    $email_subject = $get_email_data['email_arr']['email_subject'];
			$email_body = $get_email_data['email_arr']['email_body'];
			
			
			$search_arr = array('[SITE_URL]','[SITE_NAME]','[SITE_LOGO]','[CUSTOMER_FIRST_LAST_NAME]','[USER_NAME]','[USER_NEWPASSWORD]');
			$replace_arr = array(FRONT_SURL,$site_name,$site_logo,$customer_first_last_name,$username,$new_password);
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
			//$this->email->print_debugger(); exit;
			$this->email->clear();
			
			return true;

		}else{
			return false;	
		}//end if($upd_into_db)
		
	}//end function verify_email	

	//Update Last Sigin Date in Admin
	public function update_signin_date($user_id){
		
		$data = array(
		   'last_signin_date' => date('Y-m-d G:i:s'),
		   'last_signin_ip' => $this->input->ip_address(),
		);
		
		$this->db->dbprefix('customers');
		$this->db->where('id', strip_quotes($user_id));
		$update_st = $this->db->update('customers', $data);

	}//end function validate	
	
	
	
	//Get Customer Data
	public function get_customer($customer_id){
		
		$this->db->dbprefix('customers');
		$this->db->where('id',$customer_id);
		$get = $this->db->get('customers');
		
		//echo $this->db->last_query(); 		exit;

		if($get->num_rows > 0) return $get->row_array();

	}//end function verify_email	
}




?>