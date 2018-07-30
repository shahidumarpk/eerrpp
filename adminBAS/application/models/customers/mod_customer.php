<?php
class mod_customer extends CI_Model {
	
	function __construct(){
        parent::__construct();
    }

	## UPDATE PROFILE ##

	//Get customer Profile Record
	public function get_customer_profile($customer_id){
		
		$this->db->select('id, first_name, last_name, username, email_address, profile_image,country_name,state_name,city_name');
		$this->db->dbprefix('customers');
		$this->db->where('id',$customer_id);
		$get_customer_profile = $this->db->get('customers');
		//echo $this->db->last_query(); exit;
		$row_customer['customer_profile_arr'] = $get_customer_profile->row_array();
		$row_customer['customer_profile_count'] = $get_customer_profile->num_rows;
		return $row_customer;
		
	}//end get_customer_profile
	
	public function get_all_projects($customer_id,$status){
		
		
		if($status !="" and $status==0 ){
			
			
	    $this->db->dbprefix('projects');
		$this->db->where('customer_id',$customer_id);
		$this->db->order_by('id',DESC);
		$get_projects= $this->db->get('projects');
			
		
		
			
		}
		
		elseif($status==1 ){
			
			
	    $this->db->dbprefix('projects');
		$this->db->where('customer_id',$customer_id);
		$this->db->where('status',1);
		$this->db->order_by('id',DESC);
		$get_projects= $this->db->get('projects');
			
		
		
			
		}
		elseif($status==2 ){
			
			
	    $this->db->dbprefix('projects');
		$this->db->where('customer_id',$customer_id);
		$this->db->where('status',2);
		$this->db->order_by('id',DESC);
		$get_projects= $this->db->get('projects');
			
			
		}
		elseif($status==3 ){
			
			
	    $this->db->dbprefix('projects');
		$this->db->where('customer_id',$customer_id);
		$this->db->where('status',3);
		$this->db->order_by('id',DESC);
		$get_projects= $this->db->get('projects');
			
		
		
			
		}
		else{
			
			
		
		$this->db->dbprefix('projects');
		
		$where="(status=0 or status=1)";
		$this->db->where('customer_id',$customer_id);
		$this->db->where($where);
		$this->db->order_by('id',DESC);
		$get_projects= $this->db->get('projects');
		//echo $this->db->last_query();exit;
		}
		//echo $this->db->last_query();
		
		$row_projects_arr['projects_arr'] = $get_projects->result_array();
		
		$row_projects_arr['projects_count'] = $get_projects->num_rows();
	
		return $row_projects_arr;


		
		}
	
	
	//Get  Guest Customer Profile Record
	public function get_guest_customer_profile($ticket_number){
		
		$this->db->select('id,customer_name,email_address');
		$this->db->dbprefix('guest_customers');
		$this->db->where('ticket_number',$ticket_number);
		$get_guest_customer_profile = $this->db->get('guest_customers');

		//echo $this->db->last_query();
		$row_guest_customer['guest_customer_profile_arr'] = $get_guest_customer_profile->row_array();
		$row_guest_customer['guest_customer_profile_count'] = $get_guest_customer_profile->num_rows;
		return $row_guest_customer;
		
	}//end get_guest_customer_profile

	
	## customer USER MANAGEMENT ##
	
	//Get All Customer List Record
	public function get_all_customers(){
		$this->db->select('id,first_name, last_name');
		$this->db->dbprefix('customers');
		$get_customer = $this->db->get('customers');
		//echo $this->db->last_query();
		
		
		//echo $this->db->last_query(); exit;
		$row_all_customers['customers_list_arr'] = $get_customer->result_array();
		$row_all_customers['customers_list_count'] = $get_customer->num_rows;
		return $row_all_customers;
		
	}//end get_customer_user_data
	
	
	//Get customer User Record
	public function get_customer_user_data($customer_id){
		
		$this->db->dbprefix('customers');
		$this->db->where('id',$customer_id);
		$get_customer = $this->db->get('customers');
		//echo $this->db->last_query();
		$row_customer['customer_user_arr'] = $get_customer->row_array();
		$row_customer['customer_user_count'] = $get_customer->num_rows;
		
		$county_code=$row_customer['customer_user_arr']['country_name'];
		
		$this->db->dbprefix('countries');
		$this->db->where('iso',$county_code);
		$get_country = $this->db->get('countries');
		$row_country = $get_country->row_array();
		
		$row_customer['customer_user_arr']['country']=$row_country['country_name'];
		
		return $row_customer;
		
	}//end get_customer_user_data


