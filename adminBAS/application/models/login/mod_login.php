<?php
class mod_login extends CI_Model {
	function __construct(){
		
        parent::__construct();
        
    }
	
	//Validation of Login
	public function validate_credentials($username, $password,$user_login_type){
		
		
		$permission = $user_login_type;
		
		if($permission=="desktop"){
			
			$this->db->dbprefix('admin');
			$this->db->select('admin.*,admin_roles.role_title, admin_roles.permissions');
			$this->db->where('username', strip_quotes($username));
			$this->db->where('password', strip_quotes(md5($password)));
			$this->db->join('admin_roles','admin_roles.id = admin.admin_role_id');
			$this->db->where('admin.status',1);
			$this->db->where('admin_roles.status',1);
			$get = $this->db->get('admin');
			//$user_arr= $get->row_array();
			
			
		}else{
			
			
			$this->db->dbprefix('admin');
			$this->db->select('admin.*,admin_roles.role_title, admin_roles.permissions_mobile as permissions');
			$this->db->where('username', strip_quotes($username));
			$this->db->where('password', strip_quotes(md5($password)));
			$this->db->join('admin_roles','admin_roles.id = admin.admin_role_id');
			$this->db->where('admin.status',1);
			$this->db->where('admin_roles.status',1);
			$get = $this->db->get('admin');
			//$user_arr= $get->row_array();
			
		}
		
		
		if($get->num_rows > 0){
			
			$user_arr= $get->row_array();
			
			
		   $user_id= $user_arr['id'];
			
			$created_date = date('Y-m-d G:i:s');
		    $created_by_ip = $this->input->ip_address();
		   
			$ins_data = array(
					   'user_id' => $this->db->escape_str(trim($user_id)),
					   'login_type' => $this->db->escape_str(1),
					   'created_by' => $this->db->escape_str(trim($user_id)),
					   'created_date' => $this->db->escape_str(trim($created_date)),
					   'created_by_ip' => $this->db->escape_str(trim($created_by_ip))
					);	
					
          $this->db->dbprefix('logging');
		  $ins_into_db = $this->db->insert('logging', $ins_data);
		
		  return $get->row_array();
		/*  print_r($user_arr);
				echo  "<hr>";
				exit;*/
			
			} 
		

	}//end function validate	
	
	
	public function user_login_type(){
	//Mobile Detection Code 
    
    $tablet_browser = 0;
    $mobile_browser = 0;
    if (preg_match('/(tablet|ipad|playbook)|(android(?!.*(mobi|opera mini)))/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {
     $tablet_browser++;
    }
    if (preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone|android|iemobile)/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {
     $mobile_browser++;
    }
    if ((strpos(strtolower($_SERVER['HTTP_ACCEPT']),'application/vnd.wap.xhtml+xml') > 0) or ((isset($_SERVER['HTTP_X_WAP_PROFILE']) or isset($_SERVER['HTTP_PROFILE'])))) {
     $mobile_browser++;
    }
    $mobile_ua = strtolower(substr($_SERVER['HTTP_USER_AGENT'], 0, 4));
    $mobile_agents = array(
     'w3c ','acs-','alav','alca','amoi','audi','avan','benq','bird','blac',
     'blaz','brew','cell','cldc','cmd-','dang','doco','eric','hipt','inno',
     'ipaq','java','jigs','kddi','keji','leno','lg-c','lg-d','lg-g','lge-',
     'maui','maxo','midp','mits','mmef','mobi','mot-','moto','mwbp','nec-',
     'newt','noki','palm','pana','pant','phil','play','port','prox',
     'qwap','sage','sams','sany','sch-','sec-','send','seri','sgh-','shar',
     'sie-','siem','smal','smar','sony','sph-','symb','t-mo','teli','tim-',
     'tosh','tsm-','upg1','upsi','vk-v','voda','wap-','wapa','wapi','wapp',
     'wapr','webc','winw','winw','xda ','xda-');
    if (in_array($mobile_ua,$mobile_agents)) {
     $mobile_browser++;
    }
    if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']),'opera mini') > 0) {
     $mobile_browser++;
     //Check for tablets on opera mini alternative headers
     $stock_ua = strtolower(isset($_SERVER['HTTP_X_OPERAMINI_PHONE_UA'])?$_SERVER['HTTP_X_OPERAMINI_PHONE_UA']:(isset($_SERVER['HTTP_DEVICE_STOCK_UA'])?$_SERVER['HTTP_DEVICE_STOCK_UA']:''));
     if (preg_match('/(tablet|ipad|playbook)|(android(?!.*mobile))/i', $stock_ua)) {
       $tablet_browser++;
     }
    }
    if ($tablet_browser > 0) {
		$login_type  = 'mobile';        
	}
    else if ($mobile_browser > 0) {
		$login_type  = 'mobile';       
    }
    else{
		$login_type  = 'desktop';
	}   

	return $login_type ;    		
     }

	

