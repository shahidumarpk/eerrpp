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
		
		$fetch_nav_panel = $this->mod_common->fetch_admin_nav_panel();
		$data['nav_panel_arr'] = $fetch_nav_panel;
		
		//Permissions
		$data['ALLOW_user_edit'] =   (in_array(76,$this->session->userdata('permissions_arr'))) ? 1 : 0;
		$data['ALLOW_user_delete'] =   (in_array(77,$this->session->userdata('permissions_arr'))) ? 1 : 0;
		$data['ALLOW_pages_add'] =   (in_array(74,$this->session->userdata('permissions_arr'))) ? 1 : 0;
		$data['ALLOW_user_action'] =   (in_array(114,$this->session->userdata('permissions_arr'))) ? 1 : 0;
		$data['ALLOW_user_assign_team'] =   (in_array(127,$this->session->userdata('permissions_arr'))) ? 1 : 0;
		$data['ALLOW_user_assign_task'] =   (in_array(128,$this->session->userdata('permissions_arr'))) ? 1 : 0;
		
		$data['ALLOW_user_search_status'] =   (in_array(120,$this->session->userdata('permissions_arr'))) ? 1 : 0;
		$data['ALLOW_user_search_branch'] =   (in_array(121,$this->session->userdata('permissions_arr'))) ? 1 : 0;

		//Bread crum
		$this->breadcrumbcomponent->add('Dashboard', base_url().'dashboard/dashboard');
		$this->breadcrumbcomponent->add('Manage Projects', base_url().'coupons/manage-coupons');
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		$data['INC_header_script_top'] = $this->load->view('common/script_header',$data,true);
		$data['INC_header_script_footer'] = $this->load->view('common/script_footer',$data,true);
		$data['INC_top_header'] = $this->load->view('common/top_header','',true);
		$data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel',$data,true);
		$data['INC_footer'] = $this->load->view('common/footer','',true);
		$data['INC_breadcrum'] = $this->load->view('common/breadcrum','',true);
		
		$projects_arr = $this->mod_projects->get_projects();
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
		
		$data['INC_header_script_top'] = $this->load->view('common/script_header',$data,true);
		$data['INC_header_script_footer'] = $this->load->view('common/script_footer',$data,true);
		$data['INC_top_header'] = $this->load->view('common/top_header','',true);
		$data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel',$data,true);
		$data['INC_footer'] = $this->load->view('common/footer','',true);
		$data['INC_breadcrum'] = $this->load->view('common/breadcrum','',true);
		
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

		//Verify if Page is Accessable
		if(!in_array(74,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if
		
		$err_msg = '';

		if(trim($this->input->post('project_id')) == ''){
			
			$err_msg.= '- Subject cannot be empty.<br>';
			
		}//end if
		
		if(trim($this->input->post('project_subject')) == ''){
			
			$err_msg.= '- Title cannot be empty.<br>';
			
		}//end if
		
		if(trim($this->input->post('project_amount')) == ''){
			
			$err_msg.= '- Amount cannot be empty.<br>';
			
		}//end if
		
		if(trim($this->input->post('project_detail')) == ''){
			
			$err_msg.= '- Detail cannot be empty.<br>';
			
		}//end if
		
		if($err_msg !=''){

			$this->session->set_flashdata('err_message', $err_msg);
			redirect(base_url().'projects/manage_projects/add_project');
			
		}//end if($err_msg !='')

		
			//add Project
			$add_project = $this->mod_projects->add_project($this->input->post());
			
			if($add_project && $add_project['error'] == ''){
				
				$this->session->set_flashdata('ok_message', '- New Project added successfully.');
				redirect(base_url().'projects/manage-projects/add-project');
				
			}else{
				
				if($add_project['error'] != ''){
					$this->session->set_flashdata('err_message', '- Opps File can not uploaded due to Size Exceeded...! ');
					redirect(base_url().'projects/manage-projects/');
					
				}else{
					$this->session->set_flashdata('err_message', '- New Project cannot be added. Something went wrong, please try again.');
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
		
		$data['INC_header_script_top'] = $this->load->view('common/script_header',$data,true);
		$data['INC_header_script_footer'] = $this->load->view('common/script_footer',$data,true);
		$data['INC_top_header'] = $this->load->view('common/top_header','',true);
		$data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel',$data,true);
		$data['INC_footer'] = $this->load->view('common/footer','',true);
		$data['INC_breadcrum'] = $this->load->view('common/breadcrum','',true);
		
			
		$get_all_users = $this->mod_projects->get_all_users();
		$data['users_list_arr'] 	= $get_all_users['users_arr'];
		$data['users_list_count']	= $get_all_users['users_count'];
		
		
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
				
				$this->session->set_flashdata('ok_message', '-  Project Updated successfully.');
				redirect(base_url().'projects/manage-projects/edit-project/'.$this->input->post('id'));
				
			}else{
				
				if($update_project['error'] != ''){
					$this->session->set_flashdata('err_message', '- Opps File can not uploaded due to Size Exceeded...!');
					redirect(base_url().'projects/manage-projects/edit-project/'.$this->input->post('id'));
					
				}else{
					$this->session->set_flashdata('err_message', '- Project cannot be Updated. Something went wrong, please try again.');
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
				
				$this->session->set_flashdata('ok_message', '- Project Attachment Deleted successfully.');
				redirect(base_url().'projects/manage-projects/edit-project/'.$project_id);
				
			}else{
				
				if($delete_attachment['error'] != ''){
					$this->session->set_flashdata('err_message', '- '.strip_tags($add_new_user['error']));
					redirect(base_url().'projects/manage-projects/edit-project/'.$project_id);
					
				}else{
					$this->session->set_flashdata('err_message', '- Project Attachment cannot be Daleted. Something went wrong, please try again.');
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

		//Bread crum
		$this->breadcrumbcomponent->add('Dashboard', base_url().'dashboard/dashboard');
		$this->breadcrumbcomponent->add('Manage Projects', base_url().'projects/manage-projects');
		$this->breadcrumbcomponent->add('Project Detail', base_url().'cprojects/manage-projects/project_detail');
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
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
		
		$data['project_task_arr'] = $project_details['project_task_result'];
		
		$project_details = $this->mod_projects->project_detail($project_id);
		$data['project_details_arr'] = $project_details['project_details_result'];
	
		//Check if Project Exist
		if($project_details['error']){
			
			  $this->session->set_flashdata('err_message', '- Opps...! Project not found...!');
			
			  redirect(base_url().'projects/manage_projects');
			
		}
	
		
		$data['project_attachments_arr']= $project_details['project_attachments'];
		$data['project_attachments_count']= $project_details['project_attachments_count'];
		
		$data['project_assign_team'] = $project_details['project_assign_team'];
		$data['role'] = $project_details['role'];
		
		$data['project_id'] =$project_id;
		
	
		$this->load->view('projects/project_detail',$data);
		
	}//End Project_detail
	
	
	public function project_messages($project_id){
		
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(75,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if
		
			
			$project_messages = $this->mod_projects->project_messages($this->input->post());
			
			if($project_messages && $project_messages['error'] == ''){
				
				$this->session->set_flashdata('ok_message', '-Message send successfully.');
				redirect(base_url().'projects/manage_projects/project_detail/'.$project_id);
				
			}else{
				
				if($project_messages['error'] != ''){
					$this->session->set_flashdata('err_message', '- Opps File can not uploaded due to Size Exceeded...!');
					redirect(base_url().'projects/manage_projects/project_detail/'.$project_id);
					
				}else{
					$this->session->set_flashdata('err_message', '-Message cannot  send. Something went wrong, please try again.');
					redirect(base_url().'projects/manage_projects/project_detail/'.$project_id);
					
				}//end if
				
			}//end if
			
	}//end project_messages
	
	
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
				
				$this->session->set_flashdata('ok_message', '-Project Deleted successfully.');
				redirect(base_url().'projects/manage_projects/');
				
			}else{
				
				if($delete_projects['error'] != ''){
					$this->session->set_flashdata('err_message', '- '.strip_tags($add_new_user['error']));
					redirect(base_url().'projects/manage_projects/');
					
				}else{
					$this->session->set_flashdata('err_message', '-Project cannot  Deleted. Something went wrong, please try again.');
					redirect(base_url().'projects/manage_projects/');
					
				}//end if
				
			}//end if
			
	}//end Delete Projects
	

    //project Assign
	public function project_assign($project_id){
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(8,$this->session->userdata('permissions_arr'))){
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
		
		$data['INC_header_script_top'] = $this->load->view('common/script_header',$data,true);
		$data['INC_header_script_footer'] = $this->load->view('common/script_footer',$data,true);
		$data['INC_top_header'] = $this->load->view('common/top_header','',true);
		$data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel',$data,true);
		$data['INC_footer'] = $this->load->view('common/footer','',true);
		$data['INC_breadcrum'] = $this->load->view('common/breadcrum','',true);
		
		$get_all_users = $this->mod_projects->get_all_users();
		$data['users_list_arr'] 	= $get_all_users['users_arr'];
		$data['users_list_count']	= $get_all_users['users_count'];
		
		
		$data['project_id'] =$project_id;
		
		
		$this->load->view('projects/assign_project',$data);
		
	}//End assign_project
	
	
	
	public function project_assign_process(){
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(8,$this->session->userdata('permissions_arr'))){
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
				
				$this->session->set_flashdata('ok_message', '-Project Assign successfully.');
				redirect(base_url().'projects/manage_projects/');
				
			}else{
				
				if($assign_projects['error'] != ''){
					$this->session->set_flashdata('err_message', '- '.strip_tags($add_new_user['error']));
					redirect(base_url().'projects/manage_projects/');
					
				}else{
					$this->session->set_flashdata('err_message', '-Project cannot  Assign. Something went wrong, please try again.');
					redirect(base_url().'projects/manage_projects/');
					
				}//end if
				
			}//end if
			
	}//end assign_project_process
	
	
	
	
    //Assign Task
	public function assign_task($project_id){
		
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
		
		$data['INC_header_script_top'] = $this->load->view('common/script_header',$data,true);
		$data['INC_header_script_footer'] = $this->load->view('common/script_footer',$data,true);
		$data['INC_top_header'] = $this->load->view('common/top_header','',true);
		$data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel',$data,true);
		$data['INC_footer'] = $this->load->view('common/footer','',true);
		$data['INC_breadcrum'] = $this->load->view('common/breadcrum','',true);
	
		$data['project_id'] =$project_id;
		
		$this->load->view('projects/assign_task',$data);
		
	}//End assign_task
	
	
	
	public function assign_task_process(){
		
		
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(75,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if
		
		
		if(trim($this->input->post('title')) == ''){
			
			$err_msg.= '- Please Enter Title.<br>';
			
		}//end if
		
		if($err_msg !=''){

			$this->session->set_flashdata('err_message', $err_msg);
			redirect(base_url().'projects/manage-projects/assign-task/'.$this->input->post('project_id'));
			
		}//end if
			
			$assign_task = $this->mod_projects->assign_task($this->input->post());
			
			if($assign_task && $assign_task['error'] == ''){
				
				$this->session->set_flashdata('ok_message', '-Task Assign successfully.');
				redirect(base_url().'projects/manage_projects/');
				
			}else{
				
				if($assign_task['error'] != ''){
					$this->session->set_flashdata('err_message', '- '.strip_tags($add_new_user['error']));
					redirect(base_url().'projects/manage_projects/');
					
				}else{
					$this->session->set_flashdata('err_message', '-Task cannot  Assign. Something went wrong, please try again.');
					redirect(base_url().'projects/manage_projects/');
					
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
		$this->breadcrumbcomponent->add('Add Task', base_url().'coupons/manage-coupons');
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		$data['INC_header_script_top'] = $this->load->view('common/script_header',$data,true);
		$data['INC_header_script_footer'] = $this->load->view('common/script_footer',$data,true);
		$data['INC_top_header'] = $this->load->view('common/top_header','',true);
		$data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel',$data,true);
		$data['INC_footer'] = $this->load->view('common/footer','',true);
		$data['INC_breadcrum'] = $this->load->view('common/breadcrum','',true);
		
			
		$projects_arr = $this->mod_projects->get_projects_for_task();
		$data['projects_arr'] = $projects_arr['projects_arr'];
		$data['projects_count'] = $projects_arr['projects_count'];
		
		
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
		$this->breadcrumbcomponent->add('Manage Task', base_url().'coupons/manage-coupons');
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		$data['INC_header_script_top'] = $this->load->view('common/script_header',$data,true);
		$data['INC_header_script_footer'] = $this->load->view('common/script_footer',$data,true);
		$data['INC_top_header'] = $this->load->view('common/top_header','',true);
		$data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel',$data,true);
		$data['INC_footer'] = $this->load->view('common/footer','',true);
		$data['INC_breadcrum'] = $this->load->view('common/breadcrum','',true);
		
		$assign_task_arr = $this->mod_projects->get_assign_task();
		
		$data['assign_task_arr'] = $assign_task_arr['assign_task_filter'];
		$data['assign_task_count'] = $assign_task_arr['assign_task_count'];
		
		
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
				
				$this->session->set_flashdata('ok_message', '-Assign Task Updated successfully.');
				redirect(base_url().'projects/manage-projects/manage-task');
				
			}else{
				
				if($edit_assign_task['error'] != ''){
					$this->session->set_flashdata('err_message', '- '.strip_tags($add_new_user['error']));
					redirect(base_url().'projects/manage-projects/manage-task');
					
				}else{
					$this->session->set_flashdata('err_message', '-Task cannot  Updated. Something went wrong, please try again.');
					redirect(base_url().'projects/manage-projects/manage-task');
					
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
				
				$this->session->set_flashdata('ok_message', '-Task Attachment Deleted successfully.');
				redirect(base_url().'projects/manage-projects/edit-assign-task/'.$task_id);
				
			}else{
				
				if($delete_task_attach['error'] != ''){
					$this->session->set_flashdata('err_message', '- '.strip_tags($add_new_user['error']));
					redirect(base_url().'projects/manage-projects/edit-assign-task/'.$task_id);
					
				}else{
					$this->session->set_flashdata('err_message', '-Task Attachment cannot  Deleted. Something went wrong, please try again.');
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
				
				$this->session->set_flashdata('ok_message', '-Task Deleted successfully.');
				redirect(base_url().'projects/manage-projects/manage-task');
				
			}else{
				
				if($delete_task['error'] != ''){
					$this->session->set_flashdata('err_message', '- '.strip_tags($add_new_user['error']));
					redirect(base_url().'projects/manage-projects/manage-task');
					
				}else{
					$this->session->set_flashdata('err_message', '-Task  cannot  Deleted. Something went wrong, please try again.');
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
		$this->breadcrumbcomponent->add('Task Detail', base_url().'coupons/manage-coupons');
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		$data['INC_header_script_top'] = $this->load->view('common/script_header',$data,true);
		$data['INC_header_script_footer'] = $this->load->view('common/script_footer',$data,true);
		$data['INC_top_header'] = $this->load->view('common/top_header','',true);
		$data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel',$data,true);
		$data['INC_footer'] = $this->load->view('common/footer','',true);
		$data['INC_breadcrum'] = $this->load->view('common/breadcrum','',true);
		
		//$assign_task_arr = $this->mod_projects->get_assign_task();
		$assign_task_detail = $this->mod_projects->get_assign_task_detail($assign_task_id);
		
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
			
			if($update_task && $update_task['error'] == ''){
				
				$this->session->set_flashdata('ok_message', '-Task Updated successfully.');
				redirect(base_url().'projects/manage-projects/manage-task');
				
			}else{
				
				if($update_task['error'] != ''){
					$this->session->set_flashdata('err_message', '- '.strip_tags($add_new_user['error']));
					redirect(base_url().'projects/manage-projects/manage-task');
					
				}else{
					$this->session->set_flashdata('err_message', '-Task  cannot  Updated. Something went wrong, please try again.');
					redirect(base_url().'projects/manage-projects/manage-task');
					
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
		
		$data['INC_header_script_top'] = $this->load->view('common/script_header',$data,true);
		$data['INC_header_script_footer'] = $this->load->view('common/script_footer',$data,true);
		$data['INC_top_header'] = $this->load->view('common/top_header','',true);
		$data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel',$data,true);
		$data['INC_footer'] = $this->load->view('common/footer','',true);
		$data['INC_breadcrum'] = $this->load->view('common/breadcrum','',true);
		
		$data['project_id'] =$project_id;
		
		
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
				
				$this->session->set_flashdata('ok_message', '-Project Status Updated successfully.');
				redirect(base_url().'projects/manage-projects');
				
			}else{
				
				if($project_action['error'] != ''){
					$this->session->set_flashdata('err_message', '- '.strip_tags($add_new_user['error']));
					redirect(base_url().'projects/manage-projects');
					
				}else{
					$this->session->set_flashdata('err_message', '-Project Status cannot  Updated. Something went wrong, please try again.');
					redirect(base_url().'projects/manage-projects');
					
				}//end if
				
			}//end if
			
	}//end project_action
	
	
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
		
		$data['INC_header_script_top'] = $this->load->view('common/script_header',$data,true);
		$data['INC_header_script_footer'] = $this->load->view('common/script_footer',$data,true);
		$data['INC_top_header'] = $this->load->view('common/top_header','',true);
		$data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel',$data,true);
		$data['INC_footer'] = $this->load->view('common/footer','',true);
		$data['INC_breadcrum'] = $this->load->view('common/breadcrum','',true);
		
		$project_task_arr = $this->mod_projects->get_project_task($project_id,$status);
		
		$data['assign_task_arr'] = $project_task_arr['project_task_arr'];
		$data['assign_task_count'] = $project_task_arr['project_task_count'];
		
		/*echo "<pre>";
		print_r( $data['assign_task_arr']);
		exit;
		*/
		
		$this->load->view('projects/manage_task',$data);
			
	}//end manage_project_task
	
	
	public function process_projects_grid(){
		
		echo $this->mod_projects->get_filter_projects_grid_data();
		
	}//end 
	
	

}//end Dashboard 
