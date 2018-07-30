<?php 
$session_post_data = $this->session->userdata('add-page-data');
?>
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

                    <div class="row">
                        <div class="col-md-10">
                            <div class="panel-title"> <span class="glyphicon glyphicon-font"></span>Manage PayRoll  </div>
                        </div>
                        <div class="col-md-2" align="right">
                        <?php 
                                        if($ALLOW_pages_add== 1){ 
					    ?>
                          <a href="<?php echo SURL?>payroll/manage-payrolls/add-payroll-entry/fine"><span class="glyphicons glyphicons-circle_plus"></span> Add New</a>                        <?php  }  ?>
                        </div>
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
					
					if($payroll_get_count > 0){
                ?>
             
                  <table class="table table-striped table-bordered table-hover" id="manage_payroll_pages">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>User</th>
                         <th>Date</th>
                        <th>Amount</th>
  <th class="hidden-xs">Transaction Status</th>
                      <th >Transaction Type</th>
                   

                        
                        <th class="text-center">Actions</th>
                      </tr>
                    </thead>
    
                   <tbody>
                  
                    <?php 
							for($i=0;$i<$payroll_get_count;$i++){
					?>
                            <tr>
                                <td><span class="xedit"><?php echo ($i+1) ?></span></td>
                          
                            <td><span class="xedit"><?php echo stripslashes($payroll_get_arr[$i]
							['first_name']).' '.($payroll_get_arr[$i]
							['last_name']) ?>
                                </span></td>
                                 <td><span class="xedit"><?php echo stripslashes($payroll_get_arr[$i]['transaction_date'])?></span></td>
                                 
                                <td><span class="xedit"><?php echo stripslashes($payroll_get_arr[$i]['amount'])?></span></td>
                                
                               
             <td class="hidden-xs hidden-sm"><?php echo ($payroll_get_arr[$i]['transaction_status'])?></span></td>
                                   
             <td class="hidden-xs hidden-sm"><?php echo ($payroll_get_arr[$i]['transaction_type'])?></span></td>
                                    
                                                    
                                
                                <td class="text-center">
                                	<div class="btn-group">
									<?php 
                                        if($ALLOW_pages_edit == 1){ 
									?>
											<a href="<?php echo SURL?>payroll/manage-payrolls/edit-payroll_entry/<?php echo $payroll_get_arr[$i]['transaction_id']?>" type="button" class="btn btn-info btn-gradient" title="Edit PayRoll Entry"> <span class="glyphicons glyphicons-edit"></span> </a>                                    
                                    <?php		
										}//end if 
                                        if($ALLOW_pages_delete == 1){ 
									?>
											<a href="<?php echo SURL?>payroll/manage-payrolls/delete_payroll_entry/<?php echo $payroll_get_arr[$i]['transaction_id']?>" type="button" class="btn btn-danger btn-gradient" onClick="return confirm('Are you sure you want to delete?')" title="Delete PayRoll Entry"> <span class="glyphicons glyphicons-remove"></span> </a>                                    
                                    <?php	
										}//end if
                                    ?>
                                  </div>
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
                	<strong>No PayRolls Found</strong> </div>                	
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
	$('#manage_payroll_pages').dataTable({
		"aoColumnDefs": [{ 'bSortable': false, 'aTargets': [-1,-4,-6] }],
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
