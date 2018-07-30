<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public function __construct(){
		parent::__construct();

		$this->load->model('common/mod_common');
		$this->load->model('login/mod_login');
		$this->load->model('support/mod_support');
		$this->load->library('BreadcrumbComponent');
		$this->load->model('projects/mod_projects');
		
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
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();

		$data['INC_header_script_top'] = $this->load->view('common/script_header',$data,true);
		$data['INC_header_script_footer'] = $this->load->view('common/script_footer',$data,true);
		$data['INC_top_header'] = $this->load->view('common/top_header','',true);
		$data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel',$data,true);
		$data['INC_footer'] = $this->load->view('common/footer','',true);
		$data['INC_breadcrum'] = $this->load->view('common/breadcrum','',true);
		
		
	   $get_customer_data = $this->mod_login->get_customer($this->session->userdata('customer_id'));
	   $data['customer_data']=$get_customer_data;
	   
	   
	    $get_customers_user = $this->mod_support->get_customer_tickets($this->session->userdata('customer_id'));
		$data['ticket_list_result'] = $get_customers_user['ticket_list_result'];
		$data['ticket_list_result_count'] = $get_customers_user['ticket_list_result_count'];
		
		
		//Get project Messsaes
		$project_messages = $this->mod_projects->get_messages_count();
		$data['project_messages_arr'] = $project_messages['message_arr'];
		$data['project_messages_count'] = $project_messages['message_count'];
	   
	    $this->load->view('dashboard/dashboard',$data);
		
	}//end index()

}//end Dashboard 
