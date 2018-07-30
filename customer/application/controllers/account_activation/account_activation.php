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
				
	
				
		$this->load->view('account_activation/account_activation',$data);
		
		
		
     }
}

/* End of file */