	//Get customer User Record
	public function get_customer_docs($customer_id){
		
		$this->db->dbprefix('customers_docs');
		$this->db->where('cust_id',$customer_id);
		$get_customer_docs_data = $this->db->get('customers_docs');

		//echo $this->db->last_query(); exit;
		$row_customer_data['customer_user_docs_arr'] = $get_customer_docs_data->result_array();
		$row_customer_data['customer_user_docs_count'] = $get_customer_docs_data->num_rows;
		return $row_customer_data;
		
	}//end get_customer_user_data
	
	
	//Get Total Number of customer Users in Database
	public function count_total_customers_users(){
		
		$this->db->dbprefix('customers');
		return $this->db->count_all("customers");
		
	}//end count_total_customer_users

	//Get All customer Users record.
	public function get_customers_users_limit($start, $limit){
		
		$this->db->dbprefix('customers');
		$this->db->limit($limit,$start);
		$this->db->order_by('created_date DESC');
		
		$get_customer_user_list_limit = $this->db->get('customers');

		//echo $this->db->last_query();exit;
		
		$row_customer_user_list_limit['customers_list_result'] = $get_customer_user_list_limit->result_array();
		$row_customer_user_list_limit['customers_list_result_count'] = $get_customer_user_list_limit->num_rows;
		
		return $row_customer_user_list_limit;		
		
	}//end get_all_customer_users_limit
	
	//Check if username already exist
	public function check_if_username_exist($username){
		
		$this->db->dbprefix('customers');
		$this->db->select('id,');
		$this->db->dbprefix('customers');
		$this->db->where('username',$username);
		$get_count = $this->db->get('customers');
		
		$num_if_rows = $get_count->num_rows;
		
		//echo $this->db->last_query();

		if($num_if_rows > 0) return true;
		else 
		return false;

		//echo $this->db->last_query();
		
	}//end check_if_username_exist
	
	
	
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

