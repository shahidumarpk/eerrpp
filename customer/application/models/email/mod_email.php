<?php
class mod_email extends CI_Model {
	
	function __construct(){
		
        parent::__construct();
    }

	//Get All CMS pages.
	public function get_all_emails(){
		
		$this->db->dbprefix('email');
		$this->db->order_by('id DESC');
		$get_email_pages = $this->db->get('emails');

		//echo $this->db->last_query();
		$row_email['email_pages_arr'] = $get_email_pages->result_array();
		$row_email['email_pages_count'] = $get_email_pages->num_rows;
		return $row_email;
		
	}//end get_all_email_pages

	//Get email Record
	public function get_email($email_id){
		
		$this->db->dbprefix('email');
		$this->db->where('id',$email_id);
		$get_email_email = $this->db->get('email');

		//echo $this->db->last_query();
		$row_email['email_arr'] = $get_email_email->row_array();
		$row_email['email_count'] = $get_email_email->num_rows;
		//print_r($row_email['email_arr']); exit;
		return $row_email;
		
	}//end get_all_email_pages
	
	//Add New Page
	public function add_new_page($data){
		
		extract($data);
		$generate_seo_url = $this->mod_common->generate_seo_url($page_title);
		$verified_seo_url = $this->mod_common->verify_seo_url($generate_seo_url,'pages','seo_url_name',0);
		
		$created_date = date('Y-m-d G:i:s');
		$ip_address = $this->input->ip_address();
		$created_by = $this->session->userdata('admin_id');

		$ins_data = array(
		   'page_title' => $this->db->escape_str(trim($page_title)),
		   'page_short_desc' => $this->db->escape_str(trim($page_short_desc)),
		   'page_long_desc' => $this->db->escape_str(trim($page_long_desc)),
		   'meta_title' => $this->db->escape_str(trim($meta_title)),
		   'meta_keywords' => $this->db->escape_str(trim($meta_keywords)),
		   'meta_description' => $this->db->escape_str(trim($meta_description)) ,
		   'lang' => $this->db->escape_str(trim($lang)),
		   'status' => $this->db->escape_str(trim($status)),
		   'seo_url_name' => $this->db->escape_str(trim($verified_seo_url)),
		   'created_by' => $this->db->escape_str(trim($created_by)),
		   'created_by_ip' => $this->db->escape_str(trim($ip_address)),
		   'created_date' => $this->db->escape_str(trim($created_date)),
		);

		//Insert the record into the database.
		$this->db->dbprefix('pages');
		$ins_into_db = $this->db->insert('pages', $ins_data);
		//echo $this->db->last_query(); exit;
		
		if($ins_into_db) return true;

	}//end add_new_page()
	
	//Edit Page
	public function edit_new_page($data){
		
		extract($data);
		$generate_seo_url = $this->mod_common->generate_seo_url(trim($page_title));
		$verified_seo_url = $this->mod_common->verify_seo_url($generate_seo_url,'pages','seo_url_name',$page_id);
		
		$last_modified_date = date('Y-m-d G:i:s');
		$last_modified_ip = $this->input->ip_address();
		$last_modified_by = $this->session->userdata('admin_id');

		$upd_data = array(
		   'page_title' => $this->db->escape_str(trim($page_title)),
		   'page_short_desc' => $this->db->escape_str(trim($page_short_desc)),
		   'page_long_desc' => $this->db->escape_str(trim($page_long_desc)),
		   'meta_title' => $this->db->escape_str(trim($meta_title)),
		   'meta_keywords' => $this->db->escape_str(trim($meta_keywords)),
		   'meta_description' => $this->db->escape_str(trim($meta_description)) ,
		   'status' => $this->db->escape_str(trim($status)),
		   'seo_url_name' => $this->db->escape_str(trim($verified_seo_url)),
		   'last_modified_by' => $this->db->escape_str(trim($last_modified_by)),
		   'last_modified_date' => $this->db->escape_str(trim($last_modified_date)),
		   'last_modified_ip' => $this->db->escape_str(trim($last_modified_ip))
		);

		//Update the record into the database.
		$this->db->dbprefix('pages');
		$this->db->where('id',$page_id);
		$upd_into_db = $this->db->update('pages', $upd_data);
		//echo $this->db->last_query();
		
		if($upd_into_db) return true;

	}//end edit_new_page()

	//Delete Page
	public function delete_page($page_id){
		
		$get_page_arr = $this->mod_cms->get_cms_page($page_id);
		$set_as_default = $get_page_arr['cms_page_arr']['set_as_default'];
		
		//Page defined as defualt cannot be deleted
		if($set_as_default == 0){
			
			//Delete the record from the database.
			$this->db->dbprefix('pages');
			$this->db->where('id',$page_id);
			$del_into_db = $this->db->delete('pages');
			//$this->db->last_query();
			if($del_into_db) return true;
		}else
			return false;
		
	}//end delete_page()

}
?>