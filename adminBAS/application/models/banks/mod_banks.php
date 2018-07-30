<?php
class mod_banks extends CI_Model {
	
	function __construct(){
		
        parent::__construct();
    }

	//Get All Branches
	public function get_all_banks(){
		
		$this->db->dbprefix('banks');
		//$this->db->select('SUM(balance) as total_balance');
		$this->db->where('status',1);
		$this->db->order_by('id DESC');
		$get_banks = $this->db->get('banks');

		//echo $this->db->last_query();
		$row_banks['banks_arr'] = $get_banks->result_array();
		$row_banks['banks_count'] = $get_banks->num_rows;
		
		return $row_banks;
		
	}//end get_all_banks
	
	
	public function get_all_bank_account(){
	
		$this->db->dbprefix('banks');
		$get_banks = $this->db->get('banks');
	
		//echo $this->db->last_query();
		$row_banks['banks_arr'] = $get_banks->result_array();
		$row_banks['banks_count'] = $get_banks->num_rows;
		

		
	
		return $row_banks;
	
	}//end get_all_banks
	
	

	
	public function get_cities(){
	
		$this->db->dbprefix('cities');
		$this->db->order_by('id DESC');
		$this->db->where('country','PK');
		$get_cities_list = $this->db->get('cities');
	
		$row_cities_list['cities_result'] = $get_cities_list->result_array();
		$row_cities_list['cities_count'] = $get_cities_list->num_rows;
	
		return $row_cities_list;
	
	}//end get_cities
	
	
	//Get Branch Record
	public function get_bank($bank_id){
		
		
		
		$this->db->dbprefix('banks');
		$this->db->where('id',$bank_id);
		$get_bank = $this->db->get('banks');

		//echo $this->db->last_query(); exit;
		$row_bank['banks_arr'] = $get_bank->row_array();
		$row_bank['banks_count'] = $get_bank->num_rows;
		
		
		return $row_bank;
		
	}//end get_bank
	
	
	//Add New Branch
	public function add_bank($data){
		
		extract($data);
		
		$created_date = date('Y-m-d G:i:s');
		$ip_address = $this->input->ip_address();
		$created_by = $this->session->userdata('admin_id');
		$ins_data = array(
		    'branch_id' => $this->db->escape_str(trim($branch_id)),
		  	'acc_title' => $this->db->escape_str(trim($acc_title)),
			'acc_number' => $this->db->escape_str(trim($acc_number)),				
			'bank_name' => $this->db->escape_str(trim($bank_name)),
			'bank_branch' => $this->db->escape_str(trim($bank_branch)),
			'phone_1' => $this->db->escape_str(trim($phone_1)),
			'phone_2' => $this->db->escape_str(trim($phone_2)),
			'manager_phone' => $this->db->escape_str(trim($manager_phone)),
		    'address' => $this->db->escape_str(trim($address)),
			'city' => $this->db->escape_str(trim($city)),
		   'status' => $this->db->escape_str(trim($status)),
		   'created_by' => $this->db->escape_str(trim($created_by)),
		   'created_by_ip' => $this->db->escape_str(trim($ip_address)),
		   'created_date' => $this->db->escape_str(trim($created_date)),
		);

		//Insert the record into the database.
		$this->db->dbprefix('banks');
		$ins_into_db = $this->db->insert('banks', $ins_data);
		//echo $this->db->last_query();exit;
		
		if($ins_into_db) return true;

	}//end add_bank()
	
	
	//Edit Branch
	public function edit_bank($data){
		
		extract($data);
		
		$last_modified_date = date('Y-m-d G:i:s');
		$last_modified_ip = $this->input->ip_address();
		$last_modified_by = $this->session->userdata('admin_id');

		
		
		
		$upd_data = array(
		   'branch_id' => $this->db->escape_str(trim($branch_id)),
		   'acc_title' => $this->db->escape_str(trim($acc_title)),
			'acc_number' => $this->db->escape_str(trim($acc_number)),				
			'bank_name' => $this->db->escape_str(trim($bank_name)),
			'bank_branch' => $this->db->escape_str(trim($bank_branch)),
			'phone_1' => $this->db->escape_str(trim($phone_1)),
			'phone_2' => $this->db->escape_str(trim($phone_2)),
			'manager_phone' => $this->db->escape_str(trim($manager_phone)),
		    'address' => $this->db->escape_str(trim($address)),
			'city' => $this->db->escape_str(trim($city)),
		   'status' => $this->db->escape_str(trim($status)),
		   'last_modified_by' => $this->db->escape_str(trim($last_modified_by)),
		   'last_modified_date' => $this->db->escape_str(trim($last_modified_date)),
		   'last_modified_ip' => $this->db->escape_str(trim($last_modified_ip))
		);

		//Update the record into the database.
		$this->db->dbprefix('banks');
		$this->db->where('id',$bank_id);
		$upd_into_db = $this->db->update('banks', $upd_data);
		//echo $this->db->last_query();exit;
		
		if($upd_into_db) return true;

	}//end edit_bank()
	

