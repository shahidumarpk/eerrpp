<?php
class mod_account_activation extends CI_Model {
	
	function __construct(){
		
        parent::__construct();
    }

	//Get All CMS pages.
	public function account_activation($customer_id,$activation_code){
		
		$this->db->dbprefix('customers');
		$this->db->where('id',$customer_id);
		$this->db->where('activation_code',$activation_code);
		$get_customer = $this->db->get('customers');

		//echo $this->db->last_query();
		
		$row_customer['customer_data'] = $get_customer->row_array();
		$row_customer['customer_count'] = $get_customer->num_rows;
		
		
		if($row_customer['customer_count'] >0)
		{
			
			
		$updat_data = array(
		   'is_verify_email' => 1,
		   'status' => 1
		   );
		   
			$this->db->dbprefix('customers');
		    $this->db->where('id',$customer_id);
		    $get_customer = $this->db->update('customers',$updat_data);
			
			
		//Welcome Email	
		
		$this->load->helper(array('email', 'url'));
        $this->load->model('site_preferences/mod_preferences');
		$this->load->model('email/mod_email');
			
		/********************************/
		//Email Contents
		
		$email_from_txt_arr = $this->mod_preferences->get_preferences_setting('email_from_txt');
		$email_from_txt = $email_from_txt_arr['setting_value'];
		$noreply_email_arr = $this->mod_preferences->get_preferences_setting('noreply_email');
		$noreply_email = $noreply_email_arr['setting_value'];
		
		$sitename_arr = $this->mod_preferences->get_preferences_setting('site_name');
		$site_name = $sitename_arr['setting_value'];
			
		$sitelogo_arr = $this->mod_preferences->get_preferences_setting('site_logo');
			
		$site_logo = $sitelogo_arr['setting_value'];
		
		
		
       // print_r($row_customer['customer_data']);
		
		$customer_first_last_name= $row_customer['customer_data']['first_name']." ".$row_customer['customer_data']['last_name'];
		$email_address=$row_customer['customer_data']['email_address'];
	    $user_name=$row_customer['customer_data']['username'];
	    $password=$row_customer['customer_data']['password'];
			
		
		$get_email_data = $this->mod_email->get_email(2);
		$email_subject = $get_email_data['email_arr']['email_subject'];
		$email_body = $get_email_data['email_arr']['email_body'];
		$search_arr = array('[SITE_URL]','[SITE_NAME]','[SITE_LOGO]','[CUSTOMER_FIRST_LAST_NAME]',' [USER_NAME]','[USER_PASSWORD]');
		$replace_arr = array(MURL,$site_name,$site_logo,$customer_first_last_name,$user_name,$password);
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
			
		}
		
		return $row_customer;
		
		
		
		
	}//end get_all_cms_pages

	
	
	
}
?>