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
                 
                        <div class="col-md-8">
                           <div class="panel-title"> <span class="glyphicon glyphicon-list-alt"></span> My Tasks</div>
                        </div>
                        
                            <form class="cmxform" id="edit_admin_profile_frm" method="POST" action="<?php echo SURL?>projects/manage-projects/manage-project-task/<?php echo $project_id;?>" enctype="multipart/form-data"> 
                        <div class="col-md-4" style="margin-top: -6px;">
                        
                          <select id="search_status" name="search_status" style="width:100%; margin:10px 0 0 5px; "  onChange="get_tasks_ajax(this.value)" >
                           <option value="" >Search by Status</option>
                               <option value="0">New</option>
                               <option value="1" >Start</option>
                               <option value="2" >Hold</option>
                               <option value="3" >Closed</option>
                               <option value="4" >Resume</option>
                          </select>
                            
                      </div>
                      
                     </form>
                        
                    </div>      
                    
                  
                </div>
                
                
               
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
                
                   <span id="ajax_response">
                  
                  <table class="table table-striped table-bordered table-hover" id="manage_cms_pages">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th class="">Task Title</th>
                        <th class="">Start Date</th>
                        <th class="">End Date</th>
                        <th class="">Total Time</th>
                        <th class="">Project Name</th>
                        <th class="">Status</th>
                     
                      </tr>
                    </thead>
                    <tbody>
                    <?php 
					
							for($i=0;$i<$assign_task_count;$i++){
					?>
                            <tr>
                                <td><span class="xedit"><?php echo ($i+1) ?></span></td>
                                
                                <td class="hidden-xs "><strong><?php echo  stripcslashes(strip_tags($assign_task_arr[$i]['title']));?></strong></td>
                                
                                <td class="hidden-xs "><?php echo date("d, M Y h:i:s a", strtotime($assign_task_arr[$i]['start_date'])); ?></td>
                                <td class="hidden-xs "><?php echo date("d, M Y h:i:s a", strtotime($assign_task_arr[$i]['end_date']));  ?></td>
                                 <td class="hidden-xs "><?php echo $assign_task_arr[$i]['total_time'];  ?></td>
                                
                               <td class="hidden-xs "><strong><a class="anchor_style" href="<?php echo base_url()?>projects/manage-projects/project-detail/<?php echo $assign_task_arr[$i]['project_id'] ?>" title="Click to Project Detail" target="_blank"><?php echo stripcslashes(strip_tags($assign_task_arr[$i]['project_title']));  ?></a></strong></td>
                             
                               <td class="hidden-xs ">
							   <?php if($assign_task_arr[$i]['status']=='0'){ echo "<span class='label btn-success'>New</span>";} 
							   if($assign_task_arr[$i]['status']=='1'){ echo "<span class='label btn-success'>Start</span>";} 
							   if($assign_task_arr[$i]['status']=='2'){ echo "<span class='label btn-success'>Hold</span>";} 
							   if($assign_task_arr[$i]['status']=='3'){ echo "<span class='label btn-success'>Closed</span>";}
							   if($assign_task_arr[$i]['status']=='4'){ echo "<span class='label btn-success'>Resume</span>";}?>
                               </td> 
                               
                              
                      
                            </tr>
                    <?php			
						}//end for
					?>
                    </tbody>
                  </table>
                    </span>
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

<script>

function get_tasks_ajax(status){
 //document.getElementById('state_response').innerHTML = "<img class='loading' src='<?php echo IMG ; ?>select2-spinner.gif' alt='loading...' />";
 var request_url = "<?php echo SURL ; ?>projects/manage-projects/get-status-ajax/<?php echo $project_id;?>/"+status;
 jQuery.post(
  request_url, {flag : true}, function(responseText){
  
 
  jQuery("#ajax_response").html(responseText);
  
 
  }, "html"
 );
}//end check_nic_exist


</script>

</body>
</html>
