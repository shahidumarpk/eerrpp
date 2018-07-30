<?php
class mod_email_template extends CI_Model {
	
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


	//Add new Email Template
	public function add_email_template($data){
		
		extract($data);
		
		$created_date = date('Y-m-d G:i:s');
		$created_by_ip = $this->input->ip_address();
		$created_by = $this->session->userdata('admin_id');

		$ins_data = array(
		   'title' => $this->db->escape_str(trim($title)),
		   'email_subject' => $this->db->escape_str(trim($email_subject)),
		   'email_body' => trim($email_body),
		   'is_default' => $this->db->escape_str(trim($is_default)),
		   'status' => $this->db->escape_str(trim($status)),
		   'created_by' => $this->db->escape_str(trim($created_by)),
		   'created_date' => $this->db->escape_str(trim($created_date)),
		   'created_by_ip' => $this->db->escape_str(trim($created_by_ip))
		);		

		//Inserting the record into the database.
		$this->db->dbprefix('email');
		$ins_into_db = $this->db->insert('email', $ins_data);
		
	     return true;
		
		
	}//end add_email_template

	
	
	public function get_email_templates(){
		
	
		$this->db->dbprefix('email');
		
		
		$get_email_templates= $this->db->get('email');

		//echo $this->db->last_query();exit;
		
		$get_email_templates_arr['email_templates_result'] = $get_email_templates->result_array();
		
		
		$get_email_templates_arr['email_templates_count'] = $get_email_templates->num_rows;
		
		return $get_email_templates_arr;		
		
	}//end get_email_templates
	
	
	public function edit_email_template($id){
		
		
		$this->db->dbprefix('email');
		$this->db->where('id',$id);
		$edit_email_template= $this->db->get('email');
		
		$edit_email_template_arr= $edit_email_template->row_array();
		
	    return $edit_email_template_arr;
		
		
	}//end edit_email_template
	
	
	public function update_email_template_process($data){
		
		extract($data);
		
		$last_modified_date = date('Y-m-d G:i:s');
		$last_modified_ip = $this->input->ip_address();
		$last_modified_by = $this->session->userdata('admin_id');
	
		$upd_data = array(
		   'title' => $this->db->escape_str(trim($title)),
		   'email_subject' => $this->db->escape_str(trim($email_subject)),
		   'email_body' => trim($email_body),
		   'is_default' => $this->db->escape_str(trim($is_default)),
		   'status' => $this->db->escape_str(trim($status)),
		   'modified_by' => $this->db->escape_str(trim($last_modified_by)),
		   'last_modified_date' => $this->db->escape_str(trim($last_modified_date)),
		   'last_modified_ip' => $this->db->escape_str(trim($last_modified_ip))
		);		

		//Update the record into the database.
		$this->db->dbprefix('email');
		$this->db->where('id',$id);
		$upd_into_db = $this->db->update('email', $upd_data);
		
		//echo $this->db->last_query();
		
		if($upd_into_db)
			return true;
			
	}//end update_email_template process
	
	
	public function delete_email_template($id){
		
			//Delete the record from the database.
			$this->db->dbprefix('email');
			$this->db->where('id',$id);
			$del_into_db = $this->db->delete('email');
			
			if($del_into_db) return true;
			//echo $this->db->last_query();

		
	}//end delete_email_template
	
	

}
?>