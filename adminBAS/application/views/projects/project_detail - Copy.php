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
 
 <link rel="stylesheet" media="screen" href="<?php echo CSS?>countdown.css" />
<?php echo $INC_header_script_top; ?>

<style type="text/css">
.btn{color: rgb(95, 92, 92);}
.my{color: rgb(249, 247, 247);}
.btn:hover {
  color: #333;
  background-image: -webkit-linear-gradient(top, rgba(255, 255, 255, 0.13) 1%, rgba(255, 255, 255, 0.13) 100%);
  background-image: linear-gradient(to bottom, rgba(255, 255, 255, 0.13) 1%, rgba(255, 255, 255, 0.13) 100%); }

</style>

<style type="text/css">

.tutorial_list{ 
margin-bottom:20px;
}
div.list_item {
border-left: 4px solid #7ad03a;
padding: 1px 12px;
background-color:#F1F1F1;
-webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
}
div.list_item {
margin: 5px 15px 2px;
}
div.list_item p {
margin: .5em 0;
padding: 2px;
font-size: 13px;
line-height: 1.5;
}
.list_item a {
text-decoration: none;
padding-bottom: 2px;
color: #0074a2;
-webkit-transition-property: border,background,color;
transition-property: border,background,color;-webkit-transition-duration: .05s;
transition-duration: .05s;
-webkit-transition-timing-function: ease-in-out;
transition-timing-function: ease-in-out;
}
.list_item a:hover{ 
text-decoration:underline;
}
.show_more_main {
margin: 15px 25px;
}
.show_more {
background-color: #f8f8f8;
background-image: -webkit-linear-gradient(top,#fcfcfc 0,#f8f8f8 100%);
background-image: linear-gradient(top,#fcfcfc 0,#f8f8f8 100%);
border: 1px solid;
border-color: #d3d3d3;
color: #333;
font-size: 12px;
outline: 0;
}
.show_more {
cursor: pointer;
display: block;
padding: 10px 0;
text-align: center;
font-weight:bold;
}
.loding {
background-color: #e9e9e9;
border: 1px solid;
border-color: #c6c6c6;
color: #333;
font-size: 12px;
display: block;
text-align: center;
padding: 10px 0;
outline: 0;
font-weight:bold;
}
.loding_txt {
background-image: url(loading_16.gif);
background-position: left;
background-repeat: no-repeat;
border: 0;
display: inline-block;
height: 16px;
padding-left: 20px;
}

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
                <div class="row"> 
                 <div class="col-md-8">
                  <div id="CDT" style="widows:100%;"></div>
                 </div>
                 
                 <div class="col-md-4 pull-right">
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
                                        
                                        <?php if($project_details_arr['live_url']!="" or $project_details_arr['local_url']!="" or $project_details_arr['design_url']!="" or $project_details_arr['prototype_url']!=""){ ?>
                                        
                                        <tr>
                                        
                                       
                              <td class="col-md-4">
                             <strong> URL(s)</strong>
                               </td>
                            
                              
                              
                                          
                              <td class="col-md-8">
                                          
                              <?php if($project_details_arr['live_url']!="" ){ ?>
                              <a class="anchor_style" href="<?php echo $project_details_arr['live_url']; ?>" target="_blank"><strong>Live URL</strong></a>&nbsp;&nbsp;&nbsp;
                              <?php  } ?>
                              
                              <?php if($project_details_arr['local_url']!="" ){ ?>
                              <a class="anchor_style" href="<?php echo $project_details_arr['local_url']; ?>" target="_blank"><strong>Local URL</strong></a>&nbsp;&nbsp;&nbsp;
                              <?php  } ?>
                              
                               <?php if($project_details_arr['design_url']!="" ){ ?>
                              <a class="anchor_style" href="<?php echo $project_details_arr['design_url']; ?>" target="_blank"><strong>Design URL</strong></a>&nbsp;&nbsp;&nbsp;
                              <?php  } ?>
                              
                              
                               <?php if($project_details_arr['prototype_url']!="" ){ ?>
                              <a class="anchor_style" href="<?php echo $project_details_arr['prototype_url']; ?>" target="_blank"><strong>Prototype URL</strong></a>
                              <?php  } ?>
                                
                              </td>
                                        </tr>
                                     <?php  } ?>   
                                        <tr>
                                          <td class="col-md-4"><strong>Created Date:</strong></td>
                                          <td class="col-md-8"><?php echo date('d M, Y',strtotime($project_details_arr['created_date'])); ?></td>
                                        </tr>
                                        
                                        <tr>
                                          <td class="col-md-4"><strong>Status :</strong></td>
                                          <td class="col-md-8"> <?php  if($project_details_arr['status']==0){ echo "New";}?>
															   <?php  if($project_details_arr['status']==1){ echo "InProgress";}?>
                                                               <?php  if($project_details_arr['status']==2){ echo "Cancel";}?>
                                                               <?php  if($project_details_arr['status']==3){ echo "Closed";}?>
                                                               <?php  if($project_details_arr['status']==4){ echo "Hold";}?></td>
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
                     
                    <?php  if($ALLOW_user_milestones==1){ ?> 
                    
                     <div class="panel">
                        <div class="panel-heading">
                          <div class="panel-title"> <span class="glyphicon glyphicon-list-alt"></span>Project Milestones</div>
                        </div>
                        <div class="panel-body">
                          <div class="table-responsive">
                            
                            <?php if(count($project_milestones_arr)>0) { ?>
                            
                            <table class="table table-bordered" width="100%">
                              <thead>
                                <tr>
                                  <th>#</th>
                                  <th>Name</th>
                                  <th>Status</th>
                                  <th>Action</th>
                                </tr>
                            <?php for($c=0; $c<count($project_milestones_arr); $c++){ ?>    
                                <tr>
                                  <td><?php echo($c+1);?></td>
                                  <td><b><?php echo $project_milestones_arr[$c]['milestone_name']; ?></b></td>
                                  <td>
								  <?php  if($project_milestones_arr[$c]['status']==0){ echo "New"; }?>
                                  <?php  if($project_milestones_arr[$c]['status']==1){ echo "Inprogress"; }?>
                                  <?php  if($project_milestones_arr[$c]['status']==2){ echo "Closed"; }?>
                                  <?php  if($project_milestones_arr[$c]['status']==3){ echo "Reopen"; }?>
                                  </td>
                                  <td>
                                  
                                  <?php if($project_milestones_arr[$c]['status']==0 ){ ?>
                                   <a href="<?php echo base_url()?>projects/manage-projects/inprogress-milestone/<?php echo $project_milestones_arr[$c]['project_id'] ?>/<?php echo $project_milestones_arr[$c]['id'] ?>" type="button" class="btn btn-info btn-gradient"  style="color:#FFF; padding: 5px; font-size: 12px;  background: #129C17;border-color: #129C17;" title="Click for Inprogress" onClick="return confirm('Are you sure you want to Inprogress milestone?')">Inprogress</a>
                                   
                                   <?php  }elseif($project_milestones_arr[$c]['status']==1 or $project_milestones_arr[$c]['status']==3){  ?>
                                   
                                   <a href="<?php echo base_url()?>projects/manage-projects/close-milestone/<?php echo $project_milestones_arr[$c]['project_id'] ?>/<?php echo $project_milestones_arr[$c]['id'] ?>" type="button" class="btn btn-info btn-gradient"  style="color:#FFF;  padding: 5px; font-size: 12px;border-color: #d3332e;
  background-color: #d3332e;" title="Click for Closed" onClick="return confirm('Are you sure you want to Close milestone?')">Close</a>
                                   
                                   
                                   <?php  }else{  ?>
                                   
                                   <a href="<?php echo base_url()?>projects/manage-projects/reopen-milestone/<?php echo $project_milestones_arr[$c]['project_id'] ?>/<?php echo $project_milestones_arr[$c]['id'] ?>" type="button" class="btn btn-info btn-gradient"  style="color:#FFF;  padding: 5px; font-size: 12px;border-color: #d3332e;
  background-color: #d3332e;" title="Click for Reopen" onClick="return confirm('Are you sure you want to reopen milestone?')">ReOpen</a>
                                   
                                   
                                   <?php  } ?>
                                   
                        
                                  </td>
                                  
                                </tr>
                           <?php } ?>     
                              </thead>
                              <tbody>
                              
                             </tbody>
                            </table>
                            <?php }else{echo "<span style='color: red;
font-weight: bold;'>No Project Milestones Found...!</span>";} ?>
                          </div>
                        </div>
                      </div>
                     
                    <?php  } ?>
                     
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
                              
                                <a class="anchor_style" href="<?php echo MURL?>assets/project_attachments/<?php echo $project_id."/".$project_attachments_arr[$i]['attachment_name'] ?>" target="_blank" download> <img src="<?php echo SURL?>assets/img/pptx.png" style="height: 69px;" ></a>
                              
                            <?php }elseif($ext=='pdf'){ ?>
                              
                                <a class="anchor_style" href="<?php echo MURL?>assets/project_attachments/<?php echo $project_id."/".$project_attachments_arr[$i]['attachment_name'] ?>" target="_blank" download> <img src="<?php echo SURL?>assets/img/pdf.png" style="height: 66px;" ></a>        
                                <?php }elseif($ext=='txt'){ ?>
                              
                                <a class="anchor_style" href="<?php echo MURL?>assets/project_attachments/<?php echo $project_id."/".$project_attachments_arr[$i]['attachment_name'] ?>" target="_blank" download> <img src="<?php echo SURL?>assets/img/text.png" style="height: 66px;" ></a>     
                                
                                   
                                <?php }elseif($ext=='tif'){ ?>
                              
                                <a class="anchor_style" href="<?php echo MURL?>assets/project_attachments/<?php echo $project_id."/".$project_attachments_arr[$i]['attachment_name'] ?>" target="_blank" download> <img src="<?php echo MURL?>assets/img/tiff2.png" style="height: 66px;" ></a>        
                                
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
                    
                   
                    	
                      
                        <?php  for($i=0; $i<$project_messages_count; $i++){
							
								$row_id = 'row_'.$i;
							
							 ?>
                 
                        <div class="asdf" > 
                        <div class="well">
                        	<div class="row" >
                                <div class="col-md-2" style="border-right:1px solid #ccc;">
                                    
                                    <strong class="coltext3"><?php echo  $project_messages_arr[$i]['user'];?><br>
                                    <?php if($project_messages_arr[$i]['avatar_image'] !=""){ ?>    
                                    <div class="thumbnail" style="width: 30%;margin-bottom: 0px;">
        <img src="<?php echo USER_FOLDER.'/'.$project_messages_arr[$i]['admin_id'].'/'.stripslashes($project_messages_arr[$i]['avatar_image'])?>">	
                                        </div>
                                        
                                      <?php  } ?>  
                                       <?php if($project_messages_arr[$i]['user_role'] !=""){ ?>                                      
                                      (<?php echo  $project_messages_arr[$i]['user_role'];?>)
                                         
                                      <?php  } ?> 
                                         </strong>
                                        
                                         <br>
                                         <br> 
                                     <div id="jRate<?php echo $project_messages_arr[$i]['id']?>" style="height:33px;width: 100%;" title="Rating(<?php echo round($project_messages_arr[$i]['admin_rating'],2);?>)"></div>		 								
                                    <div class="text-small"> </div>
                                                                                
                                        <div class="text-small"> </div>
                                 
                                    
                                </div>
                                <div class="col-md-10">
                                    <p><?php echo stripcslashes(strip_tags($project_messages_arr[$i]['message'],'<b><br><a>')) ?></p>
                                    
                                    <?php  if(count($project_message_attachment_arr[$project_messages_arr[$i]['id']]) > 0){ 
									
									for($j=0; $j<count($project_message_attachment_arr[$project_messages_arr[$i]['id']]); $j++){
									
									?>
                                    
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
                              
                                <a class="anchor_style" href="<?php echo MURL?>assets/project_attachments/<?php echo $project_id."/".$project_message_attachment_arr[$project_messages_arr[$i]['id']][$j] ?>" target="_blank" download> <img src="<?php echo SURL?>assets/img/excel.png" style="height: 66px;" ></a>
                              
                            <?php }elseif($ext=='pptx' or $ext=='ppt'){ ?>
                              
                                <a class="anchor_style" href="<?php echo MURL?>assets/project_attachments/<?php echo $project_id."/".$project_message_attachment_arr[$project_messages_arr[$i]['id']][$j] ?>" target="_blank" download> <img src="<?php echo SURL?>assets/img/pptx.png" style="height: 69px;" ></a>
                              
                            <?php }elseif($ext=='odt'){ ?>
                              
                                <a class="anchor_style" href="<?php echo MURL?>assets/project_attachments/<?php echo $project_id."/".$project_message_attachment_arr[$project_messages_arr[$i]['id']][$j] ?>" target="_blank" download> <img src="<?php echo SURL?>assets/img/odt.png" style="height: 66px;" ></a>
                              
                            <?php }elseif($ext=='pdf'){ ?>
                              
                                <a class="anchor_style" href="<?php echo MURL?>assets/project_attachments/<?php echo $project_id."/".$project_message_attachment_arr[$project_messages_arr[$i]['id']][$j] ?>" target="_blank" download> <img src="<?php echo SURL?>assets/img/pdf.png" style="height: 69px;" ></a>        
                                <?php }elseif($ext=='txt'){ ?>
                              
                                <a class="anchor_style" href="<?php echo MURL?>assets/project_attachments/<?php echo $project_id."/".$project_message_attachment_arr[$project_messages_arr[$i]['id']][$j] ?>" target="_blank" download> <img src="<?php echo SURL?>assets/img/text.png" style="height: 69px;" ></a>        
                                <?php }elseif($ext=='tif'){ ?>
                              
                                <a class="anchor_style" href="<?php echo MURL?>assets/project_attachments/<?php echo $project_id."/".$project_message_attachment_arr[$project_messages_arr[$i]['id']][$j] ?>" target="_blank" download> <img src="<?php echo MURL?>assets/img/tiff2.png" style="height: 66px;" ></a>       
                                <?php }elseif($ext=='csv'){ ?>
                              
                                <a class="anchor_style" href="<?php echo MURL?>assets/project_attachments/<?php echo $project_id."/".$project_message_attachment_arr[$project_messages_arr[$i]['id']][$j] ?>" target="_blank" download> <img src="<?php echo SURL?>assets/img/csv.png" style="height: 66px;" ></a>       
                                <?php }  ?>
                                
                                
                              
                              
                            </div>
                            </div>
                           
                         
                              
                          <?php  
						  
						   }//End for loop
						  
						  
					      }//End if ?>
                                    
                                </div>
                            </div>
                        </div>
                        
                       
                        
                        
                        	<!--<tr id="<?php echo $row_id?>">
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
                              
                                <a class="anchor_style" href="<?php echo MURL?>assets/project_attachments/<?php echo $project_id."/".$project_message_attachment_arr[$project_messages_arr[$i]['id']][$j] ?>" target="_blank" download> <img src="<?php echo SURL?>assets/img/excel.png" style="height: 66px;" ></a>
                              
                            <?php }elseif($ext=='pptx' or $ext=='ppt'){ ?>
                              
                                <a class="anchor_style" href="<?php echo MURL?>assets/project_attachments/<?php echo $project_id."/".$project_message_attachment_arr[$project_messages_arr[$i]['id']][$j] ?>" target="_blank" download> <img src="<?php echo SURL?>assets/img/pptx.png" style="height: 69px;" ></a>
                              
                            <?php }elseif($ext=='odt'){ ?>
                              
                                <a class="anchor_style" href="<?php echo MURL?>assets/project_attachments/<?php echo $project_id."/".$project_message_attachment_arr[$project_messages_arr[$i]['id']][$j] ?>" target="_blank" download> <img src="<?php echo SURL?>assets/img/odt.png" style="height: 66px;" ></a>
                              
                            <?php }elseif($ext=='pdf'){ ?>
                              
                                <a class="anchor_style" href="<?php echo MURL?>assets/project_attachments/<?php echo $project_id."/".$project_message_attachment_arr[$project_messages_arr[$i]['id']][$j] ?>" target="_blank" download> <img src="<?php echo SURL?>assets/img/pdf.png" style="height: 69px;" ></a>        
                                <?php }elseif($ext=='txt'){ ?>
                              
                                <a class="anchor_style" href="<?php echo MURL?>assets/project_attachments/<?php echo $project_id."/".$project_message_attachment_arr[$project_messages_arr[$i]['id']][$j] ?>" target="_blank" download> <img src="<?php echo SURL?>assets/img/text.png" style="height: 69px;" ></a>        
                                <?php }elseif($ext=='tif'){ ?>
                              
                                <a class="anchor_style" href="<?php echo MURL?>assets/project_attachments/<?php echo $project_id."/".$project_message_attachment_arr[$project_messages_arr[$i]['id']][$j] ?>" target="_blank" download> <img src="<?php echo MURL?>assets/img/tiff2.png" style="height: 66px;" ></a>       
                                <?php }elseif($ext=='csv'){ ?>
                              
                                <a class="anchor_style" href="<?php echo MURL?>assets/project_attachments/<?php echo $project_id."/".$project_message_attachment_arr[$project_messages_arr[$i]['id']][$j] ?>" target="_blank" download> <img src="<?php echo SURL?>assets/img/csv.png" style="height: 66px;" ></a>       
                                <?php }  ?>
                                
                                
                              
                              
                            </div>
                            </div>
                           
                         
                              
                          <?php  
						  
						  
						   }//End for loop
						  
						  
						          }//End if ?>
                                    </div>
                                    
                          
                                 </td>
                                 
                             </tr> -->
                             
                         </div>    
                           
                            <?php
							
							
							 $msg_id =$project_messages_arr[$i]['id'];    
							  }//End for  ?> 
                            
                        <span id="<?php echo $msg_id; ?>" class="show_more" title="Load more posts">Show more</span>
                        <span class="loding" style="display: none;"><span class="loding_txt">Loading...</span></span>
                       
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
	
	
function CountdownTimer(gmt,tl,mes){
 this.initialize.apply(this,arguments);
}
CountdownTimer.prototype={
 initialize:function(gmt,tl,mes) {
  this.gmt = document.getElementById(gmt);
  this.tl = tl;
  this.mes = mes;
 },countDown:function(){
  var timer='';
  var today=new Date();
  var day=Math.floor((this.tl-today)/(24*60*60*1000));
  var hour=Math.floor(((this.tl-today)%(24*60*60*1000))/(60*60*1000));
  var min=Math.floor(((this.tl-today)%(24*60*60*1000))/(60*1000))%60;
  var sec=Math.floor(((this.tl-today)%(24*60*60*1000))/1000)%60%60;
  var me=this;

  if( ( this.tl - today ) > 0 ){
   timer += '<span class="number-wrapper"><div class="line"></div><div class="caption">DAYS</div><span class="number day">'+day+'</span></span>';
   timer += '<span class="number-wrapper"><div class="line"></div><div class="caption">HOURS</div><span class="number hour">'+hour+'</span></span>';
   timer += '<span class="number-wrapper"><div class="line"></div><div class="caption">MINS</div><span class="number min">'+this.addZero(min)+'</span></span><span class="number-wrapper"><div class="line"></div><div class="caption">SECS</div><span class="number sec">'+this.addZero(sec)+'</span></span>';
   this.gmt.innerHTML = timer;
   tid = setTimeout( function(){me.countDown();},10 );
  }else{
   this.gmt.innerHTML = this.mes;
   return;
  }
 },addZero:function(num){ return ('0'+num).slice(-2); }
}
function CDT(){

 // Set countdown limit
 var tl = new Date('<?php echo date("Y/m/d", strtotime($project_details_arr['end_date'])); ?>');

 // You can add time's up message here
 var timer = new CountdownTimer('CDT',tl,'<span class="number-wrapper"><div class="line"></div><span class="number end">Time is up!</span></span>');
 timer.countDown();
}
window.onload=function(){
 CDT();
}	
	
$(document).ready(function(){
	$(document).on('click','.show_more',function(){
		var ID = $(this).attr('id');
		$('.show_more').hide();
		$('.loding').show();
		$.ajax({
			type:'POST',
			url:'<?php echo base_url()?>projects/manage-projects/load-more/<?php echo $project_id?>',
			data:'id='+ID,
			success:function(data){
				$('#show_more_main'+ID).remove();
				$('#asdf').append(data);
				$("#<?php echo $row_id?>").after(data);
			}
		});
		
	});
});
</script>

</body>
</html>