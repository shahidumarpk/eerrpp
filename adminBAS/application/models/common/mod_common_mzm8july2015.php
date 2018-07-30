<?php
class mod_common extends CI_Model {
	function __construct(){
		
        parent::__construct();
    }
	
	//Random Password Generator
	public function random_number_generator($digit){

		$randnumber = '';
		$totalChar = $digit;  //length of random number
		$salt = "0123456789";  // salt to select chars
		srand((double)microtime()*1000000); // start the random generator
		$password=""; // set the inital variable
		
		for ($i=0;$i<$totalChar;$i++)  // loop and create number
		$randnumber = $randnumber. substr ($salt, rand() % strlen($salt), 1);
		
		return $randnumber;
		
	}// random_password_generator()
	
	
	//Random Alhpa Numeric string generator
	public function random_alphanumaric_generator($digit){

		$randnumber = '';
		$totalChar = $digit;  //length of random number
		$salt = "0123456789ABCBEFGHIJKLMNOPQRSTUVWXYZ";  // salt to select chars
		srand((double)microtime()*1000000); // start the random generator
		$password=""; // set the inital variable
		
		for ($i=0;$i<$totalChar;$i++)  // loop and create number
		$randnumber = $randnumber. substr ($salt, rand() % strlen($salt), 1);
		
		return $randnumber;
		
	}// random_password_generator()

	//Generating URL string, eliminating special characters.
	
	//Random Ticket Number Generator
	public function random_ticket_number($digit){

		$randnumber = '';
		$totalChar = $digit;  //length of random number
		$salt = "0123456789";  // salt to select chars
		srand((double)microtime()*1000000); // start the random generator
		$password=""; // set the inital variable
		
		for ($i=0;$i<$totalChar;$i++)  // loop and create number
		$randnumber = $randnumber. substr ($salt, rand() % strlen($salt), 1);
		
		return '##'.$randnumber.'##' ;
		
	}// random_password_generator()

	//Generating URL string, eliminating special characters.
	
	public function generate_seo_url($url_string){
		
		$str_tmp = str_replace(' ', '-', $url_string); // Replaces all spaces with hyphens.
		return strtolower(preg_replace('/[^A-Za-z0-9\-]/', '', $str_tmp)); 	// Replaces all Special characters	
		
	}//end generate_seo_url
	
	//If URL String already exist in the database table record generate new.
	public function verify_seo_url($url_string,$table_name,$field_name,$exclude_self){

			$this->db->dbprefix($table_name);
			$this->db->select('id');
			$this->db->where($field_name, $url_string); 
			if($exclude_self != 0) $this->db->where('id !=', $exclude_self); 
			$rs_count_rec = $this->db->get($table_name);
			//echo $this->db->last_query(); exit;
			
			if($rs_count_rec->num_rows == 0) return $url_string;
			else{
				//Add Postfix and generate concatenate.
				$generate_postfix = $this->mod_common->random_number_generator(3);
				$new_url_string = $url_string.'-'.$generate_postfix;
				return $this->mod_common->verify_seo_url($new_url_string,$table_name,'seo_url_name',$exclude_self);
				
			}//end if
		
	}//end verify_seo_url
	
	//Convert mysql format date to user defined date
	public function user_define_date($sqldate){
		
		if($sqldate!='') return date("M j, Y", strtotime($sqldate));
		else return '';
		
	}//end user_define_ddate()


	//Convert mm/dd/yyyy to Mysql Date forma Y-m-d
	public function convert_to_mysql_date($user_date){
		
		if($user_date!='') return date("Y-m-d", strtotime($user_date));
		else return '';	//end if($user_date!='')
		
	}//end convert_mysql_date()

	//Convert Mysql Date format Y-m-d to mm/dd/yyyy
	public function convert_to_standard_date($mysqldate){
		
		if($mysqldate!=''){
			return date("m/d/Y", strtotime($mysqldate));
		}else{
			return '';	
		}//end if($user_date!='')
		
	}//end convert_mysql_date()

