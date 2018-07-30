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
<header class="navbar navbar-fixed-top"><?php echo $INC_top_header; ?> </header>
<!-- End: Header --> 
<!-- Start: Main -->
<div id="main"> 
  <!-- Start: Sidebar --> 
  <?php echo $INC_left_nav_panel; ?> 
  <!-- End: Sidebar --> 
  <!-- Start: Content -->
  <section id="content"> <?php echo $INC_breadcrum?>
    <div class="container" style="min-height:1300px;">
      <div class="row">
        <div class="col-md-6 col-lg-6">
          <div class="row">
            <div class="col-md-12">
              <div class="panel profile-panel">
                <div class="panel-heading panel-visible">
                  <div class="panel-title"> <span class="glyphicon glyphicon-user"></span> User Profile -</div>
                  
                  <span class="panel-title-sm pull-left text-success" style="color: #7ec35d; padding-left: 7px; padding-top: 2px;"> Online</span>
                  <div class="panel-btns pull-right margin-left">
                    <div class="btn-group">
                      <button type="button" class="btn btn-default btn-gradient dropdown-toggle" data-toggle="dropdown"><span class="glyphicons glyphicons-cogwheel"></span></button>
                      <ul class="dropdown-menu checkbox-persist pull-right text-left" role="menu">
                        
                        <li><a href="<?php echo SURL;?>admin/manage-user/edit-user/<?php echo $admin_user_data['id'];?>"><i class="fa fa-user"></i> Edit Profile </a></li>
                      </ul>
                    </div>
                  </div>
                </div>
                <div class="panel-body">
                  <div class="row">
                    <div class="col-xs-3" id="profile-avatar"> 
                    <?php if($admin_user_data['profile_image']==""){?>
                    <img src="<?php  echo MURL."assets/empty.gif"?>" class="img-responsive" width="150" height="150" alt="avatar"/><?php }else{ ?>
                    <img src="<?php  echo USER_FOLDER.'/'.$admin_user_data['id']."/".$admin_user_data['profile_image']; ?>" class="img-responsive" width="150" height="150" alt="avatar"/>
                    <?php } ?><br>

                    
                   <div id="jRate" style="height:50px;width: 200px;" title="<?php echo round($average_rating,2);  ?>"></div>
				   
                   
                   </div>
                    
                    <div class="col-xs-9">
                    <table class="table table-striped">
                          <tbody>
                            <tr>
                              <td><strong>Name:</strong></td>
                              <td><?php echo $admin_user_data['first_name']." ".$admin_user_data['last_name']; ?></td>
                            </tr>
                           
                            <tr>
                              <td><strong>User Name:</strong></td>
                              <td> <?php echo $admin_user_data['username']; ?></td>
                            </tr>
                            <tr>
                              <td><strong>Email:</strong></td>
                              <td> <?php echo $admin_user_data['email_address']; ?></td>
                            </tr>
                            <tr>
                              <td><strong>Status:</strong></td>
                              <td> <?php  if($admin_user_data['status']==1){ ?>Active<?php } ?>
                              <?php  if($admin_user_data['status']==0){ ?>InActive<?php } ?></td>
                            </tr>
                             
                            
                             <tr>
                              <td><strong>Last SignIn Date:</strong></td>
                              <td> <?php echo date('Y-m-d G:i:s', strtotime($admin_user_data['last_signin_date']) ) ?></td>
                            </tr>
                            <tr>
                              <td><strong>Start Time:</strong></td>
                              <td> <?php echo date('G:i:s', strtotime($admin_user_data['start_time']) ) ?></td>
                            </tr>
                            <tr>
                              <td><strong>Unread Notification:</strong></td>
                              <td> <?php echo $admin_unread_count ?></td>
                            </tr>
                            <!-- <tr>
                              <td><strong>Average Rating:</strong></td>
                              <td><b>
							 
							  
							  </b></td>
                            </tr>-->
                            
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
          <div class="row">
            <div class="col-md-12">
              <div class="panel profile-panel">
                <div class="panel-heading panel-visible">
                  <div class="panel-title"> <span class="glyphicon glyphicon-user"></span>Contact Info</div>
                  
                  <span class="panel-title-sm pull-left text-success" style="color: #7ec35d; padding-left: 7px; padding-top: 2px;"></span>
                  <div class="panel-btns pull-right margin-left">
                    
                  </div>
                </div>
                <div class="panel-body">
                  <div class="row">
                    <div class="col-xs-12">
                    <table class="table table-striped">
                          <tbody>
                            <tr>
                              <td><strong>Contact No :</strong></td>
                              <td><?php echo $admin_contact_data['phone'];?>
							 </td>
                            </tr>
                           
                            <tr>
                              <td><strong>Emergency Contact No:</strong></td>
                              <td> <?php 
							  	echo $admin_contact_data['emergency_phone'];
								?></td>
                            </tr>
                            <tr>
                              <td><strong>Address:</strong></td>
                              <td> <?php
							
							  echo $admin_contact_data['address'];
							 
							   ?></td>
                            </tr>
                            <tr>
                              <td><strong>City Name:</strong></td>
                              <td> <?php echo $admin_user_data['city_name']; ?></td>
                            </tr>
                             <tr>
                              <td><strong>State Name:</strong></td>
                              <td> <?php echo $admin_user_data['state_name']; ?></td>
                            </tr>
                             <tr>
                              <td><strong>Country:</strong></td>
                              <td> <?php echo $admin_user_data['country']; ?></td>
                            </tr>
                             <tr>
                              <td><strong>Zip:</strong></td>
                              <td> <?php echo $admin_user_data['zip']; ?></td>
                            </tr>
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
          <div class="row">
            <div class="col-md-12">
              <div class="panel profile-panel">
                <div class="panel-heading panel-visible">
                  <div class="panel-title"> <span class="glyphicon glyphicon-user"></span>Bank Info</div>
                  
                  <span class="panel-title-sm pull-left text-success" style="color: #7ec35d; padding-left: 7px; padding-top: 2px;"></span>
                  <div class="panel-btns pull-right margin-left">
                    
                  </div>
                </div>
                <div class="panel-body">
                  <div class="row">
                    <div class="col-xs-12">
                    <table class="table table-striped">
                          <tbody>
                            
                           
                            <tr>
                              <td><strong>Bank Name:</strong></td>
                              <td> <?php 
							  	echo $admin_bank_data['bank_name'];
								?></td>
                            </tr>
                            <tr>
                              <td><strong>Branch Code:</strong></td>
                              <td> <?php
							  
							
							  echo $admin_bank_data['branch_code'];
							
							
							   ?></td>
                            </tr>
                            <tr>
                              <td><strong>Account No. :</strong></td>
                              <td> <?php
							  
							
							  echo $admin_bank_data['account#'];
							
							
							   ?></td>
                            </tr>
                             <tr>
                              <td><strong>Ibn No. :</strong></td>
                              <td> <?php
							  
							
							  echo $admin_bank_data['ibn#'];
							
							
							   ?></td>
                            </tr>
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
          <?php if($ALLOW_employment_detail==1){ ?>
          
          <div class="row">
            <div class="col-md-12">
              <div class="panel profile-panel">
                <div class="panel-heading panel-visible">
                  <div class="panel-title"> <span class="glyphicon glyphicon-user"></span>Employment Record</div>
                  
                  <span class="panel-title-sm pull-left text-success" style="color: #7ec35d; padding-left: 7px; padding-top: 2px;"></span>
                  <div class="panel-btns pull-right margin-left">
                    
                  </div>
                </div>
                <div class="panel-body">
                  <div class="row">
                    <div class="col-xs-12">
                    <table class="table table-striped">
                          <tbody>
                            <tr>
                              <td><strong>Salary:</strong></td>
                              <td><?php 
							  
							  if($admin_user_data['salary'] !=""){
								  
							  	echo number_format($admin_user_data['salary'],2,".",","); 
							  
							  }
							  ?></td>
                            </tr>
                           
                            <tr>
                              <td><strong>NIC:</strong></td>
                              <td> <?php echo $admin_user_data['nic']; ?></td>
                            </tr>
                            <tr>
                              <td><strong>Date of Birth:</strong></td>
                              <td> <?php echo date('d, M Y', strtotime($admin_user_data['dob'])); ?></td>
                            </tr>
                            <tr>
                              <td><strong>Join Date:</strong></td>
                              <td> <?php echo date('d, M Y', strtotime($admin_user_data['join_date'])); ?></td>
                            </tr>
                             <tr>
                              <td><strong>Last Increament:</strong></td>
                              <td> <?php echo date('d, M Y', strtotime($admin_user_data['last_increament'])); ?></td>
                            </tr>
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
          
          <?php  } ?>
        </div>
        
        <div class="col-md-6 col-lg-6">
       <!-- New Document section  -->  
       <div class="col-md-12">
          <div class="panel">
            <div class="panel-heading">
              <div class="panel-title"> <span class="glyphicon glyphicon-list-alt"></span>Letters Section</div>
              <div class="pull-right"> 	
              </div>
             
            </div>
            <div class="panel-body">
              <div class="table-responsive">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th>Appoinment Letter <?php if($admin_user_data['appointment_letter']==1){ ?><img src="<?php echo IMG?>check.png" width="20" height="20"><?php } ?></th>
                      <th><a href="<?php echo SURL?>admin/manage-user/print-letter/<?php echo $user_id;?>/appointment" type='button' class='btn btn-info btn-gradient'>Print Letter </a></th>
                    </tr>
                    <tr>
                      <th>Bank Oppening Letter  <?php if($admin_user_data['bank_oppening_letter']==1){ ?><img src="<?php echo IMG?>check.png" width="20" height="20"><?php } ?></th>
                      <th><a href="<?php echo SURL?>admin/manage-user/print-letter/<?php echo $user_id;?>/bank" type='button' class='btn btn-info btn-gradient'>Print Letter </a></th>
                    </tr>
                    <tr>
                      <th>User Access Letter  <?php if($admin_user_data['user_access_letter']==1){ ?><img src="<?php echo IMG?>check.png" width="20" height="20"><?php } ?></th>
                      <th><a href="<?php echo SURL?>admin/manage-user/print-letter/<?php echo $user_id;?>/access" type='button' class='btn btn-info btn-gradient'>Print Letter </a></th>
                    </tr>
                    
                  
                   <tr>
                      <th>Status</th>
                      <th><span id="status_response">
                      <?php if($admin_user_data['status']==0){ ?>
                      <button value="1" class='btn btn-info btn-gradient ' onClick="change_status_active()" title="Click to Active user status">Active </button>
                      <?php }else{ ?>
                      <button value='0' class='btn btn-danger btn-gradient ' onClick="change_status_inactive()"  title="Click to InActive user status">InActive</button>
                      <?php } ?>
                      
                      </span></th>
                   </tr>
                    
                  </thead>
                  <tbody>
                </tbody>
                </table>
              </div>
              
            </div>
          </div>
        </div> 
        <!-- End document section-->
        
         <div class="col-md-12">
          <div class="panel">
            <div class="panel-heading">
              <div class="panel-title"> <span class="glyphicon glyphicon-list-alt"></span>Task List</div>
              <div class="pull-right"> 	
              </div>
              <div id="test-popup" class="white-popup mfp-hide">
                  Popup content
              </div>
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
                  </thead>
                  <tbody>
                    <tr>
                      <td>
                      <?php if($total_tasks>0){ ?>
                      <a class="anchor_style" href="<?php echo base_url()?>projects/manage-projects/manage-user-task/<?php echo $user_id;?>/0" title="Click to View Task Details" target="_blank">
					  <?php } ?>
					  <?php echo $total_tasks ; ?></a></td>
                      
                      
                      <td>
                      <?php if($open_tasks>0){ ?><a class="anchor_style" href="<?php echo base_url()?>projects/manage-projects/manage-user-task/<?php echo $user_id;?>/1" title="Click to View Task Details" target="_blank">
					  <?php } ?>
					  <?php echo $open_tasks ; ?></a></td>
                      
                      <td>
                      <?php if($hold_tasks>0){ ?>
                      <a class="anchor_style" href="<?php echo base_url()?>projects/manage-projects/manage-user-task/<?php echo $user_id;?>/2" title="Click to View Task Details" target="_blank">
					  <?php } ?>
					  <?php echo $hold_tasks ; ?></a></td>
                      
                      
                       <td>
                       <?php if($closed_tasks>0){ ?>
                       <a class="anchor_style" href="<?php echo base_url()?>projects/manage-projects/manage-user-task/<?php echo $user_id;?>/3" title="Click to View Task Details" target="_blank">
					   <?php } ?>
					   <?php echo $closed_tasks ; ?></a></td>
                    </tr>
              
                </tbody>
                </table>
              </div>
              
            </div>
          </div>
        </div>
        
         <div class="col-md-12">
          <div class="panel">
            <div class="panel-heading">
              <div class="panel-title"> <span class="glyphicon glyphicon-list-alt"></span>Task Completion Report</div>
              <div class="pull-right"> 	
              </div>
              <div id="test-popup" class="white-popup mfp-hide">
                  Popup content
              </div>
            </div>
            <div class="panel-body">
              <div class="table-responsive">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th>OnTime Start</th>
                      
                      <th>OnTime Closed</th>
                    </tr>
                  </thead>
                  <tbody>
                  
                    <tr>
                      <td><b> <?php echo $ontime_start ; ?></b></td>
                       <td><b> <?php echo $ontime_closed ; ?></b></td>
                    </tr>
              
                </tbody>
                </table>
               
              <br>
        
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th>LateTime Start</th>
                      
                      <th>LateTime Closed</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      
                      <td><b><?php echo $after_time_start ; ?></b></td>
                      <td><b><?php echo $after_time_closed ; ?></b></td>
                       
                    </tr>
              
                </tbody>
                </table>
              </div>
              
            </div>
          </div>
        </div>
          
         <div class="col-md-12">
          <div class="panel">
            <div class="panel-heading">
              <div class="panel-title"> <span class="glyphicon glyphicon-list-alt"></span>Projects</div>
              <div class="pull-right"> 	
              </div>
              <div id="test-popup" class="white-popup mfp-hide">
                  Popup content
              </div>
            </div>
            <div class="panel-body">
              <div class="table-responsive">
               <?php if($total_projects>0){ ?>
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th>Total Projects</th>
                      <th>InProgress</th>
                      <th>Cancel</th>
                      <th>Closed</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>
                      <?php if($total_projects>0){ ?>
                      <a class="anchor_style" href="<?php echo base_url()?>admin/manage-user/user-detail/<?php echo $user_id;?>/0" title="Click to View Project Details">
					  <?php } ?>
					  <?php echo $total_projects ; ?></a></td>
                      
                      
                      <td>
                      <?php if($open_projects>0){ ?>
                      <a class="anchor_style" href="<?php echo base_url()?>admin/manage-user/user-detail/<?php echo $user_id;?>/1" title="Click to View Project Details">
					  <?php } ?>
					  <?php echo $open_projects ; ?></a></td>
                      
                      <td>
                       <?php if($cancel_projects>0){ ?>
                      <a class="anchor_style" href="<?php echo base_url()?>admin/manage-user/user-detail/<?php echo $user_id;?>/2" title="Click to View Project Details">
					  <?php } ?>
					  <?php echo $cancel_projects ; ?></a></td>
                      
                      
                       <td>
                      <?php if($closed_projects>0){ ?>
                      <a class="anchor_style" href="<?php echo base_url()?>admin/manage-user/user-detail/<?php echo $user_id;?>/3" title="Click to View Project Details">
					  <?php } ?>
					   <?php echo $closed_projects ; ?></a></td>
                    </tr>
              
                </tbody>
                </table>
                <?php }else{echo "<span style='color:red;font-weight:bold;'>No Projects Found...!</span>";} ?>
              </div>
              
            </div>
          </div>
        </div>
        <div class="clearfix"></div>
        
        </div>
      </div>
      <div class="clearfix">&nbsp;</div>
      <div class="row">
       <div class="col-md-12">
          <div class="panel">
            <div class="panel-heading">
              <div class="panel-title"> <span class="glyphicon glyphicon-list-alt"></span>Projects list</div>
              <div class="pull-right"> 	
              </div>
              
            </div>
            <div class="panel-body">
              <div class="table-responsive">
              <?php  if($projects_count>0){ ?>
                <table class="table table-striped table-bordered table-hover" id="manage_user_projects">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Project Title</th>
                      <th>Start Date</th>
                      <th>End Data</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>
                 <?php 
				for($i=0;$i<$projects_count;$i++){
					$counter = $i+1 ; 
				 ?>
                    <tr>
                      <td><?php echo $counter ; ?></td>
                      <td><a class="anchor_style" href="<?php echo base_url()?>projects/manage-projects/project-detail/<?php echo $projects_arr[$i]['id'] ?>"  target="_blank"><?php echo stripslashes($projects_arr[$i]['project_title']) ; ?></a></td>
                      <td><?php echo date('d, M Y', strtotime($projects_arr[$i]['start_date'])) ; ?></td>
                      <td><?php echo date('d, M Y', strtotime($projects_arr[$i]['end_date'])) ; ?></td>
                      <td><?php if($projects_arr[$i]['status']==0){echo "New";} 
	                            if($projects_arr[$i]['status']==1){echo "InProgress";}
	                            if($projects_arr[$i]['status']==2){echo "Cancel";}
	                            if($projects_arr[$i]['status']==3){echo "Closed";} ?></td>
                    </tr>
                <?php }   ?>   
                </tbody>
                </table>
             <?php }else{echo "<span style='color:red;font-weight:bold;'>No Projects Found...!</span>";} ?>   
              </div>
            </div>
          </div>
       </div>
       </div>
     <!-- <div class="row" style="min-height:250px;">&nbsp;</div> -->
    </div>
  </section>
  <!-- End: Content --> 
  
