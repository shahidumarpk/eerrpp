<?php
class mod_advertisements extends CI_Model {
	
	function __construct(){
		
        parent::__construct();
    }

	//Get All Advertisements
	public function get_all_advertisements(){
		
		$this->db->dbprefix('advertisements');
		$this->db->order_by('id DESC');
		$get_advertisements = $this->db->get('advertisements');

		//echo $this->db->last_query();
		$row_advertisements['advertisements_arr'] = $get_advertisements->result_array();
		$row_advertisements['advertisements_count'] = $get_advertisements->num_rows;
		return $row_advertisements;
		
	}//end get_all_advertisements

	//Get Advertisement Record
	public function get_advertisement($add_id){
		
		$this->db->dbprefix('advertisements');
		$this->db->where('id',$add_id);
		$get_advertisement = $this->db->get('advertisements');

		//echo $this->db->last_query(); exit;
		$row_advertisement['advertisement_arr'] = $get_advertisement->row_array();
		$row_advertisement['advertisement_count'] = $get_advertisement->num_rows;
		return $row_advertisement;
		
	}//end get_advertisement
	
	
	//Add New Advertisement
	public function add_advertisement($data){
		
		extract($data);

		//Uploading Advertisement Image
		if($_FILES['image']['name'] != ''){

			//Create User Directory if not exist
			$advertisement_folder_path = '../assets/advertisements';
	
			$file_name = 	'advertisement-'.date('YmdGis').'.jpg';

			$config['upload_path'] = $advertisement_folder_path;
			$config['allowed_types'] = 'jpg|jpeg|gif|tiff|png';
			$config['max_size']	= '6000';
			$config['overwrite'] = true;
			$config['file_name'] = $file_name;
		
			$this->load->library('upload', $config);

			if(!$this->upload->do_upload('image')){
				
				$error_file_arr = array('error' => $this->upload->display_errors());
				return $error_file_arr;
				
			}else{

				$data_image_upload = array('upload_image_data' => $this->upload->data());
				
				//Resize the Uploaded Image 800 * 600
				$config_profile['image_library'] = 'gd2';
				$config_profile['source_image'] = $advertisement_folder_path.'/'.$file_name;
				$config_profile['create_thumb'] = TRUE;
				$config_profile['thumb_marker'] = '';
				
				$config_profile['maintain_ratio'] = TRUE;
				$config_profile['width'] = 800;
				$config_profile['height'] = 600;
				
				$this->load->library('image_lib');
				$this->image_lib->initialize($config_profile);
				$this->image_lib->resize();
				$this->image_lib->clear();

				//Creating Thumbmail 28 * 28
				//Uploading is successful now resizing the uploaded image 
				$config_profile['image_library'] = 'gd2';
				$config_profile['source_image'] = $advertisement_folder_path.'/'.$file_name;
				$config_profile['new_image'] = $advertisement_folder_path.'/thumb/'.$file_name;
				$config_profile['create_thumb'] = TRUE;
				$config_profile['thumb_marker'] = '';
				
				$config_profile['maintain_ratio'] = TRUE;
				$config_profile['width'] = 230;
				$config_profile['height'] = 150;
				
				$this->load->library('image_lib');
				$this->image_lib->initialize($config_profile);
				$this->image_lib->resize();
				$this->image_lib->clear();
				
			}//end if(!$this->upload->do_upload('image'))


		}//end if($_FILES['image']['name'] != '')
		
	
		
		$created_date = date('Y-m-d G:i:s');
		$ip_address = $this->input->ip_address();
		$created_by = $this->session->userdata('admin_id');

		$ins_data = array(
		   'title' => $this->db->escape_str(trim($title)),
		   'image' => $this->db->escape_str(trim($file_name)),
		   'link' => $this->db->escape_str(trim($link)),
		   'status' => $this->db->escape_str(trim($status)),
		   'created_by' => $this->db->escape_str(trim($created_by)),
		   'created_by_ip' => $this->db->escape_str(trim($ip_address)),
		   'created_date' => $this->db->escape_str(trim($created_date)),
		);

		//Insert the record into the database.
		$this->db->dbprefix('advertisements');
		$ins_into_db = $this->db->insert('advertisements', $ins_data);
		//echo $this->db->last_query();
		
		if($ins_into_db) return true;

	}//end add_advertisement()
	
	
	//Edit Advertisement
	public function edit_advertisement($data){
		
		extract($data);
		
		$get_data = $this->mod_advertisements->get_advertisement($add_id);
		
		
		$get_data_arr = $get_data['advertisement_arr'];
		
		$old_file_name = $get_data_arr['image'];
		
		
		//Uploading Advertisement 
		if($_FILES['image']['name'] != ''){

			//Create User Directory if not exist
			$advertisement_folder_path = '../assets/advertisements';
	
			$file_ext           = ltrim(strtolower(strrchr($_FILES['slider_image']['name'],'.')),'.'); 			
			$file_name = 	'advertisement-'.date('YmdGis').'.jpg';

			$config['upload_path'] = $advertisement_folder_path;
			$config['allowed_types'] = 'jpg|jpeg|gif|tiff|png';
			$config['max_size']	= '6000';
			$config['overwrite'] = true;
			$config['file_name'] = $file_name;
		
			$this->load->library('upload', $config);

			if(!$this->upload->do_upload('image')){
				
				$error_file_arr = array('error' => $this->upload->display_errors());
				return $error_file_arr;
				
			}else{

				$data_image_upload = array('upload_image_data' => $this->upload->data());
				
				//Resize the Uploaded Image 800 * 600
				$config_profile['image_library'] = 'gd2';
				$config_profile['source_image'] = $advertisement_folder_path.'/'.$file_name;
				$config_profile['create_thumb'] = TRUE;
				$config_profile['thumb_marker'] = '';
				
				$config_profile['maintain_ratio'] = TRUE;
				$config_profile['width'] = 800;
				$config_profile['height'] = 600;
				
				$this->load->library('image_lib');
				$this->image_lib->initialize($config_profile);
				$this->image_lib->resize();
				$this->image_lib->clear();

				//Creating Thumbmail 28 * 28
				//Uploading is successful now resizing the uploaded image 
				$config_profile['image_library'] = 'gd2';
				$config_profile['source_image'] = $advertisement_folder_path.'/'.$file_name;
				$config_profile['new_image'] = $advertisement_folder_path.'/thumb/'.$file_name;
				$config_profile['create_thumb'] = TRUE;
				$config_profile['thumb_marker'] = '';
				
				$config_profile['maintain_ratio'] = TRUE;
				$config_profile['width'] = 230;
				$config_profile['height'] = 150;
				
				$this->load->library('image_lib');
				$this->image_lib->initialize($config_profile);
				$this->image_lib->resize();
				$this->image_lib->clear();
				
			}//end if(!$this->upload->do_upload('image'))

			//Delete Existing Image
			if(file_exists($advertisement_folder_path.'/'.$old_file_name)){
				
				unlink($advertisement_folder_path.'/'.$old_file_name);
				unlink($advertisement_folder_path.'/thumb/'.$old_file_name);
			}

		}else{
			$file_name = $old_file_name;	
		}//end if($_FILES['image']['name'] != '')
		
		$last_modified_date = date('Y-m-d G:i:s');
		$last_modified_ip = $this->input->ip_address();
		$last_modified_by = $this->session->userdata('admin_id');

		$upd_data = array(
		   'title' => $this->db->escape_str(trim($title)),
		   'image' => $this->db->escape_str(trim($file_name)),
		   'link' => $this->db->escape_str(trim($link)),
		   'status' => $this->db->escape_str(trim($status)),
		   'last_modified_by' => $this->db->escape_str(trim($last_modified_by)),
		   'last_modified_date' => $this->db->escape_str(trim($last_modified_date)),
		   'last_modified_ip' => $this->db->escape_str(trim($last_modified_ip))
		);

		//Update the record into the database.
		$this->db->dbprefix('advertisements');
		$this->db->where('id',$add_id);
		$upd_into_db = $this->db->update('advertisements', $upd_data);
		//echo $this->db->last_query();exit;
		
		if($upd_into_db) return true;

	}//end edit_advertisements()
	

	//Delete Advertisement
	public function delete_advertisement($add_id){


		$get_data = $this->mod_advertisements->get_advertisement($add_id);
		$get_data_arr = $get_data['advertisement_arr'];
		
		//Create User Directory if not exist
		$advertisement_folder_path = '../assets/advertisements';

	    $old_file_name = $get_data_arr['image'];
		

		//Delete Existing Image
		if(file_exists($advertisement_folder_path.'/'.$old_file_name)){
			
			unlink($advertisement_folder_path.'/'.$old_file_name);
			unlink($advertisement_folder_path.'/thumb/'.$old_file_name);
		}//end if
		
		//Delete the record from the database.
		$this->db->dbprefix('advertisements');
		$this->db->where('id',$add_id);
		$del_into_db = $this->db->delete('advertisements');
		//echo $this->db->last_query(); exit;
		
		if($del_into_db) return true;

	}//end delete_advertisement()

}
?>