	//Split the date and get the Array of Month, Day and Year. Allowed Date format Y-m-d and mm/dd/yyyy
	public function convert_date_to_array($mysqldate, $date_format){
		
		$date_split = array();
		
		if($mysqldate!=''){
			
			if($date_format == 'Y-m-d'){

				$dated = explode('-', $mysqldate);
				$date_split['year']  = $dated[0];
				$date_split['month'] = $dated[1];
				$date_split['day'] = $dated[2];
				
			}else{
				
				$dated = explode('/', $mysqldate);
				$date_split['year']  = $dated[2];
				$date_split['month'] = $dated[0];
				$date_split['day'] = $dated[1];
				
			}//end if($date_format == 'Y-m-d')
			
		}//end if($mysqldate!='')
		
		return $date_split;
		
	}//end convert_mysql_date()
	
	
	//A generic Function Used When a single value need to be accessed from the database. 
	public function db_common_function($select_field, $tablename, $where_fieldname, $where_fieldvalue){
		
		$this->db->select($select_field);
		$this->db->where($where_fieldname, $where_fieldvalue); 
		$get_if_record_exist = $this->db->get($tablename);
		$row_get_if_record_exist = $get_if_record_exist->row();
		
		if($get_if_record_exist->num_rows > 0) return $row_get_if_record_exist->$select_field;
		else return;
		
		
	}//end db_common_function

	//To get the number of days of a month in a given year. Parameter Given is a MYSQL date format
	function calculate_no_of_month_days($date){
		
		$year 	= date('Y', strtotime($date));
		$mmonth	= date('m', strtotime($date));
		$no_of_days  = cal_days_in_month(CAL_GREGORIAN,$month,$year);
		return $no_of_days ;
		
	}//end calculate_no_of_month_days
	


	##################################################
	#
	#  	A function that would delete folders, subfolders and files
	#
	##################################################
	
	public function remove_directory( $dir, $DeleteMe = TRUE ){
	
		if ( ! $dh = @opendir ( $dir ) ) return;
		
		while ( false !== ( $obj = readdir ( $dh ) ) ){
			if ( $obj == '.' || $obj == '..') continue;

			if ( ! @unlink ( $dir . '/' . $obj ) ) 
				$this->mod_common->remove_directory ( $dir . '/' . $obj, true );
			
		}
		
		closedir ( $dh );
		if ( $DeleteMe ){
			@rmdir ( $dir );
		}
	}//end remove_directory
	
	//Fetch Left Navigation Panel
	function fetch_admin_nav_panel(){

		$this->db->dbprefix('admin_user_roles');
		$this->db->where('show_in_nav',1);
		$this->db->order_by('display_order', 'DESC');
		
		$get_admin_navpanel = $this->db->get('admin_menu');

		//echo $this->db->last_query(); exit;
		$admin_nav_panel_arr = $get_admin_navpanel->result_array();
		
		for($i = 0 ;$i<count($admin_nav_panel_arr);$i++){
			
			if($admin_nav_panel_arr[$i]['parent_id'] == 0){
				
				$nav_panel_arr[$admin_nav_panel_arr[$i]['id']]['menu_id'] = $admin_nav_panel_arr[$i]['id'];
				$nav_panel_arr[$admin_nav_panel_arr[$i]['id']]['menu_title'] = $admin_nav_panel_arr[$i]['menu_title'];
				$nav_panel_arr[$admin_nav_panel_arr[$i]['id']]['menu_icon_class'] = $admin_nav_panel_arr[$i]['icon_class_name'];
				$nav_panel_arr[$admin_nav_panel_arr[$i]['id']]['show_in_nav'] = $admin_nav_panel_arr[$i]['show_in_nav'];
				$nav_panel_arr[$admin_nav_panel_arr[$i]['id']]['url_link'] = $admin_nav_panel_arr[$i]['url_link'];
				$nav_panel_arr[$admin_nav_panel_arr[$i]['id']]['status'] = $admin_nav_panel_arr[$i]['status'];
				
			}else{
				
				$nav_panel_arr[$admin_nav_panel_arr[$i]['parent_id']]['sub_menu'][] = $admin_nav_panel_arr[$i];
				
			}//end if
			
		}//end for

/*		echo '<pre>';
		print_r($nav_panel_arr);
		exit;
*/		
		return array_reverse($nav_panel_arr);
		
	}//end fetch_admin_nav_panel

