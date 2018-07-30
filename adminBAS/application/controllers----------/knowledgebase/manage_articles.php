<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Manage_Articles extends CI_Controller {

	public function __construct(){
		parent::__construct();

		$this->load->model('knowledgebase/mod_articles');
		$this->load->model('common/mod_common');
		$this->load->model('admin/mod_admin');
		$this->load->library('BreadcrumbComponent');
		
	}

	public function index(){
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(149,$this->session->userdata('permissions_arr'))){
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
		$this->breadcrumbcomponent->add('Manage User', base_url().'cms/manage-user');
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
		$data['ALLOW_user_edit'] =   (in_array(151,$this->session->userdata('permissions_arr'))) ? 1 : 0;
		$data['ALLOW_user_delete'] =   (in_array(152,$this->session->userdata('permissions_arr'))) ? 1 : 0;
		$data['ALLOW_pages_add'] =   (in_array(150,$this->session->userdata('permissions_arr'))) ? 1 : 0;
		
		
		$get_all_articles= $this->mod_articles->get_all_articles();
		$data['all_articles_arr'] = $get_all_articles['all_articles_arr'];
		$data['all_articles_count'] = $get_all_articles['all_articles_count'];

		$this->load->view('knowledgebase/manage_articles',$data);
			
	}//end index()
	
	//Add New User
	public function add_article(){
		
		$this->load->model('admin_roles/mod_admin_roles');
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(150,$this->session->userdata('permissions_arr'))){
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

		//Bread crum
		$this->breadcrumbcomponent->add('Dashboard', base_url().'dashboard/dashboard');
		$this->breadcrumbcomponent->add('Manage Articles', base_url().'knowledgebase/manage-articles');
		$this->breadcrumbcomponent->add('Add New Article', base_url().'admin/manage-user/add-new-user');
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
		
		
		//Admin User Roles List
		$get_all_admin_roles = $this->mod_admin_roles->get_all_admin_roles();

		$data['admin_roles_arr'] = $get_all_admin_roles['admin_roles_result'];
		$data['admin_roles_count'] = $get_all_admin_roles['admin_roles_result_count'];
		
	
		
		$this->load->view('knowledgebase/add_article',$data);
		
	}//add_new_user
	


	//add-article-process
	public function add_article_process(){
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		
		//Verify if Page is Accessable
		if(!in_array(150,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if
		
		
		$add_article = $this->mod_articles->add_article ($this->input->post());
		
		if($add_article ['error'] != ''){
			
			$this->session->set_flashdata('err_message',$add_article ['error']);
			redirect(base_url().'knowledgebase/manage-articles/add-article');
			
		}
		
		if($add_article && $add_article ['error'] == ''){
			
			$this->session->set_flashdata('ok_message', ' Article Added successfully.');
			redirect(base_url().'knowledgebase/manage-articles');
			
		}else{

				$this->session->set_flashdata('err_message', ' Article cannot be uploaded. Something went wrong, please try again.');
				redirect(base_url().'knowledgebase/manage-articles/add-article');
			
			
		}//end if($add_cms_page)

	}//end add-artilce-process
	
	
	//article_detail
	public function article_detail($article_id){
		
		$this->load->model('admin_roles/mod_admin_roles');
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(149,$this->session->userdata('permissions_arr'))){
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

		//Bread crum
		$this->breadcrumbcomponent->add('Dashboard', base_url().'dashboard/dashboard');
		$this->breadcrumbcomponent->add('Manage Articles', base_url().'knowledgebase/manage-articles');
		$this->breadcrumbcomponent->add('Article Details', base_url().'admin/manage-user/edit-user/'.$admin_id);
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
		
		//Get sop
		$get_article= $this->mod_articles->get_article($article_id);
		$data['article_arr'] = $get_article['article_arr'];
		
		$data['article_id']= $article_id;
		
		$this->load->view('knowledgebase/article_detail',$data);
		
	}//sop_detail
	
	
	//edit_sop
	public function edit_article($article_id){
		
		$this->load->model('admin_roles/mod_admin_roles');
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(151,$this->session->userdata('permissions_arr'))){
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

		//Bread crum
		$this->breadcrumbcomponent->add('Dashboard', base_url().'dashboard/dashboard');
		$this->breadcrumbcomponent->add('Manage Articles', base_url().'knowledgebase/manage-articles');
		$this->breadcrumbcomponent->add('Edit Article', base_url().'admin/manage-user/edit-user/'.$admin_id);
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
		
		//Admin User Roles List
		$get_all_admin_roles = $this->mod_admin_roles->get_all_admin_roles();
		$data['admin_roles_arr'] = $get_all_admin_roles['admin_roles_result'];
		$data['admin_roles_count'] = $get_all_admin_roles['admin_roles_result_count'];
		
		//Get sop
		$get_article= $this->mod_articles->get_article($article_id);
		$data['article_arr'] = $get_article['article_arr'];
		
		$data['article_id'] =$article_id;
		
		$this->load->view('knowledgebase/edit_article',$data);
		
	}//edit_sop
	
	
	
	//edit-article-process
	public function edit_article_process(){
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		
		//Verify if Page is Accessable
		if(!in_array(151,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if
		
		
		$edit_article = $this->mod_articles->edit_article($this->input->post());
		
		$article_id = $this->input->post('article_id');
		
		if($edit_article['error'] != ''){
			
			$this->session->set_flashdata('err_message',$edit_article['error']);
			redirect(base_url().'knowledgebase/manage-articles/edit-article/'.$article_id);
			
		}
		
		if($edit_article && $edit_article['error'] == ''){
			
			$this->session->set_flashdata('ok_message', ' Article Updated successfully.');
			redirect(base_url().'knowledgebase/manage-articles/edit-article/'.$article_id);
			
		}else{

				$this->session->set_flashdata('err_message', ' Article cannot be Updated. Something went wrong, please try again.');
				redirect(base_url().'knowledgebase/manage-articles/edit-article/'.$article_id);
			
			
		}//end if($add_cms_page)

	}//end edit-articleprocess
	
	
	//delete-sop
	public function delete_article($article_id){
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		
		//Verify if Page is Accessable
		if(!in_array(152,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if
		
		$delete_article= $this->mod_articles->delete_article($article_id);
		
		if($delete_article&& $delete_article['error'] == ''){
			
			$this->session->set_flashdata('ok_message', ' Article deleted successfully.');
			redirect(base_url().'knowledgebase/manage-articles');
			
		}else{

				$this->session->set_flashdata('err_message', ' Article cannot be deleted. Something went wrong, please try again.');
				redirect(base_url().'knowledgebase/manage-articles');
			
			
		}//end if($add_cms_page)

	}//end delete-article
	
	
	

}//end Dashboard 
