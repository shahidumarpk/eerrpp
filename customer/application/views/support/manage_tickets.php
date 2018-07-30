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
              <div class="panel-title"> <span class="glyphicon glyphicon-list-alt"></span> Manage Tickets</div>
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
                      <th>Ticket #</th>
                      <th>Date</th>
                      <th>Created By</th>
                      <th>Subject</th>
                      <th>Status</th>
                      <th>Options</th>
                    </tr>
                  </thead>
                  <tbody>
                 
                  	<?php 
						if($ticket_list_result_count > 0){
							for($i=0;$i<$ticket_list_result_count;$i++){
								
							$ticket_number =  str_replace('#','',$ticket_list_result[$i]['ticket_number']) 	;
							
							$name = $ticket_list_result[$i]['first_name'].' '.$ticket_list_result[$i]['last_name'] ;
							
							
							if($ticket_list_result[$i]['ticket_status'] == '0'){  // Ticket Status = Open
								$ticket_status = 'Open' ;
							}elseif($ticket_list_result[$i]['ticket_status'] == '1'){  // Ticket Status = Process
								$ticket_status = 'Process' ;
							}if($ticket_list_result[$i]['ticket_status'] == '2'){	// Ticket Status = Close Request
								$ticket_status = 'Close Request' ;
							}if($ticket_list_result[$i]['ticket_status'] == '3'){	// Ticket Status = Close
								$ticket_status = 'Close ' ;
							}
					?>
                            <tr>
                                <td><?php echo ($i+1);?></td>
                                <td><?php echo $ticket_number ;?></td>
                                <td><?php echo date('F j, Y', strtotime($ticket_list_result[$i]['created_date']) );?></td>
                                <td><?php echo $name ; ?></td>
                                <td><?php echo $ticket_list_result[$i]['subject'];?></td>
                                <td><?php echo $ticket_status;?></td>
                                <td>
                                <div class="btn-group">
								<a href="<?php echo SURL?>support/manage-tickets/ticket-detail/<?php echo $ticket_number ?>">Message Board</a>
								</div>
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