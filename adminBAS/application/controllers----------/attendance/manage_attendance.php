<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Manage_Attendance extends CI_Controller {
	
	public function __construct(){
		parent::__construct();

		$this->load->model('admin/mod_admin');
		$this->load->model('attendance/mod_attendance');
		$this->load->model('common/mod_common');
		$this->load->library('BreadcrumbComponent');
		$this->load->library('csvreader');
		
	}

	public function index(){
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();
		
		//Verify if Page is Accessable
		if(!in_array(136,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if

		//Plugin Files Permission
		$data['PLUGIN_datagrid'] = 1;
		$data['PLUGIN_datepicker'] = 0;
		$data['PLUGIN_gcal'] = 0;
		$data['PLUGIN_form_validation'] = 0;
		$data['PLUGIN_gallery'] = 0;
		$data['PLUGIN_ckeditor'] = 0;
		$data['PLUGIN_floatchart'] = 0;

		//Common Includes
		$data['meta_title'] = DEFAULT_TITLE;
		$data['meta_keywords'] = DEFAULT_META_KEYWORDS;
		$data['meta_description'] = DEFAULT_META_DESCRIPTION;

		$fetch_nav_panel = $this->mod_common->fetch_admin_nav_panel();
		$data['nav_panel_arr'] = $fetch_nav_panel;

		//Bread crum
		$this->breadcrumbcomponent->add('Dashboard', base_url().'dashboard/dashboard');
		$this->breadcrumbcomponent->add('Manage Attendance', base_url().'advertisemnts/manage-advertisements');
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		///////////////////////// Top Notifications  /////////////////////
		//Get Assign Task Notificaitons
		$assign_tasks_notifiations= $this->mod_common->get_assign_task_notifiations();
		$data['assign_task_notifiations_arr'] = $assign_tasks_notifiations['assign_task_filter'];
		$data['assign_task_notifiations_count'] = $assign_tasks_notifiations['assign_task_count'];
		
		//Get Inbox Unread Messsaes Notifications
		$inbox_unread_messages = $this->mod_common->get_inbox_unread_messages();
		$data['messages_arr'] = $inbox_unread_messages['messages_result'];
		$data['messages_count'] = $inbox_unread_messages['messages_count'];
		
		//Get Inbox Notifications
		$inbox_notifications_messages = $this->mod_common->get_inbox_notifications();
		$data['inbox_notifications_arr'] = $inbox_notifications_messages['inbox_notifications_result'];
		$data['inbox_notifications_count'] = $inbox_notifications_messages['inbox_notifications_count'];
	    ///////////////////// End Top Notifications///////////////////////
		
		$data['INC_autoload_messages'] = $this->load->view('common/autoload_messages',$data,true);
		$data['INC_header_script_top'] = $this->load->view('common/script_header',$data,true);
		$data['INC_header_script_footer'] = $this->load->view('common/script_footer',$data,true);
		$data['INC_top_header'] = $this->load->view('common/top_header','',true);
		$data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel',$data,true);
		$data['INC_footer'] = $this->load->view('common/footer','',true);
		$data['INC_breadcrum'] = $this->load->view('common/breadcrum',$data,true);
		 
		//Permissions
		$data['ALLOW_pages_edit'] =   (in_array(81,$this->session->userdata('permissions_arr'))) ? 1 : 0;
		$data['ALLOW_pages_delete'] =   (in_array(82,$this->session->userdata('permissions_arr'))) ? 1 : 0;
		$data['ALLOW_pages_add'] =   (in_array(79,$this->session->userdata('permissions_arr'))) ? 1 : 0;

		//Fetching Attendance
		$get_attendance = $this->mod_attendance->get_all_attendance();

		$data['attendance_arr'] = $get_attendance['attendance_arr'];
		$data['attendance_count'] = $get_attendance['attendance_count'];
		
		$this->load->view('attendance/view_attendance',$data);
		
	}//end index()
	
	//Upload Attendance
	public function upload(){
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();
		
		//Verify if Page is Accessable
		if(!in_array(137,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if
		
		//Plugin Files Permission
		$data['PLUGIN_datagrid'] = 0;
		$data['PLUGIN_datepicker'] = 1;
		$data['PLUGIN_gcal'] = 0;
		$data['PLUGIN_form_validation'] = 1;
		$data['PLUGIN_gallery'] = 0;
		$data['PLUGIN_ckeditor'] = 0;
		$data['PLUGIN_floatchart'] = 0;
		
		//Common Includes
		$data['meta_title'] = DEFAULT_TITLE;
		$data['meta_keywords'] = DEFAULT_META_KEYWORDS;
		$data['meta_description'] = DEFAULT_META_DESCRIPTION;
		
		$fetch_nav_panel = $this->mod_common->fetch_admin_nav_panel();
		$data['nav_panel_arr'] = $fetch_nav_panel;
		
		//Bread crum
		$this->breadcrumbcomponent->add('Dashboard', base_url().'dashboard/dashboard');
		$this->breadcrumbcomponent->add('Upload Attendance', base_url().'advertisements/manage-advertisements');
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		///////////////////////// Top Notifications  /////////////////////
		//Get Assign Task Notificaitons
		$assign_tasks_notifiations= $this->mod_common->get_assign_task_notifiations();
		$data['assign_task_notifiations_arr'] = $assign_tasks_notifiations['assign_task_filter'];
		$data['assign_task_notifiations_count'] = $assign_tasks_notifiations['assign_task_count'];
		
		//Get Inbox Unread Messsaes Notifications
		$inbox_unread_messages = $this->mod_common->get_inbox_unread_messages();
		$data['messages_arr'] = $inbox_unread_messages['messages_result'];
		$data['messages_count'] = $inbox_unread_messages['messages_count'];
		
		//Get Inbox Notifications
		$inbox_notifications_messages = $this->mod_common->get_inbox_notifications();
		$data['inbox_notifications_arr'] = $inbox_notifications_messages['inbox_notifications_result'];
		$data['inbox_notifications_count'] = $inbox_notifications_messages['inbox_notifications_count'];
	    ///////////////////// End Top Notifications///////////////////////

		$data['INC_autoload_messages'] = $this->load->view('common/autoload_messages',$data,true);
		$data['INC_header_script_top'] = $this->load->view('common/script_header',$data,true);
		$data['INC_header_script_footer'] = $this->load->view('common/script_footer',$data,true);
		$data['INC_top_header'] = $this->load->view('common/top_header','',true);
		$data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel',$data,true);
		$data['INC_footer'] = $this->load->view('common/footer','',true);
		$data['INC_breadcrum'] = $this->load->view('common/breadcrum','',true);
		
		
		$users_arr = $this->mod_attendance->get_all_users();
		$data['users_arr'] = $users_arr['admin_list_result'];
		$data['users_count'] = $users_arr['admin_list_result_count'];
		
		/*echo "<pre>";
		print_r($data['users_count'] );
		exit;
		*/
		$this->load->view('attendance/upload',$data);
		
	}//Upload Attendance

	public function upload_process(){
		
		
		//If Post is not SET
		if($this->input->post('upload')) {
			
			if(trim($_FILES['file']['name']) == ''){
				
				$this->session->set_flashdata('err_message', '- Please Select File. ..!');
				redirect(base_url().'attendance/manage-attendance/upload');
				
			}//end if(trim($this->input->post('page_title')) == '')	
			
			
	     }
		
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(137,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if
		
		
		$upload = $this->mod_attendance->upload($this->input->post());

		if($upload && $upload['error'] == ''){		
			
			//Unset POST values from session
			$this->session->unset_userdata('add-image-data');
			
			$this->session->set_flashdata('ok_message', '- Attendance Uploaded successfully.');
			redirect(base_url().'attendance/manage-attendance/upload');
			
		}else{
			
			if($upload['error'] != ''){
				
				
				$this->session->set_flashdata('err_message','- Sorrry File Can not be upload.');
				redirect(base_url().'attendance/manage-attendance/upload');
				
			}else{
				$this->session->set_flashdata('err_message', '-Attendance is not uploaded. Something went wrong, please try again.');
				redirect(base_url().'attendance/manage-attendance/upload');
				
			}//end if
			
		}//end if

	}//end

	
	
	//Edit advertisement
	public function edit_advertisement($add_id){

		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(44,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if

		//Plugin Files Permission
		$data['PLUGIN_datagrid'] = 0;
		$data['PLUGIN_datepicker'] = 0;
		$data['PLUGIN_gcal'] = 0;
		$data['PLUGIN_form_validation'] = 1;
		$data['PLUGIN_gallery'] = 1;
		$data['PLUGIN_ckeditor'] = 0;
		$data['PLUGIN_floatchart'] = 0;
		
		//Common Includes
		$data['meta_title'] = DEFAULT_TITLE;
		$data['meta_keywords'] = DEFAULT_META_KEYWORDS;
		$data['meta_description'] = DEFAULT_META_DESCRIPTION;

		$fetch_nav_panel = $this->mod_common->fetch_admin_nav_panel();
		$data['nav_panel_arr'] = $fetch_nav_panel;

		//Bread crum
		$this->breadcrumbcomponent->add('Dashboard', base_url().'dashboard/dashboard');
		$this->breadcrumbcomponent->add('Manage Advertisements', base_url().'advertisements/manage-advertisements');
		$this->breadcrumbcomponent->add('Edit Advertisements', base_url().'advertisemnts/manage-advertisements/edit-advertisement/'.$add_id);
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		///////////////////////// Top Notifications  /////////////////////
		//Get Assign Task Notificaitons
		$assign_tasks_notifiations= $this->mod_common->get_assign_task_notifiations();
		$data['assign_task_notifiations_arr'] = $assign_tasks_notifiations['assign_task_filter'];
		$data['assign_task_notifiations_count'] = $assign_tasks_notifiations['assign_task_count'];
		
		//Get Inbox Unread Messsaes Notifications
		$inbox_unread_messages = $this->mod_common->get_inbox_unread_messages();
		$data['messages_arr'] = $inbox_unread_messages['messages_result'];
		$data['messages_count'] = $inbox_unread_messages['messages_count'];
		
		//Get Inbox Notifications
		$inbox_notifications_messages = $this->mod_common->get_inbox_notifications();
		$data['inbox_notifications_arr'] = $inbox_notifications_messages['inbox_notifications_result'];
		$data['inbox_notifications_count'] = $inbox_notifications_messages['inbox_notifications_count'];
	    ///////////////////// End Top Notifications///////////////////////
		
		$data['INC_autoload_messages'] = $this->load->view('common/autoload_messages',$data,true);
		$data['INC_header_script_top'] = $this->load->view('common/script_header',$data,true);
		$data['INC_header_script_footer'] = $this->load->view('common/script_footer',$data,true);
		$data['INC_top_header'] = $this->load->view('common/top_header','',true);
		$data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel',$data,true);
		$data['INC_footer'] = $this->load->view('common/footer','',true);
		$data['INC_breadcrum'] = $this->load->view('common/breadcrum','',true);
		
		//Fetching Image slider Results
		$get_row_advertisement = $this->mod_advertisements->get_advertisement($add_id);
		$data['advertisement_data'] = $get_row_advertisement['advertisement_arr'];
		$data['advertisement_count'] = $get_row_advertisement['advertisement_count'];
		
		if($get_row_advertisement['advertisement_count'] == 0) redirect(base_url());
		
		$this->load->view('advertisements/edit_advertisement',$data);
		
	}//edit_advertisement
	

	public function edit_advertisement_process(){
		
		//If Post is not SET
		if(!$this->input->post() && !$this->input->post('edit_advertisement')) redirect(base_url());
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(44,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if

		//Updating record
		$upd_advertisement = $this->mod_advertisements->edit_advertisement($this->input->post());
		
		if($upd_advertisement && $upd_advertisement['error'] == ''){	
			
			$this->session->set_flashdata('ok_message', '- Advertisement updated successfully.');
			redirect(base_url().'advertisements/manage-advertisements/');
			
		}else{

			if($upd_advertisement['error'] != ''){

				$this->session->set_flashdata('err_message', '- '.strip_tags($upd_slider_image['error']));
				redirect(base_url().'advertisements/manage-advertisements/');
				
			}else{
				
				$this->session->set_flashdata('err_message', '- Advertisement is not updated. Something went wrong, please try again.');
				redirect(base_url().'advertisements/manage-advertisements/');

			}//end if
			
		}//end if

	}//end edit_advertisement_process
	
	public function delete_advertisement($add_id){
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(45,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if
		
		//If Post is not SET
		if(!isset($add_id)) redirect(base_url());
		
	
		$del_add = $this->mod_advertisements->delete_advertisement($add_id);
		
		if($del_add){
			
			$this->session->set_flashdata('ok_message', '- Advertisement deleted successfully.');
			redirect(base_url().'advertisements/manage-advertisements/');
			
		}else{
			$this->session->set_flashdata('err_message', '- Advertisement cannot be deleted. Something went wrong, please try again.');
			redirect(base_url().'advertisements/manage-advertisements/');
			
		}//end if

	}//end delete_advertisement

}//end Dashboard 
