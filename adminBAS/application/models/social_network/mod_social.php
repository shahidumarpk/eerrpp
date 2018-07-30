<?php
class Mod_social extends CI_Model {
	
	function __construct(){
		
        parent::__construct();
    }

	
	
	## UPDATE PROFILE ##

	//Get get_social_tools
	public function get_social_tools(){
		
		
		$this->db->dbprefix('social_network');
	
		$get_social_tools = $this->db->get('social_network');

		//echo $this->db->last_query();
		$row_social['social_tools_arr'] = $get_social_tools->row_array();
		$row_social['social_tools_count'] = $get_social_tools->num_rows;
		return $row_social;
		
	}//end get_social_tools
	
	//Updatiing social tool
	public function update_social_tools($data){
		
		extract($data);
		
		$last_modified_date = date('Y-m-d G:i:s');
		$last_modified_ip = $this->input->ip_address();
		$last_modified_by = $this->session->userdata('admin_id');

		$upd_data = array(
		   'facebook_link_page' => $this->db->escape_str(trim($facebook_link_page)),
		   'twitter_link_page' => $this->db->escape_str(trim($twitter_link_page)),
		   'googleplus_link_page' => $this->db->escape_str(trim($googleplus_link_page)),
		   'last_modified_by' => $this->db->escape_str(trim($last_modified_by)),
		   'last_modified_date' => $this->db->escape_str(trim($last_modified_date)),
		   'last_modified_ip' => $this->db->escape_str(trim($last_modified_ip))
		);		

		
		//Update the record into the database.
		$this->db->dbprefix('social_network');
		$upd_into_db = $this->db->update('social_network', $upd_data);
		
		//echo $this->db->last_query();
		
			return true;
	
		
	}//end update_social_tools




}
?>