	//Get List of all Menues
	function get_admin_menu_list(){

		$this->db->dbprefix('admin_user_roles');
		$this->db->select('id,menu_title,parent_id,set_as_default,status');
		$this->db->where('status',1);
		
		$get_admin_navpanel = $this->db->get('admin_menu');

		//echo $this->db->last_query();
		$admin_nav_panel_arr = $get_admin_navpanel->result_array();
		
		for($i = 0 ;$i<count($admin_nav_panel_arr);$i++){
			
			if($admin_nav_panel_arr[$i]['parent_id'] == 0){
				
				$nav_panel_arr[$admin_nav_panel_arr[$i]['id']]['menu_title'] = $admin_nav_panel_arr[$i]['menu_title'];
				$nav_panel_arr[$admin_nav_panel_arr[$i]['id']]['status'] = $admin_nav_panel_arr[$i]['status'];
				$nav_panel_arr[$admin_nav_panel_arr[$i]['id']]['set_as_default'] = $admin_nav_panel_arr[$i]['set_as_default'];
				
			}else{
				
				$nav_panel_arr[$admin_nav_panel_arr[$i]['parent_id']]['sub_menu'][] = $admin_nav_panel_arr[$i];
				
			}//end if
			
		}//end for

		return $nav_panel_arr;
		
	}//end get_admin_menu_list
	
	
	//Calender
	public function calendar($event_type, $event_title, $event_description, $event_url,$event_start_date, $event_end_date, $event_id, $assign_to){
		
		 $ins_data = array(
		    'event_type' => $this->db->escape_str(trim($event_type)),		  
			'event_title' => $this->db->escape_str(trim($event_title)),
		    'event_description' => $this->db->escape_str(trim($event_description)),
			'event_url' => $this->db->escape_str(trim($event_url)),
		    'event_start_date' => $this->db->escape_str(trim($event_start_date)),
		    'event_end_date' => $this->db->escape_str(trim($event_end_date)),
		    'event_id' => $this->db->escape_str(trim($event_id)),
		    'assign_to' => $this->db->escape_str(trim($assign_to))
		    );		

		   //Inserting the record into the database.
		  $this->db->dbprefix('calendar');
		  $ins_into_db = $this->db->insert('calendar', $ins_data);
		
		return true;
	
		
	}//end calender
	
	
		//Calender
	public function edit_calendar($event_type, $event_title, $event_description, $event_url,$event_start_date, $event_end_date, $event_id, $assign_to){
		
		 $upd_data = array(
		    'event_type' => $this->db->escape_str(trim($event_type)),		  
			'event_title' => $this->db->escape_str(trim($event_title)),
		    'event_description' => $this->db->escape_str(trim($event_description)),
			'event_url' => $this->db->escape_str(trim($event_url)),
		    'event_start_date' => $this->db->escape_str(trim($event_start_date)),
		    'event_end_date' => $this->db->escape_str(trim($event_end_date)),
		    'event_id' => $this->db->escape_str(trim($event_id)),
		    'assign_to' => $this->db->escape_str(trim($assign_to))
		    );		

		   //Inserting the record into the database.
		  $this->db->dbprefix('calendar');
		    $this->db->where('event_id',$event_id);
		  $ins_into_db = $this->db->update('calendar', $upd_data);
		
		return true;
	
		
	}//end calender
	
	
	//assign_project_users
	public function assign_project_users(){

		$users=array('1','2','3','4','9005');
		
		return $users;
		
	}//assign_project_users
	
	
	
	
	public function get_inbox_messages(){
		
			
		$this->db->dbprefix('messages');
		$this->db->select('COUNT(message_id) as num_messages');
		$this->db->where('message_status',0);
		$this->db->group_by('message_id');
		$this->db->order_by('message_status', ASC);
		$this->db->order_by('id', DESC);
		$this->db->where('to',$this->session->userdata('admin_id'));
		$get_messages= $this->db->get('messages');
		//echo $this->db->last_query(); exit;
		
		
		$get_messages_arr['messages_result'] = $get_messages->result_array();
		$get_messages_arr['messages_count'] = $get_messages->num_rows;
		
		
		
		
		$unread_msg_arr = array(
			'logged_in' => true,
			'unread_msg_count' =>  $get_messages_arr['messages_count']
			
			);
	
		$this->session->set_userdata($unread_msg_arr);
		
		/*echo "<pre>";
		print_r($get_messages_arr['messages_count']);
		exit;*/
		
		
		return $get_messages_arr;		
		
	}//end get_inbox_messages
	
	
	
