<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Manage_Attendance extends CI_Controller {
	
	public function __construct(){
		parent::__construct();

		$this->load->model('admin/mod_admin');
		$this->load->model('attendance/mod_attendance');
		$this->load->model('messages/mod_messages');
		$this->load->model('common/mod_common');
		$this->load->library('BreadcrumbComponent');
			$this->load->model('site_preferences/mod_preferences');
			
		$this->load->library('csvreader');
		
	}
	
	
	public function mark_absentees($date){
		//2015-12-10
		if(!$date){
		
		$date=date('Y-m-d');	
		}
		
	
	$attendance= $this->mod_attendance->check_absent($date);

	 
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
		// Loading Tardy Preferences
		//$tardy = $this->mod_preferences->get_preferences_setting('tardy_time');
	    //$data['tardy_time']= $tardy['setting_value'];
		
		
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
		
		$data['ALLOW_pages_add'] =   (in_array(137,$this->session->userdata('permissions_arr'))) ? 1 : 0;
	$data['ALLOW_pages_edit'] =   (in_array(208,$this->session->userdata('permissions_arr'))) ? 1 : 0;
		//Fetching Attendance
		$get_attendance = $this->mod_attendance->get_all_attendance();

		$data['attendance_arr'] = $get_attendance['attendance_arr'];
		$data['attendance_count'] = $get_attendance['attendance_count'];
		
	 $data['search_date']= ($this->input->post('search_date')) ? $this->input->post('search_date') : date('m/d/Y') ; 
		
		$this->load->view('attendance/view_attendance',$data);
		
	}//end index()
	
	// Single User Attendance View
	public function user_report($user_id=0){
	
	
	$this->mod_admin->verify_is_admin_login();
		
		//Verify if Page is Accessable
		if(!in_array(207,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if

			//Plugin Files Permission
		$data['PLUGIN_datagrid'] = 1;
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
			$this->breadcrumbcomponent->add('Manage Attendance', base_url().'attendance/manage-attendance');
		$this->breadcrumbcomponent->add('View Attendance', base_url().'attendance/manage-attendance/user-report');
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		//Loading Pregerences
		
		$tardy = $this->mod_preferences->get_preferences_setting('tardy_time');
	    $data['tardy_time']= $tardy['setting_value'];
		
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
		
			$data['ALLOW_pages_add'] =   (in_array(137,$this->session->userdata('permissions_arr'))) ? 1 : 0;

		//check which user_id to use. From get data or post data
		
		 $user_id_for_filter = $this->input->get('user_id');
		
		if(!$user_id_for_filter){
			$user_id_for_filter = $user_id;
			
		}
		
		
		//pass report_user_id
		$data['report_user_id'] = $user_id_for_filter;
		$data['search_date']= $this->input->get('search_date')? $this->input->get('search_date') : date('m/Y') ; 

	
	
		//Fetching Attendance
		$get_attendance = $this->mod_attendance->get_attendance($data['report_user_id'] , $data['search_date'] );

		$data['attendance_arr'] = $get_attendance['attendance_arr'];
		$data['attendance_count'] = $get_attendance['attendance_count'];
		
		

		
	//$data['user_name']= $this->input->post('user_name');
	
	
	
	$get_users = $this->mod_attendance->get_admin();
	
		$data['users_arr'] = $get_users['users_arr'];
		$data['users_count'] = $get_users['users_count'];
		
		
		$this->load->view('attendance/user_report',$data);
		
		}
	
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
		$this->breadcrumbcomponent->add('Manage Attendance', base_url().'attendance/manage-attendance');
		$this->breadcrumbcomponent->add('Upload Attendance', base_url().'attendance/manage-attendance/upload');
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



	public function upload_process_attendance_sheet(){
		
		
				
		//If Post is not SET
		
			
			if(trim($_FILES['file']['name']) == ''){
				
				$this->session->set_flashdata('err_message', '- Please Select File. ..!');
				redirect(base_url().'attendance/manage-attendance/upload');
				
			}//end if(trim($this->input->post('page_title')) == '')	
			
			
			//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(137,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if
		
		
		
		$tardy_time = $this->mod_preferences->get_preferences_setting('tardy_time');
		 
	  
	
	   	$data = $this->input->post();
	    $data['tardy']= $tardy_time['setting_value'];
		 	// Getting Users Start Time
		$start_time= $this->mod_attendance->get_start_time();
		$data['time_arr'] = $start_time['time_arr'];
			
		$result = $this->mod_attendance->single_upload_attendance( $data );
		
		
		if($result['error_code']==0){
		//all is well send success message	
			
			$this->session->set_flashdata('ok_message', ' Attendance Uploaded successfully.');
			redirect(base_url().'attendance/manage-attendance/upload');
			
		}else{
		//out the error	
			
				$error_message = $result['error_msg'] ;
				if($result['error_code'] == 1){
				$error_message .= '<br> ' . $result['error_detail']; 				}
			
			$this->session->set_flashdata('err_message',	$error_message );
			
			
			
				redirect(base_url().'attendance/manage-attendance/upload');
				
				
		}
		
		
	     
		 
	}
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
		// Loading Preferences
		 
		$tardy_time = $this->mod_preferences->get_preferences_setting('tardy_time');
		 
	  
	
	   	$data = $this->input->post();
	    $data['tardy']= $tardy_time['setting_value'];
		 	// Getting Users Start Time
		$start_time= $this->mod_attendance->get_start_time();
			$data['time_arr'] = $start_time['time_arr'];
			
		$upload = $this->mod_attendance->upload( $data );
		
		

		if($upload['error_code'] == 0){		
			
			
			
			
			$this->session->set_flashdata('ok_message', ' Attendance Uploaded successfully.');
			redirect(base_url().'attendance/manage-attendance/upload');
			
		}else{
			
			$error_message = $upload['error_msg'] ;
				if($result['error_code'] == 1){
				$error_message .= '<br> ' . $upload['error_detail']; 				}
			
			$this->session->set_flashdata('err_message',	$error_message );		
			redirect(base_url().'attendance/manage-attendance/upload');
			}//end if

	}//end

	// edit Attendnace
	public function edit_attendance($edit_id)
	{
		
			$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(208,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if

		//Plugin Files Permission
		$data['PLUGIN_datagrid'] = 1;
		$data['PLUGIN_datepicker'] = 1;
		$data['PLUGIN_gcal'] = 0;
		$data['PLUGIN_form_validation'] = 1;
		$data['PLUGIN_gallery'] = 0;
		$data['PLUGIN_ckeditor'] = 1;
		$data['PLUGIN_floatchart'] = 0;
		
		//Common Includes
		$data['meta_title'] = DEFAULT_TITLE;
		$data['meta_keywords'] = DEFAULT_META_KEYWORDS;
		$data['meta_description'] = DEFAULT_META_DESCRIPTION;

		$fetch_nav_panel = $this->mod_common->fetch_admin_nav_panel();
		$data['nav_panel_arr'] = $fetch_nav_panel;

		//Bread crum
		$this->breadcrumbcomponent->add('Dashboard', base_url().'dashboard/dashboard');
		$this->breadcrumbcomponent->add('Manage Attendance', base_url().'attendance/manage-attendance');
		$this->breadcrumbcomponent->add('Edit Attendance', base_url().'attendance/manage-attendance/edit-attendance'.$edit_id);
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		$data['INC_header_script_top'] = $this->load->view('common/script_header',$data,true);
		$data['INC_header_script_footer'] = $this->load->view('common/script_footer',$data,true);
		$data['INC_top_header'] = $this->load->view('common/top_header','',true);
		$data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel',$data,true);
		$data['INC_footer'] = $this->load->view('common/footer','',true);
		$data['INC_breadcrum'] = $this->load->view('common/breadcrum','',true);
		
		//Fetching Pages Results
	
		$get_attendance =$this->mod_attendance->get_attendance_by_id($edit_id);
		
				
			$data['attendance_data_arr'] =$get_attendance['attendance_arr'];
		$data['attendance_data_count'] = $get_attendance['attendance_count'];
	
	
	$get_users = $this->mod_attendance->get_admin();
	
		$data['users_arr'] = $get_users['users_arr'];
		$data['users_count'] = $get_users['users_count'];
		
		
	
	
		//if($get_attendance['attendance_count'] == 0) redirect(base_url());
		
		$this->load->view('attendance/edit_attendance',$data);
		}
		public function edit_attendance_process()
		{
			if(!$this->input->post() && !$this->input->post('upd_attendance')) redirect(base_url());
		
		$page_id = $this->input->post('page_id');
		
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(208,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if

		

		//Updating Attendance
		$upd_attendance_page = $this->mod_attendance->edit_attendance_process($this->input->post());
	
		if($upd_attendance_page){
			
			$this->session->set_flashdata('ok_message', '- Attendance updated successfully.');
			redirect(base_url().'attendance/manage-attendance');
			
		}else{
			$this->session->set_flashdata('err_message', '- Attendance is not updated. Something went wrong, please try again.');
			redirect(base_url().'attendance/manage-attendance/edit-attendance/'.$page_id);
		} // End Else
			}
	
	//Edit advertisement

	

	
	


}//end Dashboard 
