<?php
class mod_invoices extends CI_Model {
	
	function __construct(){
        parent::__construct();
    }


//Create New Invoice
public function create_invoice($data){
	
		extract($data);				

		$created_date = date('Y-m-d G:i:s');
		$created_by_ip = $this->input->ip_address();
		$created_by = $this->session->userdata('admin_id');
		$invoice_id 	= date("YmdHis").$customer_id ;
		$ins_data = array(
					   'customer_id' => $this->db->escape_str(trim($customer_id)),
					   'invoice_id' => $this->db->escape_str(trim($invoice_id)),
					   'invoice_to' => $this->db->escape_str(trim(date('Y-m-d',strtotime($invoice_to)))),
					   'invoice_from' => $this->db->escape_str(trim(date('Y-m-d',strtotime($invoice_from)))),
					   'sub_total' => $this->db->escape_str(trim($sub_total)),
					   'discount_percentage' => $this->db->escape_str(trim($discount)),
					   'tax_percentage' => $this->db->escape_str(trim($tax)),
					   'grand_total' => $this->db->escape_str(trim($grand_total)),
					   'invoice_date' =>$this->db->escape_str(date('Y-m-d')),
					   'invoice_status' =>$this->db->escape_str('0'),
					   'coupon_code' => $this->db->escape_str(trim($coupon_code)),
					   'created_by' => $this->db->escape_str(trim($created_by)),
					   'created_date' => $this->db->escape_str(trim($created_date)),
					   'created_by_ip' => $this->db->escape_str(trim($created_by_ip)),
					   'invoice_type' => $this->db->escape_str(trim($create_invoice_sbt))
		);	
		
		//print_r($ins_data);
		
					
		//Inserting the record into the database.
		$this->db->dbprefix('invoices');
		$ins_into_db = $this->db->insert('invoices', $ins_data);
		
		
		
		//Update Coupons Record
		$upd_coupon = array(
		   'is_used' => 1
		);		

		$this->db->dbprefix('coupons');
		$this->db->where('coupon_code',$coupon_code);
		$upd_into_db = $this->db->update('coupons', $upd_coupon);
		
		for($i=0;$i<count($item_name);$i++){
		$ins_data_detail = array(
					   'invoice_id' => $this->db->escape_str(trim($invoice_id)),
					   'customer_id' => $this->db->escape_str(trim($customer_id)),
					   'item_name' => $this->db->escape_str(trim($item_name[$i])),
					   'item_descrp' => $this->db->escape_str(trim($descrp[$i])),
					   'unit_price' => $this->db->escape_str(trim($unit_price[$i])),
					   'quantity' => $this->db->escape_str(trim($quantity[$i])),
					   'created_by' => $this->db->escape_str(trim($created_by)),
					   'created_date' => $this->db->escape_str(trim($created_date)),
					   'created_by_ip' => $this->db->escape_str(trim($created_by_ip))
					   
		);		
					
		//Inserting the record into the database.
		$this->db->dbprefix('invoices_detail');
		$ins_into_db = $this->db->insert('invoices_detail', $ins_data_detail);
		//echo $this->db->last_query(); exit; 
		}
			
		
		if($ins_into_db){	
		
		}else{
			return false;
		}
		  //Cheking the customer record
		  $this->db->dbprefix('customers');
		  $this->db->where('id',$customer_id);
		  $get_customer_data = $this->db->get('customers');
		  $customer_record=$get_customer_data->row_array();
		  $customer_name =$customer_record['first_name'].$customer_record['last_name'];
		  $customer_phone = $customer_record['phone'];
		  
		  $to_customer=$customer_record['email_address'];
		 
			
			$discount_amount = round(($sub_total)*($discount / 100),2) ;
			$tax_amount = round(($sub_total)*($tax / 100),2) ; 
			
			
			$get_invoice_template =  $this->mod_invoices->get_invoice_template(1); 
			$template_body = $get_invoice_template['invoice_template_data']['template_body'] ;
			
			
			$company_logo = '<img src="'.IMG.'clogo.jpg" alt="company logo">';
			$company_phone = '92 51 4455667';
			$company_address = 'AbC Plaza , Near Saqiqabad<br>Rawalpindi<br>Pakistan';
			
			for($i=0;$i<count($item_name);$i++){
						
			$data_loop .= '<tr>
							<td width="5%">'.($i+1).'</td>
							<td width="19%">'.$item_name[$i].'</td>
							<td width="38%">'.$descrp[$i].'</td>
							<td width="11%">'.$unit_price[$i].'</td>
							<td width="12%">'.$quantity[$i].'</td>
							<td width="15%">'.$unit_price[$i] * $quantity[$i].'</td>
						</tr>';
			}
			
			$search_arr = array('{COMPANY_LOGO}','{COMPANY_PHONE}','{COMPANY_ADDRESS}','{CUSTOMER_NAME}','{CUSTOMER_PHONE}','{CUSTOMER_ADDRESS}','{INVOICE_DATE}','{INVOICE_ID}','{DATE_TO}','{DATE_FROM}','{SUB_TOTAL}','{DISCOUNT}','{TAX}','{GRAND_TOTAL}');
			$replace_arr = array($company_logo,$company_phone,$company_address,$customer_name,$customer_phone,'Islamabad,Pakistan',$created_date,$invoice_id,$invoice_to,$invoice_from,$sub_total,$discount_amount,$tax_amount,$grand_total);
			
			$email_body = str_replace($search_arr,$replace_arr,$template_body);
			
			/**********************************************/
			$strStart = '<tr id="detail_rows">' ; 
			$strEnd = '</tr>' ;
			$text  = $email_body ;
			for ($i=0;$i<=strlen($text);$i++)
                        {
                                    if (substr($text,$i,strlen($strStart))==$strStart) 
                                    {
                                                $st=$i;
                                                $k=$i;
                                                while (substr($text,$k,strlen($strEnd))!=$strEnd)
                                                {
                                                            $k++;
                                                }
                                                $k=$k+strlen($strEnd);
                                                $start=$st;
                                                $tmpstr= substr($text,$start,$k-$start);
                                    }

              }
						
		/*********************************************/
		$email_body = str_replace($tmpstr,$data_loop,$email_body);
		
		$this->load->helper(array('dompdf', 'file'));
    	// page info here, db calls, etc.     
    	// $html = $this->load->view('controller/viewfile', $data, true);
	
		$invoice_pdf_path = '../assets/customer_files/'.$customer_id.'/'.$invoice_id.".pdf";
		
		$data = pdf_create($email_body, '', false); 	
		
		//pdf_create($email_body, $invoice_id.'pdf');
		write_file($invoice_pdf_path, $data);
		if($this->input->post('create_invoice_sbt')=='Send') // Sending Email.
		{
			
			
		//Send Email
		$this->load->helper(array('email', 'url'));
		
		//Preparing Sending Email
		$config['charset'] = 'utf-8';
		$config['mailtype'] = 'html';
		$config['wordwrap'] = TRUE;			
		$config['protocol'] = 'mail';
			
		$this->load->library('email',$config);


        //fetching email data from site preferences
		$this->db->dbprefix('site_preferences');
		$this->db->where('id',3);
		$get = $this->db->get('site_preferences');
		$email_data= $get->row_array();
		$from=$email_data['setting_value'];
		

	    $this->load->model('site_preferences/mod_preferences');		 
		$email_from_txt_arr = $this->mod_preferences->get_preferences_setting('email_from_txt');
		$email_from_txt = $email_from_txt_arr['setting_value'];
		$noreply_email_arr = $this->mod_preferences->get_preferences_setting('noreply_email');
		$noreply_email = $noreply_email_arr['setting_value'];
		$subject = 'Inno Tech Invoice '.date('d F,Y').'';
			 
		$this->email->from($noreply_email, $email_from_txt);
		$this->email->to($to_customer);
		$this->email->subject($subject);
		$this->email->message($email_body);
		$this->email->attach($invoice_pdf_path);
		$this->email->send();
		$this->email->print_debugger();
		$this->email->clear();
		
		
		
	}
		return true;
		
	

  }//end //Create New Invoice
  