	//Get cms page
	public function get_cms_page($seo_url_name){
		
		$this->db->dbprefix('pages');
		$this->db->where('seo_url_name',$seo_url_name);
		$get_page = $this->db->get('pages');
		//echo $this->db->last_query(); exit;
		$row_page = $get_page->row_array();
		
		return $row_page;		
		
	}//end get_cms_page	
	

	
	 //Get Assign task  Record
	public function get_assign_task_notifiations(){
		
			
		$this->db->dbprefix('project_task');
		$this->db->select('project_task.*,projects.project_title');
        $this->db->from('project_task');
		$this->db->where('project_task.status',0);
        $this->db->join('projects', 'project_task.project_id = projects.id');
		$this->db->order_by('project_task.id',DESC);
		$this->db->limit(3);
		$get_projects= $this->db->get();
		//echo $this->db->last_query();exit;
	
		$row_assign_task_arr['assign_task_arr'] = $get_projects->result_array();
		$row_assign_task_arr['assign_task_count'] = $get_projects->num_rows();
		
		
		//////
		            $counter = 0 ; 	
					$h = 0 ;
					for($k=0;$k<$row_assign_task_arr['assign_task_count'];$k++){
					
						
					$explode_arr = explode(',',$row_assign_task_arr['assign_task_arr'][$k]['user_id']);
					
					$user_id=$this->session->userdata('admin_id');
						
							if(in_array($user_id,$explode_arr))
							
							{
								
				//	$row_projects['projects_filter'] = $row_projects['projects_arr'][$k] ; 
								
					$row_assign_task['assign_task_filter'][$h]['id'] = $row_assign_task_arr['assign_task_arr'][$k]['id'] ;
					$row_assign_task['assign_task_filter'][$h]['user_id'] = $row_assign_task_arr['assign_task_arr'][$k]['user_id'] ;
					$row_assign_task['assign_task_filter'][$h]['project_id'] = $row_assign_task_arr['assign_task_arr'][$k]['project_id'] ;
					$row_assign_task['assign_task_filter'][$h]['milestone'] = $row_assign_task_arr['assign_task_arr'][$k]['milestone'] ;
					$row_assign_task['assign_task_filter'][$h]['title'] = $row_assign_task_arr['assign_task_arr'][$k]['title'] ;
					$row_assign_task['assign_task_filter'][$h]['start_date'] = $row_assign_task_arr['assign_task_arr'][$k]['start_date'] ;
					$row_assign_task['assign_task_filter'][$h]['end_date'] = $row_assign_task_arr['assign_task_arr'][$k]['end_date'] ;
					$row_assign_task['assign_task_filter'][$h]['description'] =$row_assign_task_arr['assign_task_arr'][$k]['description'] ;
					$row_assign_task['assign_task_filter'][$h]['status'] =$row_assign_task_arr['assign_task_arr'][$k]['status'] ;	
					
					$row_assign_task['assign_task_filter'][$h]['created_by'] = $row_assign_task_arr['assign_task_arr'][$k]['created_by'] ;
					$row_assign_task['assign_task_filter'][$h]['created_date'] =$row_assign_task_arr['assign_task_arr'][$k]['created_date'] ;
					$row_assign_task['assign_task_filter'][$h]['created_by_ip'] =$row_assign_task_arr['assign_task_arr'][$k]['created_by_ip'] ;
					$row_assign_task['assign_task_filter'][$h]['last_modified_by'] = $row_assign_task_arr['assign_task_arr'][$k]['last_modified_by'] ;
					$row_assign_task['assign_task_filter'][$h]['last_modified_date'] = $row_assign_task_arr['assign_task_arr'][$k]['last_modified_date'] ;
					$row_assign_task['assign_task_filter'][$h]['last_modified_ip'] = $row_assign_task_arr['assign_task_arr'][$k]['last_modified_ip'] ;
					$row_assign_task['assign_task_filter'][$h]['project_title'] = $row_assign_task_arr['assign_task_arr'][$k]['project_title'] ;
					
						        $h++;
								$counter  = $counter + 1 ;   
								
							//echo "<pre>"; print_r($row_projects['projects_filter']); exit; 	
							}
			}
			
		$row_assign_task['assign_task_count'] = $counter ;
		
			
	/*	
		echo "<pre>";
		print_r($row_assign_task['assign_task_filter']);
		exit;*/
		
		return $row_assign_task;
		
	}//end Project Records
	
	
	public function get_inbox_unread_messages(){
		
    function nicetime($date,$istime=false)
	{
		if(empty($date)) {
			return 'no_date_provided';
		}
	   
		$periods         = array("second", "minute", "hour", "day", "week", "month", "year", "decade",);
		$lengths         = array("60","60","24","7","4.35","12", "10",);
	   
		$now             = time();
		
		if(!$istime)
		$unix_date         = strtotime($date);
	    else
	   $unix_date         = $date;
	   
		   // check validity of date
		if(empty($unix_date)  || $unix_date<1) {   
			return "bad_date";
		}
	
		// is it future date or past date
		if($now > $unix_date) {   
			//time_ago
			$difference     = $now - $unix_date;
			$tense         = "time_ago";
		   
		} else {
			//from_now
			$difference     = $unix_date - $now;
			$tense         = "from_now";
		}
	   
		for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
			$difference /= $lengths[$j];
		}
	   
		$difference = round($difference);
	   
		if($difference != 1) {
			$periods[$j].= "s";
		}
	   	
		
		return $difference .' '. $periods[$j] .' ago';
	}
	
	
		
