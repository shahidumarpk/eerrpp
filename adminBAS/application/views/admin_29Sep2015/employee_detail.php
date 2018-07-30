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
                              <td><strong>Last SignIn Date:</strong></td>
                              <td> <?php echo date('d, M Y h:i:s a', strtotime($admin_user_data['last_signin_date']) ) ?></td>
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
        </div>
        
        
       <?php if($ALLOW_employment_detail==1){ ?>
       
        <div class="col-md-6 col-lg-6">
        
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
                              <td><strong>Salar:</strong></td>
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
        
        <div class="clearfix"></div>
        
        </div>
        
        <?php  } ?> 
        
      </div>
      
      
      <div class="clearfix">&nbsp;</div>
      
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

</body>
</html>
