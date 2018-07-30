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
<header class="navbar navbar-fixed-top"> <?php echo $INC_top_header; ?> </header>
<!-- End: Header --> 
<!-- Start: Main -->
<div id="main"> 
  <!-- Start: Sidebar --> 
  <?php echo $INC_left_nav_panel; ?> 
  <!-- End: Sidebar --> 
  <!-- Start: Content -->
  <section id="content"> <?php echo $INC_breadcrum?>
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="panel">
            <div class="panel-heading">
              <div class="panel-title"> <span class="glyphicon glyphicon-list-alt"></span> Manage Invoices</div>
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
				?>            

              <div class="table-responsive">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th  class="hidden-xs">#</th>
                      <th  class="hidden-xs">Invoice Id</th>
                      <th  class="hidden-xs">Customer Name</th>
                      <th  class="hidden-xs">Dues</th>
                      <th  class="hidden-xs">Created Date</th>
                      <th  class="hidden-xs">Status</th>
                      <th  class="hidden-xs">Options</th>
                    </tr>
                  </thead>
                  <tbody>
                  	<?php 
						if($invoice_list_count > 0){
							for($i=0;$i<$invoice_list_count;$i++){
					?>
                            <tr>
                                <td  class="hidden-xs"><?php echo ($i+1);?></td>
                                <td  class="hidden-xs"><?php echo $invoice_list[$i]['invoice_id'] ; ?></td>
                                <td  class="hidden-xs"><?php echo $invoice_list[$i]['first_name'].' '.$invoice_list[$i]['last_name'] ;?></td>
                                <td  class="hidden-xs"><?php echo $invoice_list[$i]['grand_total'] ; ?> USD</td>
                                <td  class="hidden-xs"><?php echo date('F j, Y', strtotime($invoice_list[$i]['invoice_date']) );?></td>
                                <td  class="hidden-xs"><?php if($invoice_list[$i]['status'] == 0){  echo '<span class="label btn-success">Pending</span>' ; }  '<span class="label btn-danger">InActive</span>' ?></td>
                                <td  class="hidden-xs"><a href="<?php echo CUSTOMER_FOLDER.'/'.$invoice_list[$i]['customer_id'].'/'.$invoice_list[$i]['invoice_id'].".pdf" ;?>" type="button" class="btn btn-info btn-gradient" title="View Invoice"> <span class="glyphicons glyphicons-eye_open" ></span></a>
                            
                                <a href="<?php echo base_url()?>invoices/manage_invoices/pay_now/<?php echo $invoice_list[$i]['invoice_id'] ;?>" type="button" class="btn btn-info btn-gradient" title="Make Payment"> <span class="glyphicons glyphicons-usd"></span></a>
                                
                                
                                
								
								
                                </td>
                            </tr>
                    <?php		
							
						}//enf for
						}else{
					?>	
                        <tr>
	                        <th colspan="8">
                                <div class="alert alert-danger alert-dismissable">
                                No Invoice(s) Found </div>
                            </th>
                        </tr>
                    <?php		
						}//end if($_list_count > 0)
					?>
                    
                  </tbody>
                </table>
                <div align="right">
                	<?php //echo "Showing $start - $end of $total total results"; ?>
                	<?php echo $page_links?>
                </div>

              </div>
            </div>
          </div>
        </div>
        <div class="clearfix"></div>
      </div>
      <div class="clearfix"></div>
      <div class="row" style="min-height:250px;">&nbsp;</div>
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