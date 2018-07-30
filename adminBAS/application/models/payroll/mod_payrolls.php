<?php
class Mod_payrolls extends CI_Model {
	
	function __construct(){
		
        parent::__construct();
    }
	
	// Get PayRoll BY iD
public function get_payroll($trans_id){
		
		$this->db->dbprefix('payroll_ledger');
		$this->db->where('transaction_id',$trans_id);
		$get_payrolls = $this->db->get('payroll_ledger');
		
		//echo $this->db->last_query();
		$row_payrolls['payroll1_all_arr'] = $get_payrolls->row_array();
		
		$row_payrolls['payroll1_all_count'] = $get_payrolls->num_rows;
	
		return $row_payrolls;
		
	}//end  get_Payroll record by Sepecific Id
	
	//Get All PayRolls
	public function get_all_payrolls(){
		
	
$this->db->select('payroll_ledger.* ,admin.first_name,admin.last_name,admin.username');		
$this->db->dbprefix('payroll_ledger');
$this->db->join('admin','admin.id=payroll_ledger.user_id','LEFT');
$this->db->order_by('transaction_id DESC');
	$get_payroll = $this->db->get('payroll_ledger');
//Getting Results From table PayRoll Ledgert 
	
		

		//echo $this->db->last_query();exit;
		// Storing Fetched Arrays result into rows Payroll arrays and Count Number Of Results 
 		$row_payorll['payroll_arr_res'] = $get_payroll->result_array();
		$row_payorll['payroll_count_res'] = $get_payroll->num_rows;
		
return $row_payorll;
		//Returning result 
		
		
	}//end get_all_cashs
	
	
	

	
// Getting Users By Id To Show Them On Edit View As Selected Users
	public function get_user_names($id)
	{
		$this->db->dbprefix('admin');
			$this->db->where('id',$id);
			$this->db->where('status',1);
			$get_user = $this->db->get('admin');

$row_users['user_arr'] = $get_user->result_array();
		$row_users['user_count'] = $get_user->num_rows;
		
		return $row_users;		
		
		}
	
	    //Get Admin User Record
	public function get_admin_user_data(){
		
		
		
		$permission = (in_array(126,$this->session->userdata('permissions_arr'))) ? 1 : 0;
		
		if($permission==1){
			
			
			
			$this->db->dbprefix('admin');
			$this->db->where('status',1);
			$get_admin = $this->db->get('admin');
			
		}
		else{
			
			
		
			$user_id=$this->session->userdata('admin_id');
			
			$this->db->dbprefix('admin');
			$this->db->where('id',$user_id);
			$this->db->where('status',1);
			$get_user = $this->db->get('admin');
			//echo $this->db->last_query();
			$row_user= $get_user->row_array();
			$branch_id=$row_user['branch_id'];
			
			$this->db->dbprefix('admin');
			$this->db->where('branch_id',$branch_id);
			$this->db->or_where('branch_id',0);
			$get_admin = $this->db->get('admin');
			//echo $this->db->last_query();exit;
		}
		
		$row_admin['admin_user_arr'] = $get_admin->result_array();
		$row_admin['admin_user_count'] = $get_admin->num_rows;
		
		for($i=0;$i<$row_admin['admin_user_count']; $i++){
			
			$branch_id=$row_admin['admin_user_arr'][$i]['branch_id'];
			$this->db->dbprefix('branches');
			$this->db->select('short_name');
			$this->db->where('id',$branch_id);
			$get_branch = $this->db->get('branches');
			//echo $this->db->last_query();
			$row_branch= $get_branch->row_array();
			$row_admin['admin_user_arr'][$i]['short_name']= $row_branch['short_name'];
		}

		/*echo "<pre>";
		print_r($row_admin['admin_user_arr']);
		exit;*/
		return $row_admin;
		
	}//end get_admin_user_data
	

	

