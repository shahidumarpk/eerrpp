<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Logout extends CI_Controller {

	public function index(){

		//Distroy All Sessions
		$this->session->sess_destroy();

		$this->session->set_flashdata('err_message', '- You have successfully logged out.');
		redirect(base_url().'login/login');

	}//end logout	
}

/* End of file */
