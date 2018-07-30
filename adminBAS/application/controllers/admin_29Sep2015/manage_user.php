<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Manage_User extends CI_Controller {

	public function __construct(){
		parent::__construct();

		$this->load->model('admin/mod_admin');
		$this->load->model('common/mod_common');
	
		
		$this->load->model('branches/mod_branches');
		$this->load->model('admin_roles/mod_admin_roles');
		$this->load->model('customers/mod_customer');
		$this->load->library('BreadcrumbComponent');
		
	}

	public function index(){
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(7,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if
		
		
		//Plugin Files Permission
		$data['PLUGIN_datagrid'] = 1;
		$data['PLUGIN_datepicker'] = 0;
		$data['PLUGIN_gcal'] = 0;
		$data['PLUGIN_form_validation'] = 0;
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
		$this->breadcrumbcomponent->add('Manage User', base_url().'cms/manage-user');
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		///////////////////////// Top Notifications  /////////////////////
		$inbox_unread_messages = $this->mod_common->get_inbox_messages();
		$data['unread_messages_count'] = $inbox_unread_messages['messages_count'];
		
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
		$data['ALLOW_user_edit'] =   (in_array(9,$this->session->userdata('permissions_arr'))) ? 1 : 0;
		$data['ALLOW_user_delete'] =   (in_array(10,$this->session->userdata('permissions_arr'))) ? 1 : 0;
		$data['ALLOW_pages_add'] =   (in_array(8,$this->session->userdata('permissions_arr'))) ? 1 : 0;
		$data['ALLOW_user_view_attendance'] =   (in_array(207,$this->session->userdata('permissions_arr'))) ? 1 : 0;
		
		$get_admin_user = $this->mod_admin->get_admin_users_limit();
		$data['admin_user_list'] = $get_admin_user['admin_list_result'];
		$data['admin_user_list_count'] = $get_admin_user['admin_list_result_count'];
		
		//GET Admin Roles
		$get_admin_roles = $this->mod_admin_roles->get_all_admin_roles();
		$data['admin_roles_result'] = $get_admin_roles['admin_roles_result'];
		$data['admin_roles_result_count'] = $get_admin_roles['admin_roles_result_count'];
		
		//GET Branches
		$get_branches= $this->mod_branches->get_all_branches();
		$data['branches_arr'] = $get_branches['branches_arr'];
		$data['branches_count'] = $get_branches['branches_count'];
		
		$data['branch_id']= $this->input->post('branch_id');
		$data['role_id']= $this->input->post('role_id');
		$data['status']= $this->input->post('search_status');
		
	 
		$this->load->view('admin/manage_user',$data);
			
	}//end index()
	
	//Add New User
	public function add_new_user(){
		
		$this->load->model('admin_roles/mod_admin_roles');
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(8,$this->session->userdata('permissions_arr'))){
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
		$this->breadcrumbcomponent->add('Manage User', base_url().'admin/manage-user');
		$this->breadcrumbcomponent->add('Add New User', base_url().'admin/manage-user/add-new-user');
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
		
		//Get All Branches
		$get_all_branches = $this->mod_admin->get_all_branches();
		$data['branches_arr'] = $get_all_branches['branches_arr'];
		$data['branches_count'] = $get_all_branches['branches_count'];
		
		
		//Admin User Roles List
		$get_all_admin_roles = $this->mod_admin_roles->get_all_admin_roles();

		$data['admin_roles_arr'] = $get_all_admin_roles['admin_roles_result'];
		$data['admin_roles_count'] = $get_all_admin_roles['admin_roles_result_count'];
		
		//Country List List
		$get_all_country_list = $this->mod_admin->get_all_countries();

		$data['countries_result_arr'] = $get_all_country_list['countries_result'];
		$data['countries_result_count'] = $get_all_country_list['countries_count'];
		
		$this->load->view('admin/add_new_user',$data);
		
	}//add_new_user
	
	
	//Ajax Response States against Countries
	public function get_states_list($country_id){
		
	
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		
		//State List List
		$get_all_states_list = $this->mod_admin->get_all_states($country_id);

		$data['states_result_arr'] = $get_all_states_list['states_result'];
		$data['states_result_count'] = $get_all_states_list['states_count'];
		
		$data['cities_result_arr'] = $get_all_states_list['cities_result'];
		$data['cities_result_count'] = $get_all_states_list['cities_count'];
		
		if($country_id != '0'){
		
		if($data['states_result_count'] >0){ // If State found in database .
		$response_select .= '<select  style="width:100%;"  id="state_name" name="state_name"  required><option value="0">Select State</option>' ;	
			
			for($p=0; $p < $data['states_result_count']; $p++){
				
				$response_select .= "<option value=".$data['states_result_arr'][$p]['state_name'].">".$data['states_result_arr'][$p]['state_name']."</option>" ;		
			}
		$response_select .= '</select>' ;		
		}else{
			
			$response_select .= ' <input id="state_name" name="state_name" type="text" class="form-control" placeholder="Enter State/Province Name "/>' ;	
			
		}
		}else{
			
			$response_select .="<br />Please Select Country";
			
		}
		$response_select .= '|';
		
		
		if($country_id!='0'){
		if($data['cities_result_count'] >0){ // If Cities found in database .
		$response_select .= '<select style="width:100%;"  id="city_name" name="city_name"  required><option value="0">Select City</option>' ;	
			
			for($i=0; $i < $data['cities_result_count']; $i++){
				
				$response_select .= "<option value=".$data['cities_result_arr'][$i]['name'].">".$data['cities_result_arr'][$i]['name']."</option>" ;		
			}
		$response_select .= '</select>' ;		
		}else{
			
			$response_select .= ' <input id="city_name" name="city_name" type="text" class="form-control" placeholder="Enter State/Province Name "/>' ;	
			
			
		}
		}else{
			
			$response_select .="<br />Please Select Country";
		}
		
		echo $response_select ; 
		exit;
	}//get_states_list

	public function add_new_user_process(){
		
		$this->load->helper(array('email', 'url'));

		//If Post is not SET
		if(!$this->input->post() && !$this->input->post('add_new_user_sbt')) redirect(base_url());
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(8,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if
		
		$err_msg = '';

		if(trim($this->input->post('first_name')) == ''){
			
			$err_msg.= '- First Name cannot be empty.<br>';
			
		}//end if(trim($this->input->post('page_title')) == '')

		if(trim($this->input->post('last_name')) == ''){
			
			$err_msg.= '- Last Name cannot be empty.<br>';
			
		}//end if(trim($this->input->post('page_title')) == '')
		
		if(trim($this->input->post('display_name')) == ''){
			
			$err_msg.= '- Display Name cannot be empty.<br>';
			
		}//end if(trim($this->input->post('page_title')) == '')

		if(trim($this->input->post('username')) == ''){
			
			$err_msg.= '- Username cannot be empty.<br>';
			
		}//end if(trim($this->input->post('username')) == '')

		if(trim($this->input->post('email_address')) != '' && !(valid_email($this->input->post('email_address')))){
			
			$err_msg.= '- Please enter valid Email Address<br>';
			
		}//end if(trim($this->input->post('email_address')) == '')

		if($_FILES['prof_image']['name'] != ''){
			
			$allowed_extesntions = array('jpg','jpeg','tiff','png','gif');
			$file_ext           = ltrim(strtolower(strrchr($_FILES['prof_image']['name'],'.')),'.'); 
			
			if(!in_array($file_ext,$allowed_extesntions)){
				$err_msg.= '- Invalid image for your profile (Use: jpg, jpeg, gif, tiff, png)<br>';	
			}//end if
			
		}//end if($_FILES['prof_image']['name'] != '')
		
		if($err_msg !=''){

			$this->session->set_flashdata('err_message', $err_msg);
			redirect(base_url().'admin/manage-user/add-new-user');
			
		}//end if($err_msg !='')

		$is_username_exist = $this->mod_admin->check_if_username_exist($this->input->post('username'));
		
		if($is_username_exist){
			//Username already exist

			$data_arr['add-user-data'] = $this->input->post();
			$this->session->set_userdata($data_arr);
			
			$this->session->set_flashdata('err_message', '- Username already exist. Please try another one.');
			redirect(base_url().'admin/manage-user/add-new-user');
			
		}else{
			
			//Add New User	
			$add_new_user = $this->mod_admin->add_new_user($this->input->post());
			
			if($add_new_user && $add_new_user['error'] == ''){
				
				//Unset POST values from session
				$this->session->unset_userdata('add-user-data');
				
				$this->session->set_flashdata('ok_message', '- New User added successfully.');
				redirect(base_url().'admin/manage-user');
				
			}else{
				
				if($add_new_user['error'] != ''){
					$this->session->set_flashdata('err_message', '- '.strip_tags($add_new_user['error']));
					redirect(base_url().'admin/manage-user/add-new-user/'.$admin_id);
					
				}else{
					$this->session->set_flashdata('err_message', '- New User cannot be added. Something went wrong, please try again.');
					redirect(base_url().'admin/manage-user/add-new-user');
					
				}//end if($add_new_user['error'] != '')
				
			}//end if($upd_admin_profile)

		}//end if($is_username_exist)

	}//end add_new_user_process

	//edit User
	public function edit_user($admin_id){
		
		$this->load->model('admin_roles/mod_admin_roles');
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(9,$this->session->userdata('permissions_arr'))){
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
		$this->breadcrumbcomponent->add('Manage User', base_url().'admin/manage-user');
		$this->breadcrumbcomponent->add('Edit User', base_url().'admin/manage-user/edit-user/'.$admin_id);
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
		
		//Admin User data
		$admin_user_data = $this->mod_admin->get_admin_user_data($admin_id);
		$data['admin_user_data'] = $admin_user_data['admin_user_arr'];
		$data['admin_user_count'] = $admin_user_data['admin_user_count'];
		
		//Admin User Roles List
		$get_all_admin_roles = $this->mod_admin_roles->get_all_admin_roles();

		$data['admin_roles_arr'] = $get_all_admin_roles['admin_roles_result'];
		$data['admin_roles_count'] = $get_all_admin_roles['admin_roles_result_count'];
		
		//Country List List
		$get_all_country_list = $this->mod_admin->get_all_countries();

		$data['countries_result_arr'] = $get_all_country_list['countries_result'];
		$data['countries_result_count'] = $get_all_country_list['countries_count'];
		
		$get_user_data = $this->mod_admin->get_admin_profile($admin_id);
		$county_name= $get_user_data['admin_profile_arr']['country_name'];
		
		
		$get_states_list = $this->mod_admin->get_states($county_name);
		$data['states_result_arr'] = $get_states_list['states_result'];
		$data['states_result_count'] = $get_states_list['states_count'];
		
		
		$get_cities_list = $this->mod_admin->get_cities($county_name);
		$data['cities_result_arr'] = $get_cities_list['cities_result'];
		$data['cities_result_count'] = $get_cities_list['cities_count'];
		
		//Get All Branches
		$get_all_branches = $this->mod_admin->get_all_branches();
		$data['branches_arr'] = $get_all_branches['branches_arr'];
		$data['branches_count'] = $get_all_branches['branches_count'];
		
		if($admin_user_data['admin_user_count'] == 0) redirect(base_url());
		
		$this->load->view('admin/edit_user',$data);
		
	}//edit_user

	public function edit_user_process(){
		
		$this->load->helper('email');

		//If Post is not SET
		if(!$this->input->post() && !$this->input->post('upd_user_sbt')) redirect(base_url());
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(9,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if
		
		
		$admin_id = $this->input->post('admin_id');

		$err_msg = '';
		if(trim($this->input->post('first_name')) == ''){
			
			$err_msg.= '- First Name cannot be empty.<br>';
			
		}//end if(trim($this->input->post('page_title')) == '')

		if(trim($this->input->post('last_name')) == ''){
			
			$err_msg.= '- Last Name cannot be empty.<br>';
			
		}//end if(trim($this->input->post('page_title')) == '')

		if(trim($this->input->post('display_name')) == ''){
			
			$err_msg.= '- Display Name cannot be empty.<br>';
			
		}//end if(trim($this->input->post('page_title')) == '')

		if(trim($this->input->post('username')) == ''){
			
			$err_msg.= '- Username cannot be empty.<br>';
			
		}//end if(trim($this->input->post('username')) == '')

		if(trim($this->input->post('email_address')) != '' && !(valid_email($this->input->post('email_address')))){
			
			$err_msg.= '- Please enter valid Email Address<br>';
			
		}//end if(trim($this->input->post('email_address')) == '')
		
		if($_FILES['prof_image']['name'] != ''){
			
			$allowed_extesntions = array('jpg','jpeg','tiff','png','gif');
			$file_ext           = ltrim(strtolower(strrchr($_FILES['prof_image']['name'],'.')),'.'); 
			
			if(!in_array($file_ext,$allowed_extesntions)){
				$err_msg.= '- Invalid image for your profile (Use: jpg, jpeg, gif, tiff, png)<br>';	
			}//end if
			
		}//end if($_FILES['prof_image']['name'] != '')
		
		
		if($err_msg !=''){

			$this->session->set_flashdata('err_message', $err_msg);
			redirect(base_url().'admin/manage-user/edit-user/'.$admin_id);
			
		}//end if($err_msg !='')

		//Updating Admin Data
		$upd_admin = $this->mod_admin->edit_user($this->input->post());
		
		if($upd_admin && $upd_admin['error'] == ''){
			
			$this->session->set_flashdata('ok_message', '- User record updated successfully.');
			redirect(base_url().'admin/manage-user/edit-user/'.$admin_id);
			
		}else{

			if($upd_admin['error'] != ''){
				
				$this->session->set_flashdata('err_message', '- '.strip_tags($upd_admin['error']));
				redirect(base_url().'admin/manage-user/edit-user/'.$admin_id);
				
			}else{
				$this->session->set_flashdata('err_message', '- User record cannot be updated. Something went wrong, please try again.');
				redirect(base_url().'admin/manage-user/edit-user/'.$admin_id);
				
			}//end if($upd_admin['error'] != '')
			
		}//end if($add_cms_page)

	}//end edit_user_process
	
	//Delete Admin User
	public function delete_user($admin_id){
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(10,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if

		//If Post is not SET
		if(!isset($admin_id)) redirect(base_url());
		
		//Updating Page
		$del_admin_user = $this->mod_admin->delete_user($admin_id);
		
		if($del_admin_user){
			
			$this->session->set_flashdata('ok_message', '- User deleted successfully.');
			redirect(base_url().'admin/manage-user');
			
		}else{
			$this->session->set_flashdata('err_message', '- User cannot be deleted. Something went wrong, please try again.');
			redirect(base_url().'admin/manage-user');
			
		}//end if($del_admin_user)

	}//end delete_user


	//Edit Profile
	public function edit_profile(){
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(12,$this->session->userdata('permissions_arr'))){
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
		$this->breadcrumbcomponent->add('Edit Profile', base_url().'admin/manage-user/edit-profile');
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
		
		$admin_profile_arr = $this->mod_admin->get_admin_profile($this->session->userdata('admin_id'));
		$data['admin_profile_data'] = $admin_profile_arr['admin_profile_arr'];
		$data['admin_profile_count'] = $admin_profile_arr['admin_profile_count'];
		
		if($admin_profile_arr['admin_profile_count'] == 0) redirect(base_url());
		

		$this->load->view('admin/edit_profile',$data);
		
	}//edit_profile

	public function edit_profile_process(){
		
		$this->load->helper('email');

		//If Post is not SET
		if(!$this->input->post() && !$this->input->post('upd_profile_sbt')) redirect(base_url());
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(12,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if
		

		$err_msg = '';
		if(trim($this->input->post('display_name')) == ''){
			
			$err_msg.= '- Display Name cannot be empty.<br>';
			
		}//end if(trim($this->input->post('page_title')) == '')

		if(trim($this->input->post('username')) == ''){
			
			$err_msg.= '- Username cannot be empty.<br>';
			
		}//end if(trim($this->input->post('username')) == '')

		if(trim($this->input->post('email_address')) != '' && !(valid_email($this->input->post('email_address')))){
			
			$err_msg.= '- Please enter valid Email Address<br>';
			
		}//end if(trim($this->input->post('email_address')) == '')
		
		if($_FILES['avatar_image']['name'] != ''){
			
			$allowed_extesntions = array('jpg','jpeg','tiff','png','gif');
			$file_ext           = ltrim(strtolower(strrchr($_FILES['avatar_image']['name'],'.')),'.'); 
			
			if(!in_array($file_ext,$allowed_extesntions)){
				$err_msg.= '- Invalid image for your profile (Use: jpg, jpeg, gif, tiff, png)<br>';	
			}//end if
			
		}//end if($_FILES['prof_image']['name'] != '')

		if($err_msg !=''){

			$this->session->set_flashdata('err_message', $err_msg);
			redirect(base_url().'admin/manage-user/edit-profile');
			
		}//end if($err_msg !='')

		//Updating Admin Profile
		$upd_admin_profile = $this->mod_admin->update_admin_profile($this->input->post(),$this->session->userdata('admin_id'));
		
		if($upd_admin_profile && $upd_admin_profile['error'] == ''){
			
			$this->session->set_flashdata('ok_message', '- Profile updated successfully.');
			redirect(base_url().'admin/manage-user/edit-profile');
			
		}else{

			if($upd_admin_profile['error'] != ''){
				
				$this->session->set_flashdata('err_message', '- File cannot be uploaded due to file size exceeded.');
				redirect(base_url().'admin/manage-user/edit-profile');
				
			}else{
				
				$this->session->set_flashdata('err_message', '- Profile cannot be updated. Something went wrong, please try again.');
				redirect(base_url().'admin/manage-user/edit-profile');

			}//end if($upd_admin_profile['error'] != '')
			
		}//end if($add_cms_page)

	}//end add_page_process

	//Change Admin Password
	public function edit_password(){
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(13,$this->session->userdata('permissions_arr'))){
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
		$this->breadcrumbcomponent->add('Change Password', base_url().'adminadmin/manage-user/edit-password');
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
		
		$this->load->view('admin/edit_password',$data);
		
	}//edit_password

	public function edit_password_process(){
		
		$this->load->helper('email');

		//If Post is not SET
		if(!$this->input->post() && !$this->input->post('upd_profile_sbt')) redirect(base_url());
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(13,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if

		$err_msg = '';

		if(trim($this->input->post('new_password')) == ''){
			
			$err_msg.= '- New Password cannot be empty.<br>';
			
		}//end if(trim($this->input->post('page_title')) == '')

		if(strlen(trim($this->input->post('new_password'))) < 6 ){
			
			$err_msg.= '- New Password must be atleast 6 characters long.<br>';
			
		}//end if(trim($this->input->post('page_title')) == '')
		

		if(trim($this->input->post('confirm_password')) != trim($this->input->post('new_password'))){
			
			$err_msg.= '- Confirm Password must match with your New Password.<br>';
			
		}//end if(trim($this->input->post('username')) == '')

		if($err_msg !=''){

			$this->session->set_flashdata('err_message', $err_msg);
			redirect(base_url().'admin/manage-user/edit-password');
			
		}//end if($err_msg !='')

		//Updating Admin Password
		$upd_admin_password = $this->mod_admin->update_admin_password($this->input->post(),$this->session->userdata('admin_id'));
		
		if($upd_admin_password){
			
			$this->session->set_flashdata('ok_message', '- Your Password updated successfully.');
			redirect(base_url().'admin/manage-user/edit-password');
			
		}else{
			$this->session->set_flashdata('err_message', '- Password Profile cannot be updated. Something went wrong, please try again.');
			redirect(base_url().'admin/manage-user/edit-password');
			
		}//end if($add_cms_page)

	}//end edit_password_process
	
	
	
	public function add_site_preferences(){
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(12,$this->session->userdata('permissions_arr'))){
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
		$this->breadcrumbcomponent->add('Add Site Preferences', base_url().'admin/manage-user/edit-profile');
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
		
		$this->load->view('admin/add_site_preferences',$data);
		
	}//Add Site preferences end
	
	public function add_site_preferences_process(){
		
		//If Post is not SET
		if(!$this->input->post() && !$this->input->post('add_site_preference_sbt')) redirect(base_url());
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(12,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if
		

		$err_msg = '';
		if(trim($this->input->post('name')) == ''){
			
			$err_msg.= '- Site Preference Name cannot be empty.<br>';
			
		}//end if(trim($this->input->post('name')) == '')
		
		
		$err_msg = '';
		if(trim($this->input->post('value')) == ''){
			
			$err_msg.= '- Site Preference Value cannot be empty.<br>';
			
		}//end if(trim($this->input->post('value')) == '')
		
		if($err_msg !=''){

			$this->session->set_flashdata('err_message', $err_msg);
			redirect(base_url().'admin/manage-user/add_site_preferences');
			
		}//end if($err_msg !='')
      

		//Add Site preference 
		$add_site_preferences = $this->mod_admin->add_site_preferences($this->input->post());
		
		if($add_site_preferences && $add_site_preferences['error'] == ''){
			
			$this->session->set_flashdata('ok_message', '- Added Site Preferences successfully.');
			redirect(base_url().'admin/manage-user/add_site_preferences');
			
		}else{

			if($add_site_preferences['error'] != ''){
				
				$this->session->set_flashdata('err_message', '- '.strip_tags($upd_admin['error']));
				redirect(base_url().'admin/manage-user/add_site_preferences');
				
			}else{
				
				$this->session->set_flashdata('err_message', '- Site Preferences cannot be Added. Something went wrong, please try again.');
				redirect(base_url().'admin/manage-user/add_site_preferences');

			}//end if
			
		}//end if

	}//end Add Site preferences process
	
	public function manage_site_preferences(){
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(12,$this->session->userdata('permissions_arr'))){
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
		
		//Permissions
		$data['ALLOW_user_edit'] =   (in_array(9,$this->session->userdata('permissions_arr'))) ? 1 : 0;
		$data['ALLOW_user_delete'] =   (in_array(10,$this->session->userdata('permissions_arr'))) ? 1 : 0;
		$data['ALLOW_pages_add'] =   (in_array(50,$this->session->userdata('permissions_arr'))) ? 1 : 0;
		

		//Bread crum
		$this->breadcrumbcomponent->add('Dashboard', base_url().'dashboard/dashboard');
		$this->breadcrumbcomponent->add('Edit Profile', base_url().'admin/manage-user/edit-profile');
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
		
		$site_preferences_arr = $this->mod_admin->get_site_preferences();
		$data['site_preferences_arr'] = $site_preferences_arr['site_preferences_result'];
		$data['site_preferences_count'] = $site_preferences_arr['site_preferences_count'];
		
        
		$this->load->view('admin/manage_site_preferences',$data);
		
	}//End Manage Site preferences
	
	
	public function edit_site_preferences($id){
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(12,$this->session->userdata('permissions_arr'))){
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
		$this->breadcrumbcomponent->add('Edit Site Preferences', base_url().'admin/manage-user/edit-profile');
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
		
		$edit_site_preferences_arr = $this->mod_admin->edit_site_preferences($id);
		$data['edit_site_preferences_data'] = $edit_site_preferences_arr;
		
		/*print_r($edit_site_preferences_arr);
		exit;*/
	
		$this->load->view('admin/edit_site_preferences',$data);
		
	}//edit_Site Preferences
	
	
	public function edit_site_preferences_process($id){
		
		//If Post is not SET
		if(!$this->input->post() && !$this->input->post('edit_site_preference_sbt')) redirect(base_url());
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(12,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if
		
	    $err_msg = '';
		if(trim($this->input->post('name')) == ''){
			
			$err_msg.= '- Site Preferences Name cannot be empty.<br>';
			
		}//end if
		
		if(trim($this->input->post('value')) == ''){
			
			$err_msg.= '- Site Preferences Value cannot be empty.<br>';
			
		}//end if
		if($err_msg !=''){

			$this->session->set_flashdata('err_message', $err_msg);
			redirect(base_url().'admin/manage-user/edit_site_preferences');
			
		}//end if($err_msg !='')

		//Updating copy right text
		$upd_site_preferences = $this->mod_admin->update_site_preferences_process($this->input->post(),$id);
		
		if($upd_site_preferences && $upd_site_preferences['error'] == ''){
			
			$this->session->set_flashdata('ok_message', '- Site Preferences  updated successfully.');
			redirect(base_url().'admin/manage-user/manage_site_preferences');
			
		}else{

			if($upd_site_preferences['error'] != ''){
				
				$this->session->set_flashdata('err_message', '- '.strip_tags($upd_admin['error']));
				redirect(base_url().'admin/manage-user/manage_site_preferences');
				
			}else{
				
				$this->session->set_flashdata('err_message', '-  Site Preferences cannot be updated. Something went wrong, please try again.');
				redirect(base_url().'admin/manage-user/manage_site_preferences');

			}//end if($upd_admin_profile['error'] != '')
			
		}//end if($add_cms_page)

	}//end edit site_preferences_process
	
	
	public function delete_site_preferences($id){
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(10,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if

	
		$del_site_preferences= $this->mod_admin->delete_site_preferences($id);
		
		if($del_site_preferences){
			
			$this->session->set_flashdata('ok_message', '- Site Preferences deleted successfully.');
			redirect(base_url().'admin/manage-user/manage_site_preferences');
			
		}else{
			$this->session->set_flashdata('err_message', '- Site Preferences cannot be deleted. Something went wrong, please try again.');
			redirect(base_url().'admin/manage-user/manage_site_preferences');
			
		}//end if($del_admin_user)

	}//end delete_site_preferences
	
	
	public function employee_list(){
		
		$this->load->model('admin_roles/mod_admin_roles');
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(122,$this->session->userdata('permissions_arr'))){
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
		$this->breadcrumbcomponent->add('Employees List', base_url().'admin/manage-user/employess-list/');
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
		
		
		//GET All Employess
		$get_all_employees = $this->mod_admin->get_all_employees();

		$data['employees_arr'] = $get_all_employees['admin_list_result'];
		$data['employees_count'] = $get_all_employees['admin_list_result_count'];
		
		/*print_r($data['employees_count']);
		exit;*/
		
		$this->load->view('admin/employee_list',$data);
		
	}//employee list
	
		
	public function activate_user_report($user_id){
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(122,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if

	
		$activate_user_report= $this->mod_admin->activate_user_report($user_id);
		
		if($activate_user_report){
			
			$this->session->set_flashdata('ok_message', '-User Activated successfully.');
			redirect(base_url().'admin/manage-user/employee-list');
			
		}else{
			$this->session->set_flashdata('err_message', '- User cannot be Activated. Something went wrong, please try again.');
			redirect(base_url().'admin/manage-user/employee-list');
			
		}//end if($del_admin_user)

	}//end activate_user_report
	
	public function deactivate_user_report($user_id){
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(122,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if

	
		$deactivate_user_report= $this->mod_admin->deactivate_user_report($user_id);
		
		if($deactivate_user_report){
			
			$this->session->set_flashdata('ok_message', '-User DeActivated successfully.');
			redirect(base_url().'admin/manage-user/employee-list');
			
		}else{
			$this->session->set_flashdata('err_message', '- User cannot be DeActivated. Something went wrong, please try again.');
			redirect(base_url().'admin/manage-user/employee-list');
			
		}//end if($del_admin_user)

	}//end deactivate_user_report
	
	
	public function daily_active_employee_list(){
		
		$this->load->model('admin_roles/mod_admin_roles');
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(123,$this->session->userdata('permissions_arr'))){
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
		$this->breadcrumbcomponent->add('Daily Active Employees List', base_url().'admin/manage-user/empoyees-list/');
		
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
		
		
		//GET All Employess
		$get_all_employees = $this->mod_admin->get_daily_active_employees();

		$data['employees_arr'] = $get_all_employees['admin_list_result'];
		$data['employees_count'] = $get_all_employees['admin_list_result_count'];
		
		/*print_r($data['employees_arr']);
		exit;*/
		
		$this->load->view('admin/daily_active_employee_list',$data);
		
	}//End daily_active_employee_list
	
	
	public function add_report(){
		
		$this->load->model('admin_roles/mod_admin_roles');
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(124,$this->session->userdata('permissions_arr'))){
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
		$this->breadcrumbcomponent->add('Daily Active Employees List', base_url().'admin/manage-user/empoyees-list/');
		
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
		
		
		//GET All Employess
		$get_emp_report = $this->mod_admin->get_daily_emp_report();

		$data['report_arr'] = $get_emp_report['report_arr'];
		$data['report_arr'] = $get_emp_report['report_arr'];
		
		/*echo "<pre>";
		print_r($data['report_arr']);
		exit;*/
		
		$this->load->view('admin/add_report',$data);
		
	}//End add_record
	
	
	public function add_report_process(){
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(124,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if

		//Updating Report
		$upd_report = $this->mod_admin->update_report($this->input->post());
		
		if($upd_report){
			
			$this->session->set_flashdata('ok_message', '- Report updated successfully.');
			redirect(base_url().'admin/manage-user/add-report');
			
		}else{
			$this->session->set_flashdata('err_message', '- Report cannot be updated. Something went wrong, please try again.');
			redirect(base_url().'admin/manage-user/add-report');
			
		}//end if($add_cms_page)

	}//end add_report_process
	
	
	public function view_report($user_id){
		
		$this->load->model('admin_roles/mod_admin_roles');
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(124,$this->session->userdata('permissions_arr'))){
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
		$this->breadcrumbcomponent->add('Daily Active Employees List', base_url().'admin/manage-user/empoyees-list/');
		
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
		
		
		//GET All Employess
		$get_emp_report = $this->mod_admin->get_emp_report($user_id);

		$data['report_arr'] = $get_emp_report['report_arr'];
		$data['report_count'] = $get_emp_report['report_count'];
		$data['user_id']=$user_id;
		
		$data['date']=$this->input->post('date');
		
		
		/*echo "<pre>";
		print_r($data['report_arr']);
		exit;*/
		
		$this->load->view('admin/view_report',$data);
		
	}//End view_report
	
	//user_detail
	public function user_detail($admin_id,$status=""){
		
		$this->load->model('admin_roles/mod_admin_roles');
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(9,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if
		
		//Plugin Files Permission
		$data['PLUGIN_datagrid'] = 1;
		$data['PLUGIN_datepicker'] = 0;
		$data['PLUGIN_gcal'] = 0;
		$data['PLUGIN_form_validation'] = 0;
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
		$this->breadcrumbcomponent->add('Manage User', base_url().'admin/manage-user');
		$this->breadcrumbcomponent->add('User details', base_url().'admin/manage-user/edit-user/'.$admin_id);
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
		$data['ALLOW_employment_detail'] = (in_array(162,$this->session->userdata('permissions_arr'))) ? 1 : 0;
		
		
		
		//Admin User data
		$admin_user_data = $this->mod_admin->get_admin_user_data($admin_id);
		$data['admin_user_data'] = $admin_user_data['admin_user_arr'];
		$data['admin_user_count'] = $admin_user_data['admin_user_count'];
		/*echo "<pre>";
		print_r($data['admin_user_data']);
		exit;*/
		
		//Admin User Roles List
		$get_all_projects = $this->mod_admin->get_all_projects($admin_id,$status);

		$data['projects_arr'] = $get_all_projects['projects_filter'];
		$data['projects_count'] = $get_all_projects['projects_count'];
		
		$task_details = $this->mod_admin->get_project_tasks($admin_id);
		$data['total_tasks'] = $task_details['total_tasks'];
		$data['open_tasks'] = $task_details['open_tasks'];
		$data['hold_tasks'] = $task_details['hold_tasks'];
		$data['closed_tasks'] = $task_details['closed_tasks'];
		
		
		$start_task_time_report = $this->mod_admin->get_start_time_report($admin_id);
		$data['ontime_start'] = $start_task_time_report['ontime_start'];
		$data['after_time_start'] = $start_task_time_report['after_time_start'];
		
		
		$closed_task_time_report = $this->mod_admin->get_closed_time_report($admin_id);
		$data['ontime_closed'] = $closed_task_time_report['ontime_closed'];
		$data['after_time_closed'] = $closed_task_time_report['after_time_closed'];
		
		
		$project_details = $this->mod_admin->get_user_projects_count($admin_id);
		$data['total_projects'] = $project_details['total_projects'];
		$data['open_projects'] = $project_details['open_projects'];
		$data['cancel_projects'] = $project_details['cancel_projects'];
		$data['closed_projects'] = $project_details['closed_projects'];
		
		$average_rating = $this->mod_admin->get_average_rating($admin_id);
		$data['average_rating'] = $average_rating['average_rating'];
		
		
		$data['user_id']= $admin_id;
		
		
		$this->load->view('admin/user_detail',$data);
		
	}//user_detail
	
	
	//employee_detail
	public function employee_detail($admin_id){
		
		$this->load->model('admin_roles/mod_admin_roles');
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(163,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if
		
		//Plugin Files Permission
		$data['PLUGIN_datagrid'] = 1;
		$data['PLUGIN_datepicker'] = 0;
		$data['PLUGIN_gcal'] = 0;
		$data['PLUGIN_form_validation'] = 0;
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
		$this->breadcrumbcomponent->add('Employee List', base_url().'admin/manage-user/employee-list');
		$this->breadcrumbcomponent->add('User details', base_url().'admin/manage-user/edit-user/'.$admin_id);
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
		$data['ALLOW_employment_detail'] = (in_array(162,$this->session->userdata('permissions_arr'))) ? 1 : 0;
		
		
		//Admin User data
		$admin_user_data = $this->mod_admin->get_admin_user_data($admin_id);
		$data['admin_user_data'] = $admin_user_data['admin_user_arr'];
		$data['admin_user_count'] = $admin_user_data['admin_user_count'];
		/*echo "<pre>";
		print_r($data['admin_user_data']);
		exit;*/
		
		//Admin User Roles List
		$get_all_projects = $this->mod_admin->get_all_projects($admin_id,$status);

		$data['projects_arr'] = $get_all_projects['projects_filter'];
		$data['projects_count'] = $get_all_projects['projects_count'];
		
		$task_details = $this->mod_admin->get_project_tasks($admin_id);
		$data['total_tasks'] = $task_details['total_tasks'];
		$data['open_tasks'] = $task_details['open_tasks'];
		$data['hold_tasks'] = $task_details['hold_tasks'];
		$data['closed_tasks'] = $task_details['closed_tasks'];
		
		
		$start_task_time_report = $this->mod_admin->get_start_time_report($admin_id);
		$data['ontime_start'] = $start_task_time_report['ontime_start'];
		$data['after_time_start'] = $start_task_time_report['after_time_start'];
		
		
		$closed_task_time_report = $this->mod_admin->get_closed_time_report($admin_id);
		$data['ontime_closed'] = $closed_task_time_report['ontime_closed'];
		$data['after_time_closed'] = $closed_task_time_report['after_time_closed'];
		
		
		$project_details = $this->mod_admin->get_user_projects_count($admin_id);
		$data['total_projects'] = $project_details['total_projects'];
		$data['open_projects'] = $project_details['open_projects'];
		$data['cancel_projects'] = $project_details['cancel_projects'];
		$data['closed_projects'] = $project_details['closed_projects'];
		
		$average_rating = $this->mod_admin->get_average_rating($admin_id);
		$data['average_rating'] = $average_rating['average_rating'];
		
		
		$data['user_id']= $admin_id;
		
		
		$this->load->view('admin/employee_detail',$data);
		
	}//employee_detail
	
	
	public function send_message(){
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		/*//Verify if Page is Accessable
		if(!in_array(124,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if*/

		//Updating Report
		$send_message = $this->mod_admin->send_message($this->input->post());
		
		if($send_message){
			
			$this->session->set_flashdata('ok_message', '- Mesage send successfully.');
			redirect(base_url().'admin/manage-user');
			
		}else{
			$this->session->set_flashdata('err_message', '- Message cannot be updated. Something went wrong, please try again.');
			redirect(base_url().'admin/manage-user');
			
		}//end if($add_cms_page)

	}//end add_report_process
	
	
	//Upload Users Docs
	public function upload_docs($admin_id){
		
	//Login Check
	$this->mod_admin->verify_is_admin_login();

	
		//Verify if Page is Accessable
		if(!in_array(9,$this->session->userdata('permissions_arr'))){
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
		$this->breadcrumbcomponent->add('Upload User Docs', base_url().'customers/manage-customers/upload-docs/'.$customer_id);
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
		
		//Admin User data
		$admin_user_data = $this->mod_admin->get_admin_user_data($admin_id);
		$data['admin_user_data'] = $admin_user_data['admin_user_arr'];
		$data['admin_user_count'] = $admin_user_data['admin_user_count'];
		
		$this->load->view('admin/upload_docs',$data);
		
	}//Upload Docs
	
	
	public function upload_docs_process(){
		
		//If Post is not SET
		if(!$this->input->post() && !$this->input->post('upd_user_docs_sbt')) redirect(base_url());
		
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		
		//Verify if Page is Accessable
		if(!in_array(9,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if
		
		
		$user_id = $this->input->post('user_id');

		if($_FILES['prof_image']['name'] != ''){
			
			$allowed_extesntions = array('jpg','jpeg','tiff','png','gif');
			$file_ext           = ltrim(strtolower(strrchr($_FILES['prof_image']['name'],'.')),'.'); 
			
			if(!in_array($file_ext,$allowed_extesntions)){
				$err_msg.= '- Invalid image for your profile (Use: jpg, jpeg, gif, tiff, png)<br>';	
			}//end if
			
		}//end if($_FILES['prof_image']['name'] != '')
		
		
		if($err_msg !=''){

			$this->session->set_flashdata('err_message', $err_msg);
			redirect(base_url().'admin/manage-user/upload-docs/'.$user_id);
			
		}//end if($err_msg !='')

		//Updating User Data
		$upd_user = $this->mod_admin->upload_docs($this->input->post());
		
		if($upd_user && $upd_user['error'] == ''){
			
			$this->session->set_flashdata('ok_message', '- User Docs uploaded successfully.');
			redirect(base_url().'admin/manage-user/upload-docs/'.$user_id);
			
		}else{

			if($upd_user['error'] != ''){
				$this->session->set_flashdata('err_message', '- '.strip_tags($upd_admin['error']));
				redirect(base_url().'admin/manage-user/upload-docs/'.$user_id);
				
			}else{
				$this->session->set_flashdata('err_message', '- User Docs cannot be uploaded. Something went wrong, please try again.');
				redirect(base_url().'admin/manage-user/upload-docs/'.$user_id);
				
			}//end if($upd_customer['error'] != '')
			
		}//end if($add_cms_page)

	}//end user Upload Docs
	
	
	//View User Attendance
	public function view_attendance($user_id){
		
		$this->load->model('admin_roles/mod_admin_roles');
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(138,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if
		
		//Plugin Files Permission
		$data['PLUGIN_datagrid'] = 1;
		$data['PLUGIN_datepicker'] = 0;
		$data['PLUGIN_gcal'] = 0;
		$data['PLUGIN_form_validation'] = 0;
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
		$this->breadcrumbcomponent->add('Manage User', base_url().'admin/manage-user');
		$this->breadcrumbcomponent->add('User details', base_url().'admin/manage-user/edit-user/'.$admin_id);
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
		
		// Get Current Month and year
		$data['search_date']= $this->input->get('search_date')? $this->input->get('search_date') : date('m/Y') ; 

		
		//Getting  User Attendance
		$get_attendance = $this->mod_attendance->get_attendance($data['user_id'] , $data['search_date'] );

		$data['attendance_arr'] = $get_attendance['attendance_arr'];
		$data['attendance_count'] = $get_attendance['attendance_count'];
		
		
		
		
		/*echo "<pre>";			
		print_r($data['attendance_arr']);
		exit;*/
		
		$this->load->view('admin/view_attendance',$data);
		
	}//view_attendance
	
	 public function process_admin_users_grid(){
		
		echo $this->mod_admin->get_filter_admin_user_grid_data();
		
	}//end Manage admin user grid process
	
	
	//Task Detail Report
	public function task_detail_report(){
		
		$this->load->model('admin_roles/mod_admin_roles');
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(143,$this->session->userdata('permissions_arr'))){
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
		$this->breadcrumbcomponent->add('Manage User', base_url().'admin/manage-user');
		$this->breadcrumbcomponent->add('Task Detail Report', base_url().'admin/manage-user/add-new-user');
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
		
		//Admin User Roles List
		$get_all_admin_roles = $this->mod_admin_roles->get_all_admin_roles();
		$data['admin_roles_arr'] = $get_all_admin_roles['admin_roles_result'];
		$data['admin_roles_count'] = $get_all_admin_roles['admin_roles_result_count'];
		
		//Get task_detail_report
		$get_task_detail_report = $this->mod_admin->task_detail_report();
		$data['task_detail_report_arr'] = $get_task_detail_report['task_detail_report_arr'];
		$data['task_detail_report_count'] = $get_task_detail_report['task_detail_report_count'];
		
		/*echo "<pre>";
		print_r($data['admin_roles_arr']);
		exit;*/
		
		//Get All Branches
		$get_all_branches = $this->mod_admin->get_all_branches();
		$data['branches_arr'] = $get_all_branches['branches_arr'];
		$data['branches_count'] = $get_all_branches['branches_count'];
		
		
		
		$this->load->view('admin/task_detail_report',$data);
		
	}//task_detail_report
	
	//GET SOP
	public function sop(){
		
		$this->load->model('admin_roles/mod_admin_roles');
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(144,$this->session->userdata('permissions_arr'))){
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
		$this->breadcrumbcomponent->add('Manage User', base_url().'admin/manage-user');
		$this->breadcrumbcomponent->add('SOP', base_url().'admin/manage-user/edit-user/'.$admin_id);
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		//Permissions
		$data['ALLOW_user_edit'] =   (in_array(147,$this->session->userdata('permissions_arr'))) ? 1 : 0;
		$data['ALLOW_user_delete'] =   (in_array(146,$this->session->userdata('permissions_arr'))) ? 1 : 0;
		$data['ALLOW_pages_add'] =   (in_array(145,$this->session->userdata('permissions_arr'))) ? 1 : 0;
		
		
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
		
		
		//Get All SOP
		$get_all_sop  = $this->mod_admin->get_all_sop();
		$data['sop_arr'] = $get_all_sop['sop_arr'];
		$data['sop_count'] = $get_all_sop['sop_count'];
		/*echo "<pre>";
		print_r($data['sop_arr']);
		exit;*/
		
		$this->load->view('admin/sop',$data);
		
	}//sop
	
	//Add SOP
	public function add_sop(){
		
		$this->load->model('admin_roles/mod_admin_roles');
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(145,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if
		
		//Plugin Files Permission
		$data['PLUGIN_datagrid'] = 0;
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
		$this->breadcrumbcomponent->add('Manage SOP', base_url().'admin/manage-user/sop');
		$this->breadcrumbcomponent->add('Add SOP', base_url().'admin/manage-user/edit-user/'.$admin_id);
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
		
		//Admin User Roles List
		$get_all_admin_roles = $this->mod_admin_roles->get_all_admin_roles();
		$data['admin_roles_arr'] = $get_all_admin_roles['admin_roles_result'];
		$data['admin_roles_count'] = $get_all_admin_roles['admin_roles_result_count'];
		
		
		$this->load->view('admin/add_sop',$data);
		
	}//add-sop
	
	
	//add-sop-process
	public function add_sop_process(){
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		
		//Verify if Page is Accessable
		if(!in_array(145,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if
		
		
		$add_sop = $this->mod_admin->add_sop($this->input->post());
		
		if($add_sop && $add_sop['error'] == ''){
			
			$this->session->set_flashdata('ok_message', ' SOP Added successfully.');
			redirect(base_url().'admin/manage-user/sop');
			
		}else{

				$this->session->set_flashdata('err_message', ' SOP cannot be uploaded. Something went wrong, please try again.');
				redirect(base_url().'admin/manage-user/sop');
			
			
		}//end if($add_cms_page)

	}//end add-sop-process
	
	
	//sop_detail
	public function sop_detail($sop_id){
		
		$this->load->model('admin_roles/mod_admin_roles');
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(144,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if
		
		//Plugin Files Permission
		$data['PLUGIN_datagrid'] = 0;
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
		$this->breadcrumbcomponent->add('Manage SOP', base_url().'admin/manage-user/sop');
		$this->breadcrumbcomponent->add('Add SOP', base_url().'admin/manage-user/edit-user/'.$admin_id);
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
		
		//Get sop
		$get_sop= $this->mod_admin->get_sop($sop_id);
		$data['sop_arr'] = $get_sop['sop_arr'];
		
		
		$this->load->view('admin/sop_detail',$data);
		
	}//sop_detail
	
	
	//edit_sop
	public function edit_sop($sop_id){
		
		$this->load->model('admin_roles/mod_admin_roles');
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(146,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if
		
		//Plugin Files Permission
		$data['PLUGIN_datagrid'] = 0;
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
		$this->breadcrumbcomponent->add('Manage SOP', base_url().'admin/manage-user/sop');
		$this->breadcrumbcomponent->add('Add SOP', base_url().'admin/manage-user/edit-user/'.$admin_id);
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
		
		//Admin User Roles List
		$get_all_admin_roles = $this->mod_admin_roles->get_all_admin_roles();
		$data['admin_roles_arr'] = $get_all_admin_roles['admin_roles_result'];
		$data['admin_roles_count'] = $get_all_admin_roles['admin_roles_result_count'];
		
		//Get sop
		$get_sop= $this->mod_admin->get_sop($sop_id);
		$data['sop_arr'] = $get_sop['sop_arr'];
		
		$data['sop_id'] =$sop_id;
		
		$this->load->view('admin/edit_sop',$data);
		
	}//edit_sop
	
	
	
	//edit-sop-process
	public function edit_sop_process(){
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		
		//Verify if Page is Accessable
		if(!in_array(146,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if
		
		
		/*if($err_msg !=''){

			$this->session->set_flashdata('err_message', $err_msg);
			redirect(base_url().'admin/manage-user/upload-docs/'.$user_id);
			
		}//end if($err_msg !='')*/

		
		$edit_sop = $this->mod_admin->edit_sop($this->input->post());
		
		$sop_id=$this->input->post('sop_id');
		
		if($edit_sop && $edit_sop['error'] == ''){
			
			$this->session->set_flashdata('ok_message', ' SOP Updated successfully.');
			redirect(base_url().'admin/manage-user/edit-sop/'.$sop_id);
			
		}else{

				$this->session->set_flashdata('err_message', ' SOP cannot be Updated. Something went wrong, please try again.');
				redirect(base_url().'admin/manage-user/edit-sop/'.$sop_id);
			
			
		}//end if($add_cms_page)

	}//end edit-sop-process
	
	//delete-sop
	public function delete_sop($sop_id){
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		
		//Verify if Page is Accessable
		if(!in_array(147,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if
		
		$delete_sop = $this->mod_admin->delete_sop($sop_id);
		
		if($delete_sop && $delete_sop['error'] == ''){
			
			$this->session->set_flashdata('ok_message', ' SOP deleted successfully.');
			redirect(base_url().'admin/manage-user/sop');
			
		}else{

				$this->session->set_flashdata('err_message', ' SOP cannot be deleted. Something went wrong, please try again.');
				redirect(base_url().'admin/manage-user/sop');
			
			
		}//end if($add_cms_page)

	}//end delete-sop
	
	
	
	//salary_report
	public function salary_report(){
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(164,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if
		
		//Plugin Files Permission
		$data['PLUGIN_datagrid'] = 0;
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
		$this->breadcrumbcomponent->add('Salary Report', base_url().'admin/manage-user/salary-report');
		
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
		
	    //Get all users
		$get_admin_user = $this->mod_admin->get_admin_for_salary_report();
		$data['admin_user_list'] = $get_admin_user['admin_list_result'];
		$data['admin_user_list_count'] = $get_admin_user['admin_list_result_count'];
		
		//GET Admin Roles
		$get_admin_roles = $this->mod_admin_roles->get_all_admin_roles();
		$data['admin_roles_result'] = $get_admin_roles['admin_roles_result'];
		$data['admin_roles_result_count'] = $get_admin_roles['admin_roles_result_count'];
		
		//GET Branches
		$get_branches= $this->mod_branches->get_all_branches();
		$data['branches_arr'] = $get_branches['branches_arr'];
		$data['branches_count'] = $get_branches['branches_count'];
		
		$data['branch_id']= $this->input->post('branch_id');
		$data['role_id']= $this->input->post('role_id');
		$data['status']= $this->input->post('search_status');
		
		$this->load->view('admin/salary_report',$data);
		
	}//salary_report
	
	
	//add_increament
	public function add_increament(){
		
	
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		$add_increament = $this->mod_admin->add_increament($this->input->post());
		
		if($add_increament && $add_increament['error'] == ''){
			
			$this->session->set_flashdata('ok_message', 'Increament Added Successfully.');
			redirect(base_url().'admin/manage-user/salary-report');
			
		}else{

				$this->session->set_flashdata('err_message', ' Increament cannot be added. Something went wrong, please try again.');
				redirect(base_url().'admin/manage-user/salary-report');
			
			
		}//end if($add_cms_page)

	}//end add_increament

	

}//end Dashboard 
