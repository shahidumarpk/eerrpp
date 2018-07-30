<?php
class mod_invoices extends CI_Model {
	
	function __construct(){
        parent::__construct();
    }



  
  
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
  
  
 public function get_invoices($invoice_id){
		
		
		$this->db->dbprefix('invoices');
		$this->db->select('invoices.*,invoices_detail.*');
		$this->db->join('invoices_detail','invoices.invoice_id = invoices_detail.invoice_id');
		$this->db->where('invoices.invoice_id', $invoice_id);
		$get_invoice_data_list = $this->db->get('invoices');
		//echo $this->db->last_query(); exit;
		$row_invoice_data['invoice_data_list_arr'] = $get_invoice_data_list->result_array();
		$row_invoice_data['invoice_data_list_count'] = $get_invoice_data_list->num_rows;
		
		/*echo "<pre>";
		print_r($row_invoice_data);
		exit;*/
		return $row_invoice_data;		
		
	}//end get_invoices 
 


//Get Total Number of invoicesn Database
	public function count_total_invoices(){
		
		$this->db->dbprefix('invoices');
		return $this->db->count_all("invoices");
		
	}//end count_total_customer_users

	//Get All Invoices List.
	public function get_invoices_limit($start, $limit){
		
		$customer_id=$this->session->userdata('customer_id');
		
		$this->db->dbprefix('invoices');
		$this->db->select('invoices.*,customers.first_name,customers.last_name');
		$this->db->join('customers','customers.id = invoices.customer_id','left');
		$this->db->where('invoices.customer_id',$customer_id);
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
		
		$ins_data = array(
		               'invoice_id' => $this->db->escape_str(trim($invoice_id)),
					   'customer_name' => $this->db->escape_str(trim($customer_name)),
					   'phone_number' => $this->db->escape_str(trim($phone_number)),
					   'email_address' => $this->db->escape_str(trim($email_address)),
					   'note' => $this->db->escape_str(trim($note)),
					   'created_by' => $this->db->escape_str(trim($created_by)),
					   'created_date' => $this->db->escape_str(trim($created_date)),
					   'created_by_ip' => $this->db->escape_str(trim($created_by_ip)),
					   'invoice_type' => $this->db->escape_str(trim($create_invoice_sbt))
		);	
		
		//print_r($ins_data);
					
		//Inserting the record into the database.
		$this->db->dbprefix('invoices');
		$ins_into_db = $this->db->insert('invoices', $ins_data);
		return true;
		
	}//End pay_now

	
}
?>