	//Delete Branch
	public function delete_payroll_data($page_id){
		
		//Delete the record from the database.
		$this->db->dbprefix('payroll_ledger');
		$this->db->where('transaction_id',$page_id);
		$del_into_db = $this->db->delete('payroll_ledger');
		//echo $this->db->last_query(); exit;
		
		if($del_into_db) return true;

	}//end delete_cash()
	
	
		//Filter Grid for Manage Cash
	public function get_filter_cash_grid_data(){
		
		/* Array of database columns which should be read and sent back to DataTables. Use a space where
		* you want to insert a non-database field (for example a counter or static image)
		*/
        $aColumns = array('`title`','phone','city_holders','created_date','balance','status','id');
        
        // DB table to use
        $sTable = 'cash';
		$this->db->order_by('id',DESC);
		
        //
    
        $iDisplayStart = $this->input->get_post('iDisplayStart', true);
        $iDisplayLength = $this->input->get_post('iDisplayLength', true);
        $iSortCol_0 = $this->input->get_post('iSortCol_0', true);
        $iSortingCols = $this->input->get_post('iSortingCols', true);
        $sSearch = $this->input->get_post('sSearch', true);
        $sEcho = $this->input->get_post('sEcho', true);
    
        // Paging
        if(isset($iDisplayStart) && $iDisplayLength != '-1')
        {
            $this->db->limit($this->db->escape_str($iDisplayLength), $this->db->escape_str($iDisplayStart));
        }
        
        // Ordering
        if(isset($iSortCol_0))
        {
            for($i=0; $i<intval($iSortingCols); $i++)
            {
                $iSortCol = $this->input->get_post('iSortCol_'.$i, true);
                $bSortable = $this->input->get_post('bSortable_'.intval($iSortCol), true);
                $sSortDir = $this->input->get_post('sSortDir_'.$i, true);
    
                if($bSortable == 'true')
                {
                    $this->db->order_by($aColumns[intval($this->db->escape_str($iSortCol))], $this->db->escape_str($sSortDir));
                }
            }
        }
        
				/*
		* Filtering
		* NOTE this does not match the built-in DataTables filtering which does it
		* word by word on any field. It's possible to do here, but concerned about efficiency
		* on very large tables, and MySQL's regex functionality is very limited
		*/
        if(isset($sSearch) && !empty($sSearch))
        {
            for($i=0; $i<count($aColumns); $i++)
            {
                $bSearchable = $this->input->get_post('bSearchable_'.$i, true);
                
                // Individual column filtering
                if(isset($bSearchable) && $bSearchable == 'true')
                {
                    $this->db->or_like($aColumns[$i], $sSearch);
                }
            }
        }


        // Select Data
        $this->db->select('SQL_CALC_FOUND_ROWS '.str_replace(' , ', ' ', implode(', ', $aColumns)), false);
		$this->db->dbprefix($sTable);
        $rResult = $this->db->get($sTable);
        //echo $this->db->last_query(); exit;
        // Data set length after filtering
		$this->db->dbprefix($sTable);
        $this->db->select('FOUND_ROWS() AS found_rows');
        $iFilteredTotal = $this->db->get()->row()->found_rows;
    
        // Total data set length
        $iTotal = $this->db->count_all($sTable);

    
        // Output
        $output = array(
            'sEcho' => intval($sEcho),
            'iTotalRecords' => $iTotal,
            'iTotalDisplayRecords' => $iFilteredTotal,
            'aaData' => array()
        );
        foreach($rResult->result_array() as $aRow){
            $row = array();
            $option_html = '';
            foreach($aColumns as $col)
            {
				
				if($col == '`title`'){
					
					 $row[] = $aRow['title'];
					
				}
				
				elseif($col == 'status'){
					
					$row[] = ($aRow[$col] == 1) ? '<span class="label btn-success">Active</span>' : '<span class="label btn-danger">InActive</span>';

				}
				elseif($col == 'created_date'){
					
					$row[] = date('d, M Y', strtotime($aRow['created_date']));
				}elseif($col == 'id'){
					$option_html .= '<div class="btn-group">';
					if(in_array(143,$this->session->userdata('permissions_arr'))){ 
						$option_html .= "<a href=".SURL."cashs/manage-cashs/edit-cash/".$aRow['id']." type='button' class='btn btn-info btn-gradient'> <span class='glyphicons glyphicons-edit'></span> </a>";
					}//end if
					
					if(in_array(144,$this->session->userdata('permissions_arr'))){ 
						$option_html .= "<a href=".SURL."cashs/manage-cashs/delete-cash/".$aRow['id']." type='button' class='btn btn-danger btn-gradient' onClick=\"return confirm('Are you sure you want to delete?')\"> <span class='glyphicons glyphicons-remove'></span> </a>";
					}//end if
					
					
					$option_html .= "<a href=".SURL."cashs/manage-cashs/view-account/".$aRow['id']." type='button' class='btn btn-info btn-gradient' id='emailTom' type='button' class='btn btn-info btn-gradient' > <span class='glyphicons  glyphicons-eye_open'></span> </a>";
					
					
					 $option_html .= '</div>';
					$row[] = $option_html;
					
					
				}
				else
				$row[] = $aRow[$col];
            }
    
            $output['aaData'][] = $row;
        }

		
        echo json_encode($output);
    }//end get_filter_cash_grid_data
	
	
	//Get Cash Ledger
	public function cash_ledger($data){
	

		if($this->input->post('from_date') !="" && $this->input->post('to_date')!="" && $this->input->post('cash_id') !="")
		{
			
			$from_date_sum = date('Y-m-d', strtotime('-1 day', strtotime($_POST['from_date'])));
			
			$this->db->dbprefix('cash_ledger');
		    $this->db->select('SUM(cash_in) as total_cashin,SUM(cash_out) as total_cashout ');
		    $this->db->where('DATE(transaction_date) <=', $from_date_sum);
		    
		    $get_data = $this->db->get('cash_ledger');
		    //echo $this->db->last_query();exit;
		    $row_arr= $get_data->row_array();
			
			
		    $from_date = date('Y-m-d',strtotime($_POST['from_date']));
		    $to_date = date('Y-m-d',strtotime($_POST['to_date']));
			
			if($this->input->post('cash_id')=='0'){
				
				
				$this->db->dbprefix('cash_ledger');
				$this->db->where("transaction_date BETWEEN '".$from_date."' AND '".$to_date."'"); 
				$this->db->order_by('created_date', ASC);
		   		$get_data_arr = $this->db->get('cash_ledger');
		        // echo $this->db->last_query();exit;				
				
				
			}else{
				
				$this->db->dbprefix('cash_ledger');
				$this->db->where('cash_id',$this->input->post('cash_id'));
				$this->db->where("transaction_date BETWEEN '".$from_date."' AND '".$to_date."'"); 
				$this->db->order_by('created_date', ASC);
				$get_data_arr = $this->db->get('cash_ledger');
		       // echo $this->db->last_query();exit;
				
			}
			
			
			
			/*echo "<pre>";
			print_r($row_arr);
			exit;*/
		$row_arr['row_data_arr']= $get_data_arr->result_array();
		$row_arr['row_data_count']= $get_data_arr->num_rows();
		   
	   }elseif($this->input->post('cash_id') !="")
		{
			
			$from_date_sum = date('Y-m-d', strtotime('-1 day', strtotime($_POST['from_date'])));
			
			$this->db->dbprefix('cash_ledger');
		    $this->db->select('SUM(cash_in) as total_cashin,SUM(cash_out) as total_cashout ');
		    $this->db->where('DATE(created_date) <=', $from_date_sum);
		    $get_data = $this->db->get('cash_ledger');
		    //echo $this->db->last_query();exit;
		    $row_arr= $get_data->row_array();
			
			$this->db->dbprefix('cash_ledger');
		    $this->db->where('cash_id',$this->input->post('cash_id')); 
		    $this->db->order_by('created_date', ASC);
		    $get_data_arr = $this->db->get('cash_ledger');
		     echo $this->db->last_query();exit;
			$row_arr['row_data_arr']= $get_data_arr->result_array();
			$row_arr['row_data_count']= $get_data_arr->num_rows();
		   
	   }
		
		
		return $row_arr;
		
	}//cash_ledger
	

