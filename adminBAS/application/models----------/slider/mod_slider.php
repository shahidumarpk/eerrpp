<?php
class mod_slider extends CI_Model {
	
	function __construct(){
		
        parent::__construct();
    }

	//Get All CMS pages.
	public function get_all_slider_images(){
		
		$this->db->dbprefix('slider_images');
		$this->db->order_by('id DESC');
		$get_slider_images = $this->db->get('slider_images');

		//echo $this->db->last_query();
		$row_slider_images['slider_images_arr'] = $get_slider_images->result_array();
		$row_slider_images['slider_images_count'] = $get_slider_images->num_rows;
		return $row_slider_images;
		
	}//end get_all_slider_images

	//Get Image Slider Record
	public function get_slider_image($image_id){
		
		$this->db->dbprefix('slider_images');
		$this->db->where('id',$image_id);
		$get_slider_image = $this->db->get('slider_images');
		
		//get layer button image
		$this->db->dbprefix('slider_layers');
		$btn = array('slider_id' => $image_id, 'is_button' => 1,);
		$this->db->where($btn);
		$get_btn_image = $this->db->get('slider_layers');
		$row_slider_image['btn_image_arr'] = $get_btn_image->row_array();

		//echo $this->db->last_query(); exit;
		$row_slider_image['slider_image_arr'] = $get_slider_image->row_array();
		$row_slider_image['slider_image_count'] = $get_slider_image->num_rows;
		return $row_slider_image;
		
	}//end get_all_slider_images
	
	public function get_slider_image_layer($image_id){
		
		$this->db->dbprefix('slider_layers');
		$this->db->where('slider_id',$image_id);
		$get_slider_image_layer = $this->db->get('slider_layers');

		//echo $this->db->last_query(); exit;
		//$row_slider_image_layer['slider_image_layer_arr'] = $get_slider_image_layer->row_array();

		$row_slider_images_layer['slider_layer_arr'] = $get_slider_image_layer->result_array();
		
		$row_slider_images_layer['slider_layer_count'] = $get_slider_image_layer->num_rows;
		return $row_slider_images_layer;
		
	}//end get_all_slider_images
	
