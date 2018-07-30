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
	<div class="row" style="min-height:1300px;">
        <div class="col-md-12 chat-widget">
               <div class="panel chat-panel">
                <div class="panel-heading">
                  <div class="panel-title"> 
                   <span class="glyphicon glyphicon-envelope"></span> <?php echo $ticket_data_arr['subject'] ; ?></div>
                  <div class="panel-tray pull-right">
                  </div>
                  <div class="mini-action-icons margin-right-sm pull-right"> 
                  	
                  </div>
               </div>
               <form class="form-horizontal margin-top" id="ticket_reply_process_frm" method="POST" action="<?php echo SURL?>messages/manage-messages/message-sent-detail-process" enctype="multipart/form-data">
              
                <div class="panel-body">
                	<div class="media">
                    
                    <div class="media-body">
                    <div class="media-content">
                  		<div class="form-horizontal">
                      	
                      	<div class="row">
                          <div class="col-md-2"><strong>Title :</strong></div>
                          <div class="col-lg-10">    <?php echo  $message_detail_arr[0]['subject']; ?> </div>
                        </div>
                        
                        <div class="row">
                          <div class="col-md-2"><strong>Name :</strong></div>
                          <div class="col-lg-10">   <?php echo $message_detail_arr[0]['display_name'] ?>  </div>
                        </div>
                        
                        <div class="row">
                          <label class="col-lg-2"><strong>Created Date :</strong></label>
                          <div class="col-lg-10">
                         <?php echo date('d M, Y',strtotime($message_detail_arr[0]['date'])); ?>
                          </div>
                        </div>
                    </div>
                    </div>
                    </div>
                    
                    </div>
                    
                 </div>
                    <div class="clearfix">&nbsp;</div>
                    
                   
                   
                   </form> 
                    
                    <table class="table table-bordered table-hover table-striped topicTable"> 				 						<thead>
                    		<tr class="forumhead">
                            	<th width="101" class="authorCol text-center">Author</th>
                                <th width="412" class="messCol text-center">Message</th>
                            </tr>
                    	</thead> 
                    	<tbody>
                        
                        
                        
                        <?php // echo "<pre>";
						
						//print_r($message_detail_arr);
						//exit;
						
						
						for($i=0; $i<$message_detail_count; $i++){
							
							
						 ?>
                        	<tr>
                            	<td rowspan="2">
                                    <strong class="coltext3"><?php echo $message_detail_arr[$i]['display_name'] ?></strong><br>
                                    <br> 		 								
                                    <div class="text-small"> </div>
                                </td>
                                
                                <td>
                                	<p class="text-small">Posted on: <?php echo date('d M, Y , g:i a',strtotime($message_detail_arr[$i]['date'])); ?></p><hr>
                                    
                                    
                                    <div class="post">  <?php echo  stripcslashes(strip_tags($message_detail_arr[$i]['message'],'<br>')); ?> </div>
                                     
                                 </td>
                                 
                             </tr>
                             
                            <tr><td colspan="2" class="p0 mainTopicBorder"></td></tr>
                         <?php  }  ?>   
                            
                            
                        </tbody>
                     </table>
                    
                   
                    
                    
                    
                </div>
                
                </div>
              </div> 
            </div>
        <div class="clearfix"></div>
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