	//Add new Customer
	public function add_new_customer($data){
		
		extract($data);
		
		$created_date = date('Y-m-d G:i:s');
		$created_by_ip = $this->input->ip_address();
		$created_by = $this->session->userdata('admin_id');
		//print_r($this->session->userdata); 
		//echo "Create by:  ".$created_by = $this->session->userdata('customer_id');
		//exit;
	if($account_type == 'Personal'){
		$tech_name =  $this->db->escape_str(trim($p_tech_name));
		$tech_phone =  $this->db->escape_str(trim($p_tech_phone));
	}elseif($account_type == 'Business'){
		$tech_name =  $this->db->escape_str(trim($c_tech_name));
		$tech_phone =  $this->db->escape_str(trim($c_tech_phone));
	}

	if($is_verify_email !=""){ 
		$verify_email = 0;
		$status = '0';
	}else{
		$verify_email = 1;
		$status = '1';
	}	
	
	//Generate Random code	
	$get_random_data = $this->mod_customer->random_number_generator(7);
	$activation_code=md5($get_random_data);	
		
		//Record insert into database
		$ins_data = array(
		   'first_name' => $this->db->escape_str(trim($first_name)),
		   'last_name' => $this->db->escape_str(trim($last_name)),
		   'username' => $this->db->escape_str(trim($username)),
		   'phone' => $this->db->escape_str(trim($phone)),
		   'email_address' => $this->db->escape_str(trim($email_address)),
		   'status' => $this->db->escape_str(trim($status)),		   
		   'account_type' => $this->db->escape_str(trim($account_type)),
		   'country_name' => $this->db->escape_str(trim($country_name)),
		   'state_name' => $this->db->escape_str(trim($state_name)),
		   'city_name' => $this->db->escape_str(trim($city_name)),
		   'imp_note' => $this->db->escape_str(trim(addslashes($imp_note))),
		   'tech_name' => $tech_name,
		   'tech_phone' => $tech_phone,
		   'yahoo_id' => $this->db->escape_str(trim($yahoo_id)),
		   'msn_id' => $this->db->escape_str(trim($msn_id)),
		   'skype_id' =>$this->db->escape_str(trim($skype_id)),
		   'gtalk_id' => $this->db->escape_str(trim($gtalk_id)),
		   'is_verify_email' => $verify_email,
		   'comp_name' => $this->db->escape_str(trim($comp_name)),
		   'comp_phone' => $this->db->escape_str(trim($comp_phone)),
		   'comp_website' => $this->db->escape_str(trim($comp_website)),
		   'comp_add' => $this->db->escape_str(trim($comp_add)),
		   'password' => $this->db->escape_str(trim(md5($password))),
		   'activation_code' => $this->db->escape_str(trim($activation_code)),
		   'created_by' => $this->db->escape_str(trim($created_by)),
		   'created_date' => $this->db->escape_str(trim($created_date)),
		   'created_by_ip' => $this->db->escape_str(trim($created_by_ip))
		);		

		//Inserting the record into the database.
		$this->db->dbprefix('customers');
		$ins_into_db = $this->db->insert('customers', $ins_data);
		
		$new_customer_id = $this->db->insert_id();
		
		
		$this->load->helper(array('email', 'url'));
        $this->load->model('site_preferences/mod_preferences');
		$this->load->model('email/mod_email');
			
		/********************************/
		//Email Contents
		
	    $customer_first_last_name = ucwords(strtolower(stripslashes($first_name." ".$last_name)));
		$email_address =$email_address; 
		
		$email_from_txt_arr = $this->mod_preferences->get_preferences_setting('email_from_txt');
		$email_from_txt = $email_from_txt_arr['setting_value'];
		$noreply_email_arr = $this->mod_preferences->get_preferences_setting('noreply_email');
		$noreply_email = $noreply_email_arr['setting_value'];
		
		$sitename_arr = $this->mod_preferences->get_preferences_setting('site_name');
		$site_name = $sitename_arr['setting_value'];
			
		$sitelogo_arr = $this->mod_preferences->get_preferences_setting('site_logo');
			
		$site_logo = $sitelogo_arr['setting_value'];
		
		
		$customer_id=$new_customer_id;
	
		$activation_link=MURL."customer/login/account-activation/activate/".$customer_id."/".$activation_code;
		
		//Check if Email is Verified or Not
		if($is_verify_email !=""){
			
		$get_email_data = $this->mod_email->get_email(7);
		$email_subject = $get_email_data['email_arr']['email_subject'];
		$email_body = $get_email_data['email_arr']['email_body'];
		$search_arr = array('[SITE_URL]','[SITE_NAME]','[SITE_LOGO]','[CUSTOMER_FIRST_LAST_NAME]','[ACTIVATION_LINK]');
		$replace_arr = array(MURL,$site_name,$site_logo,$customer_first_last_name,$activation_link);
		$email_body = str_replace($search_arr,$replace_arr,$email_body);
		
	    }
		else{
			
		$get_email_data = $this->mod_email->get_email(2);
		$email_subject = $get_email_data['email_arr']['email_subject'];
		$email_body = $get_email_data['email_arr']['email_body'];
		$search_arr = array('[SITE_URL]','[SITE_NAME]','[SITE_LOGO]','[CUSTOMER_FIRST_LAST_NAME]',' [USER_NAME]','[USER_PASSWORD]');
		$replace_arr = array(MURL,$site_name,$site_logo,$customer_first_last_name,$username,$password);
		$email_body = str_replace($search_arr,$replace_arr,$email_body);
	
	    }
	
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
		
		
		if($ins_into_db){
			
			

			//Create User Directory if not exist
			$user_folder_path = '../assets/customer_files/'.$new_customer_id;
			
			
			if(!is_dir($user_folder_path))
				mkdir($user_folder_path);
				
			copy('../assets/img/index.html','../assets/customer_files/'.$new_customer_id.'/index.html');
				
			//Uploading profile Imaage
			if($_FILES['prof_image']['name'] != ''){
				
				$file_ext           = ltrim(strtolower(strrchr($_FILES['prof_image']['name'],'.')),'.'); 			
				$profile_file_name = 	'user_profile_'.$new_customer_id.'.jpg';
	
				$config['upload_path'] = $user_folder_path;
				$config['allowed_types'] = 'jpg|jpeg|gif|tiff|png';
				$config['max_size']	= '1000';
				$config['overwrite'] = true;
				$config['file_name'] = $profile_file_name;
			
				$this->load->library('upload', $config);
				
				if(!$this->upload->do_upload('prof_image')){
					
					$error_file_arr = array('error' => $this->upload->display_errors());
					return $error_file_arr;
					
				}else{
					
					$data_image_upload = array('upload_image_data' => $this->upload->data());
					
					//Resize the Uploaded Image 180 * 180
					$config_profile['image_library'] = 'gd2';
					$config_profile['source_image'] = $user_folder_path.'/'.$profile_file_name;
					$config_profile['create_thumb'] = TRUE;
					$config_profile['thumb_marker'] = '';
					
					$config_profile['maintain_ratio'] = TRUE;
					$config_profile['width'] = 180;
					$config_profile['height'] = 180;
					
					$this->load->library('image_lib');
					$this->image_lib->initialize($config_profile);
					$this->image_lib->resize();
					$this->image_lib->clear();
					
					//Creating Thumbmail 28 * 28
					//Uploading is successful now resizing the uploaded image 
					$config_profile['image_library'] = 'gd2';
					$config_profile['source_image'] = $user_folder_path.'/'.$profile_file_name;
					$config_profile['new_image'] = $user_folder_path.'/t1-'.$profile_file_name;
					$config_profile['create_thumb'] = TRUE;
					$config_profile['thumb_marker'] = '';
					
					$config_profile['maintain_ratio'] = TRUE;
					$config_profile['width'] = 28;
					$config_profile['height'] = 28;
					
					$this->load->library('image_lib');
					$this->image_lib->initialize($config_profile);
					$this->image_lib->resize();
					$this->image_lib->clear();
		
				}//end if else if(!$this->upload->do_upload('upload_cv'))
				
				$upd_data['profile_image'] = $this->db->escape_str(trim($profile_file_name));
				
				//Updating the record into the database.
				$this->db->dbprefix('customers');
				$this->db->where('id',$new_customer_id);
				$upd_into_db = $this->db->update('customers', $upd_data);

			}//end if($_FILES['prof_image']['name'] != '')
			
			return true;
			
		}else
			return false;
		//end if($ins_into_db)
		
	}//end add_new_Customer

