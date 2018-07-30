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
                           <div class="panel-title"> <span class="glyphicon glyphicon-list-alt"></span>Closed Tasks Report</div>
                        </div>
                        <div class="col-md-2" align="right">
                        
                        </div>
                    </div> 
                </div>
               
                <div class="panel-body padding-bottom-none">
                
                <form class="cmxform" id="edit_admin_profile_frm" method="POST" action="<?php echo SURL?>projects/manage-projects/closed-tasks-report" enctype="multipart/form-data">     
               
           
             <div class="row form-group ">
             
             <div class="col-md-2">
               <label class="hidden-sm " style="margin-right: -106px;">Search By Date :</label>
             </div>
                            
                              <div class="col-xs-2 hidden-sm" id="fromdate">
                                   <div class="input-group"><input type="text" readonly style="cursor:pointer;" name="search_date" id="search_date" class="form-control" required value="<?php echo $search_date; ?>" /><span class="input-group-addon"><span id="targetto" onclick="create_date('fromdate')" class="glyphicon glyphicon-calendar" style="cursor:pointer;"></span></span>
	                        </div>
                            </div>
            
         
            
                <div class="form-group col-sm-1" align="left" style="margin-left: 51px;">
                        <input class="submit btn btn-blue" type="submit" name="search_sbt" id="search_sbt" value="Search" />
                </div>    
             
             </div>         
 </form>

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
					
					if(count($task_report_arr) > 0){
                ?>
               
                  <table class="table table-striped table-bordered table-hover" id="manage_cms_pages">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th class="hidden-xs">Task Name</th>
                        <th class="hidden-xs">Project Name</th>
                        <th class="hidden-xs hidden-sm" >Start Date</th>
                        <th class="hidden-xs hidden-sm" >End Date</th>
                        <th class="hidden-xs hidden-sm">Started By</th>
                        <th class="hidden-xs hidden-sm">Started Date</th>
                       
                      </tr>
                    </thead>
                    <tbody>
                    <?php 
					
							for($i=0;$i<count($task_report_arr);$i++){
					?>
                            <tr>
                                <td><span class="xedit"><?php echo ($i+1);?></span></td>
                                
                                <td class="hidden-xs"><a class="anchor_style" href="<?php echo base_url()?>projects/manage-projects/assign-task-detail/<?php echo $task_report_arr[$i]['id'] ?>" title="Click to Task Detail page" ><?php echo  stripcslashes(strip_tags($task_report_arr[$i]['title']));?></a></td>
                          <td class="hidden-xs"><a class="anchor_style" href="<?php echo base_url()?>projects/manage-projects/project-detail/<?php echo $task_report_arr[$i]['project_id'] ?>" title="Click to Project Detail page" target="_blank"> <?php echo stripcslashes(strip_tags($task_report_arr[$i]['project_name']));?></a></td>
                                
                                
                                <td class="hidden-xs hidden-sm"><?php echo date('d, M Y h:i:s a', strtotime($task_report_arr[$i]['start_date'])) ;?></td>
                                <td class="hidden-xs hidden-sm"><?php echo date('d, M Y h:i:s a', strtotime($task_report_arr[$i]['end_date'])) ;?></td> 
                   <td class="hidden-xs hidden-sm"><a class="anchor_style" href="<?php echo base_url()?>admin/manage-user/user-detail/<?php echo $task_report_arr[$i]['user_id'] ?>" title="Click to Task Detail page" target="_blank" ><?php echo $task_report_arr[$i]['user_name'];?></a> </td>     
                   <td class="hidden-xs hidden-sm"><strong><?php echo date('d, M Y h:i:s a', strtotime($task_report_arr[$i]['task_started_date']));?></strong> </td>     
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
