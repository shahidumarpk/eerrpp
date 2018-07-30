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
        <div class="col-md-12" style="min-height:1100px;">
          <div class="row">
            <div class="col-md-12">
              <div class="panel panel-visible">
                <div class="panel-heading">
                
                 <div class="row">
                        <div class="col-md-10">
                           <div class="panel-title"> <span class="glyphicon glyphicon-list-alt"></span>Tasks Detail Report</div>
                        </div>
                        <div class="col-md-2" align="right">
                        
                        </div>
                    </div> 
                </div>
                
              <form class="cmxform" id="edit_admin_profile_frm" method="POST" action="<?php echo SURL?>admin/manage-user/task-detail-report" enctype="multipart/form-data"> 
              
               
               <div class="row">
               	<div class="col-md-6">
                	<div class="row">
                 	<div class="col-md-5 col-sm-4">
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
               
                        
                 </div>
                 
                  
                        
                </div>
                <div class="col-md-6">
                	&nbsp;
                </div>
               </div>
               <div class="clearfix"></div><br>
               <div class="row">
                 	<div class="col-md-12 col-sm-12">
                          
					<?php
                    if($admin_roles_count>0){ 
                    for($c=0; $c < $admin_roles_count ; $c++){ ?>
                   &nbsp;&nbsp; <input class="checkbox"  type="checkbox" name="admin_role_id[]" id="admin_role" value="<?php  echo $admin_roles_arr[$c]['id']; ?>" style="margin-top: 5px;"  />  <?php  echo $admin_roles_arr[$c]['role_title']; ?>
                            
                    <?php }} ?>
                          
                    </div>
               
                 </div>
               <div class="clearfix"></div>  
               
               
               <div class="row">
                    <div class="col-md-10" >
                    </div>
                    <div class="col-md-2" >
                        <div class="form-group" >
                            <input class="submit btn btn-blue" type="submit" name="search_sbt" id="search_sbt" value="Search" style="margin-top: 5px;"  />
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
					
					if($task_detail_report_count> 0){
                ?>
               
                  <table class="table table-striped table-bordered table-hover" id="manage_cms_pages" width="100%">
                    <thead>
                      <tr>
                        <th width="3%">#</th>
                        <th width="8%" class="hidden-xs">User Name</th>
                        <th width="11%" class="hidden-xs">Admin Role</th>
                        <th width="9%" class="hidden-xs hidden-sm" >Branch Name</th>
                        <th width="30%" class="hidden-xs hidden-sm" >Task</th>
                         <th width="17%" class="hidden-xs hidden-sm" >Project Name</th>
                         <th width="7%" class="hidden-xs hidden-sm">Team</th>
                         <th width="15%" class="hidden-xs hidden-sm">Last Close Task</th>
                        
                       
                      </tr>
                    </thead>
                    <tbody>
                    <?php 
					
							for($i=0;$i< $task_detail_report_count;$i++){
					?>
                            <tr>
                                <td><span class="xedit"><?php echo ($i+1);?></span></td>
                                
                                <td class="hidden-xs"><a class="anchor_style" href="<?php echo base_url()?>admin/manage-user/user-detail/<?php echo $task_detail_report_arr[$i]['id'] ?>" title="Click to User Detail page" ><?php echo  stripcslashes(strip_tags($task_detail_report_arr[$i]['display_name']));?></a></td>
                                
                          <td class="hidden-xs"><?php echo $task_detail_report_arr[$i]['role_title'] ?></td>
                                
                                
                                <td class="hidden-xs hidden-sm"><?php echo stripcslashes($task_detail_report_arr[$i]['branch_name']) ;?></td>
                                <td class="hidden-xs hidden-sm">
								
								<?php if($task_detail_report_arr[$i]['task_title'] !=""){ ?>
								<a class="anchor_style" href="<?php echo base_url()?>projects/manage-projects/assign-task-detail/<?php echo $task_detail_report_arr[$i]['task_id'] ?>" title="Click to User Detail page" >	
						       <?php echo $task_detail_report_arr[$i]['task_title']; ?> </a>
                               
							   
							   
							   <?php }else{echo "-";} ;?></td> 
                               
                               
                               <td class="hidden-xs hidden-sm">
								
								<?php if($task_detail_report_arr[$i]['project_name'] !=""){ ?>
								<a class="anchor_style" href="<?php echo base_url()?>projects/manage-projects/project-detail/<?php echo $task_detail_report_arr[$i]['project_id'] ?>" title="Click to User Detail page" >	
						       <?php echo $task_detail_report_arr[$i]['project_name']; ?> </a>
                               
							   <?php }else{echo "-";} ;?></td> 
                                
                                <td class="hidden-xs hidden-sm"><?php 
								
								for($j=0; $j <=count($task_detail_report_arr[$i]['team']); $j++){
								
								  echo "<b>".$task_detail_report_arr[$i]['team'][$j]."</b><br>";
								
								}
								
								?></td> 
                                
                                  <td class="hidden-xs">
								  <?php if($task_detail_report_arr[$i]['closed_task'] !="") { ?>
								  <?php echo $task_detail_report_arr[$i]['closed_task'] ?><br>
                                  <?php echo "(".date('d, M Y h:i:s a', strtotime($task_detail_report_arr[$i]['task_close_date'])).")"; 
								  }else{ echo "-";}
								  
								  ?>
                                  
                                  </td>
                       
                 
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
$(document).ready(function() { $("#branch_id").select2(); });
</script>

<script type="application/javascript">
	$('#manage_cms_pages').dataTable({
		"aoColumnDefs": [{ 'bSortable': false, 'aTargets': [ -1,-2,3,4 ] }],
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
