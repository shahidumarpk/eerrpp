<?php
class mod_financial_statistics extends CI_Model {
	
	function __construct(){
		
        parent::__construct();
    }

	//Verify If User is Login on the authorized Pages.
	public function verify_is_admin_login(){
		
		if(!$this->session->userdata('admin_id')){
			

			$this->session->set_flashdata('err_message', '- You have to login to access this page.');
			redirect(base_url().'login/login');
			
		}//if(!$this->session->userdata('id'))
		
	}//end verify_is_user_login()


    //Get Total Number of projects in Database
	public function count_total_projects(){
		
		$this->db->dbprefix('projects');
		$where ="project_amount >0.00 and (status=0 OR status=1)";
		$this->db->where($where);
		$get_projects_list_limit = $this->db->get('projects');
		//echo $this->db->last_query();exit;
		 
	    $count= $get_projects_list_limit->num_rows;
		
	
		return $count;
		
	}//end count_total_projects
	
	
	//Get Projects record.
	public function get_projects_limit($start, $limit){
		
		
	  if($this->input->post('branch_id')!=""){
				
			$branch_id= $this->input->post('branch_id');
			
			
            $where ="project_amount >0.00 and (status=0 OR status=1)";
				
			$this->db->dbprefix('projects');
			$this->db->where('branch_id', $branch_id);
			$this->db->where($where);
		     
		    $this->db->limit($limit,$start);
		    $this->db->order_by('created_date',ASC);
		    $get_projects_list_limit = $this->db->get('projects');
		   //echo $this->db->last_query();exit;
		 
		    $row_get_projects_list_limit['projects_list_result'] = $get_projects_list_limit->result_array();
		    $row_get_projects_list_limit['projects_list_count'] = $get_projects_list_limit->num_rows;
			
			
		    return $row_get_projects_list_limit;		
			
				
	   }
	    
	  if($this->input->post('project_id')!=""){
		  
		  
				
			$project_id= $this->input->post('project_id');
			
			if($project_id !='0'){
				
			
				$this->db->dbprefix('projects');
				$this->db->where('id',$project_id); 
				$this->db->limit($limit,$start);
				$this->db->order_by('created_date',ASC);
				$get_projects_list_limit = $this->db->get('projects');
			   // echo $this->db->last_query();exit;
				
				
			}else{
				
				
				$this->db->dbprefix('projects');
				$this->db->limit($limit,$start);
				$this->db->order_by('created_date',ASC);
				$get_projects_list_limit = $this->db->get('projects');
			   //echo $this->db->last_query();exit;
			   
			   
				
				
			}
				
			
		 
		    $row_get_projects_list_limit['projects_list_result'] = $get_projects_list_limit->result_array();
		    $row_get_projects_list_limit['projects_list_count'] = $get_projects_list_limit->num_rows;
			
		 
			
		    return $row_get_projects_list_limit;		
			
				
	   }	
		
	  if($this->input->post('from_date') !="" && $this->input->post('to_date')!="")
		{
			
		    $from_date = date('Y-m-d',strtotime($_POST['from_date']));
		    $to_date = date('Y-m-d',strtotime($_POST['to_date']));
			
			
			$this->db->dbprefix('projects');
			$this->db->where("created_date BETWEEN '".$from_date."' AND '".$to_date."'"); 
		    $this->db->where('status',0); 
		    $this->db->or_where('status',1); 
		    $this->db->limit($limit,$start);
		    $this->db->order_by('created_date',ASC);
		    $get_projects_list_limit = $this->db->get('projects');
		    // echo $this->db->last_query();exit;
		 
		    $row_get_projects_list_limit['projects_list_result'] = $get_projects_list_limit->result_array();
		    $row_get_projects_list_limit['projects_list_count'] = $get_projects_list_limit->num_rows;
			
		    //print_r($row_get_projects_list_limit['projects_list_result']);
	 
		    return $row_get_projects_list_limit;		
			
			
		}
		else{
		
		 
		   $where ="project_amount >0.00 and (status=0 OR status=1)";
		   $this->db->dbprefix('projects');
		   $this->db->limit($limit,$start);
		   $this->db->order_by('project_title ASC');
		   $this->db->where($where);
		   $get_projects_list_limit = $this->db->get('projects');
		   //echo $this->db->last_query();exit;
		
		   $row_get_projects_list_limit['projects_list_result'] = $get_projects_list_limit->result_array();
		   $row_get_projects_list_limit['projects_list_count'] = $get_projects_list_limit->num_rows;
		
		 /* echo "<pre>";
		  print_r($row_get_projects_list_limit['projects_list_result']);
		  exit;*/
	
		  return $row_get_projects_list_limit;
		
		}//end if
		
	}//end get_projects_limit
	
	
	
	
    //Get projects  Record
	public function get_all_projects(){
		
		$this->db->dbprefix('projects');
		$this->db->where('status',0); 
		$this->db->or_where('status',1); 
		$this->db->order_by('project_title',ASC); 
		//$this->db->where('project_amount !=',0.00);
		$get_projects= $this->db->get('projects');
		//echo $this->db->last_query();exit;
		
		$row_projects['projects_arr'] = $get_projects->result_array();
		$row_projects['projects_count'] = $get_projects->num_rows;
		
		
		for($i=0; $i<$row_projects['projects_count']; $i++){
			
			 $grand_total+=$row_projects['projects_arr'][$i]['project_amount']."<br />";
			
			
			}
		
		$row_projects['grand_total']=$grand_total;
		
		/*echo "<pre>";
		print_r($row_projects['grand_total']);
		exit;*/
		return $row_projects;
	}//end Project Records
	