</div>

<div class="modal fade" id="mailmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Send Message</h4>
      </div>
      <div class="modal-body">
        <form action="manage-user/send-message" enctype="multipart/form-data" method="post">
         
           <div class="form-group">
           
           
                        <label for="subject">Subject*</label>
                        <input id="subject" name="subject" type="text" class="form-control"  value="" required/>
                      </div>
                      
                      
                      <div class="form-group">
                      <label for="message">Message*</label>
                      <textarea class="form-control" id="message" name="message" rows="8"></textarea>
                    </div>
                    
                     <div class="form-group">
                       <label for="page_title">Attach File </label>
						 <input type="file" id="attachment" name="attachment">
                          <span class="help-block margin-top-sm"><i class="fa fa-bell"></i> 
                                - Allowed Extensions: jpg,jpeg,gif,tiff,png,doc,zip,rar,docx,xlsx
                            </span>
                            <span class="help-block margin-top-sm"><i class="fa fa-bell"></i> 
                                Max Upload Size: 5MB;
                            </span>
                         
                     </div>
          
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
         <input type="hidden" id="userid" value="" name="user_id">
       
        <button id="submitMail" type="submit" class="btn btn-primary">Send</button>
     
      </div>
         </form>
     
    </div>
  </div>
</div>
<!-- End: Main --> 
<!-- Start: Footer -->
<footer> <?php echo $INC_footer;?> </footer>
<!-- End: Footer --> 
<?php echo $INC_header_script_footer;?>


