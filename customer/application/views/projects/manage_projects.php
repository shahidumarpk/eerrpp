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
      <div class="row">
        <div class="col-md-12" style="min-height:900px;">
          <div class="row">
            <div class="col-md-12">
              <div class="panel panel-visible">
                <div class="panel-heading">
                  <div class="panel-title"> <span class="glyphicon glyphicon-list-alt"></span> Manage Projects</div>
                  
                </div>
                <div class="panel-body padding-bottom-none">

				<?php
				
				// echo $check_employee= $this->session->userdata('check_employee');
			
				
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
                
                  <table class="table table-striped table-bordered table-hover" id="manage_cms_pages" width="100%">
                    <thead>
                      <tr>
                        <th width="5%" class="hidden-xs">#</th>
                        <th width="37%">Project Title</th>
                        <th width="24%" class="hidden-xs">Customer Name</th>
                        <th width="22%" class="hidden-xs">Project Amount</th>
                        <th width="22%" class="hidden-xs">Tasks</th>
                       <?php if($this->session->userdata('check_employee')==0){  ?>
                        <th width="22%" class="hidden-xs">Assign</th>
                       <?php } ?>
                      
                      </tr>
                    </thead>
                    <tbody>
                    <?php 
					
							for($i=0;$i<$projects_count;$i++){
					?>
                            <tr>
                                <td class="hidden-xs"><span class="xedit"><?php echo ($i+1) ?></span></td>
                                <td ><strong><a href="<?php echo base_url()?>projects/manage-projects/project-detail/<?php echo $projects_arr[$i]['id'] ?>" ><?php echo  $projects_arr[$i]['project_title'];?></a></strong></td>
                                <td class="hidden-xs"><?php echo $projects_arr[$i]['first_name']." ".$projects_arr[$i]['last_name'];?></td>
                                <td class="hidden-xs"><?php echo $projects_arr[$i]['project_amount'];?></td>
                                 <td class="hidden-xs"><strong><a href="<?php echo base_url()?>projects/manage-projects/manage-project-task/<?php echo $projects_arr[$i]['id'] ?>" >View Tasks</a></strong></td>
                                
                               <?php if($this->session->userdata('check_employee')==0){  ?>
                                  <td class="hidden-xs"><b><a href="<?php echo base_url()?>projects/manage-projects/project-assign/<?php echo $projects_arr[$i]['id'] ?>" >Assign Team</a></b></td>
                             <?php  } ?>  
                               
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
          
          
          <div class="row">
            <div class="col-md-12">
              <div class="panel panel-visible">
                <div class="panel-heading">
                  <div class="panel-title"> <span class="glyphicon glyphicon-list-alt"></span>Client Feedback(s)</div>
                </div>
                <div class="panel-body padding-bottom-none">

				<?php 
					if($projects_portfolio_count > 0){
                ?>
                
                  <table class="table table-striped table-bordered table-hover" id="manage_project_portfolio" width="100%">
                    <thead>
                      <tr>
                        <th width="5%" class="hidden-xs">#</th>
                        <th width="60%">Project Title</th>
                        <th width="15%" class="hidden-xs">Customer Name</th>
                        <th width="15%" class="text-center hidden-xs">Closed Date</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php 
					
							for($i=0;$i<$projects_portfolio_count;$i++){ ?>
                            
                            
								
								
                            <tr>
                                <td class="hidden-xs"><span class="xedit"><?php echo ($i+1) ?></span></td>
                                <td ><strong><a href="<?php if($projects_portfolio_arr[$i]['live_url'] !=""){ echo $projects_portfolio_arr[$i]['live_url'];}else{echo "#";} ?>" <?php if($projects_portfolio_arr[$i]['live_url'] !=""){?> target="_blank" <?php } ?> ><?php echo  $projects_portfolio_arr[$i]['project_title'];?></a></strong><div id="jRate<?php echo $projects_portfolio_arr[$i]['id']?>" style="height:33px;width: 200px;"></div>
								 <?php if($projects_portfolio_arr[$i]['feedback'] !=""){ ?>
                                 <span class="label btn-orange2 margin-right-sm">Feedback</span>
                                 <span style="font-style: italic;"><?php echo '" '.$projects_portfolio_arr[$i]['feedback'].' "'; }?></span>
                                
                                
                                </td>
                                <td class="hidden-xs"><strong><?php echo $projects_portfolio_arr[$i]['first_name']." ".$projects_portfolio_arr[$i]['last_name'];?></strong></td>
                                
                                <td class="hidden-xs text-center"><?php echo date('d, M Y', strtotime($projects_portfolio_arr[$i]['end_date']));?></td>
                            </tr>
                 
                 <script type="text/javascript">
				
						$(function () {
						
							var that = this;
							jQuery("#jRate<?php echo $projects_portfolio_arr[$i]['id']?>").jRate({
								rating: <?php echo $projects_portfolio_arr[$i]['project_rating']?>,
								strokeColor: 'black',
								width: 23,
								height: 20,
								readOnly: true
								
							});
							
						});
				</script> 
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

<script type="application/javascript">
	$('#manage_project_portfolio').dataTable({
		"aoColumnDefs": [{ 'bSortable': false, 'aTargets': [ 1,-3 ] }],
		"aaSorting": [],
		"oLanguage": { "oPaginate": {"sPrevious": "", "sNext": ""} },
		"iDisplayLength": 50,
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
