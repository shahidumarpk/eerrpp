<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Manage_Category extends CI_Controller {

	public function __construct(){
		parent::__construct();

		$this->load->model('admin/mod_admin');
		$this->load->model('category/mod_category');
		$this->load->model('common/mod_common');
		$this->load->library('BreadcrumbComponent');
		
	}

	public function index(){
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();
		
		//Verify if Page is Accessable
		if(!in_array(20,$this->session->userdata('permissions_arr'))){
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
		$this->breadcrumbcomponent->add('Manage Categories', base_url().'category/manage-category');
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
		$data['ALLOW_pages_edit'] =   (in_array(22,$this->session->userdata('permissions_arr'))) ? 1 : 0;
		$data['ALLOW_pages_delete'] =   (in_array(23,$this->session->userdata('permissions_arr'))) ? 1 : 0;
		$data['ALLOW_pages_add'] =   (in_array(21,$this->session->userdata('permissions_arr'))) ? 1 : 0;
		
		//Fetching All Categories Results
		$categories_count = $this->mod_category->get_all_categories_count();
		$data['category_list_count'] = $categories_count;
		
		$this->load->view('category/manage_category',$data);
		
	}//end index()
	
	public function process_category_grid(){
		
		echo $this->mod_category->get_filter_category_grid_data();
		
	}//end 
	
	//Add New Category
	public function add_new_category(){
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();
		
		//Verify if Page is Accessable
		if(!in_array(21,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if
		
		//Plugin Files Permission
		$data['PLUGIN_datagrid'] = 0;
		$data['PLUGIN_datepicker'] = 0;
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
		$this->breadcrumbcomponent->add('Manage Category', base_url().'category/manage-category');
		$this->breadcrumbcomponent->add('Add New Category', base_url().'category/manage-category/add-new-category');
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

		//Fetching Category Listing
		$get_category_list = $this->mod_category->get_all_categories();
		$data['category_list_arr'] = $get_category_list['category_list_arr'];
		$data['category_list_count'] = $get_category_list['category_list_count'];
		
		$this->load->view('category/add_new_category',$data);
		
	}//add_new_category

	public function add_new_category_process(){
		
		//If Post is not SET
		if(!$this->input->post() && !$this->input->post('add_new_cat_sbt')) redirect(base_url());
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(21,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if
		
		$data_arr['add-new-cat-data'] = $this->input->post();
		$this->session->set_userdata($data_arr);

		if(trim($this->input->post('category_name')) == ''){
			
			$this->session->set_flashdata('err_message', '- Category Name is empty.');
			redirect(base_url().'category/manage-category/add-new-category');
			
		}//end if(trim($this->input->post('category_name')) == '')

		//Check if The ctaegory name already exist against the selected Parent Category
		$check_if_cat_exist  = $this->mod_category->check_if_category_exist(trim($this->input->post('category_name')),trim($this->input->post('parent_id')),0);
		
		if($check_if_cat_exist > 0){
			
			$this->session->set_flashdata('err_message', '- Category Name already exist in the selected Parent Category.');
			redirect(base_url().'category/manage-category/add-new-category');
			
		}else{
				
			$add_new_category = $this->mod_category->add_new_category($this->input->post());

			if($add_new_category){
				
				//Unset POST values from session
				$this->session->unset_userdata('add-new-cat-data');
				
				$this->session->set_flashdata('ok_message', '- New Category added successfully.');
				redirect(base_url().'category/manage-category');
				
			}else{
				$this->session->set_flashdata('err_message', '- New Category is not added. Something went wrong, please try again.');
				redirect(base_url().'category/manage-category/add-new-category');
				
			}//end if($add_new_category)
			
		}//end if($check_if_cat_exist == 0)

	}//end add_new_category_process
	
	//Edit Category
	public function edit_category($cat_id){
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();
		
		//Verify if Page is Accessable
		if(!in_array(22,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if
		
		//Plugin Files Permission
		$data['PLUGIN_datagrid'] = 0;
		$data['PLUGIN_datepicker'] = 0;
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
		$this->breadcrumbcomponent->add('Manage Category', base_url().'category/manage-category');
		$this->breadcrumbcomponent->add('Edit Category', base_url().'category/manage-category/add-new-category/edit-category/'.$cat_id);
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
		
		//Fetching Category Listing
		$get_category_list = $this->mod_category->get_all_categories();
		$data['category_list_arr'] = $get_category_list['category_list_arr'];
		$data['category_list_count'] = $get_category_list['category_list_count'];
		
		//Get Category Data
		$get_category_record = $this->mod_category->get_category($cat_id);
		$data['category_arr'] = $get_category_record['category_arr'];
		$data['category_count'] = $get_category_record['category_arr_count'];
		
		if($get_category_record['category_arr_count'] == 0) redirect(base_url().'errors/page-not-found-404');
		
		$this->load->view('category/edit_category',$data);
		
	}//edit_category

	public function edit_category_process(){
		
		//If Post is not SET
		if(!$this->input->post() && !$this->input->post('add_new_cat_sbt')) redirect(base_url());
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(22,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if
		
		if(trim($this->input->post('category_name')) == ''){
			
			$this->session->set_flashdata('err_message', '- Category Name is empty.');
			redirect(base_url().'category/manage-category/add-new-category');
			
		}//end if(trim($this->input->post('category_name')) == '')

		//Check if The ctaegory name already exist against the selected Parent Category
		$check_if_cat_exist  = $this->mod_category->check_if_category_exist(trim($this->input->post('category_name')),trim($this->input->post('parent_id')),trim($this->input->post('cat_id')));
		
		if($check_if_cat_exist > 0){
			
			$this->session->set_flashdata('err_message', '- Category Name already exist in the selected Parent Category.');
			redirect(base_url().'category/manage-category/add-new-category');
			
		}else{
				
			$upd_new_category = $this->mod_category->edit_category($this->input->post());
			
			if($upd_new_category){

				$this->session->set_flashdata('ok_message', '- Category Updated successfully.');
				redirect(base_url().'category/manage-category/edit-category/'.$this->input->post('cat_id'));
				
			}else{
				$this->session->set_flashdata('err_message', '- Category is not updated. Something went wrong, please try again.');
				redirect(base_url().'category/manage-category');
				
			}//end if($upd_new_category)
			
		}//end if($check_if_cat_exist == 0)

	}//end edit_category_process

	//Delete Category
	public function delete_category($cat_id){

		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(23,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if
		
		//If Post is not SET
		if(!isset($cat_id)) redirect(base_url());
		
		//Updating Page
		$del_category = $this->mod_category->delete_category($cat_id);
		
		if($del_category){
			
			$this->session->set_flashdata('ok_message', '- Category deleted successfully.');
			redirect(base_url().'category/manage-category');
			
		}else{
			$this->session->set_flashdata('err_message', '- Category cannot be deleted. Something went wrong, please try again.');
			redirect(base_url().'category/manage-category');
			
		}//end if($del_category)

	}//end delete_category

}//end Dashboard 