		$this->db->dbprefix('messages');
		$this->db->where('message_status',0);
		$this->db->group_by('message_id');
		$this->db->order_by('message_status', ASC);
		//$this->db->order_by('id', DESC);
		$this->db->where('to',$this->session->userdata('admin_id'));
		$this->db->where('notification',0);
		$get_all_messages= $this->db->get('messages');
		//$this->db->limit(6);
		$get_messages_arr['messages_count'] = $get_all_messages->num_rows;
		
		
		$this->db->dbprefix('messages');
		$this->db->where('message_status',0);
		$this->db->group_by('message_id');
		//$this->db->order_by('message_status', ASC);
		$this->db->order_by('id', DESC);
		$this->db->where('to',$this->session->userdata('admin_id'));
		$this->db->where('notification',0);
		$this->db->limit(3);
		$get_messages= $this->db->get('messages');
	  //  echo $this->db->last_query(); exit;
		
		$get_messages_arr['messages_result'] = $get_messages->result_array();
		//$get_messages_arr['messages_count'] = $get_messages->num_rows;
		
		for($i=0; $i<count($get_messages_arr['messages_result']); $i++){
			
			$user_id= $get_messages_arr['messages_result'][$i]['from'];
			$this->db->dbprefix('admin');
			$this->db->select('display_name');
			$this->db->where('id',$user_id);
			$get_user= $this->db->get('admin');
		    $row_user= $get_user->row_array();
			$get_messages_arr['messages_result'][$i]['user_name']=$row_user['display_name'];
			
			//echo $get_messages_arr['messages_result'][$i]['date'];
			
		$time_ago= nicetime($get_messages_arr['messages_result'][$i]['date']);
		
		$get_messages_arr['messages_result'][$i]['time_ago']=$time_ago;
		
		
		}
		
		
	/*	
		echo "<pre>";
		print_r($get_messages_arr['messages_result']);
		exit;*/
		
	
		