   	//Add Income
	public function add_income($data){
		
		extract($data);
		
		   $date = date("Y-m-d", strtotime($date));
		
	
		   $created_date = date('Y-m-d G:i:s');
		   $created_by_ip = $this->input->ip_address();
		   $created_by = $this->session->userdata('admin_id');
		   
		   $ins_data = array(
		    'branch_id' => $this->db->escape_str(trim($branch_id)),
		    'income' => $this->db->escape_str(trim($amount)),
		    'expense' => $this->db->escape_str(trim(0)),
			'dated' => $this->db->escape_str(trim($date)),
			'description' => $this->db->escape_str(trim(nl2br($discription))),
		    'created_by' => $this->db->escape_str(trim($created_by)),
		    'created_date' => $this->db->escape_str(trim($created_date)),
		    'created_by_ip' => $this->db->escape_str(trim($created_by_ip))
		    );		

		   //Inserting the record into the database.
		  $this->db->dbprefix('projects_account');
		  $ins_into_db = $this->db->insert('projects_account', $ins_data);
		  
		  return true;
		  
		  
	}//End income
	
	
	//Add Expenses
	public function add_expense($data){
		
		extract($data);
		
		   $dated = date("Y-m-d", strtotime($date));
		
	
		   $created_date = date('Y-m-d G:i:s');
		   $created_by_ip = $this->input->ip_address();
		   $created_by = $this->session->userdata('admin_id');
		   
		   $ins_data = array(
		    'branch_id' => $this->db->escape_str(trim($branch_id)),
		    'income' => $this->db->escape_str(trim(0)),
		    'expense' => $this->db->escape_str(trim($amount)),
			'dated' => $this->db->escape_str(trim($dated)),
			'description' => $this->db->escape_str(trim(nl2br($discription))),
		    'created_by' => $this->db->escape_str(trim($created_by)),
		    'created_date' => $this->db->escape_str(trim($created_date)),
		    'created_by_ip' => $this->db->escape_str(trim($created_by_ip))
		    );		

		   //Inserting the record into the database.
		  $this->db->dbprefix('projects_account');
		  $ins_into_db = $this->db->insert('projects_account', $ins_data);
		  
		  return true;
		  
		  
	}//End expenses
	
	
	
