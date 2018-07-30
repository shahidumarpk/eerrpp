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
        <div class="col-md-12">
          <div class="row">
            <div class="col-md-12" style="min-height:1300px;">
              <div class="panel panel-visible">
                <div class="panel-heading">
                
                 <div class="row">
                        <div class="col-md-10">
                           <div class="panel-title"> <span class="glyphicon glyphicon-list-alt"></span> My Tasks</div>
                        </div>
                        <div class="col-md-2" align="right">
                        <?php 
                                        if($ALLOW_pages_add== 1){ 
					    ?>
                          <a href="<?php echo SURL?>projects/manage-projects/add-task"><span class="glyphicons glyphicons-circle_plus"></span> Add New</a>                        <?php  }  ?>
                        </div>
                    </div>      
                    
                  
                </div>
                
                <form class="cmxform" id="edit_admin_profile_frm" method="POST" action="<?php echo SURL?>projects/manage-projects/manage-task" enctype="multipart/form-data"> 
                <div class="row">
                
                        <div class="col-md-3 col-sm-5">
                           <select id="search_status" name="search_status" style="width:100%; margin:10px 0 0 5px; " >
                           <option value="" >Search by Status</option>
                               <option value="0">New</option>
                               <option value="1" >Start</option>
                               <option value="2" >Hold</option>
                               <option value="3" >Closed</option>
                               <option value="4" >Resume</option>
                          </select>
                    </div>
                    
                        
              
                        <div class="col-md-2">
                        <div class="form-group" align="left" >
                        <input class="submit btn btn-blue" type="submit" name="search_sbt" id="search_sbt" value="Search" style="margin-top: 5px;"  title="Click to search" />
                        </div>
                                          
                        </div>
               </div>
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
					
					if($assign_task_count > 0){
                ?>
                
                  <table class="table table-striped table-bordered table-hover" id="manage_cms_pages">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th class="">Task Title</th>
                        <th class="">Start Date</th>
                        <th class="">End Date</th>
                        <th class="">Project Name</th>
                        <th class="">Status</th>
                        
                        <?php 
                            
					     if($ALLOW_user_edit == 1 or $ALLOW_user_delete == 1){ 
					   ?>  
                        <th class="text-center hidden-xs">Options</th>
                       <?php } ?> 
                      </tr>
                    </thead>
                    <tbody>
                    <?php 
					
							for($i=0;$i<$assign_task_count;$i++){
					?>
                            <tr>
                                <td><span class="xedit"><?php echo ($i+1) ?></span></td>
                                
                                <td class="hidden-xs "><a class="anchor_style" href="<?php echo base_url()?>projects/manage-projects/assign-task-detail/<?php echo $assign_task_arr[$i]['id'] ?>" title="Click to Task Detail"><?php echo  stripcslashes(strip_tags($assign_task_arr[$i]['title']));?></a>
                                
							 <?php  if($assign_task_arr[$i]['rating_status']==1){ ?><span class="label btn-green"><?php echo $assign_task_arr[$i]['rating']; ?></span>  <?php  } ?>
                             <?php  if($assign_task_arr[$i]['status']==3 && $assign_task_arr[$i]['rating_status']==0 ){ ?><span class="label btn-red">?</span>  <?php  } ?>
                                
                                </td>
                                
                                <td class="hidden-xs "><?php echo date("d, M Y h:i:s a", strtotime($assign_task_arr[$i]['start_date'])); ?></td>
                                <td class="hidden-xs "><?php echo date("d, M Y h:i:s a", strtotime($assign_task_arr[$i]['end_date']));  ?></td>
                                
                               <td class="hidden-xs "><a class="anchor_style" href="<?php echo base_url()?>projects/manage-projects/project-detail/<?php echo $assign_task_arr[$i]['project_id'] ?>" title="Click to Project Detail" target="_blank"><?php echo stripcslashes(strip_tags($assign_task_arr[$i]['project_title']));  ?></a></td>
                             
                               <td class="hidden-xs "><?php if($assign_task_arr[$i]['status']=='0'){ echo "New";} if($assign_task_arr[$i]['status']=='1'){ echo "Start";} if($assign_task_arr[$i]['status']=='2'){ echo "Hold";} if($assign_task_arr[$i]['status']=='3'){ echo "Closed";}if($assign_task_arr[$i]['status']=='4'){ echo "Resume";}?></td> 
                               
                               
                                
                                
                       <?php 
                            
					     if($ALLOW_user_edit == 1 or $ALLOW_user_delete == 1){ 
					   ?>   
                                <td class="hidden-xs text-center">
                                	<?php 
                                    if($ALLOW_user_edit == 1){ 
								?>
                                        <a href="<?php echo base_url()?>projects/manage-projects/edit-assign-task/<?php echo $assign_task_arr[$i]['id'] ?>" type="button" class="btn btn-info btn-gradient"> <span class="glyphicons glyphicons-edit" title="Edit Task"></span></a>                                
                                <?php	
									}//end if
									
									if($ALLOW_user_delete == 1){ 
								?>
                                	<a href="<?php echo base_url()?>projects/manage-projects/delete-assign-task/<?php echo $assign_task_arr[$i]['id'] ?>" onClick="return confirm('Are you sure you want to delete?')" type="button" class="btn btn-danger btn-gradient" title="Delete Task"> <span class="glyphicons glyphicons-remove"></span> </a>
                                <?php	
									}//end if

                                 ?></td>
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
                <div class="alert alert-danger alert-dismissable" >
                	<strong>No Task(s) Found</strong> </div>                	
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