	 //Fetching Invoice Template
	public function get_invoice_template($id){
	
		  //fetching email data from site preferences
		  $this->db->dbprefix('invoice_templates');
		  $this->db->where('id',$id);
		  $get = $this->db->get('invoice_templates');
		  //echo $this->db->last_query(); //exit;
		  $template_data['invoice_template_data'] = $get->row_array();
		  return $template_data ; 
	
	}//end Fetching Invoice Template
  

	//Edit Page
	public function edit_invoice_template($data){
		extract($data);
		
		$last_modified_date = date('Y-m-d G:i:s');
		$last_modified_ip = $this->input->ip_address();
		$last_modified_by = $this->session->userdata('admin_id');

		$upd_data = array(
		   'template_body' => trim($template_body),
		   'is_default' => $this->db->escape_str(trim($is_default)),
		   'status' => $this->db->escape_str(trim($status)),
		   'modified_by' => $this->db->escape_str(trim($last_modified_by)),
		   'last_modified_date' => $this->db->escape_str(trim($last_modified_date)),
		   'last_modified_ip' => $this->db->escape_str(trim($last_modified_ip))
		);

		//Update the record into the database.
		$this->db->dbprefix('invoice_templates');
		$this->db->where('id',$id);
		$upd_into_db = $this->db->update('invoice_templates', $upd_data);
		//echo $this->db->last_query(); exit;
		
		if($upd_into_db) return true;

	}//end edit_new_page()


public function get_invoices($invoice_id){
		
		
		$this->db->dbprefix('invoices');
		$this->db->select('invoices.*,invoices_detail.*');
		$this->db->join('invoices_detail','invoices.invoice_id = invoices_detail.invoice_id');
		$this->db->where('invoices.invoice_id', $invoice_id);
		$get_invoice_data_list = $this->db->get('invoices');
		//echo $this->db->last_query(); exit;
		$row_invoice_data['invoice_data_list_arr'] = $get_invoice_data_list->result_array();
		$row_invoice_data['invoice_data_list_count'] = $get_invoice_data_list->num_rows;
		
	
		return $row_invoice_data;		
		
	}//end get_invoices 

public function resend_invoices($invoice_id){
		
		
		$this->db->dbprefix('invoices');
		$this->db->select('invoices.*,invoices_detail.*');
		$this->db->join('invoices_detail','invoices.invoice_id = invoices_detail.invoice_id');
		$this->db->where('invoices.invoice_id', $invoice_id);
		$get_invoice_data_list = $this->db->get('invoices');
		//echo $this->db->last_query(); exit;
		$row_invoice_data['invoice_data_list_arr'] = $get_invoice_data_list->result_array();
		$row_invoice_data['invoice_data_list_count'] = $get_invoice_data_list->num_rows;
		
		//echo "<pre>";
		//print_r($row_invoice_data['invoice_data_list_arr']);
		
		//Cheking the customer record
		  $this->db->dbprefix('customers');
		  $this->db->where('id',$row_invoice_data['invoice_data_list_arr'][0]['customer_id']);
		  $get_customer_data = $this->db->get('customers');
		  $customer_record=$get_customer_data->row_array();
		  $customer_name =$customer_record['first_name'].$customer_record['last_name'];
		  $customer_phone = $customer_record['phone'];
		  
		  $to_customer=$customer_record['email_address'];
		 
		
		$discount_amount = round(($row_invoice_data['invoice_data_list_arr'][0]['sub_total'])*($row_invoice_data['invoice_data_list_arr'][0]['discount_percentage'] / 100),2) ;
		$tax_amount = round(($row_invoice_data['invoice_data_list_arr'][0]['sub_total'])*($row_invoice_data['invoice_data_list_arr'][0]['tax_percentage'] / 100),2) ; 
		
		
		$get_invoice_template =  $this->mod_invoices->get_invoice_template(1); 
		$template_body = $get_invoice_template['invoice_template_data']['template_body'] ;
		
		
		$company_logo = '<img src="'.IMG.'clogo.png" alt="company logo">';
		$company_phone = '92 51 4455667';
		$company_address = 'AbC Plaza , Near Saqiqabad<br>Rawalpindi<br>Pakistan';
		
		for($i=0;$i<count($row_invoice_data['invoice_data_list_arr']);$i++){
					
		$data_loop .= '<tr>
						<td width="5%">'.($i+1).'</td>
						<td width="19%">'.$row_invoice_data['invoice_data_list_arr'][$i]['item_name'].'</td>
						<td width="38%">'.$row_invoice_data['invoice_data_list_arr'][$i]['item_descrp'].'</td>
						<td width="11%">'.$row_invoice_data['invoice_data_list_arr'][$i]['unit_price'].'</td>
						<td width="12%">'.$row_invoice_data['invoice_data_list_arr'][$i]['quantity'].'</td>
						<td width="15%">'.$row_invoice_data['invoice_data_list_arr'][$i]['unit_price'] * $row_invoice_data['invoice_data_list_arr'][$i]['quantity'].'</td>
					</tr>';
		}
		
		
		
		
		$invoice_id = $row_invoice_data['invoice_data_list_arr'][0]['invoice_id'] ;
		$invoice_to =  $row_invoice_data['invoice_data_list_arr'][0]['invoice_to'] ;
		$invoice_from = $row_invoice_data['invoice_data_list_arr'][0]['invoice_from'] ;
		$sub_total = $row_invoice_data['invoice_data_list_arr'][0]['sub_total'] ;
		$grand_total = $row_invoice_data['invoice_data_list_arr'][0]['invoice_id'] ;
		
		$search_arr = array('{COMPANY_LOGO}','{COMPANY_PHONE}','{COMPANY_ADDRESS}','{CUSTOMER_NAME}','{CUSTOMER_PHONE}','{CUSTOMER_ADDRESS}','{INVOICE_DATE}','{INVOICE_ID}','{DATE_TO}','{DATE_FROM}','{SUB_TOTAL}','{DISCOUNT}','{TAX}','{GRAND_TOTAL}');
		$replace_arr = array($company_logo,$company_phone,$company_address,$customer_name,$customer_phone,'Islamabad,Pakistan',$created_date,$invoice_id,$invoice_to,$invoice_from,$sub_total,$discount_amount,$tax_amount,$grand_total);
		
		$email_body = str_replace($search_arr,$replace_arr,$template_body);
		/**********************************************/
		$strStart = '<tr id="detail_rows">' ; 
		$strEnd = '</tr>' ;
		$text  = $email_body ;
		for ($i=0;$i<=strlen($text);$i++)
					{
								if (substr($text,$i,strlen($strStart))==$strStart) 
								{
											$st=$i;
											$k=$i;
											while (substr($text,$k,strlen($strEnd))!=$strEnd)
											{
														$k++;
											}
											$k=$k+strlen($strEnd);
											$start=$st;
											$tmpstr= substr($text,$start,$k-$start);
								}

		  }
					
	/*********************************************/
	$email_body = str_replace($tmpstr,$data_loop,$email_body);
	$invoice_pdf_path = '../assets/customer_files/'.$row_invoice_data['invoice_data_list_arr'][0]['customer_id'].'/'.$row_invoice_data['invoice_data_list_arr'][0]['invoice_id'].".pdf";
	
	
		 //Send Email
		$this->load->helper(array('email', 'url'));
	
		//Preparing Sending Email
		$config['charset'] = 'utf-8';
		$config['mailtype'] = 'html';
		$config['wordwrap'] = TRUE;			
		$config['protocol'] = 'mail';
		
		$this->load->library('email',$config);


	 //fetching email data from site preferences
	$this->db->dbprefix('site_preferences');
	$this->db->where('id',3);
	$get = $this->db->get('site_preferences');
	$email_data= $get->row_array();
	$from=$email_data['setting_value'];
	
	  


	$this->load->model('site_preferences/mod_preferences');		 
	$email_from_txt_arr = $this->mod_preferences->get_preferences_setting('email_from_txt');
	$email_from_txt = $email_from_txt_arr['setting_value'];
	$noreply_email_arr = $this->mod_preferences->get_preferences_setting('noreply_email');
	$noreply_email = $noreply_email_arr['setting_value'];
	$subject = 'Inno Tech Invoice '.date('d F,Y').'';
		 
	$this->email->from($noreply_email, $email_from_txt);
	$this->email->to($to_customer);
	$this->email->subject($subject);
	$this->email->message($email_body);
	$this->email->attach($invoice_pdf_path);
	$this->email->send();
	//$this->email->print_debugger();
	$this->email->clear();
	
	return true	;
	}//end get_invoices 