	//Get financial report
	public function financial_report($data){
		
		
		if($this->input->post('from_date') !="" && $this->input->post('to_date')!="")
		{
			
			$from_date_sum = date('Y-m-d', strtotime('-1 day', strtotime($_POST['from_date'])));
			
			$this->db->dbprefix('projects_account');
		    $this->db->select('SUM(income) as gincome,SUM(expense) as gexpenses ');
		    $this->db->where('dated <=', $from_date_sum);
		    $get_data = $this->db->get('projects_account');
		    //echo $this->db->last_query();exit;
		    $row_arr= $get_data->row_array();
			
			
		    $from_date = date('Y-m-d',strtotime($_POST['from_date']));
		    $to_date = date('Y-m-d',strtotime($_POST['to_date']));
			
			$this->db->dbprefix('projects_account');
		    $this->db->where("dated BETWEEN '".$from_date."' AND '".$to_date."'"); 
		    $this->db->order_by('dated', DESC);
		    $get_data_arr = $this->db->get('projects_account');
		    // echo $this->db->last_query();exit;
		   
	   }
	   elseif($this->input->post('branch_id') !="")
		{
			
			$from_date_sum = date('Y-m-d', strtotime('-1 day', strtotime($_POST['from_date'])));
			
			$this->db->dbprefix('projects_account');
		    $this->db->select('SUM(income) as gincome,SUM(expense) as gexpenses ');
		    $this->db->where('dated <=', $from_date_sum);
		    $get_data = $this->db->get('projects_account');
		    //echo $this->db->last_query();exit;
		    $row_arr= $get_data->row_array();
			
			$this->db->dbprefix('projects_account');
		    $this->db->where('branch_id',$this->input->post('branch_id')); 
		    $this->db->order_by('dated', DESC);
		    $get_data_arr = $this->db->get('projects_account');
		    // echo $this->db->last_query();exit;
		   
	   }
		
	 else{	
		$yesterday = date('Y-m-d',strtotime("-1 days"));
		
		$this->db->dbprefix('projects_account');
		$this->db->select('SUM(income) as gincome,SUM(expense) as gexpenses ');
		$this->db->where('dated <=', $yesterday);
		$get_data = $this->db->get('projects_account');
		//echo $this->db->last_query();exit;
		$row_arr= $get_data->row_array();
		
		
		$this->db->dbprefix('projects_account');
		$this->db->where('dated >=', date('Y-m-d'));
		$this->db->order_by('dated', ASC);
		$get_data_arr = $this->db->get('projects_account');
		//echo $this->db->last_query();exit;
	}//End if
		
		
		$row_arr['row_data_arr']= $get_data_arr->result_array();
		$row_arr['row_data_count']= $get_data_arr->num_rows();		
		return $row_arr;
		
	}//end financial_report
	
	
	
	
	 //Get expense Record
	public function get_all_expenses(){
	
		$this->db->dbprefix('projects_account');
		$this->db->select('expense'); 
        $this->db->from('projects_account'); 
		$this->db->where('expense !=',0.00);
		$get_data_arr = $this->db->get();
		//echo $this->db->last_query();exit;
	
		$row_expenses['expense_arr'] = $get_data_arr->result_array();
		$row_expenses['expense_count'] = $get_data_arr->num_rows;
		
		for($i=0; $i<$row_expenses['expense_count']; $i++){
			
			 $grand_total+= $row_expenses['expense_arr'][$i]['expense']."<br />";
			
			}
		
		
	    $count['grand_total']=$grand_total;
		return $count;
	}//end expense Records
	
