<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Manage_Messages extends CI_Controller {

	public function __construct(){
		parent::__construct();

		$this->load->model('admin/mod_admin');
		$this->load->model('common/mod_common');
		$this->load->model('messages/mod_messages');
		$this->load->model('customers/mod_customer');
		$this->load->library('BreadcrumbComponent');
		//$this->mod_common->get_inbox_messages();
		
	}

	public function index(){
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(72,$this->session->userdata('permissions_arr'))){
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
		$data['ALLOW_user_edit'] =   (in_array(55,$this->session->userdata('permissions_arr'))) ? 1 : 0;
		$data['ALLOW_user_delete'] =   (in_array(61,$this->session->userdata('permissions_arr'))) ? 1 : 0;
		

		//Bread crum
		$this->breadcrumbcomponent->add('Dashboard', base_url().'dashboard/dashboard');
		$this->breadcrumbcomponent->add('Inbox', base_url().'messages/manage-messages/inbox');
		$this->breadcrumbcomponent->add('Message Sent', base_url().'coupons/manage-coupons');
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
		
		$messages_arr = $this->mod_messages->get_messages();
		$data['messages_arr'] = $messages_arr['messages_result'];
		$data['messages_count'] = $messages_arr['messages_count'];
		
		$this->load->view('messages/sent',$data);
			
	}//end index()
	
	//Compose Message
	public function compose(){
	
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(70,$this->session->userdata('permissions_arr'))){
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
		
		//Permissions
		$data['ALLOW_broadcast_to_branches'] =   (in_array(125,$this->session->userdata('permissions_arr'))) ? 1 : 0;

		//Bread crum
		$this->breadcrumbcomponent->add('Dashboard', base_url().'dashboard/dashboard');
		$this->breadcrumbcomponent->add('Inbox', base_url().'messages/manage-messages/inbox');
		$this->breadcrumbcomponent->add('Compose New Message', base_url().'coupons/manage-coupons/add-coupons');
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
		
		
		$get_all_users = $this->mod_messages->get_admin_user_data();
		$data['admin_user_arr'] 	= $get_all_users['admin_user_arr'];
		$data['admin_user_count']	= $get_all_users['admin_user_count'];
		
		//Fetching Branches
		$get_branches = $this->mod_messages->get_all_branches();

		$data['branches_arr'] = $get_branches['branches_arr'];
		$data['branches_count'] = $get_branches['branches_count'];
		
		
		
		//Mesage id Generator
		$message_id = $this->mod_common->random_number_generator(7);
		$message_id = $this->mod_messages->message_id_generator($message_id);
		$data['message_id'] = $message_id;
		
		$this->load->view('messages/compose',$data);
		
	}//End Compose

	public function compose_process(){
		
		//If Post is not SET
		if(!$this->input->post() && !$this->input->post('send_message')) redirect(base_url());
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(70,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if
		
		$err_msg = '';
		
		if(trim($this->input->post('branch_id')) == '' and $this->input->post('user_name') == '' ){
			
			$err_msg.= 'Branch Name OR User Name cannot be empty.<br>';
			
		}//end if

		if(trim($this->input->post('subject')) == ''){
			
			$err_msg.= 'Subject cannot be empty.<br>';
			
		}//end if
		
		
		if(trim($this->input->post('message')) == ''){
			
			$err_msg.= 'Message Field cannot be empty.<br>';
			
		}//end if
		
		
		if($err_msg !=''){

			$this->session->set_flashdata('err_message', $err_msg);
			redirect(base_url().'messages/manage_messages/compose');
			
		}//end if($err_msg !='')

		
			//Compose New Message
			$compose = $this->mod_messages->compose($this->input->post());
			
			if($compose && $compose['error'] == ''){
				
				$this->session->set_flashdata('ok_message', 'New Message added successfully.');
				redirect(base_url().'messages/manage_messages/compose');
				
			}else{
				
				if($compose['error'] != ''){
					$this->session->set_flashdata('err_message', 'Sorry File Cannot uploaded');
					redirect(base_url().'messages/manage_messages/compose');
					
				}else{
					$this->session->set_flashdata('err_message', 'New Message cannot be added. Something went wrong, please try again.');
					redirect(base_url().'messages/manage_messages/compose');
					
				}//end if
				
			}//end if
	}//end compose_process
	
	
	
	
	//Send Message Details
	public function message_sent_detail($message_id){
	
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(72,$this->session->userdata('permissions_arr'))){
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
		$this->breadcrumbcomponent->add('Sent', base_url().'messages/manage_messages');
		$this->breadcrumbcomponent->add('Message Box', base_url().'coupons/manage-coupons/add-coupons');
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
		
		
		$get_message_detail = $this->mod_messages->get_sent_message_detail($message_id);
		$data['message_detail_arr']= $get_message_detail['message_detail_arr'];
		$data['message_detail_count']= $get_message_detail['message_detail_count'];
		
		$data['message_id']=$message_id;
		
		$this->load->view('messages/message_sent_detail',$data);
		
	}//End Send Message Detail
	
	//Inbox  Message Details
	public function message_inbox_detail($message_id){
	
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(71,$this->session->userdata('permissions_arr'))){
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
		$this->breadcrumbcomponent->add('Inbox', base_url().'messages/manage_messages/inbox');
		$this->breadcrumbcomponent->add('Message Box', base_url().'coupons/manage-coupons/add-coupons');
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		///////////////////////// Top Notifications  /////////////////////
		//Get Inbox Unread Messsaes Notifications
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
		
		
		//Update Project Message Record
		$this->mod_messages->update_inbox_message($message_id);
		
		
		$get_message_detail = $this->mod_messages->get_inbox_message_detail($message_id);
		$data['message_detail_arr']= $get_message_detail['message_detail_arr'];
		$data['message_detail_count']= $get_message_detail['message_detail_count'];
		//$data['users_arr']= $get_message_detail['users_arr'];
		
		/*echo "<pre>";
		print_r($data['message_detail_arr']);
		exit;
		*/
		$data['message_id']=$message_id;
		
		$this->load->view('messages/message_inbox_detail',$data);
		
	}//End Inbox Message Detail 
	
	public function message_inbox_detail_process(){
		
		//If Post is not SET
		if(!$this->input->post() && !$this->input->post('reply_message_sbt')) redirect(base_url());
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(71,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if
		
		
			//Compose New Message
			$compose = $this->mod_messages->message_reply($this->input->post());
			
			if($compose && $compose['error'] == ''){
				
				$this->session->set_flashdata('ok_message', 'Message added successfully.');
				redirect(base_url().'messages/manage_messages/message_inbox_detail/'.$this->input->post('message_id'));
				
			}else{
				
				if($compose['error'] != ''){
					
					$this->session->set_flashdata('err_message', 'Sorry File Size Exceeded');
					redirect(base_url().'messages/manage_messages/message_inbox_detail/'.$this->input->post('message_id'));
					
				}else{
					$this->session->set_flashdata('err_message', 'New Message cannot be added. Something went wrong, please try again.');
					redirect(base_url().'messages/manage_messages/message_inbox_detail/'.$this->input->post('message_id'));
					
				}//end if
				
			}//end if
	}//end messages inbox Detail process
	

	public function message_sent_detail_process(){
		
		//If Post is not SET
		if(!$this->input->post() && !$this->input->post('reply_message_sbt')) redirect(base_url());
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(8,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if
		
		
			//Compose New Message
			$compose = $this->mod_messages->message_reply($this->input->post());
			
			if($compose && $compose['error'] == ''){
				
				$this->session->set_flashdata('ok_message', 'Message added successfully.');
				redirect(base_url().'messages/manage_messages/message_sent_detail/'.$this->input->post('message_id'));
				
			}else{
				
				if($compose['error'] != ''){
					$this->session->set_flashdata('err_message', '- '.strip_tags($add_new_user['error']));
					redirect(base_url().'messages/manage_messages/message_sent_detail/'.$this->input->post('message_id'));
					
				}else{
					$this->session->set_flashdata('err_message', 'New Message cannot be added. Something went wrong, please try again.');
					redirect(base_url().'messages/manage_messages/message_sent_detail/'.$this->input->post('message_id'));
					
				}//end if
				
			}//end if
	}//end messages sent Detail process	
	
	//Inbox Messages
	public function inbox($type=""){
		
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(71,$this->session->userdata('permissions_arr'))){
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
		
		$data['ALLOW_compose'] =   (in_array(70,$this->session->userdata('permissions_arr'))) ? 1 : 0;

		//Bread crum
		$this->breadcrumbcomponent->add('Dashboard', base_url().'dashboard/dashboard');
		$this->breadcrumbcomponent->add('Message Inbox', base_url().'coupons/manage-coupons/add-coupons');
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		///////////////////////// Top Notifications  /////////////////////
		//Get Assign Task Notificaitons
		$assign_tasks_notifiations= $this->mod_common->get_assign_task_notifiations();
		$data['assign_task_notifiations_arr'] = $assign_tasks_notifiations['assign_task_filter'];
		$data['assign_task_notifiations_count'] = $assign_tasks_notifiations['assign_task_count'];
		
		//Get Inbox Unread Messsaes Notifications
		$inbox_unread_messages = $this->mod_common->get_inbox_messages();
		$data['unread_messages_count'] = $inbox_unread_messages['messages_count'];
		
		
		//Get Inbox Unread Messsaes Notifications
		$inbox_unread_messages = $this->mod_common->get_inbox_unread_messages();
		$data['messages_arr'] = $inbox_unread_messages['messages_result'];
		$data['messages_count'] = $inbox_unread_messages['messages_count'];
		
		/*echo "<pre>";
		print_r($data['messages_count']);
		exit;*/
		
		
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
		
		
		
		$messages_arr = $this->mod_messages->get_inbox_messages($type);
		
		$data['messages_arr'] = $messages_arr['messages_result'];
		$data['messages_count'] = $messages_arr['messages_count'];
		//$data['unread_msg'] = $messages_arr['unread_msg'];
		
		$data['unread_msg_count'] = $messages_arr['messages_count'];
		
		$data['total_messages'] = $messages_arr['total_messages'];
		
		$data['read_messages_arr'] = $messages_arr['read_messages_result'];
		$data['read_messages_count'] = $messages_arr['read_messages_count'];
		
	    $data['type'] = $type;
		
	/*	echo "<pre>";
		print_r($data['messages_count']);
		exit;
		*/
		$this->load->view('messages/inbox',$data);
		
	}//End Inbox Messages
	
	
	public function process_inbox_grid($type=""){
		
		echo $this->mod_messages->get_filter_inbox_grid_data($type);
		
	}//end 
	
	public function process_inbox_read_grid(){
		
		echo $this->mod_messages->get_filter_inbox_read_grid_data();
		
	}//end 
	

}//end Dashboard 
