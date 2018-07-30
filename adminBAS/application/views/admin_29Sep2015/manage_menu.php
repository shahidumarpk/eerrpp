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
                            <div class="panel-title"> <span class="glyphicon glyphicon-font"></span>Manage MENU  Pages</div>
                        </div>
                        <div class="col-md-2" align="right">
                        <?php 
                                        if($ALLOW_pages_add== 1){ 
					    ?>
                          <a href="<?php echo SURL?>admin/manage-menu/add-menu"><span class="glyphicons glyphicons-circle_plus"></span> Add Menu Item</a>                        <?php  }  ?>
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
					
					if($menu_result_count > 0){
                ?>
                
                  <table class="table table-striped table-bordered table-hover" id="manage_menu_pages">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Menu Title</th>
                        <th>Parent_Iid</th>
  <th class="hidden-xs">Show in Nav</th>
                      <th >Set as Default</th>
                      <th>Icon class name </th>
                       <th >Url link</th>
                       <th >Display order</th>                      
<th>Status</th>                     

                        
                        <th class="text-center">Actions</th>
                      </tr>
                    </thead>
    
                   <tbody>
                    <?php 
							for($i=0;$i<$menu_result_count;$i++){
					?>
                            <tr>
                                <td><span class="xedit"><?php echo ($i+1) ?></span></td>
                          
                            <td><span class="xedit"><?php echo stripslashes($menu_result_arr[$i]['menu_title']) ?>
                                </span></td>
                                <td><span class="xedit"><?php echo stripslashes($menu_result_arr[$i]['parent_id'])?></span></td>
                                       <td><span class="xedit"><?php echo stripslashes($menu_result_arr[$i]['show_in_nav'])?></span></td>
                    <td><span class="xedit"><?php echo stripslashes($menu_result_arr[$i]['set_as_default'])?></span></td>                   
                                        <td><span class="xedit"><?php echo stripslashes($menu_result_arr[$i]['icon_class_name']) ?>
                                </span></td>
                   <td><span class="xedit"><?php echo stripslashes($menu_result_arr[$i]['url_link']) ?>
                                </span></td>

                                <td><span class="xedit"><?php echo stripslashes($menu_result_arr[$i]['display_order']) ?>
                                </span></td>
                                <td class="hidden-xs hidden-sm"><?php echo ($menu_result_arr[$i]['status'] ==1) ? '<span class="label btn-success" title="Active">Active</span>' : '<span class="label btn-danger" title="InActive">InActive</span>' ?></td>
                            
                                                   
                                <td class="text-center">
                                	<div class="btn-group">
									<?php 
                                        if($ALLOW_pages_edit == 1){ 
										
									?>
                                   
											<a href="<?php echo  SURL?>admin/manage-menu/edit-menu/<?php echo $menu_result_arr[$i]['id']?>" type="button" class="btn btn-info btn-gradient" title="Edit Menu"> <span class="glyphicons glyphicons-edit"></span> </a>                                    
                                    <?php		
										}//end if 
                                        if($ALLOW_pages_delete == 1){ 
									?>
											<a href="<?php echo SURL?>admin/manage-menu/delete-menu/<?php echo $menu_result_arr[$i]['id']?>" type="button" class="btn btn-danger btn-gradient" onClick="return confirm('Are you sure you want to delete?')" title="Delete Menu Item"> <span class="glyphicons glyphicons-remove"></span> </a>                                    
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
                	<strong>No MENU Page(s) Found</strong> </div>                	
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
	$('#manage_menu_pages').dataTable({
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
