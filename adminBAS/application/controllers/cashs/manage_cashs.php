<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Manage_Cashs extends CI_Controller {
	
	public function __construct(){
		parent::__construct();

		$this->load->model('admin/mod_admin');
		$this->load->model('cashs/mod_cashs');
		$this->load->model('common/mod_common');
		$this->load->model('site_preferences/mod_preferences');
		$this->load->library('BreadcrumbComponent');
		
	}

	public function index(){
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();
		
		//Verify if Page is Accessable
		if(!in_array(183,$this->session->userdata('permissions_arr'))){
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
		$this->breadcrumbcomponent->add('Manage Cashs', base_url().'cashs/manage-cashs');
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		$data['INC_header_script_top'] = $this->load->view('common/script_header',$data,true);
		$data['INC_header_script_footer'] = $this->load->view('common/script_footer',$data,true);
		$data['INC_top_header'] = $this->load->view('common/top_header','',true);
		$data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel',$data,true);
		$data['INC_footer'] = $this->load->view('common/footer','',true);
		$data['INC_breadcrum'] = $this->load->view('common/breadcrum',$data,true);
		 
		//Permissions
		$data['ALLOW_pages_add'] =   (in_array(142,$this->session->userdata('permissions_arr'))) ? 1 : 0;
		$data['ALLOW_pages_edit'] =   (in_array(143,$this->session->userdata('permissions_arr'))) ? 1 : 0;
		$data['ALLOW_pages_delete'] =   (in_array(144,$this->session->userdata('permissions_arr'))) ? 1 : 0;
		

		//Fetching cashes
		$get_cashes = $this->mod_cashs->get_all_cashs();
		$data['cashs_arr'] = $get_cashes['cashs_arr'];
		$data['cashs_count'] = $get_cashes['cashs_count'];
		$data['total_balance'] = $get_cashes['cashs_arr']['total_balance'];
		
		
		
		$this->load->view('cashs/manage_cashs',$data);
		
	}//end index()
	
	
	
	
	
	//Add New cash
	public function add_cash(){
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();
		
		//Verify if Page is Accessable
		if(!in_array(184,$this->session->userdata('permissions_arr'))){
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
		$this->breadcrumbcomponent->add('Manage Accounts', base_url().'cashs/manage-cashs');
		$this->breadcrumbcomponent->add('Add New Account', base_url().'cashs/manage-cashs/add-cash');
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();

		$data['INC_header_script_top'] = $this->load->view('common/script_header',$data,true);
		$data['INC_header_script_footer'] = $this->load->view('common/script_footer',$data,true);
		$data['INC_top_header'] = $this->load->view('common/top_header','',true);
		$data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel',$data,true);
		$data['INC_footer'] = $this->load->view('common/footer','',true);
		$data['INC_breadcrum'] = $this->load->view('common/breadcrum','',true);
		
		
		$get_all_cities = $this->mod_cashs->get_cities();
		
		
		$data['cities_arr'] = $get_all_cities['cities_result'];
		$data['cities_count'] = $get_all_cities['cities_count'];
		
		
		$this->load->view('cashs/add_cash',$data);
		
	}//add_new_advetisement
	
	
	
	
	
	
	
	//Add New cash
	public function view_account($account_id){
	
		
	
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
	//
		//Bread crum
		$this->breadcrumbcomponent->add('Dashboard', base_url().'dashboard/dashboard');
		$this->breadcrumbcomponent->add('View Cash', base_url().'cashs/manage-cashs');
		$this->breadcrumbcomponent->add('View Cash Account', base_url().'cashs/manage-cashs/view-account');
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
	
		$data['INC_header_script_top'] = $this->load->view('common/script_header',$data,true);
		$data['INC_header_script_footer'] = $this->load->view('common/script_footer',$data,true);
		$data['INC_top_header'] = $this->load->view('common/top_header','',true);
		$data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel',$data,true);
		$data['INC_footer'] = $this->load->view('common/footer','',true);
		$data['INC_breadcrum'] = $this->load->view('common/breadcrum','',true);
	
	
		$get_all_view = $this->mod_cashs->get_cash($account_id);
	
	
		$data['account_arr'] = $get_all_view['cashs_arr'];
		$data['account_count'] = $get_all_view['cashs_count'];
	
	
		$this->load->view('cashs/view_account',$data);
	
	}//add_new_advetisement

	public function add_cash_process(){
		
		
		//If Post is not SET
		if(!$this->input->post() && !$this->input->post('add_cash')) redirect(base_url());
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(184,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if
		
		
		if(trim($this->input->post('title')) == ''){
			
			$err_msg.= '- Petti cash cannot be empty.<br>';
			
		}//end if
		
		if($err_msg !=''){

			$this->session->set_flashdata('err_message', $err_msg);
			redirect(base_url().'cashs/manage-cashs/add-cash');
			
		}//end if($err_msg !='')
		
		
		//Adding New cash
		$add_cash = $this->mod_cashs->add_cash($this->input->post());

		if($add_cash && $add_cash['error'] == ''){		
			
			$this->session->set_flashdata('ok_message', '- New Cash added successfully.');
			redirect(base_url().'cashs/manage-cashs');
			
		}else{
			
			if($add_cash['error'] != ''){

				$this->session->set_flashdata('err_message', '- '.strip_tags($add_slider_image['error']));
				redirect(base_url().'cashs/manage-cashs/add-cash');
				
			}else{
				$this->session->set_flashdata('err_message', '- New Cash is not Added. Something went wrong, please try again.');
				redirect(base_url().'cashs/manage-cashs/add-cash');
				
			}//end if
			
		}//end if

	}//end

	
	
	//Edit cash
	public function edit_cash($cash_id){

		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(185,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if

		//Plugin Files Permission
		$data['PLUGIN_datagrid'] = 0;
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
		$this->breadcrumbcomponent->add('Manage Cashs', base_url().'cashs/manage-cashs');
		$this->breadcrumbcomponent->add('Edit Cashs', base_url().'cashs/manage-cashs/edit-cash/'.$cash_id);
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		$data['INC_header_script_top'] = $this->load->view('common/script_header',$data,true);
		$data['INC_header_script_footer'] = $this->load->view('common/script_footer',$data,true);
		$data['INC_top_header'] = $this->load->view('common/top_header','',true);
		$data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel',$data,true);
		$data['INC_footer'] = $this->load->view('common/footer','',true);
		$data['INC_breadcrum'] = $this->load->view('common/breadcrum','',true);
		
		//Fetching Image slider Results
		$get_cash = $this->mod_cashs->get_cash($cash_id);
		
				
		$data['cashs_arr'] = $get_cash['cashs_arr'];
		$data['cashs_count'] = $get_cash['cashs_count'];
		$data['cash_id']= $cash_id;
		
		
		$get_all_cities = $this->mod_cashs->get_cities();
		
		
		$data['cities_arr'] = $get_all_cities['cities_result'];
		$data['cities_count'] = $get_all_cities['cities_count'];
		
		if($get_cash['cashs_count'] == 0) redirect(base_url());
		
		$this->load->view('cashs/edit_cash',$data);
		
	}//edit_cash
	

	public function edit_cash_process(){
		
		//If Post is not SET
		if(!$this->input->post() && !$this->input->post('edit_cash')) redirect(base_url());
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(143,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if

		//Updating record
		$upd_cash = $this->mod_cashs->edit_cash($this->input->post());
		
		if($upd_cash && $upd_cash['error'] == ''){	
			
			$this->session->set_flashdata('ok_message', '- Cash updated successfully.');
			redirect(base_url().'cashs/manage-cashs/');
			
		}else{

			if($upd_cash['error'] != ''){

				$this->session->set_flashdata('err_message', '- '.strip_tags($upd_slider_image['error']));
				redirect(base_url().'cashs/manage-cashs/');
				
			}else{
				
				$this->session->set_flashdata('err_message', '- Cash is not updated. Something went wrong, please try again.');
				redirect(base_url().'cashs/manage-cashs/');

			}//end if
			
		}//end if

	}//end edit_cash_process
	
	public function delete_cash($cash_id){
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(144,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if
		
		//If Post is not SET
		if(!isset($cash_id)) redirect(base_url());
	
		$del_cash = $this->mod_cashs->delete_cash($cash_id);
		
		if($del_cash){
			
			$this->session->set_flashdata('ok_message', '- Cash deleted successfully.');
			redirect(base_url().'cashs/manage-cashs/');
			
		}else{
			$this->session->set_flashdata('err_message', '- Vendor cannot be deleted. Something went wrong, please try again.');
			redirect(base_url().'cashs/manage-cashs');
			
		}//end if

	}//end delete_cash
	
		public function process_cash_grid(){
		
		echo $this->mod_cashs->get_filter_cash_grid_data();
		
	}//end 
	
	
	//Cash Ledger
	public function cash_ledger(){
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();
		
		//Verify if Page is Accessable
		if(!in_array(187,$this->session->userdata('permissions_arr'))){
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
		$this->breadcrumbcomponent->add('Manage Cashs', base_url().'cashs/manage-cashs');
		$this->breadcrumbcomponent->add('Cash Ledger', base_url().'cashs/manage-cashs/add-cash');
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();

		$data['INC_header_script_top'] = $this->load->view('common/script_header',$data,true);
		$data['INC_header_script_footer'] = $this->load->view('common/script_footer',$data,true);
		$data['INC_top_header'] = $this->load->view('common/top_header','',true);
		$data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel',$data,true);
		$data['INC_footer'] = $this->load->view('common/footer','',true);
		$data['INC_breadcrum'] = $this->load->view('common/breadcrum','',true);
		
		$get_data= $this->mod_cashs->cash_ledger($this->input->post());
		$data['projects_report'] =$get_data ;
		$data['projects_report_data']=$get_data['row_data_arr'];
		$data['projects_report_count']=$get_data['row_data_count'];
		
		$data['from_date']= $this->input->post('from_date');
		$data['to_date']= $this->input->post('to_date');	
	    $data['cash_id']= $this->input->post('cash_id');
		
		//Fetching cashes
		$get_cashes = $this->mod_cashs->get_all_cash_account();
		$data['cashs_arr'] = $get_cashes['cashs_arr'];
		$data['cashs_count'] = $get_cashes['cashs_count'];
		
		/*echo "<pre>";
		print_r($data['cashs_arr']);
		exit;*/
		
		$this->load->view('cashs/cash_ledger',$data);
		
	}//cash_ledger
	
	
	//Add New cash
	public function cash_in(){
	
		//Login Check
		$this->mod_admin->verify_is_admin_login();
	
		//Verify if Page is Accessable
		if(!in_array(188,$this->session->userdata('permissions_arr'))){
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
		$this->breadcrumbcomponent->add('Manage Cash', base_url().'cashs/manage-cashs');
		$this->breadcrumbcomponent->add('Add Cash in Account', base_url().'cashs/manage-cashs/cash-in');
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
	
		$data['INC_header_script_top'] = $this->load->view('common/script_header',$data,true);
		$data['INC_header_script_footer'] = $this->load->view('common/script_footer',$data,true);
		$data['INC_top_header'] = $this->load->view('common/top_header','',true);
		$data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel',$data,true);
		$data['INC_footer'] = $this->load->view('common/footer','',true);
		$data['INC_breadcrum'] = $this->load->view('common/breadcrum','',true);
	
		$get_all_cash = $this->mod_cashs->get_all_cash_account();
	
		$data['cashs_arr'] = $get_all_cash['cashs_arr'];
		$data['cashs_count'] = $get_all_cash['cashs_count'];
	
		$this->load->view('cashs/cash-in',$data);
	
	}//add_new_advetisement
	
	
	public function add_cash_in_process(){
	
		
			
		//If Post is not SET
		if(!$this->input->post() && !$this->input->post('add_cash')) redirect(base_url());
	
		//Login Check
		$this->mod_admin->verify_is_admin_login();
	
		//Verify if Page is Accessable
		if(!in_array(188,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if
	
	
		if(trim($this->input->post('amount')) == ''){
				
			$err_msg= ' Amount cannot be empty.<br>';
				
		}//end if
	
		if($err_msg !=''){
	
			$this->session->set_flashdata('err_message', $err_msg);
			redirect(base_url().'cashs/manage-cashs/cash-in');
				
		}//end if($err_msg !='')
	
	
		//Adding New cash
		$add_cash = $this->mod_cashs->cash_in_process($this->input->post());
	
		if($add_cash && $add_cash['error'] == ''){
				
			$this->session->set_flashdata('ok_message', ' New transaction has been added successfully.');
			redirect(base_url().'cashs/manage-cashs/cash-in');
				
		}else{
				
			if($add_cash['error'] != ''){
	
				$this->session->set_flashdata('err_message', '- '.strip_tags($error['error']));
				redirect(base_url().'cashs/manage-cashs/cash-in');
	
			}else{
				$this->session->set_flashdata('err_message', ' New transaction is not Added. Something went wrong, please try again.');
				redirect(base_url().'cashs/manage-cashs/cash-in');
	
			}//end if
				
		}//end if
	
	}//end
	
	
	
	public function cash_out(){
	
		//Login Check
		$this->mod_admin->verify_is_admin_login();
	
		//Verify if Page is Accessable
		if(!in_array(189,$this->session->userdata('permissions_arr'))){
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
		$this->breadcrumbcomponent->add('Manage Cash', base_url().'cashs/manage-cashs');
		$this->breadcrumbcomponent->add('Add Cash-Out Account', base_url().'cashs/manage-cashs/cash-out');
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
	
		$data['INC_header_script_top'] = $this->load->view('common/script_header',$data,true);
		$data['INC_header_script_footer'] = $this->load->view('common/script_footer',$data,true);
		$data['INC_top_header'] = $this->load->view('common/top_header','',true);
		$data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel',$data,true);
		$data['INC_footer'] = $this->load->view('common/footer','',true);
		$data['INC_breadcrum'] = $this->load->view('common/breadcrum','',true);
	
		$get_all_cash = $this->mod_cashs->get_all_cash_account();
	
		$data['cashs_arr'] = $get_all_cash['cashs_arr'];
		$data['cashs_count'] = $get_all_cash['cashs_count'];
		
		

		
		
	
		$this->load->view('cashs/cash-out',$data);
	
	}//add_new_advetisement
	
	public function add_cash_out_process(){
	
	
			
		//If Post is not SET
		if(!$this->input->post() && !$this->input->post('add_cash')) redirect(base_url());
	
		//Login Check
		$this->mod_admin->verify_is_admin_login();
	
		//Verify if Page is Accessable
		if(!in_array(189,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if
	
	
		if(trim($this->input->post('amount')) == ''){
	
			$err_msg.= '- Amount cannot be empty.<br>';
	
		}//end if
	
		if($err_msg !=''){
	
			$this->session->set_flashdata('err_message', $err_msg);
			redirect(base_url().'cashs/manage-cashs/cash-out');
	
		}//end if($err_msg !='')
	
	
		//Adding New cash
		$add_cash = $this->mod_cashs->cash_out_process($this->input->post());
		
		
		
		
	
		if($add_cash && $add_cash['error'] == ''){
	
			$this->session->set_flashdata('ok_message', ' New transaction has been added successfully.');
			redirect(base_url().'cashs/manage-cashs/cash-out');
			
		
	
		}else{
	
			if($add_cash['error'] != ''){
	
				$this->session->set_flashdata('err_message', '- '.strip_tags($add_slider_image['error']));
				redirect(base_url().'cashs/manage-cashs/cash-out');
	
			}else{
				$this->session->set_flashdata('err_message', '- New Cash is not Added. Something went wrong, please try again.');
				redirect(base_url().'cashs/manage-cashs/cash-out');
	
			}//end if
	
		}//end if
	
	}//end
	
	public function expected_cash_ledger(){
	
		//Login Check
		$this->mod_admin->verify_is_admin_login();
	
		//Verify if Page is Accessable
		if(!in_array(182,$this->session->userdata('permissions_arr'))){
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
		$this->breadcrumbcomponent->add('Manage Cashs', base_url().'cashs/manage-cashs');
		$this->breadcrumbcomponent->add('Cash Ledger', base_url().'cashs/manage-cashs/add-cash');
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
	
		$data['INC_header_script_top'] = $this->load->view('common/script_header',$data,true);
		$data['INC_header_script_footer'] = $this->load->view('common/script_footer',$data,true);
		$data['INC_top_header'] = $this->load->view('common/top_header','',true);
		$data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel',$data,true);
		$data['INC_footer'] = $this->load->view('common/footer','',true);
		$data['INC_breadcrum'] = $this->load->view('common/breadcrum','',true);
	
		$get_data= $this->mod_cashs->cash_ledger($this->input->post());
		$data['projects_report'] =$get_data ;
		$data['projects_report_data']=$get_data['row_data_arr'];
		$data['projects_report_count']=$get_data['row_data_count'];
	
		$data['from_date']= $this->input->post('from_date');
		$data['to_date']= $this->input->post('to_date');
		$data['cash_id']= $this->input->post('cash_id');
	
		//Fetching cashes
		$get_cashes = $this->mod_cashs->get_all_cashs();
		$data['cashs_arr'] = $get_cashes['cashs_arr'];
		$data['cashs_count'] = $get_cashes['cashs_count'];
	
		$this->load->view('cashs/expected_cash_ledger',$data);
	
	}//cash_ledger
	
	
	
	public function approve_ledger_payment($ledger_id){
	
	
		//Login Check
		$this->mod_admin->verify_is_admin_login();
	
		//Verify if Page is Accessable
		if(!in_array(143,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if
	
		//Updating record
		$upd_cash = $this->mod_cashs->approve_ledger_payment($ledger_id);
	
		if($upd_cash && $upd_cash['error'] == ''){
				
			$this->session->set_flashdata('ok_message', '- Cash updated successfully.');
			redirect(base_url().'cashs/manage-cashs/expected-cash-ledger/');
				
		}else{
	
			if($upd_cash['error'] != ''){
	
				$this->session->set_flashdata('err_message', '- '.strip_tags($upd_slider_image['error']));
				redirect(base_url().'cashs/manage-cashs/expected-cash-ledger/');
	
			}else{
	
				$this->session->set_flashdata('err_message', '- Cash is not updated. Something went wrong, please try again.');
				redirect(base_url().'cashs/manage-cashs/expected-cash-ledger/');
	
			}//end if
				
		}//end if
	
	}//end edit_cash_process
	
	public function send_email_ledger(){
	
		
	    //Login Check
		$this->mod_admin->verify_is_admin_login();
	
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
		$this->breadcrumbcomponent->add('Manage Cashs', base_url().'cashs/manage-cashs');
		$this->breadcrumbcomponent->add('Send Email', base_url().'cashs/manage-cashs/add-cash');
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
	
		$data['INC_header_script_top'] = $this->load->view('common/script_header',$data,true);
		$data['INC_header_script_footer'] = $this->load->view('common/script_footer',$data,true);
		$data['INC_top_header'] = $this->load->view('common/top_header','',true);
		$data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel',$data,true);
		$data['INC_footer'] = $this->load->view('common/footer','',true);
		$data['INC_breadcrum'] = $this->load->view('common/breadcrum','',true);
	
		$data['email_data']= $this->input->post('email_record');
	
		$this->load->view('cashs/send_email',$data);
	
	
	}//end send_email
	
	
	public function send_email_ledger_process(){
	
	
		//Login Check
		$this->mod_admin->verify_is_admin_login();
	
	
		$send_email = $this->mod_cashs->send_email_ledger($this->input->post());
	
		if($send_email && $send_email['error'] == ''){
				
			$this->session->set_flashdata('ok_message', 'Email Send successfully.');
			redirect(base_url().'cashs/manage-cashs/cash-ledger/');
				
		}else{
	
				$this->session->set_flashdata('err_message', 'Email can not Send. Something went wrong, please try again.');
				redirect(base_url().'cashs/manage-cashs/cash-ledger/');
	
				
		}//end if
	
	}//end send_email_ledger_process

}//end Dashboard 