	//Delete Branch
	public function delete_bank($bank_id){
		
		//Delete the record from the database.
		$this->db->dbprefix('banks');
		$this->db->where('id',$bank_id);
		$del_into_db = $this->db->delete('banks');
		//echo $this->db->last_query(); exit;
		
		if($del_into_db) return true;

	}//end delete_bank()
	
	
    //Filter Grid for Manage Banks
	public function get_filter_banks_grid_data(){
		
		/* Array of database columns which should be read and sent back to DataTables. Use a space where
		* you want to insert a non-database field (for example a counter or static image)
		*/
        $aColumns = array('`bank_name`','bank_branch','city','acc_title','acc_number','balance','status','id');
        
        // DB table to use
        $sTable = 'banks';
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
				
				if($col == '`bank_name`'){
					
					 $row[] = $aRow['bank_name'];
					
				}
				
				elseif($col == 'status'){
					
					$row[] = ($aRow[$col] == 1) ? '<span class="label btn-success">Active</span>' : '<span class="label btn-danger">InActive</span>';

				}elseif($col == 'id'){
					$option_html .= '<div class="btn-group">';
					if(in_array(145,$this->session->userdata('permissions_arr'))){ 
						$option_html .= "<a href=".SURL."banks/manage-banks/edit-bank/".$aRow['id']." type='button' class='btn btn-info btn-gradient'> <span class='glyphicons glyphicons-edit'></span> </a>";
					}//end if
					
					if(in_array(146,$this->session->userdata('permissions_arr'))){ 
						$option_html .= "<a href=".SURL."banks/manage-banks/delete-bank/".$aRow['id']." type='button' class='btn btn-danger btn-gradient' onClick=\"return confirm('Are you sure you want to delete?')\"> <span class='glyphicons glyphicons-remove'></span> </a>";
					}//end if
					
					
					$option_html .= "<a href=".SURL."banks/manage-banks/view-account/".$aRow['id']." type='button' class='btn btn-info btn-gradient' id='emailTom'  type='button' class='btn btn-info btn-gradient' > <span class='glyphicons  glyphicons-eye_open'></span> </a>";
					
					 $option_html .= '</div>';
					$row[] = $option_html;
					
					
				}
				else
				$row[] = $aRow[$col];
            }
    
