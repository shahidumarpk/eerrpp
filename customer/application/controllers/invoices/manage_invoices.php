<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Manage_Invoices extends CI_Controller {

	public function __construct(){

		parent::__construct();
	
		$this->load->model('invoices/mod_invoices');
		$this->load->model('common/mod_common');
		$this->load->model('customers/mod_customer');
		$this->load->library('BreadcrumbComponent');
		
	}

	public function index(){
		//Login Check
		$this->mod_customer->verify_is_customer_login();
		
	
		//Plugin Files Permission
		$data['PLUGIN_datagrid'] = 0;
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
		$this->breadcrumbcomponent->add('Manage Invoices', base_url().'cms/manage-invoices');
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		$data['INC_header_script_top'] = $this->load->view('common/script_header',$data,true);
		$data['INC_header_script_footer'] = $this->load->view('common/script_footer',$data,true);
		$data['INC_top_header'] = $this->load->view('common/top_header','',true);
		$data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel',$data,true);
		$data['INC_footer'] = $this->load->view('common/footer','',true);
		$data['INC_breadcrum'] = $this->load->view('common/breadcrum','',true);


		//Pagination
		$this->load->library('pagination');
		$config['base_url'] = base_url().'invoices/manage-invoices/index';
		$config['total_rows'] = $this->mod_invoices->count_total_invoices();
	
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
		
		$get_invoice_list = $this->mod_invoices->get_invoices_limit($page,$config["per_page"]);
		$data['invoice_list'] = $get_invoice_list['invoice_list_result'];
		$data['invoice_list_count'] = $get_invoice_list['invoice_limit_count'];
		$this->load->view('invoices/manage_invoices',$data);
			
	}//end index()
	
	
	
	
	public function view_invoice($invoice_id){ 
	
	//Login Check
		$this->mod_customer->verify_is_customer_login();
		
	
		
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
		$this->breadcrumbcomponent->add('Create New Invoice', base_url().'invoices/manage-invoices/create_invoice');
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		$data['INC_header_script_top'] = $this->load->view('common/script_header',$data,true);
		$data['INC_header_script_footer'] = $this->load->view('common/script_footer',$data,true);
		$data['INC_top_header'] = $this->load->view('common/top_header','',true);
		$data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel',$data,true);
		$data['INC_footer'] = $this->load->view('common/footer','',true);
		$data['INC_breadcrum'] = $this->load->view('common/breadcrum','',true);
		
		
		$get_invoices_list_data = $this->mod_invoices->get_invoices($invoice_id);
		$data['invoices_list_data_arr'] 	= $get_invoices_list_data['invoice_data_list_arr'];
		$data['invoice_data_list_count']	= $get_invoices_list_data['invoice_data_list_count'];
		
		
		
		$this->load->view('invoices/view_invoice',$data);

	}//end view Invoices
	
	
	public function pay_now($invoice_id){ 
	
	//Login Check
		$this->mod_customer->verify_is_customer_login();
		
		
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
		$this->breadcrumbcomponent->add('Create New Invoice', base_url().'invoices/manage-invoices/create_invoice');
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		$data['INC_header_script_top'] = $this->load->view('common/script_header',$data,true);
		$data['INC_header_script_footer'] = $this->load->view('common/script_footer',$data,true);
		$data['INC_top_header'] = $this->load->view('common/top_header','',true);
		$data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel',$data,true);
		$data['INC_footer'] = $this->load->view('common/footer','',true);
		$data['INC_breadcrum'] = $this->load->view('common/breadcrum','',true);
		
		
		//$get_invoices_list_data = $this->mod_invoices->get_invoices($invoice_id);
		$data['invoices_list_data_arr'] 	= $get_invoices_list_data['invoice_data_list_arr'];
		$data['invoice_data_list_count']	= $get_invoices_list_data['invoice_data_list_count'];
		$data['invoice_id']	= $invoice_id;
		
		
		
		$this->load->view('invoices/pay_now',$data);

	}//end pay_now
	
	public function pay_now_process(){
		
		//Login Check
		$this->mod_customer->verify_is_customer_login();
		
		//If Post is not SET
		if(!$this->input->post() && !$this->input->post('pay_now_sbt')) redirect(base_url());
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(8,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if
		
		
		$err_msg = '';
		if(trim($this->input->post('customer_name')) == ''){
			
			$err_msg.= '- Customer Name cannot be empty.<br>';
			
		}//end if(trim($this->input->post('page_title')) == '')

		if(trim($this->input->post('phone_number')) == ''){
			
			$err_msg.= '- Phone Number cannot be empty.<br>';
			
		}//end if(trim($this->input->post('page_title')) == '')

		
		if(trim($this->input->post('email_address')) == ''){
			
			$err_msg.= '- Email Address cannot be empty.<br>';
			
		}//end if(trim($this->input->post('username')) == '')
		
	
		if($err_msg !=''){

			$this->session->set_flashdata('err_message', $err_msg);
			redirect(base_url().'invoices/manage_invoices/pay_now/'.$this->input->post('invoice_id'));
			
		}//end if($err_msg !='')

			
		$pay_now = $this->mod_invoices->pay_now($this->input->post());
		
		
		if($pay_now){
			
			$this->session->unset_userdata('add-user-data');
			$this->session->set_flashdata('ok_message', '- Payment Added Successfully.');
			redirect(base_url().'invoices/manage_invoices/pay_now/'.$this->input->post('invoice_id'));
		}else{
					$this->session->set_flashdata('err_message', '- Payment  cannot be Added. Something went wrong, please try again.');
					redirect(base_url().'invoices/manage_invoices/pay_now'.$this->input->post('invoice_id'));
					
				}//end if
				
	}//end pay_now_proces

}//end Dashboard 