	 //Get Total Number of expenses
	public function count_total_expenses(){
		
		$this->db->dbprefix('projects_account');
		$this->db->select('expense'); 
        $this->db->from('projects_account'); 
		$this->db->where('expense !=',0.00);
		$get_data_arr = $this->db->get();
		//echo $this->db->last_query();exit;
		
		return $row_count['data_count']= $get_data_arr->num_rows();
		 
	}//end count_total_projects
	
	
	//Get expense Report
	public function expense_report($start, $limit){
		
	  if($this->input->post('branch_id') !="")
		{
			
			$this->db->dbprefix('projects_account');
			$this->db->select('id,branch_id,expense,description,dated'); 
            $this->db->from('projects_account');
			$this->db->where('expense !=',0.00); 
		    $this->db->where("branch_id",$this->input->post('branch_id')); 
		    $this->db->order_by('dated', DESC);
		    $get_data_arr = $this->db->get();
		  //echo $this->db->last_query();exit;						
	   }
	
	  elseif($this->input->post('from_date') !="" && $this->input->post('to_date')!="")
		{
			
			
		    $from_date = date('Y-m-d',strtotime($_POST['from_date']));
		    $to_date = date('Y-m-d',strtotime($_POST['to_date']));
			
			$this->db->dbprefix('projects_account');
			$this->db->select('id,branch_id,expense,description,dated'); 
            $this->db->from('projects_account');
			$this->db->where('expense !=',0.00); 
		    $this->db->where("dated BETWEEN '".$from_date."' AND '".$to_date."'"); 
		    $this->db->order_by('dated', DESC);
		    $get_data_arr = $this->db->get();
		  
	   }
		
	 else{	
		
		
		$this->db->dbprefix('projects_account');
		$this->db->select('id,branch_id,expense,description,dated'); 
        $this->db->from('projects_account'); 
		$this->db->where('expense !=',0.00);
		$this->db->where('MONTH(dated)',date('m'));
		$this->db->limit($limit,$start);
		$this->db->order_by('dated', DESC);
		$get_data_arr = $this->db->get();
	    //echo $this->db->last_query();exit;
		
	 }//End if
	 	
		$row_arr['row_data_arr']= $get_data_arr->result_array();
		$row_arr['row_data_count']= $get_data_arr->num_rows();
		
		for($i=0; $i<count($row_arr['row_data_arr']); $i++){
			
		        $branch_id= $row_arr['row_data_arr'][$i]['branch_id'];
				
			    $this->db->dbprefix('branches');
				$this->db->select('branch_name');
				$this->db->where('id',$branch_id);
				$get_data = $this->db->get('branches');
				$branch_arr= $get_data->row_array();
				
			    $row_arr['row_data_arr'][$i]['branch_name']=$branch_arr['branch_name'];	
			
			}
		
		return $row_arr;
		
	
	
 }//end expense_report
 
	
	 //Edit Expense
	public function edit_expense($expense_id){
		
		$this->db->dbprefix('projects_account');
		$this->db->where('id',$expense_id);
		$get_expense_arr = $this->db->get('projects_account');
		//echo $this->db->last_query();exit;
		$expense_data_arr['expense_arr']= $get_expense_arr->row_array();
		
		return $expense_data_arr;
		 
	}//end edit_expense
	
	
	//Edit expense process
	public function edit_expense_process($data){
		
		   extract($data);
		   
		   $dated = date("Y-m-d", strtotime($date));
		   
		   $last_modified_date = date('Y-m-d G:i:s');
		   $last_modified_ip = $this->input->ip_address();
		   $last_modified_by = $this->session->userdata('admin_id');
		   
		   $upt_data = array(
		    'income' => $this->db->escape_str(trim(0)),
			'expense' => $this->db->escape_str(trim($amount)),
			'dated' => $this->db->escape_str(trim($dated)),
			'description' => $this->db->escape_str(trim($description)),
		    'last_modified_by' => $this->db->escape_str(trim($last_modified_by)),
		    'last_modified_date' => $this->db->escape_str(trim($last_modified_date)),
		    'last_modified_ip' => $this->db->escape_str(trim($last_modified_ip))
		    );		

		   //Inserting the record into the database.
		  $this->db->dbprefix('projects_account');
		  $this->db->where('id',$expense_id);
		  $update_db = $this->db->update('projects_account', $upt_data);
		  
		  return  $update_db ;
		  
	}//End edit_expense_process
 
 
     //Delete Expense
	public function delete_expense($expense_id){
		
		$this->db->dbprefix('projects_account');
		$this->db->where('id',$expense_id);
		$this->db->delete('projects_account');
		//echo $this->db->last_query();exit;
		
		return true;
		 
	}//end delete_expense
 
    //Get all_income Record
	public function get_all_income(){
	
		$this->db->dbprefix('projects_account');
		$this->db->select('income'); 
        $this->db->from('projects_account'); 
		$this->db->where('income !=',0.00);
		$get_income= $this->db->get();
		//echo $this->db->last_query();exit;
	
		$row_income['income_arr'] = $get_income->result_array();
		$row_income['income_count'] = $get_income->num_rows;
		
		for($i=0; $i<$row_income['income_count']; $i++){
			
			 $grand_total+= $row_income['income_arr'][$i]['income']."<br />";
			
			}
		
		
	    $count['grand_total']=$grand_total;
		return $count;
	}//end income Records
	
