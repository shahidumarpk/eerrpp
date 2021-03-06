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
                            <div class="panel-title"> <span class="glyphicon glyphicon-font"></span>Manage CMS Pages</div>
                        </div>
                        <div class="col-md-2" align="right">
                        <?php 
                                        if($ALLOW_pages_add== 1){ 
					    ?>
                          <a href="<?php echo SURL?>cms/manage-pages/add-page"><span class="glyphicons glyphicons-circle_plus"></span> Add New</a>                        <?php  }  ?>
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
					
					if($cms_pages_count > 0){
                ?>
                
                  <table class="table table-striped table-bordered table-hover" id="manage_cms_pages">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Page Title</th>
                        <th>Short Description</th>
                        <th class="hidden-xs hidden-sm">SEO Link</th>
                        <th class="hidden-xs hidden-sm">Status</th>
                        <th class="visible-lg">Created Date</th>
                        
                        <th class="text-center">Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php 
							for($i=0;$i<$cms_pages_count;$i++){
					?>
                            <tr>
                                <td><span class="xedit"><?php echo ($i+1) ?></span></td>
                                <td><span class="xedit"><?php echo stripslashes($cms_pages_arr[$i]['page_title']) ?></span></td>
                                <td><?php echo substr(stripslashes(strip_tags($cms_pages_arr[$i]['page_short_desc'])),0,100).'...'?></td>
                                <td class="hidden-xs hidden-sm"><?php echo stripslashes($cms_pages_arr[$i]['seo_url_name']) ?></td>
                                <td class="hidden-xs hidden-sm"><?php echo ($cms_pages_arr[$i]['status'] == 1) ? '<span class="label btn-success" title="Active">Active</span>' : '<span class="label btn-danger" title="InActive">InActive</span>' ?></td>
                                <td class="hidden-xs hidden-sm"><?php echo date('d, M Y', strtotime($cms_pages_arr[$i]['created_date'])) ?></td>
                                
                                <td class="text-center">
                                	<div class="btn-group">
									<?php 
                                        if($ALLOW_pages_edit == 1){ 
									?>
											<a href="<?php echo SURL?>cms/manage-pages/edit-page/<?php echo $cms_pages_arr[$i]['id']?>" type="button" class="btn btn-info btn-gradient" title="Edit cms page"> <span class="glyphicons glyphicons-edit"></span> </a>                                    
                                    <?php		
										}//end if 
                                        if($ALLOW_pages_delete == 1){ 
									?>
											<a href="<?php echo SURL?>cms/manage-pages/delete-page/<?php echo $cms_pages_arr[$i]['id']?>" type="button" class="btn btn-danger btn-gradient" onClick="return confirm('Are you sure you want to delete?')" title="Delete cms page"> <span class="glyphicons glyphicons-remove"></span> </a>                                    
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
                	<strong>No CMS Page(s) Found</strong> </div>                	
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
		"aoColumnDefs": [{ 'bSortable': false, 'aTargets': [ -1,-4,-5, -7 ] }],
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
