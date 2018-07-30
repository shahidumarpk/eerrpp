<?php
class mod_employee extends CI_Model {
	
	function __construct(){
        parent::__construct();
    }

	## UPDATE PROFILE ##

	
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
	
	
	
	//Get All Empolyees List Record
	public function get_all_employees(){
		
		$customer_id = $this->session->userdata('customer_id');
		
		$this->db->dbprefix('customers');
		$this->db->where('customer_id',$customer_id);
		$this->db->order_by('id',DESC);
		$get_customer = $this->db->get('customers');
		//echo $this->db->last_query();
		$row_all_customers['customers_list_arr'] = $get_customer->result_array();
		$row_all_customers['customers_list_count'] = $get_customer->num_rows;
		
		return $row_all_customers;
		
	}//end get_all_employee_data
	
	
	//Get employee User Record
	public function get_employee($employee_id){
		
		$this->db->dbprefix('customers');
		$this->db->where('id',$employee_id);
		$get_customer = $this->db->get('customers');
		//echo $this->db->last_query();
		$row_customer['employee_arr'] = $get_customer->row_array();
		$row_customer['employee_count'] = $get_customer->num_rows;
		
		
		return $row_customer;
		
	}//end get_employee


	
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
	

	
	//Add new employee
	public function add_employee($data){
		
		extract($data);
		
		$created_date = date('Y-m-d G:i:s');
		$created_by_ip = $this->input->ip_address();
		$created_by = $this->session->userdata('customer_id');

		//Record insert into database
		$ins_data = array(
		   'customer_id' => $this->db->escape_str(trim($created_by)),
		   'first_name' => $this->db->escape_str(trim($first_name)),
		   'last_name' => $this->db->escape_str(trim($last_name)),
		   'username' => $this->db->escape_str(trim($username)),
		   'phone' => $this->db->escape_str(trim($phone)),
		   'email_address' => $this->db->escape_str(trim($email_address)),
		   'password' => $this->db->escape_str(trim(md5($password))),
		   'account_type' => $this->db->escape_str(trim('Customer SubUser')),
		   'created_by' => $this->db->escape_str(trim($created_by)),
		   'created_date' => $this->db->escape_str(trim($created_date)),
		   'created_by_ip' => $this->db->escape_str(trim($created_by_ip))
		);		

		//Inserting the record into the database.
		$this->db->dbprefix('customers');
		$ins_into_db = $this->db->insert('customers', $ins_data);
		
		$new_customer_id = $this->db->insert_id();
		
		if($ins_into_db){
			
			//Create User Directory if not exist
			$user_folder_path = './assets/customer_files/'.$new_customer_id;
			
			
			if(!is_dir($user_folder_path))
				mkdir($user_folder_path);
				
			copy('./assets/img/index.html','./assets/customer_files/'.$new_customer_id.'/index.html');
				
			//Uploading profile Imaage
			if($_FILES['prof_image']['name'] != ''){
				
				$file_ext           = ltrim(strtolower(strrchr($_FILES['prof_image']['name'],'.')),'.'); 			
				$profile_file_name = 	'customer_profile_'.$new_customer_id.'.jpg';
	
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
		
	}//end add_new_employee
	
	

	//Edit employee User Data
	public function edit_employee($data){
	
		extract($data);
		
		$last_modified_date = date('Y-m-d G:i:s');
		$last_modified_ip = $this->input->ip_address();
		$last_modified_by = $this->session->userdata('customer_id');
		
		$upd_data = array(
		   'first_name' => $this->db->escape_str(trim($first_name)),
		   'last_name' => $this->db->escape_str(trim($last_name)),
		   'username' => $this->db->escape_str(trim($username)),
		   'phone' => $this->db->escape_str(trim($phone)),
		   'email_address' => $this->db->escape_str(trim($email_address)),
		   'last_modified_by' => $this->db->escape_str(trim($last_modified_by)),
		   'last_modified_date' => $this->db->escape_str(trim($last_modified_date)),
		   'last_modified_ip' => $this->db->escape_str(trim($last_modified_ip))
		);		

		if(trim($password) != ''){
			$upd_data['password'] =  $this->db->escape_str(trim(md5($password)));
		}

		//Create User Directory if not exist
		$user_folder_path = './assets/customer_files/'.$employee_id;
		
		if(!is_dir($user_folder_path))
			mkdir($user_folder_path);
			
		//Uploading profile Imaage
		if($_FILES['prof_image']['name'] != ''){
			
			$file_ext           = ltrim(strtolower(strrchr($_FILES['prof_image']['name'],'.')),'.'); 			
			$profile_file_name = 	'customer_profile_'.$employee_id.'.jpg';

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
		$this->db->where('id',$employee_id);
		$upd_into_db = $this->db->update('customers', $upd_data);
		
		//echo $this->db->last_query(); exit;
		
		if($upd_into_db)
			return true;
		
	}//end edit_employee
	
	
	
	//Delete employee User
	public function delete_employee($employee_id){

			//Deleting User folder
			if($employee_id!=''){
				$user_folder_path = './assets/customer_files/'.$employee_id;
				$delete_user_folder = $this->mod_common->remove_directory($user_folder_path);
			}//end if($customer_id!='')
			
			//Delete the record from the database.
			$this->db->dbprefix('customers');
			$this->db->where('id',$employee_id);
			$del_into_db = $this->db->delete('customers');
			if($del_into_db) return true;
		//	echo $this->db->last_query();
		
	}//end delete_user
	
	
}
?>