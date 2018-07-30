<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Manage_Roles extends CI_Controller {

	public function __construct(){
		parent::__construct();

		$this->load->model('admin/mod_admin');
		$this->load->model('admin_roles/mod_admin_roles');
		$this->load->model('common/mod_common');
		
		$this->load->library('BreadcrumbComponent');
		
	}

	public function index(){
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(15,$this->session->userdata('permissions_arr'))){
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
		$this->breadcrumbcomponent->add('Manage Admin Roles', base_url().'admin/manage-roles');
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

		//Permissions
		$data['ALLOW_roles_edit'] =   (in_array(17,$this->session->userdata('permissions_arr'))) ? 1 : 0;
		$data['ALLOW_pages_add'] =   (in_array(16,$this->session->userdata('permissions_arr'))) ? 1 : 0;
		
		
		//Fetching Pages Results
		$get_all_admin_roles = $this->mod_admin_roles->get_all_admin_roles();

		$data['admin_roles_arr'] = $get_all_admin_roles['admin_roles_result'];
		$data['admin_roles_count'] = $get_all_admin_roles['admin_roles_result_count'];
		
		
		$this->load->view('admin/manage_roles',$data);
		
	}//end index()
	
	//Add New Role
	public function add_new_role(){

		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(16,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if
		
		//Plugin Files Permission
		$data['PLUGIN_datagrid'] = 0;
		$data['PLUGIN_datepicker'] = 0;
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
		$this->breadcrumbcomponent->add('Add New Role', base_url().'admin/manage-roles/add-new-role');
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
		
		//All Restricted Menues of Admin Panel
		$permission_arr = $this->mod_common->get_admin_menu_list();
		$data['permission_arr'] = $permission_arr;
		
		$this->load->view('admin/add_new_role',$data);
	
	}//add_new_role

	public function add_new_role_process(){
		
		
		//If Post is not SET
		if(!$this->input->post() && !$this->input->post('add_admin_role_sbt')) redirect(base_url());
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(16,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if
		

		$data_arr['add-new-role-data'] = $this->input->post();
		$this->session->set_userdata($data_arr);

		if(trim($this->input->post('role_title')) == ''){
			
			$this->session->set_flashdata('err_message', '- Role Title is missing.');
			redirect(base_url().'cms/manage-roles/add-new-role');
			
		}//end if(trim($this->input->post('page_title')) == '')

		//Adding New Role
		$add_new_role = $this->mod_admin_roles->add_new_role($this->input->post());
		
		if($add_new_role){
			
			//Unset POST values from session
			$this->session->unset_userdata('add-new-role-data');
			
			$this->session->set_flashdata('ok_message', '- New Role added successfully.');
			redirect(base_url().'admin/manage-roles');
			
		}else{
			$this->session->set_flashdata('err_message', '- New Role is not added. Something went wrong, please try again.');
			redirect(base_url().'admin/manage-roles/add-new-role');
			
		}//end if($add_cms_page)

	}//end add_new_role_process

	//Edit Role
	public function edit_role($role_id){
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(17,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if
		
		//Plugin Files Permission
		$data['PLUGIN_datagrid'] = 0;
		$data['PLUGIN_datepicker'] = 0;
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
		$this->breadcrumbcomponent->add('Manage Roles', base_url().'admin/manage-roles');
		$this->breadcrumbcomponent->add('Edit Role', base_url().'admin/manage-roles/edit-role/'.$role_id);
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

		//All Restricted Menues of Admin Panel
		$permission_arr = $this->mod_common->get_admin_menu_list();
		$data['permission_arr'] = $permission_arr;
		
		//Fetching Admin Role Data
		$get_admin_role = $this->mod_admin_roles->get_admin_role($role_id);
		$get_admin_role['admin_role_arr']['user_permissions_arr'] = explode(';',$get_admin_role['admin_role_arr']['permissions']);
		
		$get_admin_role['admin_role_arr']['user_permissions_mobile_arr'] = explode(';',$get_admin_role['admin_role_arr']['permissions_mobile']);
		
		$data['admin_role_arr'] = $get_admin_role['admin_role_arr'];
		$data['admin_role_count'] = $get_admin_role['admin_role_count'];
		
		if($get_admin_role['admin_role_count'] == 0) redirect(base_url());
		
		$this->load->view('admin/edit_role',$data);
		
	}//edit_role

	public function edit_role_process(){
		
		//If Post is not SET
		if(!$this->input->post() && !$this->input->post('upd_admin_role_sbt')) redirect(base_url());
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(17,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if
		
		$role_id = $this->input->post('role_id');

		if(trim($this->input->post('role_title')) == ''){
			
			$this->session->set_flashdata('err_message', '- Role Title is missing.');
			redirect(base_url().'admin/manage-roles/edit-role/'.$role_id);
			
		}//end if(trim($this->input->post('role_title')) == '')

		//Updating Admin Role
		$upd_admin_role = $this->mod_admin_roles->edit_role($this->input->post());
		
		if($upd_admin_role){
			
			$this->session->set_flashdata('ok_message', '- Admin Roles updated successfully.');
			redirect(base_url().'admin/manage-roles/edit-role/'.$role_id);
			
		}else{
			$this->session->set_flashdata('err_message', '- Admin Roles is not updated. Something went wrong, please try again.');
			redirect(base_url().'admin/manage-roles/edit-role/'.$role_id);
			
		}//end if($add_cms_page)

	}//end edit_role_process
	
}//end Dashboard 