<script type="application/javascript">
	$('#manage_user_projects').dataTable({
		"aoColumnDefs": [{ 'bSortable': false, 'aTargets': [ -1,-4,-5 ] }],
		"aaSorting": [],
		"oLanguage": { "oPaginate": {"sPrevious": "", "sNext": ""} },
		"iDisplayLength": 25,
		"bPaginate": true,
		"bLengthChange": true,
		"bFilter": true,
		"aLengthMenu": [[25, 50, 75,100], [25, 50, 75,100]],
		"sDom": 'T<"panel-menu dt-panelmenu"lfr><"clearfix">tip',
		"oTableTools": {
			"sSwfPath": "<?php echo VENDOR ?>plugins/datatables/extras/TableTools/media/swf/copy_csv_xls_pdf.swf"
		}
		
	});	
</script>

<script src="<?php echo JS?>jRate.min.js"></script>
<script type="text/javascript">
		$(function () {
			var that = this;
			$("#jRate").jRate({
				rating: <?php echo $average_rating;  ?>,
				strokeColor: 'black',
				width: 23,
				height: 20,
				readOnly: true
				
			});
			
		});
</script> 

<script>
function change_status_active(){
	
    $.ajax
    ({ 
        url: '<?php echo SURL?>admin/manage-user/change-status-active/<?php echo $user_id;?>',
        type: 'post',
        success: function(result)
        {
           
		   // jQuery("#state_response").html(split_response[0]);
		    $('#status_response').html(result).fadeIn(2000, function() 
            {
                setTimeout(function() 
                {
                   // $('#status_response').fadeOut();
                }, 2000);
            });
        }
    });
}

function change_status_inactive(){
	
    $.ajax
    ({ 
        url: '<?php echo SURL?>admin/manage-user/change-status-inactive/<?php echo $user_id;?>',
        type: 'post',
        success: function(result)
        {
           
		   // jQuery("#state_response").html(split_response[0]);
		    $('#status_response').html(result).fadeIn(2000, function() 
            {
                setTimeout(function() 
                {
                  //  $('#status_response').fadeOut();
                }, 2000);
            });
        }
    });
}

</script>   

</body>
</html>
