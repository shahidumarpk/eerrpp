<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ticket_Feedback extends CI_Controller {

	public function index(){
		
		$this->load->model('article/mod_article');
		$this->load->model('category/mod_category');
		$this->load->model('column/mod_column');
		$this->load->model('common/mod_common');
		$this->load->model('social_network/mod_social');
		$this->load->model('slider/mod_slider');
		$this->load->model('home/mod_home');

		
		//Common Includes
		$data['meta_title'] = (trim($get_home_page_data['cms_page_arr']['meta_title']) == '' ) ? DEFAULT_TITLE : trim(stripslashes($get_home_page_data['cms_page_arr']['meta_title']));
		$data['meta_keywords'] = (trim($get_home_page_data['cms_page_arr']['meta_keywords']) == '' ) ? DEFAULT_META_KEYWORDS : trim(stripslashes($get_home_page_data['cms_page_arr']['meta_keywords']));
		$data['meta_description'] = (trim($get_home_page_data['cms_page_arr']['meta_description']) == '' ) ? DEFAULT_META_DESCRIPTION : trim(stripslashes($get_home_page_data['cms_page_arr']['meta_description']));

		
		
	  // Social network
	  	$get_social_data = $this->mod_social->get_social_tools();
		$data['social_data_arr'] = $get_social_data;
	
		//Fetching slider Images
		$slider_images_fin_arr = $this->mod_slider->get_slider_images();
	    $data['slider_images_arr'] = $slider_images_fin_arr;
		$data['slider_images_count'] = $get_slider_images['slider_images_count'];
		
		
	  // CopyRight Text
	    $get_copyright_data = $this->mod_common->get_copyright_text();
		$data['copyright_arr'] = $get_copyright_data;
	
	
	 // GET Content Page
	  	$get_content_data = $this->mod_home->get_content_page();
		$data['content_data_arr'] = $get_content_data['content_page_arr'];
		
		
		//Module Include
		$data['INC_header_script_top'] = $this->load->view('common/script_header','',true);
		$data['INC_header_script_footer'] = $this->load->view('common/script_footer','',true);
		$data['INC_top_header'] = $this->load->view('common/top_header',$data,true);
		$data['INC_footer'] = $this->load->view('common/footer',$data,true);
		$data['INC_scrol_footer'] = $this->load->view('common/scrol_up_footer','',true);
		
		$this->load->view('home/home',$data);
		
	} //end index()
	
	
	

     public function feedback($ticket_id){
		 
		 //Login Check
		$this->mod_customer->verify_is_customer_login();
		   
		       $data['ticket_id']=$ticket_id;
			   
			  $this->load->model('ticket_feedback/mod_feedback');
			  
			 $ticket_arr= $this->mod_feedback->get_feedback($ticket_id);
			 
			   $data['ticket_data']= $ticket_arr;
			 
		      $this->load->view('ticket_feedback/ticket_feedback',$data);
		  
		   }
		   
		   
	   public function feedback_process(){
		   
		   //Login Check
		$this->mod_customer->verify_is_customer_login();
		   
		 $ticket_id=$this->input->post('ticket_id');
		 $this->load->model('ticket_feedback/mod_feedback');
		 
		 $add_feedback = $this->mod_feedback->add_feedback($this->input->post());
		 
		 if($add_feedback){
			
		$this->session->set_flashdata('msg', '- Ticket Feedback Added Succsesfully...');
		
		   redirect(base_url().'ticket_feedback/ticket-feedback/feedback/'.$ticket_id);
		
		 }
		
	
		  
     }
}

/* End of file */
