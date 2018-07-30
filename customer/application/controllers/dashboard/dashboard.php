<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public function __construct(){
		parent::__construct();

		$this->load->model('common/mod_common');
		$this->load->model('login/mod_login');
		$this->load->model('support/mod_support');
		$this->load->library('BreadcrumbComponent');
		$this->load->model('projects/mod_projects');
	  	$this->load->model('customers/mod_customer');
		
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
		
		
		//Ger projects counter
		$projects_count = $this->mod_common->get_projects_count();
		$data['projects_count'] = $projects_count;
		
		//Ger open_projects counter
		$open_projects_count = $this->mod_common->get_open_projects_count();
		$data['open_projects_count'] = $open_projects_count;
		
		
		//Ger close_projects counter
		$close_projects_count = $this->mod_common->get_close_projects_count();
		$data['close_projects_count'] = $close_projects_count;
		
		
		
		
	   $get_customer_data = $this->mod_login->get_customer($this->session->userdata('customer_id'));
	   $data['customer_data']=$get_customer_data;
	   
	   
		
		//Get project Messsaes
		$project_messages = $this->mod_projects->get_messages_count();
		$data['projects_arr'] = $project_messages['projects_arr'];
		$data['projects_count'] = $project_messages['projects_count'];
		
		
	/*	echo "<pre>";
		print_r($project_messages);
		exit;*/
	   
	    $this->load->view('dashboard/dashboard',$data);
		
	}//end index()
	
	

	public function daily_tasks(){
	
		
		$this->load->model('projects/mod_projects');
		
		$tasks_data = $this->mod_projects->daily_tasks();
		
	
	
	
		$last_10days = array();
		for ($i=-5; $i<6; $i++){
		$last_10days[] = date("Y-m-d", strtotime($i." days"));
		}
	
	
	/*echo '<h3>Dates Range</h3>';
		print_r($last_10days);*/
	
	$filtered_data = array();

	
	foreach($last_10days as $day){ // loop last 10 days and populate them according to db data
		$found = 0;
			foreach($tasks_data  as $task){
			
					if($task['formated_created_date'] == $day){
						$found = 1;
						$filtered_data[]=$task;
					}
				
				
			}//end of inner loop
		
		if(!$found){
		//incase match not found meaning no data for this particular date. Insert a blank row	
		$blank_row = array();
		$blank_row['formated_created_date']=$day;
		$blank_row['tasks_count']=0;
		$filtered_data[] = $blank_row;
			
		}//end of not found
		
		
	}//end of loop for days
	
	
		
		$data = array();
		
	   
		
		
		foreach($filtered_data as $tasks){
			
			
			$date =  $tasks['formated_created_date'];
			$task_title =  $tasks['task_title'];
			$tasks_count = (int)$tasks['tasks_count'];
			
date_default_timezone_set('UTC');

//$date1 =   (strtotime($date) * 1000) - (strtotime('02-01-1970 00:00:00') * 1000);
$date1 =   (strtotime($date) * 1000);

$data[] = array( 'x' => $date1 , 'y' =>  $tasks_count , 'task_name' => $task_title ,  'db_date' => $tasks['formated_created_date']);

		}
		

			
//out put json			
header('Content-Type: application/json');
echo json_encode($data);
		
		
		
		
		
		
	}
	
	

}//end Dashboard 