	//Discard Invoice
	public function discard_invoice($invoice_id){
		//echo $invoice_id ; 
		//exit;
		$last_modified_date = date('Y-m-d G:i:s');
		$last_modified_ip = $this->input->ip_address();
		$last_modified_by = $this->session->userdata('admin_id');

		$upd_data = array(
		   'invoice_status' => '3',
		   'last_modified_by' => $this->db->escape_str(trim($last_modified_by)),
		   'last_modified_date' => $this->db->escape_str(trim($last_modified_date)),
		   'last_modified_ip' => $this->db->escape_str(trim($last_modified_ip))
		);

		//Update the record into the database.
		$this->db->dbprefix('invoices');
		$this->db->where('invoice_id',$invoice_id);
		$upd_into_db = $this->db->update('invoices', $upd_data);
		//echo $this->db->last_query(); exit;
		
		if($upd_into_db) return true;	

	}


//Get Total Number of invoicesn Database
	public function count_total_invoices(){
		
		$this->db->dbprefix('invoices');
		return $this->db->count_all("invoices");
		
	}//end count_total_customer_users

	//Get All Invoices List.
	public function get_invoices_limit($start, $limit){
		
		$this->db->dbprefix('invoices');
		$this->db->select('invoices.*,customers.first_name,customers.last_name');
		$this->db->join('customers','customers.id = invoices.customer_id','left');
		$get_invoices_list_limit = $this->db->get('invoices');

		//echo $this->db->last_query();exit;
		
		$row_invoice_list_limit['invoice_list_result'] = $get_invoices_list_limit->result_array();
		$row_invoice_list_limit['invoice_limit_count'] = $get_invoices_list_limit->num_rows;
		
		return $row_invoice_list_limit;		
		
	}//end get_all_invoices_limit
	
	
	public function pay_now($data){
	
		extract($data);				
		
		$created_date = date('Y-m-d G:i:s');
		$created_by_ip = $this->input->ip_address();
		$created_by = $this->session->userdata('admin_id');
		
		//Updating invoices record
		$update_data = array(
		 'customer_name' => $this->db->escape_str(trim($customer_name)),
		 'phone_number' => $this->db->escape_str(trim($phone_number)),
		 'email_address' => $this->db->escape_str(trim($email_address)),
		 'note' => $this->db->escape_str(trim($note)),
		 'invoice_status' =>2
		);
			
		$this->db->dbprefix('invoices');
		$this->db->where('invoice_id',$invoice_id);
		$this->db->update('invoices', $update_data);
		
		
		//fetch invoice recored
		$this->db->dbprefix('invoices');
		$this->db->where('invoice_id',$invoice_id);
		$get_invoice=$this->db->get('invoices');
		$row_invoice['invoice_result'] = $get_invoice->row_array();
	    $invoice_amount =$row_invoice['invoice_result']['sub_total'];
		
		$this->db->dbprefix('forums');
		$this->db->where('forum_name','Paypal');
		$get_forum=$this->db->get('forums');
		$row_forum['invoice_result'] = $get_forum->row_array();
	    $forum_id =$row_forum['invoice_result']['id'];
	   
		//insert invoice recored in income table
		$insert_data = array(
		 'forum_id' => $this->db->escape_str(trim($forum_id)),
		 'amount' => $this->db->escape_str(trim($invoice_amount)),
		 'dated' => $this->db->escape_str(trim($created_date)),
		 'detail' => $this->db->escape_str(trim("Cash Paid For Invoice #: " .$invoice_id)),
		 'created_by' => $this->db->escape_str(trim($created_by)),
		 'created_date' => $this->db->escape_str(trim($created_date)),
		 'created_by_ip' => $this->db->escape_str(trim($created_by_ip))
		
		);
			
		$this->db->dbprefix('forum_cash_log');
		$this->db->insert('forum_cash_log', $insert_data);
		
		
		return true;
		
	}//End pay_now

	
}
?>