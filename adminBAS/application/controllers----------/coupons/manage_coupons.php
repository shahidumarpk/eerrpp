<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Manage_Coupons extends CI_Controller {

	public function __construct(){
		parent::__construct();

		$this->load->model('admin/mod_admin');
		$this->load->model('common/mod_common');
		$this->load->model('coupons/mod_coupons');
		
		$this->load->library('BreadcrumbComponent');
		
	}

	public function index(){
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(12,$this->session->userdata('permissions_arr'))){
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
		$data['ALLOW_pages_add'] =   (in_array(60,$this->session->userdata('permissions_arr'))) ? 1 : 0;
		

		//Bread crum
		$this->breadcrumbcomponent->add('Dashboard', base_url().'dashboard/dashboard');
		$this->breadcrumbcomponent->add('Manage Coupons', base_url().'coupons/manage-coupons');
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		$data['INC_autoload_messages'] = $this->load->view('common/autoload_messages',$data,true);
		$data['INC_header_script_top'] = $this->load->view('common/script_header',$data,true);
		$data['INC_header_script_footer'] = $this->load->view('common/script_footer',$data,true);
		$data['INC_top_header'] = $this->load->view('common/top_header','',true);
		$data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel',$data,true);
		$data['INC_footer'] = $this->load->view('common/footer','',true);
		$data['INC_breadcrum'] = $this->load->view('common/breadcrum','',true);
		
		$coupons_arr = $this->mod_coupons->get_coupons();
		$data['coupons_arr'] = $coupons_arr['coupons_result'];
		$data['coupons_count'] = $coupons_arr['coupons_count'];
		
		
		/*print_r($coupons_arr);
		exit;*/
        
		$this->load->view('coupons/manage_coupons',$data);
			
	}//end index()
	
	//Add coupons
	public function add_coupons(){
	
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(8,$this->session->userdata('permissions_arr'))){
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
		$this->breadcrumbcomponent->add('Add New Coupons', base_url().'coupons/manage-coupons/add-coupons');
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		$data['INC_autoload_messages'] = $this->load->view('common/autoload_messages',$data,true);
		$data['INC_header_script_top'] = $this->load->view('common/script_header',$data,true);
		$data['INC_header_script_footer'] = $this->load->view('common/script_footer',$data,true);
		$data['INC_top_header'] = $this->load->view('common/top_header','',true);
		$data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel',$data,true);
		$data['INC_footer'] = $this->load->view('common/footer','',true);
		$data['INC_breadcrum'] = $this->load->view('common/breadcrum','',true);
		
		//$coupons_code = $this->mod_common->random_alphanumaric_generator(7);
		//$coupons_code = $this->mod_coupons->coupon_code_generator($coupons_code);
		//$data['coupons_code'] = $coupons_code;
		
		$this->load->view('coupons/add_coupons',$data);
		
	}//End add_coupons

	public function add_coupons_process(){
		
		//If Post is not SET
		if(!$this->input->post() && !$this->input->post('add_coupon_sbt')) redirect(base_url());
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(8,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if
		
		$err_msg = '';

		if(trim($this->input->post('discount_amount')) == ''){
			
			$err_msg.= '- Coupon Discount cannot be empty.<br>';
			
		}//end if
		
		
		if(trim($this->input->post('no_of_coupons')) == ''){
			
			$err_msg.= '- No.of Coupons cannot be empty.<br>';
			
		}//end if
		
		
		if($err_msg !=''){

			$this->session->set_flashdata('err_message', $err_msg);
			redirect(base_url().'coupons/manage_coupons/add_coupons');
			
		}//end if($err_msg !='')

		
			//Add New Coupons
			$add_coupons = $this->mod_coupons->add_coupons($this->input->post());
			
			if($add_coupons && $add_coupons['error'] == ''){
				
				//Unset POST values from session
				$this->session->unset_userdata('add-user-data');
				
				$this->session->set_flashdata('ok_message', '- New Coupon added successfully.');
				redirect(base_url().'coupons/manage_coupons/add_coupons');
				
			}else{
				
				if($add_coupons['error'] != ''){
					$this->session->set_flashdata('err_message', '- '.strip_tags($add_new_user['error']));
					redirect(base_url().'coupons/manage_coupons/add_coupons');
					
				}else{
					$this->session->set_flashdata('err_message', '- New Coupon cannot be added. Something went wrong, please try again.');
					redirect(base_url().'coupons/manage_coupons/add_coupons');
					
				}//end if
				
			}//end if
	}//end add_coupons_process
	
    
	//Ajax Response States against Countries
	public function is_coupon_valid($coupon_code){
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		
		//State List List
		$ajax_response = $this->mod_coupons->coupon_authentication($coupon_code);
		
		echo $ajax_response ; 
		exit;
	}//get_states_list

	
	public function delete_coupons($id){
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(10,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if

	
		$del_coupons= $this->mod_coupons->delete_coupons($id);
		
		if($del_coupons){
			
			$this->session->set_flashdata('ok_message', '- Coupons deleted successfully.');
			redirect(base_url().'coupons/manage_coupons');
			
		}else{
			$this->session->set_flashdata('err_message', '- Coupons cannot be deleted. Something went wrong, please try again.');
			redirect(base_url().'coupons/manage_coupons');
			
		}//end if

	}//end delete_coupons
	
	
	
	public function send_coupons($coupon_code){
	
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(8,$this->session->userdata('permissions_arr'))){
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
		$this->breadcrumbcomponent->add('Add New User', base_url().'admin/manage-user/add-new-user');
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		$data['INC_autoload_messages'] = $this->load->view('common/autoload_messages',$data,true);
		$data['INC_header_script_top'] = $this->load->view('common/script_header',$data,true);
		$data['INC_header_script_footer'] = $this->load->view('common/script_footer',$data,true);
		$data['INC_top_header'] = $this->load->view('common/top_header','',true);
		$data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel',$data,true);
		$data['INC_footer'] = $this->load->view('common/footer','',true);
		$data['INC_breadcrum'] = $this->load->view('common/breadcrum','',true);
		
		//$coupons_code = $this->mod_common->random_alphanumaric_generator(7);
		//$coupons_code = $this->mod_coupons->coupon_code_generator($coupons_code);
		$data['coupon_code'] = $coupon_code;
		
		$this->load->view('coupons/send_coupons',$data);
		
	}//send_coupons
	
	
	public function send_coupons_process(){
		
		$this->load->model('email/mod_email');
		$this->load->model('site_preferences/mod_preferences');
		
		//If Post is not SET
		if(!$this->input->post() && !$this->input->post('send_coupon_sbt')) redirect(base_url());
		
		//Login Check
		$this->mod_admin->verify_is_admin_login();

		//Verify if Page is Accessable
		if(!in_array(8,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if
		
		$err_msg = '';

		if(trim($this->input->post('name')) == ''){
			
			$err_msg.= '- Name cannot be empty.<br>';
			
		}//end if
		
		
		if(trim($this->input->post('email_address')) == ''){
			
			$err_msg.= '- Email Address cannot be empty.<br>';
			
		}//end if
		
		
		if($err_msg !=''){

			$this->session->set_flashdata('err_message', $err_msg);
			redirect(base_url().'coupons/manage_coupons/send_coupons');
			
		}//end if($err_msg !='')

		
			//Send  Coupons
			$send_coupons = $this->mod_coupons->send_coupons($this->input->post());
			
			if($send_coupons && $send_coupons['error'] == ''){
				
				//Unset POST values from session
				$this->session->unset_userdata('add-user-data');
				
				$this->session->set_flashdata('ok_message', '- Coupon Send successfully.');
				redirect(base_url().'coupons/manage_coupons');
				
			}else{
				
				if($send_coupons['error'] != ''){
					$this->session->set_flashdata('err_message', '- '.strip_tags($add_new_user['error']));
					redirect(base_url().'coupons/manage_coupons');
					
				}else{
					$this->session->set_flashdata('err_message', '- Coupon cannot be Send. Something went wrong, please try again.');
					redirect(base_url().'coupons/manage_coupons');
					
				}//end if
				
			}//end if
	}//end send_coupons_process
	
	

}//end Dashboard 
