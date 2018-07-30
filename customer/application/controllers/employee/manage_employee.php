<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Manage_Employee extends CI_Controller {

	public function __construct(){

		parent::__construct();
		$this->load->model('employee/mod_employee');
		$this->load->model('customers/mod_customer');
		$this->load->model('common/mod_common');
		$this->load->library('BreadcrumbComponent');
		ini_set('memory_limit', "256M");
		
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
		$this->breadcrumbcomponent->add('Manage Sub Users', base_url().'employee/manage-employee');
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
		
		
		$this->load->view('employee/manage_employee',$data);
			
	}//end index()
	
	//Add New Employee
	public function add_employee(){
		
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
		$this->breadcrumbcomponent->add('Manage Sub Users', base_url().'employee/manage-employee');
		$this->breadcrumbcomponent->add('Add Sub User', base_url().'employee/manage-employee');
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		$data['INC_header_script_top'] = $this->load->view('common/script_header',$data,true);
		$data['INC_header_script_footer'] = $this->load->view('common/script_footer',$data,true);
		$data['INC_top_header'] = $this->load->view('common/top_header','',true);
		$data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel',$data,true);
		$data['INC_footer'] = $this->load->view('common/footer','',true);
		$data['INC_breadcrum'] = $this->load->view('common/breadcrum','',true);
		
		
		$this->load->view('employee/add_employee',$data);
		
	}//add_employee

	public function add_employee_process(){
		
		
		//If Post is not SET
		if(!$this->input->post() && !$this->input->post('add_new_employee_sbt')) redirect(base_url());
		
		//Login Check
		$this->mod_customer->verify_is_customer_login();

		$err_msg = '';

		if(trim($this->input->post('first_name')) == ''){
			
			$err_msg.= '- First Name cannot be empty.<br>';
			
		}//end if(trim($this->input->post('page_title')) == '')

		if(trim($this->input->post('last_name')) == ''){
			
			$err_msg.= '- Last Name cannot be empty.<br>';
			
		}//end if(trim($this->input->post('page_title')) == '')
		
		if(trim($this->input->post('username')) == ''){
			
			$err_msg.= '- Username cannot be empty.<br>';
			
		}//end if(trim($this->input->post('username')) == '')

		if(trim($this->input->post('email_address')) == ''){
			
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
			redirect(base_url().'employee/manage-employee/add-employee');
			
		}//end if($err_msg !='')

		$is_username_exist = $this->mod_employee->check_if_username_exist($this->input->post('username'));
		
		if($is_username_exist){
			//Username already exist

			$data_arr['add-user-data'] = $this->input->post();
			$this->session->set_userdata($data_arr);
			
			$this->session->set_flashdata('err_message', ' Username already exist. Please try another one.');
			redirect(base_url().'employee/manage-employee/add-employee');
			
		}else{
			
			//Add New Employee	
			$add_new_employee = $this->mod_employee->add_employee($this->input->post());
			$employee_id = $this->db->insert_id() ; 
			
			if($add_new_employee && $add_new_employee['error'] == ''){
			
			
			$this->session->unset_userdata('add-user-data');
			$this->session->set_flashdata('ok_message', ' New Employee added successfully.');
			redirect(base_url().'employee/manage-employee');
				
			}else{
				
				if($add_new_employee['error'] != ''){
					$this->session->set_flashdata('err_message', '- '.strip_tags($add_new_employee['error']));
					redirect(base_url().'employee/manage-employee/add-employee/'.$employee_id);
					
				}else{
					$this->session->set_flashdata('err_message', ' New Employee cannot be added. Something went wrong, please try again.');
					redirect(base_url().'employee/manage-employee/add-employee');
					
				}//end if($add_new_user['error'] != '')
				
			}//end if($upd_admin_profile)

		}//end if($is_username_exist)

	}//end add_employee_process	
	
		

	//edit employee
	public function edit_employee($employee_id){
		
		//Login Check
		$this->mod_customer->verify_is_customer_login();

		
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
		$this->breadcrumbcomponent->add('Manage Sub Users', base_url().'employee/manage-employee');
		$this->breadcrumbcomponent->add('Edit Sub User', base_url().'customers/manage-customers/edit-customer/'.$customer_id);
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
	
		$data['INC_header_script_top'] = $this->load->view('common/script_header',$data,true);
		$data['INC_header_script_footer'] = $this->load->view('common/script_footer',$data,true);
		$data['INC_top_header'] = $this->load->view('common/top_header','',true);
		$data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel',$data,true);
		$data['INC_footer'] = $this->load->view('common/footer','',true);
		$data['INC_breadcrum'] = $this->load->view('common/breadcrum','',true);
		
		//Admin User data
		$employee_data = $this->mod_employee->get_employee($employee_id);
		$data['employee_arr'] = $employee_data['employee_arr'];
		
		$data['employee_id']= $employee_id;
		
		
		$this->load->view('employee/edit_employee',$data);
		
	}//edit_employee
	
	
	
	public function edit_employee_process(){
		
		
		//If Post is not SET
		if(!$this->input->post() && !$this->input->post('edit_new_employee_sbt')) redirect(base_url());
		
		
		//Login Check
		$this->mod_customer->verify_is_customer_login();

		
		$employee_id = $this->input->post('employee_id');

		$err_msg = '';
		if(trim($this->input->post('first_name')) == ''){
			
			$err_msg.= '- First Name cannot be empty.<br>';
			
		}//end if(trim($this->input->post('page_title')) == '')

		if(trim($this->input->post('last_name')) == ''){
			
			$err_msg.= '- Last Name cannot be empty.<br>';
			
		}//end if(trim($this->input->post('page_title')) == '')

		
		if(trim($this->input->post('username')) == ''){
			
			$err_msg.= '- Username cannot be empty.<br>';
			
		}//end if(trim($this->input->post('username')) == '')

		if(trim($this->input->post('email_address')) == '' ){
			
			$err_msg.= '- Please enter valid Email Address<br>';
			
		}//end if(trim($this->input->post('email_address')) == '')
		
		
		if($err_msg !=''){

			$this->session->set_flashdata('err_message', $err_msg);
			redirect(base_url().'employee/manage-employee/edit-employee/'.$employee_id);
			
		}//end if($err_msg !='')

		//Updating Customer Data
		$upd_employee = $this->mod_employee->edit_employee($this->input->post());
		
		if($upd_employee && $upd_employee['error'] == ''){
			
			$this->session->set_flashdata('ok_message', ' Employee record updated successfully.');
			redirect(base_url().'employee/manage-employee/edit-employee/'.$employee_id);
			
		}else{

			if($upd_employee['error'] != ''){
				
				$this->session->set_flashdata('err_message', '- '.strip_tags($upd_employee['error']));
				redirect(base_url().'employee/manage-employee/edit-employee/'.$employee_id);
				
			}else{
				$this->session->set_flashdata('err_message', '- User record cannot be updated. Something went wrong, please try again.');
				redirect(base_url().'employee/manage-employee/edit-employee/'.$employee_id);
				
			}//end if
			
		}//end if

	}//end edit_employee_process
	
	
	
	//edit employee
	public function view_employee($employee_id){
		
	//Login Check
	$this->mod_admin->verify_is_admin_login();

	
		//Verify if Page is Accessable
		if(!in_array(30,$this->session->userdata('permissions_arr'))){
				redirect(base_url().'errors/page-not-found-404');
				exit;
		}//end if
		
		//Plugin Files Permission
		$data['PLUGIN_datagrid'] = 1;
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
			$this->breadcrumbcomponent->add('Manage Customers', base_url().'customers/manage-customers');
		$this->breadcrumbcomponent->add('Customer Detail', base_url().'customers/manage-customers/view-customer/'.$customer_id);
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
		
		//Customer User data
		$customer_user_data = $this->mod_customer->get_customer_user_data($customer_id);
		$data['customer_user_data'] = $customer_user_data['customer_user_arr'];
		$data['customer_user_count'] = $customer_user_data['customer_user_count'];
		
		//Customer List
		
		$get_all_customer_docs = $this->mod_customer->get_customer_docs($customer_id);

		$data['customer_user_docs_data'] 		= $get_all_customer_docs['customer_user_docs_arr'];
		$data['customer_user_docs_count']	= $get_all_customer_docs['customer_user_docs_count'];
		
		$get_all_projects = $this->mod_customer->get_all_projects($customer_id,$status);

		$data['projects_arr'] = $get_all_projects['projects_arr'];
		$data['projects_count'] = $get_all_projects['projects_count'];
		
		//Get Projects counter
		$project_details = $this->mod_customer->get_customer_projects_count($customer_id);
		$data['total_projects'] = $project_details['total_projects'];
		$data['open_projects'] = $project_details['open_projects'];
		$data['cancel_projects'] = $project_details['cancel_projects'];
		$data['closed_projects'] = $project_details['closed_projects'];
		
		$data['customer_id'] = $customer_id;
		
		if($customer_user_data['customer_user_count'] == 0) redirect(base_url());
		
		$this->load->view('customers/view_customer',$data);
		
	}//View employee
	
	
	
	//Delete employee
	public function delete_employee($employee_id){ 
		
		//Login Check
		$this->mod_customer->verify_is_customer_login();

		//If Post is not SET
		if(!isset($employee_id)) redirect(base_url());
		
		//Updating Page
		$del_employee = $this->mod_employee->delete_employee($employee_id);
		
		if($del_employee){
			
			$this->session->set_flashdata('ok_message', ' Employee deleted successfully.');
			redirect(base_url().'employee/manage-employee');
			
		}else{
			$this->session->set_flashdata('err_message', ' Employee cannot be deleted. Something went wrong, please try again.');
			redirect(base_url().'employee/manage-employee');
			
		}//end if($del_admin_user)

	}//end delete_employee
	
	

}//end Dashboard 
