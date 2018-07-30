<?php
class mod_customer extends CI_Model {
	
	function __construct(){
        parent::__construct();
    }
	
	
	//Verify If User is Login on the authorized Pages.
	public function verify_is_customer_login(){
		if(!$this->session->userdata('customer_id')){
			
			$this->session->set_flashdata('err_message', '- You have to login to access this page.');
			redirect(base_url().'login/login');
			
		}//if(!$this->session->userdata('id'))
		
	}//end verify_is_user_login()
	

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
	
	
	
	
	
	//Get customer User Record
	public function get_customer_user_data(){
		
		$customer_id=$this->session->userdata('customer_id');
		$this->db->dbprefix('customers');
		$this->db->where('id',$customer_id);
		$get_customer = $this->db->get('customers');
		//echo $this->db->last_query();
		$row_customer['customer_user_arr'] = $get_customer->row_array();
		$row_customer['customer_user_count'] = $get_customer->num_rows;
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
					$customer_folder_path = '../assets/customer_files/'.$customer_id;
					
					
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

}
?>