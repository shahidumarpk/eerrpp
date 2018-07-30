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
        <div class="col-md-12" style="min-height:900px;">
          <div class="row">
            <div class="col-md-12">
              <div class="panel panel-visible">
                <div class="panel-heading">
                  <div class="panel-title"> <span class="glyphicon glyphicon-list-alt"></span> Manage Sub Users</div>
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
					
					if($customers_count > 0){
                ?>
                
                  <table class="table table-striped table-bordered table-hover" id="manage_cms_pages" width="100%">
                    <thead>
                      <tr>
                        <th  class="hidden-xs">#</th>
                        <th >User Name</th>
                        <th  class="hidden-xs">Email</th>
                        <th  class="hidden-xs">Phone Number</th>
                        <th  class="hidden-xs">Created Date</th>
                        <th  class="text-center hidden-xs">Options</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php 
					
							for($i=0;$i<$customers_count;$i++){
					?>
                            <tr>
                                <td class="hidden-xs"><span class="xedit"><?php echo ($i+1) ?></span></td>
                                <td ><strong><?php echo  $customers_arr[$i]['first_name']." ".$customers_arr[$i]['last_name'];?></strong></td>
                                <td class="hidden-xs"><?php echo $customers_arr[$i]['email_address'];?></td>
                                <td class="hidden-xs"><?php echo $customers_arr[$i]['phone'];?></td>
                                 <td class="hidden-xs"><?php echo date('d, M Y', strtotime($customers_arr[$i]['created_date']));?></td>
                                <td class="hidden-xs text-center">
                                
                                 <a href="<?php echo base_url()?>employee/manage-employee/edit-employee/<?php echo $customers_arr[$i]['id'] ?>" type="button" class="btn btn-info btn-gradient" title="Click to Edit"> <span class="glyphicons glyphicons-edit"></span></a> 
                                  
                                 <a href="<?php echo base_url()?>employee/manage-employee/delete-employee/<?php echo $customers_arr[$i]['id'] ?>" onClick="return confirm('Are you sure you want to delete?')" type="button" class="btn btn-danger btn-gradient" title="Click to Delete"> <span class="glyphicons glyphicons-remove"></span> </a> 
                                 
                            
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
                	<strong>No Employee(s) Found</strong> </div>                	
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