		return $get_messages_arr;		
		
	}//end get_inbox_unread_messages
	
	
	public function get_inbox_notifications(){
		
		 function nicetime_notification($date,$istime=false)
	     {
		if(empty($date)) {
			return 'no_date_provided';
		}
	   
		$periods         = array("second", "minute", "hour", "day", "week", "month", "year", "decade",);
		$lengths         = array("60","60","24","7","4.35","12", "10",);
	   
		$now             = time();
		
		if(!$istime)
		$unix_date         = strtotime($date);
	    else
	   $unix_date         = $date;
	   
		   // check validity of date
		if(empty($unix_date)  || $unix_date<1) {   
			return "bad_date";
		}
	
		// is it future date or past date
		if($now > $unix_date) {   
			//time_ago
			$difference     = $now - $unix_date;
			$tense         = "time_ago";
		   
		} else {
			//from_now
			$difference     = $unix_date - $now;
			$tense         = "from_now";
		}
	   
		for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
			$difference /= $lengths[$j];
		}
	   
		$difference = round($difference);
	   
		if($difference != 1) {
			$periods[$j].= "s";
		}
	   	
		
		return $difference .' '. $periods[$j] .' ago';
	}
		
		
		$where ="(notification=1 OR notification=2 OR notification=3 )";
		
		$this->db->dbprefix('messages');
		$this->db->where('message_status',0);
		$this->db->group_by('message_id');
		$this->db->order_by('message_status', ASC);
		//$this->db->order_by('id', DESC);
		$this->db->where('to',$this->session->userdata('admin_id'));
		$this->db->where($where);
		
		$get_all_messages= $this->db->get('messages');
		//$this->db->limit(6);
		$get_inbox_notifications_arr['inbox_notifications_count'] = $get_all_messages->num_rows;
		
		$this->db->dbprefix('messages');
		$this->db->where('message_status',0);
		$this->db->group_by('message_id');
		//$this->db->order_by('message_status', ASC);
		$this->db->order_by('id', DESC);
		$this->db->where('to',$this->session->userdata('admin_id'));
		$this->db->where($where);
		$this->db->limit(3);
		$get_inbox_notifications= $this->db->get('messages');
	  //  echo $this->db->last_query(); exit;
		
		$get_inbox_notifications_arr['inbox_notifications_result'] = $get_inbox_notifications->result_array();
		//$get_inbox_notifications_arr['inbox_notifications_count'] = $get_inbox_notifications->num_rows;
		
		for($i=0; $i<count($get_inbox_notifications_arr['inbox_notifications_result']); $i++){
			
			$user_id= $get_inbox_notifications_arr['inbox_notifications_result'][$i]['from'];
			$this->db->dbprefix('admin');
			$this->db->select('display_name');
			$this->db->where('id',$user_id);
			$get_user= $this->db->get('admin');
		    $row_user= $get_user->row_array();
			$get_inbox_notifications_arr['inbox_notifications_result'][$i]['user_name']=$row_user['display_name'];
			
			$time_ago= nicetime_notification($get_inbox_notifications_arr['inbox_notifications_result'][$i]['date']);
		
		    $get_inbox_notifications_arr['inbox_notifications_result'][$i]['time_ago']=$time_ago;
		  	
		}
		
		
		/*echo "<pre>";
		print_r($get_inbox_notifications_arr['inbox_notifications_result']);
		exit;
		*/

		return $get_inbox_notifications_arr;		
		
	}//end get_inbox_messages
  
  
  
  
  //Get List of all customers
	function get_customers_count(){

		$this->db->dbprefix('customers');
		$this->db->where('status',1);
		$get_customers= $this->db->get('customers');

		//echo $this->db->last_query();
		$customers_count = $get_customers->num_rows();
		
	   return $customers_count;
		
	}//end customers_count
	
	 //Get List of all projects
	function get_projects_count(){

		$this->db->dbprefix('projects');
		//$this->db->where('status',1);
		$get_projects= $this->db->get('projects');

		//echo $this->db->last_query();
		$projects_count = $get_projects->num_rows();
		
	   return $projects_count;
		
	}//end projects_count
	
	
	 //Get List of all open_projects
	function get_open_projects_count(){
		
		$where="status =0 or status=1";

		$this->db->dbprefix('projects');
		$this->db->where($where);
		$get_open_projects= $this->db->get('projects');

		//echo $this->db->last_query();
		$open_projects_count = $get_open_projects->num_rows();
		
	   return $open_projects_count;
		
	}//end open_projects_count
	
	
	 //Get List of all close_projects
	function get_close_projects_count(){

		$this->db->dbprefix('projects');
		$this->db->where('status',3);
		$get_close_projects= $this->db->get('projects');

		//echo $this->db->last_query();
		$close_projects_count = $get_close_projects->num_rows();
		
	   return $close_projects_count;
		
	}//end close_projects_count
	
	
	 //Get List of all cancel_projects
	function get_cancel_projects_count(){

		$this->db->dbprefix('projects');
		$this->db->where('status',2);
		$get_cancel_projects= $this->db->get('projects');

		//echo $this->db->last_query();
		$cancel_projects_count = $get_cancel_projects->num_rows();
		
	   return $cancel_projects_count;
		
	}//end cancel_projects_count
	
	
	 //Get List of all hold_projects
	function get_hold_projects_count(){

		$this->db->dbprefix('projects');
		$this->db->where('status',4);
		$get_hold_projects= $this->db->get('projects');

		//echo $this->db->last_query();
		$hold_projects_count = $get_hold_projects->num_rows();
		
	   return $hold_projects_count;
		
	}//end hold_projects_count
	
	
	 //Get projects_accounts
	function projects_accounts(){

		$this->db->dbprefix('projects_account');
		$this->db->select('SUM(income) as total_income, SUM(expense) as total_expense');
		$projects= $this->db->get('projects_account');

		//echo $this->db->last_query();
		$projects_arr = $projects->row_array();
		
		
	   return $projects_arr;
		
	}//end close_projects_count
	
	
	 //Get projects_expected_income
	function projects_expected_income(){

		$this->db->dbprefix('projects');
		$this->db->select('SUM(project_amount) as total_amount, SUM(received_amount) as total_received');
		$this->db->where('status',0); 
		$this->db->or_where('status',1); 
		$projects= $this->db->get('projects');

		//echo $this->db->last_query();
		$expected_income_arr = $projects->row_array();
		
		
	   return $expected_income_arr;
		
	}//end projects_expected_income
	
	
	
    //Get List of all get_my_projects_count
	function get_my_projects_count(){
		
		
		$user_id=$this->session->userdata('admin_id');
		
		$this->db->dbprefix('projects');
		//$this->db->where('status',1);
		$get_projects= $this->db->get('projects');

		//echo $this->db->last_query();
		$projects_arr = $get_projects->result_array();
		$projects_count = $get_projects->num_rows();
		
		
					$counter = 1 ; 	
					$h = 0 ;
					for($k=0;$k<$projects_count;$k++){
					$explode_arr = explode(',',$projects_arr[$k]['project_assign']);
						
							if(in_array($user_id,$explode_arr))
							
							{
								
								$my_projects+= $counter;
								
							}
							
						}
						
						
						
	   return $my_projects;
		
	}//end projects_count
	
	
	  //Get List of all get_my_open_projects_count
	function get_my_open_projects_count(){
		
		
		$user_id=$this->session->userdata('admin_id');
		
		$where="status =0 or status=1";
		
		$this->db->dbprefix('projects');
		$this->db->where($where);
		$get_projects= $this->db->get('projects');

		//echo $this->db->last_query();
		$projects_arr = $get_projects->result_array();
		$projects_count = $get_projects->num_rows();
		
		
					$counter = 1 ; 	
					$h = 0 ;
					for($k=0;$k<$projects_count;$k++){
					$explode_arr = explode(',',$projects_arr[$k]['project_assign']);
						
							if(in_array($user_id,$explode_arr))
							
							{
								
								$my_open_projects+= $counter;
								
							}
							
						}
						
						
						
	   return $my_open_projects;
		
	}//end my_open_projects
	
	
	  //Get List of all get_my_hold_projects_count
	function get_my_hold_projects_count(){
		
		
		$user_id=$this->session->userdata('admin_id');
		
		
		$this->db->dbprefix('projects');
		$this->db->where('status',4);
		$get_projects= $this->db->get('projects');

		//echo $this->db->last_query();
		$projects_arr = $get_projects->result_array();
		$projects_count = $get_projects->num_rows();
		
		
					$counter = 1 ; 	
					$h = 0 ;
					for($k=0;$k<$projects_count;$k++){
					$explode_arr = explode(',',$projects_arr[$k]['project_assign']);
						
							if(in_array($user_id,$explode_arr))
							
							{
								
								$my_hold_projects+= $counter;
								
							}
							
						}
						
						
						
	   return $my_hold_projects;
		
	}//end get_my_hold_projects_count
	
	
	
	  //Get List of all get_my_closed_projects_count
	function get_my_closed_projects_count(){
		
		
		$user_id=$this->session->userdata('admin_id');
		
		
		$this->db->dbprefix('projects');
		$this->db->where('status',3);
		$get_projects= $this->db->get('projects');

		//echo $this->db->last_query();
		$projects_arr = $get_projects->result_array();
		$projects_count = $get_projects->num_rows();
		
		
					$counter = 1 ; 	
					$h = 0 ;
					for($k=0;$k<$projects_count;$k++){
					$explode_arr = explode(',',$projects_arr[$k]['project_assign']);
						
							if(in_array($user_id,$explode_arr))
							
							{
								
								$my_closed_projects+= $counter;
								
							}
							
						}
						
						
						
	   return $my_closed_projects;
		
	}//end my_closed_projects
	
	
	  //Get List of all get_my_cancel_projects_count
	function get_my_cancel_projects_count(){
		
		
		$user_id=$this->session->userdata('admin_id');
		
		
		$this->db->dbprefix('projects');
		$this->db->where('status',2);
		$get_projects= $this->db->get('projects');

		//echo $this->db->last_query();
		$projects_arr = $get_projects->result_array();
		$projects_count = $get_projects->num_rows();
		
		
					$counter = 1 ; 	
					$h = 0 ;
					for($k=0;$k<$projects_count;$k++){
					$explode_arr = explode(',',$projects_arr[$k]['project_assign']);
						
							if(in_array($user_id,$explode_arr))
							
							{
								
								$my_cancel_projects+= $counter;
								
							}
							
						}
						
						
						
	   return $my_cancel_projects;
		
	}//end get_my_cancel_projects_count
	
	
	
	
	  //Get List of all get_my_tasks
	function get_my_tasks(){
		
		
		$user_id=$this->session->userdata('admin_id');
		
		
		$this->db->dbprefix('project_task');
		//$this->db->where('status',3);
		$get_tasks= $this->db->get('project_task');

		//echo $this->db->last_query();
		$tasks_arr = $get_tasks->result_array();
		$tasks_count = $get_tasks->num_rows();
		
		
					$counter = 1 ; 	
					$h = 0 ;
					for($k=0;$k<$tasks_count;$k++){
					$explode_arr = explode(',',$tasks_arr[$k]['user_id']);
						
							if(in_array($user_id,$explode_arr))
							
							{
								
								$my_tasks+= $counter;
								
							}
							
						}
						
						
						
	   return $my_tasks;
		
	}//end my_tasks
	
	
	  //Get List of all my_open_tasks
	function get_my_open_tasks(){
		
		
		$user_id=$this->session->userdata('admin_id');
		
		$where="status =0 or status=1 or status=4";
		
		$this->db->dbprefix('project_task');
		$this->db->where($where);
		$get_tasks= $this->db->get('project_task');

		//echo $this->db->last_query();
		$tasks_arr = $get_tasks->result_array();
		$tasks_count = $get_tasks->num_rows();
		
		
					$counter = 1 ; 	
					$h = 0 ;
					for($k=0;$k<$tasks_count;$k++){
					$explode_arr = explode(',',$tasks_arr[$k]['user_id']);
						
							if(in_array($user_id,$explode_arr))
							
							{
								
								$my_open_tasks+= $counter;
								
							}
							
						}
						
						
						
	   return $my_open_tasks;
		
	}//end my_open_tasks
	
	
    //Get List of all my_closed_tasks
	function my_closed_tasks(){
		
		
		$user_id=$this->session->userdata('admin_id');
		
		//$where="status =0 or status=1";
		
		$this->db->dbprefix('project_task');
		$this->db->where('status',3);
		$get_tasks= $this->db->get('project_task');

		//echo $this->db->last_query();
		$tasks_arr = $get_tasks->result_array();
		$tasks_count = $get_tasks->num_rows();
		
		
					$counter = 1 ; 	
					$h = 0 ;
					for($k=0;$k<$tasks_count;$k++){
					$explode_arr = explode(',',$tasks_arr[$k]['user_id']);
						
							if(in_array($user_id,$explode_arr))
							
							{
								
								$my_closed_tasks+= $counter;
								
							}
							
						}
						
						
						
	   return $my_closed_tasks;
		
	}//end my_closed_tasks
	
	
	 //Get List of all my_hold_tasks
	function my_hold_tasks(){
		
		
		$user_id=$this->session->userdata('admin_id');
		
		//$where="status =0 or status=1";
		
		$this->db->dbprefix('project_task');
		$this->db->where('status',2);
		$get_tasks= $this->db->get('project_task');

		//echo $this->db->last_query();
		$tasks_arr = $get_tasks->result_array();
		$tasks_count = $get_tasks->num_rows();
		
		
					$counter = 1 ; 	
					$h = 0 ;
					for($k=0;$k<$tasks_count;$k++){
					$explode_arr = explode(',',$tasks_arr[$k]['user_id']);
						
							if(in_array($user_id,$explode_arr))
							
							{
								
								$my_hold_tasks+= $counter;
								
							}
							
						}
						
						
						
	   return $my_hold_tasks;
		
	}//end my_hold_tasks






}

?>