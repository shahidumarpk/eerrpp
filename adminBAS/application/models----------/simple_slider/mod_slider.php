<?php
class mod_slider extends CI_Model {
	
	function __construct(){
		
        parent::__construct();
    }

	//Get All CMS pages.
	public function get_all_slider_images(){
		
		$this->db->dbprefix('simple_slider_images');
		$this->db->order_by('id DESC');
		$get_slider_images = $this->db->get('simple_slider_images');

		//echo $this->db->last_query();
		$row_slider_images['slider_images_arr'] = $get_slider_images->result_array();
		$row_slider_images['slider_images_count'] = $get_slider_images->num_rows;
		return $row_slider_images;
		
	}//end get_all_slider_images

	//Get Image Slider Record
	public function get_slider_image($image_id){
		
		$this->db->dbprefix('simple_slider_images');
		$this->db->where('id',$image_id);
		$get_slider_image = $this->db->get('simple_slider_images');

		//echo $this->db->last_query(); exit;
		$row_slider_image['slider_image_arr'] = $get_slider_image->row_array();
		$row_slider_image['slider_image_count'] = $get_slider_image->num_rows;
		return $row_slider_image;
		
	}//end get_all_slider_images
	
	//Add New Page
	public function add_new_image($data){
		
		extract($data);

		//Uploading Slider Imaage
		if($_FILES['slider_image']['name'] != ''){

			//Create User Directory if not exist
			$slider_folder_path = '../assets/slider2.images';
	
			$file_ext           = ltrim(strtolower(strrchr($_FILES['slider_image']['name'],'.')),'.'); 			
			$file_name = 	'slider-'.date('YmdGis').'.jpg';

			$config['upload_path'] = $slider_folder_path;
			$config['allowed_types'] = 'jpg|jpeg|gif|tiff|png';
			$config['max_size']	= '6000';
			$config['overwrite'] = true;
			$config['file_name'] = $file_name;
		
			$this->load->library('upload', $config);

			if(!$this->upload->do_upload('slider_image')){
				
				$error_file_arr = array('error' => $this->upload->display_errors());
				return $error_file_arr;
				
			}else{

				$data_image_upload = array('upload_image_data' => $this->upload->data());
				
				//Resize the Uploaded Image 800 * 600
				$config_profile['image_library'] = 'gd2';
				$config_profile['source_image'] = $slider_folder_path.'/'.$file_name;
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
				$config_profile['source_image'] = $slider_folder_path.'/'.$file_name;
				$config_profile['new_image'] = $slider_folder_path.'/thumb/'.$file_name;
				$config_profile['create_thumb'] = TRUE;
				$config_profile['thumb_marker'] = '';
				
				$config_profile['maintain_ratio'] = TRUE;
				$config_profile['width'] = 230;
				$config_profile['height'] = 150;
				
				$this->load->library('image_lib');
				$this->image_lib->initialize($config_profile);
				$this->image_lib->resize();
				$this->image_lib->clear();
				
			}//end if(!$this->upload->do_upload('prof_image'))


		}//end if($_FILES['slider_image']['name'] != '')
		
		$created_date = date('Y-m-d G:i:s');
		$ip_address = $this->input->ip_address();
		$created_by = $this->session->userdata('admin_id');

		$ins_data = array(
		   'slider_image' => $this->db->escape_str(trim($file_name)),
		   'slider_caption' => $this->db->escape_str(trim($slider_caption)),
		   'display_order' => $this->db->escape_str(trim($display_order)),
		   'status' => $this->db->escape_str(trim($status)),
		   'created_by' => $this->db->escape_str(trim($created_by)),
		   'created_by_ip' => $this->db->escape_str(trim($ip_address)),
		   'created_date' => $this->db->escape_str(trim($created_date)),
		);

		//Insert the record into the database.
		$this->db->dbprefix('simple_slider_images');
		$ins_into_db = $this->db->insert('simple_slider_images', $ins_data);
		//echo $this->db->last_query();
		
		if($ins_into_db) return true;

	}//end add_new_page()
	
