<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Account_Activation extends CI_Controller {

	public function index(){
		
		
		$this->load->model('common/mod_common');
		$this->load->model('account_activation/mod_account_activation');
		$this->load->model('slider/mod_slider');
		$this->load->model('home/mod_home');
		
	} //end index()
	
	
	 public function activate($customer_id,$activation_code){
		 
	
		
		$this->load->model('account_activation/mod_account_activation');
		 
		//Account Activation
	  	$get_content_data = $this->mod_account_activation->account_activation($customer_id,$activation_code);
		
		$customer_count=$get_content_data['customer_count'];
		
				if($customer_count >0){
					
					$data['message']="-Congratulations.. Your Account has been Activated";
					
					
				}else{
					
					$data['error_message']="-Sorry..! Account Not Activated.. Something went wrong, please try again.";
					
					
				}//end if($add_new_user['error'] != '')
			
		$this->load->model('common/mod_common');
	
		$this->load->model('customers/mod_customer');
		$this->load->library('BreadcrumbComponent');		
	    
		//Common Includes
		$data['meta_title'] = DEFAULT_TITLE;
		$data['meta_keywords'] = DEFAULT_META_KEYWORDS;
		$data['meta_description'] = DEFAULT_META_DESCRIPTION;
		
		$fetch_nav_panel = $this->mod_common->fetch_admin_nav_panel();
		$data['nav_panel_arr'] = $fetch_nav_panel;
		

		//Bread crum
		$this->breadcrumbcomponent->add('Dashboard', base_url().'dashboard/dashboard');
		$this->breadcrumbcomponent->add('Financial Statistics', base_url().'coupons/manage-coupons');
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		$data['INC_header_script_top'] = $this->load->view('common/script_header',$data,true);
		$data['INC_header_script_footer'] = $this->load->view('common/script_footer',$data,true);
		$data['INC_top_header'] = $this->load->view('common/top_header','',true);
		$data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel',$data,true);
		$data['INC_footer'] = $this->load->view('common/footer','',true);
		$data['INC_breadcrum'] = $this->load->view('common/breadcrum','',true);
		
				
		$this->load->view('login/login',$data);
		
		
		
     }
}

/* End of file */
