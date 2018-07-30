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
                            <div class="panel-title hidden-xs"> <span class="glyphicon glyphicon-list"></span>Manage Categories</div>
                        </div>
                        <div class="col-md-2" align="right">
                        <?php 
                                        if($ALLOW_pages_add== 1){ 
					    ?>
                          <a href="<?php echo SURL?>category/manage-category/add-new-category"><span class="glyphicons glyphicons-circle_plus"></span> Add New</a>                        <?php  }  ?>
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
					
					if($category_list_count > 0){
                ?>
                
                  <table class="table table-striped table-bordered table-hover" id="manage_all_categories">
                    <thead>
                      <tr>
                        <th>Category Name</th>
                        <th class="hidden-xs hidden-sm">Status</th>
                        <th class="hidden-xs">Display Order</th>
                        <th class="visible-lg">Options</th>
                        
                      </tr>
                    </thead>
                    <tbody>
                    </tbody>
                  </table>
                  
                  <?php 
					}else{
				?>
                        <div class="alert alert-danger alert-dismissable">
                        <strong>No Categories Found</strong> </div>                	
                <?php		
					}//end if($category_list_count > 0)
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
	$('#manage_all_categories').dataTable({
		
		"bProcessing": true,
		"bServerSide": true,
		"sServerMethod": "POST",
		"sAjaxSource": "<?php echo base_url()?>category/manage-category/process-category-grid",
		"aoColumnDefs": [{ 'bSortable': false, 'aTargets': [ -1,-2] }],
		"aaSorting": [],
		"iDisplayLength": 50,
		"bPaginate": true,
		"bLengthChange": true,
		"bFilter": true,
		"aLengthMenu": [[25, 50, 75,100], [25, 50, 75,100]],
		"aoColumns": [
		{ "bSearchable": true, "sWidth": "65%"  },
		{ "bSearchable": false, "sWidth": "10%"},
		{ "bSearchable": false, "sWidth": "10%" },
		{ "bSearchable": false, "sWidth": "15%"}
		],
		"oLanguage": {
           "sProcessing": "Searching Please Wait..."
         }
		
	}).fnSetFilteringDelay(700);	
</script>
</body>
</html>