            $output['aaData'][] = $row;
        }

		
        echo json_encode($output);
    }//end get_filter_banks_grid_data
	
	
	
	//Get Bank Ledger
	public function bank_ledger($data){
	
		
		if($this->input->post('from_date') !="" && $this->input->post('to_date')!="" && $this->input->post('bank_id') !="")
		{
			
			$from_date_sum = date('Y-m-d', strtotime('-1 day', strtotime($_POST['from_date'])));
			
			$this->db->dbprefix('bank_ledger');
		    $this->db->select('SUM(cash_in) as total_cashin,SUM(cash_out) as total_cashout ');
		    $this->db->where('DATE(transaction_date) <=', $from_date_sum);
		    $get_data = $this->db->get('bank_ledger');
		    //echo $this->db->last_query();exit;
		    $row_arr= $get_data->row_array();
			
			
		    $from_date = date('Y-m-d',strtotime($_POST['from_date']));
		    $to_date = date('Y-m-d',strtotime($_POST['to_date']));
			
			if($this->input->post('bank_id')=='0'){
				
				$this->db->dbprefix('bank_ledger');
				$this->db->where("transaction_date BETWEEN '".$from_date."' AND '".$to_date."'"); 
				$this->db->order_by('transaction_date', ASC);
				$get_data_arr = $this->db->get('bank_ledger');
					
				
			}else{
				
					
				$this->db->dbprefix('bank_ledger');
				$this->db->where('bank_id',$this->input->post('bank_id'));
				$this->db->where("transaction_date BETWEEN '".$from_date."' AND '".$to_date."'"); 
				$this->db->order_by('created_date', ASC);
				$get_data_arr = $this->db->get('bank_ledger');
				
				
			}
			
			
			
			$row_arr['row_data_arr']= $get_data_arr->result_array();
		    $row_arr['row_data_count']= $get_data_arr->num_rows();
		    // echo $this->db->last_query();exit;
			
			/*echo "<pre>";
			print_r($row_arr);
			exit;*/
		   
	   }elseif($this->input->post('bank_id') !="")
		{
			
			$from_date_sum = date('Y-m-d', strtotime('-1 day', strtotime($_POST['from_date'])));
			
			$this->db->dbprefix('bank_ledger');
		    $this->db->select('SUM(cash_in) as total_cashin,SUM(cash_out) as total_cashout ');
		    $this->db->where('DATE(transaction_date) <=', $from_date_sum);
		    $get_data = $this->db->get('bank_ledger');
		    //echo $this->db->last_query();exit;
		    $row_arr= $get_data->row_array();
			
			$this->db->dbprefix('bank_ledger');
		    $this->db->where('bank_id',$this->input->post('bank_id')); 
		    $this->db->order_by('transaction_date', ASC);
		    $get_data_arr = $this->db->get('bank_ledger');
		    // echo $this->db->last_query();exit;
			$row_arr['row_data_arr']= $get_data_arr->result_array();
			$row_arr['row_data_count']= $get_data_arr->num_rows();
			
		   
	   }
		
		/*echo "<pre>";
		print_r($row_arr);
		exit;*/
				
		return $row_arr;
		
	}//bank_ledger
	
	
	public function cash_in_process($data){
	
		extract($data);
	
		$last_modified_date = date('Y-m-d G:i:s');
		$last_modified_ip = $this->input->ip_address();
		$last_modified_by = $this->session->userdata('admin_id');
	
	    $transaction_date = date("Y-m-d", strtotime($transaction_date));
	
		$this->db->dbprefix('banks');
	
		$this->db->set('balance', 'balance+'.$amount, FALSE);
		$this->db->where('id',$cash_account);
		$upd_into_db = $this->db->update('banks');
		//	echo $this->db->last_query();exit;
		//exit;
		
		
		$this->db->dbprefix('banks');
		$this->db->select('acc_title,acc_number,bank_name');
		$this->db->where('id',$cash_account);
		$get_banks_name = $this->db->get('banks');
		$row_bank_name = $get_banks_name->row_array();
		
		
		/////////////////// bank_proof_doc Start Update Ledge /////////////////////////
		
		if($_FILES['bank_proof_doc']['name'] !=""){
			
			
		$file_name_org = $_FILES['bank_proof_doc']['name'];
		
		$name = time()."_".$file_name_org;
		$file_store_path = './assets/payment_proof';
		$this->load->helper(array('form', 'url'));
		$config['upload_path'] = $file_store_path;
		$config['allowed_types'] = 'jpg|jpeg|gif|tiff|png|doc|docx';
		$config['max_size']	= '6000';
		$config['overwrite'] = false;
		$config['file_name'] = $name;
		//$this->load->library('upload', $config);
		
		$this->load->library('upload', $config);
			
		
		 if(!$this->upload->do_upload('bank_proof_doc')){
		
			$error_file_arr = array('error' => $this->upload->display_errors());
		
			return $error_file_arr;
		
		} 
		
		}
		
		
		
		$created_date = date('Y-m-d G:i:s');
		$ip_address = $this->input->ip_address();
		$created_by = $this->session->userdata('admin_id');
		$ins_data = array(
				'bank_id' => $this->db->escape_str(trim($cash_account)),
				'cash_in' => $this->db->escape_str(trim($amount)),
				'payment_proof' => $this->db->escape_str(trim($name)),
				'description' => $this->db->escape_str(trim($detail)),
				'transaction_date' => $this->db->escape_str(trim($transaction_date)),
				'status' => $this->db->escape_str(trim($status)),
				'payment_confirm_status' => $this->db->escape_str(trim(1)),
				'created_by' => $this->db->escape_str(trim($created_by)),
				'created_by_ip' => $this->db->escape_str(trim($ip_address)),
				'created_date' => $this->db->escape_str(trim($created_date)),
		);
		
		//Insert the record into the database.
		$this->db->dbprefix('bank_ledger');
		$ins_into_db = $this->db->insert('bank_ledger', $ins_data);
		
		/////////////////// End Update Ledge /////////////////////////
		
		

		$account_title = $row_bank_name['acc_title'];
		$bank_name = $row_bank_name['bank_name'];
		$account_number = $row_bank_name['acc_number'];	
	
		//exit;
		if($upd_into_db) return true;
	
	}//end edit_cash()
	
	
	public function cash_out_process($data){
	
		extract($data);
	
		$last_modified_date = date('Y-m-d G:i:s');
		$last_modified_ip = $this->input->ip_address();
		$last_modified_by = $this->session->userdata('admin_id');
	
	
	
		$this->db->dbprefix('banks');
	
		$this->db->set('balance', 'balance-'.$amount, FALSE);
		$this->db->where('id',$cash_account);
		$upd_into_db = $this->db->update('banks');
		//	echo $this->db->last_query();exit;
		//exit;
		
		
		
		$transaction_date = date("Y-m-d", strtotime($transaction_date));
		
		$created_date = date('Y-m-d G:i:s');
		$ip_address = $this->input->ip_address();
		$created_by = $this->session->userdata('admin_id');
		$ins_data = array(
				'bank_id' => $this->db->escape_str(trim($cash_account)),
				'cash_out' => $this->db->escape_str(trim($amount)),
				'payment_proof' => $this->db->escape_str(trim($name)),
				'description' => $this->db->escape_str(trim($detail)),
				'transaction_date' => $this->db->escape_str(trim($transaction_date)),
				'status' => $this->db->escape_str(trim($status)),
				'payment_confirm_status' => $this->db->escape_str(trim(1)),
				'created_by' => $this->db->escape_str(trim($created_by)),
				'created_by_ip' => $this->db->escape_str(trim($ip_address)),
				'created_date' => $this->db->escape_str(trim($created_date)),
		);
		
		//Insert the record into the database.
		$this->db->dbprefix('bank_ledger');
		$ins_into_db = $this->db->insert('bank_ledger', $ins_data);
		
		
		
		
		$this->db->dbprefix('banks');
		$this->db->select('acc_title,acc_number,bank_name');
		$this->db->where('id',$cash_account);
		$get_banks_name = $this->db->get('banks');
		$row_bank_name = $get_banks_name->row_array();
		
		$account_title = $row_bank_name['acc_title'];
		$bank_name = $row_bank_name['bank_name'];
		$account_number = $row_bank_name['acc_number'];
		
	
		
		if($upd_into_db) return true;
	
	}//end edit_cash()
	
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
		$this->db->dbprefix('bank_ledger');
		$this->db->where('id',$ledger_id);
		$upd_into_db = $this->db->update('bank_ledger', $upd_data);
	
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
	
	    $email_subject="Bank Ledger Report";
	
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