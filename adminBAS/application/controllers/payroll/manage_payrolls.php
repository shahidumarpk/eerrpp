<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Manage_PayRolls extends CI_Controller {
	
	public function __construct(){
		parent::__construct();

		$this->load->model('admin/mod_admin');
		$this->load->model('payroll/mod_payrolls');
		$this->load->model('messages/mod_messages');
		$this->load->model('common/mod_common');
		$this->load->model('site_preferences/mod_preferences');
		$this->load->library('BreadcrumbComponent');
		
	}

	public function index(){
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();
		
		//Verify if Page is Accessable
		if(!in_array(204,$this->session->userdata('permissions_arr'))){
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
		$this->breadcrumbcomponent->add('Manage PayRolls', base_url().'payrolls/manage-payrolls');
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
		$data['ALLOW_pages_add'] =   (in_array(201,$this->session->userdata('permissions_arr'))) ? 1 : 0;
		$data['ALLOW_pages_edit'] =   (in_array(205,$this->session->userdata('permissions_arr'))) ? 1 : 0;
		$data['ALLOW_pages_delete'] =   (in_array(206,$this->session->userdata('permissions_arr'))) ? 1 : 0;
		

		//Fetching Payrolls
		
		$get_payrolls = $this->mod_payrolls->get_all_payrolls();
			
		$data['payroll_get_arr']=$get_payrolls['payroll_arr_res'];
		$data['payroll_get_count']=$get_payrolls['payroll_count_res'];
		
	
//HA//		$data['total_balance'] = $get_cashes['cashs_arr']['total_balance'];
		
		$this->load->view('payroll/payroll_entry',$data);
		
	}//end index()
	
	
	
	
	
	
	
	
	
		public function process_payroll_grid(){
		
		echo $this->mod_cashs->get_filter_cash_grid_data();
		
	}//end 
	
	
	
	//Add New PayRoll
	public function add_payroll_entry($type){
		
		
	
		//Login Check
		$this->mod_admin->verify_is_admin_login();
	
		//Verify if Page is Accessable
		if(!in_array(200,$this->session->userdata('permissions_arr'))){
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
	// Checking Transaction Type
	$payroll_type_text = 'Add Fine';
		
		if($type == 'tardy') {
			
			$payroll_type_text = 'Add Tardy';
		}
		else
		if($type == 'incentive') {
			
			$payroll_type_text = 'Add Incentive';
		}
	$data['type'] = $type;
		//Bread crum
		$this->breadcrumbcomponent->add('Dashboard', base_url().'dashboard/dashboard');
		$this->breadcrumbcomponent->add('Manage PayRoll', base_url().'payroll/manage-payrolls');
		
		
		
		
		//$data['payroll_type_text']=$payroll_type_text;
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
		
		$this->breadcrumbcomponent->add($payroll_type_text, base_url().'payroll/manage-payrolls/add-payroll-entry'.$type);
		
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
	
		$data['INC_header_script_top'] = $this->load->view('common/script_header',$data,true);
		$data['INC_header_script_footer'] = $this->load->view('common/script_footer',$data,true);
		$data['INC_top_header'] = $this->load->view('common/top_header','',true);
		$data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel',$data,true);
		$data['INC_footer'] = $this->load->view('common/footer','',true);
		$data['INC_breadcrum'] = $this->load->view('common/breadcrum','',true);
	// Getting All users
$get_all_users = $this->mod_payrolls->get_admin_user_data();
		$data['admin_user_arr'] 	= $get_all_users['admin_user_arr'];
		$data['admin_user_count']	= $get_all_users['admin_user_count'];
		
		
	
		$this->load->view('payroll/add_payroll_entry',$data);
	
	}
	
	public function add_payroll_entry_process(){
	
		//If Post is not SET
		if(!$this->input->post() && !$this->input->post('add_payroll')) redirect(base_url());
	
		//Login Check
		$this->mod_admin->verify_is_admin_login();
	
		//Verify if Page is Accessable
		if(!in_array(201,$this->session->userdata('permissions_arr'))){
				
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if
	

	
	
	$data=$this->input->post();
		//Adding New payroll
		$add_payroll = $this->mod_payrolls->payrolls_in_process($data);
		$notify_payroll= $this->mod_messages->payrolls_notification($data);
		
	// Will we Add these condition to below checks >??
	//&&($notify_payroll && $notify_payroll['error'] == ''))
	//&&($notify_payroll['error']!='')
		if($add_payroll && $add_payroll['error'] == ''){
			
			$this->session->set_flashdata('ok_message', ' New transaction has been added and Notification sent successfully.');
			redirect(base_url().'payroll/manage-payrolls');
				
		}else{
				
			if($add_payroll['error'] != ''){
	
				$this->session->set_flashdata('err_message', '- '.strip_tags($error['error']));
				redirect(base_url().'payroll/manage-payrolls');
	
			}else{
				$this->session->set_flashdata('err_message', ' New PayRoll is not Added. Something went wrong, please try again.');
				redirect(base_url().'payroll/manage-payrolls');
	
			}//end if
				
		}//end if
	
	}//end
	
	//Edit PayRoll
	public function edit_payroll_entry($transact_id){

		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(205,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if

		//Plugin Files Permission
		$data['PLUGIN_datagrid'] = 0;
		$data['PLUGIN_datepicker'] = 1;
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
		$this->breadcrumbcomponent->add('Manage PayRolls', base_url().'payroll/manage-payrolls');
		$this->breadcrumbcomponent->add('Edit PayRoll', base_url().'payroll/manage-payrolls/edit-payroll/'.$transact_id);
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
		
		//Fetching PayRoll Results
		$get_payroll = $this->mod_payrolls->get_payroll($transact_id);
		
				
		$data['payroll_arr'] = $get_payroll['payroll1_all_arr'];
		$data['payroll_count'] = $get_payroll['payroll1_all_count'];
		
		


		//Fetching All PayRoll Users Results 
				$get_all_users = $this->mod_payrolls->get_admin_user_data();
		$data['admin_user_arr'] 	= $get_all_users['admin_user_arr'];
		$data['admin_user_count']	= $get_all_users['admin_user_count'];

//HA
	/*	$data['cash_id']= $cash_id;*/
		
		
	
		
		$this->load->view('payroll/edit_payroll_entry',$data);
		
	}//edit_PayRoll

	public function edit_payroll_entry_process(){
		
		//echo '<pre>';
		//print_r($this->input->post());
		//exit;
		
		//If Post is not SET
		if(!$this->input->post() && !$this->input->post('update_payroll')) redirect(base_url());
		
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(205,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if





		//Updating record
		$upd_payroll = $this->mod_payrolls->edit_payroll_process($this->input->post());
		
	// Checking $upd_payRoll Result
		if($upd_payroll && $upd_payroll['error'] == ''){	
			
			$this->session->set_flashdata('ok_message', '- PayRoll updated successfully.');
			redirect(base_url().'payroll/manage-payrolls');
			
		}else{

			if($upd_cash['error'] != ''){

				$this->session->set_flashdata('err_message', '- '.strip_tags($upd_slider_image['error']));
				redirect(base_url().'payroll/manage-payrolls');
				
			}else{
				
				$this->session->set_flashdata('err_message', '- PayRoll is not updated. Something went wrong, please try again.');
				redirect(base_url().'payroll/manage-payrolls');

			}//end if
			
		}//end if

	}//end edit_payroll_process
	
	
		public function delete_payroll_entry($page_id){
		//Login Check
	
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(206,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if
		
		//If Post is not SET
		if(!isset($page_id)) redirect(base_url());
	
		$del_trans = $this->mod_payrolls->delete_payroll_data($page_id);
		
		if($del_trans){
			
			$this->session->set_flashdata('ok_message', '- PayRoll deleted successfully.');
			redirect(base_url().'payroll/manage-payrolls');
			
		}else{
			$this->session->set_flashdata('err_message', '- PayRoll cannot be deleted. Something went wrong, please try again.');
			redirect(base_url().'payroll/manage-payrolls');
			
		}//end if

	}//end delete_PayRoll
	
	
	
}//end Dashboard 
