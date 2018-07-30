<?php
class mod_admin extends CI_Model {
	
	function __construct(){
		
        parent::__construct();
    }

	//Verify If User is Login on the authorized Pages.
	public function verify_is_admin_login(){
//	echo "sadasdfasdf".$this->session->userdata('admin_id') ; 
//	exit;
		if(!$this->session->userdata('admin_id')){
			
			$this->session->set_flashdata('err_message', '- You have to login to access this page.');
			redirect(base_url().'login/login');
			
		}//if(!$this->session->userdata('id'))
		
	}//end verify_is_user_login()

	## UPDATE PROFILE ##
	
	
	
	 //Get Assign task  Record
	public function get_average_rating($admin_id){
		
		$this->db->dbprefix('project_task');
		$this->db->select('AVG(rating) as average_rating');
		$this->db->where('user_id',$admin_id);
		$this->db->where('status',3);
		$this->db->where('rating_status',1);
		$get_average_rating= $this->db->get('project_task');
		//echo $this->db->last_query();exit;
		$row_average_rating= $get_average_rating->row_array();
		
		/*echo "<pre>";
		print_r($row_average_rating);
		exit;*/
		
		return $row_average_rating;
		
		
	}
	
	
	
	
	public function get_all_projects($admin_id,$status){
		
		if($status !="" and $status==0 ){
			
			
	    $this->db->dbprefix('projects');
		$this->db->select('projects.*,customers.first_name,customers.last_name');
        $this->db->from('projects');
        $this->db->join('customers', 'projects.customer_id = customers.id');
		$this->db->order_by('id',DESC);
		$get_projects= $this->db->get();
			
		
		
			
		}
		
		elseif($status==1 ){
			
			
	    $this->db->dbprefix('projects');
		$this->db->select('projects.*,customers.first_name,customers.last_name');
        $this->db->from('projects');
		$this->db->where('projects.status',1);
        $this->db->join('customers', 'projects.customer_id = customers.id');
		$this->db->order_by('id',DESC);
		$get_projects= $this->db->get();
			
			
		}
		elseif($status==2 ){
			
			
	    $this->db->dbprefix('projects');
		$this->db->select('projects.*,customers.first_name,customers.last_name');
        $this->db->from('projects');
		$this->db->where('projects.status',2);
        $this->db->join('customers', 'projects.customer_id = customers.id');
		$this->db->order_by('id',DESC);
		$get_projects= $this->db->get();
			
			
		}
		elseif($status==3 ){
			
			
	    $this->db->dbprefix('projects');
		$this->db->select('projects.*,customers.first_name,customers.last_name');
        $this->db->from('projects');
		$this->db->where('projects.status',3);
        $this->db->join('customers', 'projects.customer_id = customers.id');
		$this->db->order_by('id',DESC);
		$get_projects= $this->db->get();
			
		
		
			
		}
		else{
		
		
		$this->db->dbprefix('projects');
		$this->db->select('projects.*,customers.first_name,customers.last_name');
        $this->db->from('projects');
		$this->db->where('projects.status',0);
	    $this->db->or_where('projects.status',1);
        $this->db->join('customers', 'projects.customer_id = customers.id');
		$this->db->order_by('id',DESC);
		$get_projects= $this->db->get();
		//echo $this->db->last_query();exit;
		}
		//echo $this->db->last_query();
		
		$row_projects_arr['projects_arr'] = $get_projects->result_array();
		
		//echo "<pre>"; print_r($row_projects_arr['projects_arr']); exit;
				   $counter = 0 ; 	
					$h = 0 ;
					for($k=0;$k<count($row_projects_arr['projects_arr']);$k++){
					$explode_arr = explode(',',$row_projects_arr['projects_arr'][$k]['project_assign']);
						
							if(in_array($admin_id,$explode_arr))
							
							{
								
				//	$row_projects['projects_filter'] = $row_projects['projects_arr'][$k] ; 
								
					$row_projects['projects_filter'][$h]['id'] = $row_projects_arr['projects_arr'][$k]['id'] ;
					$row_projects['projects_filter'][$h]['project_id'] = $row_projects_arr['projects_arr'][$k]['project_id'] ;
					$row_projects['projects_filter'][$h]['customer_id'] = $row_projects_arr['projects_arr'][$k]['customer_id'] ;
					$row_projects['projects_filter'][$h]['project_title'] = $row_projects_arr['projects_arr'][$k]['project_title'] ;
					$row_projects['projects_filter'][$h]['project_amount'] = $row_projects_arr['projects_arr'][$k]['project_amount'] ;
					$row_projects['projects_filter'][$h]['start_date'] = $row_projects_arr['projects_arr'][$k]['start_date'] ;
					$row_projects['projects_filter'][$h]['end_date'] = $row_projects_arr['projects_arr'][$k]['end_date'] ;
					$row_projects['projects_filter'][$h]['project_detail'] = $row_projects_arr['projects_arr'][$k]['project_detail'] ;
					$row_projects['projects_filter'][$h]['project_assign'] = $row_projects_arr['projects_arr'][$k]['project_assign'] ;
					$row_projects['projects_filter'][$h]['status'] = $row_projects_arr['projects_arr'][$k]['status'] ;
					
					
								$h++;
								$counter  = $counter + 1 ;   
								
							}
					}
					
	//echo "<pre>"; print_r($row_projects); exit; 	
				
		
		$row_projects['projects_count'] = $counter ; 
		
		return $row_projects;


		
		}
	
	//Get All Branches
	public function get_all_branches(){
		
		$this->db->dbprefix('branches');
		$this->db->order_by('branch_name',ASC);
		$get_branches = $this->db->get('branches');

		//echo $this->db->last_query();
		$row_branches['branches_arr'] = $get_branches->result_array();
		$row_branches['branches_count'] = $get_branches->num_rows;
		
		return $row_branches;
		
	}//end get_all_branches
	
	//Get All Employees
	public function get_all_employees(){
		
		$this->db->dbprefix('admin');
		$this->db->select('admin.*,admin_roles.role_title');
		$this->db->where('admin.status',1);
		$this->db->join('admin_roles','admin_roles.id = admin.admin_role_id');
		$this->db->order_by('admin.created_date DESC');
		$get_admin_user_list_limit = $this->db->get('admin');
		//echo $this->db->last_query();exit;
		
		$row_admin_user_list_limit['admin_list_result'] = $get_admin_user_list_limit->result_array();
		$row_admin_user_list_limit['admin_list_result_count'] = $get_admin_user_list_limit->num_rows;
		
		for($i=0; $i<$row_admin_user_list_limit['admin_list_result_count']; $i++){
		
		$branch_id=$row_admin_user_list_limit['admin_list_result'][$i]['branch_id']; 
		$this->db->dbprefix('branches');
		$this->db->select('branch_name');
		$this->db->where('id', $branch_id);
		$get_branch = $this->db->get('branches');
		$row_branch_arr= $get_branch->row_array();
		$row_admin_user_list_limit['admin_list_result'][$i]['branch_name']= $row_branch_arr['branch_name'];
		
		}//end for
		
		return $row_admin_user_list_limit;		

		
	}//end get_all_employees
	
	//Get get_daily_active_employees
	public function get_daily_active_employees(){
		
		$this->db->dbprefix('admin');
		$this->db->select('admin.*,admin_roles.role_title');
		$this->db->where('admin.daily_report',1);
		$this->db->join('admin_roles','admin_roles.id = admin.admin_role_id');
		$this->db->order_by('admin.created_date DESC');
		$get_admin_user_list_limit = $this->db->get('admin');
		//echo $this->db->last_query();exit;
		
		$row_admin_user_list_limit['admin_list_result'] = $get_admin_user_list_limit->result_array();
		$row_admin_user_list_limit['admin_list_result_count'] = $get_admin_user_list_limit->num_rows;
		
		for($i=0; $i<$row_admin_user_list_limit['admin_list_result_count']; $i++){
		
		$branch_id=$row_admin_user_list_limit['admin_list_result'][$i]['branch_id']; 
		$this->db->dbprefix('branches');
		$this->db->select('branch_name');
		$this->db->where('id', $branch_id);
		$get_branch = $this->db->get('branches');
		$row_branch_arr= $get_branch->row_array();
		$row_admin_user_list_limit['admin_list_result'][$i]['branch_name']= $row_branch_arr['branch_name'];
		
		}//end for
		
		return $row_admin_user_list_limit;		

		
	}//end get_daily_active_employees
	