	public function payrolls_in_process($data){
	
extract($data);



	//transaction_date	
		$last_modified_date = date('Y-m-d G:i:s');
		$last_modified_ip = $this->input->ip_address();
		$last_modified_by = $this->session->userdata('admin_id');

		 $transaction_date = date("Y-m-d", strtotime($transaction_date));

		$this->db->dbprefix('payroll_ledger');
	
		
		////////////////////////// PAYROLL  ////////////////////////////////
		
		$ins_array=array();
		
		$created_date = date('Y-m-d G:i:s');
		$ip_address = $this->input->ip_address();
		$created_by = $this->session->userdata('admin_id');
		//Counting No of User
		
		

// Comments Applied By HA 
	/*	$ins_data = array(
				'cash_id' => $this->db->escape_str(trim($cash_account)),
				'cash_in' => $this->db->escape_str(trim($amount)),
				'payment_proof' => $this->db->escape_str(trim($name)),
				'description' => $this->db->escape_str(trim($detail)),
				'transaction_date' => $this->db->escape_str(trim($transaction_date)),
				'status' => $this->db->escape_str(trim($status)),
				'created_by' => $this->db->escape_str(trim($created_by)),
				'created_by_ip' => $this->db->escape_str(trim($ip_address)),
				'created_date' => $this->db->escape_str(trim($created_date)),
		);
		*/
		
	
		$count = count($this->input->post('user_name'));
		// Looping Throughout the Count Checking No of Users
	
	// Array To Insert Record
		

for($i = 0; $i < $count; $i++) {

    $ins_array[$i]['user_id'] = $user_name[$i];
    $ins_array[$i]['transaction_date'] =$this->db->escape_str(trim($transaction_date));
	$ins_array[$i]['transaction_type'] = $data['type'];
	$ins_array[$i]['transaction_status'] = $data['status'];
	$ins_array[$i]['description'] = $data['description'];
	$ins_array[$i]['amount'] = $data['amount'];
	
	$ins_array[$i]['created_by']=$this->db->escape_str(trim($created_by));
	$ins_array[$i]['created_by_ip']=$this->db->escape_str(trim($ip_address));
	$ins_array[$i]['created_date']=$this->db->escape_str(trim($created_date));
	
	    // etc.
}	
/*	
echo '<pre>';
		print_r($ins_array);
		exit;*/
		
	//Insert the record into the database.
		
		$this->db->dbprefix('payroll_ledger');
		$ins_into_db = $this->db->insert_batch('payroll_ledger', $ins_array);
		
		
		
		////////////////////////// Cash in ////////////////////////////////
		
		
		
		
		/*$this->db->dbprefix('payroll_ledger');
		$this->db->select('title');
		$this->db->where('id',$cash_account);
		$get_banks_name = $this->db->get('payroll_ledger');
		$row_bank_name = $get_banks_name->row_array();
		
		$account_title = $row_bank_name['title'];*/
		
		
		if($ins_into_db) return true;

	}//end PayRolls In Process()
	
	
	public function edit_payroll_process($data){

		extract($data);

		$last_modified_date = date('Y-m-d G:i:s');
		$last_modified_ip = $this->input->ip_address();
		$last_modified_by = $this->session->userdata('admin_id');
	
	    $transaction_date = date("Y-m-d", strtotime($transaction_date));
	
		
		//	echo $this->db->last_query();exit;
		//exit;
		
		
						
		$upd_data = array(
		    'user_id' => $this->db->escape_str(trim($user_name)),
		    'transaction_date' => $this->db->escape_str(trim($transaction_date)),
		    'transaction_type' => $this->db->escape_str(trim($type)),
			'transaction_status' => $this->db->escape_str(trim($status)),
			'description' => $this->db->escape_str(trim($description)),
			'amount' => $this->db->escape_str(trim($amount)),

		    'last_modified_date' => $this->db->escape_str(trim($last_modified_date)),
		    'last_modified_by' => $this->db->escape_str(trim($last_modified_by)),
		    'last_modified_ip' => $this->db->escape_str(trim($last_modified_ip))
		);	
		
	
		//Updating the record into the database.
		$this->db->dbprefix('payroll_ledger');
		$this->db->where('transaction_id',$t_id);
		$upd_into_db = $this->db->update('payroll_ledger', $upd_data);
	
		
		if($upd_into_db) return true;
	
	}//end edit_cash()
	
