<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Page_not_found_404 extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		
        
		 $this->load->driver('cache');
         $this->cache->clean();
         $this->output->cache(0);
		
		$this->load->model('common/mod_common');
		$this->load->library('BreadcrumbComponent');
		
		
		$this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->output->set_header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');  

	}

	public function index(){
		
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
		$data['ALLOW_user_edit'] =   (in_array(76,$this->session->userdata('permissions_arr'))) ? 1 : 0;
		$data['ALLOW_user_delete'] =   (in_array(77,$this->session->userdata('permissions_arr'))) ? 1 : 0;
		$data['ALLOW_pages_add'] =   (in_array(74,$this->session->userdata('permissions_arr'))) ? 1 : 0;
		$data['ALLOW_user_action'] =   (in_array(114,$this->session->userdata('permissions_arr'))) ? 1 : 0;
		$data['ALLOW_user_assign_team'] =   (in_array(127,$this->session->userdata('permissions_arr'))) ? 1 : 0;
		$data['ALLOW_user_assign_task'] =   (in_array(128,$this->session->userdata('permissions_arr'))) ? 1 : 0;
		
		
		//Bread crum
		$this->breadcrumbcomponent->add('Dashboard', base_url().'dashboard/dashboard');
		$this->breadcrumbcomponent->add('Page not found', base_url().'coupons/manage-coupons');
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		///////////////////////// Top Notifications  /////////////////////
		//Get Assign Task Notificaitons
		$assign_tasks_notifiations= $this->mod_common->get_assign_task_notifiations();
		$data['assign_task_notifiations_arr'] = $assign_tasks_notifiations['assign_task_filter'];
		$data['assign_task_notifiations_count'] = $assign_tasks_notifiations['assign_task_count'];
		
		//Get Inbox Unread Messsaes Notifications
		$inbox_unread_messages = $this->mod_common->get_inbox_unread_messages();
		$data['messages_arr'] = $inbox_unread_messages['messages_result'];
		$data['messages_count'] = $inbox_unread_messages['messages_count'];
		
		//Get Inbox Notifications
		$inbox_notifications_messages = $this->mod_common->get_inbox_notifications();
		$data['inbox_notifications_arr'] = $inbox_notifications_messages['inbox_notifications_result'];
		$data['inbox_notifications_count'] = $inbox_notifications_messages['inbox_notifications_count'];
	    ///////////////////// End Top Notifications///////////////////////
		
		$data['INC_header_script_top'] = $this->load->view('common/script_header',$data,true);
		$data['INC_header_script_footer'] = $this->load->view('common/script_footer',$data,true);
		$data['INC_top_header'] = $this->load->view('common/top_header','',true);
		$data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel',$data,true);
		$data['INC_footer'] = $this->load->view('common/footer','',true);
		$data['INC_breadcrum'] = $this->load->view('common/breadcrum','',true);
		
		//GET CMS Page
		
		$page_arr = $this->mod_common->get_cms_page('404-page');
		$data['page_arr'] = $page_arr;
		/*
		echo "<pre>";
		print_r($page_arr);
		exit;*/
		
		
		$this->load->view('errors/page_not_found',$data);
		
	} //end index()

}

/* End of file */
