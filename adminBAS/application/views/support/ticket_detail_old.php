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
	<div class="row" style="min-height:540px;">
        <div class="col-md-12 chat-widget">
              <div class="panel chat-panel">
                <div class="panel-heading">
                  <div class="panel-title"> 
                   <span class="glyphicon glyphicon-envelope"></span> <?php echo $ticket_data_arr['subject'] ; ?></div>
                  <div class="panel-tray pull-right">
                  </div>
                  <div class="mini-action-icons margin-right-sm pull-right"> 
                  	<strong>Ticket Status:</strong> <?php 
					 if($ticket_data_arr['ticket_status'] == '0'){  // Ticket Status = Open
								$ticket_status = 'Open' ;
							}elseif($ticket_data_arr['ticket_status'] == '1'){  // Ticket Status = Process
								$ticket_status = 'Process' ;
							}if($ticket_data_arr['ticket_status'] == '2'){	// Ticket Status = Close Request
								$ticket_status = 'Close Request' ;
							}if($ticket_data_arr['ticket_status'] == '3'){	// Ticket Status = Close
								$ticket_status = 'Close ' ;
							}
					echo $ticket_status ; 
					?>
                  </div>
               </div>
                <div class="panel-body">
                <form class="form-horizontal margin-top" id="ticket_reply_process_frm" method="POST" action="<?php echo SURL?>support/manage_tickets/ticket-reply-process" enctype="multipart/form-data">
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
                  <div class="media">
                    <div class="media-body">
                      <div class="media-content">
                     	<?php echo  strip_tags($ticket_data_arr['details'],'<p><br><a>') ; ?>
                        <div class="clearfix">&nbsp;</div>
                        <i class="fa fa-tags fa-lg"></i> 
                        
                        <?php
						for($attach= 0; $attach<$ticket_attachment_count;$attach++){
							if($attach != 0){
								$string .= '&nbsp;,&nbsp;'	;
							}
								$string .= '<a href="'.ATTACHMENT.$ticket_attachment_data[$attach]['attachment'].'" target="_blank">'.$ticket_attachment_data[$attach]['attachment'].'</a>' ;
							
						 } 
						echo $string ; 
						?>
                     </div>
                    </div>
                  </div>
                  <div class="media">
                    <div class="media-body">
                    <div class="media-content">
                  		<div class="form-horizontal">
                      	<div class="row">
                          <div class="col-md-2"><strong>Customer Name :</strong></div>
                          <div class="col-md-10">
                          <?php if($ticket_data_arr['customer_id']=='0'){ echo "Customer"; } else{ echo $ticket_data_arr['first_name'].' '.$ticket_data_arr['last_name']; } ?>
                          </div>
                        </div>
                      	<div class="row">
                          <div class="col-md-2"><strong>Created By :</strong></div>
                          <div class="col-lg-10">   <?php if($ticket_data_arr['created_by']=='0'){ echo "System"; }else{ echo $ticket_data_arr['first_name'].' '.$ticket_data_arr['last_name'];  }  ?>  </div>
                        </div>
                        <div class="row">
                          <label class="col-lg-2"><strong>Source :</strong></label>
                          <div class="col-lg-10">
                          <?php echo $ticket_data_arr['source'] ; ?>
                          </div>
                        </div>
                        <div class="row">
                          <label class="col-lg-2"><strong>Created Date :</strong></label>
                          <div class="col-lg-10">
                         <?php echo date('d M, Y',strtotime($ticket_data_arr['created_date'])); ?>
                          </div>
                        </div>
                    </div>
                    </div>
                    </div>
                  </div>
                  <div class="clearfix">&nbsp;</div>
                  <div class="media-contnet">
                 
                    <div class="form-group">
                      <label for="inputResponse" class="col-sm-2 hidden-xs control-label">Ticket Reply</label>
                      <div class="col-xs-8">
                        <textarea class="form-control" id="textArea" rows="3" name="ticket_reply" required></textarea>
                        <input type="hidden" name="ticket_id" id="ticket_id" value="<?php echo $ticket_data_arr['ticket_number'] ;  ?>" >
                      </div>
                    </div>
                  </div>
                  <div class="media">
                    <div class="media-body">
                    <div class="media-content">
                  		<div class="row form-group">
                        <div class="col-md-2">
                            &nbsp;
                          </div>
                          <div class="col-md-2">
                            <input class="submit btn btn-blue" name="reply_ticket_sbt" id="reply_ticket_sbt" type="submit" value="Submit" style="width:100%;">
                          </div>
                         <!-- <div class="col-md-2">
                            <input class="submit btn btn-dark" type="submit" value="Change Department" style="width:100%;">
                          </div>
                          <div class="col-md-2">
                           <input class="submit btn btn-green" type="submit" value="Change Shift" style="width:100%;">
                          </div>-->
                          <div class="col-md-2">
                            <input class="submit btn btn-red" type="submit" value="Close Ticket" style="width:100%;" onClick="javascript: if(confirm('Are you sure you want to close this ticket?')) { window.location='<?php echo SURL?>support/manage_tickets/ticket_close_process/<?php echo $ticket_data_arr['ticket_number'] ;  ?>'; return true ; }else{  return false ; }">
                          </div>
                        </div>
                    </div>
                    </div>
                  </div>
                  
                    <?php 
				for($i=0;$i<$ticket_replies_count;$i++){
					
					$counter = $i+1 ;
					
					if($ticket_all_replies_data[$i]['user_type'] == 'C') { // If Customer Reply
						if($ticket_all_replies_data[$i]['customer_id'] == '0'){
							$customer_data = $this->mod_customer->get_guest_customer_profile($ticket_data_arr['ticket_number']);
							$name =  $customer_data['guest_customer_profile_arr']['customer_name'] ;	
						}else{
							$customer_data = $this->mod_customer->get_customer_profile($ticket_all_replies_data[$i]['customer_id']);
							$name = $customer_data['customer_profile_arr']['first_name']." ".$customer_data['customer_profile_arr']['last_name'] ; 
						}
							$class_name = 'media-content-green' ;
						
					}if($ticket_all_replies_data[$i]['user_type'] == 'A'){ // If Agent Reply
						$user_data = $this->mod_admin->get_admin_user_data($ticket_all_replies_data[$i]['createdby'] ) ; 
				 		//echo "<pre>"; print_r($user_data); exit;
						$name = $user_data['admin_user_arr']['first_name']." ".$user_data['admin_user_arr']['last_name'] ; 
						$class_name = 'media-content' ;
					}
				 ?>
                  <div class="media">
                    <div class="media-body">
                      <div class="<?php echo $class_name ; ?>"> 
                        <h4 class="media-heading"><?php echo $name ;  if($ticket_all_replies_data[$i]['attachment'] != ""){ ?>  &nbsp; | &nbsp; <a id="example1" href="<?php echo ATTACHMENT?><?php echo $ticket_all_replies_data[$i]['attachment'] ; ?>"> <i class="fa fa-tags fa-lg"></i></a><?php  } ?></h4>
                        <p class="media-timestamp"><?php echo date('d M, Y , g:i a',strtotime($ticket_all_replies_data[$i]['created_date'])); ?></p>
                        <?php echo strip_tags($ticket_all_replies_data[$i]['details'],'<br><a>') ; ?></div>
                    </div>
                  </div>
                  
                  <!--<div class="media">
                    <div class="media-body">
                      <div class="">
                        <h4 class="media-heading">Marry Wilconson</h4>
                        <p class="media-timestamp">January 12, 2013 at 1:38 pm</p>
                        Cras sit amet nibh libero, in Cras purus odio, nc ac nisi vulputate facinia congue felis in faucibus. </div>
                    </div>
                  </div>-->
                  <?php  } ?>
                </form> 
                </div>
                <div class="panel-footer">
                  &nbsp;
                </div>
              </div>
            </div>
        <div class="clearfix"></div>
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
</body>
</html>