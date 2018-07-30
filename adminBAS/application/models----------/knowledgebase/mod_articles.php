<?php
class mod_articles extends CI_Model {
	
	function __construct(){
		
        parent::__construct();
    }


	
	//Get all_articles
	public function get_all_articles(){
		
		$this->db->dbprefix('articles');
		$this->db->order_by('id DESC');
		$get_all_articles= $this->db->get('articles');
		//echo $this->db->last_query();exit;
		
		$row_all_articles['all_articles_arr'] = $get_all_articles->result_array();
		$row_all_articles['all_articles_count'] = $get_all_articles->num_rows;
		
		for($i=0; $i<$row_all_articles['all_articles_count']; $i++){
		
		$admin_role_id=$row_all_articles['all_articles_arr'][$i]['admin_role_id']; 
		$this->db->dbprefix('admin_roles');
		$this->db->select('role_title');
		$this->db->where('id', $admin_role_id);
		$get_role = $this->db->get('admin_roles');
		$row_role= $get_role->row_array();
		$row_all_articles['all_articles_arr'][$i]['role_title']= $row_role['role_title'];
		
		$created_by=$row_all_articles['all_articles_arr'][$i]['created_by']; 
		$this->db->dbprefix('admin');
		$this->db->select('id,display_name');
		$this->db->where('id', $created_by);
		$get_admin = $this->db->get('admin');
		$row_admin= $get_admin->row_array();
		$row_all_articles['all_articles_arr'][$i]['posted_by']= $row_admin['display_name'];
		$row_all_articles['all_articles_arr'][$i]['admin_id']= $row_admin['id'];
		
		}//end for
		
		return $row_all_articles;	
		
	}//end get_all_articles
	
	
	
	//get_article
	public function get_article($article_id){
		
		$this->db->dbprefix('articles');
		$this->db->where('id',$article_id);
		$get_article= $this->db->get('articles');

		//echo $this->db->last_query();
		$row_article['article_arr'] = $get_article->row_array();
		
		$role_id=$row_article['article_arr']['admin_role_id']; 
			
		$this->db->dbprefix('admin_roles');
		$this->db->where('id',$role_id);
		$get_role = $this->db->get('admin_roles');
		//echo $this->db->last_query();
		$row_role= $get_role->row_array();
		
	    $row_article['article_arr']['role_title']= $row_role['role_title']; 
		
		/*echo "<pre>";
		print_r($row_article['article_arr']);
		exit;*/
	   
		return $row_article;
		
	}//end get_sop
	
	

	//Add new article
	public function add_article($data){
		
		extract($data);
		
		
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
		
		
			
		//Uploading attachment
		if($_FILES['attachment']['name'] != ''){
			
			
			//Create User Directory if not exist
		    $attch_folder_path = '../assets/article_attachments/'.$created_by;
		
		   if(!is_dir($attch_folder_path))
			mkdir($attch_folder_path);
			
			 $attach_name=str_replace(' ','_',$_FILES['attachment']['name']);
			  		
		     $attch_name = $created_by."_".$attach_name; 
			

			$config['upload_path'] = $attch_folder_path;
			$config['allowed_types'] = 'zip';
			$config['max_size']	= '15000';
			$config['overwrite'] = true;
			$config['file_name'] = $attch_name;
		
			$this->load->library('upload', $config);
			
			
			if(!$this->upload->do_upload('attachment')){
				
				 
				$error_file_arr = array('error' => $this->upload->display_errors());
				
				return $error_file_arr;
				
			}
			
			
		}//end if($_FILES['attachment']['name'] != '')
		
		

		$ins_data = array(
		   'admin_role_id' => $this->db->escape_str(trim($admin_role_id)),
		   'title' => $this->db->escape_str(trim($title)),
		    'description' => trim($string),
		   'attachments' => $this->db->escape_str(trim($attch_name)),
		   'status' => $this->db->escape_str(trim($status)),
		   'created_by' => $this->db->escape_str(trim($created_by)),
		   'created_date' => $this->db->escape_str(trim($created_date)),
		   'created_by_ip' => $this->db->escape_str(trim($created_by_ip))
		);		

		//Inserting the record into the database.
		$this->db->dbprefix('articles');
		$ins_into_db = $this->db->insert('articles', $ins_data);
		
		//echo $this->db->last_query(); exit;
		return true;
				
	}//end add_article
	

	//Edit Article
	public function edit_article($data){
		
		extract($data);
		
		
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
		   'admin_role_id' => $this->db->escape_str(trim($admin_role_id)),
		   'title' => $this->db->escape_str(trim($title)),
		    'description' => trim($string),
		   'status' => $this->db->escape_str(trim($status)),
		   'last_modified_by' => $this->db->escape_str(trim($last_modified_by)),
		   'last_modified_date' => $this->db->escape_str(trim($last_modified_date)),
		   'last_modified_ip' => $this->db->escape_str(trim($last_modified_ip))
		);		

		
		$get_article = $this->mod_articles->get_article($article_id);
		$get_article_arr = $get_article['article_arr'];
		
		$old_file_name = $get_article_arr['attachments'];
		
		//Uploading attachment
		if($_FILES['attachment']['name'] != ''){
			
			//Create User Directory if not exist
		    $attch_folder_path = '../assets/article_attachments/'.$last_modified_by;
		
		   if(!is_dir($attch_folder_path))
			mkdir($attch_folder_path);
			
		    $attach_name=str_replace(' ','_',$_FILES['attachment']['name']);
			  		
		     $attch_name = $last_modified_by."_".$attach_name; 

			$config['upload_path'] = $attch_folder_path;
			$config['allowed_types'] = 'zip';
			$config['max_size']	= '15000';
			$config['overwrite'] = true;
			$config['file_name'] = $attch_name;
		
			$this->load->library('upload', $config);
			
			
			if(!$this->upload->do_upload('attachment')){
				
				 
				$error_file_arr = array('error' => $this->upload->display_errors());
				
				return $error_file_arr;
				
			}
			
			//Delete Existing Image
			if($old_file_name !=""){
				
			$user_folder_path = '../assets/article_attachments/'.$last_modified_by."/".$old_file_name;
			
			$delete_user_folder = $this->mod_common->remove_directory($user_folder_path);
	
			}
			
			
			$upd_data['attachments'] = $this->db->escape_str(trim($attch_name));
			
		}//end if($_FILES['prof_image']['name'] != '')

		//Updating the record into the database.
		$this->db->dbprefix('articles');
		$this->db->where('id',$article_id);
		$upd_into_db = $this->db->update('articles', $upd_data);
		
		//echo $this->db->last_query(); exit;
		
		if($upd_into_db)
		return true;
		
	}//end edit_user
	
	//Delete Article
	public function delete_article($article_id){
		
		
			$admin_id = $this->session->userdata('admin_id');
			
			$get_article = $this->mod_articles->get_article($article_id);
		    $get_article_arr = $get_article['article_arr'];
		
		    $file_name = $get_article_arr['attachments'];
			
			if($file_name !=""){
			$user_folder_path = '../assets/article_attachments/'.$admin_id;
			$delete_user_folder = $this->mod_common->remove_directory($user_folder_path);
	
			}
			
			//Delete the record from the database.
			$this->db->dbprefix('articles');
			$this->db->where('id',$article_id);
			$del_into_db = $this->db->delete('articles');
			if($del_into_db) return true;
			//echo $this->db->last_query();

		
	}//end delete_article
	


}
?>