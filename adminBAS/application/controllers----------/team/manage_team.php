<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Manage_Team extends CI_Controller {

	public function __construct(){
		parent::__construct();

		$this->load->model('team/mod_team');
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
		if(!in_array(157,$this->session->userdata('permissions_arr'))){
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
		$this->breadcrumbcomponent->add('Manage Team', base_url().'cms/manage-user');
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
		$data['ALLOW_user_edit'] =   (in_array(159,$this->session->userdata('permissions_arr'))) ? 1 : 0;
		$data['ALLOW_user_delete'] =   (in_array(160,$this->session->userdata('permissions_arr'))) ? 1 : 0;
		$data['ALLOW_pages_add'] =   (in_array(158,$this->session->userdata('permissions_arr'))) ? 1 : 0;
	
		
		$get_all_teams = $this->mod_team->get_all_teams();
		$data['all_teams_arr'] = $get_all_teams['all_teams_arr'];
		$data['all_teams_count'] = $get_all_teams['all_teams_count'];
		
		/*echo "<pre>";
		print_r($get_all_teams);
		exit;*/
		
	 
		$this->load->view('team/manage_team',$data);
			
	}//end index()
	
	//Add team
	public function add_team(){
		
		$this->load->model('admin_roles/mod_admin_roles');
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(158,$this->session->userdata('permissions_arr'))){
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
		$this->breadcrumbcomponent->add('Manage Team', base_url().'team/manage-team');
		$this->breadcrumbcomponent->add('Add Team', base_url().'admin/manage-user/add-new-user');
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
		
		$get_admin_user = $this->mod_admin->get_admin_users_limit();
		$data['admin_user_list'] = $get_admin_user['admin_list_result'];
		$data['admin_user_list_count'] = $get_admin_user['admin_list_result_count'];
		
		$this->load->view('team/add_team',$data);
		
	}//add_team
	
	

	public function add_team_process(){
		
		//If Post is not SET
		if(!$this->input->post() && !$this->input->post('add_new_team_sbt')) redirect(base_url());
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(158,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if
		
		$err_msg = '';

		if(trim($this->input->post('team_title')) == ''){
			
			$err_msg.= ' Team Title cannot be empty.<br>';
			
		}//end if(trim($this->input->post('team_title')) == '')

		if(trim($this->input->post('team_head')) == ''){
			
			$err_msg.= ' Team Head cannot be empty.<br>';
			
		}//end if(trim($this->input->post('team_head')) == '')
		
		if(trim($this->input->post('branch_id')) == ''){
			
			$err_msg.= ' Branch Name cannot be empty.<br>';
			
		}//end if(trim($this->input->post('branch_id')) == '')

	
		if($err_msg !=''){

			$this->session->set_flashdata('err_message', $err_msg);
			redirect(base_url().'team/manage-team/add-team');
			
		}//end if($err_msg !='')

			
			//Add New Team	
			$add_team = $this->mod_team->add_team($this->input->post());
			
			if($add_team && $add_team['error'] == ''){
				
				$this->session->set_flashdata('ok_message', ' New Team added successfully.');
				redirect(base_url().'team/manage-team ');
				
			}else{
					$this->session->set_flashdata('err_message', ' New Team cannot be added. Something went wrong, please try again.');
					redirect(base_url().'team/manage-team/add-team');
					
			}//end if($add_team['error'] != '')
				
		
	}//end add_team_process
	
	

	//edit Team
	public function edit_team($team_id){
		
		$this->load->model('admin_roles/mod_admin_roles');
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(159,$this->session->userdata('permissions_arr'))){
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
		$this->breadcrumbcomponent->add('Manage Team', base_url().'team/manage-team');
		$this->breadcrumbcomponent->add('Edit Team', base_url().'admin/manage-user/edit-user/'.$admin_id);
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
		
		
		$get_team = $this->mod_team->get_team($team_id);
		$data['team_arr'] = $get_team['team_arr'];
		$data['team_count'] = $get_team['team_count'];
		
	
		//Get All Branches
		$get_all_branches = $this->mod_admin->get_all_branches();
		$data['branches_arr'] = $get_all_branches['branches_arr'];
		$data['branches_count'] = $get_all_branches['branches_count'];
		
		$get_admin_user = $this->mod_admin->get_admin_users_limit();
		$data['admin_user_list'] = $get_admin_user['admin_list_result'];
		$data['admin_user_list_count'] = $get_admin_user['admin_list_result_count'];
		
		if($get_team['team_count'] == 0) redirect(base_url());
		
		$data['team_id']= $team_id;
		
		$this->load->view('team/edit_team',$data);
		
	}//edit_team
	
	

	public function edit_team_process(){
		
	
		//If Post is not SET
		if(!$this->input->post() && !$this->input->post('edit_team_sbt')) redirect(base_url());
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(159,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if
		
		
		$team_id = $this->input->post('team_id');

		$err_msg = '';
		
		if(trim($this->input->post('team_title')) == ''){
			
			$err_msg.= ' Team Title cannot be empty.<br>';
			
		}//end if(trim($this->input->post('team_title')) == '')

		if(trim($this->input->post('team_head')) == ''){
			
			$err_msg.= ' Team Head cannot be empty.<br>';
			
		}//end if(trim($this->input->post('team_head')) == '')
		
		if(trim($this->input->post('branch_id')) == ''){
			
			$err_msg.= ' Branch Name cannot be empty.<br>';
			
		}//end if(trim($this->input->post('branch_id')) == '')

	
		if($err_msg !=''){

			$this->session->set_flashdata('err_message', $err_msg);
			redirect(base_url().'team/manage-team/edit-team/'.$team_id);
			
		}//end if($err_msg !='')

	

		//Updating Admin Data
		$upd_team = $this->mod_team->edit_team($this->input->post());
		
		if($upd_team && $upd_team['error'] == ''){
			
			$this->session->set_flashdata('ok_message', ' Team record updated successfully.');
			redirect(base_url().'team/manage-team/edit-team/'.$team_id);
			
		}else{

				$this->session->set_flashdata('err_message', ' Team record cannot be updated. Something went wrong, please try again.');
				redirect(base_url().'team/manage-team/edit-team/'.$team_id);
				
		
		}//end if($add_cms_page)

	}//end edit_team_process
	
	
	
	//Delete Team
	public function delete_team($team_id){
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(160,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if

		//If Post is not SET
		if(!isset($team_id)) redirect(base_url());
		
		
		$del_team = $this->mod_team->delete_team($team_id);
		
		if($del_team){
			
			$this->session->set_flashdata('ok_message', ' Team deleted successfully.');
			redirect(base_url().'team/manage-team');
			
		}else{
			$this->session->set_flashdata('err_message', ' Team cannot be deleted. Something went wrong, please try again.');
			redirect(base_url().'team/manage-team');
			
		}//end if($del_team)

	}//end delete_team


	//My Team
	public function my_team(){
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(161,$this->session->userdata('permissions_arr'))){
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
		
		
		$my_team = $this->mod_team->get_my_team();
		
		$data['my_team_arr'] = $my_team['all_teams_filter'];
		$data['my_team_count'] = $my_team['all_teams_count'];
		
		
		$this->load->view('team/my_team',$data);
		
	}//my_team

}//end Dashboard 