	 //Get Total Number of income
	public function count_total_income(){
		
		$this->db->dbprefix('projects_account');
		$this->db->select('income'); 
        $this->db->from('projects_account'); 
		$this->db->where('income !=',0.00);
		$get_data_arr = $this->db->get();
		//echo $this->db->last_query();exit;
		
		return $row_count['data_count']= $get_data_arr->num_rows();
		 
	}//end count_total_income
	
 
    //Get Income Report
	public function income_report($start, $limit){
	
	  if($this->input->post('from_date') !="" && $this->input->post('to_date')!="")
		{
			
		    $from_date = date('Y-m-d',strtotime($_POST['from_date']));
		    $to_date = date('Y-m-d',strtotime($_POST['to_date']));
			
			$this->db->dbprefix('projects_account');
			$this->db->select('id,branch_id,income,description,dated'); 
            $this->db->from('projects_account'); 
			$this->db->where('income !=',0.00);
		    $this->db->where("dated BETWEEN '".$from_date."' AND '".$to_date."'"); 
		    $this->db->order_by('dated', DESC);
		    $get_data_arr = $this->db->get();
	   }
	   elseif($this->input->post('branch_id') !="")
		{
			
			$this->db->dbprefix('projects_account');
			$this->db->select('id,branch_id,income,description,dated'); 
            $this->db->from('projects_account'); 
			$this->db->where('income !=',0.00);
		    $this->db->where('branch_id',$this->input->post('branch_id')); 
		    $this->db->order_by('dated', DESC);
		    $get_data_arr = $this->db->get();
	   }
	 else{	
		
		$this->db->dbprefix('projects_account');
		$this->db->select('id,branch_id,income,description,dated'); 
        $this->db->from('projects_account'); 
		$this->db->where('income !=',0.00);
		$this->db->where('MONTH(dated)',date('m'));
		$this->db->limit($limit,$start);
		$this->db->order_by('dated', DESC);
		$get_data_arr = $this->db->get();
		
	 }//End if
	 
	 //echo $this->db->last_query();exit;
		$row_arr['row_data_arr']= $get_data_arr->result_array();
		$row_arr['row_data_count']= $get_data_arr->num_rows();
		
	 for($i=0; $i<count($row_arr['row_data_arr']); $i++){
			
		       $branch_id= $row_arr['row_data_arr'][$i]['branch_id'];
				
			    $this->db->dbprefix('branches');
				$this->db->select('branch_name');
				$this->db->where('id',$branch_id);
				$get_data = $this->db->get('branches');
				$branch_arr= $get_data->row_array();
				
			    $row_arr['row_data_arr'][$i]['branch_name']=$branch_arr['branch_name'];	
			
		}
		
		/*echo "<pre>";
		print_r($row_arr['row_data_arr']);
		exit;*/
	
		return $row_arr;
	
    }//end income report
 
 
     //Edit income
	public function edit_income($income_id){
		
		$this->db->dbprefix('projects_account');
		$this->db->where('id',$income_id);
		$get_expense_arr = $this->db->get('projects_account');
		//echo $this->db->last_query();exit;
		$income_data_arr['income_arr']= $get_expense_arr->row_array();
		
		return $income_data_arr;
		 
	}//end edit_expense
	
	
	//Edit income process
	public function edit_income_process($data){
		
		   extract($data);
		   
		   $dated = date("Y-m-d", strtotime($date));
		   
		   $last_modified_date = date('Y-m-d G:i:s');
		   $last_modified_ip = $this->input->ip_address();
		   $last_modified_by = $this->session->userdata('admin_id');
		   
		   $upt_data = array(
		    'income' => $this->db->escape_str(trim($amount)),
			'expense' => $this->db->escape_str(trim(0)),
			'dated' => $this->db->escape_str(trim($dated)),
			'description' => $this->db->escape_str(trim($description)),
		    'last_modified_by' => $this->db->escape_str(trim($last_modified_by)),
		    'last_modified_date' => $this->db->escape_str(trim($last_modified_date)),
		    'last_modified_ip' => $this->db->escape_str(trim($last_modified_ip))
		    );		

		   //Inserting the record into the database.
		  $this->db->dbprefix('projects_account');
		  $this->db->where('id',$income_id);
		  $update_db = $this->db->update('projects_account', $upt_data);
		  
		  return  $update_db ;
		  
	}//End edit_income_process
 
 
    //Delete Income
	public function delete_income($income_id){
		
		$this->db->dbprefix('projects_account');
		$this->db->where('id',$income_id);
		$this->db->delete('projects_account');
		//echo $this->db->last_query();exit;
		
		return true;
		 
	}//end delete_income
 
    //Add Forum
	public function add_forum($data){
		
		   extract($data);
		   
		   $created_date = date('Y-m-d G:i:s');
		   $created_by_ip = $this->input->ip_address();
		   $created_by = $this->session->userdata('admin_id');
		   
		   $ins_data = array(
		    'forum_name' => $this->db->escape_str(trim($forum_name)),
			'forum_profile_url' => $this->db->escape_str(trim($forum_profile_url)),
		    'created_by' => $this->db->escape_str(trim($created_by)),
		    'created_date' => $this->db->escape_str(trim($created_date)),
		    'created_by_ip' => $this->db->escape_str(trim($created_by_ip))
		    );		

		   //Inserting the record into the database.
		  $this->db->dbprefix('forums');
		  $ins_into_db = $this->db->insert('forums', $ins_data);
		  
		  return true;
		  
	}//End add_forum
	
	
	
