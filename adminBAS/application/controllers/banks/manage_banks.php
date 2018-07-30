<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Manage_Banks extends CI_Controller {
	
	public function __construct(){
		parent::__construct();

		$this->load->model('admin/mod_admin');
		$this->load->model('banks/mod_banks');
		$this->load->model('common/mod_common');
		$this->load->model('branches/mod_branches');
		$this->load->model('site_preferences/mod_preferences');
		$this->load->library('BreadcrumbComponent');
		
	}

	public function index(){
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();
		
		//Verify if Page is Accessable
		if(!in_array(138,$this->session->userdata('permissions_arr'))){
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
		$this->breadcrumbcomponent->add('Manage Banks', base_url().'banks/manage-banks');
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		$data['INC_header_script_top'] = $this->load->view('common/script_header',$data,true);
		$data['INC_header_script_footer'] = $this->load->view('common/script_footer',$data,true);
		$data['INC_top_header'] = $this->load->view('common/top_header','',true);
		$data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel',$data,true);
		$data['INC_footer'] = $this->load->view('common/footer','',true);
		$data['INC_breadcrum'] = $this->load->view('common/breadcrum',$data,true);
		 
		//Permissions
		$data['ALLOW_pages_add'] =   (in_array(139,$this->session->userdata('permissions_arr'))) ? 1 : 0;
		$data['ALLOW_pages_edit'] =   (in_array(145,$this->session->userdata('permissions_arr'))) ? 1 : 0;
		$data['ALLOW_pages_delete'] =   (in_array(146,$this->session->userdata('permissions_arr'))) ? 1 : 0;
		

		//Fetching bankes
		$get_bankes = $this->mod_banks->get_all_banks();
		
		$data['banks_arr'] = $get_bankes['banks_arr'];
		$data['banks_count'] = $get_bankes['banks_count'];
		$data['total_balance'] = $get_bankes['banks_arr']['total_balance'];
		
		
		
		$this->load->view('banks/manage_banks',$data);
		
	}//end index()
	
	//Add New bank
	public function add_bank(){
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();
		
		//Verify if Page is Accessable
		if(!in_array(176,$this->session->userdata('permissions_arr'))){
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
		$this->breadcrumbcomponent->add('Manage Banks', base_url().'banks/manage-banks');
		$this->breadcrumbcomponent->add('Add New Bank', base_url().'banks/manage-banks/add-bank');
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();

		$data['INC_header_script_top'] = $this->load->view('common/script_header',$data,true);
		$data['INC_header_script_footer'] = $this->load->view('common/script_footer',$data,true);
		$data['INC_top_header'] = $this->load->view('common/top_header','',true);
		$data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel',$data,true);
		$data['INC_footer'] = $this->load->view('common/footer','',true);
		$data['INC_breadcrum'] = $this->load->view('common/breadcrum','',true);
		
		 //Get All Branches
		$get_all_branches = $this->mod_branches->get_all_branches();
		$data['branches_arr'] = $get_all_branches['branches_arr'];
		$data['branches_count'] = $get_all_branches['branches_count'];
		
		
		$get_all_cities = $this->mod_banks->get_cities();
		$data['cities_arr'] = $get_all_cities['cities_result'];
		$data['cities_count'] = $get_all_cities['cities_count'];
		
		$this->load->view('banks/add_bank',$data);
		
	}//add_new_advetisement

	public function add_bank_process(){
		
		
		//If Post is not SET
		if(!$this->input->post() && !$this->input->post('add_bank')) redirect(base_url());
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(139,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if
		
		
		if(trim($this->input->post('bank_name')) == ''){
			
			$err_msg.= '- Bank Name cannot be empty.<br>';
			
		}//end if
		
		if($err_msg !=''){

			$this->session->set_flashdata('err_message', $err_msg);
			redirect(base_url().'banks/manage-banks/add-bank');
			
		}//end if($err_msg !='')
		
		
		//Adding New bank
		$add_bank = $this->mod_banks->add_bank($this->input->post());

		if($add_bank && $add_bank['error'] == ''){		
			
			$this->session->set_flashdata('ok_message', '- New Bank added successfully.');
			redirect(base_url().'banks/manage-banks/add-bank');
			
		}else{
			
			if($add_bank['error'] != ''){

				$this->session->set_flashdata('err_message', '- '.strip_tags($add_slider_image['error']));
				redirect(base_url().'banks/manage-banks/add-bank');
				
			}else{
				$this->session->set_flashdata('err_message', '- New Bank is not Added. Something went wrong, please try again.');
				redirect(base_url().'banks/manage-banks/add-bank');
				
			}//end if
			
		}//end if

	}//end

	
	
	//Edit bank
	public function edit_bank($bank_id){

		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(177,$this->session->userdata('permissions_arr'))){
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
		$this->breadcrumbcomponent->add('Manage Banks', base_url().'banks/manage-banks');
		$this->breadcrumbcomponent->add('Edit Banks', base_url().'banks/manage-banks/edit-bank/'.$bank_id);
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		$data['INC_header_script_top'] = $this->load->view('common/script_header',$data,true);
		$data['INC_header_script_footer'] = $this->load->view('common/script_footer',$data,true);
		$data['INC_top_header'] = $this->load->view('common/top_header','',true);
		$data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel',$data,true);
		$data['INC_footer'] = $this->load->view('common/footer','',true);
		$data['INC_breadcrum'] = $this->load->view('common/breadcrum','',true);
		
		//Get All Branches
		$get_all_branches = $this->mod_branches->get_all_branches();
		$data['branches_arr'] = $get_all_branches['branches_arr'];
		$data['branches_count'] = $get_all_branches['branches_count'];
		
		
		//Fetching Image slider Results
		$get_bank = $this->mod_banks->get_bank($bank_id);
		$data['banks_arr'] = $get_bank['banks_arr'];
		$data['banks_count'] = $get_bank['banks_count'];
		
		
		$get_all_cities = $this->mod_banks->get_cities();
		$data['cities_arr'] = $get_all_cities['cities_result'];
		$data['cities_count'] = $get_all_cities['cities_count'];
		
		$data['bank_id']= $bank_id;
		
		if($get_bank['banks_count'] == 0) redirect(base_url());
		
		$this->load->view('banks/edit_bank',$data);
		
	}//edit_bank
	
	
	
	public function view_account($bank_id){
	
		//Login Check
		$this->mod_admin->verify_is_admin_login();
	
	
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
		$this->breadcrumbcomponent->add('Manage Banks', base_url().'banks/manage-banks');
		$this->breadcrumbcomponent->add('View Bank', base_url().'banks/manage-banks/edit-bank/'.$bank_id);
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
	
		$data['INC_header_script_top'] = $this->load->view('common/script_header',$data,true);
		$data['INC_header_script_footer'] = $this->load->view('common/script_footer',$data,true);
		$data['INC_top_header'] = $this->load->view('common/top_header','',true);
		$data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel',$data,true);
		$data['INC_footer'] = $this->load->view('common/footer','',true);
		$data['INC_breadcrum'] = $this->load->view('common/breadcrum','',true);
	
		//Fetching Image slider Results
		$get_bank = $this->mod_banks->get_bank($bank_id);
	
	
		$data['banks_arr'] = $get_bank['banks_arr'];
		$data['banks_count'] = $get_bank['banks_count'];
	
	
		$get_all_cities = $this->mod_banks->get_cities();
	
	
		$data['cities_arr'] = $get_all_cities['cities_result'];
		$data['cities_count'] = $get_all_cities['cities_count'];
	
		$data['bank_id']= $bank_id;
	
		if($get_bank['banks_count'] == 0) redirect(base_url());
	
		$this->load->view('banks/view_account',$data);
	
	}//edit_bank
	
	

	public function edit_bank_process(){
		
		//If Post is not SET
		if(!$this->input->post() && !$this->input->post('edit_bank')) redirect(base_url());
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(177,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if

		//Updating record
		$upd_bank = $this->mod_banks->edit_bank($this->input->post());
		
		if($upd_bank && $upd_bank['error'] == ''){	
			
			$this->session->set_flashdata('ok_message', '- Bank updated successfully.');
			redirect(base_url().'banks/manage-banks/');
			
		}else{

			if($upd_bank['error'] != ''){

				$this->session->set_flashdata('err_message', '- '.strip_tags($upd_slider_image['error']));
				redirect(base_url().'banks/manage-banks/');
				
			}else{
				
				$this->session->set_flashdata('err_message', '- Bank is not updated. Something went wrong, please try again.');
				redirect(base_url().'banks/manage-banks/');

			}//end if
			
		}//end if

	}//end edit_bank_process
	
	public function delete_bank($bank_id){
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(146,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if
		
		//If Post is not SET
		if(!isset($bank_id)) redirect(base_url());
	
		$del_bank = $this->mod_banks->delete_bank($bank_id);
		
		if($del_bank){
			
			$this->session->set_flashdata('ok_message', '- Bank deleted successfully.');
			redirect(base_url().'banks/manage-banks/');
			
		}else{
			$this->session->set_flashdata('err_message', '- Bank cannot be deleted. Something went wrong, please try again.');
			redirect(base_url().'banks/manage-banks');
			
		}//end if

	}//end delete_bank
	
	
	//Grid funtion
		public function process_banks_grid(){
		
		echo $this->mod_banks->get_filter_banks_grid_data();
		
	}//end 
	
	
	//Bank Ledger
	public function bank_ledger(){
		//Login Check
		$this->mod_admin->verify_is_admin_login();
		
		//Verify if Page is Accessable
		if(!in_array(191,$this->session->userdata('permissions_arr'))){
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
		$this->breadcrumbcomponent->add('Manage Banks', base_url().'banks/manage-banks');
		$this->breadcrumbcomponent->add('Bank Ledger', base_url().'cashs/manage-cashs/add-cash');
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();

		$data['INC_header_script_top'] = $this->load->view('common/script_header',$data,true);
		$data['INC_header_script_footer'] = $this->load->view('common/script_footer',$data,true);
		$data['INC_top_header'] = $this->load->view('common/top_header','',true);
		$data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel',$data,true);
		$data['INC_footer'] = $this->load->view('common/footer','',true);
		$data['INC_breadcrum'] = $this->load->view('common/breadcrum','',true);
		
		$get_data= $this->mod_banks->bank_ledger($this->input->post());
		$data['projects_report'] =$get_data ;
		$data['projects_report_data']=$get_data['row_data_arr'];
		$data['projects_report_count']=$get_data['row_data_count'];
		
		$data['from_date']= $this->input->post('from_date');
		$data['to_date']= $this->input->post('to_date');
		$data['bank_id']= $this->input->post('bank_id');
		
		//Fetching bankes
		$get_bankes = $this->mod_banks->get_all_bank_account();
		
		$data['banks_arr'] = $get_bankes['banks_arr'];
		$data['banks_count'] = $get_bankes['banks_count'];
		
		/*echo "<pre>";
			print_r($data['banks_arr']);
			exit;	
		*/
		$this->load->view('banks/bank_ledger',$data);
		
	}//bank_ledger
	
	//Add New cash
	public function cash_in(){
	
		//Login Check
		$this->mod_admin->verify_is_admin_login();
	
		//Verify if Page is Accessable
		if(!in_array(179,$this->session->userdata('permissions_arr'))){
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
		$this->breadcrumbcomponent->add('Manage Banks', base_url().'banks/manage-banks');
		$this->breadcrumbcomponent->add('Deposit', base_url().'banks/manage-banks/cash-in');
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
	
		$data['INC_header_script_top'] = $this->load->view('common/script_header',$data,true);
		$data['INC_header_script_footer'] = $this->load->view('common/script_footer',$data,true);
		$data['INC_top_header'] = $this->load->view('common/top_header','',true);
		$data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel',$data,true);
		$data['INC_footer'] = $this->load->view('common/footer','',true);
		$data['INC_breadcrum'] = $this->load->view('common/breadcrum','',true);
	
		$get_all_cash = $this->mod_banks->get_all_bank_account();
	
		$data['banks_arr'] = $get_all_cash['banks_arr'];
		$data['banks_count'] = $get_all_cash['banks_count'];
		
				
	
		$this->load->view('banks/cash-in',$data);
	
	}//add_new_advetisement
	
	
	public function add_cash_in_process(){
	
	
			
		//If Post is not SET
		if(!$this->input->post() && !$this->input->post('add_cash')) redirect(base_url());
	
		//Login Check
		$this->mod_admin->verify_is_admin_login();
	
		//Verify if Page is Accessable
		if(!in_array(142,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if
	
	
		if(trim($this->input->post('amount')) == ''){
	
			$err_msg.= '- Amount cannot be empty.<br>';
	
		}//end if
	
		if($err_msg !=''){
	
			$this->session->set_flashdata('err_message', $err_msg);
			redirect(base_url().'banks/manage-banks/cash-in');
	
		}//end if($err_msg !='')
	
	
		//Adding New cash
		$add_cash = $this->mod_banks->cash_in_process($this->input->post());
	
		if($add_cash && $add_cash['error'] == ''){
	
			$this->session->set_flashdata('ok_message', 'New Transaction has been added successfully.');
			redirect(base_url().'banks/manage-banks/cash-in');
	
		}else{
	
			if($add_cash['error'] != ''){
	
				$this->session->set_flashdata('err_message', '- '.strip_tags($add_cash['error']));
				redirect(base_url().'banks/manage-banks/cash-in');
	
			}else{
				$this->session->set_flashdata('err_message', '- New Cash is not Added. Something went wrong, please try again.');
				redirect(base_url().'banks/manage-banks/cash-in');
	
			}//end if
	
		}//end if
	
	}//end
	
	
	public function cash_out(){
	
		//Login Check
		$this->mod_admin->verify_is_admin_login();
		
		//Verify if Page is Accessable
		if(!in_array(180,$this->session->userdata('permissions_arr'))){
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
		$this->breadcrumbcomponent->add('Manage Banks', base_url().'banks/manage-banks');
		$this->breadcrumbcomponent->add('Withdrawal', base_url().'banks/manage-banks/cash-in');
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
	
		$data['INC_header_script_top'] = $this->load->view('common/script_header',$data,true);
		$data['INC_header_script_footer'] = $this->load->view('common/script_footer',$data,true);
		$data['INC_top_header'] = $this->load->view('common/top_header','',true);
		$data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel',$data,true);
		$data['INC_footer'] = $this->load->view('common/footer','',true);
		$data['INC_breadcrum'] = $this->load->view('common/breadcrum','',true);
	
		$get_all_cash = $this->mod_banks->get_all_bank_account();
	
		$data['banks_arr'] = $get_all_cash['banks_arr'];
		$data['banks_count'] = $get_all_cash['banks_count'];
	
	
	
		$this->load->view('banks/cash-out',$data);
	
	}//add_new_advetisement
	
	public function add_cash_out_process(){
	
	
			
		//If Post is not SET
		if(!$this->input->post() && !$this->input->post('add_cash')) redirect(base_url());
	
		//Login Check
		$this->mod_admin->verify_is_admin_login();
	
		//Verify if Page is Accessable
		if(!in_array(142,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if
	
	
		if(trim($this->input->post('amount')) == ''){
	
			$err_msg.= '- Amount cannot be empty.<br>';
	
		}//end if
	
		if($err_msg !=''){
	
			$this->session->set_flashdata('err_message', $err_msg);
			redirect(base_url().'banks/manage-banks/cash-out');
	
		}//end if($err_msg !='')
	
	
		//Adding New cash
		$add_cash = $this->mod_banks->cash_out_process($this->input->post());
	
		if($add_cash && $add_cash['error'] == ''){
	
			$this->session->set_flashdata('ok_message', ' New transaction has been added successfully.');
			redirect(base_url().'banks/manage-banks/cash-out');
	
		}else{
	
			if($add_cash['error'] != ''){
	
				$this->session->set_flashdata('err_message', strip_tags($add_cash['error']));
				redirect(base_url().'banks/manage-banks/cash-out');
	
			}else{
				$this->session->set_flashdata('err_message', '  New transaction is not Added. Something went wrong, please try again.');
				redirect(base_url().'banks/manage-banks/cash-out');
	
			}//end if
	
		}//end if
	
	}//end
	
	
	public function expected_bank_ledger(){
	
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();
		
		//Verify if Page is Accessable
		if(!in_array(169,$this->session->userdata('permissions_arr'))){
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
		$this->breadcrumbcomponent->add('Manage Banks', base_url().'banks/manage-banks');
		$this->breadcrumbcomponent->add('Bank Ledger', base_url().'cashs/manage-cashs/add-cash');
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();

		$data['INC_header_script_top'] = $this->load->view('common/script_header',$data,true);
		$data['INC_header_script_footer'] = $this->load->view('common/script_footer',$data,true);
		$data['INC_top_header'] = $this->load->view('common/top_header','',true);
		$data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel',$data,true);
		$data['INC_footer'] = $this->load->view('common/footer','',true);
		$data['INC_breadcrum'] = $this->load->view('common/breadcrum','',true);
		
		$get_data= $this->mod_banks->bank_ledger($this->input->post());
		$data['projects_report'] =$get_data ;
		$data['projects_report_data']=$get_data['row_data_arr'];
		$data['projects_report_count']=$get_data['row_data_count'];
		
		$data['from_date']= $this->input->post('from_date');
		$data['to_date']= $this->input->post('to_date');
		$data['bank_id']= $this->input->post('bank_id');
		
		//Fetching bankes
		$get_bankes = $this->mod_banks->get_all_banks();
		
		$data['banks_arr'] = $get_bankes['banks_arr'];
		$data['banks_count'] = $get_bankes['banks_count'];
		
		/*echo "<pre>";
			print_r($data['banks_arr']);
			exit;	*/
		
		$this->load->view('banks/expected_bank_ledger',$data);
		
	}//bank_ledger
	
	
	public function approve_ledger_payment($ledger_id){
	
	
		//Login Check
		$this->mod_admin->verify_is_admin_login();
	
		//Verify if Page is Accessable
		if(!in_array(143,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if
	
		//Updating record
		$upd_cash = $this->mod_banks->approve_ledger_payment($ledger_id);
	
		if($upd_cash && $upd_cash['error'] == ''){
	
			$this->session->set_flashdata('ok_message', '- Payment updated successfully.');
			redirect(base_url().'banks/manage-banks/expected-bank-ledger/');
	
		}else{
	
			if($upd_cash['error'] != ''){
	
				$this->session->set_flashdata('err_message', '- '.strip_tags($upd_slider_image['error']));
				redirect(base_url().'banks/manage-banks/expected-bank-ledger/');
	
			}else{
	
				$this->session->set_flashdata('err_message', '- Payment is not updated. Something went wrong, please try again.');
				redirect(base_url().'banks/manage-banks/expected-bank-ledger/');
	
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
		$this->breadcrumbcomponent->add('Manage Cashs', base_url().'Banks/manage-banks');
		$this->breadcrumbcomponent->add('Send Email', base_url().'cashs/manage-cashs/add-cash');
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
	
		$data['INC_header_script_top'] = $this->load->view('common/script_header',$data,true);
		$data['INC_header_script_footer'] = $this->load->view('common/script_footer',$data,true);
		$data['INC_top_header'] = $this->load->view('common/top_header','',true);
		$data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel',$data,true);
		$data['INC_footer'] = $this->load->view('common/footer','',true);
		$data['INC_breadcrum'] = $this->load->view('common/breadcrum','',true);
	
		$data['email_data']= $this->input->post('email_record');
	
		$this->load->view('banks/send_email',$data);
	
	
	}//end send_email
	
	
	public function send_email_ledger_process(){
	
	
		//Login Check
		$this->mod_admin->verify_is_admin_login();
	
	
		$send_email = $this->mod_banks->send_email_ledger($this->input->post());
	
		if($send_email && $send_email['error'] == ''){
				
			$this->session->set_flashdata('ok_message', 'Email Send successfully.');
			redirect(base_url().'banks/manage-banks/bank-ledger/');
				
		}else{
	
				$this->session->set_flashdata('err_message', 'Email can not Send. Something went wrong, please try again.');
				redirect(base_url().'banks/manage-banks/bank-ledger/');
	
				
		}//end if
	
	}//end send_email_ledger_process
	

}//end Dashboard 