	//Add New Page
	public function add_new_image($data){
		
		extract($data);
		
		
		//print_r($_FILES['btn_image']['name']);

		$created_date = date('Y-m-d G:i:s');
		$ip_address = $this->input->ip_address();
		$created_by = $this->session->userdata('admin_id');

		$ins_data = array(
		   'display_order' => $this->db->escape_str(trim($display_order)),
		   'status' => $this->db->escape_str(trim($status)),
		   'created_by' => $this->db->escape_str(trim($created_by)),
		   'created_by_ip' => $this->db->escape_str(trim($ip_address)),
		   'created_date' => $this->db->escape_str(trim($created_date)),
		);
		
		//Insert the record into the database.
		$this->db->dbprefix('slider_images');
		$ins_into_db = $this->db->insert('slider_images', $ins_data);
		//echo $this->db->last_query();
		
		$new_slider_id = $this->db->insert_id();

		//Uploading Slider Imaage
		if($_FILES['slider_image']['name'] != ''){

			//Create User Directory if not exist
			$slider_folder_path = '../assets/slider.images';
	
			$file_ext           = ltrim(strtolower(strrchr($_FILES['slider_image']['name'],'.')),'.'); 			
			$file_name_slider = 	$new_slider_id.'_slider.jpg';

			$config_slider_img['upload_path'] = $slider_folder_path;
			$config_slider_img['allowed_types'] = 'jpg|jpeg|gif|tiff|png';
			$config_slider_img['max_size']	= '6000';
			$config_slider_img['overwrite'] = true;
			$config_slider_img['file_name'] = $file_name_slider;
		
			$this->load->library('upload', $config_slider_img);
			$this->upload->initialize($config_slider_img);

			if(!$this->upload->do_upload('slider_image')){
				
				$error_file_arr = array('error' => $this->upload->display_errors());
				return $error_file_arr;
				
			}else{

				$data_image_upload = array('upload_image_data' => $this->upload->data());
				
				//Resize the Uploaded Image 800 * 600
				$config_front_img['image_library'] = 'gd2';
				$config_front_img['source_image'] = $slider_folder_path.'/'.$file_name_slider;
				$config_front_img['create_thumb'] = TRUE;
				$config_front_img['thumb_marker'] = '';
				
				$config_front_img['maintain_ratio'] = TRUE;
				$config_front_img['width'] = 800;
				$config_front_img['height'] = 600;
				
				$this->load->library('image_lib');
				$this->image_lib->initialize($config_front_img);
				$this->image_lib->resize();
				$this->image_lib->clear();

				//Creating Thumbmail 230 * 150
				//Uploading is successful now resizing the uploaded image 
				$config_230x150['image_library'] = 'gd2';
				$config_230x150['source_image'] = $slider_folder_path.'/'.$file_name_slider;
				$config_230x150['new_image'] = $slider_folder_path.'/thumb/'.$file_name_slider;
				$config_230x150['create_thumb'] = TRUE;
				$config_230x150['thumb_marker'] = '';
				
				$config_230x150['maintain_ratio'] = TRUE;
				$config_230x150['width'] = 230;
				$config_230x150['height'] = 150;
				
				$this->load->library('image_lib');
				$this->image_lib->initialize($config_230x150);
				$this->image_lib->resize();
				$this->image_lib->clear();
				
			}//end if(!$this->upload->do_upload('prof_image'))


		}//end if($_FILES['slider_image']['name'] != '')

		if($_FILES['slider_background']['name'] != ''){

			//Create User Directory if not exist
			$slider_folder_path = '../assets/slider.images';
	
			$file_ext           = ltrim(strtolower(strrchr($_FILES['slider_background']['name'],'.')),'.'); 			
			$file_name_background = 	$new_slider_id.'_background.jpg';

			$config_background['upload_path'] = $slider_folder_path;
			$config_background['allowed_types'] = 'jpg|jpeg|gif|tiff|png';
			$config_background['max_size']	= '6000';
			$config_background['overwrite'] = true;
		   $config_background['file_name'] = $file_name_background;
		
			$this->load->library('upload', $config_background);
			$this->upload->initialize($config_background);

			if(!$this->upload->do_upload('slider_background')){
				
				$error_file_arr = array('error' => $this->upload->display_errors());
				return $error_file_arr;
				
			}else{

				$upload_bck_image_data = array('upload_bck_image_data' => $this->upload->data());
				
				
				
				
				//Resize the Uploaded Image 800 * 600
				$config_profile['image_library'] = 'gd2';
				$config_profile['source_image'] = $slider_folder_path.'/'.$file_name_background;
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
				$config_profile['source_image'] = $slider_folder_path.'/'.$file_name_background;
				$config_profile['new_image'] = $slider_folder_path.'/thumb/'.$file_name_background;
				$config_profile['create_thumb'] = TRUE;
				$config_profile['thumb_marker'] = '';
				
				$config_profile['maintain_ratio'] = TRUE;
				$config_profile['width'] = 230;
				$config_profile['height'] = 150;
				
				$this->load->library('image_lib');
				$this->image_lib->initialize($config_profile);
				$this->image_lib->resize();
				$this->image_lib->clear();
				
			}//end if(!$this->upload->do_upload('slider_background'))
			
			

		}//end if($_FILES['slider_background']['name'] != '')
		
		$upd_data = array(
		   'slider_image' => $file_name_slider,
		   'slider_background' => $file_name_background
		   
		);
        $this->db->dbprefix('admin');
		$this->db->where('id',$new_slider_id);
		$upd_into_db = $this->db->update('slider_images', $upd_data);
		

		
		for($item=0; $item<count($slider_text); $item++)
		{ 
		
		$ins_layer_data = array(
		   'slider_id' => $this->db->escape_str(trim($new_slider_id)),
		   'layer_text' => $this->db->escape_str(trim(nl2br($slider_text[$item]))),
		   'class_name' => $this->db->escape_str(trim($class_name[$item])),
		   'x_direction' =>$this->db->escape_str(trim($x_direction[$item])),
		   'y_direction' => $this->db->escape_str(trim($y_direction[$item])),
		   'status' => $this->db->escape_str(trim($status[$item])),
		   'created_by' =>$this->db->escape_str(trim($created_by)),
		   'created_by_date' =>$this->db->escape_str(trim($created_date)),
		   'created_by_ip' =>$this->db->escape_str(trim($ip_address)),
		   'modified_by' => $this->db->escape_str(trim($last_modified_by)),
		   'modified_date' => $this->db->escape_str(trim($last_modified_date)),
		   'modified_ip' => $this->db->escape_str(trim($last_modified_ip))
		  
		);
		
		$this->db->dbprefix('slider_layers');
	    $this->db->insert('slider_layers', $ins_layer_data);
		
		}
		
		
		//Button image uoloading
		if($_FILES['btn_image']['name'] != ''){

			//Create User Directory if not exist
			$slider_folder_path = '../assets/slider.images';
	
			$file_ext           = ltrim(strtolower(strrchr($_FILES['btn_image']['name'],'.')),'.'); 			
			$file_name_btn = 	$new_slider_id.'_btn.jpg';

			$config_btn['upload_path'] = $slider_folder_path;
			$config_btn['allowed_types'] = 'jpg|jpeg|gif|tiff|png';
			$config_btn['max_size']	= '6000';
			$config_btn['overwrite'] = true;
		   $config_btn['file_name'] = $file_name_btn;
		
			$this->load->library('upload', $config_btn);
			$this->upload->initialize($config_btn);

			if(!$this->upload->do_upload('btn_image')){
				
				$error_file_arr = array('error' => $this->upload->display_errors());
				return $error_file_arr;
				
			}else{

				$upload_bck_image_data = array('upload_bck_image_data' => $this->upload->data());
				
			}//end if(!$this->upload->do_upload('btn_image'))
			
	      //insert button in database
		  $ins_btn_data = array(
		   'slider_id' => $this->db->escape_str(trim($new_slider_id)),
		   'class_name' => $this->db->escape_str(trim($btn_class_name)),
		   'x_direction' => $this->db->escape_str(trim($x_direction_btn)),
		   'y_direction' =>$this->db->escape_str(trim( $y_direction_btn)),
		   'is_button' => 1,
		   'btn_image' => $this->db->escape_str(trim($file_name_btn)),
		   'btn_link' => $this->db->escape_str(trim($btn_link)),
		   'status' => $this->db->escape_str(trim($btn_status)),
		   'created_by' =>$this->db->escape_str(trim($created_by)),
		   'created_by_date' =>$this->db->escape_str(trim($created_date)),
		   'created_by_ip' =>$this->db->escape_str(trim($ip_address)),
		   'modified_by' => $this->db->escape_str(trim($last_modified_by)),
		   'modified_date' => $this->db->escape_str(trim($last_modified_date)),
		   'modified_ip' => $this->db->escape_str(trim($last_modified_ip))
		  
		);
		
		$this->db->dbprefix('slider_layers');
	    $this->db->insert('slider_layers', $ins_btn_data);

		}//end if($_FILES['btn_image']['name'] != '')
		
		if($ins_into_db && $upd_into_db) return true;
		
	}//end 
	
