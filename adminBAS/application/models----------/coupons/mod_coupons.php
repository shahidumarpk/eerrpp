<?php
class mod_coupons extends CI_Model {
	
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


	//Add new coupons
	public function add_coupons($data){
		
		extract($data);
	
	  if($expiry_date==""){
		  
		 
		  $date = strtotime(date('m/d/Y'));
          $new_date = date("m/d/Y", strtotime("+1 month", $date)); 
		 
		}
	 else{
			
		    $new_date=$expiry_date;
			
		 }	
		
		
		for($i=0; $i<$no_of_coupons; $i++)
		{
			$coupons_code = $this->mod_common->random_alphanumaric_generator(7);
		    $coupons_code = $this->mod_coupons->coupon_code_generator($coupons_code);
		
		
		   $created_date = date('Y-m-d G:i:s');
		   $created_by_ip = $this->input->ip_address();
		   $created_by = $this->session->userdata('admin_id');

		   $ins_data = array(
		    'coupon_code' => $this->db->escape_str(trim($coupons_code)),
		    'discount_amount' => $this->db->escape_str(trim($discount_amount)),
		    'expiry_date' => $this->db->escape_str(trim($new_date)),
		    'created_by' => $this->db->escape_str(trim($created_by)),
		    'created_date' => $this->db->escape_str(trim($created_date)),
		    'created_by_ip' => $this->db->escape_str(trim($created_by_ip))
		    );		

		   //Inserting the record into the database.
		  $this->db->dbprefix('coupons');
		  $ins_into_db = $this->db->insert('coupons', $ins_data);
		
			 
		}//End For loop
		
		
	     return true;
		
		
	}//end add_coupons

	//Coupon Generater.
	public function coupon_code_generator($coupon_code){

			$this->db->dbprefix('coupons');
			$this->db->select('id');
			$this->db->where('coupon_code', $coupon_code); 
			$rs_count_rec = $this->db->get('coupons');
		    $this->db->last_query();
			
			if($rs_count_rec->num_rows == 0) return $coupon_code;
			else{
				//Add Postfix and generate concatenate.
				$generate_coupon_code = $this->mod_common->random_alphanumaric_generator(7);
				return $this->mod_common->coupon_code_generator($generate_coupon_code);
				
			}//end if
		
	}//end coupon_code_generator($coupon_code)
	
	
	//Coupon Generater.
	public function coupon_authentication($coupon_code){

            $date=date('m/d/Y');
			$this->db->dbprefix('coupons');
			$this->db->where('coupon_code', $coupon_code); 
			$this->db->where('is_used ', '0'); 
			$this->db->where('status ', '0');
			$this->db->where('expiry_date >', $date);
			$rs_count_rec = $this->db->get('coupons');
		   //echo $this->db->last_query(); exit;
		   	if($rs_count_rec->num_rows == 0) 
		   		return "Invalid coupon code.|0";
			else{
			$get_coupons_arr['coupons_result'] = $rs_count_rec->result_array();
				return "|".$get_coupons_arr['coupons_result'][0]['discount_amount'] ;
			}//end if
		
	}//end coupon_code_generator($coupon_code)
		

	
	public function get_coupons(){
		
	
		$this->db->dbprefix('coupons');
		
		$get_coupons= $this->db->get('coupons');

		$get_coupons_arr['coupons_result'] = $get_coupons->result_array();
		
		
		$get_coupons_arr['coupons_count'] = $get_coupons->num_rows;
		
		
		return $get_coupons_arr;		
		
	}//end get_coupons
	
	
	
	public function delete_coupons($id){
		
		
		$upd_data = array(
		   'status' =>1
		);		

       //Update the record into the database.
		$this->db->dbprefix('coupons');
		$this->db->where('id',$id);
		$upd_into_db = $this->db->update('coupons', $upd_data);
		
	    return true;
			//echo $this->db->last_query();

		
	}//end delete_coupons
	
   
   public function send_coupons($data){
	   
	   extract($data);
	   
	   $upd_data = array(
		   'name' =>$this->db->escape_str(trim($name)),
		   'email_address' =>$this->db->escape_str(trim($email_address)),
		   'is_send' =>1
		   
		);		

       //Update the record into the database.
		$this->db->dbprefix('coupons');
		$this->db->where('coupon_code',$coupon_code);
		$upd_into_db = $this->db->update('coupons', $upd_data);
		
		
		$this->db->where('coupon_code',$coupon_code);
		$get_coupon = $this->db->get('coupons');
		$get_coupon_arr['coupons_result'] = $get_coupon->row_array();
		
	    $expiry_date = date('d F,Y', strtotime($get_coupon_arr['coupons_result']['expiry_date']));
		
		
			$customer_first_last_name = $name ; // First Name Last Name
			
			//Email Contents
			$get_email_data = $this->mod_email->get_email(4);
			$email_subject = $get_email_data['email_arr']['email_subject'];
			$email_body = $get_email_data['email_arr']['email_body'];
			
			$sitename_arr = $this->mod_preferences->get_preferences_setting('site_name');
		    $site_name = $sitename_arr['setting_value'];
			
		    $sitelogo_arr = $this->mod_preferences->get_preferences_setting('site logo');
	     	$site_logo = $sitelogo_arr['setting_value'];
			
			$search_arr = array('[SITE_URL]','[SITE_NAME]','[SITE_LOGO]','[CUSTOMER_FIRST_LAST_NAME]','[SITE_NAME]','[COUPON_CODE]','[COUPON_EXPIRY_DATE]');
			$replace_arr = array(MURL,$site_name,$site_logo,$customer_first_last_name,$site_name,$coupon_code,$expiry_date);
			$email_body = str_replace($search_arr,$replace_arr,$email_body);
			
			//Send Email
		    $this->load->helper(array('email', 'url'));
		    //Preparing Sending Email
			$config['charset'] = 'utf-8';
			$config['mailtype'] = 'html';
			$config['wordwrap'] = TRUE;			
			$config['protocol'] = 'mail';
			
			$this->load->library('email',$config);

		  	 
		   $email_from_txt_arr = $this->mod_preferences->get_preferences_setting('email_from_txt');
		   $email_from_txt = $email_from_txt_arr['setting_value'];
		   $noreply_email_arr = $this->mod_preferences->get_preferences_setting('noreply_email');
		   $noreply_email = $noreply_email_arr['setting_value'];
		   
			 
			$this->email->from($noreply_email, $email_from_txt);
			$this->email->to($email_address);
			$this->email->subject($email_subject);
			$this->email->message($email_body);
			$this->email->send();
		    $this->email->print_debugger();
		   
		  
		    $this->email->clear();
			
			
		return true;
	   
	   
	 }	

}
?>