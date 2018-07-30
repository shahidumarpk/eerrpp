<?php
class mod_branches extends CI_Model {
	
	function __construct(){
		
        parent::__construct();
    }

	//Get All Branches
	public function get_all_branches(){
		
		$this->db->dbprefix('branches');
		$this->db->order_by('id DESC');
		$get_branches = $this->db->get('branches');

		//echo $this->db->last_query();
		$row_branches['branches_arr'] = $get_branches->result_array();
		$row_branches['branches_count'] = $get_branches->num_rows;
		
		return $row_branches;
		
	}//end get_all_branches
	

	//Get Branch Record
	public function get_branch($branch_id){
		
		$this->db->dbprefix('branches');
		$this->db->where('id',$branch_id);
		$get_branch = $this->db->get('branches');

		//echo $this->db->last_query(); exit;
		$row_branch['branch_arr'] = $get_branch->row_array();
		$row_branch['branch_count'] = $get_branch->num_rows;
		return $row_branch;
		
	}//end get_branch
	
	
	//Add New Branch
	public function add_branch($data){
		
		extract($data);
		
		$created_date = date('Y-m-d G:i:s');
		$ip_address = $this->input->ip_address();
		$created_by = $this->session->userdata('admin_id');

		$ins_data = array(
		   'branch_name' => $this->db->escape_str(trim($branch_name)),
		   'short_name' => $this->db->escape_str(trim($short_name)),
		   'land_line_number' => $this->db->escape_str(trim($land_line_number)),
		   'mobile_number' => $this->db->escape_str(trim($mobile_number)),
		   'address' => $this->db->escape_str(trim($address)),
		   'contact_person_name' => $this->db->escape_str(trim($contact_person_name)),
		   'contact_person_number' => $this->db->escape_str(trim($contact_person_number)),
		   'status' => $this->db->escape_str(trim($status)),
		   'created_by' => $this->db->escape_str(trim($created_by)),
		   'created_by_ip' => $this->db->escape_str(trim($ip_address)),
		   'created_date' => $this->db->escape_str(trim($created_date)),
		);

		//Insert the record into the database.
		$this->db->dbprefix('branches');
		$ins_into_db = $this->db->insert('branches', $ins_data);
		//echo $this->db->last_query();exit;
		
		if($ins_into_db) return true;

	}//end add_branch()
	
	
	//Edit Branch
	public function edit_branch($data){
		
		extract($data);
		
		$last_modified_date = date('Y-m-d G:i:s');
		$last_modified_ip = $this->input->ip_address();
		$last_modified_by = $this->session->userdata('admin_id');

		$upd_data = array(
		   'branch_name' => $this->db->escape_str(trim($branch_name)),
		   'short_name' => $this->db->escape_str(trim($short_name)),
		   'land_line_number' => $this->db->escape_str(trim($land_line_number)),
		   'mobile_number' => $this->db->escape_str(trim($mobile_number)),
		   'address' => $this->db->escape_str(trim($address)),
		   'contact_person_name' => $this->db->escape_str(trim($contact_person_name)),
		   'contact_person_number' => $this->db->escape_str(trim($contact_person_number)),
		   'status' => $this->db->escape_str(trim($status)),
		   'last_modified_by' => $this->db->escape_str(trim($last_modified_by)),
		   'last_modified_date' => $this->db->escape_str(trim($last_modified_date)),
		   'last_modified_ip' => $this->db->escape_str(trim($last_modified_ip))
		);

		//Update the record into the database.
		$this->db->dbprefix('branches');
		$this->db->where('id',$branch_id);
		$upd_into_db = $this->db->update('branches', $upd_data);
		//echo $this->db->last_query();exit;
		
		if($upd_into_db) return true;

	}//end edit_branch()
	

	//Delete Branch
	public function delete_branch($branch_id){
		
		//Delete the record from the database.
		$this->db->dbprefix('branches');
		$this->db->where('id',$branch_id);
		$del_into_db = $this->db->delete('branches');
		//echo $this->db->last_query(); exit;
		
		if($del_into_db) return true;

	}//end delete_branch()

}
?>