	//Edit customer User Data
	public function edit_customer($data){
	
		extract($data);
		
		$last_modified_date = date('Y-m-d G:i:s');
		$last_modified_ip = $this->input->ip_address();
		$last_modified_by = $this->session->userdata('customer_id');
		
		
		if($account_type == 'Personal'){
			$tech_name =  $this->db->escape_str(trim($p_tech_name));
			$tech_phone =  $this->db->escape_str(trim($p_tech_phone));
		}elseif($account_type == 'Business'){
			$tech_name =  $this->db->escape_str(trim($c_tech_name));
			$tech_phone =  $this->db->escape_str(trim($c_tech_phone));
		}
		
		$upd_data = array(
		   'first_name' => $this->db->escape_str(trim($first_name)),
		   'last_name' => $this->db->escape_str(trim($last_name)),
		   'username' => $this->db->escape_str(trim($username)),
		   'phone' => $this->db->escape_str(trim($phone)),
		   'email_address' => $this->db->escape_str(trim($email_address)),
		   'status' => $this->db->escape_str(trim($status)),		   
		   'account_type' => $this->db->escape_str(trim($account_type)),
		   'country_name' => $this->db->escape_str(trim($country_name)),
		   'state_name' => $this->db->escape_str(trim($state_name)),
		   'city_name' => $this->db->escape_str(trim($city_name)),
		   'imp_note' => $this->db->escape_str(trim(addslashes($imp_note))),
		   'tech_name' => $tech_name,
		   'tech_phone' => $tech_phone,
		   'yahoo_id' => $this->db->escape_str(trim($yahoo_id)),
		   'msn_id' => $this->db->escape_str(trim($msn_id)),
		   'skype_id' =>$this->db->escape_str(trim($skype_id)),
		   'gtalk_id' => $this->db->escape_str(trim($gtalk_id)),
		   'is_verify_email' => $is_verify_email,
		   'comp_name' => $this->db->escape_str(trim($comp_name)),
		   'comp_phone' => $this->db->escape_str(trim($comp_phone)),
		   'comp_website' => $this->db->escape_str(trim($comp_website)),
		   'comp_add' => $this->db->escape_str(trim($comp_add)),
		   'last_modified_by' => $this->db->escape_str(trim($last_modified_by)),
		   'last_modified_date' => $this->db->escape_str(trim($last_modified_date)),
		   'last_modified_ip' => $this->db->escape_str(trim($last_modified_ip))
		);		


		   
		if(trim($password) != ''){
			$upd_data['password'] =  $this->db->escape_str(trim(md5($password)));
		}

		//Create User Directory if not exist
		$user_folder_path = '../assets/customer_files/'.$customer_id;
		
		if(!is_dir($user_folder_path))
			mkdir($user_folder_path);
			
		//Uploading profile Imaage
		if($_FILES['prof_image']['name'] != ''){
			
			$file_ext           = ltrim(strtolower(strrchr($_FILES['prof_image']['name'],'.')),'.'); 			
			$profile_file_name = 	'user_profile_'.$customer_id.'.jpg';

			$config['upload_path'] = $user_folder_path;
			$config['allowed_types'] = 'jpg|jpeg|gif|tiff|png';
			$config['max_size']	= '1000';
			$config['overwrite'] = true;
			$config['file_name'] = $profile_file_name;
		
			$this->load->library('upload', $config);
			
			if(!$this->upload->do_upload('prof_image')){
				
				$error_file_arr = array('error' => $this->upload->display_errors());
				return $error_file_arr;
				
			}else{
				
				$data_image_upload = array('upload_image_data' => $this->upload->data());
				
				//Resize the Uploaded Image 180 * 180
				$config_profile['image_library'] = 'gd2';
				$config_profile['source_image'] = $user_folder_path.'/'.$profile_file_name;
				$config_profile['create_thumb'] = TRUE;
				$config_profile['thumb_marker'] = '';
				
				$config_profile['maintain_ratio'] = TRUE;
				$config_profile['width'] = 180;
				$config_profile['height'] = 180;
				
				$this->load->library('image_lib');
				$this->image_lib->initialize($config_profile);
				$this->image_lib->resize();
				$this->image_lib->clear();
				
				
				//Creating Thumbmail 28 * 28
				//Uploading is successful now resizing the uploaded image 
				$config_profile['image_library'] = 'gd2';
				$config_profile['source_image'] = $user_folder_path.'/'.$profile_file_name;
				$config_profile['new_image'] = $user_folder_path.'/t1-'.$profile_file_name;
				$config_profile['create_thumb'] = TRUE;
				$config_profile['thumb_marker'] = '';
				
				$config_profile['maintain_ratio'] = TRUE;
				$config_profile['width'] = 28;
				$config_profile['height'] = 28;
				
				$this->load->library('image_lib');
				$this->image_lib->initialize($config_profile);
				$this->image_lib->resize();
				$this->image_lib->clear();
	
			}//end if else if(!$this->upload->do_upload('upload_cv'))
			
			$upd_data['profile_image'] = $this->db->escape_str(trim($profile_file_name));
			
		}//end if($_FILES['prof_image']['name'] != '')

		//Updating the record into the database.
		$this->db->dbprefix('customers');
		$this->db->where('id',$customer_id);
		$upd_into_db = $this->db->update('customers', $upd_data);
		
		//echo $this->db->last_query(); exit;
		
		if($upd_into_db)
			return true;
		
	}//end edit_user
	
