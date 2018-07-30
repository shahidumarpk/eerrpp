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
    <div class="container" style="min-height:1370px;">
      <div class="row">
        <div class="col-md-6 col-lg-6">
          <div class="row">
            <div class="col-md-12">
              <div class="panel profile-panel">
                <div class="panel-heading panel-visible">
                  <div class="panel-title"> <span class="glyphicon glyphicon-user"></span> Customer Profile -</div>
                  
                  <span class="panel-title-sm pull-left text-success" style="color: #7ec35d; padding-left: 7px; padding-top: 2px;"> Online</span>
                  <div class="panel-btns pull-right margin-left">
                    <div class="btn-group">
                      <button type="button" class="btn btn-default btn-gradient dropdown-toggle" data-toggle="dropdown"><span class="glyphicons glyphicons-cogwheel"></span></button>
                      <ul class="dropdown-menu checkbox-persist pull-right text-left" role="menu">
                        
                        <li><a href="<?php echo base_url()?>customers/manage-customers/edit-customer/<?php echo $customer_user_data['id'] ?>" title="Edit customer"><i class="fa fa-user"></i> Edit Profile </a></li>
                      </ul>
                    </div>
                  </div>
                </div>
                <div class="panel-body">
                  <div class="row">
                    <div class="col-xs-3" id="profile-avatar"> 
                     <?php 
					if($customer_user_data['profile_image'] ==""){
					?>
                    
                    <img src="<?php  echo MURL."assets/empty.gif"?>" class="img-responsive" width="150" height="150" alt="avatar"/>
                     
                      <?php }else{//end if?>
                       <img src="<?php  echo CUSTOMER_FOLDER.'/'.$customer_user_data['id']."/".$customer_user_data['profile_image']; ?>" class="img-responsive" width="150" height="150" alt="avatar"/>
                      
                       <?php } ?>
                   </div>
                    <div class="col-xs-9">
                    
                    <table class="table table-striped">
                          <tbody>
                            <tr>
                              <td><strong>Name:</strong></td>
                              <td> <?php echo stripslashes($customer_user_data['first_name'])." ".stripslashes($customer_user_data['last_name']); ?></td>
                            </tr>
                            
                            <tr>
                              <td><strong>User Name:</strong></td>
                              <td> <?php echo stripslashes($customer_user_data['username']) ?></td>
                            </tr>
                            <tr>
                              <td><strong>Email:</strong></td>
                              <td> <?php echo stripslashes($customer_user_data['email_address']) ?></td>
                            </tr>
                            <tr>
                              <td><strong>Account Type:</strong></td>
                              <td> <?php echo stripslashes($customer_user_data['account_type']) ?></td>
                            </tr>
                            <tr>
                              <td><strong>Technical Person Name:</strong></td>
                              <td> <?php echo $customer_user_data['tech_name'] ?></td>
                            </tr>
                            <tr>
                              <td><strong>Technical Person Phone:</strong></td>
                              <td> <?php echo $customer_user_data['tech_phone'] ?></td>
                            </tr>
                           <?php if($customer_user_data['account_type'] == 'Business'){ ?> 
                            <tr>
                              <td><strong>Company Name:</strong></td>
                              <td><?php echo $customer_user_data['comp_name'] ?></td>
                            </tr>
                            <tr>
                              <td><strong>Company Phone:</strong></td>
                              <td><?php echo $customer_user_data['comp_phone'] ?></td>
                            </tr>
                            <tr>
                              <td><strong>Company Website:</strong></td>
                              <td><?php echo $customer_user_data['comp_website'] ?></td>
                            </tr>
                             <tr>
                              <td><strong>Company Address:</strong></td>
                              <td><?php echo $customer_user_data['comp_add'] ?></td>
                            </tr>
                            <tr>
                              <td><strong>Technical Person Name:</strong></td>
                              <td> <?php echo $customer_user_data['tech_name'] ?></td>
                            </tr>
                            <tr>
                              <td><strong>Technical Person Phone :</strong></td>
                              <td><?php echo $customer_user_data['tech_phone'] ?></td>
                            </tr>
                              <?php } ?>
                              
                               <tr>
                              <td><strong>City Name:</strong></td>
                              <td><?php echo $customer_user_data['city_name'] ?></td>
                            </tr>
                            <tr>
                              <td><strong>State Name:</strong></td>
                              <td><?php echo $customer_user_data['state_name'] ?></td>
                            </tr>
                            <tr>
                              <td><strong>Country Name :</strong></td>
                              <td><?php echo $customer_user_data['country'] ?></td>
                            </tr>
                            
                             <tr>
                              <td><strong>Last SignIn Date:</strong></td>
                              <td><?php echo date('d, M Y', strtotime($customer_user_data['last_signin_date'])) ;?></td>
                            </tr>
                            <tr>
                              <td><strong>Status:</strong></td>
                              <td><?php echo ($customer_user_data['status'] == 1) ? 'Active' : 'InActive' ;?></td>
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
        </div>
        <div class="col-md-6 col-lg-6">
         <div class="col-md-12">
          <div class="panel">
            <div class="panel-heading">
              <div class="panel-title"> <span class="glyphicon glyphicon-list-alt"></span>Document list</div>
              <div class="pull-right"> 	
              </div>
              <div id="test-popup" class="white-popup mfp-hide">
                  Popup content
              </div>
            </div>
            <div class="panel-body">
              <div class="table-responsive">
              <?php if($user_documents !=""){ ?>
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Title</th>
                      <th>Document</th>
                      <th>Description</th>
                    </tr>
                  </thead>
                  <tbody>
                
                </tbody>
                </table>
              <?php }else{echo "<span style='color:red;font-weight:bold;'>No Documents Found...!</span>";} ?>  
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
                      <a class="anchor_style" href="<?php echo base_url()?>customers/manage-customers/view-customer/<?php echo $customer_id;?>/0" title="Click to View Project Details">
					  <?php } ?>
					  <?php echo $total_projects ; ?></a></td>
                      
                      
                      <td>
                      <?php if($open_projects>0){ ?>
                      <a class="anchor_style" href="<?php echo base_url()?>customers/manage-customers/view-customer/<?php echo $customer_id;?>/1" title="Click to View Project Details">
					  <?php } ?>
					  <?php echo $open_projects ; ?></a></td>
                      
                      <td>
                       <?php if($cancel_projects>0){ ?>
                       <a class="anchor_style" href="<?php echo base_url()?>customers/manage-customers/view-customer/<?php echo $customer_id;?>/2" title="Click to View Project Details">
					  <?php } ?>
					  <?php echo $cancel_projects ; ?></a></td>
                      
                      
                       <td>
                      <?php if($closed_projects>0){ ?>
                      <a class="anchor_style" href="<?php echo base_url()?>customers/manage-customers/view-customer/<?php echo $customer_id;?>/3" title="Click to View Project Details">
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
     <!-- <div class="row" style="min-height:250px;">&nbsp;</div> -->
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
              <?php if($projects_count>0){ ?>
              
                <table class="table table-striped table-bordered table-hover" id="manage_customer_projects">
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
                      <td><a class="anchor_style" href="<?php echo base_url()?>projects/manage-projects/project-detail/<?php echo $projects_arr[$i]['id'] ?>" target="_blank" ><?php echo stripslashes($projects_arr[$i]['project_title']) ; ?></a></td>
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
                
              <?php }else{echo "<span style='color:red; font-weight:bold;'>No Projects Found...!</span>";} ?>  
              </div>
            </div>
          </div>
       </div>
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

    
<script type="application/javascript">
	$('#manage_customer_projects').dataTable({
		"aoColumnDefs": [{ 'bSortable': false, 'aTargets': [-1,-4,-5] }],
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

</body>
</html>
