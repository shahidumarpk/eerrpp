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
            <div class="col-md-12">
              <div class="panel panel-visible">
                <div class="panel-heading">
                  <div class="panel-title"> <span class="glyphicon glyphicon-list-alt"></span>Financial Statistics</div>
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
					
					if($projects_count > 0){
                ?>
                
                  <table class="table table-striped table-bordered table-hover" id="manage_cms_pages">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th class="hidden-xs hidden-sm">Project Title</th>
                        <th class="visible-lg">Start Date</th>
                        <th class="visible-lg">End Date</th>
                        <th class="visible-lg">Project Amount</th>
                     
                      </tr>
                    </thead>
                    <tbody>
                    <?php 
					
							for($i=0;$i<$projects_count;$i++){
								
								
					?>
                            <tr>
                                <td><span class="xedit"><?php echo ($i+1) ?></span></td>
                                <td class="hidden-xs hidden-sm"><a href="<?php echo base_url()?>projects/manage-projects/project-detail/<?php echo $projects_arr[$i]['id'] ?>" ><?php echo  stripcslashes(strip_tags($projects_arr[$i]['project_title']));?></a></td>
                                <td class="hidden-xs hidden-sm"><?php echo date('F j, Y', strtotime($projects_arr[$i]['start_date'])); ?></td>
                                <td class="hidden-xs hidden-sm"><?php echo  date('F j, Y', strtotime($projects_arr[$i]['end_date']));?></td>
                                
                               <td class="hidden-xs hidden-sm"><?php echo stripcslashes(strip_tags($projects_arr[$i]['project_amount']));?></td>
                               
                            </tr>
                            
                    <?php
						$grand_total += $projects_arr[$i]['project_amount'] ;  
								
						}//end for
					?>
                    
                      <tr>
                        <td></td>
                        <td class="hidden-xs hidden-sm"> </td>
                        <td class="hidden-xs hidden-sm"></td>
                        <td class="hidden-xs hidden-sm"><strong>Page Total</strong></td>
                        <td class="hidden-xs hidden-sm"><strong><?php echo $page_total; ?></strong></td>
                               
                      </tr>
                  
                    </tbody>
                  </table>
                  
                  
                  <table width="359" border="1" style="width: 100%;
height: 34px; border: rgb(194, 192, 191);">
  <tr>
    <td width="791" align="right"><b>Grand Total</b> &nbsp;&nbsp;</td>
    <td width="286"><b>&nbsp;&nbsp;<?php echo $grand_total; ?></b></td>
  </tr>
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
<script type="application/javascript">
	$('#manage_cms_pages').dataTable({
		"aoColumnDefs": [{ 'bSortable': false, 'aTargets': [ -1,-4,-5 ] }],
		"aaSorting": [],
		"oLanguage": { "oPaginate": {"sPrevious": "", "sNext": ""} },
		"iDisplayLength": 5,
		"bPaginate": true,
		"bLengthChange": true,
		"bFilter": true,
		"aLengthMenu": [[5,25, 50, 75,100], [5,25, 50, 75,100]],
		"sDom": 'T<"panel-menu dt-panelmenu"lfr><"clearfix">tip',
		"oTableTools": {
			"sSwfPath": "<?php echo VENDOR ?>plugins/datatables/extras/TableTools/media/swf/copy_csv_xls_pdf.swf"
		}
		
	});	
</script>
</body>
</html>
