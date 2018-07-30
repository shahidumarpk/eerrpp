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
                    
               
               <form class="form-horizontal margin-top" id="ticket_reply_process_frm" method="POST" action="<?php echo SURL?>messages/manage-messages/message-inbox-detail-process" enctype="multipart/form-data">
              
                <div class="panel-body">
                	<div class="media">
                    <div class="media-body">
                    <div class="media-content">
                  		<div class="form-horizontal">
                      	
                      	<div class="row">
                          <div class="col-md-2"><strong>Title :</strong></div>
                          <div class="col-lg-10"><?php echo stripcslashes($message_detail_arr[0]['subject']);  ?>  </div>
                        </div>
                        
                        <div class="row">
                          <div class="col-md-2"><strong>Name :</strong></div>
                          <div class="col-lg-10"><?php echo $message_detail_arr[0]['user_name'] ?>  </div>
                        </div>
                        
                        <div class="row">
                          <label class="col-lg-2"><strong>Created Date :</strong></label>
                          <div class="col-lg-10">
                         <?php echo date('d M, Y , g:i a',strtotime($message_detail_arr[0]['date'])); ?>
                          </div>
                        </div>
                    </div>
                    </div>
                    </div>
                  </div>
                    <div class="clearfix">&nbsp;</div>
                    <?php if($message_detail_arr[0]['notification']=="" or $message_detail_arr[0]['notification']==0 ){  ?>
                    
                    <div class="well">
                      <fieldset>
                        <legend>Reply </legend>
                        
                        
                        <div class="control-group">
                          <label class="control-label">Your message</label>
                          <div class="controls">
                           
                            <textarea class="form-control" id="textArea" rows="8" name="message_reply" required></textarea>
                            <div class="clearfix">&nbsp;</div>
                            <div class="control-group">
                          <label class="control-label">Attach File</label>
                          <div class="controls">
                           
                            <input type="file" id="attachment" name="attachment">
                             <span class="help-block margin-top-sm"><i class="fa fa-bell"></i> 
                                - Allowed Extensions:   jpg, jpeg, gif, tiff, png, doc, zip, rar, pdf, docx, odt, xlsx, csv, pptx, ppt
                            </span>
                            <span class="help-block margin-top-sm"><i class="fa fa-bell"></i> 
                                Max Upload Size: 15MB;
                            </span>
                          </div>
                        </div>
                            
                         <input type="hidden" name="message_id" id="message_id" value="<?php echo $message_id  ?>" >
                         
                        
                      	<div class="pull-right"><input class="submit btn btn-blue" name="reply_message_sbt" id="reply_message_sbt" type="submit" value="Reply" style="width:100%;"></div>
                          </div>
                        </div>
                        
                      </fieldset>
                    </div>
                    
                    <?php } ?>
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
						 
						for($i=0; $i<$message_detail_count; $i++){
							
						 ?>
                        	<tr>
                            	<td rowspan="2">
                                    <strong class="coltext3"><?php echo $message_detail_arr[$i]['user_name'] ?></strong><br>
                                    <br> 		 								
                                    <div class="text-small"> </div>
                                </td>
                                
                                <td>
                                	<p class="text-small">Posted on: <?php echo date('d M, Y , g:i a',strtotime($message_detail_arr[$i]['date'])); ?></p><hr>
                                    
                                    
                                    <div class="post">  <?php echo  stripcslashes($message_detail_arr[$i]['message']); ?><br>

                                    
                                     <?php if($message_detail_arr[$i]['attachment']!=""){ ?>
                                     
                            <br>         
                            <div class="col-md-1">      
                            <div class="thumbnail" style="width: 95px;height: 76px;margin-left: -14px;">
							<?php 
							
                             $ext = pathinfo($message_detail_arr[$i]['attachment'], PATHINFO_EXTENSION) ;
                            
                            if($ext=='jpg' or $ext=='png') {?>
                             <a href="<?php echo MURL?>assets/messages_attachments/<?php echo $message_detail_arr[$i]['attachment'] ?>" style="width: 116px;margin-left: -16px;" data-toggle="lightbox" data-gallery="multiimages" data-title="<?php echo $project_attachments_arr[$i]['title'] ?>" class="col-sm-4">
                             
                             <img src="<?php echo MURL?>assets/messages_attachments/<?php echo $message_detail_arr[$i]['attachment'] ?>" data-src="holder.js/100%x180" data-holder-rendered="false">
                             </a>
                            <?php }elseif($ext=='zip' or $ext=='rar'){ ?>
                              
                                <a class="anchor_style" href="<?php echo MURL?>assets/messages_attachments/<?php echo $message_detail_arr[$i]['attachment'] ?>" target="_blank" download> <img src="<?php echo SURL?>assets/img/zip.png" style="height: 69px;" ></a>
                                
                                <?php }elseif($ext=='doc' or $ext=='docx'){ ?>
                              
                                <a class="anchor_style" href="<?php echo MURL?>assets/messages_attachments/<?php echo $message_detail_arr[$i]['attachment'] ?>" target="_blank" download> <img src="<?php echo SURL?>assets/img/docx.png" style="height: 69px;" ></a>
                              
                            <?php }elseif($ext=='pptx' or $ext=='ppt'){ ?>
                              
                                <a class="anchor_style" href="<?php echo MURL?>assets/messages_attachments/<?php echo $message_detail_arr[$i]['attachment'] ?>" target="_blank" download> <img src="<?php echo SURL?>assets/img/pptx.png" style="height: 69px;" ></a>
                              
                            <?php }elseif($ext=='pdf'){ ?>
                              
                                <a class="anchor_style" href="<?php echo MURL?>assets/messages_attachments/<?php echo $message_detail_arr[$i]['attachment'] ?>" target="_blank" download> <img src="<?php echo SURL?>assets/img/pdf.png" style="height: 69px;" ></a>        
                                <?php }elseif($ext=='txt'){ ?>
                              
                                <a class="anchor_style" href="<?php echo MURL?>assets/messages_attachments/<?php echo $message_detail_arr[$i]['attachment'] ?>" target="_blank" download> <img src="<?php echo SURL?>assets/img/text.png" style="height: 69px;" ></a>        
                                <?php }elseif($ext=='csv'){ ?>
                              
                                <a class="anchor_style" href="<?php echo MURL?>assets/messages_attachments/<?php echo $message_detail_arr[$i]['attachment'] ?>" target="_blank" download> <img src="<?php echo SURL?>assets/img/csv.png" style="height: 69px;" ></a>       
                                
                                <?php }  ?>
                              
                              
                            </div>
                            </div>
                                     <?php }  ?>
                                     </div>
                                     
                                 </td>
                                 
                             </tr>
                             
                            <tr><td colspan="2" class="p0 mainTopicBorder"></td></tr>
                            
                         <?php  }  ?>   
                         
                            
                        </tbody>
                     </table>
                    
                   
                    
                    
                    
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
<script src="<?php echo JS?>ekko-lightbox.js"></script>
     <script type="text/javascript">
            $(document).ready(function ($) {
                // delegate calls to data-toggle="lightbox"
                $(document).delegate('*[data-toggle="lightbox"]:not([data-gallery="navigateTo"])', 'click', function(event) {
                    event.preventDefault();
                    return $(this).ekkoLightbox({
                        onShown: function() {
                            if (window.console) {
                                return console.log('Checking our the events huh?');
                            }
                        },
						onNavigate: function(direction, itemIndex) {
                            if (window.console) {
                                return console.log('Navigating '+direction+'. Current item: '+itemIndex);
                            }
						}
                    });
                });

                //Programatically call
                $('#open-image').click(function (e) {
                    e.preventDefault();
                    $(this).ekkoLightbox();
                });
                

				// navigateTo
                $(document).delegate('*[data-gallery="navigateTo"]', 'click', function(event) {
                    event.preventDefault();
                    return $(this).ekkoLightbox({
                        onShown: function() {

							var a = this.modal_content.find('.modal-footer a');
							if(a.length > 0) {

								a.click(function(e) {

									e.preventDefault();
									this.navigateTo(2);

								}.bind(this));

							}

                        }
                    });
                });


            });
        </script>
        
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