	//Edit customer User Data
	public function upload_docs($data){
	
		extract($data);
		
		$created_date = date('Y-m-d G:i:s');
		$created_by_ip = $this->input->ip_address();
		$created_by = $this->session->userdata('admin_id');
		
		for($i=0;$i<count($title);$i++){
					$ins_data = array(
					   'title' => $this->db->escape_str(trim($title[$i])),
					   'descrp' => $this->db->escape_str(trim($short_desc[$i])),
					   'cust_id' => $this->db->escape_str(trim($customer_id)),
					   'created_by' => $this->db->escape_str(trim($created_by)),
					   'created_date' => $this->db->escape_str(trim($created_date)),
					   'created_by_ip' => $this->db->escape_str(trim($created_by_ip))
					);		
					
					//Create User Directory if not exist
					$customer_folder_path = './assets/customer_files/'.$customer_id;
					
					
					if(!is_dir($customer_folder_path))
						mkdir($customer_folder_path,0777);
					
		$name = $customer_id.'_'.$_FILES['upload_doc']['name'][$i] ; 		
		$doc_file_name = 	'user_doc_'.$name.'.jpg';
		$ins_data['upload_doc'] = $this->db->escape_str(trim($doc_file_name));			
		
		//Inserting the record into the database.
		$this->db->dbprefix('customers_docs');
		$ins_into_db = $this->db->insert('customers_docs', $ins_data);
		}
			
			$this->load->helper(array('form', 'url'));
			$config['upload_path'] = $customer_folder_path;
			$config['allowed_types'] = 'jpg|jpeg|gif|tiff|png|doc|docx|xls|xlsx|pdf';
			$config['max_size']	= '6000';
			$config['overwrite'] = true;
	
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			$this->load->library('multipleupload',$config);

			$upload_epaper =  $this->multipleupload->do_multi_upload('upload_doc',TRUE,$customer_id);
			//echo $this->db->last_query(); exit;
		
			return true;
		
	}//end Upload Docs
	
