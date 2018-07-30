<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public function __construct(){
		parent::__construct();

		$this->load->model('admin/mod_admin');
		$this->load->model('common/mod_common');
		$this->load->model('projects/mod_projects');
		$this->load->library('BreadcrumbComponent');
	    $this->mod_common->get_inbox_messages();
		
	}
	public function my_projects(){

	//load model
	$this->load->model('projects/mod_projects');
	//
	//get assigned projects
	// get_my_projects
		$my_projects= $this->mod_projects->my_projects();
		
		$data['projects_arr'] = $my_projects['my_projects_data'];
		$data['projects_count'] = $my_projects['my_projects_count'];
	
	
		
	//print a select list projects_arr
	
	

 ?>

      <select placeholder="My Projects"  id="project_id" name="project_id" onChange="visit_project(this.value)" class="chosen-select md-col-10"   style="width:85%;"  required >								
	   <option value=""></option>
	   
        <?php 
					foreach($data['projects_arr'] as $projects){
								?>
   <option value="<?php echo $projects['id']?>"><?php echo $projects['project_title']?></option>    
                                <?php		
									}//end for
								?>
                            
                        </select>
                        <?php
		

		
		
	}
	public function index(){
         
		//Login Check
	 	$this->mod_admin->verify_is_admin_login();
		
		//Plugin Files Permission
		$data['PLUGIN_datagrid'] = 0;
		$data['PLUGIN_datepicker'] = 0;
		$data['PLUGIN_gcal'] = 0;
		$data['PLUGIN_form_validation'] = 0;
		$data['PLUGIN_gallery'] = 0;
		$data['PLUGIN_ckeditor'] = 0;
		$data['PLUGIN_floatchart'] = 0;
		$data['PLUGIN_highchart'] = 1; //mzm
		
		//Common Includes
		$data['meta_title'] = DEFAULT_TITLE;
		$data['meta_keywords'] = DEFAULT_META_KEYWORDS;
		$data['meta_description'] = DEFAULT_META_DESCRIPTION;
		
		$fetch_nav_panel = $this->mod_common->fetch_admin_nav_panel();
		$data['nav_panel_arr'] = $fetch_nav_panel;

		//Bread crum
		$this->breadcrumbcomponent->add('Dashboard', base_url().'dashboard/dashboard');
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		///////////////////////// Top Notifications  /////////////////////
		//Get Assign Task Notificaitons
		$assign_tasks_notifiations= $this->mod_common->get_assign_task_notifiations();
		$data['assign_task_notifiations_arr'] = $assign_tasks_notifiations['assign_task_filter'];
		$data['assign_task_notifiations_count'] = $assign_tasks_notifiations['assign_task_count'];
	    
		$inbox_unread_messages = $this->mod_common->get_inbox_messages();
		$data['unread_messages_count'] = $inbox_unread_messages['messages_count'];
		
		//Get Inbox Unread Messsaes Notifications
		$inbox_unread_messages = $this->mod_common->get_inbox_unread_messages();
		$data['messages_arr'] = $inbox_unread_messages['messages_result'];
		$data['messages_count'] = $inbox_unread_messages['messages_count'];
		
		//Get Inbox Notifications
		$inbox_notifications_messages = $this->mod_common->get_inbox_notifications();
		$data['inbox_notifications_arr'] = $inbox_notifications_messages['inbox_notifications_result'];
		$data['inbox_notifications_count'] = $inbox_notifications_messages['inbox_notifications_count'];
		
		
	    ///////////////////// End Top Notifications///////////////////////
		$data['INC_autoload_messages'] = $this->load->view('common/autoload_messages',$data,true);
		$data['INC_header_script_top'] = $this->load->view('common/script_header',$data,true);
		$data['INC_header_script_footer'] = $this->load->view('common/script_footer',$data,true);
		$data['INC_top_header'] = $this->load->view('common/top_header','',true);
		$data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel',$data,true);
		$data['INC_footer'] = $this->load->view('common/footer','',true);
		$data['INC_breadcrum'] = $this->load->view('common/breadcrum','',true);
		
		
		//Permissions
		$data['ALLOW_dashboard_statistics'] =   (in_array(167,$this->session->userdata('permissions_arr'))) ? 1 : 0;
		$data['ALLOW_my_dashboard_statistics'] =   (in_array(168,$this->session->userdata('permissions_arr'))) ? 1 : 0;
		//mzm chart permission
		 $data['ALLOW_dashboard_charts'] =   (in_array(192,$this->session->userdata('permissions_arr'))) ? 1 : 0;
		
		
		
		
		//Get project Messsaes
		$project_messages = $this->mod_projects->get_messages_count();
		$data['project_messages_arr'] = $project_messages['message_arr'];
		$data['project_messages_count'] = $project_messages['message_count'];
		
		
		//Ger Clients counter
		$customers_count = $this->mod_common->get_customers_count();
		$data['customers_count'] = $customers_count;
		
		//Ger projects counter
		$projects_count = $this->mod_common->get_projects_count();
		$data['projects_count'] = $projects_count;
		
		//Ger open_projects counter
		$open_projects_count = $this->mod_common->get_open_projects_count();
		$data['open_projects_count'] = $open_projects_count;
		
		
		//Ger close_projects counter
		$close_projects_count = $this->mod_common->get_close_projects_count();
		$data['close_projects_count'] = $close_projects_count;
		
		//Ger cancel_projects counter
		$cancel_projects_count = $this->mod_common->get_cancel_projects_count();
		$data['cancel_projects_count'] = $cancel_projects_count;
		
		//Ger hold_projects counter
		$hold_projects_count = $this->mod_common->get_hold_projects_count();
		$data['hold_projects_count'] = $hold_projects_count;
		
		//Ger close_projects counter
		$projects_accounts = $this->mod_common->projects_accounts();
		$data['total_income'] = $projects_accounts['total_income'];
		$data['total_expense'] = $projects_accounts['total_expense'];
		
		//Ger expected_income
		$projects_expected_income= $this->mod_common->projects_expected_income();
		
		$data['expected_income'] = $projects_expected_income['total_amount'] - $projects_expected_income['total_received'];
		
		/*echo "<pre>";
		print_r($data['expected_income']);
		exit;
		*/
		
		//Ger get_my_projects_count
		$my_projects= $this->mod_common->get_my_projects_count();
		$data['my_projects'] = $my_projects;
		
		//Ger get_my_projects_count
		$my_open_projects= $this->mod_common->get_my_open_projects_count();
		$data['my_open_projects'] = $my_open_projects;
		
		//Ger get_my_projects_count
		$my_hold_projects= $this->mod_common->get_my_hold_projects_count();
		$data['my_hold_projects'] = $my_hold_projects;
		
		//Ger get_my_close_projects_count
		$my_closed_projects= $this->mod_common->get_my_closed_projects_count();
		$data['my_closed_projects'] = $my_closed_projects;
		
		
		//Ger get_my_projects_count
		$my_cancel_projects= $this->mod_common->get_my_cancel_projects_count();
		$data['my_cancel_projects'] = $my_cancel_projects;
		
		
		//Ger get_my_tasks
		$get_my_tasks= $this->mod_common->get_my_tasks();
		$data['my_tasks'] = $get_my_tasks;
		
		
		//Ger get_my_open_tasks
		$get_my_open_tasks= $this->mod_common->get_my_open_tasks();
		$data['my_open_tasks'] = $get_my_open_tasks;
		
		
		//Ger get_my_hold_tasks
		$my_hold_tasks= $this->mod_common->my_hold_tasks();
		$data['my_hold_tasks'] = $my_hold_tasks;
		
		
		//Ger get_my_open_tasks
		$my_closed_tasks= $this->mod_common->my_closed_tasks();
		$data['my_closed_tasks'] = $my_closed_tasks;
		
		
				
		$this->load->view('dashboard/dashboard',$data);
		
	}//end index()
	
	function awarded_projects_chart(){
		
		
			$permissions = $this->session->userdata('permissions_arr');
	$ALLOW_dashboard_charts  = 0;	
			if(!empty($permissions)){	
			$ALLOW_dashboard_charts =   (in_array(192,$permissions)) ? 1 : 0;
			}
		if( !$ALLOW_dashboard_charts ){
			
		return false;	
		//if no permission then don't process requests
		}
		
		
		$this->load->model('projects/mod_projects');
		
	
	
		$projects_data = $this->mod_projects->get_awarded_projects_chart();
		
		//print_r($projects_data);
		//header('Content-Type: application/json');
	
	
	//echo date("Y-m-d", strtotime("7 days ago"));
	
	//NEW REQUIREMENT We need to plot last 10 days. Incase a day record is not in db it should be included in the chart.
	
	//Solution: Create an array of last 10 days. Merge the data from db
	$last_10days = array();
	for ($i=0; $i<10; $i++){
    $last_10days[] = date("Y-m-d", strtotime($i." days ago"));
	}
	
	
		

	//reverse array for proper asending order
	$last_10days = array_reverse($last_10days);
		

		
	
	
	$filtered_data = array();
	
	foreach($last_10days as $day){ // loop last 10 days and populate them according to db data
		$found = 0;
			foreach($projects_data as $project){
			
					if($project['formated_created_date'] == $day){
						$found = 1;
						$filtered_data[]=$project;
					}
				
				
			}//end of inner loop
		
		if(!$found){
		//incase match not found meaning no data for this particular date. Insert a blank row	
		$blank_row = array();
		$blank_row['amount']=0;
		$blank_row['formated_created_date']=$day;
		$filtered_data[] = $blank_row;
			
		}//end of not found
		
		
	}//end of loop for days
	
	
	
	//debugging info
/*	echo '<pre>';	
	print_r($last_10days); ;
	
	
	
	print_r($projects_data);
	
	
		
	print_r($filtered_data);*/

		
		
		$data = array();
		
		foreach($filtered_data as $project){
			
			
			$date =  $project['formated_created_date'];
			$amount =  (float) $project['amount'];
			$project_title = $project['project_title'];
date_default_timezone_set('UTC');

//$date1 =   (strtotime($date) * 1000) - (strtotime('02-01-1970 00:00:00') * 1000);
$date1 =   (strtotime($date) * 1000);

	//$data[] = array($date1 ,  $amount);
$data[] = array( 'x' => $date1 , 'y' =>  $amount , 'project_name' => $project_title);
		}
		

			
//out put json			
header('Content-Type: application/json');
echo json_encode($data);


		
		
		
		
	}
	
	