    //Get Total Number of forum in Database
	public function count_total_forum(){
		
		$this->db->dbprefix('forums');
		return $this->db->count_all("forums");
		
	}//end count_total_forum
	
	
	 //Get Forum
	public function get_forum_record($start, $limit){
		
		$this->db->dbprefix('forums');
		$this->db->limit($limit,$start);
		$get_forum_arr = $this->db->get('forums');
		//echo $this->db->last_query();exit;
		$forum_data_arr['forum_arr']= $get_forum_arr->result_array();
		$forum_data_arr['forum_count']= $get_forum_arr->num_rows();
		
		return $forum_data_arr;
		 
	}//end get_forum
	
	
	 //Get Forum
	public function get_forum(){
		
		$this->db->dbprefix('forums');
		$get_forum_arr = $this->db->get('forums');
		//echo $this->db->last_query();exit;
		$forum_data_arr['forum_arr']= $get_forum_arr->result_array();
		$forum_data_arr['forum_count']= $get_forum_arr->num_rows();
		
		return $forum_data_arr;
		 
	}//end get_forum
	
	
	
	 //Edit Forum
	public function edit_forum($forum_id){
		
		$this->db->dbprefix('forums');
		$this->db->where('id',$forum_id);
		$get_forum_arr = $this->db->get('forums');
		//echo $this->db->last_query();exit;
		$forum_data_arr['forum_arr']= $get_forum_arr->row_array();
		$forum_data_arr['forum_count']= $get_forum_arr->num_rows();
		
		return $forum_data_arr;
		 
	}//end edit_forum
	
	
	
	//Edit form process
	public function edit_forum_process($data){
		
		   extract($data);
		 
		   $last_modified_date = date('Y-m-d G:i:s');
		   $last_modified_ip = $this->input->ip_address();
		   $last_modified_by = $this->session->userdata('admin_id');
		   
		   $upt_data = array(
		    'forum_name' => $this->db->escape_str(trim($forum_name)),
			'forum_profile_url' => $this->db->escape_str(trim($forum_profile_url)),
		    'last_modified_by' => $this->db->escape_str(trim($last_modified_by)),
		    'last_modified_date' => $this->db->escape_str(trim($last_modified_date)),
		    'last_modified_ip' => $this->db->escape_str(trim($last_modified_ip))
		    );		

		   //Inserting the record into the database.
		  $this->db->dbprefix('forums');
		  $this->db->where('id',$forum_id);
		  $update_db = $this->db->update('forums', $upt_data);
		  
		  return  $update_db ;
		  
	}//End edit_forum_process
	
	
	//Deleted forum
	public function delete_forum($forum_id){
		
		  $this->db->dbprefix('forums');
		  $this->db->where('id',$forum_id);
		  $delete = $this->db->delete('forums');
		  
		  return  $delete ;
		  
	}//End deleted forum
	
	
	