	//Delete customer User
	public function delete_customer($customer_id){

			//Deleting User folder
			if($customer_id!=''){
				$user_folder_path = '../assets/customer_files/'.$customer_id;
				$delete_user_folder = $this->mod_common->remove_directory($user_folder_path);
			}//end if($customer_id!='')
			
			//Delete the record from the database.
			$this->db->dbprefix('customers');
			$this->db->where('id',$customer_id);
			$del_into_db = $this->db->delete('customers');
			if($del_into_db) return true;
		//	echo $this->db->last_query();
		
	}//end delete_user
	
	//Get All Countries Name
	public function get_all_countries(){
		
		$this->db->dbprefix('countries');
		$this->db->order_by('id DESC');
		$get_countries_list = $this->db->get('countries');
		
		$row_countries_list['countries_result'] = $get_countries_list->result_array();
		$row_countries_list['countries_count'] = $get_countries_list->num_rows;
		
		return $row_countries_list;		
		
	}//end get_all_countries
	
	
	
	public function get_states($county_name){
		
		$this->db->dbprefix('states');
		$this->db->order_by('id DESC');
		$this->db->where('country',$county_name);
		$get_states_list = $this->db->get('states');
		
		$row_states_list['states_result'] = $get_states_list->result_array();
		$row_states_list['states_count'] = $get_states_list->num_rows;
		
		return $row_states_list;		
		
	}//end get_states
	
	
	
	public function get_cities($county_name){
		
		$this->db->dbprefix('cities');
		$this->db->order_by('id DESC');
		$this->db->where('country',$county_name);
		$get_cities_list = $this->db->get('cities');
		
		$row_cities_list['cities_result'] = $get_cities_list->result_array();
		$row_cities_list['cities_count'] = $get_cities_list->num_rows;
		
		return $row_cities_list;		
		
	}//end get_cities
	
