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
              <div class="panel-title"> <span class="glyphicon glyphicon-list-alt"></span> Manage Coupons</div>
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
                      <th>Coupons Code</th>
                      <th>Discount Amount</th>
                      <th>Expiry Date</th>
                      <th>Is used</th>
                      <th>Status</th>
                      <th>Options</th>
                    </tr>
                  </thead>
                  <tbody>
                  	<?php 
						if($coupons_count > 0){
							for($i=0;$i<$coupons_count;$i++){
							
					?>
                            <tr>
                                <td><?php echo ($i+1);?></td>
                                <td><?php echo $coupons_arr[$i]['coupon_code'] ;?></td>
                                <td>$<?php echo $coupons_arr[$i]['discount_amount'] ;?></td>
                                 <td><?php echo  $new_date = date('d F,Y', strtotime($coupons_arr[$i]['expiry_date']));?></td>
                                <td><?php if($coupons_arr[$i]['is_used']==0) { echo "Not used";} if($coupons_arr[$i]['is_used']==1) { echo "Used";}?></td>
                                <td><?php echo ($coupons_arr[$i]['status'] == 0) ? '<span class="label btn-success">Active</span>' : '<span class="label btn-danger">InActive</span>' ?></td>
                                <td><?php 
								
                                if($ALLOW_user_delete == 1){ 
								?>
                                		<a href="<?php echo base_url()?>coupons/manage_coupons/delete_coupons/<?php echo  $coupons_arr[$i]['id'] ?>" onClick="return confirm('Are you sure you want to delete?')" type="button" class="btn btn-danger btn-gradient"> <span class="glyphicons glyphicons-remove"></span> </a>
                                <?php	
									}//end if ?>
                                    
                                    
                                    <a href="<?php echo base_url()?>coupons/manage_coupons/send_coupons/<?php echo  $coupons_arr[$i]['coupon_code'] ?>"  type="button" class="submit btn btn-green"><span>Send</span> </a>
                                    </td>
                                
                            </tr>
                    <?php		
							
						}//enf for
						}else{
					?>	
                        <tr>
	                        <th colspan="8">
                                <div class="alert alert-danger alert-dismissable">
                                No Ticket(s) Found </div>
                            </th>
                        </tr>
                    <?php		
						}//end if($ticket_list_result_count > 0)
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