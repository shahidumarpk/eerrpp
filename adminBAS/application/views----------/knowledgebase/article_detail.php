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
<header class="navbar navbar-fixed-top"><?php echo $INC_top_header; ?> </header>
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
        <div class="col-md-12 col-lg-12">
          <div class="row">
            <div class="col-md-12">
              <div class="panel profile-panel">
                <div class="panel-heading panel-visible">
                  <div class="panel-title"> <span class="glyphicon glyphicon-user"></span> Article Detail</div>
                
                  <div class="panel-btns pull-right margin-left">
                    <div class="btn-group">
                      
                    </div>
                  </div>
                </div>
                <div class="panel-body">
                  <div class="row">
                    
                    <div class="col-xs-12">
                    <table class="table table-striped">
                          <tbody>
                            <tr>
                              <td><strong>Title:</strong></td>
                              <td><?php echo $article_arr['title']; ?></td>
                            </tr>
                           
                            <tr>
                              <td><strong>Designation:</strong></td>
                              <td> <?php echo $article_arr['role_title']; ?></td>
                            </tr>
                            <tr>
                              <td><strong>Created Date:</strong></td>
                              <td> <?php echo date('d, M Y h:i:s a', strtotime($article_arr['created_date']));?></td>
                            </tr>
                            <tr>
                              <td><strong>Status:</strong></td>
                              <td> <?php  if($article_arr['status']==1){ ?>Active<?php } ?>
                              <?php  if($article_arr['status']==0){ ?>InActive<?php } ?></td>
                            </tr>
                             
                          </tbody>
                        </table>
                       <p><strong>Description:</strong><br><br></p> 
                       <p><?php echo $article_arr['description'];?></p>

                    </div>
                  </div>
                  <div class="clearfix"></div>
                  
                   <?php if($article_arr['attachments'] != ""){ ?>    
                 <div class="well" style="height: 160px;margin-bottom: -25px;">
                 <div class="panel-body alerts-panel">
                     <div class="row">
                     <div class="col-md-2">
                            <div class="thumbnail" style="width: 87px;height: 85px;">
                
                                <a class="anchor_style" href="<?php echo MURL?>assets/article_attachments/<?php echo $article_arr['created_by']."/".$article_arr['attachments']; ?>" target="_blank" download> <img src="<?php echo SURL?>assets/img/zip.png" style="height: 62px;" ></a>
                           
                              
                              <div class="caption">
                                <p><?php echo $deals_result_arr[$i]['detail']; ?></p>
                                <div class="clearfix"></div>
                                <!-- <p><a href="<?php echo SURL?>projects/manage-projects/delete-deal-files/<?php echo $deal_id;?>/<?php echo $deals_result_arr[$i]['id']; ?>" class="btn btn-danger pull-right" role="button">Delete</a></p> -->
                                 <div class="clearfix"></div>
                              </div>
                            </div>
                     <div class="clearfix"></div>
              </div>
              
        </div>
                 </div>
                  </div>
                  <?php  } ?>
                  
                </div>
                
              </div>
            </div>
          </div>
        </div>
        
      </div>
      <div class="clearfix">&nbsp;</div>
      
     <!-- <div class="row" style="min-height:250px;">&nbsp;</div> -->
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
	$('#manage_user_projects').dataTable({
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