	//Get All State Name
	public function get_all_states($country_id){
		
		$this->db->dbprefix('states');
		$this->db->where('country',$country_id);
		$this->db->order_by('id DESC');
		$get_states_list = $this->db->get('states');
		//echo $this->db->last_query(); exit;
		
		$row_states_list['states_result'] = $get_states_list->result_array();
		$row_states_list['states_count'] = $get_states_list->num_rows;
		
		
		$this->db->dbprefix('cities');
		$this->db->where('country',$country_id);
		$this->db->order_by('id DESC');
		$get_cities_list = $this->db->get('cities');
		//echo $this->db->last_query(); exit;
		
		$row_states_list['cities_result'] = $get_cities_list->result_array();
		$row_states_list['cities_count'] = $get_cities_list->num_rows;
		
		
		return $row_states_list;		
		
	}//end get_all_states
	
	
	//Get All Cities  Name
	public function get_all_cities($state_id){
		
		$this->db->dbprefix('cities');
		$this->db->where('state_id',$state_id);
		$this->db->order_by('id DESC');
		$get_cities_list = $this->db->get('cities');
		
		$row_cities_list['cities_result'] = $get_cities_list->result_array();
		$row_cities_list['cities_count'] = $get_cities_list->num_rows;
		
		return $row_cities_list;		
		
	}//end get_all_countries
	
	
	public function get_customer_projects_count($customer_id){
	
		$this->db->dbprefix('projects');
		$this->db->where('customer_id',$customer_id);
		$get_projects= $this->db->get('projects');
        //echo $this->db->last_query();
		$total_projects = $get_projects->num_rows;
		 			
		$row_projects['total_projects']=$total_projects;
		
		$this->db->where('customer_id',$customer_id);		
		$this->db->where('status',1);
		$get_open_projects= $this->db->get('projects');
		$open_projects_arr= $get_open_projects->num_rows();
					
	    $row_projects['open_projects']=$open_projects_arr;
		
		
		$this->db->where('customer_id',$customer_id);			
		$this->db->where('status',2);
		$get_cancel_projects= $this->db->get('projects');
		$cancel_projects_arr= $get_cancel_projects->num_rows();
					
    	$row_projects ['cancel_projects']=$cancel_projects_arr ;
					
		$this->db->where('customer_id',$customer_id);			
		$this->db->where('status',3);
		$get_closed_projects = $this->db->get('projects');
		$closed_projects_arr = $get_closed_projects->num_rows();
		
					
		$row_projects['closed_projects']=$closed_projects_arr;	
			
		/*echo "<pre>";			
		print_r($row_projects);
		exit;	*/				
			
	
		return $row_projects;		
		
	}//end get_customer_projects_count
	
