<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Manage_Products extends CI_Controller {

	public function __construct(){
		parent::__construct();

		$this->load->model('admin/mod_admin');
		$this->load->model('products/mod_products');
		$this->load->model('common/mod_common');
		
		$this->load->library('BreadcrumbComponent');
		
	}

	public function index(){
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();
		
		//Verify if Page is Accessable
		if(!in_array(25,$this->session->userdata('permissions_arr'))){
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
		
		
		//Permissions
		$data['ALLOW_user_edit'] =   (in_array(27,$this->session->userdata('permissions_arr'))) ? 1 : 0;
		$data['ALLOW_user_delete'] =   (in_array(28,$this->session->userdata('permissions_arr'))) ? 1 : 0;
		$data['ALLOW_pages_add'] =   (in_array(26,$this->session->userdata('permissions_arr'))) ? 1 : 0;

		$fetch_nav_panel = $this->mod_common->fetch_admin_nav_panel();
		$data['nav_panel_arr'] = $fetch_nav_panel;

		//Bread crum
		$this->breadcrumbcomponent->add('Dashboard', base_url().'dashboard/dashboard');
		$this->breadcrumbcomponent->add('Manage Products', base_url().'products/manage-products');
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
		
		//Fetching All Packages Results
		$products_list_arr = $this->mod_products->get_all_products();
		
		$data['products_list_arr'] = $products_list_arr['products_list_arr'];
		$data['products_list_count'] = $products_list_arr['products_list_count'];
		
		/*echo "<pre>";
		print_r($data['products_list_count']);*/
	
		$this->load->view('products/manage_products',$data);
		
	}//end index()
	
	public function process_packages_grid(){
		
		echo $this->mod_packages->get_filter_packages_grid_data();
		
	}//end 
	
	//Add New packages
	public function add_new_products(){
		
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
		$this->breadcrumbcomponent->add('Manage Products', base_url().'products/manage-products');
		$this->breadcrumbcomponent->add('Add New Products', base_url().'products/manage-products/add-new-products');
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

		//Fetching products Category Listing
		$get_categories_list = $this->mod_products->get_all_categories();
		$data['categories_list_arr'] = $get_categories_list;
		$data['categories_count'] = $get_categories_list['categories_count'];
		
			
		
		//Random number generator
         $product_code = $this->mod_common->random_number_generator(7);
		 $product_code = $this->mod_products->product_code_generator($product_code);
		 
		// $data['product_code'] = $product_code;
		 
		 $product_sess_array = array(
					'logged_in' => true,
					'product_code' => $product_code
					);
					
		$this->session->set_userdata($product_sess_array);
		$this->session->userdata('product_code');
		
		
		
		$this->load->view('products/add_new_products',$data);
		
	}//add_new_packages

	public function add_new_products_process(){
		
	
		//If Post is not SET
		if(!$this->input->post() && !$this->input->post('add_products_sbt')) redirect(base_url());
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(21,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if
		
		

		if(trim($this->input->post('product_name')) == ''){
			
			$this->session->set_flashdata('err_message', '- Product Name is empty.');
			redirect(base_url().'products/manage-products/add-new-products');
			
		}//end if
		
		
	
		$add_new_products = $this->mod_products->add_new_products($this->input->post());

			if($add_new_products){
				
				$this->session->set_flashdata('ok_message', '- New Product added successfully.');
				redirect(base_url().'products/manage-products/add-new-products');
				
			}else{
				$this->session->set_flashdata('err_message', '- New Packages is not added. Something went wrong, please try again.');
				redirect(base_url().'products/manage-products/add-new-products');
				
			}//end if($add_new_packages)
			
		
	}//end add_new_product_process
	
	//Edit products
	public function edit_products($product_id){
		
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
		$this->breadcrumbcomponent->add('Manage Products', base_url().'products/manage-products');
		$this->breadcrumbcomponent->add('Edit products', base_url().'/manage-products/edit-products');
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
		
		//Fetching products Category Listing
		$get_categories_list = $this->mod_products->get_all_categories();
		$data['categories_list_arr'] = $get_categories_list;
		
		//Get product Data
		$get_product_record = $this->mod_products->get_products($product_id);
		$data['product_arr'] = $get_product_record['product_arr'];
		$data['product_count'] = $get_product_record['product_arr_count'];
		
		$get_product_images = $this->mod_products->get_products_images($product_id);
		$data['product_images_arr'] = $get_product_images['product_images_arr'];
		$data['product_images_count'] = $get_product_images['product_images_arr_count'];
		
		
		
		$this->load->view('products/edit_products',$data);
		
	}//edit_packages

	public function edit_products_process(){
		
		//If Post is not SET
		if(!$this->input->post() && !$this->input->post('edit_products_sbt')) redirect(base_url());
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(22,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if
		
		if(trim($this->input->post('product_name')) == ''){
			
			$this->session->set_flashdata('err_message', '- Product Name is empty.');
			redirect(base_url().'products/manage-products/edit-products'.$product_id);
			
		}//end if(trim($this->input->post('packages_name')) == '')

		
				
			$upd_new_product = $this->mod_products->edit_product($this->input->post());
			
			if($upd_new_product){

				$this->session->set_flashdata('ok_message', '- Product Updated successfully.');
				redirect(base_url().'products/manage-products');
				
			}else{
				$this->session->set_flashdata('err_message', '- product is not updated. Something went wrong, please try again.');
				redirect(base_url().'products/manage-products');
				
			}//end if($upd_new_packages)
			
	

	}//end edit_products_process

	//Delete products
	public function delete_products($product_id){

		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(23,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if
		
		
		$del_products = $this->mod_products->delete_products($product_id);
		
		if($del_products){
			
			$this->session->set_flashdata('ok_message', '- product deleted successfully.');
			redirect(base_url().'products/manage-products');
			
		}else{
			$this->session->set_flashdata('err_message', '- product cannot be deleted. Something went wrong, please try again.');
			redirect(base_url().'products/manage-products');
			
		}//end if

	}//end delete_products
	
	
	//Delete products
	public function delete_products_images($image_id,$product_code){
		

		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(23,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if
		
		
		$del_products_images = $this->mod_products->delete_products_images($image_id);
		
		if($del_products_images){
			
			$this->session->set_flashdata('ok_message', '- Product images deleted successfully.');
			redirect(base_url().'products/manage-products/edit_products/'.$product_code);
			
		}else{
			$this->session->set_flashdata('err_message', '- Product images cannot be deleted. Something went wrong, please try again.');
			redirect(base_url().'products/manage-products/edit_products/'.$product_code);
			
		}//end if

	}//end delete_products

}//end Dashboard 