function income_chart(){
		
	$permissions = $this->session->userdata('permissions_arr');
	$ALLOW_dashboard_charts  = 0;	
			if(!empty($permissions)){	
			$ALLOW_dashboard_charts =   (in_array(192,$permissions)) ? 1 : 0;
			}
		if( !$ALLOW_dashboard_charts ){
			
		return false;	
		//if no permission then don't process requests
		}
		
		
		$this->load->model('finance/mod_financial_statistics');
		
		$income_data = $this->mod_financial_statistics->get_income_chart();
		
		//print_r($projects_data);
		//header('Content-Type: application/json');
		
		
			//NEW REQUIREMENT We need to plot last 10 days. Incase a day record is not in db it should be included in the chart.
	
	//Solution: Create an array of last 10 days. Merge the data from db
	$last_10days = array();
	for ($i=0; $i<10; $i++){
    $last_10days[] = date("Y-m-d", strtotime($i." days ago"));
	}
	
	
	//reverse array for proper asending order
	$last_10days = array_reverse($last_10days);
		

		
	
	
	$filtered_data = array();
	
	foreach($last_10days as $day){
		$found = 0;
			foreach($income_data as $income){
			
					if($income['formated_created_date'] == $day){
						$found = 1;
						$filtered_data[]=$income;
					}
				
				
			}//end of inner loop
		
		if(!$found){
		//incase match not found meaning no data for this particular date. Insert a blank row	
		$blank_row = array();
		$blank_row['income_usd']=0;
		$blank_row['formated_created_date']=$day;
		$filtered_data[] = $blank_row;
			
		}//end of not found
		
		
	}//end of loop for days
	
	
	
		
				//debugging info
/*	echo '<pre>';	
	print_r($last_10days); ;
	
	
	
	print_r($income_data);
	
	
		
	print_r($filtered_data);
	
	
	exit;*/
	
	
		$data = array();
		
		foreach($filtered_data as $income){
			
			
			$date =  $income['formated_created_date'];
			$amount =  (float) $income['income_usd'];
			$project_title =  $income['project_title'];
date_default_timezone_set('UTC');

//$date1 =   (strtotime($date) * 1000) - (strtotime('02-01-1970 00:00:00') * 1000);

$date1 =   (strtotime($date) * 1000) ;
	//$data[] = array($date1 ,  $amount);
	
	$data[] = array( 'x' => $date1 , 'y' =>  $amount , 'project_name' => $project_title);
	
	

		}
		

			
//out put json			
header('Content-Type: application/json');
echo json_encode($data);


		
		
		
		
	}
	


