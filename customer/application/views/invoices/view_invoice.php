<?php 
$session_post_data = $this->session->userdata('add-user-data');
?>
<!DOCTYPE html>
<html>
<head>
<!-- Meta, title, CSS, favicons, etc. -->
<meta charset="utf-8">
<title><?php echo $meta_title ?></title>
<meta name="keywords" content="<?php echo $meta_keywords ?>" />
<meta name="description" content="<?php echo $meta_description ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php echo $INC_header_script_top; ?>
</head>
<body>
<!-- Start: Header -->
<header class="navbar navbar-fixed-top"><?php echo $INC_top_header; ?></header>
<!-- End: Header --> 
<!-- Start: Main -->
<div id="main"> 
  <!-- Start: Sidebar --> 
  <?php echo $INC_left_nav_panel;  ?> 
  <!-- End: Sidebar --> 
  <!-- Start: Content -->
  <section id="content"> <?php echo $INC_breadcrum?>
    <div class="container">
     <form class="cmxform" id="frm_create_invoice" method="POST" action="<?php echo SURL?>invoices/manage-invoices/create_invoice_process" enctype="multipart/form-data">
        <div class="row">
            <div class="col-md-12">
                  <div class="panel">
                    <div class="panel-heading">
                      <div class="panel-title"> <span class="glyphicon glyphicons-adress_book"></span> Invoice</div>
                      <div class="pull-right">Date: <?php echo date('d F,Y');?> </div>
                    </div>
                    <div class="panel-body">
                     <?php
                        if($this->session->flashdata('err_message')){
                    ?>
                            <div class="alert alert-danger"><?php echo $this->session->flashdata('err_message'); ?></div>
                    <?php
                        }//end if($this->session->flashdata('err_message'))
                        
                        if($this->session->flashdata('ok_message')){
                    ?>
                            <div class="alert alert-success alert-dismissable"><?php echo $this->session->flashdata('ok_message'); ?></div>
                    <?php 
                        }//if($this->session->flashdata('ok_message'))
						
					
		$get_invoice_template =  $this->mod_invoices->get_invoice_template(1); 
		$template_body = $get_invoice_template['invoice_template_data']['template_body'] ;
		
		
		$company_logo = '<img src="'.IMG.'clogo.png" alt="company logo">';
		$company_phone = '92 51 4455667';
		$company_address = 'AbC Plaza , Near Saqiqabad<br>Rawalpindi<br>Pakistan';
		
		for($i=0;$i<count($invoices_list_data_arr);$i++){
					
		$data_loop .= '<tr>
						<td width="5%">'.($i+1).'</td>
						<td width="19%">'.$invoices_list_data_arr[$i]['item_name'].'</td>
						<td width="38%">'.$invoices_list_data_arr[$i]['item_descrp'].'</td>
						<td width="11%">'.$invoices_list_data_arr[$i]['unit_price'].'</td>
						<td width="12%">'.$invoices_list_data_arr[$i]['quantity'].'</td>
						<td width="15%">'.$invoices_list_data_arr[$i]['unit_price'] * $invoices_list_data_arr[$i]['quantity'].'</td>
					</tr>';
		}
		
		
		
		
		$invoice_id = $invoices_list_data_arr[0]['invoice_id'] ;
		$invoice_to =  $invoices_list_data_arr[0]['invoice_to'] ;
		$invoice_from = $invoices_list_data_arr[0]['invoice_from'] ;
		$sub_total = $invoices_list_data_arr[0]['sub_total'] ;
		$grand_total = $invoices_list_data_arr[0]['grand_total'] ;
		
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
	$invoice_detail = str_replace($tmpstr,$data_loop,$email_body);
echo $invoice_detail ;



					?>
                    
                    
                     
                     <div class="clearfix">&nbsp;</div>
                     <div class="pull-right" style="margin-top:20px;">
                     	<div class="row">
                        	<div class="col-md-6">
                             &nbsp;
                            </div>
                            <div class="col-md-6">
                             &nbsp;
                            </div>
                        </div>
                     </div>
                     
                  </div>
                </div>
              </div>
        </div>
      </form>  
    </div>
  </section>
  <!-- End: Content --> 
</div>
<!-- End: Main --> 
<!-- Start: Footer -->
<footer> <?php echo $INC_footer;?> </footer>
<!-- End: Footer --> 
<?php echo $INC_header_script_footer;?>
</body>
</html>