	//Edit Page
	public function edit_image($data){
		
		extract($data);
		
		$get_image_data = $this->mod_slider->get_slider_image($image_id);
		$get_image_data_arr = $get_image_data['slider_image_arr'];
		
		$old_file_name = $get_image_data_arr['slider_image'];
		
		//Uploading Slider Imaage
		if($_FILES['slider_image']['name'] != ''){

			//Create User Directory if not exist
			$slider_folder_path = '../assets/slider2.images';
	
			$file_ext           = ltrim(strtolower(strrchr($_FILES['slider_image']['name'],'.')),'.'); 			
			$file_name = 	'slider-'.date('YmdGis').'.jpg';

			$config['upload_path'] = $slider_folder_path;
			$config['allowed_types'] = 'jpg|jpeg|gif|tiff|png';
			$config['max_size']	= '6000';
			$config['overwrite'] = true;
			$config['file_name'] = $file_name;
		
			$this->load->library('upload', $config);

			if(!$this->upload->do_upload('slider_image')){
				
				$error_file_arr = array('error' => $this->upload->display_errors());
				return $error_file_arr;
				
			}else{

				$data_image_upload = array('upload_image_data' => $this->upload->data());
				
				//Resize the Uploaded Image 800 * 600
				$config_profile['image_library'] = 'gd2';
				$config_profile['source_image'] = $slider_folder_path.'/'.$file_name;
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
				$config_profile['source_image'] = $slider_folder_path.'/'.$file_name;
				$config_profile['new_image'] = $slider_folder_path.'/thumb/'.$file_name;
				$config_profile['create_thumb'] = TRUE;
				$config_profile['thumb_marker'] = '';
				
				$config_profile['maintain_ratio'] = TRUE;
				$config_profile['width'] = 230;
				$config_profile['height'] = 150;
				
				$this->load->library('image_lib');
				$this->image_lib->initialize($config_profile);
				$this->image_lib->resize();
				$this->image_lib->clear();
				
			}//end if(!$this->upload->do_upload('prof_image'))

			//Delete Existing Image
			if(file_exists($slider_folder_path.'/'.$old_file_name)){
				
				unlink($slider_folder_path.'/'.$old_file_name);
				unlink($slider_folder_path.'/thumb/'.$old_file_name);
			}

		}else{
			$file_name = $old_file_name;	
		}//end if($_FILES['slider_image']['name'] != '')
		
		$last_modified_date = date('Y-m-d G:i:s');
		$last_modified_ip = $this->input->ip_address();
		$last_modified_by = $this->session->userdata('admin_id');

		$upd_data = array(
		   'slider_image' => $this->db->escape_str(trim($file_name)),
		   'slider_caption' => $this->db->escape_str(trim($slider_caption)),
		   'display_order' => $this->db->escape_str(trim($display_order)),
		   'status' => $this->db->escape_str(trim($status)),
		   'last_modified_by' => $this->db->escape_str(trim($last_modified_by)),
		   'last_modified_date' => $this->db->escape_str(trim($last_modified_date)),
		   'last_modified_ip' => $this->db->escape_str(trim($last_modified_ip))
		);

		//Update the record into the database.
		$this->db->dbprefix('simple_slider_images');
		$this->db->where('id',$image_id);
		$upd_into_db = $this->db->update('simple_slider_images', $upd_data);
		//echo $this->db->last_query();exit;
		
		if($upd_into_db) return true;

	}//end edit_new_page()

	//Delete Image
	public function delete_image($image_id){


		$get_image_data = $this->mod_slider->get_slider_image($image_id);
		$get_image_data_arr = $get_image_data['slider_image_arr'];
		
		//Create User Directory if not exist
		$slider_folder_path = '../assets/slider2.images';

		$old_file_name = $get_image_data_arr['slider_image'];

		//Delete Existing Image
		if(file_exists($slider_folder_path.'/'.$old_file_name)){
			
			unlink($slider_folder_path.'/'.$old_file_name);
			unlink($slider_folder_path.'/thumb/'.$old_file_name);
		}//end if
		
		//Delete the record from the database.
		$this->db->dbprefix('simple_slider_images');
		$this->db->where('id',$image_id);
		$del_into_db = $this->db->delete('simple_slider_images');
		//echo $this->db->last_query(); exit;
		
		if($del_into_db) return true;

	}//end delete_page()

}
?>