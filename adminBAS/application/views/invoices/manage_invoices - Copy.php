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
                      <th>#</th>
                      <th>Invoice Id</th>
                      <th>Customer Name</th>
                      <th>Dues</th>
                      <th>Created Date</th>
                      <th>Status</th>
                      <th>Options</th>
                    </tr>
                  </thead>
                  <tbody>
                  	<?php 
						if($invoice_list_count > 0){
							for($i=0;$i<$invoice_list_count;$i++){
					?>
                            <tr>
                                <td><?php echo ($i+1);?></td>
                                <td><?php echo $invoice_list[$i]['invoice_id'] ; ?></td>
                                <td><?php echo $invoice_list[$i]['first_name'].' '.$invoice_list[$i]['last_name'] ;?></td>
                                <td><?php echo $invoice_list[$i]['grand_total'] ; ?> USD</td>
                                <td><?php echo date('F j, Y', strtotime($invoice_list[$i]['invoice_date']) );?></td>
                                <td><?php if($invoice_list[$i]['status'] == 0){  echo '<span class="label btn-success">Pending</span>' ; }  '<span class="label btn-danger">InActive</span>' ?></td>
                                <td><a href="<?php echo base_url()?>invoices/manage_invoices/view_invoice/<?php echo $invoice_list[$i]['invoice_id'] ;?>"> View Invoice</a>/<a href="<?php echo base_url()?>invoices/manage_invoices/pay_now/<?php echo $invoice_list[$i]['invoice_id'] ;?>">Pay Now</a>
                                
								
								
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
              <div class="panel-title"> <span class="glyphicon glyphicon-book"></span> Edit Invoice Template</div>
            </div>
            <div class="panel-body alerts-panel">
              <form class="cmxform" id="edit_template_frm" method="POST" action="<?php echo SURL?>invoices/manage-invoices/manage-template_process/" enctype="multipart/form-data">
                <div class="tab-content border-none padding-none">
                  <div id="cms_main_contents" class="tab-pane active">
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
						
					/*	echo "<pre>";
						print_r($edit_email_template_data);
						exit;
					*/	
                    ?>
                    
                      <div class="form-group">
                        <label for="email_body">Invoice Template*</label>
                        <div class="form-group">
                        <textarea class="ckeditor editor1"  id="email_body" name="email_body" rows="14"><?php echo $get_invoice_template_arr['template_body']; ?></textarea>
                      </div>
                      </div>
                      
                      <div class="row form-group">
                    
                        <div class="col-md-5">
                          <label for="is_default">Is Default</label>
                            <select class="form-control" id="is_default" name="is_default">
                            <option value="0" <?php if($get_invoice_template_arr['is_default']== 0) {?> selected <?php } ?> >0</option>
                            <option value="1" <?php if($get_invoice_template_arr['is_default']== 1) {?> selected <?php } ?>>1</option>
                        </select>
                        </div>
                    </div>
                    
                    <div class="row form-group">
                    
                        <div class="col-md-5">
                          <label for="standard-list1">Status</label>
                            <select class="form-control" id="status" name="status">
                            <option value="1" <?php if($get_invoice_template_arr['status']==1) {?> selected <?php } ?>>Active</option>
                            <option value="0" <?php if($get_invoice_template_arr['status']==0) {?> selected <?php } ?> >InActive</option>
                        </select>
                        </div>
                    </div>
                                                        
                  </div>
                      <input type="hidden" name="id" value="<?php echo $edit_email_template_data['id']; ?>" >
                    <div class="form-group" align="right" style="margin-right:17px">
                        <input class="submit btn btn-blue" type="submit" name="edit_email_template_sbt" id="edit_email_template_sbt" value="Edit Email Template" />
                    </div>
                </div>
                
              </form>
            </div>            
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- End: Content --> 
  
</div>
<!-- End: Main --> 
<!-- Start: Footer -->
<footer> <?php echo $INC_footer;?> </footer>
<!-- End: Footer --> 
<?php echo $INC_header_script_footer;?>
    <script type="text/javascript">
      jQuery(document).ready(function() {
    
      // validate signup form on keyup and submit
        $("#edit_admin_profile_frm").validate({
            rules: {
				first_name : 'required',
				last_name : 'required',
                display_name: "required",
				username: {
					required: true,
					minlength: 5,
					 maxlength: 20
				},
				email_address: {
					required: false,
					email: true
				},
				prof_image: {
					required: false,
					extension: "jpg|jpeg|gif|tiff|png"
				}				
				
            },
            messages: {
                first_name: "This field is required.",
				last_name : "This field is required.",
                display_name: "This field is required.",
				prof_image : "Please select valid image for your profile (Use: jpg, jpeg, gif, tiff, png)",
				username: {
					required: "This field is required.",
					minlength: "Your Username must consist of at least 5 characters",
					maxlength: "Your Username cannot me more than 20 characters"
				},
				email_address: "Enter your valid email address",
            }
        });
    
    });
    </script>

</body>
</html>
