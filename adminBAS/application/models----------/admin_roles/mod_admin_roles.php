<?php
class mod_admin_roles extends CI_Model {
	
	function __construct(){
		
        parent::__construct();
    }

	## ROLES MANAGEMENT ##
	
	//Get All Admin Roles
	public function get_all_admin_roles(){
		
		$this->db->dbprefix('admin_roles');
		$this->db->order_by('id DESC');
		$get_admin_roles = $this->db->get('admin_roles');
		
		$row_admin_roles['admin_roles_result'] = $get_admin_roles->result_array();
		$row_admin_roles['admin_roles_result_count'] = $get_admin_roles->num_rows;
		
		return $row_admin_roles;		
		
	}//end get_all_admin_roles
	
	//Adding New admin Role
	public function add_new_role($data){
		
		extract($data);
		
		$created_date = date('Y-m-d G:i:s');
		$created_by_ip = $this->input->ip_address();
		$created_by = $this->session->userdata('admin_id');
		
		$permission_str = implode(';',$permission_arr);
		
		if($permission_mobile_arr !=""){
			
		$permission_mobile_str = implode(';',$permission_mobile_arr);
		
		}


		$ins_data = array(
		   'role_title' => $this->db->escape_str(trim($role_title)),
		   'permissions' => $this->db->escape_str(trim($permission_str)),
		   'permissions_mobile' => $this->db->escape_str(trim($permission_mobile_str)),
		   'status' => $this->db->escape_str(trim($status)),
		   'created_by' => $this->db->escape_str(trim($created_by)),
		   'created_date' => $this->db->escape_str(trim($created_date)),
		   'created_by_ip' => $this->db->escape_str(trim($created_by_ip))
		);		

		//Inserting the record into the database.
		$this->db->dbprefix('admin_roles');
		$ins_into_db = $this->db->insert('admin_roles', $ins_data);
		
		if($ins_into_db)
			return true;

		
	}//end add_new_roles

	//Update admin Role
	public function edit_role($data){
		
		extract($data);
		
		$last_modified_date = date('Y-m-d G:i:s');
		$last_modified_ip = $this->input->ip_address();
		$last_modified_by = $this->session->userdata('admin_id');
		
		$permission_str = implode(';',$permission_arr);
		
		
		if($permission_mobile_arr !=""){
			
		   $permission_mobile_str = implode(';',$permission_mobile_arr);
		}

		$ins_data = array(
		   'role_title' => $this->db->escape_str(trim($role_title)),
		   'permissions' => $this->db->escape_str(trim($permission_str)),
		   'permissions_mobile' => $this->db->escape_str(trim($permission_mobile_str)),
		   'status' => $this->db->escape_str(trim($status)),
		   'last_modified_by' => $this->db->escape_str(trim($last_modified_by)),
		   'last_modified_date' => $this->db->escape_str(trim($last_modified_date)),
		   'last_modified_ip' => $this->db->escape_str(trim($last_modified_ip))
		);		

		//Inserting the record into the database.
		$this->db->dbprefix('admin_roles');
		$this->db->where('id',$role_id);
		$ins_into_db = $this->db->update('admin_roles', $ins_data);
		
		//echo $this->db->last_query();
		
		if($ins_into_db)
			return true;

	}//end edit_role
	
	//Get Admin Role Data
	public function get_admin_role($role_id){
		
		$this->db->dbprefix('admin_roles');
		$this->db->where('id',$role_id);
		$get_admin_role = $this->db->get('admin_roles');

		//echo $this->db->last_query();
		$row_admin['admin_role_arr'] = $get_admin_role->row_array();
		$row_admin['admin_role_count'] = $get_admin_role->num_rows;
		return $row_admin;
		
	}//end get_admin_role

}
?>