	//Edit image
	public function edit_image($data){
		
		extract($data);
		
		$get_image_data = $this->mod_slider->get_slider_image($image_id);
		$get_image_data_arr = $get_image_data['slider_image_arr'];
		
	   $old_file_name = $get_image_data_arr['slider_image'];
	
		
		//Uploading Slider Imaage
		if($_FILES['slider_image']['name'] != ''){
			
			//Create User Directory if not exist
			$slider_folder_path = '../assets/slider.images';
	
			$file_ext           = ltrim(strtolower(strrchr($_FILES['slider_image']['name'],'.')),'.'); 			
			$file_name_slider = 	$image_id.'_slider.jpg';
           
			$config_slider_img['upload_path'] = $slider_folder_path;
			$config_slider_img['allowed_types'] = 'jpg|jpeg|gif|tiff|png';
			$config_slider_img['max_size']	= '6000';
			$config_slider_img['overwrite'] = true;
			$config_slider_img['file_name'] = $file_name_slider;
		
			$this->load->library('upload', $config_slider_img);
			$this->upload->initialize($config_slider_img);

			if(!$this->upload->do_upload('slider_image')){
				
				$error_file_arr = array('error' => $this->upload->display_errors());
				return $error_file_arr;
				
			}else{

				$data_image_upload = array('upload_image_data' => $this->upload->data());
				
				//Resize the Uploaded Image 800 * 600
				$config_front_img['image_library'] = 'gd2';
				$config_front_img['source_image'] = $slider_folder_path.'/'.$file_name_slider;
				$config_front_img['create_thumb'] = TRUE;
				$config_front_img['thumb_marker'] = '';
				
				$config_front_img['maintain_ratio'] = TRUE;
				$config_front_img['width'] = 800;
				$config_front_img['height'] = 600;
				
				$this->load->library('image_lib');
				$this->image_lib->initialize($config_front_img);
				$this->image_lib->resize();
				$this->image_lib->clear();

				//Creating Thumbmail 230 * 150
				//Uploading is successful now resizing the uploaded image 
				$config_230x150['image_library'] = 'gd2';
				$config_230x150['source_image'] = $slider_folder_path.'/'.$file_name_slider;
				$config_230x150['new_image'] = $slider_folder_path.'/thumb/'.$file_name_slider;
				$config_230x150['create_thumb'] = TRUE;
				$config_230x150['thumb_marker'] = '';
				
				$config_230x150['maintain_ratio'] = TRUE;
				$config_230x150['width'] = 230;
				$config_230x150['height'] = 150;
				
				$this->load->library('image_lib');
				$this->image_lib->initialize($config_230x150);
				$this->image_lib->resize();
				$this->image_lib->clear();
				
			}//end if(!$this->upload->do_upload('slider_image'))
         

		}
		
		else{
			
			 $file_name_slider = $old_file_name;
		    
		
		}//end if($_FILES['slider_image']['name'] != '')
		
		
		//Uploading Slider Background
		if($_FILES['slider_background']['name'] != ''){

			//Create User Directory if not exist
		
			$slider_folder_path = '../assets/slider.images';
	
			$file_ext           = ltrim(strtolower(strrchr($_FILES['slider_background']['name'],'.')),'.'); 			
		    $file_name_background = 	$image_id.'_background.jpg';

			$config_background['upload_path'] = $slider_folder_path;
			$config_background['allowed_types'] = 'jpg|jpeg|gif|tiff|png';
			$config_background['max_size']	= '6000';
			$config_background['overwrite'] = true;
		   $config_background['file_name'] = $file_name_background;
		
			$this->load->library('upload', $config_background);
			$this->upload->initialize($config_background);

			if(!$this->upload->do_upload('slider_background')){
				
				$error_file_arr = array('error' => $this->upload->display_errors());
				return $error_file_arr;
				
			}else{

				$upload_bck_image_data = array('upload_bck_image_data' => $this->upload->data());
			
				//Resize the Uploaded Image 800 * 600
				$config_profile['image_library'] = 'gd2';
				$config_profile['source_image'] = $slider_folder_path.'/'.$file_name_background;
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
				$config_profile['source_image'] = $slider_folder_path.'/'.$file_name_background;
				$config_profile['new_image'] = $slider_folder_path.'/thumb/'.$file_name_background;
				$config_profile['create_thumb'] = TRUE;
				$config_profile['thumb_marker'] = '';
				
				$config_profile['maintain_ratio'] = TRUE;
				$config_profile['width'] = 230;
				$config_profile['height'] = 150;
				
				$this->load->library('image_lib');
				$this->image_lib->initialize($config_profile);
				$this->image_lib->resize();
				$this->image_lib->clear();
				
			}//end if(!$this->upload->do_upload('slider_background'))
		
		}
		
		else{
			$file_name_background = $old_file_name;	
		}//end if($_FILES['slider_background']['name'] != '')
		
		$last_modified_date = date('Y-m-d G:i:s');
		$last_modified_ip = $this->input->ip_address();
		$last_modified_by = $this->session->userdata('admin_id');

		$upd_data = array(
		   'display_order' => $this->db->escape_str(trim($display_order)),
		   'status' => $this->db->escape_str(trim($status)),
		   'last_modified_by' => $this->db->escape_str(trim($last_modified_by)),
		   'last_modified_date' => $this->db->escape_str(trim($last_modified_date)),
		   'last_modified_ip' => $this->db->escape_str(trim($last_modified_ip))
		);

		//Update the record into the database.
		$this->db->dbprefix('slider_images');
		$this->db->where('id',$image_id);
		$upd_into_db = $this->db->update('slider_images', $upd_data);
		//echo $this->db->last_query();exit;
		
		//Delete Existing  layer data
		$array = array('slider_id' => $image_id, 'is_button' => 0,);
		$this->db->dbprefix('slider_layers');
		$this->db->where($array);
		$del_into_db = $this->db->delete('slider_layers');
		
		//update layer data
		for($item=0; $item<count($slider_text); $item++)
		{ 
		
		$update_layer_data = array(
		   'slider_id' => $image_id,
		   'layer_text' => $this->db->escape_str(trim(nl2br($slider_text[$item]))),
		   'class_name' => $this->db->escape_str(trim($class_name[$item])),
		   'x_direction' =>$this->db->escape_str(trim($x_direction[$item])),
		   'y_direction' => $this->db->escape_str(trim($y_direction[$item])),
		   'status' => $this->db->escape_str(trim($layer_status[$item])),
		   'modified_by' => $this->db->escape_str(trim($last_modified_by)),
		   'modified_date' => $this->db->escape_str(trim($last_modified_date)),
		   'modified_ip' => $this->db->escape_str(trim($last_modified_ip))
		  
		);
		
		$this->db->dbprefix('slider_layers');
	    $this->db->insert('slider_layers', $update_layer_data);
		
		}
		
		//Update Button Layer Image
		if($_FILES['btn_image']['name'] != ''){
			
			//Create User Directory if not exist
			$slider_folder_path = '../assets/slider.images';
	
			$file_ext           = ltrim(strtolower(strrchr($_FILES['btn_image']['name'],'.')),'.'); 			
			$file_name_btn = 	$image_id.'_btn.jpg';
		

			$config_btn['upload_path'] = $slider_folder_path;
			$config_btn['allowed_types'] = 'jpg|jpeg|gif|tiff|png';
			$config_btn['max_size']	= '6000';
			$config_btn['overwrite'] = true;
		    $config_btn['file_name'] = $file_name_btn;
		
			$this->load->library('upload', $config_btn);
			$this->upload->initialize($config_btn);

			if(!$this->upload->do_upload('btn_image')){
				
				$error_file_arr = array('error' => $this->upload->display_errors());
				return $error_file_arr;
				
			}else{

				$upload_bck_image_data = array('upload_bck_image_data' => $this->upload->data());
				
			}//end if(!$this->upload->do_upload('Button_image'))
			
			$insert_btn_data = array(
		   'slider_id' => $this->db->escape_str(trim($image_id)),
		   'class_name' => $this->db->escape_str(trim($btn_class_name)),
		   'x_direction' =>$this->db->escape_str(trim($x_direction_btn)),
		   'y_direction' =>$this->db->escape_str(trim($y_direction_btn)),
		   'is_button' => 1,
		   'btn_image' => $this->db->escape_str(trim($file_name_btn)),
		   'btn_link' => $this->db->escape_str(trim($btn_link)),
		   'status' => $this->db->escape_str(trim($btn_status)),
		   'modified_by' => $this->db->escape_str(trim($last_modified_by)),
		   'modified_date' => $this->db->escape_str(trim($last_modified_date)),
		   'modified_ip' => $this->db->escape_str(trim($last_modified_ip))
		  
		);
		
		//delete existing button image
		$array = array('slider_id' => $image_id, 'is_button' => 1,);
		$this->db->dbprefix('slider_layers');
		$this->db->where($array);
		$del_into_db = $this->db->delete('slider_layers');
		
		//insert new button image
		$this->db->dbprefix('slider_layers');
	    $this->db->insert('slider_layers', $insert_btn_data);
		}
		
		if($upd_into_db) return true;

	}//end edit_image()

