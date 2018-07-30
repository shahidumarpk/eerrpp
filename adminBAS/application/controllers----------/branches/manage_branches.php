<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Manage_Branches extends CI_Controller {
	
	public function __construct(){
		parent::__construct();

		$this->load->model('admin/mod_admin');
		$this->load->model('branches/mod_branches');
		$this->load->model('common/mod_common');
		$this->load->library('BreadcrumbComponent');
		
	}

	public function index(){
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();
		
		//Verify if Page is Accessable
		if(!in_array(116,$this->session->userdata('permissions_arr'))){
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
		$this->breadcrumbcomponent->add('Manage Branches', base_url().'branches/manage-branches');
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
		$data['ALLOW_pages_add'] =   (in_array(117,$this->session->userdata('permissions_arr'))) ? 1 : 0;
		$data['ALLOW_pages_edit'] =   (in_array(118,$this->session->userdata('permissions_arr'))) ? 1 : 0;
		$data['ALLOW_pages_delete'] =   (in_array(119,$this->session->userdata('permissions_arr'))) ? 1 : 0;
		

		//Fetching Branches
		$get_branches = $this->mod_branches->get_all_branches();

		$data['branches_arr'] = $get_branches['branches_arr'];
		$data['branches_count'] = $get_branches['branches_count'];
		
		$this->load->view('branches/manage_branches',$data);
		
	}//end index()
	
	//Add New Branch
	public function add_branch(){
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();
		
		//Verify if Page is Accessable
		if(!in_array(117,$this->session->userdata('permissions_arr'))){
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
		$this->breadcrumbcomponent->add('Manage Branches', base_url().'branches/manage-branches');
		$this->breadcrumbcomponent->add('Add New Branch', base_url().'branches/manage-branches/add-branch');
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
		
		$this->load->view('branches/add_branch',$data);
		
	}//add_new_advetisement

	public function add_branch_process(){
		
		
		//If Post is not SET
		if(!$this->input->post() && !$this->input->post('add_branch')) redirect(base_url());
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(117,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if
		
		
		if(trim($this->input->post('branch_name')) == ''){
			
			$err_msg.= '- Branch Name cannot be empty.<br>';
			
		}//end if
		
		if($err_msg !=''){

			$this->session->set_flashdata('err_message', $err_msg);
			redirect(base_url().'branches/manage-branches/add-branch');
			
		}//end if($err_msg !='')
		
		
		//Adding New Branch
		$add_branch = $this->mod_branches->add_branch($this->input->post());

		if($add_branch && $add_branch['error'] == ''){		
			
			$this->session->set_flashdata('ok_message', '- New Branch added successfully.');
			redirect(base_url().'branches/manage-branches/add-branch');
			
		}else{
			
			if($add_branch['error'] != ''){

				$this->session->set_flashdata('err_message', '- '.strip_tags($add_slider_image['error']));
				redirect(base_url().'branches/manage-branches/add-branch');
				
			}else{
				$this->session->set_flashdata('err_message', '- New Branch is not Added. Something went wrong, please try again.');
				redirect(base_url().'branches/manage-branches/add-branch');
				
			}//end if
			
		}//end if

	}//end

	
	
	//Edit Branch
	public function edit_branch($branch_id){

		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(118,$this->session->userdata('permissions_arr'))){
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
		$this->breadcrumbcomponent->add('Manage Branches', base_url().'branches/manage-branches');
		$this->breadcrumbcomponent->add('Edit Branch', base_url().'branches/manage-branches/edit-branch/'.$branch_id);
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
		$get_branch = $this->mod_branches->get_branch($branch_id);
		$data['branch_arr'] = $get_branch['branch_arr'];
		$data['branch_count'] = $get_branch['branch_count'];
		$data['branch_id']= $branch_id;
		
		if($get_branch['branch_count'] == 0) redirect(base_url());
		
		$this->load->view('branches/edit_branch',$data);
		
	}//edit_branch
	

	public function edit_branch_process(){
		
		//If Post is not SET
		if(!$this->input->post() && !$this->input->post('edit_branch')) redirect(base_url());
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(118,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if

		//Updating record
		$upd_branch = $this->mod_branches->edit_branch($this->input->post());
		
		if($upd_branch && $upd_branch['error'] == ''){	
			
			$this->session->set_flashdata('ok_message', '- Branch updated successfully.');
			redirect(base_url().'branches/manage-branches/');
			
		}else{

			if($upd_branch['error'] != ''){

				$this->session->set_flashdata('err_message', '- '.strip_tags($upd_slider_image['error']));
				redirect(base_url().'branches/manage-branches/');
				
			}else{
				
				$this->session->set_flashdata('err_message', '- Branches is not updated. Something went wrong, please try again.');
				redirect(base_url().'branches/manage-branches/');

			}//end if
			
		}//end if

	}//end edit_branch_process
	
	public function delete_branch($branch_id){
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(119,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if
		
		//If Post is not SET
		if(!isset($branch_id)) redirect(base_url());
	
		$del_branch = $this->mod_branches->delete_branch($branch_id);
		
		if($del_branch){
			
			$this->session->set_flashdata('ok_message', '- Branch deleted successfully.');
			redirect(base_url().'branches/manage-branches/');
			
		}else{
			$this->session->set_flashdata('err_message', '- Branch cannot be deleted. Something went wrong, please try again.');
			redirect(base_url().'branches/manage-branches');
			
		}//end if

	}//end delete_branch

}//end Dashboard 