	//Email Address Validation
	public function verify_email($email_address){
		
		$this->db->dbprefix('admin');
		$this->db->where('email_address', strip_quotes($email_address));
		$this->db->where('status',1);
		$get = $this->db->get('admin');
		
		//echo $this->db->last_query(); 		exit;

		if($get->num_rows > 0) return $get->row_array();

	}//end function verify_email	

	//Send New password
	public function send_new_password($admin_id){
		
		//User data
		$get_user_data = $this->mod_admin->get_admin_user_data($admin_id);

		$user_first_last_name = ucwords(strtolower(stripslashes($get_user_data['admin_user_arr']['first_name'].' '.$get_user_data['admin_user_arr']['last_name'])));
		$username = stripslashes($get_user_data['admin_user_arr']['username']);
		$new_password = $this->mod_common->random_number_generator(6);
		$email_address = stripslashes(trim($get_user_data['admin_user_arr']['email_address']));
		
		//Updating New Password into the database

		$last_modified_date = date('Y-m-d G:i:s');
		$last_modified_ip = $this->input->ip_address();
		$last_modified_by = $this->session->userdata('admin_id');

		$upd_data = array(
		   'password' => $this->db->escape_str(trim(md5($new_password))),
		   'last_modified_by' => $this->db->escape_str(trim($last_modified_by)),
		   'last_modified_date' => $this->db->escape_str(trim($last_modified_date)),
		   'last_modified_ip' => $this->db->escape_str(trim($last_modified_ip))
		);

		//Update the record into the database.
		$this->db->dbprefix('admin');
		$this->db->where('id',$admin_id);
		$upd_into_db = $this->db->update('admin', $upd_data);
		
		if($upd_into_db){
			
			$email_from_txt_arr = $this->mod_preferences->get_preferences_setting('email_from_txt');
			$email_from_txt = $email_from_txt_arr['setting_value'];
			
			$noreply_email_arr = $this->mod_preferences->get_preferences_setting('noreply_email');
			$noreply_email = $noreply_email_arr['setting_value'];
			
			$sitename_arr = $this->mod_preferences->get_preferences_setting('site_name');
		    $site_name = $sitename_arr['setting_value'];
			
	       $sitelogo_arr = $this->mod_preferences->get_preferences_setting('site logo');
	       $site_logo = $sitelogo_arr['setting_value'];
			
			
			//Email Contents
			$get_email_data = $this->mod_email->get_email(1);
			
			$email_subject = $get_email_data['email_arr']['email_subject'];
			$email_body = $get_email_data['email_arr']['email_body'];
			
			$search_arr = array('[SITE_URL]','[SITE_LOGO]','[USER_FIRST_LAST_NAME]','[USER_USERNAME]','[USER_NEWPASSWORD]');
			$replace_arr = array(FRONT_SURL,$site_logo,$user_first_last_name,$username,$new_password);
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
		
		$this->db->dbprefix('admin');
		$this->db->where('id', strip_quotes($user_id));
		$update_st = $this->db->update('admin', $data);

	}//end function validate	
	
	
	
}




?>