	 //Get Total Number of cash in Database
	public function count_total_cash(){
		
		$this->db->dbprefix('forum_cash_log');
		return $this->db->count_all("forum_cash_log");
		
	}//end count_total_cash
	
	
	//Get cash
	public function get_cash($start, $limit){
	
		$this->db->dbprefix('forum_cash_log');
		$this->db->select('forum_cash_log.*,forums.forum_name');
        $this->db->from('forum_cash_log');
        $this->db->join('forums', 'forum_cash_log.forum_id = forums.id');
		$this->db->limit($limit,$start);
		$get_cash_arr= $this->db->get();
		//echo $this->db->last_query();exit;
		$cash_data_arr['cash_arr']= $get_cash_arr->result_array();
		$cash_data_arr['cash_count']= $get_cash_arr->num_rows();

		return $cash_data_arr;
		 
	}//end get_cash
	
	
	
	
	 //Get get_all_cash_record 
	public function get_all_cash_record(){
	
		$this->db->dbprefix('forum_cash_log');
		$get_income= $this->db->get('forum_cash_log');
		//echo $this->db->last_query();exit;
		$row_cash['cash_data_arr'] = $get_income->result_array();
		$row_cash['cash_data_count'] = $get_income->num_rows;
		
		for($i=0; $i<$row_cash['cash_data_count']; $i++){
			
			  $grand_total_amount+= $row_cash['cash_data_arr'][$i]['amount']."<br />";
			
			}
		
		$count['grand_total_amount']=$grand_total_amount;
		 
		return $count;
	}//end get all_cash_record
	
	
	
	
	//Add Cash
	public function add_cash($data){
		
		   extract($data);
		   
		   $dated = date("Y-m-d", strtotime($date));
		   
		   $created_date = date('Y-m-d G:i:s');
		   $created_by_ip = $this->input->ip_address();
		   $created_by = $this->session->userdata('admin_id');
		   
		   
		   $ins_data = array(
		    'forum_id' => $this->db->escape_str(trim($forum_id)),
			'amount' => $this->db->escape_str(trim($amount)),
			'dated' => $this->db->escape_str(trim($dated)),
			'detail' => $this->db->escape_str(trim($detail)),
		    'created_by' => $this->db->escape_str(trim($created_by)),
		    'created_date' => $this->db->escape_str(trim($created_date)),
		    'created_by_ip' => $this->db->escape_str(trim($created_by_ip))
		    );		

		   //Inserting the record into the database.
		  $this->db->dbprefix('forum_cash_log');
		  $ins_into_db = $this->db->insert('forum_cash_log', $ins_data);
		  
		  
		  //Update Forum Record
		    $upt_data = array(
		    'amount' => $this->db->escape_str(trim($amount)),
		    'last_modified_by' => $this->db->escape_str(trim($created_by)),
		    'last_modified_date' => $this->db->escape_str(trim($created_date)),
		    'last_modified_ip' => $this->db->escape_str(trim($created_by_ip))
		    );		

		   //Inserting the record into the database.
		  $this->db->dbprefix('forums');
		  $this->db->where('id',$forum_id);
		  $update_db = $this->db->update('forums', $upt_data);
		  
		  
		  return true;
		  
	}//End add_cash
	
	
	
	
	 //Edit cash
	public function edit_cash($forum_id){
		
		$this->db->dbprefix('forums');
		$this->db->where('id',$forum_id);
		$get_cash_arr = $this->db->get('forums');
		//echo $this->db->last_query();exit;
		$cash_data_arr['cash_arr']= $get_cash_arr->row_array();
		$cash_data_arr['cash_count']= $get_cash_arr->num_rows();
		
		return $cash_data_arr;
		 
	}//end edit_cash
	
	
	
