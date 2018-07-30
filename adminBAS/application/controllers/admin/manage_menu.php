<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Manage_menu extends CI_Controller {
	
	public function __construct(){
		parent::__construct();

		$this->load->model('admin/mod_admin');
		$this->load->model('admin/mod_menu');
		$this->load->model('common/mod_common');
		
		$this->load->library('BreadcrumbComponent');
		
	}

	public function index(){
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();
		
		
		//Verify if Page is Accessable
		if(!in_array(196,$this->session->userdata('permissions_arr'))){
			
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
		$this->breadcrumbcomponent->add('Manage Menu Items', base_url().'admin/manage-menu');
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		$data['INC_header_script_top'] = $this->load->view('common/script_header',$data,true);
		$data['INC_header_script_footer'] = $this->load->view('common/script_footer',$data,true);
		$data['INC_top_header'] = $this->load->view('common/top_header','',true);
		$data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel',$data,true);
		$data['INC_footer'] = $this->load->view('common/footer','',true);
		$data['INC_breadcrum'] = $this->load->view('common/breadcrum',$data,true);
		 
		//Permissions
		$data['ALLOW_pages_edit'] =   (in_array(197,$this->session->userdata('permissions_arr'))) ? 1 : 0;
		$data['ALLOW_pages_delete'] =   (in_array(198,$this->session->userdata('permissions_arr'))) ? 1 : 0;
		$data['ALLOW_pages_add'] =   (in_array(195,$this->session->userdata('permissions_arr'))) ? 1 : 0;
		
		//Fetching Pages Results
		// all_menu Method in mod_menu
		$get_menu = $this->mod_menu->get_all_menu();
		

		$data['menu_result_arr'] = $get_menu['menu_all_arr'];
		
	
		$data['menu_result_count'] = $get_menu['menu_all_count'];

		
		
		$this->load->view('admin/manage_menu',$data);

		
	}//end index()
	
	//Add New Page
	public function add_menu(){
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();
		
		//Verify if Page is Accessable
		if(!in_array(195,$this->session->userdata('permissions_arr'))){
			
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
		$this->breadcrumbcomponent->add('Manage Menu Items', base_url().'admin/manage-menu');
		$this->breadcrumbcomponent->add('Add New Item', base_url().'admin/manage-menu/add-menu');
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		$data['INC_header_script_top'] = $this->load->view('common/script_header',$data,true);
		$data['INC_header_script_footer'] = $this->load->view('common/script_footer',$data,true);
		$data['INC_top_header'] = $this->load->view('common/top_header','',true);
		$data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel',$data,true);
		$data['INC_footer'] = $this->load->view('common/footer','',true);
		$data['INC_breadcrum'] = $this->load->view('common/breadcrum','',true);
		//getting categories
			$get_items = $this->mod_menu->get_all_parentid();
		$data['items_result_arr'] = $get_items['items_result'];
		
		$data['items_result_count'] = $get_items['items_count'];
		
		
		$this->load->view('admin/add_menu',$data);
		
	}//add_new_page

	public function add_menu_process(){
		
		//If Post is not SET
	
		if(!$this->input->post() && !$this->input->post('add_menu_sbt')) redirect(base_url());
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(195,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if
		

		$data_arr['add-menu-data'] = $this->input->post();
		$this->session->set_userdata($data_arr);

		if(trim($this->input->post('menu_title')) == ''){
			
			$this->session->set_flashdata('err_message', '- New Item is not added. TITLE missing.');
			redirect(base_url().'admin/manage-menu/add-menu');
			
		}//end if(trim($this->input->post('page_title')) == '')

		//Adding New Page
		$add_menu = $this->mod_menu->add_new_menu($this->input->post());
		
		if($add_menu){
			
			//Unset POST values from session
			$this->session->unset_userdata('add-menu-data');
			
			$this->session->set_flashdata('ok_message', '- New Item added successfully.');
			redirect(base_url().'admin/manage-menu');
			
		}else{
			$this->session->set_flashdata('err_message', '- New Question is not added. Something went wrong, please try again.');
			
			redirect(base_url().'admin/manage-menu/add-menu');
			
		}//end if($add_menu)

	}//end add_menu_process

	//Edit Page
	public function edit_menu($page_id){
		
		//Login Check
	
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(197,$this->session->userdata('permissions_arr'))){
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
		$this->breadcrumbcomponent->add('Manage Menu Items', base_url().'admin/manage-menu');
		$this->breadcrumbcomponent->add('Edit Menu Item', base_url().'admin/manage-menu/edit_menu');
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		$data['INC_header_script_top'] = $this->load->view('common/script_header',$data,true);
		$data['INC_header_script_footer'] = $this->load->view('common/script_footer',$data,true);
		$data['INC_top_header'] = $this->load->view('common/top_header','',true);
		$data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel',$data,true);
		$data['INC_footer'] = $this->load->view('common/footer','',true);
		$data['INC_breadcrum'] = $this->load->view('common/breadcrum','',true);
		
		//Fetching Pages Results
		$get_menu = $this->mod_menu->get_menu($page_id);
		$get_items=$this->mod_menu->get_all_parentid();
			
		$data['menu_data_arr'] = $get_menu['menu1_all_arr'];
		$data['menu_data_count'] = $get_menu['menu1_all_count'];
		$data['items_data1'] = $get_items['items_result'];
		if($get_menu['menu1_all_count'] == 0) redirect(base_url());
		
		$this->load->view('admin/edit_menu',$data);
		
	}//add_new_page

	public function edit_menu_process(){
		
		//If Post is not SET
		
		if(!$this->input->post() && !$this->input->post('upd_menu_sbt')) redirect(base_url());
		
		$page_id = $this->input->post('page_id');
		
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(197,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if

		if(trim($this->input->post('menu_title')) == ''){
			
			$this->session->set_flashdata('err_message', '- MENU is not updated. SomeThng Went missing.');
			redirect(base_url().'admin/manage-menu/edit-menu/'.$page_id);
			
		}//end if(trim($this->input->post('page_title')) == '')

		//Updating Page
		$upd_menu_page = $this->mod_menu->edit_new_menu($this->input->post());
		
		if($upd_menu_page){
			
			$this->session->set_flashdata('ok_message', '- Question updated successfully.');
			redirect(base_url().'admin/manage-menu');
			
		}else{
			$this->session->set_flashdata('err_message', '- MENU is not updated. Something went wrong, please try again.');
			redirect(base_url().'admin/manage-menu/edit-menu/'.$page_id);
			
		}//end if($add_cms_page)

	}//end add_page_process
	
	public function delete_menu($page_id){
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(198,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if
		
		//If Post is not SET
		
		if(!isset($page_id)) redirect(base_url());
		
		//Updating Page
		$del_menu = $this->mod_menu->delete_menu($page_id);
		
		
		if($del_menu){
			
			$this->session->set_flashdata('ok_message', '- Item deleted successfully.');
			redirect(base_url().'admin/manage-menu');
			
		}else{
			$this->session->set_flashdata('err_message', '- Item cannot be deleted. Something went wrong, please try again.');
			redirect(base_url().'admin/manage-menu');
			
		}//end if($add_cms_page)

	}//end delete_page

}//end Dashboard 
