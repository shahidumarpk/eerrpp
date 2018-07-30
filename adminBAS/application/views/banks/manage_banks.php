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
    <div class="container" style="min-height:1300px;">
      
      <div class="row">
        <div class="col-md-12">
          <div class="row">
            <div class="col-md-12">
              <div class="panel panel-visible">
                <div class="panel-heading">
                
                 <div class="row">
                        <div class="col-md-4">
                           <div class="panel-title hidden-xs"> <span class="glyphicon glyphicon-list"></span>Manage Banks</div>
                        </div>
                        
                        <div class="col-md-6 pull-right" align="right">
                        
                       <!-- <a href="< ?php echo SURL?>assets/voucher_sample/petty_bank_voucher.html"  id="popup" >Download Voucher</a> |-->
                        <?php 
                                        if($ALLOW_pages_add== 1){ 
					    ?>
                          <a href="<?php echo SURL?>banks/manage-banks/add-bank"><span class="glyphicons glyphicons-circle_plus"></span> Add New</a>                        <?php  }  ?>
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
					
					if($banks_count > 0){
                ?>
                
                  <table class="table table-striped table-bordered table-hover" id="manage_banks">
                    <thead>
                      <tr>
                      
                        <th width="125" class="hidden-xs">Bank Name</th>
                        
                        <th width="125" class="hidden-xs">Branch</th>
                        <th width="125" class="hidden-xs">City</th>
                        <th width="125" class="hidden-xs">Account Title  </th>
                        <th width="124" class="hidden-xs">AC Number</th>
                         <th width="125" class="hidden-xs">Balance</th> 
                        <th width="90" class="hidden-xs">Status</th>
                        <th width="144" class="text-center hidden-xs">Actions</th>
                        
                      </tr>
                    </thead>
                    <tbody>
                    </tbody>
                  </table>
                  
                   </table>
                   <table class="table table-striped table-bordered table-hover">
                    <thead>
                      <tr>
                        <th width="125" class="text-right hidden-xs"  >Total Balance</th>
                        <th width="125" class="hidden-xs"><?php echo $total_balance; ?></th>
                       
                      </tr>
                    </thead>
                    <tbody>
                    </tbody>
                  </table>
                  
                  <?php 
					}else{
				?>
                <div class="alert alert-danger alert-dismissable">
                	<strong>No Bank Found</strong> </div>                	
                <?php		
					}//end if($slider_images_count > 0)
				  ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="clearfix"></div>
      
        <div class="modal fade" id="mailmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">View Record</h4>
      </div>
      <div class="modal-body">
       
         
           <div class="form-group">
           <label for="subject">Title</label>
                        <div>Shiow</div>
                      </div>
                      
                      <div class="form-group">
           <label for="subject">Phone</label>
                        <div>Shiow</div>
                      </div>
                      
                      <div class="form-group">
           <label for="subject">address</label>
                        <div>Shiow</div>
                      </div>
                      
                      <div class="form-group">
           <label for="subject">City</label>
                        <div>Shiow</div>
                      </div>
                      
                      <div class="form-group">
           <label for="subject">Status</label>
                        <div>Shiow</div>
                      </div>
                      
                     
                    
                    
          
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
         
       
        
     
      </div>
        
    </div>
  </div>
</div>
      
      
      
      
      
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
	$('#manage_banks').dataTable({
		
		"bProcessing": true,
		"bServerSide": true,
		"sServerMethod": "POST",
		"sAjaxSource": "<?php echo base_url()?>banks/manage-banks/process-banks-grid",
		"aoColumnDefs": [{ 'bSortable': false, 'aTargets': [ -1,-2] }],
		"aaSorting": [],
		"iDisplayLength": 50,
		"bPaginate": true,
		"bLengthChange": true,
		"bFilter": true,
		"aLengthMenu": [[25, 50, 75,100], [25, 50, 75,100]],
		"aoColumns": [
		{ "bSearchable": true,  },
		{ "bSearchable": false, },
		{ "bSearchable": false, },
		{ "bSearchable": false, },
		{ "bSearchable": true, },
		{ "bSearchable": false, },
		{ "bSearchable": false, },
		{ "bSearchable": false,  },
		
		],
		"oLanguage": {
           "sProcessing": "Searching Please Wait..."
         }
		
	}).fnSetFilteringDelay(700);	
</script>

<script type="application/javascript">
	$('#manage_slider_images').dataTable({
		"aoColumnDefs": [{ 'bSortable': false, 'aTargets': [ -1,-4,-5,-6 ] }],
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
$('#popup').click(function(event) {
    event.preventDefault();
    window.open($(this).attr("href"), "popupWindow", "width=730,height=600,scrollbars=no");
   
});

</script>
</body>
</html>
