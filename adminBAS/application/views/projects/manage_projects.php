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
      
      <div class="row">
        <div class="col-md-12" style="min-height:1200px;">
          <div class="row">
            <div class="col-md-12">
              <div class="panel panel-visible">
                <div class="panel-heading">
                
                 <div class="row">
                        <div class="col-md-10">
                           <div class="panel-title"> <span class="glyphicon glyphicon-list-alt"></span> Manage Projects</div>
                        </div>
                        <div class="col-md-2" align="right">
                        <?php 
                                        if($ALLOW_pages_add== 1){ 
					    ?>
                          <a href="<?php echo SURL?>projects/manage-projects/add-project"><span class="glyphicons glyphicons-circle_plus"></span> Add New</a>                        <?php  }  ?>
                        </div>
                    </div> 
                </div>
               
             
             
              <form class="cmxform" id="edit_admin_profile_frm" method="POST" action="<?php echo SURL?>projects/manage-projects" enctype="multipart/form-data"> 
              
              
               <?php 
                 if($ALLOW_user_search_status== 1 || $ALLOW_user_search_branch== 1 ){ 
			     ?>   
               <div class="row">
               	<div class="col-md-12">
                	<div class="row">
               <?php 
                 if($ALLOW_user_search_status== 1){ 
			    ?>
                
                		<div class="col-md-2 col-sm-4">
                           <select id="search_status" name="search_status" style="width:100%; margin:10px 0 0 5px; " >
                           <option value="">Search By Status</option>
                           <option value="0">New</option>
                           <option value="1" >InProgress</option>
                            <option value="4" >Hold</option>
                           <option value="2" >Cancel</option>
                           <option value="3" >Closed</option>
                          
                          </select>
                        </div>
                      
                        
               <?php } ?>
               
                <?php 
                 if($ALLOW_user_search_status== 1 && $ALLOW_user_search_branch== 1 ){ 
			     ?>
                    
                 		<div class="col-md-1 col-sm-1"> 
                        	<div style="font-weight:bold; margin-top:18px;text-align: center;">OR</div>
                        </div>
                  <?php } ?>               
                        
                  <?php 
                 if($ALLOW_user_search_branch== 1){ 
			     ?>   
                 
                 	<div class="col-md-2 col-sm-4">
                           <select id="branch_id" name="branch_id" style="width:100%; margin:10px 0 0 5px; " >
                            <option value="" selected>Search By Branch</option>
                                <?php
								if($branches_count>0){ 
								for($c=0; $c < $branches_count ; $c++){ ?>
										<option value="<?php echo $branches_arr[$c]['id'] ?>"  <?php
										  if($branches_arr[$c]['id']!=0){
										 if($branch_id==$branches_arr[$c]['id']){ ?> selected <?php  }} ?>><?php echo $branches_arr[$c]['branch_name'];?></option>
								<?php }} ?>
                          </select>
                    </div>
                 	
                        
                 <?php } ?>       
                        
                 <div class="col-md-2" style="margin-top: 14px;">
                          
					
                   &nbsp;&nbsp; <input class="checkbox"  type="checkbox" name="important_projects" id="important_projects" value="important_projects" style="margin-top: 5px;"  />Star Project
                        
                  </div>
                  
                   <div class="col-md-2" style="margin-top: 14px;">
                          
					
                   &nbsp;&nbsp; <input class="checkbox"  type="checkbox" name="is_awarded" id="is_awarded" value="important_projects" style="margin-top: 5px;"  />Awarded
                        
                  </div>
                           
                        <div class="col-md-1">
                        <div class="form-group" style="margin-top:6px;">
                        <input class="submit btn btn-blue" type="submit" name="search_sbt" id="search_sbt" value="Search" style="margin-top: 5px;"  />
                        </div>
                                          
                        </div>
                 </div>
                        
                </div>
                
               </div>
             <?php } ?>  
              </form>
             
                <div class="panel-body padding-bottom-none">

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
					
					if($projects_count > 0){
                ?>
               
                  <table class="table table-striped table-bordered table-hover" id="manage_cms_pages">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th class="hidden-xs">Project Title</th>
                        <th class="hidden-xs">Customer Name</th>
                        <th class="hidden-xs hidden-sm">Start Date</th>
                        <th class="hidden-xs hidden-sm" >End Date</th>
                        
                      <?php 
                            
					     if($ALLOW_user_assign_team == 1){ 
					  ?>
                      <th class="hidden-xs">Assign Team</th>
					  <?php  }
					  
					     if($ALLOW_user_assign_task == 1){ 
					   ?>
                       <th class="hidden-xs">Assign Task</th>
					   <?php  } ?>
                       <th class="hidden-xs">Branch Name</th>
                        <th class="hidden-xs hidden-sm">Status</th>
                       
                       <?php 
                            
					     if($ALLOW_user_edit == 1 or $ALLOW_user_delete == 1 or $ALLOW_user_action == 1 or $ALLOW_workspace == 1 ){ 
					   ?> 
                        <th class="text-center hidden-xs">Options</th>
                        <?php } ?>
                      </tr>
                    </thead>
                    <tbody>
                    <?php 
					
							for($i=0;$i<$projects_count;$i++){
					?>
                            <tr>
            <td><span class="xedit"><?php echo ($i+1);?></span></td>
            <td class="hidden-xs">
            <a class="anchor_style" href="<?php echo base_url()?>projects/manage-projects/project-detail/<?php echo $projects_arr[$i]['id'] ?>" ><?php echo  stripcslashes(strip_tags($projects_arr[$i]['project_title']));?></a>
           <?php if($projects_arr[$i]['is_important']==1){?><span class="label btn-red">Star</span><?php } ?>
           <?php  if($projects_arr[$i]['is_awarded']==1){ ?><span class="label btn-success">Awarded</span>  <?php  } ?>
           <?php  if($projects_arr[$i]['payment_due']==1){ ?> <span class="label btn-alert">Payment due</span>  <?php  } ?>
           
                               
                              
                               <?php 
							 
					                if($ALLOW_user_project_label == 1 && $projects_arr[$i]['project_label'] !=""  ){ 
					           ?>
                                      <br><br><span class="label btn-orange2 "><?php echo $projects_arr[$i]['project_label']; ?></span>
                                      
                              <?php  } ?> 
                                </td>
                                <td class="hidden-xs"><a class="anchor_style" href="<?php echo base_url()?>customers/manage-customers/view-customer/<?php echo $projects_arr[$i]['customer_id'] ?>" title="Click to customer Detail page" target="_blank"> <?php echo stripcslashes(strip_tags($projects_arr[$i]['first_name']." ".$projects_arr[$i]['last_name']));?></a></td>
                                <td class="hidden-xs hidden-sm"><?php echo date('d, M Y', strtotime($projects_arr[$i]['start_date'])) ;?></td>
                                <td class="hidden-xs hidden-sm"><?php echo date('d, M Y', strtotime($projects_arr[$i]['end_date'])) ;?></td>
                                
                      <?php 
					     if($ALLOW_user_assign_team == 1){ 
					  ?>
                                
                                <td class="hidden-xs"><a class="anchor_style" href="<?php echo base_url()?>projects/manage-projects/project-assign/<?php echo $projects_arr[$i]['id'] ?>" >Assign</a></b></td>
					  <?php } 
                            
					     if($ALLOW_user_assign_task == 1){ 
					  ?>     
                                <td class="hidden-xs"><a class="anchor_style" href="<?php echo base_url()?>projects/manage-projects/assign-task/<?php echo $projects_arr[$i]['id'] ?>" >Assign </a></td> 
					  <?php  }?>
                   <td class="hidden-xs">
                   <?php echo $projects_arr[$i]['branch_name'];?>
                   </td>             
                   <td class="hidden-xs hidden-sm">
				   <?php if($projects_arr[$i]['status']==0) { echo "New";}?>
                   <?php if($projects_arr[$i]['status']==1) { echo "InProgress";}?>
                   <?php if($projects_arr[$i]['status']==2) { echo "Cancel";}?>
                   <?php if($projects_arr[$i]['status']==3) { echo "Closed";}?>
                    <?php if($projects_arr[$i]['status']==4) { echo "Hold";}?>
                   </td>   
                              
                       <?php 
                            
					     if($ALLOW_user_edit == 1 or $ALLOW_user_delete == 1 or $ALLOW_user_action == 1 or $ALLOW_workspace == 1 ){ 
					   ?>  
                               <td class="hidden-xs text-center">
                                <?php 
                            
							        if($ALLOW_user_edit == 1){ 
								?>
                                        <a href="<?php echo base_url()?>projects/manage-projects/edit-project/<?php echo $projects_arr[$i]['id'] ?>" type="button" class="btn btn-info btn-gradient" title="Click to Edit"> <span class="glyphicons glyphicons-edit"></span></a>                                
                                <?php	
									}//end if
									
									if($ALLOW_user_delete == 1){ 
								?>
                                	<a href="<?php echo base_url()?>projects/manage-projects/delete-project/<?php echo $projects_arr[$i]['id'] ?>" onClick="return confirm('Are you sure you want to delete?')" type="button" class="btn btn-danger btn-gradient" title="Click to Delete"> <span class="glyphicons glyphicons-remove"></span> </a>
                                <?php	
									}//end if
                                if($ALLOW_user_action == 1){ 
                                 ?>
                                 
                                 <a href="<?php echo base_url()?>projects/manage-projects/project-action/<?php echo $projects_arr[$i]['id'] ?>" type="button" class="btn btn-info btn-gradient" style="background-color: #129C17;border-color: #129C17;" title="Click for Project Action"> <span class="glyphicons glyphicons-new_window"></span></a>
                                   <?php	
									}//end if 
									
									if($ALLOW_project_workspace == 1){ 
									?>
                                    
                                    <a href="<?php echo base_url()?>projects/manage-projects/project_workspace/<?php echo $projects_arr[$i]['id'] ?>" type="button" class="btn btn-info btn-gradient" style="background-color: #129C17;border-color: #129C17;" title="Click to Workspace"><span class="glyphicons glyphicons-folder_open"></span></a>
                                    
                                    <?php	
									}//end if 
									
									if($ALLOW_project_important== 1){ 
									?>
                                    
                                   <?php if($projects_arr[$i]['is_important']!=1){ ?>
                                    <a href="<?php echo base_url()?>projects/manage-projects/important-project/<?php echo $projects_arr[$i]['id'] ?>" type="button" class="btn btn-info btn-gradient"  title="Click for important" onClick="return confirm('Are you sure you want to make it star?')"><span class="glyphicons glyphicons-star"></span> </a>
                                    
                                    <?php }else{ ?>
                                    
                                    <a href="<?php echo base_url()?>projects/manage-projects/unimportant-project/<?php echo $projects_arr[$i]['id'] ?>" type="button" class="btn btn-danger btn-gradient"  title="Click for Unimportant" onClick="return confirm('Are you sure you want to remove star?')"><span class="glyphicons glyphicons-star"></span> </a>
                                    
                                  <?php }
								  
									}
								  
								  if($ALLOW_payment_due== 1){ 
									?>
                                    
                                   <?php if($projects_arr[$i]['payment_due']!=1){ ?>
                                    <a href="<?php echo base_url()?>projects/manage-projects/payment-due/<?php echo $projects_arr[$i]['id'] ?>" type="button" class="btn btn-info btn-gradient"  title="Click for Payment Due" onClick="return confirm('Are you sure you want to make payment due?')"><span class="glyphicons glyphicons-usd"></span> </a>
                                    
                                    <?php }else{ ?>
                                    
                                    <a href="<?php echo base_url()?>projects/manage-projects/payment-recieve/<?php echo $projects_arr[$i]['id'] ?>" type="button" class="btn btn-danger btn-gradient"  title="Click for Payment recieve" onClick="return confirm('Are you sure you want to recieve payment?')"><span class="glyphicons glyphicons-usd"></span> </a>
                                    
                                  <?php } 
								  
								  } ?>  
                                    
                                 </td>
                              <?php } ?>   
                            </tr>
                    <?php			
						}//end for
					?>
                    </tbody>
                  </table>
                  
                  <?php 
					}else{
				?>
                <div class="alert alert-danger alert-dismissable">
                	<strong>No Project(s) Found</strong> </div>                	
                <?php		
					}//end if($cms_pages_count > 0)
				  ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="clearfix"></div>
      <div class="row" style="min-height:250px;">&nbsp;</div>
    </div>
  </section>
  <!-- End: Content --> 
  
</div>
<!-- End: Main --> 
<!-- Start: Footer -->
<footer> <?php echo $INC_footer;?> </footer>
<!-- End: Footer --> 
<?php echo $INC_header_script_footer;?>

<link href="<?php echo CSS ;?>select2.css" rel="stylesheet"/>
<script src="<?php echo JS ; ?>select2.js"></script>
<script>
$(document).ready(function() { $("#search_status").select2(); });
</script>
<script>
$(document).ready(function() { $("#branch_id").select2(); });
</script>

<script type="application/javascript">
	$('#manage_cms_pages').dataTable({
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
</body>
</html>