	//Edit cash process
	public function edit_cash_process($data){
		
		 extract($data);
		
		
		   $created_date = date('Y-m-d G:i:s');
		   $created_by_ip = $this->input->ip_address();
		   $created_by = $this->session->userdata('admin_id');
		   
		   
		   $ins_data = array(
		    'forum_id' => $this->db->escape_str(trim($forum_id)),
			'amount' => $this->db->escape_str(trim($amount)),
			'dated' => $this->db->escape_str(trim($created_date)),
			'detail' => $this->db->escape_str(trim($detail)),
		    'created_by' => $this->db->escape_str(trim($created_by)),
		    'created_date' => $this->db->escape_str(trim($created_date)),
		    'created_by_ip' => $this->db->escape_str(trim($created_by_ip))
		    );		

		   //Inserting the record into the database.
		  $this->db->dbprefix('forum_cash_log');
		  $ins_into_db = $this->db->insert('forum_cash_log', $ins_data);
		  
		  
		  //Update Forum Record
		    $upt_data = array(
		    'amount' => $this->db->escape_str(trim($amount)),
		    'last_modified_by' => $this->db->escape_str(trim($created_by)),
		    'last_modified_date' => $this->db->escape_str(trim($created_date)),
		    'last_modified_ip' => $this->db->escape_str(trim($created_by_ip))
		    );		

		   //Inserting the record into the database.
		  $this->db->dbprefix('forums');
		  $this->db->where('id',$forum_id);
		  $update_db = $this->db->update('forums', $upt_data);
		  
		  
		  return  $update_db ;
		  
	}//End edit_cash_process
	
	
	//Deleted cash
	public function delete_cash($cash_id){
		
		  $this->db->dbprefix('forum_cash_log');
		  $this->db->where('id',$cash_id);
		  $delete = $this->db->delete('forum_cash_log');
		  
		  return  $delete ;
		  
	}//End deleted cash
	
	
    //Get Total Number of projects in Database
	public function count_total_forum_report(){
		
		$this->db->dbprefix('forum_cash_log');
		return $this->db->count_all("forum_cash_log");
		
	}//end count_total_forum_report
	
	
	//Get forum record.
	public function get_forum_report($start, $limit){
	  
	  if($this->input->post('forum_id')!=""){
				
			$forum_id= $this->input->post('forum_id');
			
			$this->db->dbprefix('forum_cash_log');
			$this->db->select('forum_cash_log.*,forums.forum_name');
            $this->db->from('forum_cash_log');
            $this->db->join('forums', 'forum_cash_log.forum_id = forums.id');
		    $this->db->where('forum_cash_log.forum_id',$forum_id);
			$get_forum_report_list = $this->db->get();
		     //echo $this->db->last_query();exit;
		 
		   $row_forum_report['forum_list_result'] = $get_forum_report_list->result_array();
		   $row_forum_report['forum_list_count'] = $get_forum_report_list->num_rows;
		   
		    for($i=0; $i< $row_forum_report['forum_list_count']; $i++){
			   
			   
			  $user_id= $row_forum_report['forum_list_result'][$i]['created_by'];
			   
			  $this->db->dbprefix('admin');
			  $this->db->select('display_name');
              $this->db->from('admin');
			  $this->db->where('id',$user_id);
			  $get_user = $this->db->get();
		      $row_user['user_result'] = $get_user->row_array();
			  
			 $row_forum_report['forum_list_result'][$i]['user_name']=$row_user['user_result']['display_name']; 
			   
			   }
		
		  return $row_forum_report;
				
	   }	
		
	  if($this->input->post('from_date') !="" && $this->input->post('to_date')!="")
		{
			
		    $from_date = date('Y-m-d',strtotime($_POST['from_date']));
		    $to_date = date('Y-m-d',strtotime($_POST['to_date']));
			
		    $this->db->dbprefix('forum_cash_log');
			$this->db->select('forum_cash_log.*,forums.forum_name');
            $this->db->from('forum_cash_log');
            $this->db->join('forums', 'forum_cash_log.forum_id = forums.id');
		    $this->db->where("forum_cash_log.created_date BETWEEN '".$from_date."' AND '".$to_date."'"); 
			$this->db->order_by('forum_cash_log.dated', DESC);
			$this->db->order_by('forum_cash_log.id', DESC);
			$get_forum_report_list = $this->db->get();
		 
		   $row_forum_report['forum_list_result'] = $get_forum_report_list->result_array();
		   $row_forum_report['forum_list_count'] = $get_forum_report_list->num_rows;
		   
		    for($i=0; $i< $row_forum_report['forum_list_count']; $i++){
			   
			   
			  $user_id= $row_forum_report['forum_list_result'][$i]['created_by'];
			   
			  $this->db->dbprefix('admin');
			  $this->db->select('display_name');
              $this->db->from('admin');
			  $this->db->where('id',$user_id);
			  $get_user = $this->db->get();
		      $row_user['user_result'] = $get_user->row_array();
			  
			 $row_forum_report['forum_list_result'][$i]['user_name']=$row_user['user_result']['display_name']; 
			   
			   }
		
		   return $row_forum_report;	
			
			
		}
		else{
		
		   
		    $this->db->dbprefix('forum_cash_log');
			$this->db->select('forum_cash_log.*,forums.forum_name');
            $this->db->from('forum_cash_log');
            $this->db->join('forums', 'forum_cash_log.forum_id = forums.id');
		    $this->db->limit($limit,$start);
		    $this->db->order_by('forum_cash_log.dated',DESC);
			$this->db->order_by('forum_cash_log.id', DESC);
			$get_forum_report_list = $this->db->get();
		  // echo $this->db->last_query();exit;
		
		   $row_forum_report['forum_list_result'] = $get_forum_report_list->result_array();
		   $row_forum_report['forum_list_count'] = $get_forum_report_list->num_rows;
		   
		   for($i=0; $i< $row_forum_report['forum_list_count']; $i++){
			   
			   
			  $user_id= $row_forum_report['forum_list_result'][$i]['created_by'];
			   
			  $this->db->dbprefix('admin');
			  $this->db->select('display_name');
              $this->db->from('admin');
			  $this->db->where('id',$user_id);
			  $get_user = $this->db->get();
		      $row_user['user_result'] = $get_user->row_array();
			  
			 $row_forum_report['forum_list_result'][$i]['user_name']=$row_user['user_result']['display_name']; 
			   
			   }
		   
		
		  return $row_forum_report;
		
		}//end if
		
	}//end get_forum_report

}
?>