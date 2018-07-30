<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Manage_Projects extends CI_Controller {

	public function __construct(){
		parent::__construct();
	
			
		$this->load->driver('cache');
		$this->cache->clean();
		$this->output->cache(0);
		
		$this->load->model('admin/mod_admin');
		$this->load->model('common/mod_common');
		$this->load->model('projects/mod_projects');
		$this->load->model('customers/mod_customer');
		$this->load->library('BreadcrumbComponent');
		$this->load->model('site_preferences/mod_preferences');
		$this->load->model('email/mod_email');
		
		$this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
		$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
		$this->output->set_header('Pragma: no-cache');
		$this->output->set_header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');  


	
	}

	public function index(){
		
		
		
		//Login Check
	
		$this->mod_admin->verify_is_admin_login();
	

		//Verify if Page is Accessable
		if(!in_array(75,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if
		
		//Plugin Files Permission
		$data['PLUGIN_datagrid'] = 1;
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
		
				$this->benchmark->mark('mzm_time_for_fetch_admin_nav_panel_start');
	
		
		
		$fetch_nav_panel = $this->mod_common->fetch_admin_nav_panel();
		$data['nav_panel_arr'] = $fetch_nav_panel;
			$this->benchmark->mark('mzm_time_for_fetch_admin_nav_panel_end'); 
		
		
		
				
				
		logit('log a message in console 1');
		 
		logit($fetch_nav_panel); 
	
		
		
		//Permissions
		$data['ALLOW_user_edit'] =   (in_array(76,$this->session->userdata('permissions_arr'))) ? 1 : 0;
		$data['ALLOW_user_delete'] =   (in_array(77,$this->session->userdata('permissions_arr'))) ? 1 : 0;
		$data['ALLOW_pages_add'] =   (in_array(74,$this->session->userdata('permissions_arr'))) ? 1 : 0;
		$data['ALLOW_user_action'] =   (in_array(114,$this->session->userdata('permissions_arr'))) ? 1 : 0;
		$data['ALLOW_user_assign_team'] =   (in_array(127,$this->session->userdata('permissions_arr'))) ? 1 : 0;
		$data['ALLOW_user_assign_task'] =   (in_array(128,$this->session->userdata('permissions_arr'))) ? 1 : 0;
		$data['ALLOW_workspace'] =   (in_array(153,$this->session->userdata('permissions_arr'))) ? 1 : 0;
		
		$data['ALLOW_project_workspace'] =   (in_array(153,$this->session->userdata('permissions_arr'))) ? 1 : 0;
		$data['ALLOW_project_important'] =   (in_array(155,$this->session->userdata('permissions_arr'))) ? 1 : 0;
		
		$data['ALLOW_user_search_status'] =   (in_array(120,$this->session->userdata('permissions_arr'))) ? 1 : 0;
		$data['ALLOW_user_search_branch'] =   (in_array(121,$this->session->userdata('permissions_arr'))) ? 1 : 0;
		
		$data['ALLOW_user_project_label'] =   (in_array(156,$this->session->userdata('permissions_arr'))) ? 1 : 0;
		
		$data['ALLOW_payment_due'] =   (in_array(166,$this->session->userdata('permissions_arr'))) ? 1 : 0;

		
		//Bread crum
		$this->breadcrumbcomponent->add('Dashboard', base_url().'dashboard/dashboard');
		$this->breadcrumbcomponent->add('Manage Projects', base_url().'coupons/manage-coupons');
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
		
		$projects_arr = $this->mod_projects->get_projects();
		//echo '<pre>';print_r($projects_arr);exit;
		$data['projects_arr'] = $projects_arr['projects_filter'];
		$data['projects_count'] = $projects_arr['projects_count'];
		
		//Get All Branches
		$get_all_branches = $this->mod_admin->get_all_branches();
		$data['branches_arr'] = $get_all_branches['branches_arr'];
		$data['branches_count'] = $get_all_branches['branches_count'];
		
		$data['branch_id']= $this->input->post('branch_id');
		$data['status']= $this->input->post('search_status');
		
		$this->load->view('projects/manage_projects',$data);
		
			
	}//end index()
	
	//Add Project
	public function add_project(){
	
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(74,$this->session->userdata('permissions_arr'))){
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
		$this->breadcrumbcomponent->add('Manage Projects', base_url().'projects/manage-projects');
		$this->breadcrumbcomponent->add('Add New Project', base_url().'projects/manage-projects/add-projects');
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
		
		
		//Get Customers
		$get_all_project_defauls= $this->mod_projects->get_all_project_defauls();
		$data['project_defauls_user_arr'] 	= $get_all_project_defauls;
		
		
		//Get Customers
		$get_all_customer = $this->mod_customer->get_all_customers();
		$data['customers_list_arr'] 	= $get_all_customer['customers_list_arr'];
		$data['customers_list_count']	= $get_all_customer['customers_list_count'];
		
		
		//Get Users
		$get_all_users = $this->mod_projects->get_all_users();
		$data['users_list_arr'] 	= $get_all_users['users_arr'];
		$data['users_list_count']	= $get_all_users['users_count'];
		
		//Get forums
		$get_all_forums = $this->mod_projects->get_all_forums();
		$data['forums_list_arr'] 	= $get_all_forums['forums_arr'];
		$data['forums_list_count']	= $get_all_forums['forums_count'];
		
		//Get All Branches
		$get_all_branches = $this->mod_admin->get_all_branches();
		$data['branches_arr'] = $get_all_branches['branches_arr'];
		$data['branches_count'] = $get_all_branches['branches_count'];
		
		$this->load->view('projects/add_project',$data);
		
	}//End Add new project

	public function add_project_process(){
		
		//If Post is not SET
		if(!$this->input->post() && !$this->input->post('submit')) redirect(base_url());
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

	/*	//Verify if Page is Accessable
		if(!in_array(74,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if*/
		
		$err_msg = '';

		if(trim($this->input->post('project_id')) == ''){
			
			$err_msg.= ' Subject cannot be empty.<br>';
			
		}//end if
		
		if(trim($this->input->post('project_subject')) == ''){
			
			$err_msg.= ' Title cannot be empty.<br>';
			
		}//end if
		
		if(trim($this->input->post('project_amount')) == ''){
			
			$err_msg.= ' Amount cannot be empty.<br>';
			
		}//end if
		
		if(trim($this->input->post('project_detail')) == ''){
			
			$err_msg.= ' Detail cannot be empty.<br>';
			
		}//end if
		
		if($err_msg !=''){

			$this->session->set_flashdata('err_message', $err_msg);
			redirect(base_url().'projects/manage_projects/add_project');
			
		}//end if($err_msg !='')

		
			//add Project
			$add_project = $this->mod_projects->add_project($this->input->post());
			
			if($add_project && $add_project['error'] == ''){
				
				$this->session->set_flashdata('ok_message', 'New Project added successfully.');
				redirect(base_url().'projects/manage-projects/add-project');
				
			}else{
				
				if($add_project['error'] != ''){
					$this->session->set_flashdata('err_message', 'Opps File can not uploaded due to Size Exceeded...! ');
					redirect(base_url().'projects/manage-projects/');
					
				}else{
					$this->session->set_flashdata('err_message', 'New Project cannot be added. Something went wrong, please try again.');
					redirect(base_url().'projects/manage-projects/add-project');
					
				}//end if
				
			}//end if
			
	}//end add_project_process
	
	
	//Edit project
	public function edit_project($project_id){
	
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(76,$this->session->userdata('permissions_arr'))){
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
		$this->breadcrumbcomponent->add('Manage Projects', base_url().'projects/manage-projects');
		$this->breadcrumbcomponent->add('Edit Project', base_url().'coupons/manage-coupons/add-coupons');
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
		
			
		$get_all_users = $this->mod_projects->get_all_users();
		$data['users_list_arr'] 	= $get_all_users['users_arr'];
		$data['users_list_count']	= $get_all_users['users_count'];
		
		/*echo "<pre>";
		print_r($get_all_users);
		exit;*/
		
		
		$get_all_customer = $this->mod_customer->get_all_customers();
		$data['customers_list_arr'] 	= $get_all_customer['customers_list_arr'];
		$data['customers_list_count']	= $get_all_customer['customers_list_count'];
		
		$project_detail = $this->mod_projects->get_project_details($project_id);
		$data['project_detail_arr']= $project_detail['project_detail_result'];
		
		$data['project_attachments_arr']= $project_detail['project_attachments'];
		$data['project_attachments_count']= $project_detail['project_attachments_count'];
		
		//Get forums
		$get_all_forums = $this->mod_projects->get_all_forums();
		$data['forums_list_arr'] 	= $get_all_forums['forums_arr'];
		$data['forums_list_count']	= $get_all_forums['forums_count'];
		
		//Get All Branches
		$get_all_branches = $this->mod_admin->get_all_branches();
		$data['branches_arr'] = $get_all_branches['branches_arr'];
		$data['branches_count'] = $get_all_branches['branches_count'];
		
		//Get project_milestones
		$get_project_milestones= $this->mod_projects->get_project_milestones($project_id);
		$data['project_milestones_arr'] = $get_project_milestones['project_milestones_arr'];
		$data['project_milestones_count'] = $get_project_milestones['project_milestones_count'];
	
		
		$data['project_id']=$project_id;
		
		$this->load->view('projects/edit_project',$data);
		
	}//End Edit Project
	
	
    
	public function edit_project_process(){
		
		//If Post is not SET
		if(!$this->input->post() && !$this->input->post('update')) redirect(base_url());
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(76,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if
		
		
			//edit project
			$update_project = $this->mod_projects->edit_project($this->input->post());
			
			if($update_project && $update_project['error'] == ''){
				
				$this->session->set_flashdata('ok_message', 'Project Updated successfully.');
				redirect(base_url().'projects/manage-projects/edit-project/'.$this->input->post('id'));
				
			}else{
				
				if($update_project['error'] != ''){
					$this->session->set_flashdata('err_message', 'Opps File can not uploaded..!');
					redirect(base_url().'projects/manage-projects/edit-project/'.$this->input->post('id'));
					
				}else{
					$this->session->set_flashdata('err_message', 'Project cannot be Updated. Something went wrong, please try again.');
					redirect(base_url().'projects/manage-projects/edit-project'.$this->input->post('id'));
					
				}//end if
				
			}//end if
	}//end messages Detail process
	
	
	public function delete_project_attachment($project_id,$attachment_id){
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(77,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if
		
			
			$delete_attachment = $this->mod_projects->delete_project_attachment($attachment_id);
			
			if($delete_attachment && $delete_attachment['error'] == ''){
				
				$this->session->set_flashdata('ok_message', 'Project Attachment Deleted successfully.');
				redirect(base_url().'projects/manage-projects/edit-project/'.$project_id);
				
			}else{
				
				if($delete_attachment['error'] != ''){
					$this->session->set_flashdata('err_message', '- '.strip_tags($add_new_user['error']));
					redirect(base_url().'projects/manage-projects/edit-project/'.$project_id);
					
				}else{
					$this->session->set_flashdata('err_message', 'Project Attachment cannot be Daleted. Something went wrong, please try again.');
					redirect(base_url().'projects/manage-projects/edit-project/'.$project_id);
					
				}//end if
				
			}//end if
			
	}//end delete Attachments
	
	//project Detail
	public function project_detail($project_id){
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(75,$this->session->userdata('permissions_arr'))){
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
		$data['PLUGIN_autolinker'] = 1;
		
		//Common Includes
		$data['meta_title'] = DEFAULT_TITLE;
		$data['meta_keywords'] = DEFAULT_META_KEYWORDS;
		$data['meta_description'] = DEFAULT_META_DESCRIPTION;

		$fetch_nav_panel = $this->mod_common->fetch_admin_nav_panel();
		$data['nav_panel_arr'] = $fetch_nav_panel;
		
		//Permissions
		$data['ALLOW_user_assign_team'] =   (in_array(127,$this->session->userdata('permissions_arr'))) ? 1 : 0;
		$data['ALLOW_user_assign_task'] =   (in_array(128,$this->session->userdata('permissions_arr'))) ? 1 : 0;
		$data['ALLOW_user_detail_page'] =   (in_array(129,$this->session->userdata('permissions_arr'))) ? 1 : 0;
		$data['ALLOW_customer_detail_page'] =   (in_array(130,$this->session->userdata('permissions_arr'))) ? 1 : 0;
		$data['ALLOW_user_milestones'] =   (in_array(165,$this->session->userdata('permissions_arr'))) ? 1 : 0;
		$data['ALLOW_user_edit_project'] =   (in_array(76,$this->session->userdata('permissions_arr'))) ? 1 : 0;

		//Bread crum
		$this->breadcrumbcomponent->add('Dashboard', base_url().'dashboard/dashboard');
		$this->breadcrumbcomponent->add('Manage Projects', base_url().'projects/manage-projects');
		$this->breadcrumbcomponent->add('Project Detail', base_url().'cprojects/manage-projects/project_detail');
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
		
		
		//Update messages Record
		 $this->mod_projects->update_project_messages_count($project_id);
		
		
		//Get project Messsaes
		$project_details = $this->mod_projects->get_project_messages($project_id);
		$data['project_messages_arr'] = $project_details['project_messages_result'];
		$data['project_messages_count'] = $project_details['project_messages_count'];
		
		
		
		//get messages attachments array
		
		$project_messages_attachments = $this->mod_projects->get_message_attachments($project_id);
		$data['project_message_attachment_arr'] = $project_messages_attachments;
		
		
		$project_details = $this->mod_projects->get_project_tasks($project_id);
		$data['total_task'] = $project_details['total_task'];
		$data['open_task'] = $project_details['open_task'];
		$data['hold_task'] = $project_details['hold_task'];
		$data['closed_task'] = $project_details['closed_task'];
		
		$data['total_task_time'] = $project_details['total_task_time'];
		$data['total_task_consumed_time'] = $project_details['total_task_consumed_time'];
		
		$data['project_task_arr'] = $project_details['project_task_result'];
		
		$project_details = $this->mod_projects->project_detail($project_id);
		$data['project_details_arr'] = $project_details['project_details_result'];
	
		//Check if Project Exist
		if($project_details['error']){
			
			  $this->session->set_flashdata('err_message', 'Oops...! Project not found');
			
			  redirect(base_url().'projects/manage_projects');
			
		}
	
		
		$data['project_attachments_arr']= $project_details['project_attachments'];
		$data['project_attachments_count']= $project_details['project_attachments_count'];
		
		$data['project_assign_team'] = $project_details['project_assign_team'];
		$data['role'] = $project_details['role'];
		
		$data['project_id'] =$project_id;
		
		
		//Get project_milestones
		$get_project_milestones= $this->mod_projects->get_project_milestones($project_id);
		$data['project_milestones_arr'] = $get_project_milestones['project_milestones_arr'];
		$data['project_milestones_count'] = $get_project_milestones['project_milestones_count'];
		
		
		$this->load->view('projects/project_detail',$data);
		
	}//End Project_detail
	
	
	
	public function delete_project($project_id){
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(77,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if
		
			
			$delete_projects = $this->mod_projects->delete_project($project_id);
			
			if($delete_projects && $delete_projects['error'] == ''){
				
				$this->session->set_flashdata('ok_message', 'Project Deleted successfully.');
				redirect(base_url().'projects/manage_projects/');
				
			}else{
				
				if($delete_projects['error'] != ''){
					$this->session->set_flashdata('err_message', '- '.strip_tags($add_new_user['error']));
					redirect(base_url().'projects/manage_projects/');
					
				}else{
					$this->session->set_flashdata('err_message', 'Project cannot  Deleted. Something went wrong, please try again.');
					redirect(base_url().'projects/manage_projects/');
					
				}//end if
				
			}//end if
			
	}//end Delete Projects
	

    //project Assign
	public function project_assign($project_id){
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(127,$this->session->userdata('permissions_arr'))){
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
		$this->breadcrumbcomponent->add('Project Assign', base_url().'coupons/manage-coupons/add-coupons');
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
		
		$get_all_users = $this->mod_projects->get_all_users();
		$data['users_list_arr'] 	= $get_all_users['users_arr'];
		$data['users_list_count']	= $get_all_users['users_count'];
		
		$get_assign_team = $this->mod_projects->get_assign_team($project_id);
		$data['assign_team_arr'] 	= $get_assign_team;
		/*echo "<pre>";
		print_r($data['users_list_arr']  );
		exit;*/
		
		
		$data['project_id'] =$project_id;
		
		
		$this->load->view('projects/assign_project',$data);
		
	}//End assign_project
	
	
	//Ajax Response Get Team Against Project
	public function get_team_list($project_id){
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		
		//State List List
		$get_project_team = $this->mod_projects->get_project_team($project_id);

		$data['team_arr'] = $get_project_team;
		
		
	   /* echo "<pre>";
		print_r($data['team_arr']);
		exit;*/
		
		if($project_id != '0'){
		
		if($data['team_arr'] >0){ // If State found in database .
		
		$response_select .= '<select name="task_assign[]" id="user_id" data-placeholder="Choose a name..." class="chosen-select" multiple style="width:350px;" tabindex="4">';
			for($p=0; $p < count($data['team_arr']); $p++){
				
				$response_select .= "<option value=".$data['team_arr'][$p]['id'].">".$data['team_arr'][$p]['name']."</option>" ;		
			}
		$response_select .= '</select>' ;		
		}
		}else{
			
			$response_select .="<br />Please Select Project";
			
		}
		
		
		echo $response_select ; 
		exit;
	}//get_states_list
		
	
	
	
	public function project_assign_process(){
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(127,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if
		
		
	
		if(trim($this->input->post('project_id')) == ''){
			
			$err_msg.= '- Please Enter Project Name.<br>';
			
		}//end if
		
	
	
		if($err_msg !=''){

			$this->session->set_flashdata('err_message', $err_msg);
			redirect(base_url().'projects/manage_projects/project_assign/'.$this->input->post('project_id'));
			
		}//end if
			
			$assign_projects = $this->mod_projects->project_assign($this->input->post());
			
			if($assign_projects && $assign_projects['error'] == ''){
				
				$this->session->set_flashdata('ok_message', 'Project Assign successfully.');
				redirect(base_url().'projects/manage_projects/');
				
			}else{
				
				if($assign_projects['error'] != ''){
					$this->session->set_flashdata('err_message', '- '.strip_tags($add_new_user['error']));
					redirect(base_url().'projects/manage_projects/');
					
				}else{
					$this->session->set_flashdata('err_message', 'Project cannot  Assign. Something went wrong, please try again.');
					redirect(base_url().'projects/manage_projects/');
					
				}//end if
				
			}//end if
			
	}//end assign_project_process
	
	
	
	
    //Assign Task
	public function assign_task($project_id){
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(128,$this->session->userdata('permissions_arr'))){
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
		$this->breadcrumbcomponent->add('Assign Task', base_url().'coupons/manage-coupons/add-coupons');
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
		
		$get_all_team= $this->mod_projects->get_project_team($project_id);
		$data['team_arr'] 	= $get_all_team;
		/*
			echo "<pre>";
		print_r($data['team_arr']);
		exit;
		*/
		$data['project_id'] =$project_id;
		
		$this->load->view('projects/assign_task',$data);
		
	}//End assign_task
	
	
	
	public function assign_task_process(){
		
		
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(128,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if
		
		
		if(trim($this->input->post('task_assign[0]')) == ''){
			
			
			
		}//end if
		
		$check= $this->input->post('task_assign');
		
		if(empty($check))
		{
            $err_msg.= '- Please Enter Team.<br>';
        }
		 
		
		 
		if($err_msg !=''){

			$this->session->set_flashdata('err_message', $err_msg);
			redirect(base_url().'projects/manage-projects/assign-task/'.$this->input->post('project_id'));
			
		}//end if
			
			$assign_task = $this->mod_projects->assign_task($this->input->post());
			
			if($assign_task && $assign_task['error'] == ''){
				
				$this->session->set_flashdata('ok_message', 'Task Assign successfully.');
				redirect(base_url().'projects/manage-projects/add-task');
				
			}else{
				
				if($assign_task['error'] != ''){
					$this->session->set_flashdata('err_message', '- '.strip_tags($add_new_user['error']));
					redirect(base_url().'projects/manage-projects/');
					
				}else{
					$this->session->set_flashdata('err_message', 'Task cannot  Assign. Something went wrong, please try again.');
					redirect(base_url().'projects/manage-projects/add-task');
					
				}//end if
				
			}//end if
			
	}//end assign_task_process
	
	
	//Add Task
	public function add_task(){
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(110,$this->session->userdata('permissions_arr'))){
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
		
		//Permissions
		$data['ALLOW_user_edit'] =   (in_array(76,$this->session->userdata('permissions_arr'))) ? 1 : 0;
		$data['ALLOW_user_delete'] =   (in_array(77,$this->session->userdata('permissions_arr'))) ? 1 : 0;
		$data['ALLOW_pages_add'] =   (in_array(74,$this->session->userdata('permissions_arr'))) ? 1 : 0;
		

		//Bread crum
		$this->breadcrumbcomponent->add('Dashboard', base_url().'dashboard/dashboard');
		$this->breadcrumbcomponent->add('Manage Tasks', base_url().'projects/manage-projects/manage-task');
		$this->breadcrumbcomponent->add('Add Task', base_url().'coupons/manage-coupons');
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
		
		$projects_arr = $this->mod_projects->get_projects();
		$data['projects_arr'] = $projects_arr['projects_filter'];
		$data['projects_count'] = $projects_arr['projects_count'];
		
			
		//$projects_arr = $this->mod_projects->get_projects_for_task();
		//$data['projects_arr'] = $projects_arr['projects_arr'];
		//$data['projects_count'] = $projects_arr['projects_count'];
		
		
		$this->load->view('projects/assign_task',$data);
			
	}//end add_task
	
	//Manage Task
	public function manage_task(){
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(109,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if
		
		//Plugin Files Permission
		$data['PLUGIN_datagrid'] = 1;
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
		$data['ALLOW_user_edit'] =   (in_array(112,$this->session->userdata('permissions_arr'))) ? 1 : 0;
		$data['ALLOW_user_delete'] =   (in_array(113,$this->session->userdata('permissions_arr'))) ? 1 : 0;
		$data['ALLOW_pages_add'] =   (in_array(110,$this->session->userdata('permissions_arr'))) ? 1 : 0;
		

		//Bread crum
		$this->breadcrumbcomponent->add('Dashboard', base_url().'dashboard/dashboard');
		$this->breadcrumbcomponent->add('My Tasks', base_url().'coupons/manage-coupons');
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
		
		$assign_task_arr = $this->mod_projects->get_assign_task();
		
		$data['assign_task_arr'] = $assign_task_arr['assign_task_filter'];
		$data['assign_task_count'] = $assign_task_arr['assign_task_count'];
		
		
		
		/*echo "<pre>";
		print_r($data['assign_task_arr']);
		exit;*/
		
		
		$this->load->view('projects/manage_task',$data);
			
	}//end manage_task
	
	
	 //Edit Assign Task
	public function edit_assign_task($assign_task_id){
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(112,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if
		
		
		//Plugin Files Permission
		$data['PLUGIN_datagrid'] = 0;
		$data['PLUGIN_datepicker'] = 1;
		$data['PLUGIN_gcal'] = 1;
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
		$this->breadcrumbcomponent->add('Manage Task', base_url().'projects/manage-projects/manage-task');
		$this->breadcrumbcomponent->add('Edit Assign Task', base_url().'coupons/manage-coupons/add-coupons');
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
		
		$assign_task_detail = $this->mod_projects->get_assign_task_detail($assign_task_id);
		
		$data['assign_task_arr']= $assign_task_detail['assign_task_result'];
		
		$data['assign_task_attachments']= $assign_task_detail['assign_task_attachments'];
		$data['assign_task_attachments_count']= $assign_task_detail['assign_task_attachments_count'];
		
		$get_all_users = $this->mod_projects->get_all_users();
		$data['users_list_arr'] 	= $get_all_users['users_arr'];
		$data['users_list_count']	= $get_all_users['users_count'];
		/*
		echo "<pre>";
		print_r($data['users_list_count']);
		exit;*/
		
		$data['assign_task_id'] =$assign_task_id;
		
		
		$this->load->view('projects/edit_assign_task',$data);
		
	}//End edit_assign_task
	
	
	//Edit Assign_task_process
	public function edit_assign_task_process(){
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(112,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if
		
			
			$edit_assign_task = $this->mod_projects->edit_assign_task($this->input->post());
			
			if($edit_assign_task && $edit_assign_task['error'] == ''){
				
				$this->session->set_flashdata('ok_message', 'Assign Task Updated successfully.');
				redirect(base_url().'projects/manage-projects/show-all-tasks');
				
			}else{
				
				if($edit_assign_task['error'] != ''){
					$this->session->set_flashdata('err_message', '- '.strip_tags($add_new_user['error']));
					redirect(base_url().'projects/manage-projects/show-all-tasks');
					
				}else{
					$this->session->set_flashdata('err_message', 'Task cannot  Updated. Something went wrong, please try again.');
					redirect(base_url().'projects/manage-projects/show-all-tasks');
					
				}//end if
				
			}//end if
			
	}//end edit_assign_task_process
	
	
	
	//Delete Assign_task_attachments
	public function delete_assign_task_attachment($task_id,$task_attachment_id){
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(113,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if
		
			
			$delete_task_attach = $this->mod_projects->delete_assign_task_attachment($task_attachment_id,$task_id);
			
			if($delete_task_attach && $delete_task_attach['error'] == ''){
				
				$this->session->set_flashdata('ok_message', 'Task Attachment Deleted successfully.');
				redirect(base_url().'projects/manage-projects/edit-assign-task/'.$task_id);
				
			}else{
				
				if($delete_task_attach['error'] != ''){
					$this->session->set_flashdata('err_message', '- '.strip_tags($add_new_user['error']));
					redirect(base_url().'projects/manage-projects/edit-assign-task/'.$task_id);
					
				}else{
					$this->session->set_flashdata('err_message', 'Task Attachment cannot  Deleted. Something went wrong, please try again.');
					redirect(base_url().'projects/manage-projects/edit-assign-task/'.$task_id);
					
				}//end if
				
			}//end if
			
	}//end delete_assign_task_attachments


   //Delete Assign_task
	public function delete_assign_task($task_id){
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(113,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if
		
			
			$delete_task = $this->mod_projects->delete_assign_task($task_id);
			
			if($delete_task && $delete_task['error'] == ''){
				
				$this->session->set_flashdata('ok_message', 'Task Deleted successfully.');
				redirect(base_url().'projects/manage-projects/manage-task');
				
			}else{
				
				if($delete_task['error'] != ''){
					$this->session->set_flashdata('err_message', '- '.strip_tags($add_new_user['error']));
					redirect(base_url().'projects/manage-projects/manage-task');
					
				}else{
					$this->session->set_flashdata('err_message', 'Task  cannot  Deleted. Something went wrong, please try again.');
					redirect(base_url().'projects/manage-projects/manage-task');
					
				}//end if
				
			}//end if
			
	}//end delete_assign_task
	
	
	
	//Assign TAsk Detail
	public function assign_task_detail($assign_task_id){
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(109,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if
		
		//Plugin Files Permission
		$data['PLUGIN_datagrid'] = 1;
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
		
		if(in_array(140,$this->session->userdata('permissions_arr'))){
			
		   $this->breadcrumbcomponent->add('Show All Tasks', base_url().'projects/manage-projects/show-all-tasks');	
		   $this->breadcrumbcomponent->add('My Tasks', base_url().'projects/manage-projects/manage-task');
		   
		}else{
		
		   $this->breadcrumbcomponent->add('Manage Tasks', base_url().'projects/manage-projects/manage-task');
		}
		$this->breadcrumbcomponent->add('Task Detail', base_url().'coupons/manage-coupons');
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
		$data['ALLOW_task_approve'] = (in_array(154,$this->session->userdata('permissions_arr'))) ? 1 : 0;
		
		//$assign_task_arr = $this->mod_projects->get_assign_task();
		$assign_task_detail = $this->mod_projects->get_assign_task_detail($assign_task_id);
		if(! $assign_task_detail){
			
			$this->session->set_flashdata('err_message', 'Oops...! Sorry Task not found');
			redirect(base_url().'projects/manage-projects/manage-task');
		
		}
		
		$data['assign_task_arr']= $assign_task_detail['assign_task_result'];
		
		$data['assign_task_attachments']= $assign_task_detail['assign_task_attachments'];
		$data['assign_task_attachments_count']= $assign_task_detail['assign_task_attachments_count'];
		
		$data['assign_task_id'] =$assign_task_id;
		
		
		$this->load->view('projects/assign_task_detail',$data);
			
	}//end manage_task_detail
	
	
	//update_task_status
	public function update_task_status($status,$assign_task_id){
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(109,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if
		
			
			$update_task = $this->mod_projects->update_task_status($status,$assign_task_id);
			
			if($update_task['already_start_task'] !=''){
				
				$this->session->set_flashdata('err_message',$update_task['already_start_task']);
				redirect(base_url().'projects/manage-projects/assign-task-detail/'.$assign_task_id);
				
			}
			
			if($update_task['start_error'] !=''){
				
				$this->session->set_flashdata('err_message',$update_task['start_error']);
				redirect(base_url().'projects/manage-projects/assign-task-detail/'.$assign_task_id);
				
			}
			if($update_task['hold_error'] !=''){
				
				
				$this->session->set_flashdata('err_message',$update_task['hold_error']);
				redirect(base_url().'projects/manage-projects/assign-task-detail/'.$assign_task_id);
				
			}
			if($update_task['closed_error'] !=''){
				
				
				$this->session->set_flashdata('err_message',$update_task['closed_error']);
				redirect(base_url().'projects/manage-projects/assign-task-detail/'.$assign_task_id);
				
			}
			
			if($update_task && $update_task['error'] == ''){
				
				$this->session->set_flashdata('ok_message', 'Task Updated successfully.');
				redirect(base_url().'projects/manage-projects/assign-task-detail/'.$assign_task_id);
				
			}else{
				
				if($update_task['error'] != ''){
					$this->session->set_flashdata('err_message', '- '.strip_tags($add_new_user['error']));
					redirect(base_url().'projects/manage-projects/assign-task-detail/'.$assign_task_id);
					
				}else{
					$this->session->set_flashdata('err_message', 'Task  cannot  Updated. Something went wrong, please try again.');
					redirect(base_url().'projects/manage-projects/assign-task-detail/'.$assign_task_id);
					
				}//end if
				
			}//end if
			
	}//end update_task_status
	
	
	
	//Assign TAsk Detail
	public function calendar(){
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(12,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if
		
		//Plugin Files Permission
		$data['PLUGIN_datagrid'] = 1;
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
		$data['ALLOW_user_edit'] =   (in_array(76,$this->session->userdata('permissions_arr'))) ? 1 : 0;
		$data['ALLOW_user_delete'] =   (in_array(77,$this->session->userdata('permissions_arr'))) ? 1 : 0;
		$data['ALLOW_pages_add'] =   (in_array(74,$this->session->userdata('permissions_arr'))) ? 1 : 0;
		

		//Bread crum
		$this->breadcrumbcomponent->add('Dashboard', base_url().'dashboard/dashboard');
		$this->breadcrumbcomponent->add('Calendar', base_url().'coupons/manage-coupons');
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
		
		$calendar_arr = $this->mod_projects->get_calendar();
		$data['calendar_arr']= $calendar_arr['calender_arr'];
		$data['calendar_count']= $calendar_arr['calendar_count'];
		
		
		$this->load->view('projects/calendar',$data);
			
	}//end calendar
	
	
	//project_action
	public function project_action($project_id){
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(114,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if
		
		
		//Plugin Files Permission
		$data['PLUGIN_datagrid'] = 0;
		$data['PLUGIN_datepicker'] = 1;
		$data['PLUGIN_gcal'] = 1;
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
		$this->breadcrumbcomponent->add('Manage Projects', base_url().'projects/manage-projects/');
		$this->breadcrumbcomponent->add('Project Action', base_url().'projects/manage-projects/project-action');
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
		
		$data['project_id'] =$project_id;
		
		$project_action= $this->mod_projects->get_project_action($project_id);
		$data['project_action'] = $project_action['project_action'];
		
	/*	echo "<pre>";
		print_r($data['project_action']);
		exit;	*/
		
		
		$this->load->view('projects/project_action',$data);
		
	}//End project_action
	
	
	//project_action_process
	public function project_action_process(){
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(114,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if
		
			
			$project_action = $this->mod_projects->project_action($this->input->post());
			
			if($project_action && $project_action['error'] == ''){
				
				$this->session->set_flashdata('ok_message', 'Project Status Updated successfully.');
				redirect(base_url().'projects/manage-projects/project-action/'.$this->input->post('project_id'));
				
			}else{
				
				if($project_action['error'] != ''){
					$this->session->set_flashdata('err_message', '- '.strip_tags($add_new_user['error']));
					redirect(base_url().'projects/manage-projects');
					
				}else{
					$this->session->set_flashdata('err_message', 'Project Status cannot  Updated. Something went wrong, please try again.');
					redirect(base_url().'projects/manage-projects/project-action/'.$this->input->post('project_id'));
					
				}//end if
				
			}//end if
			
	}//end project_action
	
	
	//submit_portfolio
	public function submit_portfolio_process(){
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(114,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if
		
			
			$submit_portfolio = $this->mod_projects->submit_portfolio($this->input->post());
			
			if($submit_portfolio && $project_action['error'] == ''){
				
				$this->session->set_flashdata('ok_message', 'Project Portfolio submitted  successfully.');
				redirect(base_url().'projects/manage-projects/project-action/'.$this->input->post('project_id'));
				
			}else{
				
				if($submit_portfolio['error'] != ''){
					$this->session->set_flashdata('err_message', '- '.$submit_portfolio['error']);
					redirect(base_url().'projects/manage-projects');
					
				}else{
					$this->session->set_flashdata('err_message', 'Project Portfolio cannot  submitted. Something went wrong, please try again.');
					redirect(base_url().'projects/manage-projects/project-action/'.$this->input->post('project_id'));
					
				}//end if
				
			}//end if
			
	}//end submit_portfolio
	
	
	//Manage User Task
	public function manage_user_task($user_id,$status){
		
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(109,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if
		
		//Plugin Files Permission
		$data['PLUGIN_datagrid'] = 1;
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
		$data['ALLOW_user_edit'] =   (in_array(112,$this->session->userdata('permissions_arr'))) ? 1 : 0;
		$data['ALLOW_user_delete'] =   (in_array(113,$this->session->userdata('permissions_arr'))) ? 1 : 0;
		$data['ALLOW_pages_add'] =   (in_array(110,$this->session->userdata('permissions_arr'))) ? 1 : 0;
		

		//Bread crum
		$this->breadcrumbcomponent->add('Dashboard', base_url().'dashboard/dashboard');
		$this->breadcrumbcomponent->add('Manage Task', base_url().'coupons/manage-coupons');
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
		
		$assign_task_arr = $this->mod_projects->get_user_task($user_id,$status);
		
		$data['assign_task_arr'] = $assign_task_arr['assign_task_filter'];
		$data['assign_task_count'] = $assign_task_arr['assign_task_count'];
		
		/*echo "<pre>";
		print_r( $data['assign_task_arr']);
		exit;
		*/
		
		$this->load->view('projects/manage_task',$data);
			
	}//end manage_user_task
	
	
	//Manage Project Task
	public function manage_project_task($project_id,$status){
		
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(109,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if
		
		//Plugin Files Permission
		$data['PLUGIN_datagrid'] = 1;
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
		$data['ALLOW_user_edit'] =   (in_array(112,$this->session->userdata('permissions_arr'))) ? 1 : 0;
		$data['ALLOW_user_delete'] =   (in_array(113,$this->session->userdata('permissions_arr'))) ? 1 : 0;
		$data['ALLOW_pages_add'] =   (in_array(110,$this->session->userdata('permissions_arr'))) ? 1 : 0;
		

		//Bread crum
		$this->breadcrumbcomponent->add('Dashboard', base_url().'dashboard/dashboard');
		$this->breadcrumbcomponent->add('Manage Task', base_url().'coupons/manage-coupons');
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
		
		$project_task_arr = $this->mod_projects->get_project_task($project_id,$status);
		$data['assign_task_arr'] = $project_task_arr['project_task_arr'];
		$data['assign_task_count'] = $project_task_arr['project_task_count'];
		
		$get_total_task_timings = $this->mod_projects->get_total_task_timings($project_id);
		$data['total_task_time']=$get_total_task_timings['total_task_time'];
		$data['total_task_consumed_time']=$get_total_task_timings['total_task_consumed_time'];
		
		
		$data['download_csv']=1;
		$data['project_id']= $project_id;
		$data['project_name']= $project_task_arr['project_task_arr'][0]['project_title'];
		
		
		
		/*echo "<pre>";
		print_r( $data['assign_task_arr']);
		exit;*/
		
		
		$this->load->view('projects/manage_task',$data);
			
	}//end manage_project_task
	
	
	
	//Start tasks_report
	public function tasks_report(){
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(139,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if
		
		
		//Plugin Files Permission
		$data['PLUGIN_datagrid'] = 1;
		$data['PLUGIN_datepicker'] = 1;
		$data['PLUGIN_gcal'] = 1;
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
		//$this->breadcrumbcomponent->add('Manage Projects', base_url().'projects/manage-projects/');
		$this->breadcrumbcomponent->add('Start Tasks Report', base_url().'projects/manage-projects/tasks-report');
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
		
		
		$task_report_arr = $this->mod_projects->get_tasks_report();
		
		$data['task_report_arr'] = $task_report_arr;
		
		$data['search_date']=$this->input->post('search_date');
		
		/*echo "<pre>";
		print_r( $data['projects_report_arr']);
		exit;*/
		
		$this->load->view('projects/tasks_report',$data);
		
	}//End Start tasks_report
	
	
	//Hold tasks_report
	public function hold_tasks_report(){
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(139,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if
		
		
		//Plugin Files Permission
		$data['PLUGIN_datagrid'] = 1;
		$data['PLUGIN_datepicker'] = 1;
		$data['PLUGIN_gcal'] = 1;
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
	//	$this->breadcrumbcomponent->add('Manage Tasks', base_url().'projects/manage-projects/');
		$this->breadcrumbcomponent->add('Hold Tasks Report', base_url().'projects/manage-projects/tasks-report');
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
		
		
		$task_report_arr = $this->mod_projects->get_hold_tasks_report();
		
		$data['task_report_arr'] = $task_report_arr;
		
		$data['search_date']=$this->input->post('search_date');
		
		/*echo "<pre>";
		print_r( $data['projects_report_arr']);
		exit;*/
		
		$this->load->view('projects/hold_tasks_report',$data);
		
	}//End Hold tasks_report
	
	//Closed tasks_report
	public function closed_tasks_report(){
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(139,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if
		
		
		//Plugin Files Permission
		$data['PLUGIN_datagrid'] = 1;
		$data['PLUGIN_datepicker'] = 1;
		$data['PLUGIN_gcal'] = 1;
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
	//	$this->breadcrumbcomponent->add('Manage Tasks', base_url().'projects/manage-projects/');
		$this->breadcrumbcomponent->add('Closed Tasks Report', base_url().'projects/manage-projects/tasks-report');
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
		
		
		$task_report_arr = $this->mod_projects->get_closed_tasks_report();
		
		$data['task_report_arr'] = $task_report_arr;
		
		$data['search_date']=$this->input->post('search_date');
		
		/*echo "<pre>";
		print_r( $data['projects_report_arr']);
		exit;*/
		
		$this->load->view('projects/closed_tasks_report',$data);
		
	}//End Closed tasks_report
	
	
	
	//show_all_tasks
	public function show_all_tasks(){
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(140,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if
		
		//Plugin Files Permission
		$data['PLUGIN_datagrid'] = 1;
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
		$data['ALLOW_user_edit'] =   (in_array(112,$this->session->userdata('permissions_arr'))) ? 1 : 0;
		$data['ALLOW_user_delete'] =   (in_array(113,$this->session->userdata('permissions_arr'))) ? 1 : 0;
		$data['ALLOW_pages_add'] =   (in_array(110,$this->session->userdata('permissions_arr'))) ? 1 : 0;
		

		//Bread crum
		$this->breadcrumbcomponent->add('Dashboard', base_url().'dashboard/dashboard');
		$this->breadcrumbcomponent->add('Show All Tasks', base_url().'projects/manage-projects/show-all-tasks');
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
		
		$all_tasks_arr = $this->mod_projects->show_all_tasks();
		
		$data['all_tasks_arr'] = $all_tasks_arr['all_tasks_arr'];
		$data['all_tasks_count'] = $all_tasks_arr['all_tasks_count'];
		
		/*echo "<pre>";
		print_r($data['all_tasks_count']);
		exit;*/
		
		
		$this->load->view('projects/show_all_tasks',$data);
			
	}//end show_all_tasks
	
	
	//project_workspace
	public function project_workspace($project_id){
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(153,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if
		
		//Plugin Files Permission
		$data['PLUGIN_datagrid'] = 1;
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
		$this->breadcrumbcomponent->add('Manage Projects', base_url().'projects/manage-projects');
		$this->breadcrumbcomponent->add('Project workspace', base_url().'projects/manage-projects/show-all-tasks');
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
		
		$data['project_id']= $project_id;
		
		//Get Project Work space
		$get_project_workspace= $this->mod_projects->get_project_workspace($project_id);
		$data['project_workspace_arr'] = $get_project_workspace['project_workspace_arr'];
		$data['project_workspace_count'] = $get_project_workspace['project_workspace_count'];
		
		/*echo "<pre>";
		print_r($data['all_tasks_count']);
		exit;*/
		
		
		$this->load->view('projects/project_workspace',$data);
			
	}//end workspace
	
	//project_workspace_process
	public function project_workspace_process($project_id){
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(153,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if
		
			
			$project_work_space = $this->mod_projects->project_workspace($this->input->post(), $project_id);
			
			
			
			if($project_work_space && $project_work_space['error'] == ''){
				
				$this->session->set_flashdata('ok_message', 'Project Portfolio submitted  successfully.');
				return true;
				
			}else{
				
				
					$this->session->set_flashdata('err_message', $project_work_space['error']);
					return false;
			}//end if*/
			
	}//end project_workspace_process
	
	
	
	//Approve Task RAting
	public function approve_task_rating($task_id){
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(154,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if
		
			
			$approve_rating = $this->mod_projects->approve_task_rating($task_id);
			
			if($approve_rating && $approve_rating['error'] == ''){
				
				$this->session->set_flashdata('ok_message', 'Task Rating Approved Successfully.');
				redirect(base_url().'projects/manage-projects/assign-task-detail/'.$task_id);
				
				
			}else{
				
					$this->session->set_flashdata('err_message', 'Task Rating Not Approved.');
					redirect(base_url().'projects/manage-projects/assign-task-detail/'.$task_id);
			}//end if*/
			
	}//end Task rating approve
	
	
	
	//Not Approve Task Rating
	public function not_approve_task_rating($task_id){
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(154,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if
		
			
			$not_approve_rating = $this->mod_projects->disapprove_task_rating($task_id);
			
			if($not_approve_rating && $not_approve_rating['error'] == ''){
				
				$this->session->set_flashdata('ok_message', 'Task Rating Disapproved Successfully.');
				redirect(base_url().'projects/manage-projects/assign-task-detail/'.$task_id);
				
				
			}else{
				
					$this->session->set_flashdata('err_message', 'Task Rating Not Disapproved.');
					redirect(base_url().'projects/manage-projects/assign-task-detail/'.$task_id);
			}//end if*/
			
	}//end Task rating approve
	
	
	//important project
	public function important_project($project_id){
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(155,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if
		
			
			$important_project = $this->mod_projects->important_project($project_id);
			
			if($important_project && $important_project['error'] == ''){
				
				$this->session->set_flashdata('ok_message', 'Project Start added Successfully.');
				redirect(base_url().'projects/manage-projects');
				
				
			}else{
				
					$this->session->set_flashdata('err_message', 'Project Start not added.');
					redirect(base_url().'projects/manage-projects');
			}//end if*/
			
	}//end Task rating approve
	
	
	//important project
	public function unimportant_project($project_id){
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(155,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if
		
			
			$important_project = $this->mod_projects->unimportant_project($project_id);
			
			if($important_project && $important_project['error'] == ''){
				
				$this->session->set_flashdata('ok_message', 'Project Star empty Successfully.');
				redirect(base_url().'projects/manage-projects');
				
				
			}else{
				
					$this->session->set_flashdata('err_message', 'Project Star can not empty.');
					redirect(base_url().'projects/manage-projects');
			}//end if*/
			
	}//end Task rating approve
	
	
	
	//User Add Task
	public function user_add_task(){
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();
		
	    $project_id= $this->input->post('project_id');
		
		$err_msg = "";
		
		if(trim($this->input->post('title')) == ''){
			
			$err_msg.= ' Title cannot be empty.<br>';
			
		}//end if
		
		if(trim($this->input->post('end_date')) == ''){
			
			$err_msg.= ' Task End Date cannot be empty.<br>';
			
		}//end if
		
		if(trim($this->input->post('description')) == ''){
			
			$err_msg.= ' Task Description cannot be empty.<br>';
			
		}//end if
		
		if($err_msg !=''){

			$this->session->set_flashdata('err_message', $err_msg);
			redirect(base_url().'projects/manage-projects/project-detail/'.$project_id);
			
		}//end if($err_msg !='')

		$assign_task = $this->mod_projects->user_add_task($this->input->post());
		
		
		if($assign_task['already_start_task'] != ''){
					$this->session->set_flashdata('err_message', '- '.strip_tags($assign_task['already_start_task']));
					redirect(base_url().'projects/manage-projects/project-detail/'.$project_id);
					
		}
	
			if($assign_task && $assign_task['error'] == ''){
				
				$this->session->set_flashdata('ok_message', 'Task Assign successfully.');
				redirect(base_url().'projects/manage-projects/project-detail/'.$project_id);
				
			}else{
				
					$this->session->set_flashdata('err_message', 'Task cannot  Assign. Something went wrong, please try again.');
					redirect(base_url().'projects/manage-projects/project-detail/'.$project_id);
					
			
				
			}//end if
			
	}//end user_add_tas
	
	
	//inprogress Milestone
	public function inprogress_milestone($project_id,$milestone_id){
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(165,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if
		
			
			$inprogress_milestone = $this->mod_projects->inprogress_milestone($project_id,$milestone_id);
			
			if($inprogress_milestone){
				
				$this->session->set_flashdata('ok_message', 'Project Milestone Inprogress Successfully.');
				redirect(base_url().'projects/manage-projects/project-detail/'.$project_id);
				
				
			}else{
				
					$this->session->set_flashdata('err_message', 'Project Milestone can not Inprogress.');
					redirect(base_url().'projects/manage-projects/project-detail/'.$project_id);
			}
			
	}//end close_milestone
	
	
	
	
	//Close Milestone
	public function close_milestone($project_id,$milestone_id){
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(165,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if
		
			
			$close_milestone = $this->mod_projects->close_milestone($project_id,$milestone_id);
			
			if($close_milestone){
				
				$this->session->set_flashdata('ok_message', 'Project Milestone Closed Successfully.');
				redirect(base_url().'projects/manage-projects/project-detail/'.$project_id);
				
				
			}else{
				
					$this->session->set_flashdata('err_message', 'Project Milestone can not Closed.');
					redirect(base_url().'projects/manage-projects/project-detail/'.$project_id);
			}
			
	}//end close_milestone
	
	
	//reopen Milestone
	public function reopen_milestone($project_id,$milestone_id){
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(165,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if
		
			
			$reopen_milestone = $this->mod_projects->reopen_milestone($project_id,$milestone_id);
			
			if($reopen_milestone){
				
				$this->session->set_flashdata('ok_message', 'Project Milestone ReOpen Successfully.');
				redirect(base_url().'projects/manage-projects/project-detail/'.$project_id);
				
				
			}else{
				
					$this->session->set_flashdata('err_message', 'Project Milestone can not ReOpen.');
					redirect(base_url().'projects/manage-projects/project-detail/'.$project_id);
			}
			
	}//end reopen_milestone
	
	
	//payment_due
	public function payment_due($project_id){
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(166,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if
		
			
			$payment_due = $this->mod_projects->payment_due($project_id);
			
			if($payment_due){
				
				$this->session->set_flashdata('ok_message', 'Project Payment due Successfully.');
				redirect(base_url().'projects/manage-projects');
				
				
			}else{
				
					$this->session->set_flashdata('err_message', 'Project can not Payment due.');
					redirect(base_url().'projects/manage-projects');
			}
			
	}//end payment_due
	
	
	
		
	//payment_recieve
	public function payment_recieve($project_id){
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(166,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if
		
			
			$payment_recieve = $this->mod_projects->payment_recieve($project_id);
			
			if($payment_recieve){
				
				$this->session->set_flashdata('ok_message', 'Project Payment recieved Successfully.');
				redirect(base_url().'projects/manage-projects');
				
				
			}else{
				
					$this->session->set_flashdata('err_message', 'Project can not Payment recieve.');
					redirect(base_url().'projects/manage-projects');
			}
			
	}//end payment_recieve
	
	
	//load_more
	public function load_more($project_id){
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

	
			
	   $project_arr = $this->mod_projects->load_more($project_id);
	   
	   
	  $project_messages_arr = $project_arr['project_messages_result'];
	  
	  $project_messages_count= $project_arr['project_messages_count'];
	   
	   $project_messages_attachments = $this->mod_projects->get_message_attachments($project_id);
	   $project_message_attachment_arr = $project_messages_attachments;
	
	  for($i=0; $i<$project_messages_count; $i++){ 
	  
	   $msg_id =$project_messages_arr[$i]['id'];  
	   
	   ?>
	     
	  
      <div class="asdf" > 
                        <div class="well">
                        	<div class="row" >
                                <div class="col-md-2" style="border-right:1px solid #ccc;">
                                    
                                    <strong class="coltext3"><?php echo  $project_messages_arr[$i]['user'];?><br>
                                    <?php if($project_messages_arr[$i]['avatar_image'] !=""){ ?>    
                                    <div class="thumbnail" style="width: 30%;margin-bottom: 0px;">
        <img src="<?php echo USER_FOLDER.'/'.$project_messages_arr[$i]['admin_id'].'/'.stripslashes($project_messages_arr[$i]['avatar_image'])?>">	
                                        </div>
                                        
                                      <?php  } ?>  
                                       <?php if($project_messages_arr[$i]['user_role'] !=""){ ?>                                      
                                      (<?php echo  $project_messages_arr[$i]['user_role'];?>)
                                         
                                      <?php  } ?> 
                                         </strong>
                                        
                                         <br>
                                         <br> 
                                     <div id="jRate<?php echo $project_messages_arr[$i]['id']?>" style="height:33px;width: 100%;" title="Rating(<?php echo round($project_messages_arr[$i]['admin_rating'],2);?>)"></div>		 								
                                    <div class="text-small"> </div>
                                                                                
                                        <div class="text-small"> </div>
                                 
                                    
                                </div>
                                <div class="col-md-10">
                                
                                <div class="time_date pull-right">
                 
                                        <div class="time">
                                        <i class="fa fa-clock-o"></i>
                                        <span class="c_time"><?php echo date('d M, Y , g:i a',strtotime($project_messages_arr[$i]['created_date'])); ?></span>
                                        
                                        
                                        </div>
                                        
                                        
                                        
                                    </div>
                                
                                    <p><?php echo stripcslashes(strip_tags($project_messages_arr[$i]['message'],'<b><br><a>')) ?></p>
                                    
                                    <?php  if(count($project_message_attachment_arr[$project_messages_arr[$i]['id']]) > 0){ 
									
									for($j=0; $j<count($project_message_attachment_arr[$project_messages_arr[$i]['id']]); $j++){
									
									?>
                                    
                             <div class="col-md-2">              
                            <div class="thumbnail" style="width: 90px;height: 76px;">
                         
							<?php 
							
                             $ext = pathinfo($project_message_attachment_arr[$project_messages_arr[$i]['id']][$j], PATHINFO_EXTENSION) ;
                            
                            if($ext=='jpg' or $ext=='png') {?>
                             <a href="<?php echo MURL?>assets/project_attachments/<?php echo $project_id."/".$project_message_attachment_arr[$project_messages_arr[$i]['id']][$j] ?>" style="width: 139%;margin-left: -16px;" data-toggle="lightbox" data-gallery="multiimages" data-title="<?php echo $project_attachments_arr[$i]['title'] ?>" class="col-sm-4">
                             
                             <img src="<?php echo MURL?>assets/project_attachments/<?php echo $project_id."/".$project_message_attachment_arr[$project_messages_arr[$i]['id']][$j] ?>" data-src="holder.js/100%x180" data-holder-rendered="false" style="width: 86px;height: 65px;">
                             </a>
                            <?php }elseif($ext=='zip' or $ext=='rar'){ ?>
                              
                                <a class="anchor_style" href="<?php echo MURL?>assets/project_attachments/<?php echo $project_id."/".$project_message_attachment_arr[$project_messages_arr[$i]['id']][$j] ?>" target="_blank" download> <img src="<?php echo SURL?>assets/img/zip.png" style="height: 69px;" ></a>
                                
                                <?php }elseif($ext=='doc' or $ext=='docx'){ ?>
                              
                                <a class="anchor_style" href="<?php echo MURL?>assets/project_attachments/<?php echo $project_id."/".$project_message_attachment_arr[$project_messages_arr[$i]['id']][$j] ?>" target="_blank" download> <img src="<?php echo SURL?>assets/img/docx.png" style="height: 69px;" ></a>
                              
                            <?php }elseif($ext=='xlsx' or $ext=='xls'){ ?>
                              
                                <a class="anchor_style" href="<?php echo MURL?>assets/project_attachments/<?php echo $project_id."/".$project_message_attachment_arr[$project_messages_arr[$i]['id']][$j] ?>" target="_blank" download> <img src="<?php echo SURL?>assets/img/excel.png" style="height: 66px;" ></a>
                              
                            <?php }elseif($ext=='pptx' or $ext=='ppt'){ ?>
                              
                                <a class="anchor_style" href="<?php echo MURL?>assets/project_attachments/<?php echo $project_id."/".$project_message_attachment_arr[$project_messages_arr[$i]['id']][$j] ?>" target="_blank" download> <img src="<?php echo SURL?>assets/img/pptx.png" style="height: 69px;" ></a>
                              
                            <?php }elseif($ext=='odt'){ ?>
                              
                                <a class="anchor_style" href="<?php echo MURL?>assets/project_attachments/<?php echo $project_id."/".$project_message_attachment_arr[$project_messages_arr[$i]['id']][$j] ?>" target="_blank" download> <img src="<?php echo SURL?>assets/img/odt.png" style="height: 66px;" ></a>
                              
                            <?php }elseif($ext=='pdf'){ ?>
                              
                                <a class="anchor_style" href="<?php echo MURL?>assets/project_attachments/<?php echo $project_id."/".$project_message_attachment_arr[$project_messages_arr[$i]['id']][$j] ?>" target="_blank" download> <img src="<?php echo SURL?>assets/img/pdf.png" style="height: 69px;" ></a>        
                                <?php }elseif($ext=='txt'){ ?>
                              
                                <a class="anchor_style" href="<?php echo MURL?>assets/project_attachments/<?php echo $project_id."/".$project_message_attachment_arr[$project_messages_arr[$i]['id']][$j] ?>" target="_blank" download> <img src="<?php echo SURL?>assets/img/text.png" style="height: 69px;" ></a>        
                                <?php }elseif($ext=='tif'){ ?>
                              
                                <a class="anchor_style" href="<?php echo MURL?>assets/project_attachments/<?php echo $project_id."/".$project_message_attachment_arr[$project_messages_arr[$i]['id']][$j] ?>" target="_blank" download> <img src="<?php echo MURL?>assets/img/tiff2.png" style="height: 66px;" ></a>       
                                <?php }elseif($ext=='csv'){ ?>
                              
                                <a class="anchor_style" href="<?php echo MURL?>assets/project_attachments/<?php echo $project_id."/".$project_message_attachment_arr[$project_messages_arr[$i]['id']][$j] ?>" target="_blank" download> <img src="<?php echo SURL?>assets/img/csv.png" style="height: 66px;" ></a>       
                                <?php }  ?>
                                
                                
                              
                              
                            </div>
                            </div>
                           
                         
                              
                          <?php  
						  
						   }//End for loop
						  
						  
					      }//End if ?>
                                    
                                </div>
                            </div>
                        </div>
                        
                         </div>
                         
              
            </div>
      
      
	  <?php
	  
        $msg_id = $project_messages_arr[$i]['id'];   
	  
	  } 
	  
	  ?>
	  
	   <?php if(isset($msg_id) !=""){ ?>
	     
        <div class="show_more_main" id="show_more_main<?php echo $msg_id; ?>">
                
        <span id="<?php echo $msg_id; ?>" class="show_more" title="Load more posts">Show more</span>
        <span class="loding" style="display: none;"><span class="loding_txt">Loading...</span></span>  
		
			
<?php	} }//end load_more



	//send_message_process
	public function project_messages(){
		
		//echo $this->input->post('user_id_from');
		
		 $this->input->post('last_row_id');
		 
		$project_id= $this->input->post('project_id');
		 
		
		$this->mod_projects->project_messages($this->input->post());
		
		//$send_message_process = $this->mod_user->send_message_process($this->input->post());
		
		/*$project_arr = $this->mod_projects->get_autoload_latest_messages($this->input->post());
		
	    $project_messages_arr = $project_arr;
	  
	    $project_messages_count= count($project_arr);
	   
	    $project_messages_attachments = $this->mod_projects->get_message_attachments($project_id);
	    $project_message_attachment_arr = $project_messages_attachments;*/
		
 		 /*if($project_messages_count>0){
	  
	  
		?>  
		  
		<?php 
	
 		for($i=0; $i<$project_messages_count; $i++){
		
			$row_id = 'row_'.$i;
		
		 ?>

	<div class="asdf" > 
                        <div class="well">
                        	<div class="row" >
                                <div class="col-md-2" style="border-right:1px solid #ccc;">
                                    
                                    <strong class="coltext3"><?php echo  $project_messages_arr[$i]['user'];?><br>
                                    <?php if($project_messages_arr[$i]['avatar_image'] !=""){ ?>    
                                    <div class="thumbnail" style="width: 30%;margin-bottom: 0px;">
        <img src="<?php echo USER_FOLDER.'/'.$project_messages_arr[$i]['admin_id'].'/'.stripslashes($project_messages_arr[$i]['avatar_image'])?>">	
                                        </div>
                                        
                                      <?php  } ?>  
                                       <?php if($project_messages_arr[$i]['user_role'] !=""){ ?>                                      
                                      (<?php echo  $project_messages_arr[$i]['user_role'];?>)
                                         
                                      <?php  } ?> 
                                         </strong>
                                        
                                         <br>
                                         <br> 
                                     <div id="jRate<?php echo $project_messages_arr[$i]['id']?>" style="height:33px;width: 100%;" title="Rating(<?php echo round($project_messages_arr[$i]['admin_rating'],2);?>)"></div>		 								
                                    <div class="text-small"> </div>
                                                                                
                                        <div class="text-small"> </div>
                                 
                                    
                                </div>
                                <div class="col-md-10">
                                
                                <div class="time_date pull-right">
                 
                                        <div class="time">
                                        <i class="fa fa-clock-o"></i>
                                        <span class="c_time"><?php echo date('d M, Y , g:i a',strtotime($project_messages_arr[$i]['created_date'])); ?></span>
                                        
                                        
                                        </div>
                                        
                                        
                                        
                                    </div>
                                
                                    <p><?php echo stripcslashes(strip_tags($project_messages_arr[$i]['message'],'<b><br><a>')) ?></p>
                                    
                                    <?php  if(count($project_message_attachment_arr[$project_messages_arr[$i]['id']]) > 0){ 
									
									for($j=0; $j<count($project_message_attachment_arr[$project_messages_arr[$i]['id']]); $j++){
									
									?>
                                    
                             <div class="col-md-2">              
                            <div class="thumbnail" style="width: 90px;height: 76px;">
                         
							<?php 
							
                             $ext = pathinfo($project_message_attachment_arr[$project_messages_arr[$i]['id']][$j], PATHINFO_EXTENSION) ;
                            
                            if($ext=='jpg' or $ext=='png') {?>
                             <a href="<?php echo MURL?>assets/project_attachments/<?php echo $project_id."/".$project_message_attachment_arr[$project_messages_arr[$i]['id']][$j] ?>" style="width: 139%;margin-left: -16px;" data-toggle="lightbox" data-gallery="multiimages" data-title="<?php echo $project_attachments_arr[$i]['title'] ?>" class="col-sm-4">
                             
                             <img src="<?php echo MURL?>assets/project_attachments/<?php echo $project_id."/".$project_message_attachment_arr[$project_messages_arr[$i]['id']][$j] ?>" data-src="holder.js/100%x180" data-holder-rendered="false" style="width: 86px;height: 65px;">
                             </a>
                            <?php }elseif($ext=='zip' or $ext=='rar'){ ?>
                              
                                <a class="anchor_style" href="<?php echo MURL?>assets/project_attachments/<?php echo $project_id."/".$project_message_attachment_arr[$project_messages_arr[$i]['id']][$j] ?>" target="_blank" download> <img src="<?php echo SURL?>assets/img/zip.png" style="height: 69px;" ></a>
                                
                                <?php }elseif($ext=='doc' or $ext=='docx'){ ?>
                              
                                <a class="anchor_style" href="<?php echo MURL?>assets/project_attachments/<?php echo $project_id."/".$project_message_attachment_arr[$project_messages_arr[$i]['id']][$j] ?>" target="_blank" download> <img src="<?php echo SURL?>assets/img/docx.png" style="height: 69px;" ></a>
                              
                            <?php }elseif($ext=='xlsx' or $ext=='xls'){ ?>
                              
                                <a class="anchor_style" href="<?php echo MURL?>assets/project_attachments/<?php echo $project_id."/".$project_message_attachment_arr[$project_messages_arr[$i]['id']][$j] ?>" target="_blank" download> <img src="<?php echo SURL?>assets/img/excel.png" style="height: 66px;" ></a>
                              
                            <?php }elseif($ext=='pptx' or $ext=='ppt'){ ?>
                              
                                <a class="anchor_style" href="<?php echo MURL?>assets/project_attachments/<?php echo $project_id."/".$project_message_attachment_arr[$project_messages_arr[$i]['id']][$j] ?>" target="_blank" download> <img src="<?php echo SURL?>assets/img/pptx.png" style="height: 69px;" ></a>
                              
                            <?php }elseif($ext=='odt'){ ?>
                              
                                <a class="anchor_style" href="<?php echo MURL?>assets/project_attachments/<?php echo $project_id."/".$project_message_attachment_arr[$project_messages_arr[$i]['id']][$j] ?>" target="_blank" download> <img src="<?php echo SURL?>assets/img/odt.png" style="height: 66px;" ></a>
                              
                            <?php }elseif($ext=='pdf'){ ?>
                              
                                <a class="anchor_style" href="<?php echo MURL?>assets/project_attachments/<?php echo $project_id."/".$project_message_attachment_arr[$project_messages_arr[$i]['id']][$j] ?>" target="_blank" download> <img src="<?php echo SURL?>assets/img/pdf.png" style="height: 69px;" ></a>        
                                <?php }elseif($ext=='txt'){ ?>
                              
                                <a class="anchor_style" href="<?php echo MURL?>assets/project_attachments/<?php echo $project_id."/".$project_message_attachment_arr[$project_messages_arr[$i]['id']][$j] ?>" target="_blank" download> <img src="<?php echo SURL?>assets/img/text.png" style="height: 69px;" ></a>        
                                <?php }elseif($ext=='tif'){ ?>
                              
                                <a class="anchor_style" href="<?php echo MURL?>assets/project_attachments/<?php echo $project_id."/".$project_message_attachment_arr[$project_messages_arr[$i]['id']][$j] ?>" target="_blank" download> <img src="<?php echo MURL?>assets/img/tiff2.png" style="height: 66px;" ></a>       
                                <?php }elseif($ext=='csv'){ ?>
                              
                                <a class="anchor_style" href="<?php echo MURL?>assets/project_attachments/<?php echo $project_id."/".$project_message_attachment_arr[$project_messages_arr[$i]['id']][$j] ?>" target="_blank" download> <img src="<?php echo SURL?>assets/img/csv.png" style="height: 66px;" ></a>       
                                <?php }  ?>
                                
                                
                              
                              
                            </div>
                            </div>
                           
                         
                              
                          <?php  
						  
						   }//End for loop
						  
						  
					      }//End if ?>
                                    
                                </div>
                            </div>
                        </div>
                        
                     </div> 
     
     |
     
    <?php echo $project_messages_arr[0]['id'];?>
	   
		<?php
		
		
		 $msg_id =$project_messages_arr[$i]['id'];    
		  
	}//End for 
	
  }else{*/
	  
	//  echo "not";
	  
	//  }
  
	}//end send_message_process	
	
	
	 public function ajax_upload_message_attachments(){
		   
		
			//echo "<pre>"; print_r($data= $this->input->post());  exit;
			//$data['file']= $_FILE;
			//prining success message
		
			
			$get_record =  $this->mod_projects->ajax_upload_message_attachments($this->input->post());
			   
			//success message
			 if($get_record ){
				  
			 
			 echo json_encode(array("file_name"=>$get_record['file_name'],"file_id"=> $get_record['file_id']));
			   exit;			}else{
			//printing error for dropzone
            header('HTTP/1.1 500 Internal Server Error');
            header('Content-type: text/plain');
            echo 'ERROR FILE UPLOAD';
			exit;
			   }
		   
	   }
	   
	   
	 public function ajax_delete_itemimages() {
		
		
         $data['job_id'] = $this->input->post('job_id');
         $data['server_file_id']=$this->input->post('server_file_id');
		 $data['server_file_name']=$this->input->post('server_file_name');
            // dump($data);

        //$wheres = array('file_name' => $data['file'], 'job_id' => $data['job_id']);
        $this->mod_projects->delete_file($data );
        exit;
    }
	
	
	
	public function autoload(){
	
	
		
		$project_arr = $this->mod_projects->get_autoload_latest_messages($this->input->post());
		
	
	    $data['project_messages_arr'] = $project_arr;
	  
	    $data['project_messages_count']= count($project_arr);
	   
	    $data['project_messages_attachments'] = $this->mod_projects->get_message_attachments($project_id);
	    $data['project_message_attachment_arr'] = $project_messages_attachments;
		
		
		$data['project_id']= $this->input->post('project_id');
		
		
		$this->load->view('projects/autoload', $data);
		
		
	} //end index()	
	
	
	
	 //Upload Task
	public function upload_task(){
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(210,$this->session->userdata('permissions_arr'))){
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
		$this->breadcrumbcomponent->add('Upload Task', base_url().'coupons/manage-coupons/add-coupons');
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
		
		$projects_arr = $this->mod_projects->get_projects();
		$data['projects_arr'] = $projects_arr['projects_filter'];
		$data['projects_count'] = $projects_arr['projects_count'];
		
		$this->load->view('projects/upload_task',$data);
		
	}//End upload_task
	
	
	
	//upload_task
	public function upload_task_process(){
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(210,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if
		
		
			
			$upload_task = $this->mod_projects->upload_task($this->input->post());
			
			if($upload_task['error_msg'] != ''){
				
				
				$this->session->set_flashdata('err_message', $upload_task['error_msg']);
				redirect(base_url().'projects/manage-projects/upload-task');
				
			}
			
			
			if($upload_task){
				
				$this->session->set_flashdata('ok_message', 'Task Uploaded Successfully.');
				redirect(base_url().'projects/manage-projects/upload-task');
				
			}else{
				
				$this->session->set_flashdata('err_message', 'Task cannot Uploaded. Something went wrong, please try again.');
				redirect(base_url().'projects/manage-projects/upload-task');
			
				
			}//end if
			
	}//end upload_task_process
	
	
	
	public function download_csv($project_id) {
		
			$this->load->helper('url');
		
		   $file_contents = $this->mod_projects->download_csv_file($project_id);	
		
			//$file_contents = load_file_from_id($_GET['id']);
			$file_name = 'project_tasks'.time().'.csv';
		
			header("Content-type: text/csv");
			header("Content-Disposition: attachment; filename=$file_name");
			header("Pragma: no-cache");
			header("Expires: 0");
			
			echo $file_contents;
		
	}//end download csv
	
	
	//Ajax Response Users
	public function get_users_ajax(){
		
		//Users List 
		$get_users_name= $this->mod_projects->get_users_ajax($this->input->get('ids'));
		
		echo $get_users_name;

	
	}//end ajax get_users
	
	
	

}//end Dashboard 
