<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Manage_Projects extends CI_Controller {

	public function __construct(){
		parent::__construct();

		$this->load->model('common/mod_common');
		$this->load->model('projects/mod_projects');
		$this->load->model('customers/mod_customer');
		$this->load->library('BreadcrumbComponent');
		$this->load->model('employee/mod_employee');
	}

	public function index(){
		
		//Login Check
		$this->mod_customer->verify_is_customer_login();
	
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
		$this->breadcrumbcomponent->add('Manage Projects', base_url().'coupons/manage-coupons');
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		$data['INC_header_script_top'] = $this->load->view('common/script_header',$data,true);
		$data['INC_header_script_footer'] = $this->load->view('common/script_footer',$data,true);
		$data['INC_top_header'] = $this->load->view('common/top_header','',true);
		$data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel',$data,true);
		$data['INC_footer'] = $this->load->view('common/footer','',true);
		$data['INC_breadcrum'] = $this->load->view('common/breadcrum','',true);
		
		$projects_arr = $this->mod_projects->get_projects();
		$data['projects_arr'] = $projects_arr['projects_arr'];
		$data['projects_count'] = $projects_arr['projects_count'];
		
		//GET Projects Protfolio
		$projects_portfolio_arr = $this->mod_projects->get_projects_portfolio();
		$data['projects_portfolio_arr'] = $projects_portfolio_arr['projects_portfolio_arr'];
		$data['projects_portfolio_count'] = $projects_portfolio_arr['projects_portfolio_count'];
		
		/*echo "<pre>";
		print_r($data['projects_portfolio_count']);
		exit;*/
		
		$this->load->view('projects/manage_projects',$data);
			
	}//end index()
	
	
	//project Detail
	public function project_detail($project_id){
		
		//Login Check
		$this->mod_customer->verify_is_customer_login();
				
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
		$this->breadcrumbcomponent->add('Manage Project', base_url().'projects/manage-projects');
		$this->breadcrumbcomponent->add('Project Detail', base_url().'coupons/manage-coupons/add-coupons');
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
		
		$data['user_name'] = $project_details['user_name'];
		
		//$data['project_id'] =$project_id;
		//////////////////////////////////////////////////////
		
		
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
			
			  $this->session->set_flashdata('err_message', ' Opps...! Project not found...!');
			
			  redirect(base_url().'projects/manage_projects');
			
		}
	
		
		$data['project_attachments_arr']= $project_details['project_attachments'];
		$data['project_attachments_count']= $project_details['project_attachments_count'];
		
		$data['project_assign_team'] = $project_details['project_assign_team'];
		$data['role'] = $project_details['role'];
		
		$data['project_id'] =$project_id;
		
		//////////////////////////////////////////////////
		/*$project_details = $this->mod_projects->project_detail($project_id);
		
		$data['project_details_arr'] = $project_details['project_details_result'];
		$data['project_id'] =$project_id;
		
		//Check if Project Exist
		if($project_details['error']){
			
			  $this->session->set_flashdata('err_message', '- Opps...! Project not found...!');
			
			  redirect(base_url().'projects/manage_projects');
			
		}*/
		
		//Get project_milestones
		$get_project_milestones= $this->mod_projects->get_project_milestones($project_id);
		$data['project_milestones_arr'] = $get_project_milestones['project_milestones_arr'];
		$data['project_milestones_count'] = $get_project_milestones['project_milestones_count'];
	
		$this->load->view('projects/project_detail',$data);
		
	}//End Inbox
	
	
	public function project_messages($project_id){
		
		//Login Check
		$this->mod_customer->verify_is_customer_login();
		
		
			$project_messages = $this->mod_projects->project_messages($this->input->post());
			
			if($project_messages && $project_messages['error'] == ''){
				
				$this->session->set_flashdata('ok_message', ' Message send successfully.');
				redirect(base_url().'projects/manage_projects/project_detail/'.$project_id);
				
			}else{
				
				if($project_messages['error'] != ''){
					$this->session->set_flashdata('err_message', 'Opps File can not uploaded...!');
					redirect(base_url().'projects/manage_projects/project_detail/'.$project_id);
					
				}else{
					$this->session->set_flashdata('err_message', 'Message cannot  send. Something went wrong, please try again.');
					redirect(base_url().'projects/manage_projects/project_detail/'.$project_id);
					
				}//end if
				
			}//end if
			
	}//end project_messages
	
	
	//project_workspace
	public function project_workspace($project_id){
		
		//Login Check
    	$this->mod_customer->verify_is_customer_login();

		
		
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
		$this->mod_customer->verify_is_customer_login();

		
			$project_work_space = $this->mod_projects->project_workspace($this->input->post(), $project_id);
			
			
			
			if($project_work_space && $project_work_space['error'] == ''){
				
				$this->session->set_flashdata('ok_message', 'Project Portfolio submitted  successfully.');
				return true;
				
			}else{
				
				
					$this->session->set_flashdata('err_message', $project_work_space['error']);
					return false;
			}//end if*/
			
	}//end project_workspace_process
	
	
	 //project Assign
	public function project_assign($project_id){
		
		//Login Check
		$this->mod_customer->verify_is_customer_login();

	
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
		
		$customers_list_arr = $this->mod_employee->get_all_employees();
		$data['customers_arr'] = $customers_list_arr['customers_list_arr'];
		$data['customers_count'] = $customers_list_arr['customers_list_count'];
		
	//	$get_assign_team = $this->mod_employee->get_assign_team($project_id);
		$data['assign_team_arr'] 	= $get_assign_team;
		
		/*echo "<pre>";
		print_r($data['assign_team_arr'] );
		exit;*/
		
		
		$data['project_id'] =$project_id;
		
		
		$this->load->view('projects/assign_project',$data);
		
	}//End assign_project
	
	
	public function project_assign_process(){
		
			//Login Check
			$this->mod_customer->verify_is_customer_login();

			$assign_projects = $this->mod_projects->project_assign($this->input->post());
			
			if($assign_projects && $assign_projects['error'] == ''){
				
				$this->session->set_flashdata('ok_message', 'Project Assign successfully.');
				redirect(base_url().'projects/manage-projects/');
				
			}else{
				
				if($assign_projects['error'] != ''){
					$this->session->set_flashdata('err_message', '- '.strip_tags($add_new_user['error']));
					redirect(base_url().'projects/manage-projects/');
					
				}else{
					$this->session->set_flashdata('err_message', 'Project cannot  Assign. Something went wrong, please try again.');
					redirect(base_url().'projects/manage-projects/');
					
				}//end if
				
			}//end if
			
	}//end assign_project_process
	
	

}//end Dashboard 