		//Filter Grid for Manage Customers
	public function get_filter_customer_grid_data(){
		
		/* Array of database columns which should be read and sent back to DataTables. Use a space where
		* you want to insert a non-database field (for example a counter or static image)
		*/
        $aColumns = array('first_name','account_type','username','last_signin_date','created_date','status','id');
        
        // DB table to use
        $sTable = 'customers';
		$this->db->order_by('id DESC');
		
    
        $iDisplayStart = $this->input->get_post('iDisplayStart', true);
        $iDisplayLength = $this->input->get_post('iDisplayLength', true);
        $iSortCol_0 = $this->input->get_post('iSortCol_0', true);
        $iSortingCols = $this->input->get_post('iSortingCols', true);
        $sSearch = $this->input->get_post('sSearch', true);
        $sEcho = $this->input->get_post('sEcho', true);
    
        // Paging
        if(isset($iDisplayStart) && $iDisplayLength != '-1')
        {
            $this->db->limit($this->db->escape_str($iDisplayLength), $this->db->escape_str($iDisplayStart));
        }
        
        // Ordering
        if(isset($iSortCol_0))
        {
            for($i=0; $i<intval($iSortingCols); $i++)
            {
                $iSortCol = $this->input->get_post('iSortCol_'.$i, true);
                $bSortable = $this->input->get_post('bSortable_'.intval($iSortCol), true);
                $sSortDir = $this->input->get_post('sSortDir_'.$i, true);
    
                if($bSortable == 'true')
                {
                    $this->db->order_by($aColumns[intval($this->db->escape_str($iSortCol))], $this->db->escape_str($sSortDir));
                }
            }
        }
        
				/*
		* Filtering
		* NOTE this does not match the built-in DataTables filtering which does it
		* word by word on any field. It's possible to do here, but concerned about efficiency
		* on very large tables, and MySQL's regex functionality is very limited
		*/
        if(isset($sSearch) && !empty($sSearch))
        {
            for($i=0; $i<count($aColumns); $i++)
            {
                $bSearchable = $this->input->get_post('bSearchable_'.$i, true);
                
                // Individual column filtering
                if(isset($bSearchable) && $bSearchable == 'true')
                {
                    $this->db->or_like($aColumns[$i], $sSearch);
                }
            }
        }


        // Select Data
        $this->db->select('SQL_CALC_FOUND_ROWS '.str_replace(' , ', ' ', implode(', ', $aColumns)), false);
		$this->db->dbprefix($sTable);
        $rResult = $this->db->get($sTable);

        // Data set length after filtering
		$this->db->dbprefix($sTable);
        $this->db->select('FOUND_ROWS() AS found_rows');
        $iFilteredTotal = $this->db->get()->row()->found_rows;
    
        // Total data set length
        $iTotal = $this->db->count_all($sTable);

    
        // Output
        $output = array(
            'sEcho' => intval($sEcho),
            'iTotalRecords' => $iTotal,
            'iTotalDisplayRecords' => $iFilteredTotal,
            'aaData' => array()
        );
        foreach($rResult->result_array() as $aRow){
            $row = array();
            $option_html = '';
            foreach($aColumns as $col)
            {
				/*
				if($col == 'created_date'){
					 $row[] = date('d, M Y', strtotime($aRow[$col]));
				}
				*/
				if($col == 'first_name'){
					
					 $row[] = "<a class='anchor_style' href=".SURL."customers/manage-customers/view-customer/".$aRow['id'].">".stripslashes($aRow['first_name'])."</a>";
				
				}elseif($col == 'username'){
					
					$row[] = stripslashes($aRow['username']);
				
				}elseif($col == 'last_signin_date'){
					$row[] = date('d, M Y', (strtotime($aRow['last_signin_date'])));
					
				}
				elseif($col == 'created_date'){
					$row[] = date('d, M Y', (strtotime($aRow['created_date'])));
					
				}elseif($col == 'status'){
					
					$row[] = ($aRow[$col] == 1) ? '<span class="label btn-success">Active</span>' : '<span class="label btn-danger">InActive</span>';

				}elseif($col == 'id'){
					
					$option_html .= '<div class="btn-group">';
					if(in_array(62,$this->session->userdata('permissions_arr'))){ 
						$option_html .= "<a href=".SURL."customers/manage-customers/edit-customer/".$aRow['id']." type='button' class='btn btn-info btn-gradient'> <span class='glyphicons glyphicons-edit'></span> </a>";
					}//end if
					
					if(in_array(63,$this->session->userdata('permissions_arr'))){ 
						$option_html .= "<a href=".SURL."customers/manage-customers/delete-customer/".$aRow['id']." type='button' class='btn btn-danger btn-gradient' onClick=\"return confirm('Are you sure you want to delete?')\"> <span class='glyphicons glyphicons-remove'></span> </a>";
						
					}//end if
					
					 $option_html .= '</div>';
					$row[] = $option_html;
					$row[] = 'kjk';
					
				}
				else
				$row[] = $aRow[$col];
            }
    
            $output['aaData'][] = $row;
        }

		
        echo json_encode($output);
    }//end get_filter_customer_grid_data
    

}
?>