	//Get Admin Profile Record
	public function get_admin_profile($admin_id){
		
		$this->db->select('id, first_name, last_name, display_name, username, email_address, profile_image,avatar_image,country_name,state_name,city_name');
		$this->db->dbprefix('admin');
		$this->db->where('id',$admin_id);
		$get_admin_profile = $this->db->get('admin');

		//echo $this->db->last_query();
		$row_admin['admin_profile_arr'] = $get_admin_profile->row_array();
		$row_admin['admin_profile_count'] = $get_admin_profile->num_rows;
		return $row_admin;
		
	}//end get_admin_profile
	
	
	
	
	//Updatiing Admin Profile
	public function update_admin_profile($data,$admin_id){
		
		extract($data);
		
		$last_modified_date = date('Y-m-d G:i:s');
		$last_modified_ip = $this->input->ip_address();
		$last_modified_by = $this->session->userdata('admin_id');

		$upd_data = array(
		   'display_name' => $this->db->escape_str(trim($display_name)),
		   'email_address' => $this->db->escape_str(trim($email_address)),
		   'last_modified_by' => $this->db->escape_str(trim($last_modified_by)),
		   'last_modified_date' => $this->db->escape_str(trim($last_modified_date)),
		   'last_modified_ip' => $this->db->escape_str(trim($last_modified_ip))
		);		

		//Create User Directory if not exist
		$user_folder_path = './assets/user_files/'.$admin_id;
		
		if(!is_dir($user_folder_path))
			mkdir($user_folder_path);
			
		//Uploading profile Imaage
		if($_FILES['avatar_image']['name'] != ''){
			
			$file_ext           = ltrim(strtolower(strrchr($_FILES['avatar_image']['name'],'.')),'.'); 			
			$profile_file_name = 	'user_avatar'.$admin_id.'.jpg';

			$config['upload_path'] = $user_folder_path;
			$config['allowed_types'] = 'jpg|jpeg|gif|tiff|png';
			$config['max_size']	= '1000';
			$config['overwrite'] = true;
			$config['file_name'] = $profile_file_name;
		
			$this->load->library('upload', $config);
			
			
			if(!$this->upload->do_upload('avatar_image')){
				
				 
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
			
			$upd_data['avatar_image'] = $this->db->escape_str(trim($profile_file_name));

			$add_profile_to_session = array(
				'avatar_image'	=>	trim($profile_file_name),
			);
				
			$this->session->set_userdata($add_profile_to_session);			
			
		}//end if($_FILES['prof_image']['name'] != '')

		//Update the record into the database.
		$this->db->dbprefix('admin');
		$this->db->where('id',$admin_id);
		$upd_into_db = $this->db->update('admin', $upd_data);
		
		//echo $this->db->last_query();
		
		if($upd_into_db){

			$login_sess_array = array(
				'display_name'	=>	$display_name,
				'email_address'	=>	$mail_address,
				);
					
				$this->session->set_userdata($login_sess_array);
			
			return true;
			
		}//end if($upd_into_db)
		
	}//end update_admin_profile

	## CHANGE PASSWORD ##
	
	//Updatiing Admin Password
	public function update_admin_password($data,$admin_id){
		
		extract($data);
		
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
		
		//echo $this->db->last_query();
		
		if($upd_into_db)
			return true;
			
	}//end update_admin_password
	
	## ADMIN USER MANAGEMENT ##
	
	//Get Admin User Record
	public function get_admin_user_data($admin_id){
		
		$this->db->dbprefix('admin');
		$this->db->where('id',$admin_id);
		$get_admin = $this->db->get('admin');

		//echo $this->db->last_query();
		$row_admin['admin_user_arr'] = $get_admin->row_array();
		$row_admin['admin_user_count'] = $get_admin->num_rows;
		
	    $county_code=$row_admin['admin_user_arr']['country_name'];
		
		
		$this->db->dbprefix('countries');
		$this->db->where('iso',$county_code);
		$get_country = $this->db->get('countries');
		$row_country = $get_country->row_array();
		
		$row_admin['admin_user_arr']['country']=$row_country['country_name'];
		
		return $row_admin;
		
	}//end get_admin_user_data

	
	//Get Total Number of admin Users in Database
	public function count_total_admin_users(){
		
		$this->db->dbprefix('admin');
		return $this->db->count_all("admin");
		
	}//end count_total_admin_users

	//Get All Admin Users record.
	public function get_admin_users_limit(){
		
		
		if($this->input->post('branch_id')!="" && $this->input->post('search_status')!="" && $this->input->post('role_id')!=""){
		
			 
	    $this->db->dbprefix('admin');
		$this->db->select('admin.*,admin_roles.role_title');
		$this->db->where('branch_id',$this->input->post('branch_id'));
	 	$this->db->where('admin.status',$this->input->post('search_status'));
		$this->db->where('admin_role_id',$this->input->post('role_id'));
		$this->db->join('admin_roles','admin_roles.id = admin.admin_role_id');
		//$this->db->limit($limit,$start);
		$this->db->order_by('admin.created_date DESC');
		$get_admin_user_list_limit = $this->db->get('admin');
		//echo $this->db->last_query();exit;
			
		 }elseif($this->input->post('branch_id')!=""){
		
			 
	    $this->db->dbprefix('admin');
		$this->db->select('admin.*,admin_roles.role_title');
		$this->db->where('branch_id',$this->input->post('branch_id'));
		$this->db->join('admin_roles','admin_roles.id = admin.admin_role_id');
		//$this->db->limit($limit,$start);
		$this->db->order_by('admin.created_date DESC');
		$get_admin_user_list_limit = $this->db->get('admin');
		//echo $this->db->last_query();exit;
			
		 }elseif($this->input->post('role_id')!=""){
		
			 
	    $this->db->dbprefix('admin');
		$this->db->select('admin.*,admin_roles.role_title');
		$this->db->where('admin_role_id',$this->input->post('role_id'));
		$this->db->join('admin_roles','admin_roles.id = admin.admin_role_id');
		//$this->db->limit($limit,$start);
		$this->db->order_by('admin.created_date DESC');
		$get_admin_user_list_limit = $this->db->get('admin');
		//echo $this->db->last_query();exit;
			
		 }elseif($this->input->post('search_status')!=""){
		
			 
	    $this->db->dbprefix('admin');
		$this->db->select('admin.*,admin_roles.role_title');
		$this->db->where('admin.status',$this->input->post('search_status'));
		$this->db->join('admin_roles','admin_roles.id = admin.admin_role_id');
		//$this->db->limit($limit,$start);
		$this->db->order_by('admin.created_date DESC');
		$get_admin_user_list_limit = $this->db->get('admin');
		//echo $this->db->last_query();exit;
			
		 }else{
		
		
		$this->db->dbprefix('admin');
		$this->db->select('admin.*,admin_roles.role_title');
		$this->db->where('is_sup_admin != 1');
		$this->db->join('admin_roles','admin_roles.id = admin.admin_role_id','LEFT');
		//$this->db->limit($limit,$start);
		$this->db->order_by('admin.created_date DESC');
		$get_admin_user_list_limit = $this->db->get('admin');
		//echo $this->db->last_query();exit;
		
		 }
		 	//echo $this->db->last_query();exit;
		
		$row_admin_user_list_limit['admin_list_result'] = $get_admin_user_list_limit->result_array();
		$row_admin_user_list_limit['admin_list_result_count'] = $get_admin_user_list_limit->num_rows;
		
		for($i=0; $i<$row_admin_user_list_limit['admin_list_result_count']; $i++){
		
		$branch_id=$row_admin_user_list_limit['admin_list_result'][$i]['branch_id']; 
		$this->db->dbprefix('branches');
		$this->db->select('branch_name');
		$this->db->where('id', $branch_id);
		$get_branch = $this->db->get('branches');
		$row_branch_arr= $get_branch->row_array();
		$row_admin_user_list_limit['admin_list_result'][$i]['branch_name']= $row_branch_arr['branch_name'];
		
		$admin_id = $row_admin_user_list_limit['admin_list_result'][$i]['id'];
		$average_rating = $this->mod_admin->get_average_rating($admin_id);
		
		$row_admin_user_list_limit['admin_list_result'][$i]['average_rating'] = $average_rating['average_rating'];
		
		}//end for
		
		/*echo "<pre>";
		print_r($row_admin_user_list_limit['admin_list_result']);
		exit;*/
		
		return $row_admin_user_list_limit;		
		
	}//end get_all_admin_users_limit
	
	
	//Get get_admin_for_salary_report
	public function get_admin_for_salary_report(){
		
		
		if($this->input->post('branch_id')!="" && $this->input->post('search_status')!="" && $this->input->post('role_id')!=""){
		
			 
	    $this->db->dbprefix('admin');
		$this->db->select('admin.*,admin_roles.role_title');
		$this->db->where('branch_id',$this->input->post('branch_id'));
	 	$this->db->where('admin.status',$this->input->post('search_status'));
		$this->db->where('admin.status',1);
		$this->db->where('admin_role_id',$this->input->post('role_id'));
		$this->db->join('admin_roles','admin_roles.id = admin.admin_role_id');
		//$this->db->limit($limit,$start);
		$this->db->order_by('admin.created_date DESC');
		$get_admin_user_list_limit = $this->db->get('admin');
		//echo $this->db->last_query();exit;
			
		 }elseif($this->input->post('branch_id')!=""){
		
			 
	    $this->db->dbprefix('admin');
		$this->db->select('admin.*,admin_roles.role_title');
		$this->db->where('branch_id',$this->input->post('branch_id'));
		$this->db->where('admin.status',1);
		$this->db->join('admin_roles','admin_roles.id = admin.admin_role_id');
		//$this->db->limit($limit,$start);
		$this->db->order_by('admin.created_date DESC');
		$get_admin_user_list_limit = $this->db->get('admin');
		//echo $this->db->last_query();exit;
			
		 }elseif($this->input->post('role_id')!=""){
		
			 
	    $this->db->dbprefix('admin');
		$this->db->select('admin.*,admin_roles.role_title');
		$this->db->where('admin_role_id',$this->input->post('role_id'));
		$this->db->where('admin.status',1);
		$this->db->join('admin_roles','admin_roles.id = admin.admin_role_id');
		//$this->db->limit($limit,$start);
		$this->db->order_by('admin.created_date DESC');
		$get_admin_user_list_limit = $this->db->get('admin');
		//echo $this->db->last_query();exit;
			
		 }elseif($this->input->post('search_status')!=""){
		
			 
	    $this->db->dbprefix('admin');
		$this->db->select('admin.*,admin_roles.role_title');
		$this->db->where('admin.status',$this->input->post('search_status'));
		
		$this->db->join('admin_roles','admin_roles.id = admin.admin_role_id');
		//$this->db->limit($limit,$start);
		$this->db->order_by('admin.created_date DESC');
		$get_admin_user_list_limit = $this->db->get('admin');
		//echo $this->db->last_query();exit;
			
		 }else{
		
		
		$this->db->dbprefix('admin');
		$this->db->select('admin.*,admin_roles.role_title');
		$this->db->where('is_sup_admin != 1');
		$this->db->where('admin.status',1);
		$this->db->join('admin_roles','admin_roles.id = admin.admin_role_id');
		//$this->db->limit($limit,$start);
		$this->db->order_by('admin.created_date DESC');
		$get_admin_user_list_limit = $this->db->get('admin');
		//echo $this->db->last_query();exit;
		
		 }
		
		$row_admin_user_list_limit['admin_list_result'] = $get_admin_user_list_limit->result_array();
		$row_admin_user_list_limit['admin_list_result_count'] = $get_admin_user_list_limit->num_rows;
		
		for($i=0; $i<$row_admin_user_list_limit['admin_list_result_count']; $i++){
		
		$branch_id=$row_admin_user_list_limit['admin_list_result'][$i]['branch_id']; 
		$this->db->dbprefix('branches');
		$this->db->select('branch_name');
		$this->db->where('id', $branch_id);
		$get_branch = $this->db->get('branches');
		$row_branch_arr= $get_branch->row_array();
		$row_admin_user_list_limit['admin_list_result'][$i]['branch_name']= $row_branch_arr['branch_name'];
		
		$admin_id = $row_admin_user_list_limit['admin_list_result'][$i]['id'];
		$average_rating = $this->mod_admin->get_average_rating($admin_id);
		
		$row_admin_user_list_limit['admin_list_result'][$i]['average_rating'] = $average_rating['average_rating'];
		
		}//end for
		
		/*echo "<pre>";
		print_r($row_admin_user_list_limit['admin_list_result']);
		exit;*/
		
		return $row_admin_user_list_limit;		
		
	}//end get_admin_for_salary_report
	
	
	//Check if username already exist
	public function check_if_username_exist($username){
		
		$this->db->dbprefix('admin');
		$this->db->select('id,');
		$this->db->dbprefix('admin');
		$this->db->where('username',$username);
		$get_count = $this->db->get('admin');
		
		$num_if_rows = $get_count->num_rows;
		
		//echo $this->db->last_query();

		if($num_if_rows > 0) return true;
		else 
		return false;

		//echo $this->db->last_query();
		
	}//end check_if_username_exist

	//Add new Admin User
	public function add_new_user($data){
		
		extract($data);
		
		$dob = date("Y-m-d", strtotime($dob));
		$join_date = date("Y-m-d", strtotime($join_date));
		$last_increament = date("Y-m-d", strtotime($last_increament));
		
		
		$created_date = date('Y-m-d G:i:s');
		$created_by_ip = $this->input->ip_address();
		$created_by = $this->session->userdata('admin_id');

		$ins_data = array(
		   'branch_id' => $this->db->escape_str(trim($branch_id)),
		   'first_name' => $this->db->escape_str(trim($first_name)),
		   'last_name' => $this->db->escape_str(trim($last_name)),
		   'display_name' => $this->db->escape_str(trim($display_name)),
		   'username' => $this->db->escape_str(trim($username)),
		   'email_address' => $this->db->escape_str(trim($email_address)),
		   'zip' => $this->db->escape_str(trim($zip)),
		   'phone' => $this->db->escape_str(trim($phone)),
		   'emergency_phone' => $this->db->escape_str(trim($emergency_phone)),
		   'country_name' => $this->db->escape_str(trim($country_name)),
		   'state_name' => $this->db->escape_str(trim($state_name)),
		   'city_name' => $this->db->escape_str(trim($city_name)),
		   'salary' => $this->db->escape_str(trim($salary)),
		   'nic' => $this->db->escape_str(trim($nic)),
		   'dob' => $this->db->escape_str(trim($dob)),
		   'join_date' => $this->db->escape_str(trim($join_date)),
		   'last_increament' => $this->db->escape_str(trim($last_increament)),
		   'admin_role_id' => $this->db->escape_str(trim($admin_role_id)),
		   'status' => $this->db->escape_str(trim($status)),
		   'password' => $this->db->escape_str(trim(md5($password))),
		   'created_by' => $this->db->escape_str(trim($created_by)),
		   'created_date' => $this->db->escape_str(trim($created_date)),
		   'created_by_ip' => $this->db->escape_str(trim($created_by_ip)),
		   'start_time'=>$this->db->escape_str(trim($start_time))
		);		

		//Inserting the record into the database.
		$this->db->dbprefix('admin');
		$ins_into_db = $this->db->insert('admin', $ins_data);
		
		//echo $this->db->last_query(); exit;
		
		if($ins_into_db){
			
			$new_admin_id = $this->db->insert_id();

			//Create User Directory if not exist
			$user_folder_path = './assets/user_files/'.$new_admin_id;
			
			if(!is_dir($user_folder_path))
				mkdir($user_folder_path);
				
			//Uploading profile Imaage
			if($_FILES['prof_image']['name'] != ''){
				
				$file_ext           = ltrim(strtolower(strrchr($_FILES['prof_image']['name'],'.')),'.'); 			
				$profile_file_name = 	'user_profile_'.$new_admin_id.'.jpg';
	
				$config['upload_path'] = $user_folder_path;
				$config['allowed_types'] = 'jpg|jpeg|gif|tiff|png';
				$config['max_size']	= '1000';
				$config['overwrite'] = true;
				$config['file_name'] = $profile_file_name;
			
				$this->load->library('upload', $config);
				$this->upload->initialize($config);
				
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
				$this->db->dbprefix('admin');
				$this->db->where('id',$new_admin_id);
				$upd_into_db = $this->db->update('admin', $upd_data);

			}//end if($_FILES['prof_image']['name'] != '')
			
			//Uploading Avatar Imaage
			if($_FILES['avatar_image']['name'] != ''){
				
				$file_ext           = ltrim(strtolower(strrchr($_FILES['avatar_image']['name'],'.')),'.'); 			
				$avatar_file_name = 	'user_avatar'.$new_admin_id.'.jpg';
	
				$config_avatar['upload_path'] = $user_folder_path;
				$config_avatar['allowed_types'] = 'jpg|jpeg|gif|tiff|png';
				$config_avatar['max_size']	= '1000';
				$config_avatar['overwrite'] = true;
				$config_avatar['file_name'] = $avatar_file_name;
			
				$this->load->library('upload', $config_avatar);
				$this->upload->initialize($config_avatar);
				
				if(!$this->upload->do_upload('avatar_image')){
					
					$error_file_arr = array('error' => $this->upload->display_errors());
					return $error_file_arr;
					
				}else{
					
					$data_image_upload = array('upload_image_data' => $this->upload->data());
					
					//Resize the Uploaded Image 180 * 180
					$config_profile_avatar['image_library'] = 'gd2';
					$config_profile_avatar['source_image'] = $user_folder_path.'/'.$avatar_file_name;
					$config_profile_avatar['create_thumb'] = TRUE;
					$config_profile_avatar['thumb_marker'] = '';
					
					$config_profile_avatar['maintain_ratio'] = TRUE;
					$config_profile_avatar['width'] = 180;
					$config_profile_avatar['height'] = 180;
					
					$this->load->library('image_lib');
					$this->image_lib->initialize($config_profile_avatar);
					$this->image_lib->resize();
					$this->image_lib->clear();
					
					//Creating Thumbmail 28 * 28
					//Uploading is successful now resizing the uploaded image 
					$config_profile_avatar['image_library'] = 'gd2';
					$config_profile_avatar['source_image'] = $user_folder_path.'/'.$avatar_file_name;
					$config_profile_avatar['new_image'] = $user_folder_path.'/t1-'.$avatar_file_name;
					$config_profile_avatar['create_thumb'] = TRUE;
					$config_profile_avatar['thumb_marker'] = '';
					
					$config_profile_avatar['maintain_ratio'] = TRUE;
					$config_profile_avatar['width'] = 28;
					$config_profile_avatar['height'] = 28;
					
					$this->load->library('image_lib');
					$this->image_lib->initialize($config_profile_avatar);
					$this->image_lib->resize();
					$this->image_lib->clear();
		
				}//end if else if(!$this->upload->do_upload('upload_cv'))
				
				$upd_data['avatar_image'] = $this->db->escape_str(trim($avatar_file_name));
				
				//Updating the record into the database.
				$this->db->dbprefix('admin');
				$this->db->where('id',$new_admin_id);
				$upd_into_db = $this->db->update('admin', $upd_data);

			}//end if($_FILES['avatar_image']['name'] != '')
			
			
			return true;
			
		}else
			return false;
		//end if($ins_into_db)
		
	}//end add_new_user

	//Edit Admin User Data
	public function edit_user($data){
		
		extract($data);
		
		$dob = date("Y-m-d", strtotime($dob));
		$join_date = date("Y-m-d", strtotime($join_date));
		$last_increament = date("Y-m-d", strtotime($last_increament));
		
		$last_modified_date = date('Y-m-d G:i:s');
		$last_modified_ip = $this->input->ip_address();
		$last_modified_by = $this->session->userdata('admin_id');
	
	
		
		$upd_data = array(
		   'branch_id' => $this->db->escape_str(trim($branch_id)),
		   'first_name' => $this->db->escape_str(trim($first_name)),
		   'last_name' => $this->db->escape_str(trim($last_name)),
		   'display_name' => $this->db->escape_str(trim($display_name)),
		   'username' => $this->db->escape_str(trim($username)),
		   'email_address' => $this->db->escape_str(trim($email_address)),
		   'zip' => $this->db->escape_str(trim($zip)),
		   'phone' => $this->db->escape_str(trim($phone)),
		   'emergency_phone' => $this->db->escape_str(trim($emergency_phone)),
		   'country_name' => $this->db->escape_str(trim($country_name)),
		   'state_name' => $this->db->escape_str(trim($state_name)),
		   'city_name' => $this->db->escape_str(trim($city_name)),
		   'salary' => $this->db->escape_str(trim($salary)),
		   'nic' => $this->db->escape_str(trim($nic)),
		   'dob' => $this->db->escape_str(trim($dob)),
		   'join_date' => $this->db->escape_str(trim($join_date)),
		   'last_increament' => $this->db->escape_str(trim($last_increament)),
		   'admin_role_id' => $this->db->escape_str(trim($admin_role_id)),
		   'status' => $this->db->escape_str(trim($status)),
		   'last_modified_by' => $this->db->escape_str(trim($last_modified_by)),
		   'last_modified_date' => $this->db->escape_str(trim($last_modified_date)),
		   'last_modified_ip' => $this->db->escape_str(trim($last_modified_ip)),
		   'start_time'=>$this->db->escape_str(trim($start_time)),
		   
		);		
		
		if(trim($password) != ''){
			$upd_data['password'] =  $this->db->escape_str(trim(md5($password)));
		}

		//Create User Directory if not exist
		$user_folder_path = './assets/user_files/'.$admin_id;
		
		if(!is_dir($user_folder_path))
			mkdir($user_folder_path);
			
		//Uploading profile Imaage
		if($_FILES['prof_image']['name'] != ''){
			
			$file_ext           = ltrim(strtolower(strrchr($_FILES['prof_image']['name'],'.')),'.'); 			
			$profile_file_name = 	'user_profile_'.$admin_id.'.jpg';

			$config['upload_path'] = $user_folder_path;
			$config['allowed_types'] = 'jpg|jpeg|gif|tiff|png';
			$config['max_size']	= '1000';
			$config['overwrite'] = true;
			$config['file_name'] = $profile_file_name;
		
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			
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
		
		//Uploading Avatar Imaage
		if($_FILES['avatar_image']['name'] != ''){
			
			$file_ext           = ltrim(strtolower(strrchr($_FILES['avatar_image']['name'],'.')),'.'); 			
			$avatar_file_name = 	'user_avatar'.$admin_id.'.jpg';

			$config_avatar['upload_path'] = $user_folder_path;
			$config_avatar['allowed_types'] = 'jpg|jpeg|gif|tiff|png';
			$config_avatar['max_size']	= '1000';
			$config_avatar['overwrite'] = true;
			$config_avatar['file_name'] = $avatar_file_name;
		
			$this->load->library('upload', $config_avatar);
			$this->upload->initialize($config_avatar);
			
			if(!$this->upload->do_upload('avatar_image')){
				
				$error_file_arr = array('error' => $this->upload->display_errors());
				return $error_file_arr;
				
			}else{
				
				$data_image_upload = array('upload_image_data' => $this->upload->data());
				
				//Resize the Uploaded Image 180 * 180
				$config_profile_avatar['image_library'] = 'gd2';
				$config_profile_avatar['source_image'] = $user_folder_path.'/'.$avatar_file_name;
				$config_profile_avatar['create_thumb'] = TRUE;
				$config_profile_avatar['thumb_marker'] = '';
				
				$config_profile_avatar['maintain_ratio'] = TRUE;
				$config_profile_avatar['width'] = 180;
				$config_profile_avatar['height'] = 180;
				
				$this->load->library('image_lib');
				$this->image_lib->initialize($config_profile_avatar);
				$this->image_lib->resize();
				$this->image_lib->clear();
				
				
				//Creating Thumbmail 28 * 28
				//Uploading is successful now resizing the uploaded image 
				$config_profile_avatar['image_library'] = 'gd2';
				$config_profile_avatar['source_image'] = $user_folder_path.'/'.$avatar_file_name;
				$config_profile_avatar['new_image'] = $user_folder_path.'/t1-'.$avatar_file_name;
				$config_profile_avatar['create_thumb'] = TRUE;
				$config_profile_avatar['thumb_marker'] = '';
				
				$config_profile_avatar['maintain_ratio'] = TRUE;
				$config_profile_avatar['width'] = 28;
				$config_profile_avatar['height'] = 28;
				
				$this->load->library('image_lib');
				$this->image_lib->initialize($config_profile_avatar);
				$this->image_lib->resize();
				$this->image_lib->clear();
	
			}//end if else if(!$this->upload->do_upload('upload_cv'))
			
			$upd_data['avatar_image'] = $this->db->escape_str(trim($avatar_file_name));
			
		}//end if($_FILES['avatar_image']['name'] != '')

		//Updating the record into the database.
		

		$this->db->dbprefix('admin');
		$this->db->where('id',$admin_id);
		$upd_into_db = $this->db->update('admin', $upd_data);
		
		//echo $this->db->last_query(); exit;
		
		if($upd_into_db)
			return true;
		
	}//end edit_user
	
	//Delete Admin User
	public function delete_user($admin_id){
		
		if($admin_id != 1){
			
			//Deleting User folder
			if($admin_id!=''){
				$user_folder_path = './assets/user_files/'.$admin_id;
				$delete_user_folder = $this->mod_common->remove_directory($user_folder_path);
			}//end if($admin_id!='')
			
			//Delete the record from the database.
			$this->db->dbprefix('admin');
			$this->db->where('id',$admin_id);
			$del_into_db = $this->db->delete('admin');
			if($del_into_db) return true;
			//echo $this->db->last_query();

		}//end if($admin_id != 1)
		
	}//end delete_user
	
	
	public function add_site_preferences($data){
		
		extract($data);
		
		$ins_data = array(
		   'setting_name' => $this->db->escape_str(trim($name)),
		   'setting_value' => $this->db->escape_str(trim($value))
		);		

		//Inserting the record into the database.
		$this->db->dbprefix('site_preferences');
		$ins_into_db = $this->db->insert('site_preferences', $ins_data);
		
		return true;
		
	}//End Add site preferences
	
	
	public function get_site_preferences(){
		
		$this->db->dbprefix('site_preferences');
		
		$get_site_preferences= $this->db->get('site_preferences');

		//echo $this->db->last_query();exit;
		
		$get_site_preferences_arr['site_preferences_result'] = $get_site_preferences->result_array();
		$get_site_preferences_arr['site_preferences_count'] = $get_site_preferences->num_rows;
		
		
		
		return $get_site_preferences_arr;		
		
	}//end get_site_preferences
	
	
	public function edit_site_preferences($id){
		
		
		$this->db->dbprefix('site_preferences');
		$this->db->where('id',$id);
		$edit_preferences= $this->db->get('site_preferences');
		
		$edit_site_preferences_arr= $edit_preferences->row_array();
		
	    return $edit_site_preferences_arr;
		
		
	}//end update_Site Preferences
	
	
	public function update_site_preferences_process($data,$id){
		
		extract($data);
		
		$upd_data = array(
		   'setting_name' => $this->db->escape_str(trim($name)),
		   'setting_value' => $this->db->escape_str(trim($value))
		);		

		//Update the record into the database.
		$this->db->dbprefix('site_preferences');
		$this->db->where('id',$id);
		$upd_into_db = $this->db->update('site_preferences', $upd_data);
		
		//echo $this->db->last_query();
		
		if($upd_into_db)
			return true;
			
	}//end update_site_preferences process
	
	
	public function delete_site_preferences($id){
		
			//Delete the record from the database.
			$this->db->dbprefix('site_preferences');
			$this->db->where('id',$id);
			$del_into_db = $this->db->delete('site_preferences');
			
			if($del_into_db) return true;
			//echo $this->db->last_query();

		
	}//end delete_site_preferences
	
		
	//Get All Countries Name
	public function get_all_countries(){
		
		$this->db->dbprefix('countries');
		$this->db->select('Id,country_name,iso')
		;$this->db->order_by('id DESC');
		$get_countries_list = $this->db->get('countries');
		//echo $this->db->last_query(); exit;
		
		
		$row_countries_list['countries_result'] = $get_countries_list->result_array();
		$row_countries_list['countries_count'] = $get_countries_list->num_rows;
		
		return $row_countries_list;		
		
	}//end get_all_countries
	
	
	
	
	public function get_states($county_name){
		
		$this->db->dbprefix('states');
		$this->db->select('id,state_name');
		$this->db->order_by('id DESC');
		$this->db->where('country',$county_name);
		$get_states_list = $this->db->get('states');
		//echo $this->db->last_query(); exit;
		$row_states_list['states_result'] = $get_states_list->result_array();
		$row_states_list['states_count'] = $get_states_list->num_rows;
		
		
		return $row_states_list;		
		
	}//end get_states
	
	
	
	public function get_cities($county_name){
		
		$this->db->dbprefix('cities');
		$this->db->select('name');
		$this->db->order_by('id DESC');
		$this->db->where('country',$county_name);
		$get_cities_list = $this->db->get('cities');
		//echo $this->db->last_query(); exit;
		
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
	
	
	public function activate_user_report($user_id){
	
		
		$upd_data = array(
		   'daily_report' => $this->db->escape_str(trim(1))
		);		

		//Inserting the record into the database.
		$this->db->dbprefix('admin');
		$this->db->where('id',$user_id);
		$ins_into_db = $this->db->update('admin', $upd_data);
		
		return true;
		
	}//End activate_user_report
	
	public function deactivate_user_report($user_id){
		
		$upd_data = array(
		   'daily_report' => $this->db->escape_str(trim(0))
		);		

		//Inserting the record into the database.
		$this->db->dbprefix('admin');
		$this->db->where('id',$user_id);
		$ins_into_db = $this->db->update('admin', $upd_data);
		
		return true;
		
	}//End activate_user_report
	
	
	//Update User Daily Report
	public function update_report($data){
		
		extract($data);
		
		$created_date = date('Y-m-d G:i:s');
		$created_by_ip = $this->input->ip_address();
		$created_by = $this->session->userdata('admin_id');
		
		for($i=0; $i<count($time_from); $i++){
		
		$this->db->dbprefix('emp_daily_report');
		$this->db->where('user_id',$created_by);
		$this->db->where('time_from',$time_from[$i] );
		$get_report = $this->db->get('emp_daily_report');
		//echo $this->db->last_query(); exit;
		$row_report_list = $get_report->row_array();
		$row_report_count= $get_report->num_rows;
		
		if($row_report_count >0){
			
		$id= $row_report_list['id'];
	
		$upd_data = array(
		   'user_id' => $this->db->escape_str(trim($created_by)),
		   'time_from' => $this->db->escape_str(trim($time_from[$i])),
		   'time_to' => $this->db->escape_str(trim($time_to[$i])),
		   'comments' => $this->db->escape_str(trim($comments[$i])),
		   'add_date_time' => $this->db->escape_str(trim($created_date)),
		   'created_by' => $this->db->escape_str(trim($created_by)),
		   'created_date' => $this->db->escape_str(trim($created_date)),
		   'created_by_ip' => $this->db->escape_str(trim($created_by_ip))
		);		

		//Inserting the record into the database.
		$this->db->dbprefix('emp_daily_report');
		$this->db->where('id',$id);
		$ins_into_db = $this->db->update('emp_daily_report', $upd_data);
		
		}
		else{
	
			
		$ins_data = array(
		   'user_id' => $this->db->escape_str(trim($created_by)),
		   'time_from' => $this->db->escape_str(trim($time_from[$i])),
		   'time_to' => $this->db->escape_str(trim($time_to[$i])),
		   'comments' => $this->db->escape_str(trim($comments[$i])),
		   'add_date_time' => $this->db->escape_str(trim($created_date)),
		   'created_by' => $this->db->escape_str(trim($created_by)),
		   'created_date' => $this->db->escape_str(trim($created_date)),
		   'created_by_ip' => $this->db->escape_str(trim($created_by_ip))
		);		

		//Inserting the record into the database.
		$this->db->dbprefix('emp_daily_report');
		$ins_into_db = $this->db->insert('emp_daily_report', $ins_data);
		}
		
	
		}
		
		return true;
		
	}//End update_report
	
	//Get get_daily_emp_record
	public function get_daily_emp_report(){
		
		$row_states_list=array();
		
		for($i=0; $i<=23; $i++){
		
		$hourdate = date('Y-m-d').' '.$i.':00:00';
		$GetDate = date('Y-m-d h:i:s a', strtotime($hourdate));
	    date('Y-m-d h:i:s a', strtotime($GetDate));
		
		$this->db->dbprefix('emp_daily_report');
		$this->db->where('user_id',$this->session->userdata('admin_id'));
		$this->db->where('time_from', date('Y-m-d h:i:s a', strtotime($GetDate)));
		$get_report = $this->db->get('emp_daily_report');
		//echo $this->db->last_query(); exit;
		
		$row_report_list['report_arr'][$i] = $get_report->row_array();
		
		$row_report_list['report_count'][$i] = $get_report->num_rows;
		
	
		}
				
		return $row_report_list;		
		
	}//end get_daily_emp_report
	
	//Get get_emp_record
	public function get_emp_report($user_id){
		
		$current_day= date('Y-m-d');  
		$this->db->dbprefix('emp_daily_report');
		$this->db->where('user_id',$user_id);
		$this->db->like('add_date_time',$current_day);
		$check_report = $this->db->get('emp_daily_report');
		$count_check= $check_report->num_rows();
		
		if($count_check ==0){
			
		$previous_day= date('Y-m-d', strtotime('-1 day', strtotime(date("Y-m-d"))));
		//$current_day= date('Y-m-d');
		$this->db->dbprefix('emp_daily_report');
		$this->db->where('user_id',$user_id);
		$this->db->like('add_date_time',$previous_day);
		$this->db->order_by('add_date_time',DESC);
		$get_report = $this->db->get('emp_daily_report');	
			
		}
		
		elseif($this->input->post('date') &&$this->input->post('date')!="" ){
			
		$date = date("Y-m-d", strtotime($this->input->post('date')));	
		$this->db->dbprefix('emp_daily_report');
		$this->db->where('user_id',$user_id);
		$this->db->like('add_date_time',$date);
		$get_report = $this->db->get('emp_daily_report');
		//echo $this->db->last_query(); exit;
	
	   }else{
		   
		//$previous_day= date('Y-m-d', strtotime('-1 day', strtotime(date("Y-m-d"))));
		$current_day= date('Y-m-d');    
		  
		$this->db->dbprefix('emp_daily_report');
		$this->db->where('user_id',$user_id);
		$this->db->like('add_date_time',$current_day);
		$this->db->order_by('add_date_time',DESC);
		$get_report = $this->db->get('emp_daily_report');
		//echo $this->db->last_query(); exit;
	   }
		
		$row_report_list['report_arr']= $get_report->result_array();
		$row_report_list['report_count']= $get_report->num_rows;
		
		/*echo "<pre>";
		print_r($row_report_list['report_arr']);
		exit;*/
		return $row_report_list;		
		
	}//end get_emp_report
	
	
	//send_message
	public function send_message($data){
		
		  extract($data);
		  
	   $message_id = $this->mod_common->random_number_generator(7);
	   $message_id = $this->mod_admin->message_id_generator($message_id);
	  
		//Uploading Message Attachments
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
			
			
		  
	     return true;
		
	}//send_message
	
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
	
	

    public function get_start_time_report($admin_id){
	
		$this->db->dbprefix('project_task');
		//$this->db->where('status',1);
		$this->db->where('ontime_start',1);
		$get_ontime_start= $this->db->get('project_task');
		$row_tasks['task_arr'] = $get_ontime_start->result_array();
		
			$ontime_start_task = 0 ;
			
			for($k=0;$k<count($row_tasks['task_arr']);$k++){
				
			$explode_arr = explode(',',$row_tasks['task_arr'][$k]['user_id']);
			
		
				if(in_array($admin_id,$explode_arr))
				{
					
					 $ontime_start_task  = $ontime_start_task + 1 ;  
				}
			
			}
		
	  $row['ontime_start']= $ontime_start_task;
			
		$this->db->dbprefix('project_task');
	//	$this->db->where('status',1);
		$this->db->where('ontime_start',0);
		$get_task_arr_after= $this->db->get('project_task');
		$row_task_arr_after['task_arr_after'] = $get_task_arr_after->result_array();	
				
			$after_time_start_task = 0 ;
			for($k=0;$k<count($row_task_arr_after['task_arr_after'] );$k++){
			$explode_arr = explode(',',$row_task_arr_after['task_arr_after'][$k]['user_id']);
			
				if(in_array($admin_id,$explode_arr))
				
				{
						$after_time_start_task  = $after_time_start_task + 1 ;  
				}
			
			}
			
			$row['after_time_start']=$after_time_start_task;	
			
	
			
		return $row;		
		
	}//end get_start_time_report
	
	
	 public function get_closed_time_report($admin_id){
	
		$this->db->dbprefix('project_task');
		$this->db->where('status',3);
		$this->db->where('ontime_closed',1);
		$get_ontime_start= $this->db->get('project_task');
		$row_tasks['task_arr'] = $get_ontime_start->result_array();
		
			$ontime_closed_task = 0 ;
			
			for($k=0;$k<count($row_tasks['task_arr']);$k++){
				
			$explode_arr = explode(',',$row_tasks['task_arr'][$k]['user_id']);
			
		
				if(in_array($admin_id,$explode_arr))
				{
					
					 $ontime_closed_task  = $ontime_closed_task + 1 ;  
				}
			
			}
		
	  $row['ontime_closed']= $ontime_closed_task;
			
		$this->db->dbprefix('project_task');
		$this->db->where('status',3);
		$this->db->where('ontime_closed',0);
		$get_task_arr_after= $this->db->get('project_task');
		$row_task_arr_after['task_arr_after'] = $get_task_arr_after->result_array();	
				
			$after_time_closed_task = 0 ;
			for($k=0;$k<count($row_task_arr_after['task_arr_after'] );$k++){
			$explode_arr = explode(',',$row_task_arr_after['task_arr_after'][$k]['user_id']);
			
				if(in_array($admin_id,$explode_arr))
				
				{
						$after_time_closed_task  = $after_time_closed_task + 1 ;  
				}
			
			}
			
			$row['after_time_closed']=$after_time_closed_task;	
			
		/*echo "<pre>";
	print_r($row);
	exit;	*/	
				
			
		return $row;		
		
	}//end get_closed_time_report

	public function get_project_tasks($admin_id){
	
		$this->db->dbprefix('project_task');
		$get_tasks= $this->db->get('project_task');
        //echo $this->db->last_query();
		$task_arr['task_result'] = $get_tasks->result_array();
		
					$counter = 0 ;
					for($k=0;$k<count($task_arr['task_result']);$k++){
					$explode_arr = explode(',',$task_arr['task_result'][$k]['user_id']);
					
					
						
					if(in_array($admin_id,$explode_arr))
					
					{
							$counter  = $counter + 1 ;  
					}
					
					//$row_projects['projects_filter']=$
					
					}
		 			
		            $row_tasks['total_tasks']=$counter;
		
		$this->db->where('status',1);
		$get_open_tasks= $this->db->get('project_task');
		$open_task_arr['task_result'] = $get_open_tasks->result_array();
		
		$counter_open_tasks = 0 ;
					for($k=0;$k<count($open_task_arr['task_result']);$k++){
					$explode_arr = explode(',',$open_task_arr['task_result'][$k]['user_id']);
					
						if(in_array($admin_id,$explode_arr))
						
						{
								$counter_open_tasks  = $counter_open_tasks + 1 ;  
						}
					
					}
					
					$row_tasks['open_tasks']=$counter_open_tasks;
					
		$this->db->where('status',2);
		$get_open_tasks= $this->db->get('project_task');
		$hold_task_arr['task_result'] = $get_open_tasks->result_array();
		
		$counter_hold_task = 0 ;
					for($k=0;$k<count($hold_task_arr['task_result']);$k++){
					$explode_arr = explode(',',$hold_task_arr['task_result'][$k]['user_id']);
					
						if(in_array($admin_id,$explode_arr))
						
						{
								$counter_hold_task  = $counter_hold_task + 1 ;  
						}
					
					}
					
					$row_tasks['hold_tasks']=$counter_hold_task;	
					
		$this->db->where('status',3);
		$get_closed_tasks= $this->db->get('project_task');
		$closed_task_arr['task_result'] = $get_closed_tasks->result_array();
		
		$counter_closed_task = 0 ;
					for($k=0;$k<count($closed_task_arr['task_result']);$k++){
					$explode_arr = explode(',',$closed_task_arr['task_result'][$k]['user_id']);
					
						if(in_array($admin_id,$explode_arr))
						
						{
								$counter_closed_task  = $counter_closed_task + 1 ;  
						}
					
					}
					
					$row_tasks['closed_tasks']=$counter_closed_task;						
			
	
		return $row_tasks;		
		
	}//end get_user_tasks
	
	
	
	public function get_user_projects_count($admin_id){
	
		$this->db->dbprefix('projects');
		$get_projects= $this->db->get('projects');
        //echo $this->db->last_query();
		$projects_arr['projects_result'] = $get_projects->result_array();
		
					$counter = 0 ;
					for($k=0;$k<count($projects_arr['projects_result']);$k++){
					$explode_arr = explode(',',$projects_arr['projects_result'][$k]['project_assign']);
					
						
					if(in_array($admin_id,$explode_arr))
					
					{
							$counter  = $counter + 1 ;  
					}
					
					//$row_projects['projects_filter']=$
					
					}
		 			
		            $row_projects['total_projects']=$counter;
					/*print_r(  $row_projects['total_projects']);
					exit;*/
		
		$this->db->where('status',1);
		$get_open_projects= $this->db->get('projects');
		$open_projects_arr['projects_result'] = $get_open_projects->result_array();
		
		$counter_open_projects  = 0 ;
					for($k=0;$k<count($open_projects_arr['projects_result']);$k++){
					$explode_arr = explode(',',$open_projects_arr['projects_result'][$k]['project_assign']);
					
						if(in_array($admin_id,$explode_arr))
						
						{
								$counter_open_projects = $counter_open_projects + 1 ;  
						}
					
					}
					
					$row_projects['open_projects']=$counter_open_projects;
					
					/*print_r(  $row_projects['open_projects']);
					exit;*/
					
		$this->db->where('status',2);
		$get_cancel_projects= $this->db->get('projects');
		$cancel_projects_arr['projects_result'] = $get_cancel_projects->result_array();
		
		$counter_cancel_projects = 0 ;
					for($k=0;$k<count($cancel_projects_arr['projects_result']);$k++){
					$explode_arr = explode(',',$cancel_projects_arr['projects_result'][$k]['project_assign']);
					
						if(in_array($admin_id,$explode_arr))
						
						{
								$counter_cancel_projects = $counter_cancel_projects + 1 ;  
						}
					
					}
					
					$row_projects ['cancel_projects']=$counter_cancel_projects ;
					
					
						
					
		$this->db->where('status',3);
		$get_closed_projects = $this->db->get('projects');
		$closed_projects_arr['projects_result'] = $get_closed_projects->result_array();
		
		$counter_closed_projects = 0 ;
					for($k=0;$k<count($closed_projects_arr['projects_result']);$k++){
					$explode_arr = explode(',',$closed_projects_arr['projects_result'][$k]['project_assign']);
					
						if(in_array($admin_id,$explode_arr))
						
						{
								$counter_closed_projects  = $counter_closed_projects + 1 ;  
						}
					
					}
					
					$row_projects['closed_projects']=$counter_closed_projects;		
		/*echo "<pre>";			
		print_r($row_projects);
		exit;	*/				
			
	
		return $row_projects;		
		
	}//end get_user_projects_count
	
	
	//Edit User Data
	public function upload_docs($data){
		
	
		extract($data);
		
		$created_date = date('Y-m-d G:i:s');
		$created_by_ip = $this->input->ip_address();
		$created_by = $this->session->userdata('admin_id');
		
		for($i=0;$i<count($title);$i++){
					$ins_data = array(
					   'user_id' => $this->db->escape_str(trim($user_id)),
					   'title' => $this->db->escape_str(trim($title[$i])),
					   'description' => $this->db->escape_str(trim($short_desc[$i])),
					   'created_by' => $this->db->escape_str(trim($created_by)),
					   'created_date' => $this->db->escape_str(trim($created_date)),
					   'created_by_ip' => $this->db->escape_str(trim($created_by_ip))
					);		
					
					//Create User Directory if not exist
					$user_folder_path = './assets/user_files/'.$user_id;
					
					
					if(!is_dir($user_folder_path))
						mkdir($user_folder_path,0777);
					
		$name = $user_id.'_'.$_FILES['upload_doc']['name'][$i] ; 		
	 	$doc_file_name = 	'user_doc_'.$name;
		$ins_data['upload_doc'] = $this->db->escape_str(trim($doc_file_name));			
		
		//Inserting the record into the database.
		$this->db->dbprefix('user_docs');
		$ins_into_db = $this->db->insert('user_docs', $ins_data);
		}
			
			$this->load->helper(array('form', 'url'));
			$config['upload_path'] = $user_folder_path;
			$config['allowed_types'] = 'jpg|jpeg|gif|tiff|png|doc|docx|xls|xlsx|pdf';
			$config['max_size']	= '6000';
			$config['overwrite'] = true;
	
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			$this->load->library('multipleupload',$config);

			$upload_epaper =  $this->multipleupload->do_multi_upload('upload_doc',TRUE,$user_id);
			
			/*echo "<pre>";
			print_r($upload_epaper);
			exit;*/
			//echo $this->db->last_query(); exit;
		
			return true;
		
	}//end Upload Docs
	
	
	//Get User Attendance
	public function get_user_attendance($user_id){
		
		$month = date('m');
		$year = date('Y');
		$last_day_of_month = cal_days_in_month(CAL_GREGORIAN, $month, $year);
		$sdate = $year.'-'.$month.'-01';
		$edate = $year.'-'.$month.'-'.$last_day_of_month;
		
		for($i=1;$i<=$last_day_of_month;$i++){
		
		        $sr++;
				if($i < 10){
					$day = '0'.$i;
				}else{
					$day = $i;
				}
					 $show_date = $year.'-'.$month.'-'.$day;	
					
					$this->db->dbprefix('attendance');
					$this->db->where('emp_code', $user_id);
					$this->db->where('attend_date', $show_date);
					$get_attendance = $this->db->get('attendance');
					
					//echo $this->db->last_query();exit;
					$row_attendance['attendance_arr'] = $get_attendance->row_array();
					//$row_attendance['attendance_arr'][$show_date];
					
					if(count($row_attendance['attendance_arr'])>0){
						
					$row_attendance['final_arr'][$i]['id']=$row_attendance['attendance_arr']['id'];
					$row_attendance['final_arr'][$i]['emp_name']=$row_attendance['attendance_arr']['emp_name'];
					$row_attendance['final_arr'][$i]['attend_date']=$row_attendance['attendance_arr']['attend_date'];
					$row_attendance['final_arr'][$i]['per_day_salary']=$row_attendance['attendance_arr']['per_day_salary'];
					
					$row_attendance['final_arr'][$i]['time_in']=$row_attendance['attendance_arr']['time_in'];
					$row_attendance['final_arr'][$i]['time_out']=$row_attendance['attendance_arr']['time_out'];
					$row_attendance['final_arr'][$i]['astatus']=$row_attendance['attendance_arr']['astatus'];
					$row_attendance['final_arr'][$i]['remarks']=$row_attendance['attendance_arr']['remarks'];
					
					
					$row_attendance['final_arr'][$i]['user_id']=$row_attendance['attendance_arr']['user_id'];
					$row_attendance['final_arr'][$i]['enty_type']=$row_attendance['attendance_arr']['enty_type'];
					$row_attendance['final_arr'][$i]['reason']=$row_attendance['attendance_arr']['reason'];
					$row_attendance['final_arr'][$i]['upload_time']=$row_attendance['attendance_arr']['upload_time'];
					$row_attendance['final_arr'][$i]['early_timeout_reason']=$row_attendance['early_timeout_reason']['user_id'];
					$row_attendance['final_arr'][$i]['show_date']=$show_date;
					
					}
					//$row_attendance['final_arr'][$i]=$row_attendance['attendance_arr'];
					
					
		}
		            
				/*
					echo "<pre>";
					print_r($row_attendance['final_arr']);
					exit;*/
				
		
		return $row_attendance;
		
	}//end get_user_attendance
	
	//Get admin role name
	public function get_admin_role_name($role_id){
		
		global $chain_str;

		$this->db->dbprefix('admin_roles');
		$this->db->select('role_title');
		$this->db->where('id',$role_id);

		$get_admin_role_arr = $this->db->get('admin_roles');
		$row_admin_role_name = $get_admin_role_arr->row_array();
		
		
		$chain_str =  $row_admin_role_name['role_title'];
		
		return $chain_str;
		
	}//end admin_role_name
	
	//Get admin Branch name
	public function get_admin_branch_name($branch_id){
		
		global $chain_str;

		$this->db->dbprefix('branches');
		$this->db->select('branch_name');
		$this->db->where('id',$branch_id);

		$get_branch_arr = $this->db->get('branches');
		$row_admin_branch_name = $get_branch_arr->row_array();
		
		
		$chain_str =  $row_admin_branch_name['branch_name'];
		
		return $chain_str;
		
	}//end admin_branch_name
	
	
	//Filter Grid for Manage all admin users
	public function get_filter_admin_user_grid_data(){
		
		/* Array of database columns which should be read and sent back to DataTables. Use a space where
		* you want to insert a non-database field (for example a counter or static image)
		*/
        $aColumns = array('`display_name`','username','admin_role_id','last_signin_date','branch_id','status','id');
        
        // DB table to use
        $sTable = 'admin';
		$this->db->order_by('id', DESC);
		
        //
    
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
        //echo $this->db->last_query(); exit;
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
				
				if($col == '`display_name`'){
					 //$admin_name = stripslashes($this->mod_messages->get_admin_name($aRow['from']));
					 
					 $row[] = "<strong><a class='anchor_style' href=".SURL."admin/manage-user/user-detail/".$aRow['id']." title='Click to User Detail'>".$aRow['display_name']."</strong></a>";
					
					
				}
				elseif($col == 'admin_role_id'){
					
					 $admin_role_name = stripslashes($this->mod_admin->get_admin_role_name($aRow['admin_role_id']));
					 $row[] = $admin_role_name;
					
				}
				elseif($col == 'last_signin_date'){
					$row[] = date('d, M Y h:i:s a', strtotime(stripslashes($aRow['last_signin_date'])));
					
				}
				elseif($col == 'branch_id'){
					
					 $branch_name = stripslashes($this->mod_admin->get_admin_branch_name($aRow['branch_id']));
					 $row[] = $branch_name;
					
				}elseif($col == 'status'){
					
					$row[] = ($aRow[$col] == 1) ? '<span class="label btn-success">Active</span>' : '<span class="label btn-danger">InActive</span>';

				}elseif($col == 'id'){
					$option_html .= '<div class="btn-group">';
					
					if(in_array(149,$this->session->userdata('permissions_arr'))){ 
						$option_html .= "<a href=".SURL."admin/manage-user/view-attendance/".$aRow['id']." type='button' class='btn btn-info btn-gradient' title='View Attendance'> <span class='glyphicons glyphicons-eye_open'></span> </a>";
					}//end if
					
					if(in_array(9,$this->session->userdata('permissions_arr'))){ 
						$option_html .= "<a href=".SURL."admin/manage-user/edit-user/".$aRow['id']." type='button' class='btn btn-info btn-gradient'> <span class='glyphicons glyphicons-edit'></span> </a>";
					}//end if
					
					if(in_array(10,$this->session->userdata('permissions_arr'))){ 
						$option_html .= "<a href=".SURL."admin/manage-user/delete-user/".$aRow['id']." type='button' class='btn btn-danger btn-gradient' onClick=\"return confirm('Are you sure you want to delete?')\"> <span class='glyphicons glyphicons-remove'></span> </a>";
					}//end if
					
					$option_html .= "<a href='' onClick='openModel(".$aRow['id'].")' id='emailTom' data-toggle='modal' data-target='#mailmodal' type='button' class='btn btn-info btn-gradient' title='Send Message'> <span class='glyphicons glyphicons-envelope'></span> </a>";
					
					 $option_html .= '</div>';
					$row[] = $option_html;
					
					
				}
				else
				$row[] = $aRow[$col];
            }
    
            $output['aaData'][] = $row;
        }

		
        echo json_encode($output);
    }//end get_filter_inbox_read_grid_data
	
	
	//Get task_detail_report
	public function task_detail_report(){
		
		 $admin_role_id= $this->input->post('admin_role_id');
		
		 
		 if($this->input->post('search_sbt') && $this->input->post('branch_id')!=""){
			 
			    $branch_id =$this->input->post('branch_id');
			 
				$this->db->dbprefix('admin');
				$this->db->select('admin.*,admin_roles.role_title');
				$this->db->where('admin.status',1);
				$this->db->where('admin.branch_id',$branch_id);
				
				if(!empty($admin_role_id)){
				$this->db->where_in('admin.admin_role_id',$admin_role_id);
				}
				
				$this->db->join('admin_roles','admin_roles.id = admin.admin_role_id');
				$this->db->order_by('admin.display_name ASC');
				$get_detail_report = $this->db->get('admin');
				//echo $this->db->last_query();exit;
			
	    }elseif(!empty($admin_role_id)){
			
		
		  	    $admin_role_id= $this->input->post('admin_role_id');
			
			 
				$this->db->dbprefix('admin');
				$this->db->select('admin.*,admin_roles.role_title');
				$this->db->where('admin.status',1);
				$this->db->where_in('admin.admin_role_id',$admin_role_id);
				$this->db->join('admin_roles','admin_roles.id = admin.admin_role_id');
				$this->db->order_by('admin.display_name ASC');
				$get_detail_report = $this->db->get('admin');
				//echo $this->db->last_query();exit;
			
	    }else{
		
		
		$this->db->dbprefix('admin');
		$this->db->select('admin.*,admin_roles.role_title');
		$this->db->where('admin.status',1);
		$this->db->join('admin_roles','admin_roles.id = admin.admin_role_id');
		$this->db->order_by('admin.display_name ASC');
		$get_detail_report = $this->db->get('admin');
		//echo $this->db->last_query();exit;
		
		}
		
		$row_detail_report['task_detail_report_arr'] = $get_detail_report->result_array();
		$row_detail_report['task_detail_report_count'] = $get_detail_report->num_rows;
		
		for($i=0; $i<$row_detail_report['task_detail_report_count']; $i++){
		
		$branch_id=$row_detail_report['task_detail_report_arr'][$i]['branch_id']; 
		$this->db->dbprefix('branches');
		$this->db->select('branch_name');
		$this->db->where('id', $branch_id);
		$get_branch = $this->db->get('branches');
		$row_branch_arr= $get_branch->row_array();
		$row_detail_report['task_detail_report_arr'][$i]['branch_name']= $row_branch_arr['branch_name'];
		
		
	    //Get user task
	    $user_id=$row_detail_report['task_detail_report_arr'][$i]['id']; 
		
		$where ="(status=1 OR status=4)";
		$this->db->dbprefix('project_task');
		$this->db->where($where);
		$this->db->where('task_started_by', $user_id);
		$get_task = $this->db->get('project_task');
		$row_task= $get_task->row_array();
		
		
		$row_detail_report['task_detail_report_arr'][$i]['task_title']= $row_task['title']; 
		
		$row_detail_report['task_detail_report_arr'][$i]['task_id']= $row_task['id']; 
		
		$project_id= $row_task['project_id'];
		
		$this->db->dbprefix('projects');
		$this->db->select('id , project_title');
		$this->db->where('id', $project_id);
		$get_project= $this->db->get('projects');
		$row_project= $get_project->row_array();
		
		$row_detail_report['task_detail_report_arr'][$i]['project_name']= $row_project['project_title'];
		$row_detail_report['task_detail_report_arr'][$i]['project_id']= $row_project['id'];
		
		
		//Get Last Closed Tasks
        $this->db->dbprefix('project_task');
		$this->db->where('status', 3);
		$this->db->where('task_started_by', $user_id);
		$this->db->order_by('task_close_date',DESC);
		$get_task = $this->db->get('project_task');
		$row_closed_task= $get_task->row_array();
		
		
		$row_detail_report['task_detail_report_arr'][$i]['closed_task']= $row_closed_task['title']; 
		
		$row_detail_report['task_detail_report_arr'][$i]['task_close_date']=$row_closed_task['task_close_date'];
		
		
		
		//echo $this->db->last_query();exit;
		
	    //$task_team= $row_task['user_id'];
		
		$exp_team= explode(',',$row_task['user_id']);
		
		
	
		for($j=0; $j<count($exp_team); $j++){
			
			if($exp_team[$j] != $user_id){
			
			$this->db->dbprefix('admin');
			$this->db->select('id,display_name');
			$this->db->where('id', $exp_team[$j]);
			$get_admin = $this->db->get('admin');
			$row_admin= $get_admin->row_array();
			
			$team_name= $row_admin['display_name'];
			
			$row_detail_report['task_detail_report_arr'][$i]['team'][$j]= $team_name;
			
			}
		
		}
		
		
		//$row_detail_report['task_detail_report_arr'][$i]['task_title']= $row_task['title'];
		
		
		}//end for
		
	
		
	
	 /*   echo "<pre>";
		print_r($row_detail_report);
		exit;*/
		
		return $row_detail_report;		

		
	}//end task_detail_report
	
	
	
	//Get All SOP
	public function get_all_sop(){
		
		$this->db->dbprefix('sop');
		$this->db->order_by('id',DESC);
		$get_all_sop = $this->db->get('sop');

		//echo $this->db->last_query();
		$row_all_sop['sop_arr'] = $get_all_sop->result_array();
		$row_all_sop['sop_count'] = $get_all_sop->num_rows;
		
		for($i=0; $i<$row_all_sop['sop_count']; $i++){
			
			$role_id=$row_all_sop['sop_arr'][$i]['admin_role_id']; 
				
			$this->db->dbprefix('admin_roles');
			$this->db->where('id', $role_id);
			$get_role = $this->db->get('admin_roles');
			//echo $this->db->last_query();
			$row_role= $get_role->row_array();
			
			$row_all_sop['sop_arr'][$i]['designation']= $row_role['role_title']; 
			
		}
		
	   
		return $row_all_sop;
		
	}//end get_all_sop
	
	
	//get_sop
	public function get_sop($sop_id){
		
		$this->db->dbprefix('sop');
		$this->db->where('id',$sop_id);
		$get_sop = $this->db->get('sop');

		//echo $this->db->last_query();
		$row_sop['sop_arr'] = $get_sop->row_array();
		
		$role_id=$row_sop['sop_arr']['admin_role_id']; 
			
		$this->db->dbprefix('admin_roles');
		$this->db->where('id', $role_id);
		$get_role = $this->db->get('admin_roles');
		//echo $this->db->last_query();
		$row_role= $get_role->row_array();
		
		$row_sop['sop_arr']['designation']= $row_role['role_title']; 
		
		/*echo "<pre>";
		print_r($row_sop['sop_arr']);
		exit;*/
	   
		return $row_sop;
		
	}//end get_sop
	
	


###############################################################################################
#																							  #			
#  	Opposite of strip_tags in which we can make an array of those tags which are not allowed  # 
#																							  # 	
###############################################################################################

	 




	//Add add_sop
	public function add_sop($data){
		
		extract($data);
		
		$dob = date("Y-m-d", strtotime($dob));
		$join_date = date("Y-m-d", strtotime($join_date));
		$last_increament = date("Y-m-d", strtotime($last_increament));
		
		
		$created_date = date('Y-m-d G:i:s');
		$created_by_ip = $this->input->ip_address();
		$created_by = $this->session->userdata('admin_id');
		
		function stripSingleTags($string, $not_allowed_tags)
		{
			foreach( $not_allowed_tags as $tag )
			{
				$string = preg_replace('#</?'.$tag.'[^>]*>#is', '', $string);
			}
			
			return $string;
		}
		
		$tags = array('script');
		
        $string= stripSingleTags($description,$tags);
       
		$ins_data = array(
		   'title' => $this->db->escape_str(trim($title)),
		   'admin_role_id' => $this->db->escape_str(trim($admin_role_id)),
		   'description' => trim($string),
		   'status' => $this->db->escape_str(trim($status)),
		   'created_by' => $this->db->escape_str(trim($created_by)),
		   'created_date' => $this->db->escape_str(trim($created_date)),
		   'created_by_ip' => $this->db->escape_str(trim($created_by_ip))
		);		

		//Inserting the record into the database.
		$this->db->dbprefix('sop');
		$ins_into_db = $this->db->insert('sop', $ins_data);
		
		return true;
		
	}//End add_sop
	
	
	//Add edit_sop
	public function edit_sop($data){
		
		extract($data);
		
		$dob = date("Y-m-d", strtotime($dob));
		$join_date = date("Y-m-d", strtotime($join_date));
		$last_increament = date("Y-m-d", strtotime($last_increament));
		
		
		$last_modified_date = date('Y-m-d G:i:s');
		$last_modified_ip = $this->input->ip_address();
		$last_modified_by = $this->session->userdata('admin_id');
		
		function stripSingleTags($string, $not_allowed_tags)
		{
			foreach( $not_allowed_tags as $tag )
			{
				$string = preg_replace('#</?'.$tag.'[^>]*>#is', '', $string);
			}
			
			return $string;
		}
		
		$tags = array('script');
		
        $string= stripSingleTags($description,$tags);

		$upd_data = array(
		   'title' => $this->db->escape_str(trim($title)),
		   'admin_role_id' => $this->db->escape_str(trim($admin_role_id)),
		   'description' => trim($string),
		   'status' => $this->db->escape_str(trim($status)),
		   'last_modified_by' => $this->db->escape_str(trim($last_modified_by)),
		   'last_modified_date' => $this->db->escape_str(trim($last_modified_date)),
		   'last_modified_ip' => $this->db->escape_str(trim($last_modified_ip))
		);		

		//Inserting the record into the database.
		$this->db->dbprefix('sop');
		$this->db->where('id', $sop_id);
		$this->db->update('sop', $upd_data);
		
		return true;
		
	}//End edit_sop
	
	
	//delete_sop
	 public function delete_sop($sop_id){
		
		//Inserting the record into the database.
		$this->db->dbprefix('sop');
		$this->db->where('id', $sop_id);
		$this->db->delete('sop');
		
		return true;
		
	}//End delete_sop
	
	
	
	//add_increament
	public function add_increament($data){
		
		extract($data);
		
		//echo $user_id;
		//exit;
		
		$this->db->dbprefix('admin');
		$this->db->where('id',$user_id);
		$get_admin_profile = $this->db->get('admin');
		
		$admin_arr = $get_admin_profile->row_array();
		
		$last_salary = $admin_arr['salary'];
		
		$new_salary = $last_salary + $amount;
		
		
		//Update Salary
		$upd_data = array(
		   'salary' => $this->db->escape_str(trim($new_salary))
		);		

		//Inserting the record into the database.
		$this->db->dbprefix('admin');
		$this->db->where('id', $user_id);
		$this->db->update('admin', $upd_data);
		
		$created_date = date('Y-m-d G:i:s');
		$created_by_ip = $this->input->ip_address();
		$created_by = $this->session->userdata('admin_id');
		

		$ins_data = array(
		   'emp_id' => $this->db->escape_str(trim($user_id)),
		   'amount' => $this->db->escape_str(trim($amount)),
		   'description' => $this->db->escape_str(trim($description)),
		   'created_date' => $this->db->escape_str(trim($created_date)),
		   'created_by_ip' => $this->db->escape_str(trim($created_by_ip)),
		   'created_by' => $this->db->escape_str(trim($created_by))
		);		

		//Inserting the record into the database.
		$this->db->dbprefix('increament_log');
		$this->db->insert('increament_log', $ins_data);
		
		return true;
		
	}//End add_increament
	

}
?>