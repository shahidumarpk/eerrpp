<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class App extends CI_Controller {

	public function __construct(){
		parent::__construct();

	    $this->load->model('customers/mod_customer');
	}
	
	public function index(){
		
		
		//Login Check
		$this->mod_customer->verify_is_customer_login();

		
	    $this->load->view('customers/app',$data);
		
	}//end index()
	
	

}//end Dashboard 