	////////////////////// update cash status //////////////////////////////
	
	public function approve_ledger_payment($ledger_id) {
		
		$last_modified_date = date('Y-m-d G:i:s');
		$last_modified_ip = $this->input->ip_address();
		$last_modified_by = $this->session->userdata('admin_id');
		
		$upd_data = array(
				'payment_confirm_status' => '1',
				'last_modified_by' => $this->db->escape_str(trim($last_modified_by)),
				'last_modified_date' => $this->db->escape_str(trim($last_modified_date)),
				'last_modified_ip' => $this->db->escape_str(trim($last_modified_ip))
		);
		
		//Update the record into the database.
		$this->db->dbprefix('cash_ledger');
		$this->db->where('id',$ledger_id);
		$upd_into_db = $this->db->update('cash_ledger', $upd_data);

		if($upd_into_db) return true;
		
	}
	
	
	public function send_email_ledger($data) {
		
		extract($data);
		
		 /********************************/
		//Customer Email  Contents
		
		$email_from_txt_arr = $this->mod_preferences->get_preferences_setting('email_from_txt');
		
		$email_from_txt = $email_from_txt_arr['setting_value'];
		$noreply_email_arr = $this->mod_preferences->get_preferences_setting('noreply_email');
	    $noreply_email = $noreply_email_arr['setting_value'];
		
		//$sitename_arr = $this->mod_preferences->get_preferences_setting('site_name');
		//$site_name = $sitename_arr['setting_value'];
		//$sitelogo_arr = $this->mod_preferences->get_preferences_setting('site_logo');
		//$site_logo = $sitelogo_arr['setting_value'];
		
		//$get_email_data = $this->mod_email->get_email(10);
		//$email_subject = $get_email_data['email_arr']['email_subject'];
		//$email_body = $get_email_data['email_arr']['email_body'];
		//$search_arr = array('[SITE_URL]','[SITE_NAME]','[SITE_LOGO]','[CUSTOMER_FIRST_LAST_NAME]','[PROJECT_TITLE]','[PROJECT_DESCIPTION]');
		//$replace_arr = array(MURL,$site_name,$site_logo,$customer_first_last_name,$project_subject,$project_detail);
		//$email_body = str_replace($search_arr,$replace_arr,$email_body);
	
	    $email_subject="Cash Ledger Report";
	
		//Preparing Sending Email
		$config['charset'] = 'utf-8';
		$config['mailtype'] = 'html';
		$config['wordwrap'] = TRUE;			
		$config['protocol'] = 'mail';
			
		$this->load->library('email',$config);

		$this->email->from($noreply_email, $email_from_txt);
		$this->email->to($email_address);
		$this->email->subject($email_subject);
		$this->email->message($email_data);
		$this->email->send();
		//echo $this->email->print_debugger();
		$this->email->clear();
	    //echo $this->db->last_query(); exit;	
	
		
	     return true;
		
	}
	
	
	

}
?>