	//Delete Image
	public function delete_image($image_id){


		$get_image_data = $this->mod_slider->get_slider_image($image_id);
		$get_image_data_arr = $get_image_data['slider_image_arr'];
		
		$get_btn_data_arr = $get_image_data['btn_image_arr'];
		
		
		//Create User Directory if not exist
		$slider_folder_path = '../assets/slider.images';

		$old_slider_name = $get_image_data_arr['slider_image'];
		$old_background_name = $get_image_data_arr['slider_background'];
		
		$btn_image=$get_btn_data_arr['btn_image'];
		

		//Delete Existing Image
		if(file_exists($slider_folder_path.'/'.$old_slider_name)){
			
			unlink($slider_folder_path.'/'.$old_slider_name);
			unlink($slider_folder_path.'/thumb/'.$old_slider_name);
		}//end if
		
		if(file_exists($slider_folder_path.'/'.$old_background_name)){
			
			unlink($slider_folder_path.'/'.$old_background_name);
			unlink($slider_folder_path.'/thumb/'.$old_background_name);
		}//end if
		if(file_exists($slider_folder_path.'/'.$btn_image)){
			
			unlink($slider_folder_path.'/'.$btn_image);
			
		}//end if
		
		//Delete the record from the database.
		$this->db->dbprefix('slider_images');
		$this->db->where('id',$image_id);
		$del_into_db = $this->db->delete('slider_images');
		
		//delete slider layer
		$this->db->where('slider_id',$image_id);
		$del_into_db = $this->db->delete('slider_layers');
		
		//echo $this->db->last_query(); exit;
		
		
		
		if($del_into_db) return true;

	}//end delete_page()
	
	
	
	public function delete_slider_layer($id){
		
		//Delete the record from the database.
		$this->db->dbprefix('slider_layers');
		$this->db->where('id',$id);
		$del_into_db = $this->db->delete('slider_layers');
		//echo $this->db->last_query(); exit;
		
		if($del_into_db) return true;

	}//end delete_slider_layer()
	
	public function delete_layer_button($id){
		
		//Delete the record from the database.
		$this->db->dbprefix('slider_layers');
		$this->db->where('id',$id);
		$del_into_db = $this->db->delete('slider_layers');
		//echo $this->db->last_query(); exit;
		
		if($del_into_db) return true;

	}//end delete_layer_button()

}
?>