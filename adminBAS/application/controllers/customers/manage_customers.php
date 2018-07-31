<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Manage_Customers extends CI_Controller {

	public function __construct(){

		parent::__construct();
		$this->load->model('admin/mod_admin');
		$this->load->model('customers/mod_customer');
		$this->load->model('common/mod_common');
		$this->load->library('BreadcrumbComponent');
		ini_set('memory_limit', "256M");
		
	}

	public function index(){
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(30,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if
		echo "shahid";exit;
		
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
		$this->breadcrumbcomponent->add('Manage Customer', base_url().'cms/manage-customer');
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
		$data['ALLOW_user_edit'] =   (in_array(62,$this->session->userdata('permissions_arr'))) ? 1 : 0;
		$data['ALLOW_user_delete'] =   (in_array(63,$this->session->userdata('permissions_arr'))) ? 1 : 0;
		$data['ALLOW_pages_add'] =   (in_array(31,$this->session->userdata('permissions_arr'))) ? 1 : 0;
		
		//Pagination
		$this->load->library('pagination');
		$config['base_url'] = base_url().'customers/manage-user/index';
		$config['total_rows'] = $this->mod_customer->count_total_customers_users();
	
		$config['per_page'] = 50;
		$config['num_links'] = 10;
		$config['use_page_numbers'] = TRUE;
		$config['uri_segment'] = 4;
		
		$config['next_link'] = '&raquo;';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		
		$config['prev_link'] = '&laquo;';

		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		
		$config['first_link'] = 'First';
		$config['last_link'] = 'Last';
		
		$config['full_tag_open'] = '<ul class="pagination">';
		$config['full_tag_close'] = '</ul>';
		
		$config['cur_tag_open'] = '<li><a href="#"><b>';
		$config['cur_tag_close'] = '</b></a></li>';
		
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		
		$this->pagination->initialize($config);
		$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
		if($page !=0) $page = ($page-1) * $config['per_page'];

		$data['page_links'] = $this->pagination->create_links();
		
		$get_customers_user = $this->mod_customer->get_customers_users_limit($page,$config["per_page"]);
		$data['customers_user_list'] = $get_customers_user['customers_list_result'];
		$data['customers_user_list_count'] = $get_customers_user['customers_list_result_count'];
		$this->load->view('customers/manage_customer',$data);
			
	}//end index()
	
	//Add New Customer
	public function add_new_customer(){
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();


		//Verify if Page is Accessable
		if(!in_array(31,$this->session->userdata('permissions_arr'))){
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
		$this->breadcrumbcomponent->add('Manage Customer', base_url().'customers/manage-customers');
		$this->breadcrumbcomponent->add('Add New Customer', base_url().'admin/manage-user/add-new-user');
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
		
		
		//Country List List
		$get_all_country_list = $this->mod_customer->get_all_countries();

		$data['countries_result_arr'] = $get_all_country_list['countries_result'];
		$data['countries_result_count'] = $get_all_country_list['countries_count'];
		
		
		//State List
		//$get_all_country_list = $this->mod_customer->get_all_states();

		$data['countries_result_arr'] = $get_all_country_list['countries_result'];
		$data['countries_result_count'] = $get_all_country_list['countries_count'];
		
		
		$this->load->view('customers/add_new_customer',$data);
		
	}//add_new_user

	public function add_new_customer_process(){
		$this->load->helper(array('email', 'url'));
        $this->load->model('site_preferences/mod_preferences');
		$this->load->model('email/mod_email');
		//If Post is not SET
		if(!$this->input->post() && !$this->input->post('add_new_customer_sbt')) redirect(base_url());
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();


		//Verify if Page is Accessable
		if(!in_array(31,$this->session->userdata('permissions_arr'))){
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
			redirect(base_url().'customers/manage-customers/add_new_customer');
			
		}//end if($err_msg !='')

		$is_username_exist = $this->mod_customer->check_if_username_exist($this->input->post('username'));
		
		if($is_username_exist){
			//Username already exist

			$data_arr['add-user-data'] = $this->input->post();
			$this->session->set_userdata($data_arr);
			
			$this->session->set_flashdata('err_message', '- Username already exist. Please try another one.');
			redirect(base_url().'customers/manage-customers/add_new_customer');
			
		}else{
			
			//Add New Customer	
			$add_new_customer = $this->mod_customer->add_new_customer($this->input->post());
			$customer_id = $this->db->insert_id() ; 
			
			if($add_new_customer && $add_new_customer['error'] == ''){
			
			
			$this->session->unset_userdata('add-user-data');
			$this->session->set_flashdata('ok_message', '- New Customer added successfully.');
			redirect(base_url().'customers/manage-customers');
				
			}else{
				
				if($add_new_customer['error'] != ''){
					$this->session->set_flashdata('err_message', '- '.strip_tags($add_new_customer['error']));
					redirect(base_url().'customers/manage-customers/add_new_customer/'.$admin_id);
					
				}else{
					$this->session->set_flashdata('err_message', '- New Customer cannot be added. Something went wrong, please try again.');
					redirect(base_url().'customers/manage-customers/add_new_customer');
					
				}//end if($add_new_user['error'] != '')
				
			}//end if($upd_admin_profile)

		}//end if($is_username_exist)

	}//end add_new_user_process	
	
	//Ajax Response States against Countries
	public function get_states_list($country_id){
		
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		
		//State List List
		$get_all_states_list = $this->mod_customer->get_all_states($country_id);

		$data['states_result_arr'] = $get_all_states_list['states_result'];
		$data['states_result_count'] = $get_all_states_list['states_count'];
		
		$data['cities_result_arr'] = $get_all_states_list['cities_result'];
		$data['cities_result_count'] = $get_all_states_list['cities_count'];
		
		if($country_id != '0'){
		
		if($data['states_result_count'] >0){ // If State found in database .
		$response_select .= '<select  style="width:100%;"  id="state_name" name="state_name" onChange="get_cities(this.value)" required><option value="0">Select State</option>' ;	
			
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
		
		if($country_id != '0'){
		if($data['cities_result_count'] >0){ // If Cities found in database .
		$response_select .= '<select style="width:100%;" id="city_name" name="city_name" onChange="get_cities(this.value)" required><option value="0">Select City</option>' ;	
			
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
		

	//edit Customer
	public function edit_customer($customer_id){
		
	//Login Check
	$this->mod_admin->verify_is_admin_login();

	
		//Verify if Page is Accessable
		if(!in_array(62,$this->session->userdata('permissions_arr'))){
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
		$this->breadcrumbcomponent->add('Manage Customer', base_url().'customers/manage-customers');
		$this->breadcrumbcomponent->add('Edit Customer', base_url().'customers/manage-customers/edit-customer/'.$customer_id);
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
		$customer_user_data = $this->mod_customer->get_customer_user_data($customer_id);
		$data['customer_user_data'] = $customer_user_data['customer_user_arr'];
		$data['customer_user_count'] = $customer_user_data['customer_user_count'];
		
		//Country List List
		$get_all_country_list = $this->mod_customer->get_all_countries();

		$data['countries_result_arr'] = $get_all_country_list['countries_result'];
		$data['countries_result_count'] = $get_all_country_list['countries_count'];
		
		
		$get_customer_data = $this->mod_customer->get_customer_profile($customer_id);
		$county_name= $get_customer_data['customer_profile_arr']['country_name'];
		
		
		$get_states_list = $this->mod_customer->get_states($county_name);
		$data['states_result_arr'] = $get_states_list['states_result'];
		$data['states_result_count'] = $get_states_list['states_count'];
		
		
		$get_cities_list = $this->mod_customer->get_cities($county_name);
		$data['cities_result_arr'] = $get_cities_list['cities_result'];
		$data['cities_result_count'] = $get_cities_list['cities_count'];
		
		if($customer_user_data['customer_user_count'] == 0) redirect(base_url());
		
		$this->load->view('customers/edit_customer',$data);
		
	}//edit_user
	
	public function edit_customer_process(){
		
		$this->load->helper('email');

		//If Post is not SET
		if(!$this->input->post() && !$this->input->post('upd_customer_sbt')) redirect(base_url());
		
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		
		//Verify if Page is Accessable
		if(!in_array(62,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if
		
		
		$customer_id = $this->input->post('customer_id');

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
			redirect(base_url().'customers/manage-customers/edit-customer/'.$customer_id);
			
		}//end if($err_msg !='')

		//Updating Customer Data
		$upd_customer = $this->mod_customer->edit_customer($this->input->post());
		
		if($upd_customer && $upd_customer['error'] == ''){
			
			$this->session->set_flashdata('ok_message', '- User record updated successfully.');
			redirect(base_url().'customers/manage-customers/edit-customer/'.$customer_id);
			
		}else{

			if($upd_admin['error'] != ''){
				
				$this->session->set_flashdata('err_message', '- '.strip_tags($upd_admin['error']));
				redirect(base_url().'customers/manage-customers/edit-customer/'.$customer_id);
				
			}else{
				$this->session->set_flashdata('err_message', '- User record cannot be updated. Something went wrong, please try again.');
				redirect(base_url().'customers/manage-customers/edit-customer/'.$customer_id);
				
			}//end if($upd_customer['error'] != '')
			
		}//end if($add_cms_page)

	}//end edit_user_process
	
	//Upload Customer Docs
	public function upload_docs($customer_id){
		
	//Login Check
	$this->mod_admin->verify_is_admin_login();

	
		//Verify if Page is Accessable
		if(!in_array(62,$this->session->userdata('permissions_arr'))){
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
		$this->breadcrumbcomponent->add('Upload Customer Docs', base_url().'customers/manage-customers/upload-docs/'.$customer_id);
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
		$customer_user_data = $this->mod_customer->get_customer_user_data($customer_id);
		$data['customer_user_data'] = $customer_user_data['customer_user_arr'];
		$data['customer_user_count'] = $customer_user_data['customer_user_count'];
		
		if($customer_user_data['customer_user_count'] == 0) redirect(base_url());
		
		$this->load->view('customers/upload_docs',$data);
		
	}//Upload Docs
	
	
	public function upload_docs_process(){
		
		//If Post is not SET
		if(!$this->input->post() && !$this->input->post('upd_customer_docs_sbt')) redirect(base_url());
		
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		
		//Verify if Page is Accessable
		if(!in_array(62,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if
		
		
		$customer_id = $this->input->post('customer_id');

		if($_FILES['prof_image']['name'] != ''){
			
			$allowed_extesntions = array('jpg','jpeg','tiff','png','gif');
			$file_ext           = ltrim(strtolower(strrchr($_FILES['prof_image']['name'],'.')),'.'); 
			
			if(!in_array($file_ext,$allowed_extesntions)){
				$err_msg.= '- Invalid image for your profile (Use: jpg, jpeg, gif, tiff, png)<br>';	
			}//end if
			
		}//end if($_FILES['prof_image']['name'] != '')
		
		
		if($err_msg !=''){

			$this->session->set_flashdata('err_message', $err_msg);
			redirect(base_url().'customers/manage-customers/upload-docs/'.$customer_id);
			
		}//end if($err_msg !='')

		//Updating Customer Data
		$upd_customer = $this->mod_customer->upload_docs($this->input->post());
		
		if($upd_customer && $upd_customer['error'] == ''){
			
			$this->session->set_flashdata('ok_message', '- Customer Docs uploaded successfully.');
			redirect(base_url().'customers/manage-customers/upload-docs/'.$customer_id);
			
		}else{

			if($upd_customer['error'] != ''){
				$this->session->set_flashdata('err_message', '- '.strip_tags($upd_admin['error']));
				redirect(base_url().'customers/manage-customers/upload-docs/'.$customer_id);
				
			}else{
				$this->session->set_flashdata('err_message', '- Customer Docs cannot be uploaded. Something went wrong, please try again.');
				redirect(base_url().'customers/manage-customers/upload-docs/'.$customer_id);
				
			}//end if($upd_customer['error'] != '')
			
		}//end if($add_cms_page)

	}//end Customer Upload Docs
	
	
	//edit Customer
	public function view_customer($customer_id,$status=""){
		
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
		
	}//View Customer
	
	//Delete Admin User
	public function delete_customer($customer_id){ 
		
	//Login Check
	$this->mod_admin->verify_is_admin_login();

		

		//Verify if Page is Accessable
		if(!in_array(63,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if

		//If Post is not SET
		if(!isset($customer_id)) redirect(base_url());
		
		//Updating Page
		$del_customer_user = $this->mod_customer->delete_customer($customer_id);
		
		if($del_customer_user){
			
			$this->session->set_flashdata('ok_message', '- Customer deleted successfully.');
			redirect(base_url().'customers/manage-customers');
			
		}else{
			$this->session->set_flashdata('err_message', '- Customer cannot be deleted. Something went wrong, please try again.');
			redirect(base_url().'customers/manage-customers');
			
		}//end if($del_admin_user)

	}//end delete_user
	
	
	
	 public function process_customer_grid(){

       echo $this->mod_customer->get_filter_customer_grid_data();

	}//end
	
	


}//end Dashboard 
