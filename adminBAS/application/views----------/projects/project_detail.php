<!DOCTYPE html>
<html>
<head>

<!-- Meta, title, CSS, favicons, etc. -->
<meta charset="utf-8">
<title><?php echo $meta_title ?></title>
<meta name="keywords" content="<?php echo $meta_keywords ?>" />
<meta name="description" content="<?php echo $meta_description ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
 <link href="<?php echo CSS?>ekko-lightbox.css" rel="stylesheet">
<?php echo $INC_header_script_top; ?>

<style type="text/css">
.btn{color: rgb(95, 92, 92);}
.my{color: rgb(249, 247, 247);}
.btn:hover {
  color: #333;
  background-image: -webkit-linear-gradient(top, rgba(255, 255, 255, 0.13) 1%, rgba(255, 255, 255, 0.13) 100%);
  background-image: linear-gradient(to bottom, rgba(255, 255, 255, 0.13) 1%, rgba(255, 255, 255, 0.13) 100%); }

</style>


<?php echo $INC_header_script_footer;?>
<script src="<?php echo JS?>jRate.min.js"></script>
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
        <form class="form-horizontal margin-top" id="ticket_reply_process_frm" method="POST" action="<?php echo SURL?>projects/manage-projects/project-messages/<?php echo $project_id ?>" enctype="multipart/form-data">
               <div class="panel chat-panel">
                <div class="panel-heading">
                  <div class="panel-title"> 
                   <span class="glyphicon glyphicon"></span>Status : 
                   <?php  if($project_details_arr['status']==0){ echo "New";}?>
                   <?php  if($project_details_arr['status']==1){ echo "InProgress";}?>
                   <?php  if($project_details_arr['status']==2){ echo "Cancel";}?>
                   <?php  if($project_details_arr['status']==3){ echo "Closed";}?>
                   <?php  if($project_details_arr['status']==4){ echo "Hold";}?>
                   </div>
                 <div class="pull-right">
                 <a href=''  id='emailTom' data-toggle='modal' data-target='#add_task' title='Add Task'>Add Task</a>
                <?php 
                    if($ALLOW_user_assign_task== 1){ 
			    ?> 
              	&nbsp; | &nbsp; <a href="<?php echo base_url()?>projects/manage-projects/assign-task/<?php echo $project_id; ?>" >Assign Task</a> &nbsp; | &nbsp;<?php  }  ?>   
                
                 <?php 
                    if($ALLOW_user_assign_team== 1){ 
			    ?> 
               <a href="<?php echo base_url()?>projects/manage-projects/project-assign/<?php echo $project_id; ?>" >Assign Team</a><?php  }  ?> 
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
               
               
              
                <div class="panel-body">
                 <div class="row">
                    <div class="col-md-7 col-lg-7">
                      <div class="row">
                        <div class="col-md-12">
                          <div class="panel profile-panel">
                            <div class="panel-heading panel-visible">
                              <div class="panel-title"> <span class="glyphicon glyphicon-list"></span> Project Details </div>
                             
                            
                              <div class="panel-btns pull-right margin-left">
                                
                              </div>
                            </div>
                            <div class="panel-body">
                              <div class="row">
                                
                                <div class="col-xs-12">
                                <table class="table">
                                      <tbody>
                                        <tr>
                                          <td class="col-md-4 "><strong>Project Title</strong></td>
                                          <td class="col-md-8 pTitle"><?php echo  stripslashes($project_details_arr['project_title']); ?></td>
                                        </tr>
                                        <tr>
                                          <td class="col-md-4"><strong>Project Description :</strong></td>
                                          <td class="col-md-8"><?php echo  stripcslashes($project_details_arr['project_detail']); ?></td>
                                        </tr>
                                        <tr>
                                          <td class="col-md-4"><strong>Customer Name:</strong></td>
                                          <td class="col-md-8">
                                          <a class="anchor_style" href="<?php echo base_url()?>customers/manage-customers/view-customer/<?php echo $project_details_arr['id'] ?>" title="Click to customer Detail page" target="_blank"><?php echo $project_details_arr['first_name']." ".$project_details_arr['last_name']; ?></a></td>
                                        </tr>
                                        <tr>
                                          <td class="col-md-4"><strong>Created Date:</strong></td>
                                          <td class="col-md-8"><?php echo date('d M, Y',strtotime($project_details_arr['created_date'])); ?></td>
                                        </tr>
                        <?php
						
						 if($project_assign_team[0]!=" ") { ?>
                                        <tr>
                                          <td class="col-md-4"><strong>Team:</strong></td>
                                           
                                          <td class="col-md-8">
	                     <?php
						  
						  for($i=0;$i<count($project_assign_team); $i++)
						  {
							if($role[$i]=='Super Admin' or $role[$i]=='General Manager')
							{ ?>
                            
                           
							   <a class="anchor_style" href="<?php echo base_url()?>admin/manage-user/user-detail/<?php echo $project_assign_team[$i]['id'] ?>" target="_blank">
                          
                           <?php  echo  $project_assign_team[$i]['user_name']; ?>(*)</a><br>
						   <?php }
							else { ?>
                            
								
								 <a class="anchor_style" href="<?php echo base_url()?>admin/manage-user/user-detail/<?php echo $project_assign_team[$i]['id'] ?>" target="_blank">
                              
								 <?php echo $project_assign_team[$i]['user_name']." (".$role[$i].")". "<br> ";
						 }       }     
						  
						  ?></a></td>
                                        </tr>
                              <?php  }  ?> 
                      
                                      </tbody>
                                    </table>
            
                                </div>
                              </div>
                              
                              
                              <div class="clearfix"></div>
                            </div>
                            <div class="panel-footer">
                              
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-5 col-lg-5">
                     <div class="col-md-12">
                      <div class="panel">
                        <div class="panel-heading">
                          <div class="panel-title"> <span class="glyphicon glyphicon-list-alt"></span>Task Details</div>
                        </div>
                        <div class="panel-body">
                          <div class="table-responsive">
                            <table class="table table-bordered">
                              <thead>
                                <tr>
                                  <th>Total Tasks</th>
                                  <th>Start</th>
                                  <th>Hold</th>
                                  <th>Closed</th>
                                </tr>
                                <tr>
                                  <td>
                                   <?php if($total_task>0){ ?>
                                   <a class="anchor_style" href="<?php echo base_url()?>projects/manage-projects/manage-project-task/<?php echo $project_id;?>/0" title="Click to View Task Details" target="_blank">
								   <?php } ?>
								   <?php echo $total_task; ?> </a></td>
                                  <td>
								  
                                  <?php if($open_task>0){ ?>
                                  <a class="anchor_style" href="<?php echo base_url()?>projects/manage-projects/manage-project-task/<?php echo $project_id;?>/1" title="Click to View Task Details" target="_blank">
                                  <?php } ?>
								  <?php echo $open_task ?></a>
                                  
                                  </td>
                                  <td>
								   <?php if($hold_task>0){ ?>
                                  <a class="anchor_style" href="<?php echo base_url()?>projects/manage-projects/manage-project-task/<?php echo $project_id;?>/2" title="Click to View Task Details" target="_blank">
                                  <?php } ?>
								  <?php echo $hold_task ?></a>
                                  
                                  </td>
                                  <td>
								   <?php if($closed_task>0){ ?>
                                  <a class="anchor_style" href="<?php echo base_url()?>projects/manage-projects/manage-project-task/<?php echo $project_id;?>/3" title="Click to View Task Details" target="_blank">
                                  <?php } ?>
								  <?php echo $closed_task ?></a>
                                  
                                  </td>
                                </tr>
                              </thead>
                              <tbody>
                             
                            </tbody>
                            </table>
                            <div class="clearfix"></div>
                           
                          </div>
                        </div>
                      </div>
                      <div class="panel">
                        <div class="panel-heading">
                          <div class="panel-title"> <span class="glyphicon glyphicon-list-alt"></span>Recent Project Tasks</div>
                        </div>
                        <div class="panel-body">
                          <div class="table-responsive">
                            
                            <?php if(count($project_task_arr)>0) {?>
                            <table class="table table-bordered">
                              <thead>
                                <tr>
                                  <th>#</th>
                                  <th>Task Title</th>
                                  <th>Start Date</th>
                                  <th>End Date</th>
                                </tr>
                            <?php for($c=0; $c<count($project_task_arr); $c++){ ?>    
                                <tr>
                                  <td><?php echo($c+1);?></td>
                                  <td><a class="anchor_style" href="<?php echo base_url()?>projects/manage-projects/assign-task-detail/<?php echo $project_task_arr[$c]['id'] ?>" title="Click to Task Detail" target="_blank"><?php echo $project_task_arr[$c]['title']; ?></a></td>
                                  <td><?php echo date('d M, Y  h:i:s a', strtotime($project_task_arr[$c]['start_date'])); ?></td>
                                  <td><?php echo date('d M, Y  h:i:s a', strtotime($project_task_arr[$c]['end_date']));  ; ?></td>
                                  
                                </tr>
                           <?php } ?>     
                              </thead>
                              <tbody>
                              
                             </tbody>
                            </table>
                            <?php }else{echo "<span style='color: red;
font-weight: bold;'>No Tasks Found...!</span>";} ?>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="clearfix"></div>
                    </div>
                  </div>
                	
                  </div>
              
     <?php if($project_attachments_count >0){ ?>
     <div class="col-md-7 pull-left" style="margin-top: -66px; ">
             <div class="panel">
            
             <div class="panel-heading">Project Attachments</div>
                 <div class="panel-body alerts-panel">
                     <div class="row">
                 
					  <?php for($i=0; $i<$project_attachments_count; $i++) { ?>
                       <div class="col-md-3">
                            <div class="thumbnail" style="width: 85px;height: 85px;">
                
							<?php 
                             $ext = pathinfo($project_attachments_arr[$i]['attachment_name'], PATHINFO_EXTENSION) ;
                            
                            if($ext=='jpg' or $ext=='png') {?>
                             <a href="<?php echo MURL?>assets/project_attachments/<?php echo $project_id."/".$project_attachments_arr[$i]['attachment_name'] ?>" style="width:140%;margin-left: -16px;" data-toggle="lightbox" data-gallery="multiimages" data-title="<?php echo $project_attachments_arr[$i]['title'] ?>" class="col-sm-4">
                             
                             <img src="<?php echo MURL?>assets/project_attachments/<?php echo $project_id."/".$project_attachments_arr[$i]['attachment_name'] ?>" data-src="holder.js/100%x180" data-holder-rendered="false" width="100" height="74">
                             </a>
                            <?php }elseif($ext=='zip' or $ext=='rar'){ ?>
                              
                                <a class="anchor_style" href="<?php echo MURL?>assets/project_attachments/<?php echo $project_id."/".$project_attachments_arr[$i]['attachment_name'] ?>" target="_blank" download> <img src="<?php echo SURL?>assets/img/zip.png" style="height: 66px;" ></a>
                                
                                <?php }elseif($ext=='doc' or $ext=='docx'){ ?>
                              
                                <a class="anchor_style" href="<?php echo MURL?>assets/project_attachments/<?php echo $project_id."/".$project_attachments_arr[$i]['attachment_name'] ?>" target="_blank" download> <img src="<?php echo SURL?>assets/img/docx.png" style="height: 66px;" ></a>
                              
                            <?php }elseif($ext=='xlsx' or $ext=='xls'){ ?>
                              
                                <a class="anchor_style" href="<?php echo MURL?>assets/project_attachments/<?php echo $project_id."/".$project_attachments_arr[$i]['attachment_name'] ?>" target="_blank" download> <img src="<?php echo SURL?>assets/img/excel.png" style="height: 66px;" ></a>
                              
                            <?php }elseif($ext=='odt'){ ?>
                              
                                <a class="anchor_style" href="<?php echo MURL?>assets/project_attachments/<?php echo $project_id."/".$project_attachments_arr[$i]['attachment_name'] ?>" target="_blank" download> <img src="<?php echo SURL?>assets/img/odt.png" style="height: 66px;" ></a>
                              
                            <?php }
							elseif($ext=='pptx' or $ext=='ppt'){ ?>
                              
                                <a class="anchor_style" href="<?php echo MURL?>assets/project_attachments/<?php echo $project_id."/".$project_message_attachment_arr[$project_messages_arr[$i]['id']][$j] ?>" target="_blank" download> <img src="<?php echo SURL?>assets/img/pptx.png" style="height: 69px;" ></a>
                              
                            <?php }elseif($ext=='pdf'){ ?>
                              
                                <a class="anchor_style" href="<?php echo MURL?>assets/project_attachments/<?php echo $project_id."/".$project_attachments_arr[$i]['attachment_name'] ?>" target="_blank" download> <img src="<?php echo SURL?>assets/img/pdf.png" style="height: 66px;" ></a>        
                                <?php }elseif($ext=='txt'){ ?>
                              
                                <a class="anchor_style" href="<?php echo MURL?>assets/project_attachments/<?php echo $project_id."/".$project_attachments_arr[$i]['attachment_name'] ?>" target="_blank" download> <img src="<?php echo SURL?>assets/img/text.png" style="height: 66px;" ></a>        
                                <?php }elseif($ext=='csv'){ ?>
                              
                                <a class="anchor_style" href="<?php echo MURL?>assets/project_attachments/<?php echo $project_id."/".$project_attachments_arr[$i]['attachment_name'] ?>" target="_blank" download> <img src="<?php echo SURL?>assets/img/csv.png" style="height: 66px;" ></a>       
                                 <?php }  ?>
                              
                              <div class="caption">
                                <p><?php echo $deals_result_arr[$i]['detail']; ?></p>
                                <div class="clearfix"></div>
                                <!-- <p><a href="<?php echo SURL?>projects/manage-projects/delete-deal-files/<?php echo $deal_id;?>/<?php echo $deals_result_arr[$i]['id']; ?>" class="btn btn-danger pull-right" role="button">Delete</a></p> -->
                                 <div class="clearfix"></div>
                              </div>
                            </div>
                     <div class="clearfix"></div>
              </div>
                      <?php } ?>
          
        </div>
                 </div>
             </div>
      </div>
      <?php  } ?>
           
                    <div class="clearfix">&nbsp;</div>
                    
                   
                    <div class="well">
                      <fieldset>
                        <legend>Reply </legend>
                        
                        
                        <div class="control-group">
                          <label class="control-label">Your message</label>
                          <div class="controls">
                           
                            <textarea class="form-control" id="textArea" rows="8" name="message_reply" required></textarea>
                            <div class="clearfix">&nbsp;</div>
                            <fieldset>
                        <legend>Add Attachments</legend>
                       <span class="help-block margin-top-sm"><i class="fa fa-bell"></i> 
                                - Allowed Extensions:   jpg, jpeg, gif, tiff, png, doc, zip, rar, pdf, docx, odt, xlsx, csv, pptx, ppt
                            </span>
                            <span class="help-block margin-top-sm"><i class="fa fa-bell"></i> 
                                Max Upload Size: 15MB;
                            </span>
                        
                        <div class="control-group">
                        
                          
                          <div class="controls">
                           
                            <input type="file" id="attachments" name="attachments[]" title="add attchments">
                          </div>
                        </div>
                        
                    <div id="item"></div> 
                    <div><button type="button" class="btn btn-blue" onClick="add_layer_html(this.form);" style="margin-top: 5px;" title="Click to add more">Add More</button></div>
                        
                      </fieldset>
                    
                       <input type="hidden" name="project_title" id="project_title" value="  <?php echo  $project_details_arr['project_title']; ?>" >
                       <input type="hidden" name="project_id" id="project_id" value="<?php echo $project_id  ?>" >
                       <input type="hidden" name="to" id="to" value="<?php echo  $project_details_arr['customer_id'];   ?>" >
                      	<div class="pull-right"><input class="submit btn btn-blue" name="reply_message_sbt" id="reply_message_sbt" type="submit" value="Reply" style="width:100%;" title="Click for Reply"></div>
                          </div>
                        </div>
                        
                      </fieldset>
                    </div>
                   
                </div>   
                 
        </form> 
                    
                    <table width="100%" class="table table-bordered table-hover table-striped topicTable"> 				 						<thead>
                    		<tr class="forumhead">
                            	<th width="20%" class="authorCol text-center">Author</th>
                                <th width="80%" class="messCol text-center">Message</th>
                            </tr>
                    	</thead> 
                    	<tbody>
                        
                        <?php  for($i=0; $i<$project_messages_count; $i++){ ?>
                        
                        
                        	<tr>
                            	<td rowspan="2">
                                    <strong class="coltext3"><?php echo  $project_messages_arr[$i]['user'];?> <br>
                                    
                                    <?php if($project_messages_arr[$i]['avatar_image'] !=""){ ?>
                                    <div class="thumbnail" style="width: 30%;margin-bottom: 0px;">
                                    <img  src="<?php echo USER_FOLDER.'/'.$project_messages_arr[$i]['admin_id'].'/'.stripslashes($project_messages_arr[$i]['avatar_image'])?>">	
                                    </div>
                                    <?php  } ?>
                                    
                                    <?php if($project_messages_arr[$i]['user_role'] !=""){ ?>
									(<?php echo  $project_messages_arr[$i]['user_role'];?>)
                                    <?php  } ?> </strong>
                                    
                                    <br>
                                    <br> 
                                     <div id="jRate<?php echo $project_messages_arr[$i]['id']?>" style="height:33px;width: 100%;" title="Rating(<?php echo round($project_messages_arr[$i]['admin_rating'],2);?>)"></div>		 								
                                    <div class="text-small"> </div>
                                </td>
                                
                                <td>
                                	<p class="text-small">Posted on: <?php echo date('d M, Y , g:i a',strtotime($project_messages_arr[$i]['created_date'])); ?></p><hr>
                                    
                                    
                                    <div class="post"><?php echo stripcslashes(strip_tags($project_messages_arr[$i]['message'],'<b><br><a>')) ?>
                                    
                         <?php  if(count($project_message_attachment_arr[$project_messages_arr[$i]['id']]) > 0){ 
									
									for($j=0; $j<count($project_message_attachment_arr[$project_messages_arr[$i]['id']]); $j++){
									
									?>
                                    
                         <p></p>
                            <div class="col-md-2">      
                            <div class="thumbnail" style="width: 90px;height: 76px;">
							<?php 
							
                             $ext = pathinfo($project_message_attachment_arr[$project_messages_arr[$i]['id']][$j], PATHINFO_EXTENSION) ;
                            
                            if($ext=='jpg' or $ext=='png') {?>
                             <a href="<?php echo MURL?>assets/project_attachments/<?php echo $project_id."/".$project_message_attachment_arr[$project_messages_arr[$i]['id']][$j] ?>" style="width: 139%;margin-left: -16px;" data-toggle="lightbox" data-gallery="multiimages" data-title="<?php echo $project_attachments_arr[$i]['title'] ?>" class="col-sm-4">
                             
                             <img src="<?php echo MURL?>assets/project_attachments/<?php echo $project_id."/".$project_message_attachment_arr[$project_messages_arr[$i]['id']][$j] ?>" data-src="holder.js/100%x180" data-holder-rendered="false" style="width: 86px;height: 65px;">
                             </a>
                            <?php }elseif($ext=='zip' or $ext=='rar'){ ?>
                              
                                <a class="anchor_style" href="<?php echo MURL?>assets/project_attachments/<?php echo $project_id."/".$project_message_attachment_arr[$project_messages_arr[$i]['id']][$j] ?>" target="_blank" download> <img src="<?php echo SURL?>assets/img/zip.png" style="height: 69px;" ></a>
                                
                                <?php }elseif($ext=='doc' or $ext=='docx'){ ?>
                              
                                <a class="anchor_style" href="<?php echo MURL?>assets/project_attachments/<?php echo $project_id."/".$project_message_attachment_arr[$project_messages_arr[$i]['id']][$j] ?>" target="_blank" download> <img src="<?php echo SURL?>assets/img/docx.png" style="height: 69px;" ></a>
                              
                            <?php }elseif($ext=='xlsx' or $ext=='xls'){ ?>
                              
                                <a class="anchor_style" href="<?php echo MURL?>assets/project_attachments/<?php echo $project_id."/".$project_attachments_arr[$i]['attachment_name'] ?>" target="_blank" download> <img src="<?php echo SURL?>assets/img/excel.png" style="height: 66px;" ></a>
                              
                            <?php }elseif($ext=='pptx' or $ext=='ppt'){ ?>
                              
                                <a class="anchor_style" href="<?php echo MURL?>assets/project_attachments/<?php echo $project_id."/".$project_message_attachment_arr[$project_messages_arr[$i]['id']][$j] ?>" target="_blank" download> <img src="<?php echo SURL?>assets/img/pptx.png" style="height: 69px;" ></a>
                              
                            <?php }elseif($ext=='odt'){ ?>
                              
                                <a class="anchor_style" href="<?php echo MURL?>assets/project_attachments/<?php echo $project_id."/".$project_attachments_arr[$i]['attachment_name'] ?>" target="_blank" download> <img src="<?php echo SURL?>assets/img/odt.png" style="height: 66px;" ></a>
                              
                            <?php }elseif($ext=='pdf'){ ?>
                              
                                <a class="anchor_style" href="<?php echo MURL?>assets/project_attachments/<?php echo $project_id."/".$project_message_attachment_arr[$project_messages_arr[$i]['id']][$j] ?>" target="_blank" download> <img src="<?php echo SURL?>assets/img/pdf.png" style="height: 69px;" ></a>        
                                <?php }elseif($ext=='txt'){ ?>
                              
                                <a class="anchor_style" href="<?php echo MURL?>assets/project_attachments/<?php echo $project_id."/".$project_message_attachment_arr[$project_messages_arr[$i]['id']][$j] ?>" target="_blank" download> <img src="<?php echo SURL?>assets/img/text.png" style="height: 69px;" ></a>        
                                <?php }elseif($ext=='csv'){ ?>
                              
                                <a class="anchor_style" href="<?php echo MURL?>assets/project_attachments/<?php echo $project_id."/".$project_message_attachment_arr[$project_messages_arr[$i]['id']][$j] ?>" target="_blank" download> <img src="<?php echo SURL?>assets/img/csv.png" style="height: 66px;" ></a>       
                                <?php }  ?>
                              
                              
                            </div>
                            </div>
                           
                         
                              
                          <?php      }//End for loop
						  
						  
						          }//End if ?>
                                    </div>
                                     
                                 </td>
                                 
                             </tr>
                             
                            <tr><td colspan="2" class="p0 mainTopicBorder"></td></tr>
                            
                            <?php  }//End for  ?> 
                            
                            
                        </tbody>
                     </table>
                    
                   
                    
                    
                    
                </div>
                <div class="panel-footer">
                  &nbsp;
                </div>
              </div> 
              
     </div>
     <div class="clearfix"></div>
    
    
  </section>
  <!-- End: Content --> 
</div>
<!-- End: Main --> 
<!-- Start: Footer -->
<div class="modal fade" id="add_task" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
    <form id="add_task_frm" action="<?php echo SURL?>projects/manage-projects/user-add-task" enctype="multipart/form-data" method="post">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Add Your Task</h4>
      </div>
      <div class="modal-body">
        
         
           <div class="form-group">
                        <label for="title">Task Title*</label>
                        <input id="title" name="title" type="text" class="form-control"  value="" required/>
           </div>
           
           
           
           <div class="row">
           <div class="col-md-12">
           <label >End Date/Time</label>
           </div>
           </div>
           
            <div class="row form-group">
                  
                  <div class="col-xs-6">
                    <div class="input-group" id="fromdate">
                    <input type="text" readonly style="cursor:pointer;" name="end_date" id="end_date" class="form-control" required /><span class="input-group-addon"><span id="target" onclick="create_date_time('fromdate')" class="glyphicon glyphicon-calendar" style="cursor:pointer;"></span></span>
                    </div>
                </div>
                             
            </div>
                 
                      
         <div class="form-group">
          <label for="message">Description*</label>
          <textarea class="form-control" id="description" name="description" rows="8" required></textarea>
        </div>
                    
         <div class="form-group">
           <label for="page_title">Attach File </label>
             <input type="file" id="attachments" name="attachments">
              <span class="help-block margin-top-sm"><i class="fa fa-bell"></i> 
                    - Allowed Extensions:   jpg, jpeg, gif, tiff, png, doc, zip, rar, pdf, docx, odt, xlsx, csv, pptx, ppt
                </span>
                <span class="help-block margin-top-sm"><i class="fa fa-bell"></i> 
                    Max Upload Size: 5MB;
                </span>
             
         </div>
          
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
         <input type="hidden" id="project_id" value="<?php echo $project_id;?>" name="project_id">
       
        <button id="submitMail" type="submit" class="btn btn-primary my">Add Task</button>
     
      </div>
         </form>
     
    </div>
  </div>
</div>


<footer> <?php echo $INC_footer;?> </footer>
<!-- End: Footer --> 
<?php  for($i=0; $i<$project_messages_count; $i++){ ?>
<script type="text/javascript">
				
		$(function () {
		
			var that = this;
			jQuery("#jRate<?php echo $project_messages_arr[$i]['id']?>").jRate({
				rating: <?php echo $project_messages_arr[$i]['admin_rating'];?>,
				strokeColor: 'black',
				width: 23,
				height: 20,
				readOnly: true
				
			});
			
		});
</script> 
<?php } ?>

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

<script type="text/javascript">
      jQuery(document).ready(function() {
    
      // validate signup form on keyup and submit
        $("#add_task_frm").validate({
            rules: {
				title : 'required',
				description : 'required',
                end_date: "required",
					
            },
            messages: {
                title: "This field is required.",
				description : "This field is required.",
                end_date: "This field is required.",
				
            }
        });
    
    });
</script>
</body>
</html>