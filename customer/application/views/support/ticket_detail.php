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
					echo $ticket_status ; ?>
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
                    
                    <?php echo  stripcslashes(strip_tags($ticket_data_arr['details'],'<br>')) ; ?>
                    
                        <div class="clearfix">&nbsp;</div>
                       
                        
                        <?php
						for($attach= 0; $attach<$ticket_attachment_count;$attach++){
							if($attach != 0){
								$string .= '&nbsp;,&nbsp;'	;
							}
								$string .= '<a href="'.ATTACHMENT.$ticket_attachment_data[$attach]['attachment'].'" target="_blank">'.$ticket_attachment_data[$attach]['attachment'].'</a>' ;
							
						 } 
						echo $string ; 
						?>
                        
                  		<div class="form-horizontal">
                      	
                      	<div class="row">
                          <div class="col-md-2"><strong>Customer Name :</strong></div>
                          <div class="col-lg-10">   <?php if($ticket_data_arr['customer_id']=='0'){ echo "Customer"; } else{ echo $ticket_data_arr['first_name'].' '.$ticket_data_arr['last_name']; } ?>  </div>
                        </div>
                        
                        <div class="row">
                          <div class="col-md-2"><strong>Created By :</strong></div>
                          <div class="col-lg-10"> <?php if($ticket_data_arr['created_by']=='0'){ echo "System"; }else{ echo $ticket_data_arr['first_name'].' '.$ticket_data_arr['last_name'];  }  ?>  </div>
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
                    <div class="well">
                      <fieldset>
                        <legend>Ticket Reply </legend>
                        
                        
                        <div class="control-group">
                          <label class="control-label">Your message</label>
                          <div class="controls">
                           
                            <textarea class="form-control" id="ticket_reply" rows="8" name="ticket_reply" required></textarea>
                            <div class="clearfix">&nbsp;</div>
                           
                       <input type="hidden" name="ticket_id" id="ticket_id" value="<?php echo $ticket_data_arr['ticket_number'] ;  ?>" >
                       
                      	<div class="pull-right">
                        <input class="submit btn btn-blue" name="reply_ticket_sbt" id="reply_ticket_sbt" type="submit" value="Submit" style="width:100%;">
                         <input class="submit btn btn-red" type="submit" value="Close Ticket" style="width:100%;" onClick="javascript: if(confirm('Are you sure you want to close this ticket?')) { window.location='<?php echo SURL?>support/manage_tickets/ticket_close_process/<?php echo $ticket_id ;  ?>'; return true ; }else{  return false ; }">
                          </div>
                        </div>
                        </div>
                      </fieldset>
                    </div>
                   </form> 
                    
                    <table class="table table-bordered table-hover table-striped topicTable"> 				 						<thead>
                    		<tr class="forumhead">
                            	<th width="101" class="authorCol text-center">Author</th>
                                <th width="412" class="messCol text-center">Message</th>
                            </tr>
                    	</thead> 
                    	<tbody>
                        
                       <?php 
				for($i=0;$i<$ticket_replies_count;$i++){
					
				 ?>
                        	<tr>
                            	<td rowspan="2">
                                    <strong class="coltext3"><?php echo $name ;  if($ticket_all_replies_data[$i]['attachment'] != ""){ ?>  &nbsp; | &nbsp; <a id="example1" href="<?php echo ATTACHMENT?><?php echo $ticket_all_replies_data[$i]['attachment'] ; ?>"> <i class="fa fa-tags fa-lg"></i></a><?php  } ?></strong><br>
                                    <br> 		 								
                                    <div class="text-small"> <b>Joined:</b> 2011-03-24<br> <b>Posts:</b> 12001<br> <b>Age:</b> 39<br> <b>Location:</b> Vienna<br> </div>
                                </td>
                                
                                <td>
                                	<p class="text-small">Posted on: <?php echo date('d M, Y , g:i a',strtotime($ticket_all_replies_data[$i]['created_date'])); ?></p><hr>
                                    
                                    
                                    <div class="post"> <?php echo strip_tags(stripcslashes($ticket_all_replies_data[$i]['details']),'<br><a>') ; ?>
                                    
                                 
                                    </div>
                                     
                                 </td>
                                 
                             </tr>
                             
                            <tr><td colspan="2" class="p0 mainTopicBorder"></td></tr>
                         <?php  } ?>         
                            
                        </tbody>
                     </table>
                    
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
<script type='text/javascript'>
        var rowNum = 0;
function add_layer_html(frm) {
 rowNum ++;
 var row = '<div id="rowNum'+rowNum+'"><input type="file" id="attachments" name="attachments[]" style="margin-top: 5px;"><input type="button" class="btn btn-danger" value="Remove" onclick="removeRow('+rowNum+');" style="margin-top: 5px;"><div class="clearfix">&nbsp;</div><div class="clearfix"></div>';
 jQuery('#item').append(row);
}

function removeRow(rnum) {
 jQuery('#rowNum'+rnum).remove();
}

</script>
</body>
</html>