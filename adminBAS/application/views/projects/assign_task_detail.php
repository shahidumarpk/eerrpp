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
                  <span class="glyphicon glyphicon"></span>Status : 
                   <?php  if($assign_task_arr['status']==0){ echo "New";}?>
                   <?php  if($assign_task_arr['status']==1){ echo "Start";}?>
                   <?php  if($assign_task_arr['status']==2){ echo "Hold";}?>
                   <?php  if($assign_task_arr['status']==3){ echo "Closed";}?>
                   <?php  if($assign_task_arr['status']==4){ echo "Resume";}?>
                 </div>
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
                    }//if($this->session->flashdata('ok_message')) ?>
                    
                <div class="panel-body">
                	<div class="media">
                    <div class="media-body">
                    <div class="media-content">
                  		<div class="form-horizontal">
                      	
                        <div class="row">
                          <div class="col-md-2"><strong>Assign To :</strong></div>
                          
                          <div class="col-lg-10"><strong><?php for($i=0; $i<count($assign_task_arr['assign_to']['name']); $i++){  ?>
						
                        <a class="anchor_style" href="<?php echo base_url()?>admin/manage-user/user-detail/<?php echo $assign_task_arr['assign_to']['user_id'][$i] ?>" title="Click to Project Detail" target="_blank">   
						<?php   echo  $assign_task_arr['assign_to']['name'][$i];?></a>&nbsp; &nbsp
						   
						   
						<?php   }?> </strong> </div>
                        
                        </div>
                        
                      	<div class="row">
                          <div class="col-md-2"><strong>Task Title :</strong></div>
                          <div class="col-lg-10"><strong> <?php echo  $assign_task_arr['title']; ?> </strong> </div>
                        </div>
                        
                        <div class="row">
                          <div class="col-md-2"><strong>Description :</strong></div>
                          <div class="col-lg-10">   <?php echo  stripcslashes(str_replace('\n','<br>',$assign_task_arr['description'])); ?>  </div>
                        </div>
                        
                        <div class="row">
                          <div class="col-md-2"><strong>Start Date :</strong></div>
                          <div class="col-lg-10"><strong><?php echo  date('d, M Y h:i:s a', strtotime($assign_task_arr['start_date'])); ?> </strong></div>
                        </div>
                        
                        
                         <div class="row">
                          <div class="col-md-2"><strong>End Date  :</strong></div>
                          <div class="col-lg-10"> 
                          <?php  
						  		
								//echo 'Original End Date:' . date('F j, Y', strtotime($assign_task_arr['end_date']));
								$end_date=strtotime($assign_task_arr['end_date']);
						  		$today=strtotime(date('F j, Y'));
								if($today > $end_date){
										
									echo '<span  style="color: red; font-weight:bold;">'.date('d, M Y h:i:s a', $end_date).'</span>';
								}else{
									echo '<span  style="color: green; font-weight:bold;">'.date('d, M Y h:i:s a', $end_date).'</span>';
								}
						  
						  
						  ?>
                            </div>
                        </div>
                        
                        
                         <div class="row">
                          <div class="col-md-2"><strong style="color: #F30807;">Task Total Time :</strong></div>
                          <div class="col-lg-10">
                          <strong style="color: #F30807;">
                          
						  <?php 
						  
						   if($assign_task_arr['total_time'] >=60){ 
								 
								   $total_hours+= floor($assign_task_arr['total_time'] / 60);
								 
								   echo  $hours = floor($assign_task_arr['total_time'] / 60)." Hours";
								   
								 }else{
									 
									$total_mints+= $assign_task_arr['total_time'];
									 
									echo  $assign_task_arr['total_time']." Mints";
									 
								} 
						 ?> 
                          
                          
                        </strong></div>
                        </div>
                        
                        <div class="row">
                          <label class="col-lg-2"><strong>Project Name:</strong></label>
                          <div class="col-lg-10"><strong>
                       <a class="anchor_style" href="<?php echo base_url()?>projects/manage-projects/project-detail/<?php echo $assign_task_arr['project_id'] ?>" title="Click to Project Detail" target="_blank">  <?php echo $assign_task_arr['project_title']; ?></a>
                          </strong></div>
                        </div>
                        
                        <div class="row">
                          <div class="col-md-2"><strong>Assign By :</strong></div>
                          <div class="col-lg-10"><strong>  <a class="anchor_style" href="<?php echo base_url()?>admin/manage-user/user-detail/<?php echo $assign_task_arr['assign_by_id'] ?>" title="Click to Project Detail" target="_blank"><?php echo  $assign_task_arr['assign_by']; ?></strong> </a> </div>
                        </div>
                        
                        <?php if($assign_task_arr['rating_status']==1){ ?>
                        <div class="row">
                          <div class="col-md-2"><strong>Awarded Rating :</strong></div>
                          <div class="col-lg-10"><strong><?php echo  $assign_task_arr['rating'];?></strong></div>
                        </div>
                      <?php } ?>  
                       
                    </div>
                    </div>
                    </div>
                  </div>
                    <div class="clearfix">&nbsp;</div>
                 <?php if($assign_task_attachments_count >0){ ?>    
                 <div class="well">
                 <div class="panel-body alerts-panel">
                     <div class="row">
                      <label for="page_title">Task Attachments </label><br>
                 
					  <?php for($i=0; $i<$assign_task_attachments_count; $i++) { ?>
                      
                       <div class="col-md-2">
                            <div class="thumbnail" style="width: 87px;height: 85px;">
                
							<?php 
                             $ext = pathinfo($assign_task_attachments[$i]['attachment_name'], PATHINFO_EXTENSION) ;
                            
                            if($ext=='jpg' or $ext=='png') {?>
                             <a href="<?php echo MURL?>assets/project_attachments/<?php echo $assign_task_arr['project_id']."/project_task/".$assign_task_attachments[$i]['attachment_name'] ?>" style="margin-left: -14px;width:136%;" data-toggle="lightbox" data-gallery="multiimages" data-title="<?php echo $project_attachments_arr[$i]['title'] ?>" class="col-sm-4">
                             
                             <img src="<?php echo MURL?>assets/project_attachments/<?php echo $assign_task_arr['project_id']."/project_task/".$assign_task_attachments[$i]['attachment_name'] ?>" data-src="holder.js/100%x180" data-holder-rendered="false" style="width: 113px;">
                             </a>
                            <?php }elseif($ext=='zip' or $ext=='rar'){ ?>
                              
                                <a class="anchor_style" href="<?php echo MURL?>assets/project_attachments/<?php echo $assign_task_arr['project_id']."/project_task/".$assign_task_attachments[$i]['attachment_name'] ?>" target="_blank" download> <img src="<?php echo SURL?>assets/img/zip.png" style="height: 62px;" ></a>
                              
                              <?php }elseif($ext=='pdf'){ ?>
                              
                                <a class="anchor_style" href="<?php echo MURL?>assets/project_attachments/<?php echo $assign_task_arr['project_id']."/project_task/".$assign_task_attachments[$i]['attachment_name'] ?>" target="_blank" download> <img src="<?php echo SURL?>assets/img/pdf.png" style="height: 62px;" ></a>
                                <?php }elseif($ext=='doc' or $ext=='docx'){ ?>
                              
                                <a class="anchor_style" href="<?php echo MURL?>assets/project_attachments/<?php echo $assign_task_arr['project_id']."/project_task/".$assign_task_attachments[$i]['attachment_name'] ?>" target="_blank" download> <img src="<?php echo SURL?>assets/img/docx.png" style="height: 62px;" ></a>
                                <?php  }elseif($ext=='xlsx' or $ext=='xls'){ ?>
                              
                                <a class="anchor_style" href="<?php echo MURL?>assets/project_attachments/<?php echo $project_id."/".$project_attachments_arr[$i]['attachment_name'] ?>" target="_blank" download> <img src="<?php echo SURL?>assets/img/excel.png" style="height: 66px;" ></a>
                              
                            <?php }elseif($ext=='odt'){ ?>
                              
                                <a class="anchor_style" href="<?php echo MURL?>assets/project_attachments/<?php echo $assign_task_arr['project_id']."/project_task/".$assign_task_attachments[$i]['attachment_name'] ?>" target="_blank" download> <img src="<?php echo SURL?>assets/img/odt.png" style="height: 69px;" ></a>
                              
                            <?php }
							elseif($ext=='pptx' or $ext=='ppt'){ ?>
                              
                                <a class="anchor_style" href="<?php echo MURL?>assets/project_attachments/<?php echo $assign_task_arr['project_id']."/project_task/".$assign_task_attachments[$i]['attachment_name'] ?>" target="_blank" download> <img src="<?php echo SURL?>assets/img/pptx.png" style="height: 69px;" ></a>
                              
                            <?php }elseif($ext=='txt'){ ?>
                              
                                <a class="anchor_style" href="<?php echo MURL?>assets/project_attachments/<?php echo $assign_task_arr['project_id']."/project_task/".$assign_task_attachments[$i]['attachment_name'] ?>" target="_blank" download> <img src="<?php echo SURL?>assets/img/text.png" style="height: 62px;" ></a> 
                                
                                <?php } elseif($ext=='csv'){ ?>
                              
                                <a class="anchor_style" href="<?php echo MURL?>assets/project_attachments/<?php echo $assign_task_arr['project_id']."/project_task/".$assign_task_attachments[$i]['attachment_name'] ?>" target="_blank" download> <img src="<?php echo SURL?>assets/img/csv.png" style="height: 62px;" ></a> 
                                <?php  } ?>
                              
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
                  <?php } ?>
                  
           <?php 
		 
		   $team_arr=$assign_task_arr['assign_to']['user_id'];
		   $user_id= $this->session->userdata('admin_id'); 
		   
		   if(in_array($user_id, $team_arr)){
			   
		    ?>       
               
				   <?php if($assign_task_arr['status'] !=3){?>
                    <div class="well">
                        
                     <?php  if($assign_task_arr['status']==0){ ?>
                     
                     <a href="<?php echo base_url()?>projects/manage-projects/update-task-status/1/<?php echo $assign_task_id; ?>" onClick="return confirm('Are you sure you want to Update?')" title="Click to Start Task"><span class="label btn-success">Start</span>  </a>
                     
                     <?php } ?>
                     
                      <?php  if($assign_task_arr['status']==2){ ?>
                     
                     <a href="<?php echo base_url()?>projects/manage-projects/update-task-status/4/<?php echo $assign_task_id; ?>" onClick="return confirm('Are you sure you want to Update?')" title="Click to Start Task"><span class="label btn-success">Resume</span>  </a>
                     
                     <?php } ?>
                     
                      <?php  if($assign_task_arr['status']!=2){ ?>
                     <span class="label btn-success" onClick="change_account()" id="hold" style="cursor:pointer" title="Click to Hold Task">Hold</span><?php } ?>
                     
                      <?php  if($assign_task_arr['status']!=3){ ?>
                     <a href="<?php echo base_url()?>projects/manage-projects/update-task-status/3/<?php echo $assign_task_id; ?>" onClick="return confirm('Are you sure you want to Update?')"  title="Click to Closed Task"> <span class="label btn-success">Closed</span> </a>      
                     <?php } ?>
                        </div>
                   <?php } ?>  
                    
                    <div id="input_hold" style="display:none;">
                    <form class="wpcf7" id="add_new_slider_image_frm" method="POST" action="<?php echo SURL?>projects/manage-projects/update-task-status/2/<?php echo $assign_task_id; ?>" enctype="multipart/form-data">
                    	 <div class="form-group">
                        <label for="hold_reason">Enter Hold Reason</label>
                        <input id="hold_reason" name="hold_reason" type="text" class="form-control" placeholder="Hold reason" value="<?php echo $session_post_data['tech_name'] ?>" required/>
                      </div>
                      
                      <div class="form-group" align="right" style="margin-right:17px">
                        <input class="submit btn btn-blue" type="submit" name="submit" id="submit" value="Submit Hold Reason"  title="Submit Reason"/>
                    </div>
                    </form>   
                    </div>
                  
            <?php } ?> 
            
             <?php
				if($assign_task_arr['rating_status'] ==1){
				 
                  if($ALLOW_task_approve == 1 && $assign_task_arr['status'] ==3 ){
					  
					$task_started_date= $assign_task_arr['task_started_date']; 
					$task_close_date= $assign_task_arr['task_close_date']; 
					 
					$datetime1 = strtotime($task_started_date);
					$datetime2 = strtotime($task_close_date);
					$interval  = abs($datetime2 - $datetime1);
				 	$minutes   = round($interval / 60);
					 
					 
					/* $subTime = strtotime($task_close_date) - strtotime($task_end_date);
	
						$y = ($subTime/(60*60*24*365));
						$d = ($subTime/(60*60*24))%365;
						$h = ($subTime/(60*60))%24;
						$m = ($subTime/60)%60;*/
						
						
				?>
                   
                        <div class="well">
                        <p><strong>Task Rating</strong></p>
                        <p>Awarded <b><?php  echo $assign_task_arr['rating'];?></b> Rating  by the system<br> Time Difference<br> 
						
					  <?php 
					  
					   if($minutes >=60){
						   
								    $hours = floor($minutes / 60);
									 
									$mints = ($minutes % 60);
									 
									if($hours !=""){
									  $hoursstr=" Hours ";	
									}
									
									if($hours !="" and $mints !=""){
										
										$and=" and ";
									}
									
									if($mints !=""){
										
									  $mintstr=" Mints";	
										
									}
									 
									 echo  $hours.$hoursstr.$and.$mints.$mintstr;
								   
						}else{
									 
								
									echo  $minutes." Mints";
									 
						} 
					  
					 "<br>"?><strong> </strong></p>
                        <!--<a href="<?php echo base_url()?>projects/manage-projects/approve-task-rating/<?php echo $assign_task_id;?>" type="button" class="btn btn-info btn-gradient" onClick="return confirm('Are you sure you want to  approve rating?')">Approve Rating</a>      -->
                        
                         <a href="<?php echo base_url()?>projects/manage-projects/not-approve-task-rating/<?php echo $assign_task_id;?>" onClick="return confirm('Are you sure you want to not approve rating?')" type="button" class="btn btn-danger btn-gradient" title="Delete Task">Reject</a>    
                            
                        
                        </div> 
               <?php } }?> 
                 
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

/*function change_account(){
	
	var hold=document.getElementById('hold').innerHTML;
	
		
	if(hold == 'Hold'){
		document.getElementById('personaldata').style.display = '';
		document.getElementById('businessdata').style.display = 'none';
		
	}*/
	
	
$('#hold').click(function() {
	
	$('#input_hold').toggle('fast');
	
});
	


</script>
</body>
</html>