<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Manage_Customers extends CI_Controller {

	public function __construct(){

		parent::__construct();
		
		$this->load->model('customers/mod_customer');
		$this->load->model('common/mod_common');
		$this->load->library('BreadcrumbComponent');
		
	}

	public function index(){
		
		//Login Check
		$this->mod_customer->verify_is_customer_login();

		//Verify if Page is Accessable
		if(!in_array(29,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if
		
		
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
		$this->breadcrumbcomponent->add('Manage Customer', base_url().'cms/manage-customer');
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		$data['INC_header_script_top'] = $this->load->view('common/script_header',$data,true);
		$data['INC_header_script_footer'] = $this->load->view('common/script_footer',$data,true);
		$data['INC_top_header'] = $this->load->view('common/top_header','',true);
		$data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel',$data,true);
		$data['INC_footer'] = $this->load->view('common/footer','',true);
		$data['INC_breadcrum'] = $this->load->view('common/breadcrum','',true);

		//Permissions
		$data['ALLOW_user_edit'] =   (in_array(9,$this->session->userdata('permissions_arr'))) ? 1 : 0;
		$data['ALLOW_user_delete'] =   (in_array(10,$this->session->userdata('permissions_arr'))) ? 1 : 0;
		
		//Pagination
		$this->load->library('pagination');
		$config['base_url'] = base_url().'customers/manage-user/index';
		$config['total_rows'] = $this->mod_customer->count_total_customers_users();
	
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
		
		$get_customers_user = $this->mod_customer->get_customers_users_limit($page,$config["per_page"]);
		$data['customers_user_list'] = $get_customers_user['customers_list_result'];
		$data['customers_user_list_count'] = $get_customers_user['customers_list_result_count'];
		$this->load->view('customers/manage_customer',$data);
			
	}//end index()
	
	//Ajax Response States against Countries
	public function get_states_list($country_id){
		
		//Login Check
		$this->mod_customer->verify_is_customer_login();
		
		//State List List
		$get_all_states_list = $this->mod_customer->get_all_states($country_id);

		$data['states_result_arr'] = $get_all_states_list['states_result'];
		$data['states_result_count'] = $get_all_states_list['states_count'];
		
		$data['cities_result_arr'] = $get_all_states_list['cities_result'];
		$data['cities_result_count'] = $get_all_states_list['cities_count'];
		
		if($country_id !='0'){
		
		if($data['states_result_count'] >0){ // If State found in database .
		$response_select .= '<select  style="width:100%;" id="state_name" name="state_name" onChange="get_cities(this.value)" required><option value="0">Select State</option>' ;	
			
			for($p=0; $p < $data['states_result_count']; $p++){
				
				$response_select .= "<option value=".$data['states_result_arr'][$p]['state_name'].">".$data['states_result_arr'][$p]['state_name']."</option>" ;		
			}
		$response_select .= '</select>' ;		
		}else{
			
			$response_select .= ' <input id="state_name" name="state_name" type="text" class="form-control" placeholder="Enter State/Province Name "/>' ;	
			
			
		}
		}else{
			
			$response_select .="Please Select Country Name";
		
		}
		
		$response_select .= '|';
		
		
		if($country_id !='0'){
		
		if($data['cities_result_count'] >0){ // If Cities found in database .
		$response_select .= '<select style="width:100%;" id="city_name" name="city_name" onChange="get_cities(this.value)" required><option value="0">Select City</option>' ;	
			
			for($i=0; $i < $data['cities_result_count']; $i++){
				
				$response_select .= "<option value=".$data['cities_result_arr'][$i]['name'].">".$data['cities_result_arr'][$i]['name']."</option>" ;		
			}
		$response_select .= '</select>' ;		
		}else{
			
			$response_select .= ' <input id="city_name" name="city_name" type="text" class="form-control" placeholder="Enter State/Province Name "/>' ;	
			
			
		}
		}else{
			
			$response_select .= "Please Select Country Name";
			
		}
		
		
		echo $response_select ; 
		exit;
	}//get_states_list

	public function edit_customer(){
		
		//Login Check
		$this->mod_customer->verify_is_customer_login();
	
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
		$this->breadcrumbcomponent->add('Edit Customer', base_url().'customers/manage-customers/edit-customer/'.$customer_id);
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		$data['INC_header_script_top'] = $this->load->view('common/script_header',$data,true);
		$data['INC_header_script_footer'] = $this->load->view('common/script_footer',$data,true);
		$data['INC_top_header'] = $this->load->view('common/top_header','',true);
		$data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel',$data,true);
		$data['INC_footer'] = $this->load->view('common/footer','',true);
		$data['INC_breadcrum'] = $this->load->view('common/breadcrum','',true);
		
		//Admin User data
		$customer_user_data = $this->mod_customer->get_customer_user_data($customer_id);
		$data['customer_user_data'] = $customer_user_data['customer_user_arr'];
		$data['customer_user_count'] = $customer_user_data['customer_user_count'];
		
		//Country List List
		$get_all_country_list = $this->mod_customer->get_all_countries();

		$data['countries_result_arr'] = $get_all_country_list['countries_result'];
		$data['countries_result_count'] = $get_all_country_list['countries_count'];
		
	    $customer_id=$this->session->userdata('customer_id');
		
		$get_customer_data = $this->mod_customer->get_customer_profile($customer_id);
		$county_name= $get_customer_data['customer_profile_arr']['country_name'];
		
		
		$get_states_list = $this->mod_customer->get_states($county_name);
		$data['states_result_arr'] = $get_states_list['states_result'];
		$data['states_result_count'] = $get_states_list['states_count'];
		
		
		$get_cities_list = $this->mod_customer->get_cities($county_name);
		$data['cities_result_arr'] = $get_cities_list['cities_result'];
		$data['cities_result_count'] = $get_cities_list['cities_count'];
	
		
		$this->load->view('customers/edit_customer',$data);
		
	}//edit_user
	
	public function edit_customer_process(){
		
		//Login Check
		$this->mod_customer->verify_is_customer_login();
		
		$this->load->helper('email');

		
		
		$customer_id = $this->input->post('customer_id');

		$err_msg = '';
		if(trim($this->input->post('first_name')) == ''){
			
			$err_msg.= '- First Name cannot be empty.<br>';
			
		}//end if(trim($this->input->post('page_title')) == '')

		if(trim($this->input->post('last_name')) == ''){
			
			$err_msg.= '- Last Name cannot be empty.<br>';
			
		}//end if(trim($this->input->post('page_title')) == '')

		
		if(trim($this->input->post('username')) == ''){
			
			$err_msg.= '- Username cannot be empty.<br>';
			
		}//end if(trim($this->input->post('username')) == '')

		if(trim($this->input->post('email_address')) != '' && !(valid_email($this->input->post('email_address')))){
			
			$err_msg.= '- Please enter valid Email Address<br>';
			
		}//end if(trim($this->input->post('email_address')) == '')
		
		if($_FILES['prof_image']['name'] != ''){
			
			$allowed_extesntions = array('jpg','jpeg','tiff','png','gif');
			$file_ext           = ltrim(strtolower(strrchr($_FILES['prof_image']['name'],'.')),'.'); 
			
			if(!in_array($file_ext,$allowed_extesntions)){
				$err_msg.= '- Invalid image for your profile (Use: jpg, jpeg, gif, tiff, png)<br>';	
			}//end if
			
		}//end if($_FILES['prof_image']['name'] != '')
		
		
		if($err_msg !=''){

			$this->session->set_flashdata('err_message', $err_msg);
			redirect(base_url().'customers/manage-customers/edit-customer/'.$customer_id);
			
		}//end if($err_msg !='')

		//Updating Customer Data
		$upd_customer = $this->mod_customer->edit_customer($this->input->post());
		
		if($upd_customer && $upd_customer['error'] == ''){
			
			$this->session->set_flashdata('ok_message', '- User record updated successfully.');
			redirect(base_url().'customers/manage-customers/edit-customer/'.$customer_id);
			
		}else{

			if($upd_admin['error'] != ''){
				
				$this->session->set_flashdata('err_message', '- '.strip_tags($upd_admin['error']));
				redirect(base_url().'customers/manage-customers/edit-customer/'.$customer_id);
				
			}else{
				$this->session->set_flashdata('err_message', '- User record cannot be updated. Something went wrong, please try again.');
				redirect(base_url().'customers/manage-customers/edit-customer/'.$customer_id);
				
			}//end if($upd_customer['error'] != '')
			
		}//end if($add_cms_page)

	}//end edit_user_process
	
	//Upload Customer Docs
	public function upload_docs($customer_id){
		
		//Login Check
		$this->mod_customer->verify_is_customer_login();
		
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
		$this->breadcrumbcomponent->add('Upload Customer Docs', base_url().'customers/manage-customers/upload-docs/'.$customer_id);
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		$data['INC_header_script_top'] = $this->load->view('common/script_header',$data,true);
		$data['INC_header_script_footer'] = $this->load->view('common/script_footer',$data,true);
		$data['INC_top_header'] = $this->load->view('common/top_header','',true);
		$data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel',$data,true);
		$data['INC_footer'] = $this->load->view('common/footer','',true);
		$data['INC_breadcrum'] = $this->load->view('common/breadcrum','',true);
		
		//Admin User data
		$customer_user_data = $this->mod_customer->get_customer_user_data($customer_id);
		$data['customer_user_data'] = $customer_user_data['customer_user_arr'];
		$data['customer_user_count'] = $customer_user_data['customer_user_count'];
		
		
		
		$this->load->view('customers/upload_docs',$data);
		
	}//Upload Docs
	
	
	public function upload_docs_process(){
		
		//Login Check
		$this->mod_customer->verify_is_customer_login();
		
		//If Post is not SET
		if(!$this->input->post() && !$this->input->post('upd_customer_docs_sbt')) redirect(base_url());
		
		
		$customer_id = $this->input->post('customer_id');

		if($_FILES['prof_image']['name'] != ''){
			
			$allowed_extesntions = array('jpg','jpeg','tiff','png','gif');
			$file_ext           = ltrim(strtolower(strrchr($_FILES['prof_image']['name'],'.')),'.'); 
			
			if(!in_array($file_ext,$allowed_extesntions)){
				$err_msg.= '- Invalid image for your profile (Use: jpg, jpeg, gif, tiff, png)<br>';	
			}//end if
			
		}//end if($_FILES['prof_image']['name'] != '')
		
		
		if($err_msg !=''){

			$this->session->set_flashdata('err_message', $err_msg);
			redirect(base_url().'customers/manage-customers/upload-docs/'.$customer_id);
			
		}//end if($err_msg !='')

		//Updating Customer Data
		$upd_customer = $this->mod_customer->upload_docs($this->input->post());
		
		if($upd_customer && $upd_customer['error'] == ''){
			
			$this->session->set_flashdata('ok_message', '- Customer Docs uploaded successfully.');
			redirect(base_url().'customers/manage-customers/upload-docs/'.$customer_id);
			
		}else{

			if($upd_customer['error'] != ''){
				$this->session->set_flashdata('err_message', '- '.strip_tags($upd_admin['error']));
				redirect(base_url().'customers/manage-customers/upload-docs/'.$customer_id);
				
			}else{
				$this->session->set_flashdata('err_message', '- Customer Docs cannot be uploaded. Something went wrong, please try again.');
				redirect(base_url().'customers/manage-customers/upload-docs/'.$customer_id);
				
			}//end if($upd_customer['error'] != '')
			
		}//end if($add_cms_page)

	}//end Customer Upload Docs
	
	
	


}//end Dashboard 
