<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Manage_Tickets extends CI_Controller {

	public function __construct(){

		parent::__construct();
		$this->load->library('BreadcrumbComponent');
		$this->load->model('admin/mod_admin');
		$this->load->model('common/mod_common');
		$this->load->model('support/mod_support');
		$this->load->model('customers/mod_customer');
	}

	public function index(){
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(32,$this->session->userdata('permissions_arr'))){
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
		$data['PLUGIN_fancybox'] = 0;

		//Common Includes
		$data['meta_title'] = DEFAULT_TITLE;
		$data['meta_keywords'] = DEFAULT_META_KEYWORDS;
		$data['meta_description'] = DEFAULT_META_DESCRIPTION;

		$fetch_nav_panel = $this->mod_common->fetch_admin_nav_panel();
		$data['nav_panel_arr'] = $fetch_nav_panel;

		//Bread crum
		$this->breadcrumbcomponent->add('Dashboard', base_url().'dashboard/dashboard');
		$this->breadcrumbcomponent->add('Manage Tickets', base_url().'support/manage-tickets');
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
		$data['ALLOW_user_edit'] =   (in_array(9,$this->session->userdata('permissions_arr'))) ? 1 : 0;
		$data['ALLOW_user_delete'] =   (in_array(10,$this->session->userdata('permissions_arr'))) ? 1 : 0;
		$data['ALLOW_pages_add'] =   (in_array(57,$this->session->userdata('permissions_arr'))) ? 1 : 0;
		
		//Pagination
		$this->load->library('pagination');
		$config['base_url'] = base_url().'support/manage-tickets/index';
		$config['total_rows'] = $this->mod_support->count_total_tickets();
	
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
		
		$get_customers_user = $this->mod_support->get_ticket_limit($page,$config["per_page"]);
		$data['ticket_list_result'] = $get_customers_user['ticket_list_result'];
		$data['ticket_list_result_count'] = $get_customers_user['ticket_list_result_count'];
		//echo "<pre>";
		//print_r($data['ticket_list_result']);
		//exit;
		$this->load->view('support/manage_tickets',$data);
			
	}//end index()

	
	//View Ticket Details
	public function ticket_detail($ticket_id){

	//Login Check
	$this->mod_admin->verify_is_admin_login();
	
		//Verify if Page is Accessable
		if(!in_array(32,$this->session->userdata('permissions_arr'))){
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
		$data['PLUGIN_fancybox'] = 1;
		
		//Common Includes
		$data['meta_title'] = DEFAULT_TITLE;
		$data['meta_keywords'] = DEFAULT_META_KEYWORDS;
		$data['meta_description'] = DEFAULT_META_DESCRIPTION;

		$fetch_nav_panel = $this->mod_common->fetch_admin_nav_panel();
		$data['nav_panel_arr'] = $fetch_nav_panel;

		//Bread crum
		$this->breadcrumbcomponent->add('Dashboard', base_url().'dashboard/dashboard');
		$this->breadcrumbcomponent->add('Ticket Detail', base_url().'support/view-details/'.$ticket_id);
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
		
		
		
		//Ticket data
		$ticket_data = $this->mod_support->get_ticket_detail_data($ticket_id);
		$data['ticket_data_arr'] = $ticket_data['ticket_data_arr'];
		$data['ticket_data_count'] = $ticket_data['ticket_data_count'];
		
		
		$get_ticket_attachments = $this->mod_support->get_ticket_attachments($ticket_id);

		$data['ticket_attachment_data'] 	= $get_ticket_attachments['ticket_attachment_arr'];
		$data['ticket_attachment_count']	= $get_ticket_attachments['ticket_attachment_count'];
		
		
		//Get All Ticket Replies
		$get_all_ticket_replies = $this->mod_support->get_all_ticket_replies($ticket_id);

		$data['ticket_all_replies_data'] 	= $get_all_ticket_replies['ticket_replies_arr'];
		$data['ticket_replies_count']	= $get_all_ticket_replies['ticket_replies_count'];
		
	
		//echo "<pre>"; print_r($data['ticket_data_arr']); exit;
		if($ticket_data['ticket_data_count'] == 0) redirect(base_url());
		
		$data['ticket_id']=$ticket_id;
		
		$this->load->view('support/ticket_detail',$data);
		
	}//View Ticket Detail
	
	
	public function ticket_reply_process(){
		
		
		$this->load->model('email/mod_email');
		$this->load->helper('email');
		$this->load->model('site_preferences/mod_preferences');
		
		//If Post is not SET
		if(!$this->input->post() && !$this->input->post('reply_ticket_sbt')) redirect(base_url());
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();
		
		//Verify if Page is Accessable
		if(!in_array(9,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if
		
		 $ticket_id = $this->input->post('ticket_id');
		//Ticket reply
		$upd_ticket_reply = $this->mod_support->ticket_reply($this->input->post());
		$ticket_id = str_replace("#","",$ticket_id);
		if($upd_ticket_reply){
				
			$this->session->set_flashdata('ok_message', '- Ticket Reply has been sent.');
			redirect(base_url().'support/manage-tickets/ticket-detail/'.$ticket_id);
		}else{
			
			$this->session->set_flashdata('err_message', '- Ticket reply cannot be sent. Something went wrong, please try again.');
			redirect(base_url().'support/manage-tickets/ticket-detail/'.$ticket_id);
			
			
		}//end ticket reply.

	}//end ticket_reply_process
	
	
	public function ticket_close_process($ticket_number){
	
		$this->load->helper('email');
		$this->load->model('email/mod_email');
		$this->load->model('site_preferences/mod_preferences');
		
		
		
		//Login Check
	    $this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(10,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if

		//If GET is not SET
		if(!isset($ticket_number)) redirect(base_url());
		
		//Updating Page
		$close_ticket = $this->mod_support->close_ticket($ticket_number);
		
		if($close_ticket){
			$this->session->set_flashdata('ok_message', '- Close ticket request has been sent sucessfully.');
			redirect(base_url().'support/manage-tickets/ticket-detail/'.$ticket_number);
			
		}else{
			$this->session->set_flashdata('err_message', '- Ticket close request cannot be send. Something went wrong, please try again.');
			redirect(base_url().'support/manage-tickets/ticket-detail/'.$ticket_number);
			
		}//end if($del_admin_user)

		}//end ticket_reply_process
	
	
	
	public function add_ticket(){
	
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(32,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if
		
		
		
		//Plugin Files Permission
		$data['PLUGIN_datagrid'] = 0;
		$data['PLUGIN_datepicker'] = 1;
		$data['PLUGIN_gcal'] = 0;
		$data['PLUGIN_form_validation'] = 0;
		$data['PLUGIN_gallery'] = 0;
		$data['PLUGIN_ckeditor'] = 0;
		$data['PLUGIN_floatchart'] = 0;
		$data['PLUGIN_fancybox'] = 0;

		//Common Includes
		$data['meta_title'] = DEFAULT_TITLE;
		$data['meta_keywords'] = DEFAULT_META_KEYWORDS;
		$data['meta_description'] = DEFAULT_META_DESCRIPTION;

		$fetch_nav_panel = $this->mod_common->fetch_admin_nav_panel();
		$data['nav_panel_arr'] = $fetch_nav_panel;

		//Bread crum
		$this->breadcrumbcomponent->add('Dashboard', base_url().'dashboard/dashboard');
		$this->breadcrumbcomponent->add('Add New Ticket', base_url().'support/manage-tickets');
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
		$data['ALLOW_user_edit'] =   (in_array(9,$this->session->userdata('permissions_arr'))) ? 1 : 0;
		$data['ALLOW_user_delete'] =   (in_array(10,$this->session->userdata('permissions_arr'))) ? 1 : 0;
		
		
		$get_all_customer = $this->mod_customer->get_all_customers();
		$data['customers_list_arr'] 	= $get_all_customer['customers_list_arr'];
		$data['customers_list_count']	= $get_all_customer['customers_list_count'];
		
		$this->load->view('support/add_ticket',$data);
		
		
	}//End add_ticket
	
	
	public function add_ticket_process(){
		
		//If Post is not SET
		if(!$this->input->post() && !$this->input->post('add_ticket_sbt')) redirect(base_url());
		
		$this->load->model('email/mod_email');
		$this->load->model('site_preferences/mod_preferences');
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(8,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if
		
		$err_msg = '';
		
		if(trim($this->input->post('account_type')) == ''){
			
			$err_msg.= '- Account type cannot be empty.<br>';
			
		}//end if(trim($this->input->post('page_title')) == '')


		if(trim($this->input->post('subject')) == ''){
			
			$err_msg.= '- Subject cannot be empty.<br>';
			
		}//end if(trim($this->input->post('page_title')) == '')

		if(trim($this->input->post('details')) == ''){
			
			$err_msg.= '- Details cannot be empty.<br>';
			
		}//end if(trim($this->input->post('page_title')) == '')
		
		
		if($err_msg !=''){

			$this->session->set_flashdata('err_message', $err_msg);
			redirect(base_url().'support/manage_tickets/add_ticket');
			
		}//end if($err_msg !='')

		
		
			$add_ticket = $this->mod_support->add_ticket($this->input->post());
			
			if($add_ticket && $add_ticket['error'] == ''){
				
				//Unset POST values from session
				$this->session->unset_userdata('add-user-data');
				
				$this->session->set_flashdata('ok_message', '- New Ticket added successfully.');
				redirect(base_url().'support/manage_tickets/add_ticket');
				
			}else{
				
				if($add_ticket['error'] != ''){
					$this->session->set_flashdata('err_message', '- '.strip_tags($add_new_user['error']));
					redirect(base_url().'support/manage_tickets/add_ticket');
					
				}else{
					$this->session->set_flashdata('err_message', '- New Ticket cannot be added. Something went wrong, please try again.');
					redirect(base_url().'support/manage_tickets/add_ticket');
					
				}//end if
				
			}//end if

	}//end add_ticket_process
	

}//end Dashboard 