function closing_projects(){
	
	$permissions = $this->session->userdata('permissions_arr');
	$ALLOW_dashboard_charts  = 0;	
			if(!empty($permissions)){	
			$ALLOW_dashboard_charts =   (in_array(192,$permissions)) ? 1 : 0;
			}
		if( !$ALLOW_dashboard_charts ){
			
		return false;	
		//if no permission then don't process requests
		}
		
		
		$this->load->model('projects/mod_projects');
		
		$projects_data = $this->mod_projects->closing_projects();
		
		
	/*	echo '<h3>DB DATA</h3>';
		print_r($projects_data);*/
		//header('Content-Type: application/json');
		
		
		//print_r($projects_data);
		//header('Content-Type: application/json');
	
	
	//echo date("Y-m-d", strtotime("7 days ago"));
	
	//NEW REQUIREMENT We need to plot last 10 days. Incase a day record is not in db it should be included in the chart.
	
	
	//DIFFERENT : GET 5 days in the past 5 in the future
	// START FROM minus 5 upto + 5
	$last_10days = array();
	for ($i=-5; $i<6; $i++){
    $last_10days[] = date("Y-m-d", strtotime($i." days"));
	}
	
	
	/*echo '<h3>Dates Range</h3>';
		print_r($last_10days);*/
	
	$filtered_data = array();
	
	foreach($last_10days as $day){ // loop last 10 days and populate them according to db data
		$found = 0;
			foreach($projects_data as $project){
			
					if($project['formated_end_date'] == $day){
						$found = 1;
						$filtered_data[]=$project;
					}
				
				
			}//end of inner loop
		
		if(!$found){
		//incase match not found meaning no data for this particular date. Insert a blank row	
		$blank_row = array();
		$blank_row['amount']=0;
		$blank_row['formated_end_date']=$day;
		$blank_row['project_count']=0;
		$filtered_data[] = $blank_row;
			
		}//end of not found
		
		
	}//end of loop for days
	
	/*echo '<h3>filtered_data</h3>';
		print_r($filtered_data);*/
	
	
	//debugging info
/*	echo '<pre>';	
	print_r($last_10days); ;
	
	
	
	print_r($projects_data);
	
	
		
	print_r($filtered_data);*/

		
		
		$data = array();
		
		foreach($filtered_data as $project){
			
			
			$date =  $project['formated_end_date'];
			$amount =  (float) $project['amount'];
			$project_title =  $project['project_title'];
			$project_count = (int)$project['project_count'];
			
date_default_timezone_set('UTC');

//$date1 =   (strtotime($date) * 1000) - (strtotime('02-01-1970 00:00:00') * 1000);
$date1 =   (strtotime($date) * 1000);

$data[] = array( 'x' => $date1 , 'y' =>  $project_count , 'amount' => $amount, 'project_name' => $project_title ,  'db_date' => $project['formated_end_date']);

		}
		

			
//out put json			
header('Content-Type: application/json');
echo json_encode($data);
		
		
		
		
		
		
	}
	




}//end Dashboard 
